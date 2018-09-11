-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Июн 20 2017 г., 11:04
-- Версия сервера: 5.7.18
-- Версия PHP: 5.6.27-1+deb.sury.org~xenial+1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- База данных: `dombusin2`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `dombusin_banner`
-- 

DROP TABLE IF EXISTS `dombusin_banner`;
CREATE TABLE `dombusin_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop` int(11) NOT NULL DEFAULT '0',
  `page` varchar(255) NOT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  `cont` text NOT NULL,
  `visible` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `shop` (`shop`),
  KEY `page` (`page`),
  KEY `visible` (`visible`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=217 ;

-- 
-- Дамп данных таблицы `dombusin_banner`
-- 

INSERT INTO `dombusin_banner` (`id`, `shop`, `page`, `position`, `cont`, `visible`) VALUES 
(212, 0, 'all_pages', 1, '<p>&nbsp;<a href="http://www.dombusin.com/catalog/action/cat-545-kuloni-i-podveski"><img src="/pic/image/Kylonu_30.jpg" width="769" height="245" alt="" /></a></p>', 0),
(216, 0, 'all_pages', 1, '<p>&nbsp;<a href="http://www.dombusin.com/catalog/action"><img src="/pic/image/sea.jpg" width="769" height="245" alt="" /></a></p>', 0),
(214, 0, 'all_pages', 1, '<p>&nbsp;<a href="http://www.dombusin.com/catalog/action/cat-554-konnektori"><img src="/pic/image/konnektory_30.jpg" width="769" height="245" alt="" /></a></p>', 0),
(215, 0, 'all_pages', 1, '<p>&nbsp;<a href="http://www.dombusin.com/catalog/action/cat-457-zhemchug-naturalnij-i-perlamutr"><img src="/pic/image/shells.jpg" width="769" height="245" alt="" /></a></p>', 0);
