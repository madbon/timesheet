-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.27-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.4.0.6659
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table db_bpsu_timesheet.address
CREATE TABLE IF NOT EXISTS `address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_info_id` int(11) DEFAULT NULL,
  `region_c` varchar(2) DEFAULT NULL,
  `province_c` varchar(3) DEFAULT NULL,
  `citymun_c` varchar(3) DEFAULT NULL,
  `barangay_c` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_info_id` (`user_info_id`),
  KEY `id` (`id`),
  KEY `region_c` (`region_c`),
  KEY `province_c` (`province_c`),
  KEY `citymun_c` (`citymun_c`),
  KEY `barangay_c` (`barangay_c`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_bpsu_timesheet.address: ~0 rows (approximately)

-- Dumping structure for table db_bpsu_timesheet.auth_assignment
CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `idx-auth_assignment-user_id` (`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_bpsu_timesheet.auth_assignment: ~1 rows (approximately)
INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
	('Administrator', '2', NULL),
	('Administrator', '6', NULL),
	('CompanySupervisor', '15', NULL);

-- Dumping structure for table db_bpsu_timesheet.auth_item
CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text DEFAULT NULL,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_bpsu_timesheet.auth_item: ~12 rows (approximately)
INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
	('Administrator', 1, '', NULL, NULL, NULL, NULL),
	('CompanySupervisor', 1, '', NULL, NULL, NULL, NULL),
	('OjtCoordinator', 1, '', NULL, NULL, NULL, NULL),
	('Trainee', 1, '', NULL, NULL, NULL, NULL),
	('user-management-create', 2, NULL, NULL, NULL, NULL, NULL),
	('user-management-delete', 2, '', NULL, NULL, NULL, NULL),
	('user-management-delete-role-assigned', 2, '', NULL, NULL, NULL, NULL),
	('user-management-index', 2, '', NULL, NULL, NULL, NULL),
	('USER-MANAGEMENT-MODULE', 2, 'access to all permissions of user management', NULL, NULL, NULL, NULL),
	('user-management-update', 2, '', NULL, NULL, NULL, NULL),
	('user-management-upload-file', 2, '', NULL, NULL, NULL, NULL),
	('user-management-view', 2, '', NULL, NULL, NULL, NULL);

-- Dumping structure for table db_bpsu_timesheet.auth_item_child
CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_bpsu_timesheet.auth_item_child: ~6 rows (approximately)
INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
	('Administrator', 'USER-MANAGEMENT-MODULE'),
	('USER-MANAGEMENT-MODULE', 'user-management-create'),
	('USER-MANAGEMENT-MODULE', 'user-management-delete'),
	('USER-MANAGEMENT-MODULE', 'user-management-delete-role-assigned'),
	('USER-MANAGEMENT-MODULE', 'user-management-index'),
	('USER-MANAGEMENT-MODULE', 'user-management-update'),
	('USER-MANAGEMENT-MODULE', 'user-management-upload-file'),
	('USER-MANAGEMENT-MODULE', 'user-management-view');

-- Dumping structure for table db_bpsu_timesheet.auth_rule
CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_bpsu_timesheet.auth_rule: ~0 rows (approximately)

-- Dumping structure for table db_bpsu_timesheet.cms_actions
CREATE TABLE IF NOT EXISTS `cms_actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_bpsu_timesheet.cms_actions: ~0 rows (approximately)

-- Dumping structure for table db_bpsu_timesheet.cms_role
CREATE TABLE IF NOT EXISTS `cms_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role` (`title`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_bpsu_timesheet.cms_role: ~3 rows (approximately)
INSERT INTO `cms_role` (`id`, `title`) VALUES
	(1, 'Administrator'),
	(2, 'Coordinator'),
	(3, 'Trainee');

-- Dumping structure for table db_bpsu_timesheet.cms_role_actions
CREATE TABLE IF NOT EXISTS `cms_role_actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cms_role_id` int(11) DEFAULT NULL,
  `cms_actions_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `cms_role_id` (`cms_role_id`),
  KEY `cms_actions_id` (`cms_actions_id`),
  CONSTRAINT `cms_role_actions_ibfk_1` FOREIGN KEY (`cms_role_id`) REFERENCES `cms_role` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `cms_role_actions_ibfk_2` FOREIGN KEY (`cms_actions_id`) REFERENCES `cms_actions` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_bpsu_timesheet.cms_role_actions: ~0 rows (approximately)

