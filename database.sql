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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы RKOT.menus: ~2 rows (приблизительно)
INSERT INTO `menus` (`id`, `name`, `items`) VALUES
	(1, 'Admin', '{\r\n  "Пользователи": "/admin/users",\r\n  "Страницы": "/admin/pages",\r\n  "РКОТ": {\r\n    "Отчёты": "/admin/pages/rkot/reports"\r\n  },\r\n  "Выйти с аккаунта": "/logout"\r\n}'),
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

-- Дамп данных таблицы RKOT.pages: ~17 rows (приблизительно)
INSERT INTO `pages` (`id`, `page`, `url`, `location`, `roles`, `type`) VALUES
	(1, 'Администратор: Главная', '/admin', '/pages/admin/main.php', '[1,2]', 'admin'),
	(2, 'Администратор: Управление пользователями', '/admin/users', '/pages/admin/users.php', '[1]', 'admin'),
	(3, 'Администратор: Страницы', '/admin/pages', '/pages/admin/pages.php', '[1]', 'admin'),
	(4, 'Администратор: Редактирирование страницы', '/admin/pages/editor', '/pages/admin/editor.php', '[1]', 'admin'),
	(5, 'Api:Modules:Main:Roles', '/api/roles', '/api/main/roles.php', '', 'api'),
	(6, 'Api:Modules:Main:Files:Get TODO', '/api/getfile', '/pages/admin/api/getfile.php', '[1,2]', 'api'),
	(8, '404', '/404', '/pages/404.php', NULL, 'main'),
	(9, 'Вход', '/auth', '/pages/auth/login.php', NULL, 'main'),
	(10, 'Выйти из аккаунта', '/logout', '/pages/auth/logout.php', NULL, 'main'),
	(12, 'РКОТ: Отчёты', '/admin/pages/rkot/reports', '/pages/admin/rkot/reports.php', '[1,2]', 'admin:rkot'),
	(13, 'РКОТ: Отчёт', '/admin/pages/rkot/report', '/pages/admin/rkot/report.php', '[1,2]', 'admin:rkot'),
	(17, 'Api:Modules:RKOT:Reports', '/api/rkot/reports', '/api/modules/rkot/reports.php', '[1,2]', 'api:rkot'),
	(18, 'Api:Modules:Main:Users', '/api/users', '/api/main/users.php', '', 'api'),
	(19, 'Api:Modules:RKOT:Reports:Data', '/api/rkot/reports/data', '/api/modules/rkot/reports_data.php', '[1,2]', 'api:rkot'),
	(23, 'Информация', '/info', '/pages/info.php', NULL, NULL),
	(24, 'Api:Modules:Main:Pages', '/api/pages', '/api/main/pages.php', '', 'api'),
	(25, 'Главная', '/', '/pages/main.php', NULL, 'main');

