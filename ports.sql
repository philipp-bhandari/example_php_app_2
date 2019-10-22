-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 01 2019 г., 13:35
-- Версия сервера: 5.7.26
-- Версия PHP: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `ports`
--

-- --------------------------------------------------------

--
-- Структура таблицы `proxys`
--

DROP TABLE IF EXISTS `proxys`;
CREATE TABLE IF NOT EXISTS `proxys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(100) NOT NULL,
  `port` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=142 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `proxys`
--

INSERT INTO `proxys` (`id`, `ip`, `port`) VALUES
(128, '163.172.147.94', 5656),
(129, '157.245.0.181', 3128),
(130, '157.230.38.116', 8080),
(131, '146.120.81.73', 52658),
(132, '144.217.74.219', 3128),
(133, '139.255.89.91', 3128),
(134, '116.49.94.205', 3128),
(135, '104.168.213.25', 8080),
(141, '123', 123);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `role` int(11) NOT NULL DEFAULT '2',
  `token` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`),
  UNIQUE KEY `token` (`token`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `pass`, `role`, `token`) VALUES
(1, 'admin', 'admin', 1, 'o1blkf5k73g3p1u06ge1ochb3n'),
(2, 'vasiliy', '123', 2, 'j8jh072bl94fg0981qssfpoe4e'),
(3, 'root', 'root', 1, 'iumv707k9tf5gapljb0olcr0g4');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
