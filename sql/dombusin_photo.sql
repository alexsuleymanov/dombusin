-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Мар 12 2018 г., 19:37
-- Версия сервера: 5.7.18
-- Версия PHP: 5.6.27-1+deb.sury.org~xenial+1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- База данных: `dombusin2`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `dombusin_photo`
-- 

DROP TABLE IF EXISTS `dombusin_photo`;
CREATE TABLE `dombusin_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `par` int(11) NOT NULL DEFAULT '0',
  `name` text NOT NULL,
  `prior` int(11) NOT NULL DEFAULT '0',
  `visible` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `prior` (`prior`),
  KEY `type` (`type`),
  KEY `par` (`par`),
  KEY `visible` (`visible`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- 
-- Дамп данных таблицы `dombusin_photo`
-- 

INSERT INTO `dombusin_photo` (`id`, `type`, `par`, `name`, `prior`, `visible`) VALUES 
(5, 'prod', 1, '', 0, 1),
(6, 'prod', 1, '', 0, 1);
