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

-- Dumping structure for table db_bpsu_timesheet.attendance
CREATE TABLE IF NOT EXISTS `attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `time_in` varchar(20) DEFAULT NULL,
  `time_out` varchar(20) DEFAULT NULL,
  `remarks` varchar(50) DEFAULT NULL,
  `access_type` varchar(50) DEFAULT NULL COMMENT 'facial recognition or thru password',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.attendance: ~0 rows (approximately)

-- Dumping structure for table db_bpsu_timesheet.auth_assignment
CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `idx-auth_assignment-user_id` (`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_bpsu_timesheet.auth_assignment: ~19 rows (approximately)
INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
	('Administrator', '2', NULL),
	('Administrator', '23', NULL),
	('Administrator', '6', NULL),
	('CompanySupervisor', '15', NULL),
	('CompanySupervisor', '31', NULL),
	('CompanySupervisor', '32', NULL),
	('CompanySupervisor', '33', NULL),
	('CompanySupervisor', '34', NULL),
	('OjtCoordinator', '24', NULL),
	('OjtCoordinator', '25', NULL),
	('OjtCoordinator', '26', NULL),
	('OjtCoordinator', '27', NULL),
	('Trainee', '16', NULL),
	('Trainee', '17', NULL),
	('Trainee', '18', NULL),
	('Trainee', '20', NULL),
	('Trainee', '21', NULL),
	('Trainee', '22', NULL),
	('Trainee', '28', NULL),
	('Trainee', '29', NULL),
	('Trainee', '30', NULL);

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

-- Dumping data for table db_bpsu_timesheet.auth_item: ~45 rows (approximately)
INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
	('access-administrator-index', 2, '', NULL, NULL, NULL, NULL),
	('access-all-index', 2, '', NULL, NULL, NULL, NULL),
	('access-company-supervisor-index', 2, '', NULL, NULL, NULL, NULL),
	('access-ojt-coordinator-index', 2, '', NULL, NULL, NULL, NULL),
	('access-trainee-index', 2, '', NULL, NULL, NULL, NULL),
	('Administrator', 1, '', NULL, NULL, NULL, NULL),
	('CompanySupervisor', 1, '', NULL, NULL, NULL, NULL),
	('create-button-administrator', 2, '', NULL, NULL, NULL, NULL),
	('create-button-company-supervisor', 2, '', NULL, NULL, NULL, NULL),
	('create-button-ojt-coordinator', 2, '', NULL, NULL, NULL, NULL),
	('create-button-trainee', 2, '', NULL, NULL, NULL, NULL),
	('edit-time', 2, '', NULL, NULL, NULL, NULL),
	('menu-map-markers', 2, '', NULL, NULL, NULL, NULL),
	('menu-settings', 2, '', NULL, NULL, NULL, NULL),
	('menu-timesheet', 2, '', NULL, NULL, NULL, NULL),
	('menu-user-management', 2, '', NULL, NULL, NULL, NULL),
	('OjtCoordinator', 1, '', NULL, NULL, NULL, NULL),
	('record-time-in-out', 2, '', NULL, NULL, NULL, NULL),
	('SETTINGS', 2, 'SETTINGS MODULE', NULL, NULL, NULL, NULL),
	('settings-index', 2, '', NULL, NULL, NULL, NULL),
	('settings-list-companies', 2, '', NULL, NULL, NULL, NULL),
	('settings-list-departments', 2, '', NULL, NULL, NULL, NULL),
	('settings-list-majors', 2, '', NULL, NULL, NULL, NULL),
	('settings-list-positions', 2, '', NULL, NULL, NULL, NULL),
	('settings-list-program-course', 2, '', NULL, NULL, NULL, NULL),
	('settings-list-student-section', 2, '', NULL, NULL, NULL, NULL),
	('settings-list-student-year', 2, '', NULL, NULL, NULL, NULL),
	('settings-list-suffix', 2, '', NULL, NULL, NULL, NULL),
	('settings-mapping-tagging-container', 2, '', NULL, NULL, NULL, NULL),
	('settings-permissions', 2, '', NULL, NULL, NULL, NULL),
	('settings-role-assignments', 2, '', NULL, NULL, NULL, NULL),
	('settings-roles', 2, '', NULL, NULL, NULL, NULL),
	('settings-roles-permission-container', 2, '', NULL, NULL, NULL, NULL),
	('settings-user-accounts-form-reference-container', 2, '', NULL, NULL, NULL, NULL),
	('time-in-out', 2, '', NULL, NULL, NULL, NULL),
	('timesheet-remarks', 2, '', NULL, NULL, NULL, NULL),
	('Trainee', 1, '', NULL, NULL, NULL, NULL),
	('upload-others-esig', 2, '', NULL, NULL, NULL, NULL),
	('upload-signature', 2, 'permission to upload signature', NULL, NULL, NULL, NULL),
	('user-management-create', 2, NULL, NULL, NULL, NULL, NULL),
	('user-management-delete', 2, '', NULL, NULL, NULL, NULL),
	('user-management-delete-role-assigned', 2, '', NULL, NULL, NULL, NULL),
	('user-management-index', 2, '', NULL, NULL, NULL, NULL),
	('USER-MANAGEMENT-MODULE', 2, 'access to all permissions of user management', NULL, NULL, NULL, NULL),
	('user-management-update', 2, '', NULL, NULL, NULL, NULL),
	('user-management-upload-file', 2, '', NULL, NULL, NULL, NULL),
	('user-management-view', 2, '', NULL, NULL, NULL, NULL),
	('validate-timesheet', 2, '', NULL, NULL, NULL, NULL),
	('view-other-timesheet', 2, '', NULL, NULL, NULL, NULL);

