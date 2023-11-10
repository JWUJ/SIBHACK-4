-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               10.8.4-MariaDB - mariadb.org binary distribution
-- Операционная система:         Win64
-- HeidiSQL Версия:              12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Дамп структуры базы данных RKOT
CREATE DATABASE IF NOT EXISTS `RKOT` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `RKOT`;

-- Дамп структуры для таблица RKOT.files
CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT 0,
  `filename` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user_id`),
  CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы RKOT.files: ~0 rows (приблизительно)

-- Дамп структуры для таблица RKOT.menus
CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`items`)),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы RKOT.menus: ~2 rows (приблизительно)
INSERT INTO `menus` (`id`, `name`, `items`) VALUES
	(1, 'Admin', '{\r\n  "Пользователи": "/admin/users",\r\n  "Страницы": "/admin/pages",\r\n  "РКОТ": {\r\n    "Отчёты": "/admin/rkot/table",\r\n    "Города": "/admin/pages/rkot/cities",\r\n    "Операторы связи": "/admin/pages/rkot/mobile_operators"\r\n  }\r\n}'),
	(2, 'Main', '{\r\n "Об проекте": "/info"\r\n}');

-- Дамп структуры для таблица RKOT.pages
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `type` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы RKOT.pages: ~16 rows (приблизительно)
INSERT INTO `pages` (`id`, `page`, `url`, `location`, `roles`, `type`) VALUES
	(1, 'Администратор: Главная', '/admin', '/pages/admin/main.php', '[1,2]', 'admin'),
	(2, 'Администратор: Управление пользователями', '/admin/users', '/pages/admin/users.php', '[1]', 'admin'),
	(3, 'Администратор: Страницы', '/admin/pages', '/pages/admin/pages.php', '[1]', 'admin'),
	(4, 'Администратор: Редактирирование страницы', '/admin/pages/editor', '/pages/admin/editor.php', '[1]', 'admin'),
	(5, 'Api:Modules:Main:Roles', '/api/roles', '/api/main/roles.php', '', 'api'),
	(6, 'Api:Modules:Main:Files:Get TODO', '/api/getfile', '/pages/admin/api/getfile.php', '[1,2]', 'api'),
	(7, 'РКОТ: Города', '/admin/pages/rkot/cities', '/pages/admin/rkot/cities.php', '[1,2]', 'admin:rkot'),
	(8, '404', '/404', '/pages/404.php', NULL, 'main'),
	(9, 'Вход', '/auth', '/pages/auth/login.php', NULL, 'main'),
	(10, 'Выйти из аккаунта', '/logout', '/pages/auth/logout.php', NULL, 'main'),
	(11, 'РКОТ: Операторы', '/admin/pages/rkot/mobile_operators', '/pages/admin/rkot/mobile_operators.php', '[1,2]', 'admin:rkot'),
	(15, 'Api:Modules:RKOT:Cities', '/api/rkot/cities', '/api/modules/rkot/cities.php', '[1,2]', 'api:rkot'),
	(16, 'Api:Modules:RKOT:Mobile_Operators', '/api/rkot/mobile_operators', '/api/modules/rkot/mobile_operators.php', '[1,2]', 'api:rkot'),
	(18, 'Api:Modules:Main:Users', '/api/users', '/api/main/users.php', '', 'api'),
	(24, 'Api:Modules:Main:Pages', '/api/pages', '/api/main/pages.php', '', 'api'),
	(25, 'Главная', '/', '/pages/main.php', NULL, 'main');

-- Дамп структуры для таблица RKOT.rkot_cities
CREATE TABLE IF NOT EXISTS `rkot_cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Города модуля RKOT';

-- Дамп данных таблицы RKOT.rkot_cities: ~2 rows (приблизительно)
INSERT INTO `rkot_cities` (`id`, `name`) VALUES
	(1, 'Хабаровск'),
	(2, 'Новосибирск');

-- Дамп структуры для таблица RKOT.rkot_mobile_operators
CREATE TABLE IF NOT EXISTS `rkot_mobile_operators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы RKOT.rkot_mobile_operators: ~4 rows (приблизительно)
INSERT INTO `rkot_mobile_operators` (`id`, `name`) VALUES
	(1, 'Теле2'),
	(2, 'Билайн'),
	(3, 'Мегафон'),
	(4, 'МТС');

-- Дамп структуры для таблица RKOT.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rules` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`rules`)),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы RKOT.roles: ~2 rows (приблизительно)
INSERT INTO `roles` (`id`, `role`, `rules`) VALUES
	(1, 'Администратор', NULL),
	(2, 'Пользователь', NULL);

-- Дамп структуры для таблица RKOT.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` int(11) DEFAULT NULL,
  `image` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы RKOT.users: ~2 rows (приблизительно)
INSERT INTO `users` (`user_id`, `username`, `name`, `password`, `role`, `image`) VALUES
	(1, 'admin', 'Стововой Алексей Михайлович', '$2y$10$GMwC0fhGntzkC1yWOcdpy.CUdA8.hKQMDcitGNm0jZBRS2yvit28m', 1, NULL),
	(2, 'user', 'Бянкин Александр', '$2y$10$GMwC0fhGntzkC1yWOcdpy.CUdA8.hKQMDcitGNm0jZBRS2yvit28m', 2, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
