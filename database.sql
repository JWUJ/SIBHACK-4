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


-- Дамп структуры базы данных portal
CREATE DATABASE IF NOT EXISTS `portal` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `portal`;

-- Дамп структуры для таблица portal.certificates
CREATE TABLE IF NOT EXISTS `certificates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `request_date` datetime NOT NULL,
  `status` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employer` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы portal.certificates: ~3 rows (приблизительно)
INSERT INTO `certificates` (`id`, `student_id`, `request_date`, `status`, `employer`, `file`) VALUES
	(27, 1, '2023-11-07 12:08:02', 'Done', 'ХИИК СИБГУТИ', NULL);

-- Дамп структуры для таблица portal.education_type
CREATE TABLE IF NOT EXISTS `education_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы portal.education_type: ~4 rows (приблизительно)
INSERT INTO `education_type` (`id`, `name`) VALUES
	(1, 'Высшее образование очное'),
	(2, 'Высшее образование заочное'),
	(3, 'Среднее образование очное'),
	(4, 'Среднее образование заочное');

-- Дамп структуры для таблица portal.files
CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT 0,
  `filename` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user_id`),
  CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы portal.files: ~0 rows (приблизительно)

-- Дамп структуры для таблица portal.groups
CREATE TABLE IF NOT EXISTS `groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `education_type` int(11) NOT NULL,
  `сourse` int(11) DEFAULT 1,
  `session_start` date DEFAULT NULL,
  `session_end` date DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы portal.groups: ~4 rows (приблизительно)
INSERT INTO `groups` (`group_id`, `group_name`, `education_type`, `сourse`, `session_start`, `session_end`) VALUES
	(1, 'Group A', 1, 1, '2023-11-06', '2023-12-10'),
	(2, 'Group B', 2, 2, NULL, NULL),
	(3, 'Group C', 3, 3, NULL, NULL),
	(4, 'Group D', 4, 4, NULL, NULL);

-- Дамп структуры для таблица portal.journal
CREATE TABLE IF NOT EXISTS `journal` (
  `journal_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `grade` int(11) DEFAULT NULL,
  `attendance` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attached_files` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`journal_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы portal.journal: ~3 rows (приблизительно)
INSERT INTO `journal` (`journal_id`, `student_id`, `schedule_id`, `grade`, `attendance`, `attached_files`) VALUES
	(1, 1, 1, 95, 'Present', 'math_homework.pdf'),
	(2, 2, 1, 90, 'Present', 'math_homework.pdf'),
	(3, 1, 2, 88, 'Present', 'physics_lab_report.pdf');

-- Дамп структуры для таблица portal.menus
CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`items`)),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы portal.menus: ~4 rows (приблизительно)
INSERT INTO `menus` (`id`, `name`, `items`) VALUES
	(1, 'Main', '{\n  "Справки": "/documents",\n  "Расписание": "/schedule"\n}'),
	(2, 'User', '{\r\n    "Профиль": "/profile",\r\n    "Настройки": "/settings",\r\n    "Перейти в ЭИОС": "do.hiik.ru",\r\n    "Выйти": "/logout"\r\n  }'),
	(3, 'Admin', '{\r\n  "Пользователи": "/admin/users",\r\n  "Страницы": "/admin/pages",\r\n  "Учебный отдел": {\r\n    "Расписание занятий": "/admin/schedule",\r\n    "Справки": "/admin/certificates"\r\n  }\r\n}'),
	(4, 'Main_logged', '{\r\n  "Главная": "/test",\r\n  "Пунт 2": "/test",\r\n  "Сабменю": {\r\n    "Пунт 1asdasdsda": "/test",\r\n    "Пунт 2": "/test"\r\n  },\r\n  "Пунт 3": "/test",\r\n  "sdfsdfsdf": "/test"\r\n}');

