-- phpMyAdmin SQL Dump
-- version 3.5.3
-- http://www.phpmyadmin.net
--
-- ホスト: localhost
-- 生成日時: 2012 年 10 月 14 日 20:30
-- サーバのバージョン: 5.1.61
-- PHP のバージョン: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- データベース: `xvs`
--

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
  PRIMARY KEY (`xvideos_id`,`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `xvideos_tag`
--
ALTER TABLE `xvideos_tag`
  ADD CONSTRAINT `xvideos_tag_ibfk_1` FOREIGN KEY (`xvideos_id`) REFERENCES `xvideos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

