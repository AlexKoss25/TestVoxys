-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июн 10 2021 г., 05:32
-- Версия сервера: 10.3.16-MariaDB
-- Версия PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `users`
--

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `patronymic` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `last_name`, `first_name`, `patronymic`, `status`) VALUES
(1, 'Иванов', 'Иван', 'Иванович', 'Третий'),
(2, 'Петров', 'Петр', 'Петрович', 'Третий'),
(3, 'Иванов', 'Петр', 'Петрович', 'Третий'),
(4, 'Иванов', 'Петр', 'Иванович', 'Третий'),
(5, 'Иванов', 'Иван', 'Иванович', 'Третий'),
(6, 'Козачек', 'Александр', '', 'Первый'),
(7, 'Алексеев', 'Алексей', 'Алексеевич', 'Третий'),
(8, 'Скворцов', 'Николай', 'Иванович', 'Третий'),
(23, 'Петрова', 'Анастасия', 'Сергеевна', 'Второй'),
(24, 'Петров', 'Иван', 'Васильевич', 'Второй'),
(25, 'Петров', 'Дмитрий', 'Михайлович', 'Второй'),
(26, 'Петров', 'Дмитрий', 'Михайлович', 'Первый');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