-- Dumping structure for table db_bpsu_timesheet.cms_role_assignment
CREATE TABLE IF NOT EXISTS `cms_role_assignment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `cms_role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `cms_role_id` (`cms_role_id`),
  KEY `id` (`id`),
  CONSTRAINT `cms_role_assignment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_bpsu_timesheet.cms_role_assignment: ~7 rows (approximately)
INSERT INTO `cms_role_assignment` (`id`, `user_id`, `cms_role_id`) VALUES
	(1, NULL, 0),
	(2, 12, 2),
	(3, 2, 3),
	(4, 4, 2),
	(5, 9, 2),
	(6, 5, 3),
	(7, 6, 3);

-- Dumping structure for table db_bpsu_timesheet.contact_info
CREATE TABLE IF NOT EXISTS `contact_info` (
  `id` int(11) NOT NULL,
  `user_info_id` int(10) DEFAULT NULL,
  `mobile_no` int(10) DEFAULT NULL,
  `landline_no` varchar(25) DEFAULT NULL,
  `email_add` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_info_id` (`user_info_id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_bpsu_timesheet.contact_info: ~0 rows (approximately)

-- Dumping structure for table db_bpsu_timesheet.files
CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `model_name` varchar(50) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `file_name` varchar(250) DEFAULT NULL,
  `extension` varchar(10) DEFAULT NULL,
  `file_hash` varchar(150) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `id` (`id`),
  KEY `model_id` (`model_id`),
  KEY `created_at` (`created_at`),
  CONSTRAINT `files_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_bpsu_timesheet.files: ~6 rows (approximately)
INSERT INTO `files` (`id`, `user_id`, `model_name`, `model_id`, `file_name`, `extension`, `file_hash`, `remarks`, `created_at`) VALUES
	(2, 2, 'UserData', 4, 'esig3', 'png', '65f7ebb4bf92b7b7bef7e59a25ecbb98', NULL, 1678335075),
	(3, 2, 'UserData', 5, 'esig4', 'png', '4fe59a1eba5fbe2e9380e3fd87f26fe9', NULL, 1678335090),
	(4, 2, 'UserData', 6, 'esig2', 'png', 'e1301f064511d0d59140ab37dbd553f6', NULL, 1678335098),
	(6, 2, 'UserData', 2, 'esig1', 'png', 'cb82b1232e6bd27563d9b4b121f6c506', NULL, 1678335196),
	(7, 2, 'UserData', 9, 'esig2', 'png', 'db8c00be880f4084d57946a7ee2cf1e3', NULL, 1678345294),
	(8, 2, 'UserData', 12, 'esig3', 'png', '66a9e2ea397cbbbf4f9a4b160796a596', NULL, 1678348171);

-- Dumping structure for table db_bpsu_timesheet.migration
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_bpsu_timesheet.migration: ~7 rows (approximately)
INSERT INTO `migration` (`version`, `apply_time`) VALUES
	('m000000_000000_base', 1678168164),
	('m130524_201442_init', 1678168169),
	('m140506_102106_rbac_init', 1678417445),
	('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1678417445),
	('m180523_151638_rbac_updates_indexes_without_prefix', 1678417445),
	('m190124_110200_add_verification_token_column_to_user_table', 1678168169),
	('m200409_110543_rbac_update_mssql_trigger', 1678417445);

-- Dumping structure for table db_bpsu_timesheet.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(250) DEFAULT NULL,
  `mname` varchar(150) DEFAULT NULL,
  `sname` varchar(50) DEFAULT NULL,
  `bday` date DEFAULT NULL,
  `sex` varchar(1) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT 10,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_bpsu_timesheet.user: ~7 rows (approximately)
INSERT INTO `user` (`id`, `fname`, `mname`, `sname`, `bday`, `sex`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
	(2, 'Juan', 'Reyes', 'Dela Cruz', '1995-10-12', 'M', 'admin', 'mLv-KdIB84pIgOrOKnopaaXc51uQml-_', '$2y$13$Mg3jk2B0jWku6FC8vR66i.I1HFd.DrEFuPNv9s1z9QTZDF.73ZUv6', NULL, 'admin@gm.com', 10, 1678168986, 1678168986, 'alqvh-uTo-NSx86JuSUvY_5iG3xkpOQG_1678168986'),
	(4, 'Kim', '', 'Martinez', '2013-03-08', 'M', 'kimberjune', 'bx-_6DrWVLfMIFcL8-k0CGC26BOz3VcM', '$2y$13$h7lpx1SzzRtc2KJ901p5a.jbVuRvp8gPB9oZwxJeVQ8rxCOYXvNSy', NULL, 'kimberjune@gm.com', 10, 0, 0, 'xKBM92taJZO9cPOGj3rWqTFxV7AJDNkC_1678246557'),
	(5, 'Daniel', '', 'Padilla', '2013-03-06', 'M', 'deniel', 'hxDbgPXGZO0gakuA3txWWRNhyXni59em', '$2y$13$R4RgHgwzDxpswiMNafbik.gYvtjVAkAn6oGGS9Wckj2gzdNZaxgli', NULL, 'deniel@gm.com', 10, 0, 0, 'mYTqg1KsP60Preuf65HXCGDQcoL4MFtU_1678246620'),
	(6, 'michael', '', 'cortuna', '2005-03-10', 'M', 'michael', 'oLilpGzQJpOIgtFM1aXYqM2ok_KqkQBO', '$2y$13$X6X3L09c3UulgABB57juGuSMyXWinjxuEywPsj42zn3tU7MLzklEi', NULL, 'michael@gm.com', 10, 0, 0, 'SaZragbYd24ey-M-75NKQJIdch1xKVNK_1678246940'),
	(9, 'Jimmy', '', 'Reyes', '2013-03-05', 'M', 'jim', 'CN7MzQ0oh4UBa7nkjDfEhM8mv1jNkeVZ', '$2y$13$uoHRirwat1nHhm8YblA6VOVf7v293eVs75BZyG5Vyrj7a9.3FuCN2', NULL, 'jim@gmail.com', 10, 0, 0, 'nVx0wFrsd2FUXw3JeNetkPL-mGmd3P4H_1678344963'),
	(10, 'Jojo', '', 'Vito', '2013-03-05', 'M', 'jojo', 'kgnloB8kX1qv5R0N78G0CJIdH1JQcqNb', '$2y$13$kIL70sEYgnrCazTa8vMite4vvwuRPMwXdeeEmC8pnYBP5IrSIgNee', NULL, 'jojo@gm.com', 10, 0, 0, 'he3TEKOJUefD02o1eDVd1CE7fOBEuups_1678345337'),
	(12, 'Warren', '', 'Celeste', '2013-03-05', 'M', 'warren', 'b8b5ohQe2b088Ag4oODLFGuZukUMf9Lf', '$2y$13$0BQ2nKuyj0JepnxthYtxKefTIv1A1g/8saAhcQFstW6OMAreXFpGO', NULL, 'warren@gm.com', 10, 0, 0, 'srcOj_S0cmMgsrccugdmIcu0aIvBUx7s_1678348138'),
	(13, 'Ken', '', 'Mateo', '2005-03-10', 'M', 'ken', 'dU_YwJsZbxPpzMhLenmo62G3HUQRQByy', '$2y$13$d6/4LxP7LqGnJM3JJQLyf.XdJpnWfaSau3/Kn4Hb5pgaZc09hEfP.', NULL, 'ken@gm.com', 10, 0, 0, 'aFFYT7PA5MtXlgmzAwrrYi2kS4Er3kj-_1678434605'),
	(15, 'sdfdfd', 'fdfd', 'fdfdf', '2005-03-10', 'M', 'asdsd', 'Uas9Q6lT6K2ZleRjQUe7u9-f0STX8fUZ', '$2y$13$o5HF8ta/VDg0f7sn5hd1HekdePk7Jr5dPq7JoksNSUsYOHYzltH3K', NULL, 'sdfdf@gf.com', 10, 0, 0, 'Gx2hofcN7X0ltP3xHFAfi0lBd4RgzE6y_1678435021');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