-- Dumping structure for table db_bpsu_timesheet.auth_item_child
CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_bpsu_timesheet.auth_item_child: ~74 rows (approximately)
INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
	('access-all-index', 'access-administrator-index'),
	('access-all-index', 'access-company-supervisor-index'),
	('access-all-index', 'access-ojt-coordinator-index'),
	('access-all-index', 'access-trainee-index'),
	('Administrator', 'access-all-index'),
	('Administrator', 'create-button-administrator'),
	('Administrator', 'create-button-company-supervisor'),
	('Administrator', 'create-button-ojt-coordinator'),
	('Administrator', 'create-button-trainee'),
	('Administrator', 'menu-map-markers'),
	('Administrator', 'menu-settings'),
	('Administrator', 'menu-user-management'),
	('Administrator', 'SETTINGS'),
	('Administrator', 'settings-index'),
	('Administrator', 'settings-list-companies'),
	('Administrator', 'settings-list-departments'),
	('Administrator', 'settings-list-majors'),
	('Administrator', 'settings-list-positions'),
	('Administrator', 'settings-list-program-course'),
	('Administrator', 'settings-list-student-section'),
	('Administrator', 'settings-list-student-year'),
	('Administrator', 'settings-list-suffix'),
	('Administrator', 'settings-mapping-tagging-container'),
	('Administrator', 'settings-permissions'),
	('Administrator', 'settings-role-assignments'),
	('Administrator', 'settings-roles'),
	('Administrator', 'settings-roles-permission-container'),
	('Administrator', 'settings-user-accounts-form-reference-container'),
	('Administrator', 'upload-others-esig'),
	('Administrator', 'USER-MANAGEMENT-MODULE'),
	('Administrator', 'view-other-timesheet'),
	('CompanySupervisor', 'access-trainee-index'),
	('CompanySupervisor', 'edit-time'),
	('CompanySupervisor', 'menu-user-management'),
	('CompanySupervisor', 'SETTINGS'),
	('CompanySupervisor', 'settings-index'),
	('CompanySupervisor', 'timesheet-remarks'),
	('CompanySupervisor', 'upload-signature'),
	('CompanySupervisor', 'user-management-index'),
	('CompanySupervisor', 'validate-timesheet'),
	('CompanySupervisor', 'view-other-timesheet'),
	('OjtCoordinator', 'access-company-supervisor-index'),
	('OjtCoordinator', 'access-trainee-index'),
	('OjtCoordinator', 'create-button-company-supervisor'),
	('OjtCoordinator', 'create-button-trainee'),
	('OjtCoordinator', 'menu-map-markers'),
	('OjtCoordinator', 'menu-settings'),
	('OjtCoordinator', 'menu-user-management'),
	('OjtCoordinator', 'SETTINGS'),
	('OjtCoordinator', 'settings-index'),
	('OjtCoordinator', 'settings-list-companies'),
	('OjtCoordinator', 'settings-list-departments'),
	('OjtCoordinator', 'settings-list-majors'),
	('OjtCoordinator', 'settings-list-positions'),
	('OjtCoordinator', 'settings-list-program-course'),
	('OjtCoordinator', 'settings-mapping-tagging-container'),
	('OjtCoordinator', 'settings-user-accounts-form-reference-container'),
	('OjtCoordinator', 'user-management-create'),
	('OjtCoordinator', 'user-management-delete'),
	('OjtCoordinator', 'user-management-delete-role-assigned'),
	('OjtCoordinator', 'user-management-index'),
	('OjtCoordinator', 'user-management-update'),
	('OjtCoordinator', 'user-management-upload-file'),
	('OjtCoordinator', 'user-management-view'),
	('OjtCoordinator', 'view-other-timesheet'),
	('SETTINGS', 'settings-index'),
	('SETTINGS', 'settings-list-positions'),
	('Trainee', 'menu-timesheet'),
	('Trainee', 'record-time-in-out'),
	('Trainee', 'time-in-out'),
	('Trainee', 'timesheet-remarks'),
	('Trainee', 'upload-signature'),
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_bpsu_timesheet.files: ~9 rows (approximately)
INSERT INTO `files` (`id`, `user_id`, `model_name`, `model_id`, `file_name`, `extension`, `file_hash`, `remarks`, `created_at`) VALUES
	(2, 2, 'UserData', 4, 'esig3', 'png', '65f7ebb4bf92b7b7bef7e59a25ecbb98', NULL, 1678335075),
	(3, 2, 'UserData', 5, 'esig4', 'png', '4fe59a1eba5fbe2e9380e3fd87f26fe9', NULL, 1678335090),
	(4, 2, 'UserData', 6, 'esig2', 'png', 'e1301f064511d0d59140ab37dbd553f6', NULL, 1678335098),
	(6, 2, 'UserData', 2, 'esig1', 'png', 'cb82b1232e6bd27563d9b4b121f6c506', NULL, 1678335196),
	(7, 2, 'UserData', 9, 'esig2', 'png', 'db8c00be880f4084d57946a7ee2cf1e3', NULL, 1678345294),
	(8, 2, 'UserData', 12, 'esig3', 'png', '66a9e2ea397cbbbf4f9a4b160796a596', NULL, 1678348171),
	(9, 2, 'UserData', 28, 'esig4', 'png', '47e2d40cf57a1028c173b4c50eb61bf7', NULL, 1678957490),
	(10, 31, 'UserData', 31, 'esig1', 'png', '787c4cbba8e7efd94fd124ee927b60af', NULL, 1678975571),
	(11, 20, 'UserData', 20, 'esig4', 'png', 'b12014b1fb25fdf438f40e308225d135', NULL, 1679147038);

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

