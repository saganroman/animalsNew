-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Час створення: Лис 21 2016 р., 08:04
-- Версія сервера: 10.1.16-MariaDB
-- Версія PHP: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `animals`
--

-- --------------------------------------------------------

--
-- Структура таблиці `animals`
--

CREATE TABLE `animals` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `species_id` int(11) NOT NULL,
  `breed_id` int(11) NOT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `LatLn` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `animals`
--

INSERT INTO `animals` (`id`, `name`, `species_id`, `breed_id`, `content`, `photo`, `address`, `LatLn`) VALUES
(8, 'Тузік', 1, 1, '<p>Пропала собака. Хто знайде дзвоніть 05088877744</p>\r\n', '1479710461.jpg', 'Львів автовокзал, вулиця Стрийська, Львів, Україна', '49.7867677, 24.01672110000004'),
(9, 'Мурчик', 2, 2, '<p>Пропала собака. Хто знайде дзвоніть 05088877744</p>\r\n', '1479710524.jpg', 'вулиця Городоцька, Львів, Львівська область, Україна', '49.830936, 23.969823099999985'),
(10, 'Селім', 2, 4, '<p>Пропала собака. Хто знайде дзвоніть 05088877744</p>\r\n', '1479710568.jpg', 'Львівський національний університет імені Івана Франка, вулиця Університетська, Львів, Україна', '49.8406108, 24.022509899999932'),
(11, 'Рекс', 1, 3, '<p>Пропала собака. Хто знайде дзвоніть 05088877744</p>\r\n', '1479710626.jpg', 'вулиця Князя Мстислава Удатного, Львів, Львівська область, Україна', '49.84637190000001, 24.026361700000052');

-- --------------------------------------------------------

--
-- Структура таблиці `breeds`
--

CREATE TABLE `breeds` (
  `id` int(10) UNSIGNED NOT NULL,
  `species_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `breeds`
--

INSERT INTO `breeds` (`id`, `species_id`, `name`) VALUES
(1, 1, 'Дворняга звичайна'),
(2, 2, 'Бурмілла'),
(3, 1, 'Вівчарка'),
(4, 2, 'Ашера');

-- --------------------------------------------------------

--
-- Структура таблиці `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2016_11_11_134449_create_species_table', 1),
('2016_11_11_134604_create_breed_table', 1),
('2016_11_11_134619_create_animals_table', 1);

-- --------------------------------------------------------

--
-- Структура таблиці `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `species`
--

CREATE TABLE `species` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `species`
--

INSERT INTO `species` (`id`, `name`) VALUES
(1, 'Собаки'),
(2, 'Коти');

-- --------------------------------------------------------

--
-- Структура таблиці `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп даних таблиці `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Роман Саган', 'romaaskoe@gmail.com', '$2y$10$..gHsyjsGHLpNxM8aFqiC.SfytqTU01MJfGi45CkIcEKm2I5GOh62', 'PAq9JivIjszku7H5kWJX3X1qVUu8Gs2bzWfMhm4U1Y5ppLhEC5qvfERsTjf4', '2016-11-14 13:40:09', '2016-11-20 10:08:41');

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `breeds`
--
ALTER TABLE `breeds`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Індекси таблиці `species`
--
ALTER TABLE `species`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT для таблиці `breeds`
--
ALTER TABLE `breeds`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблиці `species`
--
ALTER TABLE `species`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблиці `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
