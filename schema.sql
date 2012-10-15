-- phpMyAdmin SQL Dump
-- version 3.5.3
-- http://www.phpmyadmin.net
--
-- ホスト: localhost
-- 生成日時: 2012 年 10 月 16 日 01:45
-- サーバのバージョン: 5.1.61
-- PHP のバージョン: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- データベース: `xvs`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `registered` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `registered` (`registered`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `user_history`
--

CREATE TABLE IF NOT EXISTS `user_history` (
  `user_id` int(10) unsigned NOT NULL,
  `xvideos_id` int(10) unsigned NOT NULL,
  `svd_ratio` decimal(10,9) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`xvideos_id`),
  KEY `xvideos_id` (`xvideos_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `xvideos`
--

CREATE TABLE IF NOT EXISTS `xvideos` (
  `id` int(10) unsigned NOT NULL,
  `uri` tinytext NOT NULL,
  `title` tinytext NOT NULL,
  `duration` int(11) NOT NULL,
  `thumb_uri` tinytext NOT NULL,
  `embed_tag` text NOT NULL,
  `category` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `xvideos_tag`
--

CREATE TABLE IF NOT EXISTS `xvideos_tag` (
  `xvideos_id` int(10) unsigned NOT NULL,
  `tag` varchar(32) NOT NULL,
  `is_usertag` int(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`xvideos_id`,`tag`),
  KEY `visible` (`is_usertag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `user_history`
--
ALTER TABLE `user_history`
  ADD CONSTRAINT `user_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_history_ibfk_2` FOREIGN KEY (`xvideos_id`) REFERENCES `xvideos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- テーブルの制約 `xvideos_tag`
--
ALTER TABLE `xvideos_tag`
  ADD CONSTRAINT `xvideos_tag_ibfk_1` FOREIGN KEY (`xvideos_id`) REFERENCES `xvideos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

