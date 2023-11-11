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
	(1, 'Admin', '{\r\n  "Пользователи": "/admin/users",\r\n  "Страницы": "/admin/pages",\r\n  "РКОТ": {\r\n    "Отчёты": "/admin/pages/rkot/reports",\r\n    "Города": "/admin/pages/rkot/cities",\r\n    "Операторы связи": "/admin/pages/rkot/mobile_operators"\r\n  },\r\n  "Выйти с аккаунта": "/logout"\r\n}'),
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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы RKOT.pages: ~21 rows (приблизительно)
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
	(12, 'РКОТ: Отчёты', '/admin/pages/rkot/reports', '/pages/admin/rkot/reports.php', '[1,2]', 'admin:rkot'),
	(15, 'Api:Modules:RKOT:Cities', '/api/rkot/cities', '/api/modules/rkot/cities.php', '[1,2]', 'api:rkot'),
	(16, 'Api:Modules:RKOT:Mobile_Operators', '/api/rkot/mobile_operators', '/api/modules/rkot/mobile_operators.php', '[1,2]', 'api:rkot'),
	(17, 'Api:Modules:RKOT:Reports', '/api/rkot/reports', '/api/modules/rkot/reports.php', '[1,2]', 'api:rkot'),
	(18, 'Api:Modules:Main:Users', '/api/users', '/api/main/users.php', '', 'api'),
	(19, 'Api:Modules:RKOT:Reports:Data', '/api/rkot/reports/data', '/api/modules/rkot/reports_data.php', '[1,2]', 'api:rkot'),
	(24, 'Api:Modules:Main:Pages', '/api/pages', '/api/main/pages.php', '', 'api'),
	(25, 'Главная', '/', '/pages/main.php', NULL, 'main'),
	(26, 'test', '/test', '/pages/test.php', NULL, NULL),
	(27, 'test', '/testtable', '/pages/testtable.php', NULL, NULL);

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

-- Дамп структуры для таблица RKOT.rkot_reports
CREATE TABLE IF NOT EXISTS `rkot_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` int(11) NOT NULL DEFAULT 0,
  `date_start` int(11) NOT NULL DEFAULT 0,
  `date_end` int(11) NOT NULL DEFAULT 0,
  `city_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__rkot_cities` (`city_id`),
  KEY `FK_rkot_reports_users` (`user_id`),
  CONSTRAINT `FK__rkot_cities` FOREIGN KEY (`city_id`) REFERENCES `rkot_cities` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_rkot_reports_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы RKOT.rkot_reports: ~2 rows (приблизительно)
INSERT INTO `rkot_reports` (`id`, `name`, `date_start`, `date_end`, `city_id`, `user_id`) VALUES
	(1, 2, 1, 1, 1, 1),
	(2, 2, 1, 1, 1, 2);

