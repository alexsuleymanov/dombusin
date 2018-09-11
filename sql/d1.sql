DROP TABLE IF EXISTS `dombusin_admins`;
CREATE TABLE `dombusin_admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `pass` text NOT NULL,
  `comm` text NOT NULL,
  `level` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

-- 
-- Дамп данных таблицы `dombusin_admins`
-- 

INSERT INTO `dombusin_admins` (`id`, `login`, `pass`, `comm`, `level`) VALUES 
(1, 'Kiril', 'd0mbu5in2017', '', 2),
(21, 'Alena', 'd0mbu5in17', '', 0),
(3, 'misha', 'd0mbu5in17', '', 2),
(22, 'Vika', 'd0mbu5in17', '', 2),
(23, 'Katya', 'd0mbu5in17', '', 0),
(12, 'MasGroup', 'm0sgr0up', '', 2),
(13, 'Marina', 'd0mbu5in17', '', 0),
(15, 'Viktoria', 'd0mbu5in17', '', 0),
(16, 'Dima', 'd0mbu5in17', '', 2),
(25, 'Kira', 'd0mbu5in17', '', 2),
(18, 'Sasha', 'd0mbu5in17', '', 0),
(19, 'Nadya', 'd0mbu5in17', '', 1),
(26, 'Olya', 'd0mbu5in17', '', 0),
(27, 'Oksana', 'd0mbu5in17', '', 0),
(28, 'deus', '111111', '', 1);

-- --------------------------------------------------------

-- 
-- Структура таблицы `dombusin_banner`
-- 

DROP TABLE IF EXISTS `dombusin_banner`;
CREATE TABLE `dombusin_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) NOT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  `cont` text NOT NULL,
  `visible` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `page` (`page`),
  KEY `visible` (`visible`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=238 ;

-- 
-- Дамп данных таблицы `dombusin_banner`
-- 

INSERT INTO `dombusin_banner` (`id`, `page`, `position`, `cont`, `visible`) VALUES 
(219, 'all_pages', 1, '<p>&nbsp;<a href="https://www.dombusin.com/catalog/cat-534-klej-skotch"><img src="/pic/image/skotch.jpg" width="775" height="245" alt="" /></a></p>', 0),
(216, 'all_pages', 1, '<p>&nbsp;<a href="https://www.dombusin.com/catalog/cat-533-figurnie-komposteri"><img src="/pic/image/composters.jpg" width="775" height="245" alt="" /></a></p>', 0),
(235, 'all_pages', 1, '<p>&nbsp;<a href="https://www.dombusin.com/catalog/cat-545-kuloni-i-podveski"><img src="/pic/Дом.jpg" width="775" height="245" alt="" /></a></p>', 0),
(234, 'all_pages', 1, '<p>&nbsp;<a href="https://www.dombusin.com/catalog/action/cat-143-kitajskij"><img src="/pic/image/biser_china.jpg" width="775" height="245" alt="" /></a></p>', 0),
(233, 'all_pages', 1, '<p>&nbsp;<a href="https://www.dombusin.com/catalog/action/cat-144-cheshskij"><img src="/pic/image/chech_biser.jpg" width="775" height="245" alt="" /></a></p>', 0),
(230, 'all_pages', 1, '<p>&nbsp;<a href="https://www.dombusin.com/catalog/action/cat-489-osnova-dlya-kolec"><img src="/pic/image/furniture_oct.jpg" width="769" height="245" alt="" /></a></p>', 0),
(231, 'all_pages', 1, '<p>&nbsp;<a href="https://www.dombusin.com/catalog/action/cat-487-hrustal-avstrijskij-imitaciya"><img src="/pic/image/chustal.jpg" width="775" height="245" alt="" /></a></p>', 0),
(232, 'all_pages', 1, '<p>&nbsp;<a href="https://www.dombusin.com/catalog/action/cat-493-niti-i-shnuri"><img src="/pic/image/cords.jpg" width="775" height="245" alt="" /></a></p>', 0),
(236, 'all_pages', 1, '<p>&nbsp;<a href="https://www.dombusin.com/catalog/action/cat-426-busini-steklyannie-bitoe-steklo"><img src="/pic/image/broke_glace.jpg" width="775" height="245" alt="" /></a></p>', 0),
(237, 'all_pages', 1, '<p>&nbsp;<a href="https://www.dombusin.com/catalog/cat-536-foamiran"><img src="/pic/image/foamiran_new.jpg" width="775" height="245" alt="" /></a></p>', 0);

-- --------------------------------------------------------

-- 
-- Структура таблицы `dombusin_block`
-- 

DROP TABLE IF EXISTS `dombusin_block`;
CREATE TABLE `dombusin_block` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `intname` varchar(255) NOT NULL,
  `comm` text NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `intname` (`intname`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Дамп данных таблицы `dombusin_block`
-- 

INSERT INTO `dombusin_block` (`id`, `intname`, `comm`, `value`) VALUES 
(1, 'tels', 'Контакты в шапке', 'Офис <span class="phone">(057) 755-60-05</span><br />\r\nМобильный <span class="phone">(063) 880-81-91</span>'),
(2, 'copy', 'copyright', 'Copyright &copy;2012 Вентиляция в Харькове.'),
(3, 'user_message', 'Сообщение для клиентов', '');

-- --------------------------------------------------------

-- 
-- Структура таблицы `dombusin_brand`
-- 

DROP TABLE IF EXISTS `dombusin_brand`;
CREATE TABLE `dombusin_brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `intname` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `short` text NOT NULL,
  `cont` longtext NOT NULL,
  `prior` int(11) NOT NULL DEFAULT '0',
  `visible` int(11) NOT NULL DEFAULT '0',
  `title` text,
  `h1` text,
  `kw` text,
  `descr` text,
  `spec` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `intname` (`intname`),
  KEY `visible` (`visible`),
  KEY `prior` (`prior`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Дамп данных таблицы `dombusin_brand`
-- 

INSERT INTO `dombusin_brand` (`id`, `intname`, `name`, `short`, `cont`, `prior`, `visible`, `title`, `h1`, `kw`, `descr`, `spec`) VALUES 
(1, 'brend1', 'Бренд1', '<p>Кратко о бренде1&nbsp;</p>', '<p>Полное описание бренда 1&nbsp;</p>', 0, 1, 'титл бренда 1', 'заголовок бренда 1', 'ключевые 1', 'дескрипшн бренда 1', 0);
