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

-- Dumping structure for table db_bpsu_timesheet.auth_assignment
CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `idx-auth_assignment-user_id` (`user_id`),
  KEY `item_name` (`item_name`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_bpsu_timesheet.auth_assignment: ~1 rows (approximately)
INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
	('Administrator', '2', NULL);

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
  KEY `name` (`name`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_bpsu_timesheet.auth_item: ~60 rows (approximately)
INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
	('access-administrator-index', 2, '', NULL, NULL, NULL, NULL),
	('access-all-index', 2, '', NULL, NULL, NULL, NULL),
	('access-company-supervisor-index', 2, '', NULL, NULL, NULL, NULL),
	('access-ojt-coordinator-index', 2, '', NULL, NULL, NULL, NULL),
	('access-trainee-index', 2, '', NULL, NULL, NULL, NULL),
	('Administrator', 1, '', NULL, NULL, NULL, NULL),
	('CompanySupervisor', 1, '', NULL, NULL, NULL, NULL),
	('create-activity-reminder', 2, '', NULL, NULL, NULL, NULL),
	('create-button-administrator', 2, '', NULL, NULL, NULL, NULL),
	('create-button-company-supervisor', 2, '', NULL, NULL, NULL, NULL),
	('create-button-ojt-coordinator', 2, '', NULL, NULL, NULL, NULL),
	('create-button-trainee', 2, '', NULL, NULL, NULL, NULL),
	('create-transaction', 2, '', NULL, NULL, NULL, NULL),
	('edit-time', 2, '', NULL, NULL, NULL, NULL),
	('menu-map-markers', 2, '', NULL, NULL, NULL, NULL),
	('menu-settings', 2, '', NULL, NULL, NULL, NULL),
	('menu-tasks', 2, '', NULL, NULL, NULL, NULL),
	('menu-timesheet', 2, '', NULL, NULL, NULL, NULL),
	('menu-user-management', 2, '', NULL, NULL, NULL, NULL),
	('OjtCoordinator', 1, '', NULL, NULL, NULL, NULL),
	('receive_accomplishment_report', 2, 'Permission to Receive accomplishment report', NULL, NULL, NULL, NULL),
	('receive_trainees_activity', 2, '', NULL, NULL, NULL, NULL),
	('receive_trainees_evaluation', 2, '', NULL, NULL, NULL, NULL),
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
	('settings-list-task-type', 2, '', NULL, NULL, NULL, NULL),
	('settings-mapping-tagging-container', 2, '', NULL, NULL, NULL, NULL),
	('settings-permissions', 2, '', NULL, NULL, NULL, NULL),
	('settings-role-assignments', 2, '', NULL, NULL, NULL, NULL),
	('settings-roles', 2, '', NULL, NULL, NULL, NULL),
	('settings-roles-permission-container', 2, '', NULL, NULL, NULL, NULL),
	('settings-task-container', 2, '', NULL, NULL, NULL, NULL),
	('settings-user-accounts-form-reference-container', 2, '', NULL, NULL, NULL, NULL),
	('submit_accomplishment_report', 2, 'Permission to Submit Accomplishment Report', NULL, NULL, NULL, NULL),
	('submit_trainees_activity', 2, 'Permission to Remind Trainees about the Activity', NULL, NULL, NULL, NULL),
	('submit_trainees_evaluation', 2, 'Permission to Submit Evaluation of Trainees', NULL, NULL, NULL, NULL),
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
  KEY `parent` (`parent`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_bpsu_timesheet.auth_item_child: ~86 rows (approximately)
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
	('Administrator', 'settings-list-task-type'),
	('Administrator', 'settings-mapping-tagging-container'),
	('Administrator', 'settings-permissions'),
	('Administrator', 'settings-role-assignments'),
	('Administrator', 'settings-roles'),
	('Administrator', 'settings-roles-permission-container'),
	('Administrator', 'settings-task-container'),
	('Administrator', 'settings-user-accounts-form-reference-container'),
	('Administrator', 'upload-others-esig'),
	('Administrator', 'USER-MANAGEMENT-MODULE'),
	('Administrator', 'view-other-timesheet'),
	('CompanySupervisor', 'access-trainee-index'),
	('CompanySupervisor', 'create-activity-reminder'),
	('CompanySupervisor', 'create-transaction'),
	('CompanySupervisor', 'edit-time'),
	('CompanySupervisor', 'menu-tasks'),
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
	('OjtCoordinator', 'menu-tasks'),
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
	('Trainee', 'create-transaction'),
	('Trainee', 'menu-tasks'),
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
  KEY `model_name` (`model_name`),
  CONSTRAINT `files_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_bpsu_timesheet.files: ~0 rows (approximately)

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.ref_company: ~0 rows (approximately)

-- Dumping structure for table db_bpsu_timesheet.ref_department
CREATE TABLE IF NOT EXISTS `ref_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) DEFAULT NULL,
  `abbreviation` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.ref_department: ~2 rows (approximately)
INSERT INTO `ref_department` (`id`, `title`, `abbreviation`) VALUES
	(1, 'IT Department', ''),
	(2, 'Human Resource Department', ''),
	(3, 'Financial Management Department', '');

-- Dumping structure for table db_bpsu_timesheet.ref_document_assignment
CREATE TABLE IF NOT EXISTS `ref_document_assignment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_document_type_id` int(11) DEFAULT NULL,
  `auth_item` varchar(50) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `filter_type` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `ref_document_type_id` (`ref_document_type_id`),
  KEY `auth_item` (`auth_item`),
  KEY `type` (`type`),
  KEY `filter_type` (`filter_type`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.ref_document_assignment: ~6 rows (approximately)
INSERT INTO `ref_document_assignment` (`id`, `ref_document_type_id`, `auth_item`, `type`, `filter_type`) VALUES
	(1, 1, 'CompanySupervisor', 'SENDER', 'based_on_company_department'),
	(2, 1, 'OjtCoordinator', 'RECEIVER', 'based_on_course'),
	(3, 3, 'Trainee', 'SENDER', 'based_on_login_id'),
	(4, 3, 'OjtCoordinator', 'RECEIVER', 'based_on_course'),
	(5, 5, 'CompanySupervisor', 'SENDER', 'based_on_company_department'),
	(6, 5, 'Trainee', 'RECEIVER', 'based_on_company_department');

-- Dumping structure for table db_bpsu_timesheet.ref_document_type
CREATE TABLE IF NOT EXISTS `ref_document_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) DEFAULT NULL,
  `action_title` varchar(150) DEFAULT NULL,
  `required_uploading` int(11) NOT NULL,
  `enable_tagging` int(11) NOT NULL,
  `enable_commenting` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `required_uploading` (`required_uploading`),
  KEY `enable_tagging` (`enable_tagging`),
  KEY `enable_commenting` (`enable_commenting`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.ref_document_type: ~3 rows (approximately)
INSERT INTO `ref_document_type` (`id`, `title`, `action_title`, `required_uploading`, `enable_tagging`, `enable_commenting`) VALUES
	(1, 'Trainees Evaluation Form', 'Submit Trainees Evaluation Form', 1, 1, 0),
	(3, 'Accomplishment Report', 'Submit Accomplishment Report', 1, 0, 1),
	(5, 'Activity Reminder', 'Create Activity Reminder', 0, 0, 0);

-- Dumping structure for table db_bpsu_timesheet.ref_position
CREATE TABLE IF NOT EXISTS `ref_position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.ref_position: ~4 rows (approximately)
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
  `required_hours` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.ref_program: ~5 rows (approximately)
INSERT INTO `ref_program` (`id`, `title`, `abbreviation`, `required_hours`) VALUES
	(1, 'Bachelor of Science in Information Technology', 'BSIT', 486),
	(2, 'Bachelor of Science in Computer Science', 'BSCS', 162),
	(3, 'Bachelor of Science in Computer Engineering', 'BSCE', 0),
	(4, 'Bachelor of Science in Electronics Engineering', 'BSECE', 0),
	(5, 'Bachelor of Science in Entrepreneurship Management', 'BSEM', 0);

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

-- Dumping data for table db_bpsu_timesheet.student_year: ~4 rows (approximately)
INSERT INTO `student_year` (`year`, `title`) VALUES
	(1, '1st Year'),
	(2, '2nd Year'),
	(3, '3rd Year'),
	(4, '4th Year'),
	(5, '5th Year');

-- Dumping structure for table db_bpsu_timesheet.submission_reply
CREATE TABLE IF NOT EXISTS `submission_reply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `submission_thread_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `submission_thread_id` (`submission_thread_id`),
  KEY `user_id` (`user_id`),
  KEY `date_time` (`date_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.submission_reply: ~0 rows (approximately)

-- Dumping structure for table db_bpsu_timesheet.submission_thread
CREATE TABLE IF NOT EXISTS `submission_thread` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `tagged_user_id` int(11) DEFAULT NULL,
  `subject` varchar(250) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `ref_document_type_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `ref_document_type_id` (`ref_document_type_id`),
  KEY `id` (`id`),
  KEY `tagged_user_id` (`tagged_user_id`),
  CONSTRAINT `submission_thread_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `submission_thread_ibfk_2` FOREIGN KEY (`ref_document_type_id`) REFERENCES `ref_document_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.submission_thread: ~0 rows (approximately)

-- Dumping structure for table db_bpsu_timesheet.submission_thread_seen
CREATE TABLE IF NOT EXISTS `submission_thread_seen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `submission_thread_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `submission_thread_id` (`submission_thread_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.submission_thread_seen: ~0 rows (approximately)

-- Dumping structure for table db_bpsu_timesheet.suffix
CREATE TABLE IF NOT EXISTS `suffix` (
  `title` varchar(10) NOT NULL,
  `meaning` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`title`),
  KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.suffix: ~5 rows (approximately)
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
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_bpsu_timesheet.user: ~1 rows (approximately)
INSERT INTO `user` (`id`, `student_idno`, `student_year`, `student_section`, `ref_program_id`, `ref_program_major_id`, `ref_department_id`, `ref_position_id`, `fname`, `mname`, `sname`, `suffix`, `bday`, `sex`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `mobile_no`, `tel_no`, `address`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
	(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Juan', 'Reyes', 'Dela Cruz', NULL, '1995-10-12', 'M', 'admin', 'mLv-KdIB84pIgOrOKnopaaXc51uQml-_', '$2y$13$Mg3jk2B0jWku6FC8vR66i.I1HFd.DrEFuPNv9s1z9QTZDF.73ZUv6', NULL, 'admin@gm.com', NULL, '', NULL, 10, 1678168986, 1678168986, 'alqvh-uTo-NSx86JuSUvY_5iG3xkpOQG_1678168986');

-- Dumping structure for table db_bpsu_timesheet.user_company
CREATE TABLE IF NOT EXISTS `user_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `ref_company_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `ref_company_id` (`ref_company_id`),
  KEY `id` (`id`),
  CONSTRAINT `user_company_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.user_company: ~0 rows (approximately)

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
  KEY `date` (`date`),
  KEY `id` (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.user_timesheet: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