-- Дамп структуры для таблица RKOT.rkot_reports
CREATE TABLE IF NOT EXISTS `rkot_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_start` tinytext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_end` tinytext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rkot_reports_users` (`user_id`),
  CONSTRAINT `FK_rkot_reports_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы RKOT.rkot_reports: ~1 rows (приблизительно)
INSERT INTO `rkot_reports` (`id`, `name`, `date_start`, `date_end`, `city`, `district`, `user_id`) VALUES
	(1, '№32 от 24 июля 2019', '03.06.2019', '23.07.2019', 'г. Екатеринбург', 'УРАЛЬСКОМ ФЕДЕРАЛЬНОМ ОКРУГЕ', NULL);

-- Дамп структуры для таблица RKOT.rkot_reports_data
CREATE TABLE IF NOT EXISTS `rkot_reports_data` (
  `id_report` int(11) DEFAULT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  KEY `FK__rkot_reports` (`id_report`),
  CONSTRAINT `FK__rkot_reports` FOREIGN KEY (`id_report`) REFERENCES `rkot_reports` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы RKOT.rkot_reports_data: ~1 rows (приблизительно)
INSERT INTO `rkot_reports_data` (`id_report`, `data`) VALUES
	(1, '[\n    [\n        {\n            "0": "Показатели качества услуг подвижной радиотелефонной связи в части голосового соединения",\n            "2": "Beeline",\n            "3": "MegaFon RUS",\n            "4": "MTS-RUS",\n            "5": "TELE2"\n        },\n        [\n            "Доля неуспешных попыток установления голосового соединения  (Voice Service Non-Acessibility ) [%] ",\n            "не более 5",\n            0.2941928882067025,\n            0.7864726700747149,\n            0.43369693783677227,\n            0.8062418725617685\n        ],\n        [\n            "Доля обрывов голосовых соединений ( Voice Service Cut-off Ratio) [%]",\n            "не более 5",\n            0.8376288659793815,\n            1.6090425531914894,\n            0.6365203553905318,\n            0.8722082727633144\n        ],\n        [\n            "Средняя разборчивость речи на соединение (Speech Quality on Call basis (MOS POLQA))",\n            "не менее 2,6",\n            4.1707148578331825,\n            3.886055875352966,\n            4.18023008238823,\n            4.212120767495408\n        ],\n        [\n            "Доля голосовых соединений с низкой разборчивостью речи (Negative MOS samples Ratio,MOS POLQA < 2,6) [%]",\n            " ",\n            0.2528581763111102,\n            2.5191463729455297,\n            0.36151490644160117,\n            0.6208030697546937\n        ]\n    ],\n    [\n        [\n            "Показатели качества услуг подвижной радиотелефонной связи в части передачи коротких текстовых сообщений"\n        ],\n        [\n            "Доля недоставленных SMS сообщений [%]",\n            " ",\n            2.4,\n            4.242424242424242,\n            3.4412955465587043,\n            6.326530612244898\n        ],\n        [\n            "Среднее время доставки SMS сообщений [сек]",\n            " ",\n            6.276091028432377,\n            7.642689378955696,\n            6.09436828485325,\n            5.741553479030501\n        ]\n    ],\n    [\n        [\n            "Показатели качества услуг связи по передаче данных, за исключением услуг связи по передаче данных для целей передачи голосовой информации"\n        ],\n        {\n            "0": "Доля неуспешных сессий по протоколу HTTP (HTTP Session Failure Ratio) [%]",\n            "2": 2.161200101703534,\n            "3": 1.4733395696913003,\n            "4": 2.2454142947501583,\n            "5": 3.3399942906080504\n        },\n        [\n            "Среднее значение скорости передачи данных от абонента (HTTP UL Mean User Data Rate) [kbit/sec]",\n            " ",\n            2488.1455125150483,\n            1870.449183782878,\n            2644.7536430988375,\n            2012.078376643705\n        ],\n        [\n            "Среднее значение скорости передачи данных к абоненту (HTTP DL Mean User Data Rate) [kbit/sec]",\n            "не менее 80",\n            9700.979612662122,\n            10409.297302806985,\n            7504.212544372116,\n            9107.286552223888\n        ],\n        [\n            "Продолжительность успешной сессии (HTTP Session Time) [s]",\n            " ",\n            10.925764036687983,\n            12.698537113634828,\n            11.65106516713181,\n            10.919908157237344\n        ]\n    ],\n    [\n        [\n            "Справочная информация"\n        ],\n        [\n            "Общее количество тестовых голосовых соединений ",\n            " ",\n            7818,\n            7629,\n            7609,\n            7690\n        ],\n        [\n            "Общее количество голосовых последовательностей в оцениваемых соединениях (POLQA) ",\n            " ",\n            147909,\n            139452,\n            144669,\n            145940\n        ],\n        [\n            "Количество голосовых соединений с низкой разборчивостью (Negative MOS samples Count, MOS POLQA<2,6)[%]",\n            " ",\n            374,\n            3513,\n            523,\n            906\n        ],\n        [\n            "Общее количество отправленных SMS - сообщений",\n            " ",\n            500,\n            495,\n            494,\n            490\n        ],\n        [\n            "Общее количество попыток соединений с сервером передачи данных HTTP (Загрузка файлов)",\n            " ",\n            1729,\n            1896,\n            1456,\n            1588\n        ],\n        [\n            "Общее количество тестовых сессий по протоколу HTTP (Web-browsing)",\n            " ",\n            2204,\n            2380,\n            1706,\n            1915\n        ]\n    ]\n]');

-- Дамп структуры для таблица RKOT.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rules` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`rules`)),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Дамп данных таблицы RKOT.users: ~1 rows (приблизительно)
INSERT INTO `users` (`user_id`, `username`, `name`, `password`, `role`) VALUES
	(1, 'admin', 'Администратор', '$2y$10$GMwC0fhGntzkC1yWOcdpy.CUdA8.hKQMDcitGNm0jZBRS2yvit28m', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