-- Dumping structure for table db_bpsu_timesheet.post
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `created_at` (`created_at`),
  KEY `user_id` (`user_id`),
  KEY `id` (`id`),
  CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.post: ~0 rows (approximately)

-- Dumping structure for table db_bpsu_timesheet.post_tags
CREATE TABLE IF NOT EXISTS `post_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `ref_program_id` int(11) DEFAULT NULL,
  `ref_program_major_id` int(11) DEFAULT NULL,
  `ref_department_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `ref_department_id` (`ref_department_id`),
  KEY `ref_program_id` (`ref_program_id`),
  KEY `ref_program_major_id` (`ref_program_major_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `post_tags_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `post_tags_ibfk_2` FOREIGN KEY (`ref_department_id`) REFERENCES `ref_department` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `post_tags_ibfk_3` FOREIGN KEY (`ref_program_id`) REFERENCES `ref_program` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `post_tags_ibfk_4` FOREIGN KEY (`ref_program_major_id`) REFERENCES `ref_program_major` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `post_tags_ibfk_5` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.post_tags: ~0 rows (approximately)

-- Dumping structure for table db_bpsu_timesheet.ref_company
CREATE TABLE IF NOT EXISTS `ref_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `contact_info` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.ref_company: ~5 rows (approximately)
INSERT INTO `ref_company` (`id`, `name`, `address`, `latitude`, `longitude`, `contact_info`) VALUES
	(14, 'Sky Cable', 'Sky Cable, Saturn, Mandaluyong, Metro Manila, Philippines', 14.5791861, 121.0249454, ''),
	(17, 'Converge ICT Solutions Inc', 'Converge ICT Solutions Inc, Eulogio Rodriguez Jr. Avenue, Pasig, Metro Manila, Philippines', 14.5779240, 121.0739720, '2343434'),
	(18, 'La Bella Villa Resort', 'La Bella Villa Resort, Bgy, San Baraquiel, St, Valenzuela, Metro Manila, Philippines', 14.7411074, 120.9862269, '2343-12323'),
	(19, 'Accenture Gateway Tower 2', 'Accenture Gateway Tower 2, General Aguinaldo Avenue, Cubao, Quezon City, Metro Manila, Philippines', 14.6226048, 121.0530741, ''),
	(20, 'Emerson Electric (Asia) Ltd.', 'Emerson Electric (Asia) Ltd., Ortigas Center, Pasig, Metro Manila, Philippines', 14.5878487, 121.0617371, '');

-- Dumping structure for table db_bpsu_timesheet.ref_department
CREATE TABLE IF NOT EXISTS `ref_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) DEFAULT NULL,
  `abbreviation` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.ref_department: ~3 rows (approximately)