-- Дамп структуры для таблица RKOT.rkot_reports_data
CREATE TABLE IF NOT EXISTS `rkot_reports_data` (
  `id_report` int(11) DEFAULT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  KEY `FK__rkot_reports` (`id_report`),
  CONSTRAINT `FK__rkot_reports` FOREIGN KEY (`id_report`) REFERENCES `rkot_reports` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы RKOT.rkot_reports_data: ~1 rows (приблизительно)
INSERT INTO `rkot_reports_data` (`id_report`, `data`) VALUES
	(1, '[\r\n    [\r\n        {\r\n            "0": "Показатели качества услуг подвижной радиотелефонной связи в части голосового соединения",\r\n            "2": "Beeline",\r\n            "3": "MegaFon RUS",\r\n            "4": "MTS-RUS",\r\n            "5": "TELE2"\r\n        },\r\n        [\r\n            "Доля неуспешных попыток установления голосового соединения  (Voice Service Non-Acessibility ) [%] ",\r\n            "не более 5",\r\n            0.2941928882067025,\r\n            0.7864726700747149,\r\n            0.43369693783677227,\r\n            0.8062418725617685\r\n        ],\r\n        [\r\n            "Доля обрывов голосовых соединений ( Voice Service Cut-off Ratio) [%]",\r\n            "не более 5",\r\n            0.8376288659793815,\r\n            1.6090425531914894,\r\n            0.6365203553905318,\r\n            0.8722082727633144\r\n        ],\r\n        [\r\n            "Средняя разборчивость речи на соединение (Speech Quality on Call basis (MOS POLQA))",\r\n            "не менее 2,6",\r\n            4.1707148578331825,\r\n            3.886055875352966,\r\n            4.18023008238823,\r\n            4.212120767495408\r\n        ],\r\n        [\r\n            "Доля голосовых соединений с низкой разборчивостью речи (Negative MOS samples Ratio,MOS POLQA < 2,6) [%]",\r\n            " ",\r\n            0.2528581763111102,\r\n            2.5191463729455297,\r\n            0.36151490644160117,\r\n            0.6208030697546937\r\n        ]\r\n    ],\r\n    [\r\n        [\r\n            "Показатели качества услуг подвижной радиотелефонной связи в части передачи коротких текстовых сообщений"\r\n        ],\r\n        [\r\n            "Доля недоставленных SMS сообщений [%]",\r\n            " ",\r\n            2.4,\r\n            4.242424242424242,\r\n            3.4412955465587043,\r\n            6.326530612244898\r\n        ],\r\n        [\r\n            "Среднее время доставки SMS сообщений [сек]",\r\n            " ",\r\n            6.276091028432377,\r\n            7.642689378955696,\r\n            6.09436828485325,\r\n            5.741553479030501\r\n        ]\r\n    ],\r\n    [\r\n        [\r\n            "Показатели качества услуг связи по передаче данных, за исключением услуг связи по передаче данных для целей передачи голосовой информации"\r\n        ],\r\n        {\r\n            "0": "Доля неуспешных сессий по протоколу HTTP (HTTP Session Failure Ratio) [%]",\r\n            "2": 2.161200101703534,\r\n            "3": 1.4733395696913003,\r\n            "4": 2.2454142947501583,\r\n            "5": 3.3399942906080504\r\n        },\r\n        [\r\n            "Среднее значение скорости передачи данных от абонента (HTTP UL Mean User Data Rate) [kbit\\/sec]",\r\n            " ",\r\n            2488.1455125150483,\r\n            1870.449183782878,\r\n            2644.7536430988375,\r\n            2012.078376643705\r\n        ],\r\n        [\r\n            "Среднее значение скорости передачи данных к абоненту (HTTP DL Mean User Data Rate) [kbit\\/sec]",\r\n            "не менее 80",\r\n            9700.979612662122,\r\n            10409.297302806985,\r\n            7504.212544372116,\r\n            9107.286552223888\r\n        ],\r\n        [\r\n            "Продолжительность успешной сессии (HTTP Session Time) [s]",\r\n            " ",\r\n            10.925764036687983,\r\n            12.698537113634828,\r\n            11.65106516713181,\r\n            10.919908157237344\r\n        ]\r\n    ],\r\n    [\r\n        [\r\n            "Справочная информация"\r\n        ],\r\n        [\r\n            "Общее количество тестовых голосовых соединений ",\r\n            " ",\r\n            7818,\r\n            7629,\r\n            7609,\r\n            7690\r\n        ],\r\n        [\r\n            "Общее количество голосовых последовательностей в оцениваемых соединениях (POLQA) ",\r\n            " ",\r\n            147909,\r\n            139452,\r\n            144669,\r\n            145940\r\n        ],\r\n        [\r\n            "Количество голосовых соединений с низкой разборчивостью (Negative MOS samples Count, MOS POLQA<2,6)[%]",\r\n            " ",\r\n            374,\r\n            3513,\r\n            523,\r\n            906\r\n        ],\r\n        [\r\n            "Общее количество отправленных SMS - сообщений",\r\n            " ",\r\n            500,\r\n            495,\r\n            494,\r\n            490\r\n        ],\r\n        [\r\n            "Общее количество попыток соединений с сервером передачи данных HTTP (Загрузка файлов)",\r\n            " ",\r\n            1729,\r\n            1896,\r\n            1456,\r\n            1588\r\n        ],\r\n        [\r\n            "Общее количество тестовых сессий по протоколу HTTP (Web-browsing)",\r\n            " ",\r\n            2204,\r\n            2380,\r\n            1706,\r\n            1915\r\n        ]\r\n    ]\r\n]');

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
