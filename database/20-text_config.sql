-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Апр 23 2018 г., 09:26
-- Версия сервера: 10.1.24-MariaDB
-- Версия PHP: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `cms`
--

-- --------------------------------------------------------

--
-- Структура таблицы `text_config`
--

CREATE TABLE `text_config` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'markdown'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `text_config`
--

INSERT INTO `text_config` (`id`, `name`, `content`, `type`) VALUES
(1, 'footer', '© 2017 МКУК «ЗДВИНСКАЯ ЦЕНТРАЛИЗОВАННАЯ БИБЛИОТЕЧНАЯ СИСТЕМА»', 'markdown'),
(2, 'sitebar', '####Библиотека работает:\r\n\r\n*Пн - Пт:* c 10:00 до 17:00 <br>\r\n*Воскресенье:* c 11:00 до 17:00 <br>\r\n*Суббота:* Выходной', 'markdown'),
(3, 'menu', '\'Детям\': \'#\'\r\n\'Родителям\': \'#\'\r\n\'Новости\': \'/news\'\r\n\'Наши фото\': \'#\'\r\n\'О нас\': \r\n  \'Документы\': \'#\'\r\n  \'Справка\': \'#\'\r\n  \'правка\': \'#\'\r\n  \'О библиотеке\': \'/article/24\'', 'yaml');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `text_config`
--
ALTER TABLE `text_config`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `text_config`
--
ALTER TABLE `text_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
