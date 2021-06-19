-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 19 2021 г., 22:48
-- Версия сервера: 8.0.19
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `kcity_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `sections`
--

CREATE TABLE `sections` (
  `id` mediumint NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `sections`
--

INSERT INTO `sections` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'Default group', '2021-06-01 01:05:35', '2021-06-18 20:05:47'),
(2, 'Advanced group', '2021-06-01 20:09:32', '2021-06-19 15:09:54');

-- --------------------------------------------------------

--
-- Структура таблицы `students`
--

CREATE TABLE `students` (
  `id` int NOT NULL,
  `section_id` int NOT NULL,
  `first_name` varchar(40) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `login` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `students`
--

INSERT INTO `students` (`id`, `section_id`, `first_name`, `last_name`, `login`, `email`, `created_at`, `updated_at`) VALUES
(1, 2, 'Dominique', 'Hermiston', 'rebeca.aufderhar', 'shaina26@collins.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(2, 2, 'Deonte', 'Gottlieb', 'jameson81', 'wzboncak@emard.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(3, 1, 'Reginald', 'Feeney', 'carroll.beahan', 'khartmann@kulas.org', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(4, 2, 'Corine', 'Pfannerstill', 'koelpin.kailyn', 'petra09@ebert.net', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(5, 1, 'Mathias', 'Willms', 'lonie.cruickshank', 'gbeier@gmail.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(6, 2, 'Alexander', 'Tremblay', 'rpadberg', 'bryana85@yahoo.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(7, 1, 'Frederick', 'Kemmer', 'davonte51', 'considine.retta@yahoo.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(8, 1, 'Pascale', 'Reinger', 'lquitzon', 'jeremy.walsh@gmail.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(9, 1, 'Sandy', 'Harber', 'eileen.herzog', 'prosacco.ben@yost.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(10, 2, 'Gordon', 'Shanahan', 'emerson.wunsch', 'anne.aufderhar@yahoo.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(11, 2, 'Karine', 'Rutherford', 'weston02', 'buckridge.marshall@huels.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(12, 1, 'Nicolette', 'Hagenes', 'torp.hunter', 'anastacio.leffler@murazik.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(13, 1, 'Isaac', 'Ullrich', 'norval.hackett', 'whoppe@jones.biz', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(14, 2, 'Angela', 'Quigley', 'devon.kling', 'keira.block@gmail.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(15, 1, 'Jillian', 'Roob', 'goyette.raphael', 'znicolas@oconner.net', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(16, 2, 'Jovan', 'Deckow', 'wilber.green', 'zcollier@hotmail.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(17, 1, 'Wiley', 'Boyer', 'keanu08', 'jamil.homenick@wiza.net', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(18, 1, 'Justine', 'Kuhic', 'trunolfsdottir', 'corine.pacocha@becker.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(19, 1, 'Jamir', 'Sipes', 'wilber55', 'white.gabriel@hotmail.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(20, 1, 'Helga', 'Aufderhar', 'yesenia.schimmel', 'lakin.frederick@yahoo.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(21, 1, 'Bert', 'Kutch', 'lyda.kertzmann', 'landen.west@parisian.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(22, 2, 'Carrie', 'Murphy', 'imertz', 'nia61@gmail.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(23, 2, 'Mathilde', 'Thompson', 'rempel.warren', 'vraynor@little.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(24, 2, 'Allie', 'Mueller', 'buck33', 'etha.feest@gottlieb.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(25, 2, 'Ambrose', 'Fay', 'hagenes.teagan', 'dgoldner@little.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(26, 2, 'Rey', 'Ernser', 'kdietrich', 'kurt.bernhard@gmail.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(27, 2, 'Clark', 'Pfannerstill', 'trent.waters', 'sincere.white@gmail.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(28, 2, 'Mario', 'Windler', 'bayer.andy', 'jpaucek@ryan.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(29, 2, 'Jadon', 'Casper', 'kelly.casper', 'considine.eda@hirthe.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(30, 2, 'Nora', 'McGlynn', 'rzemlak', 'vandervort.roberto@gmail.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(31, 2, 'Loraine', 'Schaden', 'nolan.waters', 'npaucek@rosenbaum.info', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(32, 2, 'Abdullah', 'Halvorson', 'lindgren.emmanuel', 'solon.fay@murray.net', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(33, 2, 'Brendon', 'Schiller', 'jtorp', 'oleta.runte@gmail.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(34, 1, 'Gene', 'Brown', 'grady.arno', 'rosalind.russel@dicki.info', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(35, 2, 'Marshall', 'Tromp', 'cnienow', 'kuphal.petra@gmail.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(36, 2, 'Dorcas', 'Kessler', 'harber.marquise', 'hane.payton@hotmail.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(37, 1, 'Sadye', 'Bogisich', 'hhaley', 'farrell.eleazar@hotmail.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(38, 2, 'Lonie', 'Dicki', 'gleffler', 'evalyn62@skiles.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(39, 2, 'Naomie', 'Bode', 'koelpin.avery', 'tshanahan@hotmail.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(40, 1, 'Lessie', 'Mann', 'braun.cecil', 'cora99@erdman.org', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(41, 2, 'Willy', 'Hane', 'delbert98', 'kyleigh.gleichner@hickle.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(42, 2, 'Johathan', 'Treutel', 'istokes', 'arvilla.schimmel@gmail.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(43, 2, 'Elwin', 'Botsford', 'joan.littel', 'bzemlak@dickinson.info', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(44, 1, 'Brown', 'Pacocha', 'mariana.jones', 'minerva.kohler@dooley.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(45, 2, 'Laurianne', 'Sporer', 'timmothy.hansen', 'marcellus75@walter.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(46, 2, 'Roselyn', 'Kemmer', 'barton10', 'lesch.luella@hand.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(47, 2, 'Broderick', 'Larkin', 'aiden.davis', 'margot26@greenholt.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(48, 1, 'Oceane', 'Frami', 'cierra.bergnaum', 'yvon@hotmail.com', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(49, 2, 'Davin', 'Botsford', 'stella.haley', 'dora44@mills.biz', '2021-06-19 18:15:57', '2021-06-19 15:15:57'),
(50, 2, 'Bianka', 'Pfannerstill', 'xmante', 'conroy.deanna@hauck.org', '2021-06-19 18:15:57', '2021-06-19 15:15:57');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `login` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'root', '4c76bdacc41b8a47a0cd3e329eca8ab2', '2021-06-19 12:41:01', '2021-06-19 09:41:01', NULL),
(2, 'splinter', 'af9cd099aaf93e992de2fcefce50c75f', '2021-06-19 12:41:01', '2021-06-19 09:41:02', NULL),
(3, 'batman', '3bc2a8b61923a0fd5b55f5b4e8caa945', '2021-06-19 12:41:01', '2021-06-19 09:41:02', NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_idx_login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `sections`
--
ALTER TABLE `sections`
  MODIFY `id` mediumint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `students`
--
ALTER TABLE `students`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