INSERT INTO `ref_department` (`id`, `title`, `abbreviation`) VALUES
	(1, 'IT Department', ''),
	(2, 'Human Resource Department', ''),
	(3, 'Financial Management Department', '');

-- Dumping structure for table db_bpsu_timesheet.ref_document_type
CREATE TABLE IF NOT EXISTS `ref_document_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.ref_document_type: ~0 rows (approximately)

-- Dumping structure for table db_bpsu_timesheet.ref_position
CREATE TABLE IF NOT EXISTS `ref_position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.ref_position: ~5 rows (approximately)
INSERT INTO `ref_position` (`id`, `position`) VALUES
	(1, 'Software Engineer'),
	(2, 'HR Head'),
	(3, 'HR Staff'),
	(4, 'Financial Specialist'),
	(5, 'Database Administrator');

-- Dumping structure for table db_bpsu_timesheet.ref_program
CREATE TABLE IF NOT EXISTS `ref_program` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) DEFAULT NULL,
  `abbreviation` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.ref_program: ~5 rows (approximately)
INSERT INTO `ref_program` (`id`, `title`, `abbreviation`) VALUES
	(1, 'Bachelor of Science in Information Technology', 'BSIT'),
	(2, 'Bachelor of Science in Computer Science', 'BSCS'),
	(3, 'Bachelor of Science in Computer Engineering', 'BSCE'),
	(4, 'Bachelor of Science in Electronics Engineering', 'BSECE'),
	(5, 'Bachelor of Science in Entrepreneurship Management', 'BSEM');

-- Dumping structure for table db_bpsu_timesheet.ref_program_major
CREATE TABLE IF NOT EXISTS `ref_program_major` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_program_id` int(11) DEFAULT NULL,
  `title` varchar(250) DEFAULT NULL,
  `abbreviation` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `ref_program_id` (`ref_program_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.ref_program_major: ~2 rows (approximately)
INSERT INTO `ref_program_major` (`id`, `ref_program_id`, `title`, `abbreviation`) VALUES
	(1, 1, 'Computer Programming', 'CP'),
	(2, 1, 'Information System', 'IS');

