-- phpMyAdmin SQL Dump
-- version 3.4.0
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Ноя 25 2012 г., 23:43
-- Версия сервера: 5.0.51
-- Версия PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- Структура таблицы `chat`
--

DROP TABLE IF EXISTS `chat`;
CREATE TABLE IF NOT EXISTS `chat` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user` int(10) unsigned NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `text` varchar(512) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `type` char(32) NOT NULL,
  `category` int(10) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `text` varchar(512) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `type` (`type`,`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `daily`
--

DROP TABLE IF EXISTS `daily`;
CREATE TABLE IF NOT EXISTS `daily` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `topic` char(192) NOT NULL,
  `text` varchar(10240) NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `category` int(10) unsigned default NULL,
  `read` tinyint(1) unsigned NOT NULL default '0',
  `comments` tinyint(1) unsigned NOT NULL default '1',
  `hide` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `user` (`user`,`hide`),
  KEY `date` (`hide`,`date`),
  KEY `category` (`category`,`hide`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `daily_category`
--

DROP TABLE IF EXISTS `daily_category`;
CREATE TABLE IF NOT EXISTS `daily_category` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user` int(10) unsigned NOT NULL,
  `name` char(128) NOT NULL,
  `about` char(192) default NULL,
  PRIMARY KEY  (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `files`
--

DROP TABLE IF EXISTS `files`;
CREATE TABLE IF NOT EXISTS `files` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` char(192) NOT NULL,
  `filetype` char(8) NOT NULL,
  `description` varchar(512) default NULL,
  `category` int(10) NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `size` int(10) unsigned NOT NULL,
  `width` smallint(4) unsigned default NULL,
  `height` smallint(4) unsigned default NULL,
  `bitrate` int(10) unsigned default NULL,
  `frequency` int(10) unsigned default NULL,
  `download` SMALLINT( 5 ) UNSIGNED NOT NULL DEFAULT  '0',
  PRIMARY KEY  (`id`),
  KEY `date` (`date`),
  KEY `category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `files_category`
--

DROP TABLE IF EXISTS `files_category`;
CREATE TABLE IF NOT EXISTS `files_category` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parent` int(10) unsigned NOT NULL default '0',
  `name` char(128) NOT NULL,
  `about` char(192) default NULL,
  `filetypes` char(192) default NULL,
  PRIMARY KEY  (`id`,`parent`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `forums`
--

DROP TABLE IF EXISTS `forums`;
CREATE TABLE IF NOT EXISTS `forums` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` char(128) NOT NULL,
  `description` varchar(512) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `forums_favorites`
--

DROP TABLE IF EXISTS `forums_favorites`;
CREATE TABLE IF NOT EXISTS `forums_favorites` (
  `user` int(10) unsigned NOT NULL,
  `theme` int(10) unsigned NOT NULL,
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `forums_messages`
--

DROP TABLE IF EXISTS `forums_messages`;
CREATE TABLE IF NOT EXISTS `forums_messages` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `theme` int(10) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `text` varchar(10240) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `theme` (`theme`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `forums_themes`
--

DROP TABLE IF EXISTS `forums_themes`;
CREATE TABLE IF NOT EXISTS `forums_themes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `category` int(10) unsigned NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `name` char(128) NOT NULL,
  `close` tinyint(1) NOT NULL default '0',
  `warning` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `category` (`category`),
  KEY `category_3` (`category`,`warning`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `guestbook`
--

DROP TABLE IF EXISTS `guestbook`;
CREATE TABLE IF NOT EXISTS `guestbook` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user` int(10) unsigned NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `text` varchar(512) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id` smallint(2) unsigned NOT NULL auto_increment,
  `name` char(64) NOT NULL,
  `module` char(64) default NULL,
  `page_id` int(10) unsigned default NULL,
  `image` char(192) default NULL,
  `about_function` char(64) default NULL,
  `sort` smallint(2) default NULL,
  PRIMARY KEY  (`id`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `menu`
--

INSERT INTO `menu` (`id`, `name`, `module`, `page_id`, `image`, `about_function`, `sort`) VALUES
(1, 'Информация', NULL, NULL, '', NULL, 1),
(2, 'Новости', 'news', 0, '166-newspaper.png', 'news_date', 2),
(4, 'Общение', NULL, NULL, NULL, NULL, 4),
(5, 'Гостевая книга', 'guestbook', NULL, '96-book.png', 'guestbook_count', 6),
(6, 'Чат', 'chat', NULL, '08-chat.png', 'chat_count', 7),
(7, 'Форум', 'forum', NULL, '124-bullhorn.png', 'forum_info', 5),
(9, 'Пользователи', 'users_online', NULL, '112-group.png', 'users_info', 3),
(10, 'Дневники', 'daily', NULL, '187-pencil.png', 'daily_count', 10),
(11, 'Фотоальбом', 'photos', NULL, '42-photos.png', 'photos_count', 11),
(12, 'Файлы', 'files', NULL, '68-paperclip.png', 'files_count', 9),
(15, 'Разное', '', NULL, NULL, NULL, 8);

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `time` int(10) unsigned NOT NULL,
  `group` bigint(20) unsigned NOT NULL,
  `from` int(10) unsigned NOT NULL,
  `whom` int(10) unsigned NOT NULL,
  `text` varchar(10240) NOT NULL,
  `d_from` tinyint(1) unsigned NOT NULL default '0',
  `d_whom` tinyint(1) unsigned NOT NULL default '0',
  `read` tinyint(1) unsigned NOT NULL default '0',
  `delete` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `whom` (`whom`,`read`,`delete`),
  KEY `time` (`from`,`whom`,`delete`,`time`),
  KEY `time_2` (`group`,`delete`,`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `topic` char(192) NOT NULL,
  `text` varchar(10240) NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `category` int(10) unsigned default NULL,
  `read` tinyint(1) unsigned NOT NULL default '0',
  `comments` tinyint(1) unsigned NOT NULL default '1',
  `hide` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `hide` (`hide`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `news_category`
--

DROP TABLE IF EXISTS `news_category`;
CREATE TABLE IF NOT EXISTS `news_category` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` char(128) NOT NULL,
  `about` char(192) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` char(248) default NULL,
  `description` char(248) default NULL,
  `keywords` varchar(2048) default NULL,
  `text` text,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `photos`
--

DROP TABLE IF EXISTS `photos`;
CREATE TABLE IF NOT EXISTS `photos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user` int(10) unsigned NOT NULL,
  `name` char(192) NOT NULL,
  `description` varchar(512) default NULL,
  `category` int(10) NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `size` int(10) unsigned NOT NULL,
  `width` smallint(4) unsigned NOT NULL,
  `height` smallint(4) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user` (`user`),
  KEY `date` (`date`),
  KEY `category` (`category`),
  KEY `category_2` (`category`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `photos_category`
--

DROP TABLE IF EXISTS `photos_category`;
CREATE TABLE IF NOT EXISTS `photos_category` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user` int(10) unsigned NOT NULL,
  `name` char(128) NOT NULL,
  `about` char(192) default NULL,
  PRIMARY KEY  (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `profile`
--

DROP TABLE IF EXISTS `profile`;
CREATE TABLE IF NOT EXISTS `profile` (
  `user` int(10) unsigned NOT NULL,
  `firstname` char(32) default NULL,
  `lastname` char(32) default NULL,
  `birthday` char(10) default NULL,
  `city` char(64) default NULL,
  `about` char(255) default NULL,
  `phone` char(32) default NULL,
  `skype` char(32) default NULL,
  `icq` int(9) unsigned default NULL,
  `twitter` char(32) default NULL,
  `facebook` char(32) default NULL,
  `vk` char(32) default NULL,
  `site` char(64) default NULL,
  PRIMARY KEY  (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL auto_increment,
  `login` char(32) NOT NULL,
  `password` char(255) NOT NULL,
  `sex` tinyint(1) unsigned NOT NULL,
  `mail` char(128) NOT NULL,
  `date_registration` int(10) unsigned NOT NULL,
  `elements` smallint(10) unsigned NOT NULL default '10',
  `timezone` smallint(4) NOT NULL default '20',
  `last_update` int(10) unsigned NOT NULL,
  `level` smallint(4) unsigned NOT NULL default '1',
  `forum` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `login` (`login`),
  KEY `last_update` (`last_update`),
  KEY `date_registration` (`date_registration`),
  KEY `mail` (`mail`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;

-- --------------------------------------------------------

--
-- Дамп данных таблицы `menu`
--

INSERT INTO `users` ( `id` , `login` , `password` , `sex` , `mail` , `date_registration` , `elements` , `timezone` , `last_update` , `level` , `forum`) VALUES ('999',  'Гость',  '',  '1',  '',  '1350241827',  '5',  '18',  '1356518773',  '1',  '2');

-- --------------------------------------------------------

--
-- Структура таблицы `users_auth`
--

DROP TABLE IF EXISTS `users_auth`;
CREATE TABLE IF NOT EXISTS `users_auth` (
  `user` int(10) unsigned NOT NULL,
  `key` char(32) NOT NULL,
  `ip` bigint(10) NOT NULL,
  PRIMARY KEY  (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users_friends`
--

DROP TABLE IF EXISTS `users_friends`;
CREATE TABLE IF NOT EXISTS `users_friends` (
  `user` int(10) unsigned NOT NULL,
  `friend` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`user`,`friend`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users_lost`
--

DROP TABLE IF EXISTS `users_lost`;
CREATE TABLE IF NOT EXISTS `users_lost` (
  `id` int(10) NOT NULL,
  `key` char(255) NOT NULL,
  `password` char(255) NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1;

-- --------------------------------------------------------

--
-- Структура таблицы `variables`
--

DROP TABLE IF EXISTS `variables`;
CREATE TABLE IF NOT EXISTS `variables` (
  `name` char(32) NOT NULL,
  `value` char(192) NOT NULL,
  `expire` int(10) unsigned default NULL,
  PRIMARY KEY  (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