-- Дамп структуры для таблица portal.pages
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `type` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы portal.pages: ~24 rows (приблизительно)
INSERT INTO `pages` (`id`, `page`, `url`, `location`, `roles`, `type`) VALUES
	(1, 'Администратор: Главная', '/admin', '/pages/admin/main.php', '[1,2]', 'admin'),
	(2, 'Администратор: Управление пользователями', '/admin/users', '/pages/admin/users.php', '[1]', 'admin'),
	(3, 'Администратор: Страницы', '/admin/pages', '/pages/admin/pages.php', '[1]', 'admin'),
	(4, 'Администратор: Редактирирование страницы', '/admin/pages/editor', '/pages/admin/editor.php', '[1]', 'admin'),
	(5, 'Api:Main:Roles', '/api/roles', '/api/main/roles.php', '', 'api'),
	(6, 'Api:Main:Files:Get TODO', '/api/getfile', '/pages/admin/api/getfile.php', '[1,2]', 'api'),
	(7, 'Главная страницца', '/', '/pages/main.php', NULL, NULL),
	(8, '404', '/404', '/pages/404.php', NULL, NULL),
	(9, 'Вход', '/auth', '/pages/auth/login.php', NULL, NULL),
	(10, 'Выйти из аккаунта', '/logout', '/pages/auth/logout.php', NULL, NULL),
	(11, 'Учебный отдел: Расписание занятий', '/admin/schedule', '/pages/admin/dean/schedule.php', '[1,2]', 'dean'),
	(12, 'Учебный отдел: Справки', '/admin/certificates', '/pages/admin/dean/certificates.php', '[1,2]', 'dean'),
	(13, 'Расписание', '/schedule', '/pages/main/schedule.php', '', NULL),
	(14, 'Документы', '/documents', '/pages/main/documents.php', '[1,3]', NULL),
	(15, 'Api:Modules:Dean:Certs:Call', '/api/dean/certificates', '/api/modules/dean/certificates/certificates.php', NULL, 'api'),
	(16, 'Test', '/test', '/pages/test.php', NULL, NULL),
	(17, 'Профиль', '/profile', '/pages/profile.php', NULL, NULL),
	(18, 'Api:Main:Users', '/api/users', '/api/main/users.php', '', 'api'),
	(19, 'Api:Modules:Dean:Schedule', '/api/dean/schedule', '/api/modules/dean/schedule.php', '', 'api'),
	(20, 'Api:Modules:Dean:Groups', '/api/dean/groups', '/api/modules/dean/groups.php', '', 'api'),
	(21, 'Api:Modules:Dean:Teachers', '/api/dean/teachers', '/api/modules/dean/teachers.php', '', 'api'),
	(22, 'Api:Modules:Dean:EduTypes', '/api/dean/edutype', '/api/modules/dean/edutypes.php', '', 'api'),
	(23, 'Api:Modules:Dean:Subjects', '/api/dean/subjects', '/api/modules/dean/subjects.php', '', 'api'),
	(24, 'Api:Main:Pages', '/api/pages', '/api/main/pages.php', '', 'api');

-- Дамп структуры для таблица portal.portfolio
CREATE TABLE IF NOT EXISTS `portfolio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы portal.portfolio: ~0 rows (приблизительно)

-- Дамп структуры для таблица portal.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rules` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`rules`)),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы portal.roles: ~4 rows (приблизительно)
INSERT INTO `roles` (`id`, `role`, `rules`) VALUES
	(1, 'Администратор', NULL),
	(2, 'Учебный отдел', NULL),
	(3, 'Студент', NULL),
	(4, 'Преподаватель', NULL);

-- Дамп структуры для таблица portal.schedules
CREATE TABLE IF NOT EXISTS `schedules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `day_of_week` int(11) NOT NULL,
  `time` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` int(11) NOT NULL DEFAULT 0,
  `office` int(11) DEFAULT NULL,
  `fraction` int(11) DEFAULT NULL,
  `type` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы portal.schedules: ~7 rows (приблизительно)
INSERT INTO `schedules` (`id`, `group_id`, `teacher_id`, `day_of_week`, `time`, `subject_id`, `office`, `fraction`, `type`) VALUES
	(32, 1, 4, 1, '1', 1, 222, 2, 'Лабз'),
	(37, 1, 3, 1, '5', 1, 444, 1, 'Лабз'),
	(39, 1, 4, 2, '4', 2, 434, 1, 'Пз'),
	(40, 1, 4, 2, '3', 2, 434, 1, 'Пз'),
	(42, 1, 4, 3, '5', 2, 434, 2, 'Пз'),
	(43, 2, 3, 1, '4', 3, 434, 1, 'Лабз'),
	(44, 1, 3, 6, '5', 3, 333, 2, 'Пз');

-- Дамп структуры для таблица portal.subjects
CREATE TABLE IF NOT EXISTS `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teachers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`teachers`)),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы portal.subjects: ~3 rows (приблизительно)
INSERT INTO `subjects` (`id`, `name`, `teachers`) VALUES
	(1, 'Философия', NULL),
	(2, 'История', NULL),
	(3, 'История России', NULL);

-- Дамп структуры для таблица portal.users
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

-- Дамп данных таблицы portal.users: ~11 rows (приблизительно)
INSERT INTO `users` (`user_id`, `username`, `name`, `password`, `role`, `image`) VALUES
	(1, 'admin', 'Стововой Алексей Михайлович', '$2y$10$GMwC0fhGntzkC1yWOcdpy.CUdA8.hKQMDcitGNm0jZBRS2yvit28m', 1, NULL),
	(2, 'student2', 'Ntcn', 'student2password', 3, NULL),
	(3, 'teacher1', 'Данилов Роман Михайлович', 'teacher1password', 4, NULL),
	(4, 'teacher2', 'Киреев Сергей Викторович', 'teacher2password', 4, NULL),
	(5, 'student1', '', 'student1password', 3, NULL),
	(6, 'methodist1', '', '$2y$10$dnU1a7YlEMJj56/ZwML06e7o7pbmP6kzwMKYr8mJri25soSVvQ0aq', 2, NULL),
	(7, 'methodist2', '', 'methodist2password', 2, NULL),
	(8, 'methodist3', 'hgfgh', 'methodist2password', 2, NULL),
	(9, 'methodist4', 'hgfgh', 'methodist2password', 2, NULL),
	(10, 'methodist5', 'hgfgh', 'methodist2password', 2, NULL),
	(11, 'methodist6', 'hgfgh', 'methodist2password', 2, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