-- Dumping structure for table db_bpsu_timesheet.student_section
CREATE TABLE IF NOT EXISTS `student_section` (
  `section` varchar(5) NOT NULL,
  PRIMARY KEY (`section`),
  UNIQUE KEY `section` (`section`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.student_section: ~5 rows (approximately)
INSERT INTO `student_section` (`section`) VALUES
	('A'),
	('B'),
	('C'),
	('D'),
	('E');

-- Dumping structure for table db_bpsu_timesheet.student_year
CREATE TABLE IF NOT EXISTS `student_year` (
  `year` int(1) NOT NULL,
  `title` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`year`),
  UNIQUE KEY `year` (`year`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.student_year: ~5 rows (approximately)
INSERT INTO `student_year` (`year`, `title`) VALUES
	(1, '1st Year'),
	(2, '2nd Year'),
	(3, '3rd Year'),
	(4, '4th Year'),
	(5, '5th Year');

-- Dumping structure for table db_bpsu_timesheet.submission_thread
CREATE TABLE IF NOT EXISTS `submission_thread` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `ref_document_type_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `ref_document_type_id` (`ref_document_type_id`),
  CONSTRAINT `submission_thread_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `submission_thread_ibfk_2` FOREIGN KEY (`ref_document_type_id`) REFERENCES `ref_document_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.submission_thread: ~0 rows (approximately)

-- Dumping structure for table db_bpsu_timesheet.suffix
CREATE TABLE IF NOT EXISTS `suffix` (
  `title` varchar(10) NOT NULL,
  `meaning` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`title`),
  KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.suffix: ~6 rows (approximately)
INSERT INTO `suffix` (`title`, `meaning`) VALUES
	('II', 'the Second'),
	('III', 'the Third'),
	('IV', 'the Fourth'),
	('Jr.', 'Junior'),
	('Sr.', 'Senior'),
	('V', 'the Fifth');

-- Dumping structure for table db_bpsu_timesheet.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_idno` varchar(50) DEFAULT NULL,
  `student_year` int(1) DEFAULT NULL,
  `student_section` varchar(1) DEFAULT NULL,
  `ref_program_id` int(11) DEFAULT NULL,
  `ref_program_major_id` int(11) DEFAULT NULL,
  `ref_department_id` int(11) DEFAULT NULL,
  `ref_position_id` int(11) DEFAULT NULL,
  `fname` varchar(250) DEFAULT NULL,
  `mname` varchar(150) DEFAULT NULL,
  `sname` varchar(50) DEFAULT NULL,
  `suffix` varchar(10) DEFAULT NULL,
  `bday` date DEFAULT NULL,
  `sex` varchar(1) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `mobile_no` int(10) DEFAULT NULL,
  `tel_no` varchar(150) NOT NULL,
  `address` text DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT 10,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`),
  KEY `id` (`id`),
  KEY `mobile_no` (`mobile_no`),
  KEY `suffix` (`suffix`),
  KEY `student_idno` (`student_idno`),
  KEY `ref_program_id` (`ref_program_id`),
  KEY `ref_program_major_id` (`ref_program_major_id`),
  KEY `ref_department_id` (`ref_department_id`),
  KEY `ref_position_id` (`ref_position_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_bpsu_timesheet.user: ~21 rows (approximately)
INSERT INTO `user` (`id`, `student_idno`, `student_year`, `student_section`, `ref_program_id`, `ref_program_major_id`, `ref_department_id`, `ref_position_id`, `fname`, `mname`, `sname`, `suffix`, `bday`, `sex`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `mobile_no`, `tel_no`, `address`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
	(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Juan', 'Reyes', 'Dela Cruz', NULL, '1995-10-12', 'M', 'admin', 'mLv-KdIB84pIgOrOKnopaaXc51uQml-_', '$2y$13$Mg3jk2B0jWku6FC8vR66i.I1HFd.DrEFuPNv9s1z9QTZDF.73ZUv6', NULL, 'admin@gm.com', NULL, '', NULL, 10, 1678168986, 1678168986, 'alqvh-uTo-NSx86JuSUvY_5iG3xkpOQG_1678168986'),
	(4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kim', '', 'Martinez', NULL, '2013-03-08', 'M', 'kimberjune', 'bx-_6DrWVLfMIFcL8-k0CGC26BOz3VcM', '$2y$13$h7lpx1SzzRtc2KJ901p5a.jbVuRvp8gPB9oZwxJeVQ8rxCOYXvNSy', NULL, 'kimberjune@gm.com', NULL, '', NULL, 10, 0, 0, 'xKBM92taJZO9cPOGj3rWqTFxV7AJDNkC_1678246557'),
	(5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Daniel', '', 'Padilla', NULL, '2013-03-06', 'M', 'deniel', 'hxDbgPXGZO0gakuA3txWWRNhyXni59em', '$2y$13$R4RgHgwzDxpswiMNafbik.gYvtjVAkAn6oGGS9Wckj2gzdNZaxgli', NULL, 'deniel@gm.com', NULL, '', NULL, 10, 0, 0, 'mYTqg1KsP60Preuf65HXCGDQcoL4MFtU_1678246620'),
	(6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'michael', '', 'cortuna', NULL, '2005-03-10', 'M', 'michael', 'oLilpGzQJpOIgtFM1aXYqM2ok_KqkQBO', '$2y$13$X6X3L09c3UulgABB57juGuSMyXWinjxuEywPsj42zn3tU7MLzklEi', NULL, 'michael@gm.com', NULL, '', NULL, 10, 0, 0, 'SaZragbYd24ey-M-75NKQJIdch1xKVNK_1678246940'),
	(9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Jimmy', '', 'Reyes', NULL, '2013-03-05', 'M', 'jim', 'CN7MzQ0oh4UBa7nkjDfEhM8mv1jNkeVZ', '$2y$13$uoHRirwat1nHhm8YblA6VOVf7v293eVs75BZyG5Vyrj7a9.3FuCN2', NULL, 'jim@gmail.com', NULL, '', NULL, 10, 0, 0, 'nVx0wFrsd2FUXw3JeNetkPL-mGmd3P4H_1678344963'),
	(10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Jojo', '', 'Vito', NULL, '2013-03-05', 'M', 'jojo', 'kgnloB8kX1qv5R0N78G0CJIdH1JQcqNb', '$2y$13$kIL70sEYgnrCazTa8vMite4vvwuRPMwXdeeEmC8pnYBP5IrSIgNee', NULL, 'jojo@gm.com', NULL, '', NULL, 10, 0, 0, 'he3TEKOJUefD02o1eDVd1CE7fOBEuups_1678345337'),
	(12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Warren', '', 'Celeste', NULL, '2013-03-05', 'M', 'warren', 'b8b5ohQe2b088Ag4oODLFGuZukUMf9Lf', '$2y$13$0BQ2nKuyj0JepnxthYtxKefTIv1A1g/8saAhcQFstW6OMAreXFpGO', NULL, 'warren@gm.com', NULL, '', NULL, 10, 0, 0, 'srcOj_S0cmMgsrccugdmIcu0aIvBUx7s_1678348138'),
	(13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ken', '', 'Mateo', NULL, '2005-03-10', 'M', 'ken', 'dU_YwJsZbxPpzMhLenmo62G3HUQRQByy', '$2y$13$d6/4LxP7LqGnJM3JJQLyf.XdJpnWfaSau3/Kn4Hb5pgaZc09hEfP.', NULL, 'ken@gm.com', NULL, '', NULL, 10, 0, 0, 'aFFYT7PA5MtXlgmzAwrrYi2kS4Er3kj-_1678434605'),
	(15, NULL, NULL, NULL, NULL, NULL, 2, 2, 'Yael', 'Di Makulangan', 'Yuzon', '', '2005-03-10', 'M', 'asdsd', 'Uas9Q6lT6K2ZleRjQUe7u9-f0STX8fUZ', '$2y$13$o5HF8ta/VDg0f7sn5hd1HekdePk7Jr5dPq7JoksNSUsYOHYzltH3K', NULL, 'sdfdf@gf.com', NULL, '', '', 10, 0, 0, 'Gx2hofcN7X0ltP3xHFAfi0lBd4RgzE6y_1678435021'),
	(20, '1232090', 1, 'B', 1, 1, 1, 1, 'JOHN', 'De Guzman', 'SMOOTH', 'IV', '2005-03-06', 'M', 'trainee', 'a7jMTVWHllh3qnNl9HE4lLBrexdWRYh8', '$2y$13$bBA.7wEkNaHZUm9WTxjoieI8XTckTg2eMoDltOdMeq9Y7eNfil27W', NULL, 'nap@gm.com', 2147483647, '2343434', '12323 address', 10, 0, 0, 'BI5HOKRlYM6YNi6HhzRDRJX7jH7Fu3Xg_1678677157'),
	(21, '2313553', 4, 'B', 1, 2, 1, NULL, 'vilma', '', 'dayagmil', '', '2005-03-06', 'M', 'vilma', 'bQW83W97gNRv8h_OLOQQEcBKt82ZKDtG', '$2y$13$p12B2eY8FRiAArUz1ONr7.bugwXDqwfCjh7diU2YcVSc.BYIbHJQ6', NULL, 'vilma@gm.com', 9232323, 'sdfdf', 'sdfdfd', 10, 0, 0, 'mEhL6bWT6Dms3Cs8-jvfRt8N-D9OqWPL_1678677395'),
	(22, '234343', 4, 'E', 4, NULL, 1, NULL, 'france', '', 'dacales', '', '2005-02-28', 'F', 'france', 'LEH7yRVrvsCkfYGvvykGSekyD_gq3q5S', '$2y$13$oqmSvq5yfCPHkOARf8Wyye5s4WnZjXJ8ilMdqmgFWjXT9hQah8LSK', NULL, 'france@gm.com', 2147483647, '2343434', 'sdfdfd', 10, 0, 0, 'NuE-OGiB9RnY3zRC6Qe7OGar1-Up5vrx_1678677582'),
	(23, NULL, NULL, NULL, 2, NULL, NULL, NULL, 'alvin', '', 'sibaluca', 'II', '2005-03-06', 'M', 'alvin', 'Jt2FFZ4bDd5qIpZXNgDVJgD5zdGcnaAN', '$2y$13$4PWK6Ic8FySi/zmcrSa16O698puS9W3ESCemobfyMHm1/FnJsNj0i', NULL, 'alvin@gm.com', 2147483647, 'tel12323', '031 Elma Stree, Don Fabian,  Brgy. Commonwealth, Quezon City, Metro Manila, 1121', 10, 0, 0, 'ycVi4JFu-nQdW7jEf0KESszpRK-XsFt2_1678687295'),
	(24, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'Nicka', '', 'De Guzman', '', '2005-02-27', 'M', 'coor', '1Veun2dt3r9hnBJQ7Qn0G5H0Tkagzu84', '$2y$13$27LnUZ568Q46.lXRp4yXa.a689gXPsxms76TphmARiO9gbgUVIKqq', NULL, 'nickadg@gm.com', 2147483647, '2323323', 'Tabing Ilog, Malolos, Bulacan', 10, 0, 0, 'DlnHssTWDN0RLchN0Bf_udvgnI7qnM0C_1678689072'),
	(25, NULL, NULL, NULL, 2, NULL, NULL, NULL, 'Marcus', 'dfdf', 'Reyes', 'III', '2005-03-07', 'M', 'marcus', 'mS36TXMKD9ktQFooRCC1a1p6q6NK3qq7', '$2y$13$60UT0u3vkMLSTaMCP6vHG.uaWhFLVTrQQsvKbJEP3gDac.miq.qJS', NULL, 'marcus@gm.com', 2147483647, '1232323', 'fsdfdf', 10, 0, 0, 'EOoPNX67A_NLXRYhBO5xW-_22LSVzd1U_1678689188'),
	(26, NULL, NULL, NULL, 3, NULL, NULL, NULL, 'Leonel', '', 'Coor', 'Jr.', '2005-03-09', 'M', 'leonelcoor', '361qo_APVzQbGJDIs_lE4ZhkvLLfEVkk', '$2y$13$ijx.ka0GfD0WB0glocpag.lpcpMs7RsDJHiV0.TDt2sTPoIdkIJXe', NULL, 'leonelcoor@gm.com', 2147483647, '4342314', 'Elma Street, Comm', 10, 0, 0, '2RVtFc_XyO12dJyLeZNLDHE1-t__S44V_1678689352'),
	(27, NULL, NULL, NULL, 4, NULL, NULL, NULL, 'Romnick', '', 'Alfons', 'III', '2005-03-07', 'M', 'romnickalfons', '4YtvYAdGttEKx2ro_xL25Cr5v4hl8S7N', '$2y$13$2L2AdxFpw/uiu99rp15myev4.KptVpC2180EmucCNZYMnvN9miWhi', NULL, 'romnickalfons@gm.com', 2147483647, '', 'Batangas City', 10, 0, 0, 'mQKXx69OXzkobBHTxn_m7HqO3hOVG8zb_1678689520'),
	(28, '890232', 4, 'A', 5, NULL, 1, NULL, 'Genese', '', 'Luna', '', '2005-03-15', 'F', 'genluna', 'PiowCQ7Fw-U9np-bROC2IsXvT9S2SY0I', '$2y$13$JItdkwe.rjAQqV2ofRJjaeVIp4afiNwBxxov3/CcHWgQ5k/TTMYQ6', NULL, 'genluna@gm.com', 923239232, '123-1232', 'Bocaue, Bulacan', 10, 0, 0, 'Nstb34KJO89hoarjamjI6F0WwMGrhSy9_1678847596'),
	(30, '12-0932323', 4, 'C', 2, NULL, 1, NULL, 'Coco', '', 'Martin', 'IV', '2005-03-07', 'M', 'cocomartin', 'j18zpNSDWoU7FIhBPg8rp8F54wDKvYbb', '$2y$13$SrkIl5Upg5cnC9tHtKu0VetZkr9Tpqd7mzYflToxNshTO5w.AitA2', NULL, 'cocomartin@gm.com', 934343434, '23434', '9123 Coco St. Brgy. Matapang, Bataan', 10, 0, 0, 'MAbkw-ZokCSnRrD3iKD7pz31CvudetfX_1678949188'),
	(31, NULL, NULL, NULL, NULL, NULL, 1, 1, 'Chito', 'Parokya', 'Miranda', '', '2005-03-15', 'F', 'supervisor', 'NiMqkvUJL1-jlIOs3H7Ev6kWEiD4wFdw', '$2y$13$DVoW8H6dS.U6pVz//e4LGuUPr3c1Pxddt3Pk.tOL.v4O7lrNPW3L6', NULL, 'heather@gm.com', 912323232, '454-45454', 'Malolos, Bulacan', 10, 0, 0, '5VPdHej0dhW3AmqIg2uDyLaym6ktx8Wl_1678957717'),
	(32, NULL, NULL, NULL, NULL, NULL, 1, 5, 'La Bella', '', 'Supervisor', '', '2005-03-10', 'M', 'labellacp', 'QXmxsZQpwcOVx3aSJ8oY_5YV4jVVuaJC', '$2y$13$G2dnDGbxEVWyfPBtkrk3duZnkYDMbVeJY1tk3vD46ZTs6hKhx.0G2', NULL, 'labellacoor@gm.com', 912434343, '980-3434', 'Bgy, San Baraqueil, St. Valenzuela', 10, 0, 0, 'AWABYAlcjaRkp7-FA4NJ7VZZ_h3FmmRR_1679100523'),
	(34, NULL, NULL, NULL, NULL, NULL, 2, 3, 'Felix', '', 'Miguel', 'III', '2005-03-07', 'M', 'felix', 'a_VmgqNcHnYNg3RwKMn2mYN7SQnvQ8Wd', '$2y$13$gk9L3iFF3ZxNBrcWE7IY5.QRkEkoIYaCFDa6upkyuqSqR14VfFPKG', NULL, 'felix@gm.com', 923434343, '454-45454', 'Matalino St.', 10, 0, 0, 'MIO5YioffuOwBk-2_yYaOZ9AuHB0zLGH_1679378496');

-- Dumping structure for table db_bpsu_timesheet.user_company
CREATE TABLE IF NOT EXISTS `user_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `ref_company_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `ref_company_id` (`ref_company_id`),
  CONSTRAINT `user_company_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.user_company: ~9 rows (approximately)
INSERT INTO `user_company` (`id`, `user_id`, `ref_company_id`) VALUES
	(2, 20, 19),
	(3, 21, 18),
	(4, 22, 14),
	(5, 28, 17),
	(7, 30, 19),
	(8, 15, 17),
	(9, 31, 19),
	(10, 24, NULL),
	(11, 32, 18),
	(13, 34, 19);

-- Dumping structure for table db_bpsu_timesheet.user_timesheet
CREATE TABLE IF NOT EXISTS `user_timesheet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `time_in_am` time DEFAULT NULL,
  `time_out_am` time DEFAULT NULL,
  `time_in_pm` time DEFAULT NULL,
  `time_out_pm` time DEFAULT NULL,
  `date` date DEFAULT NULL,
  `remarks` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `time_in_am` (`time_in_am`),
  KEY `time_out_am` (`time_out_am`),
  KEY `time_in_pm` (`time_in_pm`),
  KEY `time_out_pm` (`time_out_pm`),
  KEY `date` (`date`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.user_timesheet: ~7 rows (approximately)
INSERT INTO `user_timesheet` (`id`, `user_id`, `time_in_am`, `time_out_am`, `time_in_pm`, `time_out_pm`, `date`, `remarks`, `status`) VALUES
	(12, 20, '08:00:00', '12:00:00', '14:48:13', '20:50:15', '2023-03-16', 'Sample remarks', 0),
	(14, 20, NULL, NULL, '13:14:43', '18:14:00', '2023-03-17', NULL, 1),
	(25, 20, NULL, NULL, '20:54:59', '20:55:21', '2022-03-18', NULL, 0),
	(45, 20, '08:00:00', '12:00:00', '12:30:00', '20:28:40', '2023-03-19', '', 0),
	(46, 20, '08:00:00', '10:00:00', '12:54:11', '13:00:00', '2023-01-19', NULL, 0),
	(47, 21, NULL, NULL, '14:27:47', '14:38:25', '2023-03-20', NULL, 0),
	(48, 20, '09:24:05', '12:00:00', '12:47:55', '17:00:00', '2023-03-21', '', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
