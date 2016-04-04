-- phpMyAdmin SQL Dump
-- version 4.0.10.12
-- http://www.phpmyadmin.net
--
-- Хост: id212905.mysql.ukraine.com.ua
-- Время создания: Апр 04 2016 г., 06:52
-- Версия сервера: 5.6.27-75.0-log
-- Версия PHP: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `id212905_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `api_keys`
--

CREATE TABLE IF NOT EXISTS `api_keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `api_key` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `api_keys`
--

INSERT INTO `api_keys` (`id`, `api_key`) VALUES
(1, '2b550a11f7c8d1b1'),
(2, 'sdgv0ddff7kko3hj');

-- --------------------------------------------------------

--
-- Структура таблицы `userlist`
--

CREATE TABLE IF NOT EXISTS `userlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `order_num` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=39 ;

--
-- Дамп данных таблицы `userlist`
--

INSERT INTO `userlist` (`id`, `name`, `email`, `order_num`) VALUES
(33, 'Louis C.K', 'louilouilooooui@gmail.com', '1'),
(34, 'George Carlin', 'georgeeee@yahoo.com', '5508'),
(35, 'Chris Rock', 'roooockkkkk123@ukr.net', '7089'),
(36, 'Jimmy Fallon', 'helloimjimm@amazon.com', '2584'),
(37, 'Eddie Murphy', 'onicecream@gmail.com', '2413');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
