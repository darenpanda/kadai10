-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2022-06-10 02:58:58
-- サーバのバージョン： 10.4.24-MariaDB
-- PHP のバージョン: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `blog`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `filename` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `articles`
--

INSERT INTO `articles` (`id`, `title`, `body`, `category_id`, `is_delete`, `filename`, `created_at`, `updated_at`) VALUES
(11, 'バナナブレッド（自家製酵母）編集', '一番人気商品。ｘｘｘｘｘｘ\r\nおすすめポイントは、、、', NULL, 0, NULL, '2022-05-21 10:51:15', '2022-06-04 07:23:21'),
(12, '天然酵母の竹炭チョコベーグル', '玉木宏主演の『極主夫道 ザ・シネマ』コラボ商品、6月3日全国の109シネマで販売\r\nもちもち食感、竹炭の外観が特色', NULL, 0, NULL, '2022-05-21 10:55:06', '2022-05-21 10:55:50'),
(13, 'ランチセット', 'サンドイッチとお好きなベーグルのセット　600円', NULL, 1, NULL, '2022-05-21 10:57:54', '2022-05-21 10:57:54'),
(14, 'テスト', 'ｄｄｄｄ', NULL, 1, NULL, '2022-05-21 13:12:55', '2022-05-21 13:12:55'),
(15, 'ｓ', 'ｄ', NULL, 1, NULL, '2022-05-21 13:13:45', '2022-05-21 13:13:45'),
(16, 'kkuuuuu', 'kk,,,,,,,,,,,,,,,', NULL, 1, NULL, '2022-05-21 14:11:46', '2022-05-21 14:12:01'),
(17, 'test', 'テストです', NULL, 1, NULL, '2022-06-04 07:51:40', '2022-06-04 07:51:40'),
(18, '画像登録のテストです', '画像登録します', NULL, 1, NULL, '2022-06-04 07:53:53', '2022-06-04 07:53:53'),
(19, 'もう一度テスト', '属性変えてみた', NULL, 1, NULL, '2022-06-04 07:56:41', '2022-06-04 07:56:41'),
(20, '画像テスト', 'どうだ？', NULL, 1, NULL, '2022-06-04 08:31:59', '2022-06-04 08:31:59'),
(21, 'データベースを修正後', 'どうだ？', NULL, 1, NULL, '2022-06-04 08:52:28', '2022-06-04 08:52:28'),
(22, '画像', '画像', NULL, 1, NULL, '2022-06-06 07:12:03', '2022-06-06 07:12:03'),
(23, 'ｆｆ', 'ｄｄ', NULL, 1, NULL, '2022-06-06 07:25:19', '2022-06-06 07:25:19'),
(24, 'テスト', 'ｒｒｒｒ', NULL, 0, '202206100105171253633265.png', '2022-06-10 07:14:32', '2022-06-10 08:05:27'),
(25, '画像テスト', '画像テスト', NULL, 0, '202206100156171306783454.jpg', '2022-06-10 07:14:54', '2022-06-10 08:56:17'),
(26, '画像サムネイルのテスト', 'サムネイルのテスト本文', NULL, 0, '20220610015541734615771.jpg', '2022-06-10 07:40:50', '2022-06-10 08:55:41'),
(27, 'サムネイルのテスト２編集', 'サムネイルのテスト本文２編集', NULL, 1, '20220610004229167398589.jpg', '2022-06-10 07:42:29', '2022-06-10 07:50:53'),
(28, 'サムネイルのテスト３編集', 'サムネイルテスト本文３編集本文', NULL, 1, '20220610010411534559394.jpg', '2022-06-10 07:43:18', '2022-06-10 08:04:11');

-- --------------------------------------------------------

--
-- テーブルの構造 `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `name`, `password`) VALUES
(2, 'Yamada', '$2y$10$P9XbAHNw3jnPbqNf9G78ou5puYuxwzdoJAe9xZa5cabf9kks41AM.');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- テーブルの AUTO_INCREMENT `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
