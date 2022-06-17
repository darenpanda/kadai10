<?php
class QueryArticle extends connect{
  private $article;
  
  const THUMBS_WIDTH = 200; // サムネイルの幅

  public function __construct(){
    parent::__construct();
  }

  public function setArticle(Article $article){
    $this->article = $article;
  }

// ===== ここから追加。↓画像保存処理をここに移動予定 =====
  // 画像アップロード
  private function saveFile($old_name){
  
  // ===== ここまで追加 ===
// ===== ↓saveFile()メソッド内に追加 ここから↓ =====
$new_name = date('YmdHis').mt_rand();

if ($type = exif_imagetype($old_name)){
  // 元画像の縦横サイズを取得
  list($width, $height) = getimagesize($old_name);

  // サムネイルの比率を求める
  $rate = self::THUMBS_WIDTH / $width;  // 比率
  $thumbs_height = $rate * $height;

  // キャンバス作成
  $canvas = imagecreatetruecolor(self::THUMBS_WIDTH, $thumbs_height);

  switch($type){
    case IMAGETYPE_JPEG:
      $new_name .= '.jpg';

      // サムネイルを保存
      $image = imagecreatefromjpeg($old_name);
      imagecopyresampled($canvas, $image, 0, 0, 0, 0, self::THUMBS_WIDTH, $thumbs_height, $width, $height);
      imagejpeg($canvas, __DIR__.'/../album/thumbs-'.$new_name);
      break;

    case IMAGETYPE_GIF:
      $new_name .= '.gif';

      // サムネイルを保存
      $image = imagecreatefromgif($old_name);
      imagecopyresampled($canvas, $image, 0, 0, 0, 0, self::THUMBS_WIDTH, $thumbs_height, $width, $height);
      imagegif($canvas, __DIR__.'/../album/thumbs-'.$new_name);
      break;

    case IMAGETYPE_PNG:
      $new_name .= '.png';

      // サムネイルを保存
      $image = imagecreatefrompng($old_name);
      imagecopyresampled($canvas, $image, 0, 0, 0, 0, self::THUMBS_WIDTH, $thumbs_height, $width, $height);
      imagepng($canvas, __DIR__.'/../album/thumbs-'.$new_name);
      break;

    default:
      // JPEG・GIF・PNG以外の画像なら処理しない
      imagedestroy($canvas);
      return null;
  }
  imagedestroy($canvas);
  imagedestroy($image);

  // 元サイズの画像をアップロード
  move_uploaded_file($old_name, __DIR__.'/../album/'.$new_name);

  // 保存したファイル名を返す
  return $new_name;

} else {
  // 画像以外なら処理しない
  return null;
}
// ===== ↑saveFile()メソッド内に追加 ここまで↑ =====
}



  
  public function save(){
    // ===== ↓上書き・新規作成で共通の項目はif文の外に移動 ここから↓ =====
        // bindParam用
        $title = $this->article->getTitle();
        $body = $this->article->getBody();
        $filename = $this->article->getFilename();
            // ===== ↑共通項目の移動 ここまで↑ =====
    
        if ($this->article->getId()){
          // IDがあるときは上書き
    // 元々ここにあった$title, $bodyなどの共通項目の代入はif文外に移動する
          $id = $this->article->getId();

// ===== ↓ここから追加↓ =====
      // 新しいファイルがアップロードされたとき
      // if ($file = $this->article->getFile()){
      //   $this->deleteFile();
      //           // ファイルが既にある場合、古いファイルを削除する
      //   if ($this->article->getFilename()){
      //     unlink(__DIR__.'/../album/thumbs-'.$this->article->getFilename());
      //     unlink(__DIR__.'/../album/'.$this->article->getFilename());
      //   }   
      //   // 新しいファイルのアップロード
      //   $this->article->setFilename($this->saveFile($file['tmp_name']));
      //   $filename = $this->article->getFilename();
      // }
    
      // 新しいファイルがアップロードされたとき
      if ($file = $this->article->getFile()){
        // ファイルが既にある場合、古いファイルを削除する
        $this->deleteFile();
        // 新しいファイルのアップロード
        $this->article->setFilename($this->saveFile($file['tmp_name']));
        $filename = $this->article->getFilename();
      }  
        
      // ===== ↑ここまで追加↑ ===
      $stmt = $this->dbh->prepare("UPDATE articles
      SET title=:title, body=:body, filename=:filename, updated_at=NOW()
      WHERE id=:id");

$stmt->bindParam(':title', $title, PDO::PARAM_STR);
$stmt->bindParam(':body', $body, PDO::PARAM_STR);
// ===== ↓bindParamに:filenameを追加 =====
$stmt->bindParam(':filename', $filename, PDO::PARAM_STR);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
        
        } else {
          // IDがなければ新規作成
      // IDがなければ新規作成
      // ===== ここから変更。↑これ以前にあった画像保存処理は全てsaveFile()に移動予定 =====
      if ($file = $this->article->getFile()){
        $this->article->setFilename($this->saveFile($file['tmp_name']));
        $filename = $this->article->getFilename();
      }


    // ===== ↓画像保存処理 ここから追加↓ =====
          if ($file = $this->article->getFile()){
            $old_name = $file['tmp_name'];
            $new_name = date('YmdHis').mt_rand();
    
            // アップロード可否を決める変数。デフォルトはアップロード不可
            $is_upload = false;
    
            // 画像の種類を取得する
            $type = exif_imagetype($old_name);
            // ファイルの種類が画像だったとき、種類によって拡張子を変更
            switch ($type){
              case IMAGETYPE_JPEG:
                $new_name .= '.jpg';
                $is_upload = true;
                break;
              case IMAGETYPE_GIF:
                $new_name .= '.gif';
                $is_upload = true;
                break;
              case IMAGETYPE_PNG:
                $new_name .= '.png';
                $is_upload = true;
                break;
            }   
    
            if ($is_upload && move_uploaded_file($old_name, __DIR__.'/../album/'.$new_name)){
              $this->article->setFilename($new_name);
              $filename = $this->article->getFilename();
            }   
          }
    // ===== ↑画像保存処理 ここまで追加↑ =====
    
    // 元々ここにあった$title, $bodyなどの共通項目の代入はif文外に移動する
    
          $stmt = $this->dbh->prepare("INSERT INTO articles (title, body, filename, created_at, updated_at)
                    VALUES (:title, :body, :filename, NOW(), NOW())");
          $stmt->bindParam(':title', $title, PDO::PARAM_STR);
          $stmt->bindParam(':body', $body, PDO::PARAM_STR);
          $stmt->bindParam(':filename', $filename, PDO::PARAM_STR);
          $stmt->execute();
        }
      }
   // ===== ↓ここから追加↓ =====
   private function deleteFile(){
    if ($this->article->getFilename()){
      unlink(__DIR__.'/../album/thumbs-'.$this->article->getFilename());
      unlink(__DIR__.'/../album/'.$this->article->getFilename());
    }
  }
  // ===== ↑ここまで追加↑ =====
  
    // ===== ↓ここから追加↓：save()メソッドの下にdelete()を追加
 public function delete(){
  if ($this->article->getId()){
    $this->deleteFile();
    $id = $this->article->getId();
    $stmt = $this->dbh->prepare("UPDATE articles SET is_delete=1 WHERE id=:id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
  }   
}
// ===== ↑ここまで追加↑ =====


    public function find($id){
                $stmt = $this->dbh->prepare("SELECT * FROM articles WHERE id=:id AND is_delete=0");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $article = null;
        if ($result){
          $article = new Article();
          $article->setId($result['id']);
          $article->setTitle($result['title']);
          $article->setBody($result['body']);
          $article->setFilename($result['filename']);   
          $article->setCreatedAt($result['created_at']);
          $article->setUpdatedAt($result['updated_at']);
        }
        return $article;
      }


    public function findAll(){
            $stmt = $this->dbh->prepare("SELECT * FROM articles WHERE is_delete=0 ORDER BY created_at DESC");

        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $articles = array();
        foreach ($results as $result){
          $article = new Article();
          $article->setId($result['id']);
          $article->setTitle($result['title']);
          $article->setBody($result['body']);
          $article->setFilename($result['filename']);
          $article->setCreatedAt($result['created_at']);
          $article->setUpdatedAt($result['updated_at']);
          $articles[] = $article;
        }
        return $articles;
      }   


}