-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-01-2017 a las 16:59:38
-- Versión del servidor: 10.1.19-MariaDB
-- Versión de PHP: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `age`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `analyst_client`
--

CREATE TABLE `analyst_client` (
  `id` int(10) UNSIGNED NOT NULL,
  `analyst_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `analyst_client`
--

INSERT INTO `analyst_client` (`id`, `analyst_id`, `client_id`) VALUES
(9, 13, 11),
(10, 12, 15),
(11, 13, 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2015_05_15_124334_update_users_table', 1),
('2015_10_21_173121_create_users_roles', 1),
('2015_11_02_004932_create_profiles_table', 1),
('2015_12_25_010553_add_signup_ip_address_to_users_table', 1),
('2015_12_25_011117_add_signup_confirmation_ip_address_to_users_table', 1),
('2015_12_25_025231_add_signup_sm_ip_address_to_users_table', 1),
('2016_04_19_045644_add_signup_admin_ip_address_to_users_table', 1),
('2016_09_01_202529_add_user_profile_bg_to_user_profiles_table', 1),
('2017_01_18_162653_create_tasks_table', 2),
('2017_01_19_164714_create_reports_table', 3),
('2017_01_20_004514_create_priorities_table', 4),
('2017_01_20_004809_create_subjects_table', 4),
('2017_01_20_004852_create_requirements_table', 5),
('2017_01_20_005415_subject_priority_table', 5),
('2017_01_23_150609_create_analyst_client_table', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `priorities`
--

CREATE TABLE `priorities` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `priorities`
--

INSERT INTO `priorities` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Urgente', '2017-01-20 05:12:35', '2017-01-20 05:12:35'),
(2, 'Alta', '2017-01-20 05:12:35', '2017-01-20 05:12:35'),
(3, 'Media', '2017-01-20 05:12:35', '2017-01-20 05:12:35'),
(4, 'Baja', '2017-01-20 05:12:35', '2017-01-20 05:12:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profiles`
--

CREATE TABLE `profiles` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `bio` text COLLATE utf8_unicode_ci,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `skype_user` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `profile_pic` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_profile_bg` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'default-user-bg.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `bio`, `phone`, `skype_user`, `profile_pic`, `created_at`, `updated_at`, `user_profile_bg`) VALUES
(7, 10, '', '04242337767', 'daniel.corcega', '/images/profile/10/pics/user-pic.gif', '2017-01-17 23:26:43', '2017-01-23 16:55:50', 'default-user-bg.jpg'),
(8, 11, '', '04242337767', 'daniel.corcega', '', '2017-01-18 03:17:44', '2017-01-18 03:17:44', 'default-user-bg.jpg'),
(9, 12, '', '', 'daniel.corcega', '', '2017-01-18 03:23:45', '2017-01-18 03:23:45', 'default-user-bg.jpg'),
(10, 13, '', '', '', '', '2017-01-19 17:13:49', '2017-01-19 17:13:49', 'default-user-bg.jpg'),
(12, 15, '', '', '', '/images/profile/15/pics/user-pic.jpg', '2017-01-19 19:12:34', '2017-01-19 19:12:34', 'default-user-bg.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reports`
--

CREATE TABLE `reports` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `storage` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `extension` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `belongs_to` int(11) NOT NULL,
  `uploaded_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `reports`
--

INSERT INTO `reports` (`id`, `name`, `storage`, `extension`, `description`, `belongs_to`, `uploaded_by`, `created_at`, `updated_at`) VALUES
(3, 'tests test', '/files/users/10/reports/tests_test.pdf', 'pdf', 'asdasd', 15, 10, '2017-01-20 01:36:27', '2017-01-23 16:38:40'),
(4, 'cbh dia', '/files/users/10/reports/cbh_dia.pdf', 'pdf', 'sadasdad', 11, 10, '2017-01-23 16:33:46', '2017-01-23 16:33:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requirements`
--

CREATE TABLE `requirements` (
  `id` int(10) UNSIGNED NOT NULL,
  `subject_id` int(11) NOT NULL,
  `priority_id` int(11) NOT NULL,
  `archive` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file_ext` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `requirements`
--

INSERT INTO `requirements` (`id`, `subject_id`, `priority_id`, `archive`, `file_ext`, `description`, `created_by`, `assigned_to`, `created_at`, `updated_at`) VALUES
(4, 3, 1, '/files/users/10/requirements/4/requirementFile.pdf', 'pdf', 'a description', 10, NULL, '2017-01-24 02:20:51', '2017-01-24 03:04:40'),
(5, 3, 2, '/files/users/10/requirements/5/requirementFile.pdf', 'pdf', 'asdada', 10, NULL, '2017-01-24 02:26:15', '2017-01-24 03:06:07'),
(6, 2, 1, '', '', 'requerimiento de prueba', 15, 13, '2017-01-24 04:42:41', '2017-01-24 05:02:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'super administrador', '2017-01-17 17:40:20', '2017-01-17 17:40:20'),
(2, 'supervisor', '2017-01-17 17:40:20', '2017-01-17 17:40:20'),
(3, 'analista', '2017-01-17 17:40:20', '2017-01-17 17:40:20'),
(4, 'usuario', '2017-01-17 17:40:20', '2017-01-17 17:40:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subjects`
--

CREATE TABLE `subjects` (
  `id` int(10) UNSIGNED NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `subjects`
--

INSERT INTO `subjects` (`id`, `subject`, `created_at`, `updated_at`) VALUES
(2, 'subject 1', '2017-01-20 07:11:14', '2017-01-20 07:11:14'),
(3, 'subject 23', '2017-01-20 07:12:18', '2017-01-20 07:12:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subject_priority`
--

CREATE TABLE `subject_priority` (
  `id` int(10) UNSIGNED NOT NULL,
  `subject_id` int(11) NOT NULL,
  `priority_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `subject_priority`
--

INSERT INTO `subject_priority` (`id`, `subject_id`, `priority_id`, `created_at`, `updated_at`) VALUES
(1, 2, 4, NULL, NULL),
(2, 3, 1, NULL, NULL),
(3, 3, 2, NULL, NULL),
(4, 3, 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tasks`
--

CREATE TABLE `tasks` (
  `id` int(10) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `cant_horas` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tasks`
--

INSERT INTO `tasks` (`id`, `fecha`, `hora_inicio`, `cant_horas`, `descripcion`, `tipo`, `user_id`, `client_id`, `created_at`, `updated_at`) VALUES
(3, '2017-01-20', '11:00:00', 120, 'clases', '1', 13, 15, '2017-01-19 17:14:55', '2017-01-19 17:14:55'),
(4, '2017-01-24', '07:00:00', 180, 'arreglos a las tareas', '2', 13, 11, '2017-01-24 17:41:38', '2017-01-24 17:43:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `activation_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `resent` tinyint(3) UNSIGNED NOT NULL,
  `role_id` int(11) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `signup_ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `signup_confirmation_ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `signup_sm_ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `admin_ip_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `first_name`, `last_name`, `email`, `password`, `activation_code`, `active`, `resent`, `role_id`, `remember_token`, `signup_ip_address`, `signup_confirmation_ip_address`, `signup_sm_ip_address`, `admin_ip_address`, `created_at`, `updated_at`) VALUES
(10, 'admin', 'Daniel', 'Corcega', 'danicorcega@gmail.com', '$2y$10$lZ/EDBGcs60bmrw6OrwSpOKL7BS9TTJP.0xlAcixSY0DmF11buSDK', '', 1, 0, 1, 'lYbg9PYgvY1AdCGGGkQKEKldfra27fxpNxPQ0rWsCpzSh0HKlB1wJLcK2ZSG', '::1', '::1', '', '', '2017-01-17 23:26:39', '2017-01-20 06:37:34'),
(11, 'Danic', 'Daniel', 'admin', 'admin@admin.com', '$2y$10$kVleqKq/b0eY9jjFvIdPRePsYrzuJ/z3ZjqcEsnnP3vemvaY0oKIG', 'SKXiCQP4Bo9Nr3HScj4m2LpOtglWWwinnO2znJgILAoSMuoNAQY4CpZLYha7admin@admin.com', 1, 0, 4, NULL, '', '', '', '::1', '2017-01-18 03:17:44', '2017-01-18 03:17:44'),
(12, 'daniadmi', 'admin', 'Corcega', 'author@author.com', '$2y$10$v7KinkTzq/sq7zpv6iFU3e4dGyYuGUev9ImjpnaGKky2FSOn2VjuK', 'b03HtBUU7CISkcdPnqkyHY0wjqC5gufMGAxgN5jY8phTNTetWFPzmpTpoPqyauthor@author.com', 1, 0, 2, NULL, '', '', '', '::1', '2017-01-18 03:23:45', '2017-01-18 03:23:45'),
(13, 'español', 'Dani', 'analyst', 'author2@author.com', '$2y$10$CRjWM43qpkjh6F9IEEs4UOJbwDFjNcGpAxoJzJTqijV6W3hAKvqHG', 'xt36RXjttKx1GbB1FTnOZtzPBFCkFTnnBV2mysfOoiwHkmCJGugKcUPmdApkauthor2@author.com', 1, 0, 3, 'N2XcTAWv1VsIZBt2hfZCYfR6Ys10DEOgZgDgRa2K9MfSkgJJGtiVO0U27QhL', '', '', '', '::1', '2017-01-19 17:13:49', '2017-01-19 18:22:29'),
(15, 'tests', 'test', 'test', 'test@test.com', '$2y$10$PputvrdIBfcerXpJu8I8SecK0rGsrpnkkJhhlEA/MXkQqJZVFS.iu', 'VeVAtQmCXBUTkCXEeUo6xZL154zqhhuE2yATodV5ATDhzqMhPnTwGnW3dm2Utest@test.com', 1, 0, 4, 'n1Xt4Va14oaMiHmWvu4ECmOqqZtmyxjC8OxoY28ZrvtEKuRJ540ufhNcc6r9', '', '', '', '::1', '2017-01-19 19:12:33', '2017-01-24 17:48:58');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `analyst_client`
--
ALTER TABLE `analyst_client`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indices de la tabla `priorities`
--
ALTER TABLE `priorities`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profiles_user_id_index` (`user_id`);

--
-- Indices de la tabla `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `requirements`
--
ALTER TABLE `requirements`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `subject_priority`
--
ALTER TABLE `subject_priority`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_name_unique` (`name`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `analyst_client`
--
ALTER TABLE `analyst_client`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `priorities`
--
ALTER TABLE `priorities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `requirements`
--
ALTER TABLE `requirements`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `subject_priority`
--
ALTER TABLE `subject_priority`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
