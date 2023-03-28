-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Мар 22 2023 г., 20:59
-- Версия сервера: 10.4.27-MariaDB
-- Версия PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `tickets`
--

-- --------------------------------------------------------

--
-- Структура таблицы `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20230227162414', '2023-02-27 17:24:20', 347);

-- --------------------------------------------------------

--
-- Структура таблицы `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `status`
--

INSERT INTO `status` (`id`, `status`) VALUES
(1, 'Получен'),
(2, 'В обработке'),
(3, 'В работе'),
(4, 'Завершено');

-- --------------------------------------------------------

--
-- Структура таблицы `ticket_entity`
--

CREATE TABLE `ticket_entity` (
  `id` int(11) NOT NULL,
  `urgency_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `text` longtext NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `ticket_entity`
--

INSERT INTO `ticket_entity` (`id`, `urgency_id`, `status_id`, `text`, `name`) VALUES
(9, 3, 4, 'asdasdasdasdasd', 'Проблема с логином');

-- --------------------------------------------------------

--
-- Структура таблицы `ticket_of_user`
--

CREATE TABLE `ticket_of_user` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `ticket_of_user`
--

INSERT INTO `ticket_of_user` (`id`, `user_id`, `ticket_id`) VALUES
(5, 1, 9);

-- --------------------------------------------------------

--
-- Структура таблицы `urgency_entity`
--

CREATE TABLE `urgency_entity` (
  `id` int(11) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `urgency_entity`
--

INSERT INTO `urgency_entity` (`id`, `time`) VALUES
(1, 1),
(2, 3),
(3, 12),
(4, 24),
(5, 48);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`) VALUES
(1, 'usernameAdmin', '[\"ROLE_ADMIN\"]', '$2y$13$pdrcQPykhkU6FXrcgvYd/uT1NmukL856REakJCVvQGRNYGobMMadO'),
(2, 'username', '[\"ROLE_USER\"]', '$2y$13$vehrTus3uCDIskoVQxJy4uomdygNBG21AJ9jcewAEza4F5BHXGeeW');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Индексы таблицы `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `ticket_entity`
--
ALTER TABLE `ticket_entity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_746A2EA34D44979A` (`urgency_id`),
  ADD KEY `IDX_746A2EA36BF700BD` (`status_id`);

--
-- Индексы таблицы `ticket_of_user`
--
ALTER TABLE `ticket_of_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_24670728A76ED395` (`user_id`),
  ADD KEY `IDX_24670728700047D2` (`ticket_id`);

--
-- Индексы таблицы `urgency_entity`
--
ALTER TABLE `urgency_entity`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `ticket_entity`
--
ALTER TABLE `ticket_entity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `ticket_of_user`
--
ALTER TABLE `ticket_of_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `urgency_entity`
--
ALTER TABLE `urgency_entity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `ticket_entity`
--
ALTER TABLE `ticket_entity`
  ADD CONSTRAINT `FK_746A2EA34D44979A` FOREIGN KEY (`urgency_id`) REFERENCES `urgency_entity` (`id`),
  ADD CONSTRAINT `FK_746A2EA36BF700BD` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`);

--
-- Ограничения внешнего ключа таблицы `ticket_of_user`
--
ALTER TABLE `ticket_of_user`
  ADD CONSTRAINT `FK_24670728700047D2` FOREIGN KEY (`ticket_id`) REFERENCES `ticket_entity` (`id`),
  ADD CONSTRAINT `FK_24670728A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
