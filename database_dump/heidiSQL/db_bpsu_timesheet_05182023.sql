-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.27-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table db_bpsu_timesheet.announcement
CREATE TABLE IF NOT EXISTS `announcement` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id of announcement (auto generated)',
  `viewer_type` varchar(50) DEFAULT NULL COMMENT 'serve as identifier to filter who can view the announcement (all courses, only assigned courses, or selected courses)',
  `user_id` int(11) DEFAULT NULL COMMENT 'foreign key unique id (user table) creator of announcement',
  `content_title` varchar(250) DEFAULT NULL COMMENT 'optional field (title of announcement)',
  `content` text DEFAULT NULL COMMENT 'details of announcement',
  `date_time` datetime DEFAULT NULL COMMENT 'date and time that announcement has been created/posted',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `id` (`id`),
  KEY `created_at` (`date_time`) USING BTREE,
  CONSTRAINT `announcement_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='This table would allow you to store announcement details/content.';

-- Dumping data for table db_bpsu_timesheet.announcement: ~0 rows (approximately)

-- Dumping structure for table db_bpsu_timesheet.announcement_program_tags
CREATE TABLE IF NOT EXISTS `announcement_program_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID (auto generated)',
  `announcement_id` int(11) DEFAULT NULL COMMENT 'foreign key (announcement table)',
  `ref_program_id` int(11) DEFAULT NULL COMMENT 'foreign key (ref_program table)',
  PRIMARY KEY (`id`),
  KEY `announcement_id` (`announcement_id`),
  KEY `ref_program_id` (`ref_program_id`),
  CONSTRAINT `announcement_program_tags_ibfk_1` FOREIGN KEY (`announcement_id`) REFERENCES `announcement` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `announcement_program_tags_ibfk_2` FOREIGN KEY (`ref_program_id`) REFERENCES `ref_program` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='This table will store data on which courses/programs will see the announcement';

-- Dumping data for table db_bpsu_timesheet.announcement_program_tags: ~0 rows (approximately)

-- Dumping structure for table db_bpsu_timesheet.announcement_seen
CREATE TABLE IF NOT EXISTS `announcement_seen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `announcement_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `announcement_id` (`announcement_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `announcement_seen_ibfk_1` FOREIGN KEY (`announcement_id`) REFERENCES `announcement` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `announcement_seen_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_bpsu_timesheet.announcement_seen: ~0 rows (approximately)

-- Dumping structure for table db_bpsu_timesheet.auth_assignment
CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) NOT NULL COMMENT 'foreign key (unique name of role)',
  `user_id` varchar(64) NOT NULL COMMENT 'unique id, foreign key from user table',
  `created_at` int(11) DEFAULT NULL COMMENT 'date and time created',
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `idx-auth_assignment-user_id` (`user_id`),
  KEY `item_name` (`item_name`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='this table will store the data of users who have an assigned role or permission to access the system';

-- Dumping data for table db_bpsu_timesheet.auth_assignment: ~33 rows (approximately)
INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
	('Administrator', '2', NULL),
	('CompanySupervisor', '100', NULL),
	('CompanySupervisor', '104', NULL),
	('CompanySupervisor', '112', NULL),
	('CompanySupervisor', '86', NULL),
	('OjtCoordinator', '111', NULL),
	('OjtCoordinator', '84', NULL),
	('OjtCoordinator', '85', NULL),
	('Trainee', '101', NULL),
	('Trainee', '102', NULL),
	('Trainee', '103', NULL),
	('Trainee', '105', NULL),
	('Trainee', '106', NULL),
	('Trainee', '107', NULL),
	('Trainee', '108', NULL),
	('Trainee', '109', NULL),
	('Trainee', '110', NULL),
	('Trainee', '80', NULL),
	('Trainee', '81', NULL),
	('Trainee', '82', NULL),
	('Trainee', '83', NULL),
	('Trainee', '87', NULL),
	('Trainee', '88', NULL),
	('Trainee', '89', NULL),
	('Trainee', '90', NULL),
	('Trainee', '91', NULL),
	('Trainee', '92', NULL),
	('Trainee', '93', NULL),
	('Trainee', '94', NULL),
	('Trainee', '95', NULL),
	('Trainee', '96', NULL),
	('Trainee', '97', NULL),
	('Trainee', '98', NULL),
	('Trainee', '99', NULL);

-- Dumping structure for table db_bpsu_timesheet.auth_item
CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) NOT NULL COMMENT 'unique name of roles/permissions',
  `type` smallint(6) NOT NULL COMMENT 'type of access (1 - role of the user / 2 - permission to access the specific or special features of the system)',
  `description` text DEFAULT NULL COMMENT 'description of the role and permission',
  `rule_name` varchar(64) DEFAULT NULL COMMENT 'disregard this column',
  `data` blob DEFAULT NULL COMMENT 'disregard this column',
  `created_at` int(11) DEFAULT NULL COMMENT 'date and time created',
  `updated_at` int(11) DEFAULT NULL COMMENT 'date and time updated',
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  KEY `name` (`name`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='In this table are stored the permissions and roles that can be assigned to users so that they have access to the system and the special features of the system';

-- Dumping data for table db_bpsu_timesheet.auth_item: ~76 rows (approximately)
INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
	('access-administrator-index', 2, '', NULL, NULL, NULL, NULL),
	('access-all-index', 2, '', NULL, NULL, NULL, NULL),
	('access-company-supervisor-index', 2, '', NULL, NULL, NULL, NULL),
	('access-ojt-coordinator-index', 2, '', NULL, NULL, NULL, NULL),
	('access-trainee-index', 2, '', NULL, NULL, NULL, NULL),
	('Administrator', 1, '', NULL, NULL, NULL, NULL),
	('announcement-create', 2, '', NULL, NULL, NULL, NULL),
	('announcement-index', 2, '', NULL, NULL, NULL, NULL),
	('announcement-menu', 2, '', NULL, NULL, NULL, NULL),
	('announcement-search-program', 2, '', NULL, NULL, NULL, NULL),
	('announcement-viewer-type-all-programs', 2, '', NULL, NULL, NULL, NULL),
	('announcement-viewer-type-assigned-program', 2, '', NULL, NULL, NULL, NULL),
	('announcement-viewer-type-select-programs', 2, '', NULL, NULL, NULL, NULL),
	('CompanySupervisor', 1, '', NULL, NULL, NULL, NULL),
	('create-activity-reminder', 2, '', NULL, NULL, NULL, NULL),
	('create-button-administrator', 2, '', NULL, NULL, NULL, NULL),
	('create-button-company-supervisor', 2, '', NULL, NULL, NULL, NULL),
	('create-button-ojt-coordinator', 2, '', NULL, NULL, NULL, NULL),
	('create-button-trainee', 2, '', NULL, NULL, NULL, NULL),
	('create-transaction', 2, '', NULL, NULL, NULL, NULL),
	('edit-time', 2, '', NULL, NULL, NULL, NULL),
	('import-based-on-assigned-program', 2, '', NULL, NULL, NULL, NULL),
	('import-button-trainees', 2, 'permission to import trainees using excel template', NULL, NULL, NULL, NULL),
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
	('settings-coordinator-assigned-programs-container', 2, '', NULL, NULL, NULL, NULL),
	('settings-index', 2, '', NULL, NULL, NULL, NULL),
	('settings-list-companies', 2, '', NULL, NULL, NULL, NULL),
	('settings-list-coordinator-programs', 2, '', NULL, NULL, NULL, NULL),
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
	('settings-system-other-feature', 2, '', NULL, NULL, NULL, NULL),
	('settings-task-container', 2, '', NULL, NULL, NULL, NULL),
	('settings-user-accounts-form-reference-container', 2, '', NULL, NULL, NULL, NULL),
	('submit_accomplishment_report', 2, 'Permission to Submit Accomplishment Report', NULL, NULL, NULL, NULL),
	('submit_trainees_activity', 2, 'Permission to Remind Trainees about the Activity', NULL, NULL, NULL, NULL),
	('submit_trainees_evaluation', 2, 'Permission to Submit Evaluation of Trainees', NULL, NULL, NULL, NULL),
	('time-in-out', 2, '', NULL, NULL, NULL, NULL),
	('timesheet-remarks', 2, '', NULL, NULL, NULL, NULL),
	('Trainee', 1, '', NULL, NULL, NULL, NULL),
	('upload-others-esig', 2, '', NULL, NULL, NULL, NULL),
	('upload-profile-photo', 2, '', NULL, NULL, NULL, NULL),
	('upload-signature', 2, 'permission to upload signature', NULL, NULL, NULL, NULL),
	('user-management-create', 2, NULL, NULL, NULL, NULL, NULL),
	('user-management-delete', 2, '', NULL, NULL, NULL, NULL),
	('user-management-delete-role-assigned', 2, '', NULL, NULL, NULL, NULL),
	('user-management-index', 2, '', NULL, NULL, NULL, NULL),
	('USER-MANAGEMENT-MODULE', 2, 'access to all permissions of user management', NULL, NULL, NULL, NULL),
	('user-management-register-face', 2, '', NULL, NULL, NULL, NULL),
	('user-management-update', 2, '', NULL, NULL, NULL, NULL),
	('user-management-update-status', 2, 'permission to deactivate account', NULL, NULL, NULL, NULL),
	('user-management-upload-file', 2, '', NULL, NULL, NULL, NULL),
	('user-management-view', 2, '', NULL, NULL, NULL, NULL),
	('validate-timesheet', 2, '', NULL, NULL, NULL, NULL),
	('view-column-course-program', 2, NULL, NULL, NULL, NULL, NULL),
	('view-other-timesheet', 2, '', NULL, NULL, NULL, NULL);

-- Dumping structure for table db_bpsu_timesheet.auth_item_child
CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) NOT NULL COMMENT 'unique name of role and permission',
  `child` varchar(64) NOT NULL COMMENT 'unique name of role and permission (assigned permission to role)',
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  KEY `parent` (`parent`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='In this table, the assigned permissions to each role are stored.';

-- Dumping data for table db_bpsu_timesheet.auth_item_child: ~104 rows (approximately)
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
	('Administrator', 'import-button-trainees'),
	('Administrator', 'menu-settings'),
	('Administrator', 'menu-user-management'),
	('Administrator', 'SETTINGS'),
	('Administrator', 'settings-coordinator-assigned-programs-container'),
	('Administrator', 'settings-index'),
	('Administrator', 'settings-list-companies'),
	('Administrator', 'settings-list-coordinator-programs'),
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
	('Administrator', 'settings-system-other-feature'),
	('Administrator', 'settings-task-container'),
	('Administrator', 'settings-user-accounts-form-reference-container'),
	('Administrator', 'USER-MANAGEMENT-MODULE'),
	('Administrator', 'user-management-update-status'),
	('Administrator', 'view-column-course-program'),
	('CompanySupervisor', 'access-trainee-index'),
	('CompanySupervisor', 'create-activity-reminder'),
	('CompanySupervisor', 'create-transaction'),
	('CompanySupervisor', 'edit-time'),
	('CompanySupervisor', 'menu-tasks'),
	('CompanySupervisor', 'menu-user-management'),
	('CompanySupervisor', 'SETTINGS'),
	('CompanySupervisor', 'settings-index'),
	('CompanySupervisor', 'submit_trainees_evaluation'),
	('CompanySupervisor', 'timesheet-remarks'),
	('CompanySupervisor', 'upload-signature'),
	('CompanySupervisor', 'user-management-index'),
	('CompanySupervisor', 'validate-timesheet'),
	('CompanySupervisor', 'view-column-course-program'),
	('CompanySupervisor', 'view-other-timesheet'),
	('OjtCoordinator', 'access-company-supervisor-index'),
	('OjtCoordinator', 'access-trainee-index'),
	('OjtCoordinator', 'announcement-create'),
	('OjtCoordinator', 'announcement-index'),
	('OjtCoordinator', 'announcement-menu'),
	('OjtCoordinator', 'announcement-search-program'),
	('OjtCoordinator', 'announcement-viewer-type-all-programs'),
	('OjtCoordinator', 'announcement-viewer-type-assigned-program'),
	('OjtCoordinator', 'announcement-viewer-type-select-programs'),
	('OjtCoordinator', 'create-button-company-supervisor'),
	('OjtCoordinator', 'create-button-trainee'),
	('OjtCoordinator', 'import-based-on-assigned-program'),
	('OjtCoordinator', 'import-button-trainees'),
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
	('OjtCoordinator', 'view-column-course-program'),
	('OjtCoordinator', 'view-other-timesheet'),
	('SETTINGS', 'settings-index'),
	('SETTINGS', 'settings-list-positions'),
	('Trainee', 'announcement-index'),
	('Trainee', 'announcement-menu'),
	('Trainee', 'create-transaction'),
	('Trainee', 'menu-tasks'),
	('Trainee', 'menu-timesheet'),
	('Trainee', 'record-time-in-out'),
	('Trainee', 'time-in-out'),
	('Trainee', 'timesheet-remarks'),
	('Trainee', 'upload-signature'),
	('Trainee', 'user-management-register-face'),
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Please disregard this table because we didn''t use it, but it was automatically migrated to the database once you installed the yii2 php framework, so it might be useful, so don''t delete it.';

-- Dumping data for table db_bpsu_timesheet.auth_rule: ~0 rows (approximately)

-- Dumping structure for table db_bpsu_timesheet.coordinator_programs
CREATE TABLE IF NOT EXISTS `coordinator_programs` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique ID',
  `user_id` int(11) DEFAULT NULL COMMENT 'foreign key from user table (coordinator id)',
  `ref_program_id` int(11) DEFAULT NULL COMMENT 'foreign key from ref_program table (unique id of program/course)',
  `ref_program_major_id` int(11) DEFAULT NULL COMMENT 'just ready in case the different majors need to be assigned to the coordinator',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `ref_program_id` (`ref_program_id`),
  CONSTRAINT `coordinator_programs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `coordinator_programs_ibfk_2` FOREIGN KEY (`ref_program_id`) REFERENCES `ref_program` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='here you can see the coordinator''s assigned programs/courses';

-- Dumping data for table db_bpsu_timesheet.coordinator_programs: ~6 rows (approximately)
INSERT INTO `coordinator_programs` (`id`, `user_id`, `ref_program_id`, `ref_program_major_id`) VALUES
	(1, 84, 3, NULL),
	(2, 85, 1, NULL),
	(3, 85, 2, NULL),
	(4, 85, 4, NULL),
	(5, 111, 1, NULL),
	(6, 111, 3, NULL);

-- Dumping structure for table db_bpsu_timesheet.evaluation_criteria
CREATE TABLE IF NOT EXISTS `evaluation_criteria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) DEFAULT NULL,
  `max_points` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_bpsu_timesheet.evaluation_criteria: ~7 rows (approximately)
INSERT INTO `evaluation_criteria` (`id`, `title`, `max_points`) VALUES
	(1, '1. Knowledge of Work', 20),
	(2, '2. Productivity', 20),
	(3, '3. Initiative', 15),
	(4, '4. Dedication to Duty', 15),
	(5, '5. Cooperation', 10),
	(6, '6. Safety of Housekeeping', 10),
	(7, '7. Attendance and Punctuality', 10);

-- Dumping structure for table db_bpsu_timesheet.evaluation_form
CREATE TABLE IF NOT EXISTS `evaluation_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `submission_thread_id` int(11) DEFAULT NULL,
  `trainee_user_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `evaluation_criteria_id` int(11) DEFAULT NULL,
  `points_scored` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `trainee_user_id` (`trainee_user_id`),
  KEY `user_id` (`user_id`),
  KEY `evaluation_criteria_id` (`evaluation_criteria_id`),
  KEY `submission_thread_id` (`submission_thread_id`),
  CONSTRAINT `evaluation_form_ibfk_1` FOREIGN KEY (`evaluation_criteria_id`) REFERENCES `evaluation_criteria` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `evaluation_form_ibfk_2` FOREIGN KEY (`trainee_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `evaluation_form_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `evaluation_form_ibfk_4` FOREIGN KEY (`submission_thread_id`) REFERENCES `submission_thread` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_bpsu_timesheet.evaluation_form: ~0 rows (approximately)

-- Dumping structure for table db_bpsu_timesheet.files
CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id of file (auto generated)',
  `user_id` int(11) DEFAULT NULL COMMENT 'foreign key from user table (uploader)',
  `model_name` varchar(50) DEFAULT NULL COMMENT 'identifier (category of the file / table name)',
  `model_id` int(11) DEFAULT NULL COMMENT 'table id',
  `file_name` varchar(250) DEFAULT NULL COMMENT 'file name',
  `extension` varchar(10) DEFAULT NULL COMMENT 'file type or extension name',
  `file_hash` varchar(150) DEFAULT NULL COMMENT 'unique hash code of the file (auto generated by the system)',
  `remarks` text DEFAULT NULL COMMENT 'in case the uploader want to add some remarks or message regarding the uploaded file',
  `created_at` int(11) DEFAULT NULL COMMENT 'date time uploaded',
  `user_timesheet_time` time DEFAULT NULL COMMENT 'serves as basis in DTR time in/out captured photo of user',
  `user_timesheet_id` int(11) DEFAULT NULL COMMENT 'foreign key of user_timesheet table',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `id` (`id`),
  KEY `model_id` (`model_id`),
  KEY `created_at` (`created_at`),
  KEY `model_name` (`model_name`),
  KEY `file_name` (`file_name`),
  KEY `extension` (`extension`),
  KEY `file_hash` (`file_hash`),
  KEY `user_timesheet_time` (`user_timesheet_time`),
  CONSTRAINT `files_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='in this table you can see all the files uploaded to the system';

-- Dumping data for table db_bpsu_timesheet.files: ~98 rows (approximately)
INSERT INTO `files` (`id`, `user_id`, `model_name`, `model_id`, `file_name`, `extension`, `file_hash`, `remarks`, `created_at`, `user_timesheet_time`, `user_timesheet_id`) VALUES
	(27, 87, 'UserFacialRegister', 87, '6449ca537e432.png', 'png', '6449ca537e432.png', NULL, 1682557523, NULL, NULL),
	(28, 87, 'UserFacialRegister', 87, '6449ca8266dbe.png', 'png', '6449ca8266dbe.png', NULL, 1682557570, NULL, NULL),
	(29, 87, 'UserFacialRegister', 87, '6449ca8a81011.png', 'png', '6449ca8a81011.png', NULL, 1682557578, NULL, NULL),
	(30, 87, 'UserFacialRegister', 87, '6449ca9422398.png', 'png', '6449ca9422398.png', NULL, 1682557588, NULL, NULL),
	(31, 87, 'UserFacialRegister', 87, '6449ca9730bbe.png', 'png', '6449ca9730bbe.png', NULL, 1682557591, NULL, NULL),
	(32, 87, 'UserFacialRegister', 87, '6449caa3abee0.png', 'png', '6449caa3abee0.png', NULL, 1682557603, NULL, NULL),
	(33, 87, 'UserFacialRegister', 87, '6449caa8afbfe.png', 'png', '6449caa8afbfe.png', NULL, 1682557608, NULL, NULL),
	(34, 87, 'UserFacialRegister', 87, '6449cabc99397.png', 'png', '6449cabc99397.png', NULL, 1682557628, NULL, NULL),
	(35, 87, 'UserFacialRegister', 87, '6449cadcb6b83.png', 'png', '6449cadcb6b83.png', NULL, 1682557660, NULL, NULL),
	(36, 87, 'UserFacialRegister', 87, '6449cae6430b0.png', 'png', '6449cae6430b0.png', NULL, 1682557670, NULL, NULL),
	(37, 87, 'UserFacialRegister', 87, '6449cafa46578.png', 'png', '6449cafa46578.png', NULL, 1682557690, NULL, NULL),
	(38, 87, 'UserFacialRegister', 87, '6449cb13d343d.png', 'png', '6449cb13d343d.png', NULL, 1682557715, NULL, NULL),
	(39, 87, 'UserFacialRegister', 87, '6449cb3bd0e91.png', 'png', '6449cb3bd0e91.png', NULL, 1682557755, NULL, NULL),
	(40, 87, 'UserFacialRegister', 87, '6449cb4c006c2.png', 'png', '6449cb4c006c2.png', NULL, 1682557772, NULL, NULL),
	(41, 87, 'UserFacialRegister', 87, '6449cb51652c0.png', 'png', '6449cb51652c0.png', NULL, 1682557777, NULL, NULL),
	(42, 87, 'UserFacialRegister', 87, '6449cb58d810d.png', 'png', '6449cb58d810d.png', NULL, 1682557784, NULL, NULL),
	(43, 87, 'UserFacialRegister', 87, '6449cb76adf3a.png', 'png', '6449cb76adf3a.png', NULL, 1682557814, NULL, NULL),
	(44, 87, 'UserFacialRegister', 87, '6449cb8674176.png', 'png', '6449cb8674176.png', NULL, 1682557830, NULL, NULL),
	(45, 87, 'UserFacialRegister', 87, '6449cba199183.png', 'png', '6449cba199183.png', NULL, 1682557857, NULL, NULL),
	(46, 87, 'UserFacialRegister', 87, '6449cba3c9e7a.png', 'png', '6449cba3c9e7a.png', NULL, 1682557859, NULL, NULL),
	(47, 87, 'UserTimesheet', 87, '6449cc0055add.png', 'png', '6449cc0055add.png', NULL, 1682557952, '09:12:32', 2),
	(48, 86, 'UserData', 86, 'jhaema3', 'png', 'aa41300d4b7813ff42964ed14b5e2d89', NULL, 1682585986, NULL, NULL),
	(51, 85, 'Announcement', 1, 'sample_accreport', 'docx', '53b30705962437f62ca598eb6ea1e2c5', NULL, 1682587107, NULL, NULL),
	(52, 86, 'SubmissionThread', 2, 'sample_eval', 'docx', '6852a148f782a65a48ed501579eb175c', NULL, 1682587270, NULL, NULL),
	(58, 98, 'UserFacialRegister', 98, '6454fc4782073.png', 'png', '6454fc4782073.png', NULL, 1683291207, NULL, NULL),
	(59, 98, 'UserFacialRegister', 98, '6454fdd7b5dc2.png', 'png', '6454fdd7b5dc2.png', NULL, 1683291607, NULL, NULL),
	(60, 98, 'UserFacialRegister', 98, '6454fded3e541.png', 'png', '6454fded3e541.png', NULL, 1683291629, NULL, NULL),
	(61, 98, 'UserFacialRegister', 98, '6454fe0ac9acd.png', 'png', '6454fe0ac9acd.png', NULL, 1683291658, NULL, NULL),
	(62, 98, 'UserFacialRegister', 98, '6455014ddfad1.png', 'png', '6455014ddfad1.png', NULL, 1683292493, NULL, NULL),
	(63, 98, 'UserFacialRegister', 98, '645501679272e.png', 'png', '645501679272e.png', NULL, 1683292519, NULL, NULL),
	(64, 98, 'UserFacialRegister', 98, '6455017d9ee3f.png', 'png', '6455017d9ee3f.png', NULL, 1683292541, NULL, NULL),
	(65, 98, 'UserFacialRegister', 98, '645501915ed58.png', 'png', '645501915ed58.png', NULL, 1683292561, NULL, NULL),
	(66, 98, 'UserFacialRegister', 98, '645501a5e55db.png', 'png', '645501a5e55db.png', NULL, 1683292581, NULL, NULL),
	(67, 98, 'UserFacialRegister', 98, '645501ba514df.png', 'png', '645501ba514df.png', NULL, 1683292602, NULL, NULL),
	(68, 98, 'UserFacialRegister', 98, '645501d96a076.png', 'png', '645501d96a076.png', NULL, 1683292633, NULL, NULL),
	(69, 98, 'UserFacialRegister', 98, '645501ef87b79.png', 'png', '645501ef87b79.png', NULL, 1683292655, NULL, NULL),
	(70, 98, 'UserFacialRegister', 98, '6455020f64b3e.png', 'png', '6455020f64b3e.png', NULL, 1683292687, NULL, NULL),
	(71, 98, 'UserFacialRegister', 98, '6455023694298.png', 'png', '6455023694298.png', NULL, 1683292726, NULL, NULL),
	(72, 98, 'UserFacialRegister', 98, '6455024b200b1.png', 'png', '6455024b200b1.png', NULL, 1683292747, NULL, NULL),
	(73, 98, 'UserFacialRegister', 98, '64550260648c3.png', 'png', '64550260648c3.png', NULL, 1683292768, NULL, NULL),
	(74, 98, 'UserFacialRegister', 98, '64550281068ad.png', 'png', '64550281068ad.png', NULL, 1683292801, NULL, NULL),
	(75, 98, 'UserFacialRegister', 98, '6455029887314.png', 'png', '6455029887314.png', NULL, 1683292824, NULL, NULL),
	(76, 98, 'UserFacialRegister', 98, '645502ad9cc49.png', 'png', '645502ad9cc49.png', NULL, 1683292845, NULL, NULL),
	(77, 98, 'UserFacialRegister', 98, '645502c4f352a.png', 'png', '645502c4f352a.png', NULL, 1683292869, NULL, NULL),
	(78, 98, 'UserTimesheet', 98, '6407d068b3862.png', 'png', '6407d068b3862.png', NULL, 1678233705, '08:01:45', 5),
	(79, 98, 'UserTimesheet', 98, '64084f974e5db.png', 'png', '64084f974e5db.png', NULL, 1678266264, '17:04:24', 5),
	(80, 98, 'UserTimesheet', 98, '6433523ec29a1.png', 'png', '6433523ec29a1.png', NULL, 1681084991, '08:03:11', 6),
	(81, 98, 'UserTimesheet', 98, '64338aa5c7502.png', 'png', '64338aa5c7502.png', NULL, 1681099430, '12:03:50', 6),
	(82, 98, 'UserTimesheet', 98, '645598f1836d5.png', 'png', '645598f1836d5.png', NULL, 1683331314, '08:01:54', 7),
	(83, 98, 'UserTimesheet', 98, '6455ca6f26470.png', 'png', '6455ca6f26470.png', NULL, 1683343984, '11:33:04', 7),
	(84, 98, 'UserTimesheet', 98, '6455df1a99f3b.png', 'png', '6455df1a99f3b.png', NULL, 1683349275, '13:01:15', 7),
	(85, 98, 'UserTimesheet', 98, '6456258f93a3a.png', 'png', '6456258f93a3a.png', NULL, 1683367312, '18:01:52', 7),
	(86, 98, 'UserTimesheet', 98, '6409225336f28.png', 'png', '6409225336f28.png', NULL, 1678320212, '08:03:32', 8),
	(87, 98, 'UserTimesheet', 98, '640959fede1b2.png', 'png', '640959fede1b2.png', NULL, 1678334463, '12:01:03', 8),
	(88, 98, 'UserTimesheet', 98, '64096825330b6.png', 'png', '64096825330b6.png', NULL, 1678338086, '13:01:26', 9),
	(89, 98, 'UserTimesheet', 98, '640968263631b.png', 'png', '640968263631b.png', NULL, 1678338087, '13:01:27', 9),
	(90, 98, 'UserTimesheet', 98, '6409a0cecb18c.png', 'png', '6409a0cecb18c.png', NULL, 1678352591, '17:03:11', 10),
	(91, 98, 'UserTimesheet', 98, '640a73516d0cb.png', 'png', '640a73516d0cb.png', NULL, 1678406482, '08:01:22', 11),
	(92, 98, 'UserTimesheet', 98, '640aaa5f277b1.png', 'png', '640aaa5f277b1.png', NULL, 1678420576, '11:56:16', 11),
	(93, 98, 'UserTimesheet', 98, '640ab98c04e3f.png', 'png', '640ab98c04e3f.png', NULL, 1678424460, '13:01:00', 11),
	(94, 98, 'UserTimesheet', 98, '640b0ddfc7d7f.png', 'png', '640b0ddfc7d7f.png', NULL, 1678446048, '19:00:48', 11),
	(95, 98, 'UserFacialRegister', 98, '640b0e0e17b96.png', 'png', '640b0e0e17b96.png', NULL, 1678446094, NULL, NULL),
	(96, 98, 'UserFacialRegister', 98, '640b0e151b904.png', 'png', '640b0e151b904.png', NULL, 1678446101, NULL, NULL),
	(97, 98, 'UserFacialRegister', 98, '640b0e1d02c17.png', 'png', '640b0e1d02c17.png', NULL, 1678446109, NULL, NULL),
	(98, 98, 'UserFacialRegister', 98, '640b0e216f45a.png', 'png', '640b0e216f45a.png', NULL, 1678446113, NULL, NULL),
	(99, 98, 'UserFacialRegister', 98, '640b0e2b16ff2.png', 'png', '640b0e2b16ff2.png', NULL, 1678446123, NULL, NULL),
	(100, 98, 'UserFacialRegister', 98, '640b0e327ca44.png', 'png', '640b0e327ca44.png', NULL, 1678446130, NULL, NULL),
	(101, 98, 'UserFacialRegister', 98, '640b0e527abad.png', 'png', '640b0e527abad.png', NULL, 1678446162, NULL, NULL),
	(102, 98, 'UserFacialRegister', 98, '640b0e5e74099.png', 'png', '640b0e5e74099.png', NULL, 1678446174, NULL, NULL),
	(103, 98, 'UserFacialRegister', 98, '640b0e6527ebc.png', 'png', '640b0e6527ebc.png', NULL, 1678446181, NULL, NULL),
	(104, 98, 'UserFacialRegister', 98, '640b0e6c3862a.png', 'png', '640b0e6c3862a.png', NULL, 1678446188, NULL, NULL),
	(105, 98, 'UserFacialRegister', 98, '640b0e808faea.png', 'png', '640b0e808faea.png', NULL, 1678446208, NULL, NULL),
	(106, 98, 'UserData', 98, 'jhaema3', 'png', '6e17071684f123c052426880319dd0aa', NULL, 1678446232, NULL, NULL),
	(107, 98, 'UserTimesheet', 98, '640bc5a93f7d3.png', 'png', '640bc5a93f7d3.png', NULL, 1678493098, '08:04:58', 12),
	(108, 98, 'UserTimesheet', 98, '640bfca0de5ce.png', 'png', '640bfca0de5ce.png', NULL, 1678507169, '11:59:29', 12),
	(109, 98, 'UserTimesheet', 98, '640c0b21e8fc4.png', 'png', '640c0b21e8fc4.png', NULL, 1678510882, '13:01:22', 12),
	(110, 98, 'UserTimesheet', 98, '640c586d5a573.png', 'png', '640c586d5a573.png', NULL, 1678530670, '18:31:10', 12),
	(111, 98, 'UserTimesheet', 98, '6455f01b32db0.png', 'png', '6455f01b32db0.png', NULL, 1683353627, '14:13:47', 13),
	(112, 98, 'UserTimesheet', 98, '6409bf7379500.png', 'png', '6409bf7379500.png', NULL, 1678360436, '19:13:56', 10),
	(113, 98, 'UserTimesheet', 98, '640d1675d0aa1.png', 'png', '640d1675d0aa1.png', NULL, 1678579318, '08:01:58', 14),
	(114, 98, 'UserTimesheet', 98, '640d4eaf76fe0.png', 'png', '640d4eaf76fe0.png', NULL, 1678593712, '12:01:52', 14),
	(115, 98, 'UserTimesheet', 98, '640d5cba26c30.png', 'png', '640d5cba26c30.png', NULL, 1678597307, '13:01:47', 15),
	(116, 98, 'UserTimesheet', 98, '640da30222238.png', 'png', '640da30222238.png', NULL, 1678615299, '18:01:39', 15),
	(117, 87, 'UserFacialRegister', 87, '645ef74d8a52f.png', 'png', '645ef74d8a52f.png', NULL, 1683945293, NULL, NULL),
	(118, 87, 'UserFacialRegister', 87, '645ef751a39e8.png', 'png', '645ef751a39e8.png', NULL, 1683945297, NULL, NULL),
	(119, 87, 'UserTimesheet', 87, '645ef76b332e4.png', 'png', '645ef76b332e4.png', NULL, 1683945323, '10:35:23', 27),
	(120, 87, 'UserTimesheet', 87, '645ef8ab2fded.png', 'png', '645ef8ab2fded.png', NULL, 1683945643, '10:40:43', 27),
	(121, 87, 'UserTimesheet', 87, '645ef8bacdec5.png', 'png', '645ef8bacdec5.png', NULL, 1683945658, '10:40:58', 27),
	(122, 87, 'UserTimesheet', 87, '645ef8c559862.png', 'png', '645ef8c559862.png', NULL, 1683945669, '10:41:09', 28),
	(123, 87, 'UserTimesheet', 87, '645ef8ccc2e8c.png', 'png', '645ef8ccc2e8c.png', NULL, 1683945676, '10:41:16', 28),
	(124, 87, 'UserTimesheet', 87, '645f237da2df0.png', 'png', '645f237da2df0.png', NULL, 1683956605, '13:43:25', 27),
	(125, 87, 'UserTimesheet', 87, '645f23e26a67a.png', 'png', '645f23e26a67a.png', NULL, 1683956706, '13:45:06', 27),
	(126, 87, 'UserTimesheet', 87, '645f23ea7b6d0.png', 'png', '645f23ea7b6d0.png', NULL, 1683956714, '13:45:14', 27),
	(127, 87, 'UserTimesheet', 87, '645f23f17a32f.png', 'png', '645f23f17a32f.png', NULL, 1683956721, '13:45:21', 29),
	(128, 87, 'UserTimesheet', 87, '645f23fb2e6d7.png', 'png', '645f23fb2e6d7.png', NULL, 1683956731, '13:45:31', 29),
	(129, 86, 'UserData', 86, 'esig1', 'png', '697520f6053f1a758aee3d937e690e7a', NULL, 1684287266, NULL, NULL),
	(130, 87, 'UserData', 87, 'esig3', 'png', 'fc9e7f76a302c1d66d4e214202f08984', NULL, 1684287351, NULL, NULL),
	(131, 86, 'UserData', 86, 'esig4', 'png', 'fd9dea8370462b440b01b37447d7e676', NULL, 1684287421, NULL, NULL),
	(132, 86, 'UserData', 86, 'esig2', 'png', 'e4c304d77ce303111345bd19b6e35c79', NULL, 1684288139, NULL, NULL);

-- Dumping structure for table db_bpsu_timesheet.migration
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL COMMENT 'migration file name',
  `apply_time` int(11) DEFAULT NULL COMMENT 'date time migrated',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='auto migrated table once you install the Yii2 PHP framework (serves as repository of migrated default tables of Yii2 Framework)';

-- Dumping data for table db_bpsu_timesheet.migration: ~14 rows (approximately)
INSERT INTO `migration` (`version`, `apply_time`) VALUES
	('m000000_000000_base', 1678168164),
	('m130524_201442_init', 1678168169),
	('m140506_102106_rbac_init', 1678417445),
	('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1678417445),
	('m180523_151638_rbac_updates_indexes_without_prefix', 1678417445),
	('m190124_110200_add_verification_token_column_to_user_table', 1678168169),
	('m200409_110543_rbac_update_mssql_trigger', 1678417445),
	('m230401_054400_another_permission', 1680328127),
	('m230402_020608_update_program_id', 1680401805),
	('m230402_125314_add_permission_assignment', 1680440013),
	('m230502_084102_update_mobile_no', 1683548187),
	('m230503_000856_add_column_ref_document_type_required_remarks', 1683548187),
	('m230503_004527_update_required_uploading', 1683548187),
	('m230515_073556_add_col_submission_thread', 1684136797);

-- Dumping structure for table db_bpsu_timesheet.ref_company
CREATE TABLE IF NOT EXISTS `ref_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id (auto generated)',
  `name` varchar(255) DEFAULT NULL COMMENT 'company name',
  `address` varchar(255) DEFAULT NULL COMMENT 'company address',
  `latitude` decimal(10,7) DEFAULT NULL COMMENT 'company location (latitude)',
  `longitude` decimal(10,7) DEFAULT NULL COMMENT 'company location (longitude)',
  `contact_info` varchar(150) DEFAULT NULL COMMENT 'contact details of the company',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='reference table: you can see the encoded company details';

-- Dumping data for table db_bpsu_timesheet.ref_company: ~5 rows (approximately)
INSERT INTO `ref_company` (`id`, `name`, `address`, `latitude`, `longitude`, `contact_info`) VALUES
	(1, 'Technical Education and Skills Development Authority', 'TESDA, Kinatawan Road, City of Balanga, Bataan, Philippines', 14.6767056, 120.5310184, ''),
	(2, 'The Bunker', 'The Bunker, City of Balanga, Bataan, Philippines', 14.6756875, 120.5290961, ''),
	(3, 'Bataan Peninsula State University', 'Bataan Peninsula State University, Capitol Drive, City of Balanga, Bataan, Philippines', 14.6769210, 120.5306378, ''),
	(4, 'Accenture Gateway Tower 2', 'Accenture Gateway Tower 2, General Aguinaldo Avenue, Cubao, Quezon City, Metro Manila, Philippines', 14.6226048, 121.0530741, ''),
	(5, 'AMPC', 'AMPC, Magtanong Street, Abucay, Bataan, Philippines', 14.7245510, 120.5323474, ''),
	(6, 'Nokia Shanghai-Bell Philippines, Inc.', 'Nokia Shanghai-Bell Philippines, Inc., 5th Avenue, Taguig, Metro Manila, Philippines', 14.5532998, 121.0487714, '');

-- Dumping structure for table db_bpsu_timesheet.ref_department
CREATE TABLE IF NOT EXISTS `ref_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique ID (auto generated)',
  `title` varchar(250) DEFAULT NULL COMMENT 'department name',
  `abbreviation` varchar(20) DEFAULT NULL COMMENT 'department abbreviation',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='reference table: the company''s departments are stored here';

-- Dumping data for table db_bpsu_timesheet.ref_department: ~4 rows (approximately)
INSERT INTO `ref_department` (`id`, `title`, `abbreviation`) VALUES
	(1, 'IT Department', ''),
	(2, 'Human Resource Department', ''),
	(3, 'Financial Management Department', ''),
	(4, 'Engineering Department', '');

-- Dumping structure for table db_bpsu_timesheet.ref_document_assignment
CREATE TABLE IF NOT EXISTS `ref_document_assignment` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id (auto generated)',
  `ref_document_type_id` int(11) DEFAULT NULL COMMENT 'foreign key of ref_document_type table',
  `auth_item` varchar(50) DEFAULT NULL COMMENT 'role/permission name (auth_item table)',
  `type` varchar(20) DEFAULT NULL COMMENT 'task identifier (SENDER or RECEIVER)',
  `filter_type` varchar(150) DEFAULT NULL COMMENT 'Backend filter identifier (this serves as basis to filter the task)',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `ref_document_type_id` (`ref_document_type_id`),
  KEY `auth_item` (`auth_item`),
  KEY `type` (`type`),
  KEY `filter_type` (`filter_type`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='reference table: serves as the system''s basis for who is the receiver or sender of the Accomplishment Report, Evaluation Form, & Activity Reminder';

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
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique ID (auto generated)',
  `title` varchar(150) DEFAULT NULL COMMENT 'title of task once RECEIVED',
  `action_title` varchar(150) DEFAULT NULL COMMENT 'title of task to be performed',
  `required_uploading` int(11) NOT NULL COMMENT '1 - required uploading of file / 0 - optional',
  `enable_tagging` int(11) NOT NULL COMMENT '1 - enable tagging of user / 0 - disabl tagging of user',
  `enable_commenting` int(11) NOT NULL COMMENT '1 - enable creating comment / 0 - disable creating of comment',
  `required_remarks` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `required_uploading` (`required_uploading`),
  KEY `enable_tagging` (`enable_tagging`),
  KEY `enable_commenting` (`enable_commenting`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Reference table: types of task';

-- Dumping data for table db_bpsu_timesheet.ref_document_type: ~3 rows (approximately)
INSERT INTO `ref_document_type` (`id`, `title`, `action_title`, `required_uploading`, `enable_tagging`, `enable_commenting`, `required_remarks`) VALUES
	(1, 'Trainees Evaluation Form', 'Submit Trainees Evaluation Form', 1, 1, 0, 0),
	(3, 'Accomplishment Report', 'Submit Accomplishment Report', 1, 0, 1, 0),
	(5, 'Activity Reminder', 'Create Activity Reminder', 0, 0, 0, 1);

-- Dumping structure for table db_bpsu_timesheet.ref_position
CREATE TABLE IF NOT EXISTS `ref_position` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id of position (auto generated)',
  `position` varchar(100) DEFAULT NULL COMMENT 'position title',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Reference table: list of company positions';

-- Dumping data for table db_bpsu_timesheet.ref_position: ~5 rows (approximately)
INSERT INTO `ref_position` (`id`, `position`) VALUES
	(1, 'Administrative Assistant'),
	(2, 'Director'),
	(3, 'Manager'),
	(4, 'Financial Specialist'),
	(5, 'Database Administrator');

-- Dumping structure for table db_bpsu_timesheet.ref_program
CREATE TABLE IF NOT EXISTS `ref_program` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id of program/course (auto generated)',
  `title` varchar(250) DEFAULT NULL COMMENT 'title of program/course',
  `abbreviation` varchar(20) DEFAULT NULL COMMENT 'abbreviation of program/course',
  `required_hours` int(11) NOT NULL COMMENT 'required hours to be rendered in OJT',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Reference table: list of programs/courses';

-- Dumping data for table db_bpsu_timesheet.ref_program: ~5 rows (approximately)
INSERT INTO `ref_program` (`id`, `title`, `abbreviation`, `required_hours`) VALUES
	(1, 'Bachelor of Science in Information Technology', 'BSIT', 324),
	(2, 'Bachelor of Science in Computer Science', 'BSCS', 162),
	(3, 'Bachelor of Science in Entertainment & Multimedia Computing', 'BSEMC', 486),
	(4, 'Bachelor of Science in Electronics Engineering', 'BSECE', 0),
	(5, 'Bachelor of Science in Entrepreneurship Management', 'BSEM', 0);

-- Dumping structure for table db_bpsu_timesheet.ref_program_major
CREATE TABLE IF NOT EXISTS `ref_program_major` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique if of major (auto generated)',
  `ref_program_id` int(11) DEFAULT NULL COMMENT 'foreign key of ref_program table',
  `title` varchar(250) DEFAULT NULL COMMENT 'title of Major',
  `abbreviation` varchar(10) DEFAULT NULL COMMENT 'abbreviation of Major',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `ref_program_id` (`ref_program_id`),
  CONSTRAINT `ref_program_major_ibfk_1` FOREIGN KEY (`ref_program_id`) REFERENCES `ref_program` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Refererence table: list of program''s majors';

-- Dumping data for table db_bpsu_timesheet.ref_program_major: ~5 rows (approximately)
INSERT INTO `ref_program_major` (`id`, `ref_program_id`, `title`, `abbreviation`) VALUES
	(3, 1, 'Network and Web Application', 'NW'),
	(4, 2, 'Network and Data Communication', 'ND'),
	(5, 2, 'Software Development', 'SD'),
	(6, 3, 'Game Development', 'GD'),
	(7, 3, 'Digital Animation Technology', 'DAT');

-- Dumping structure for table db_bpsu_timesheet.student_section
CREATE TABLE IF NOT EXISTS `student_section` (
  `section` varchar(5) NOT NULL,
  PRIMARY KEY (`section`),
  UNIQUE KEY `section` (`section`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Reference table: list of sections';

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Reference table: list of years';

-- Dumping data for table db_bpsu_timesheet.student_year: ~3 rows (approximately)
INSERT INTO `student_year` (`year`, `title`) VALUES
	(3, '3rd Year'),
	(4, '4th Year'),
	(5, '5th Year');

-- Dumping structure for table db_bpsu_timesheet.submission_archive
CREATE TABLE IF NOT EXISTS `submission_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `submission_thread_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `submission_thread_id` (`submission_thread_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `submission_archive_ibfk_1` FOREIGN KEY (`submission_thread_id`) REFERENCES `submission_thread` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `submission_archive_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_bpsu_timesheet.submission_archive: ~0 rows (approximately)

-- Dumping structure for table db_bpsu_timesheet.submission_reply
CREATE TABLE IF NOT EXISTS `submission_reply` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id of messages (auto generated)',
  `submission_thread_id` int(11) DEFAULT NULL COMMENT 'foreign key id of submission_thread table (under of what task is this thread)',
  `user_id` int(11) DEFAULT NULL COMMENT 'foreign key id of user table (creator of message)',
  `message` text DEFAULT NULL COMMENT 'message content',
  `date_time` datetime DEFAULT NULL COMMENT 'date time created',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `submission_thread_id` (`submission_thread_id`),
  KEY `user_id` (`user_id`),
  KEY `date_time` (`date_time`),
  CONSTRAINT `submission_reply_ibfk_1` FOREIGN KEY (`submission_thread_id`) REFERENCES `submission_thread` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `submission_reply_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='transaction table: this table allows user to store messages/comment regarding the submitted document (AR) or performed tasks (creating activity reminder) (messenger)';

-- Dumping data for table db_bpsu_timesheet.submission_reply: ~0 rows (approximately)

-- Dumping structure for table db_bpsu_timesheet.submission_reply_seen
CREATE TABLE IF NOT EXISTS `submission_reply_seen` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id (auto generated)',
  `submission_thread_id` int(11) DEFAULT NULL,
  `submission_reply_id` int(11) DEFAULT NULL COMMENT 'foreign key of submission_reply table',
  `user_id` int(11) DEFAULT NULL COMMENT 'foreign key of user table (who seen the reply)',
  `date_time` datetime DEFAULT NULL COMMENT 'date/time seen',
  PRIMARY KEY (`id`),
  KEY `submission_reply_id` (`submission_reply_id`),
  KEY `user_id` (`user_id`),
  KEY `submission_thread_id` (`submission_thread_id`),
  CONSTRAINT `submission_reply_seen_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `submission_reply_seen_ibfk_2` FOREIGN KEY (`submission_thread_id`) REFERENCES `submission_thread` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='here you can see if the user has seen the reply or message regarding the AR submission';

-- Dumping data for table db_bpsu_timesheet.submission_reply_seen: ~0 rows (approximately)

-- Dumping structure for table db_bpsu_timesheet.submission_thread
CREATE TABLE IF NOT EXISTS `submission_thread` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique ID (auto generated)',
  `user_id` int(11) DEFAULT NULL COMMENT 'foreign key id of user table (submitted by / created by)',
  `tagged_user_id` int(11) DEFAULT NULL COMMENT 'foreign key id (The company supervisor will tag whose evaluation form to submit)',
  `subject` varchar(250) DEFAULT NULL COMMENT 'disregard this column',
  `remarks` text DEFAULT NULL COMMENT 'remarks or message details regarding the submitted document or created activity reminder',
  `ref_document_type_id` int(11) DEFAULT NULL COMMENT 'foreign key id of ref_document_type table (identifier if AR, Evaluation Form, or Activity Reminder)',
  `created_at` int(11) DEFAULT NULL COMMENT 'disregard this column',
  `date_time` datetime DEFAULT NULL COMMENT 'date time created/submitted',
  `date_commenced` date DEFAULT NULL,
  `date_completed` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `ref_document_type_id` (`ref_document_type_id`),
  KEY `id` (`id`),
  KEY `tagged_user_id` (`tagged_user_id`),
  CONSTRAINT `submission_thread_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `submission_thread_ibfk_2` FOREIGN KEY (`ref_document_type_id`) REFERENCES `ref_document_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='transactional table: here you can store all transaction regarding the tasks or submission of Accomplishment Report, Evaluation Form, and Activity Reminder.';

-- Dumping data for table db_bpsu_timesheet.submission_thread: ~7 rows (approximately)
INSERT INTO `submission_thread` (`id`, `user_id`, `tagged_user_id`, `subject`, `remarks`, `ref_document_type_id`, `created_at`, `date_time`, `date_commenced`, `date_completed`) VALUES
	(2, 86, 80, NULL, '', 1, 1682587270, '2023-04-27 17:21:10', NULL, NULL),
	(3, 86, NULL, NULL, 'checking of system', 5, 1682587378, '2023-04-27 17:22:58', NULL, NULL),
	(4, 86, NULL, NULL, 'eat your breaky', 5, 1682596891, '2023-04-27 20:01:31', NULL, NULL),
	(6, 86, NULL, NULL, '', 1, 1684134955, '2023-05-15 15:15:55', NULL, NULL),
	(7, 86, NULL, NULL, 'yes', 5, 1684137618, '2023-05-15 16:00:18', NULL, NULL),
	(10, 86, 87, NULL, 'sample recommendations', 1, 1684221431, '2023-05-16 15:17:11', '2023-05-01', '2023-05-16'),
	(11, 86, 107, NULL, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English', 1, 1684300616, '2023-05-17 13:16:56', '2023-05-02', '2023-05-17');

-- Dumping structure for table db_bpsu_timesheet.submission_thread_seen
CREATE TABLE IF NOT EXISTS `submission_thread_seen` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id (auto generated)',
  `submission_thread_id` int(11) DEFAULT NULL COMMENT 'foreign key id of submission_thread table',
  `user_id` int(11) DEFAULT NULL COMMENT 'forein key id of user table (who viewed the created tasks or submitted document)',
  `date_time` datetime DEFAULT NULL COMMENT 'date time seen',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `submission_thread_id` (`submission_thread_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Transactional table: serves as basis if the user seen the submitted document or viewed the created activity reminder';

-- Dumping data for table db_bpsu_timesheet.submission_thread_seen: ~7 rows (approximately)
INSERT INTO `submission_thread_seen` (`id`, `submission_thread_id`, `user_id`, `date_time`) VALUES
	(1, 1, 85, '2023-04-27 17:15:34'),
	(2, 2, 85, '2023-04-27 17:21:46'),
	(3, 3, 80, '2023-04-27 17:24:25'),
	(4, 4, 80, '2023-04-27 20:04:07'),
	(5, 5, 80, '2023-04-28 21:19:10'),
	(6, 8, 85, '2023-05-16 11:47:10'),
	(7, 10, 85, '2023-05-17 10:43:09');

-- Dumping structure for table db_bpsu_timesheet.suffix
CREATE TABLE IF NOT EXISTS `suffix` (
  `title` varchar(10) NOT NULL,
  `meaning` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`title`),
  KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Reference table: list of suffixes';

-- Dumping data for table db_bpsu_timesheet.suffix: ~6 rows (approximately)
INSERT INTO `suffix` (`title`, `meaning`) VALUES
	('II', 'the Second'),
	('III', 'the Third'),
	('IV', 'the Fourth'),
	('Jr.', 'Junior'),
	('Sr.', 'Senior'),
	('V', 'the Fifth');

-- Dumping structure for table db_bpsu_timesheet.system_other_feature
CREATE TABLE IF NOT EXISTS `system_other_feature` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feature` varchar(250) DEFAULT NULL,
  `enabled` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_bpsu_timesheet.system_other_feature: ~0 rows (approximately)
INSERT INTO `system_other_feature` (`id`, `feature`, `enabled`) VALUES
	(2, 'time_inout_using_login_credential', 1);

-- Dumping structure for table db_bpsu_timesheet.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id of user',
  `student_idno` varchar(50) DEFAULT NULL COMMENT 'student id no',
  `student_year` int(1) DEFAULT NULL COMMENT 'student''s year',
  `student_section` varchar(1) DEFAULT NULL COMMENT 'student''s section',
  `ref_program_id` int(11) DEFAULT NULL COMMENT 'student''s program/course',
  `ref_program_major_id` int(11) DEFAULT NULL COMMENT 'student''s major',
  `ref_department_id` int(11) DEFAULT NULL COMMENT 'student/supervisor''s deparment',
  `ref_position_id` int(11) DEFAULT NULL COMMENT 'supervisor''s company position',
  `fname` varchar(250) DEFAULT NULL COMMENT 'first name',
  `mname` varchar(150) DEFAULT NULL COMMENT 'middle name',
  `sname` varchar(50) DEFAULT NULL COMMENT 'surname',
  `suffix` varchar(10) DEFAULT NULL COMMENT 'suffix',
  `bday` date DEFAULT NULL COMMENT 'birthdate',
  `sex` varchar(1) DEFAULT NULL COMMENT 'Male or Female (M,F)',
  `username` varchar(255) NOT NULL COMMENT 'account''s username',
  `auth_key` varchar(32) NOT NULL COMMENT 'accounts authentication key (unique code if the user successfully login)',
  `password_hash` varchar(255) NOT NULL COMMENT 'accounts password (stored in hash code)',
  `password_reset_token` varchar(255) DEFAULT NULL COMMENT 'disregard this column',
  `email` varchar(255) NOT NULL COMMENT 'user''s email',
  `mobile_no` varchar(10) DEFAULT NULL,
  `tel_no` varchar(150) NOT NULL COMMENT 'user''s telephone no.',
  `address` text DEFAULT NULL COMMENT 'user''s address details',
  `status` smallint(6) NOT NULL DEFAULT 10 COMMENT 'account''s status (10 - active, 9 - inactive)',
  `created_at` int(11) NOT NULL COMMENT 'date time created',
  `updated_at` int(11) NOT NULL COMMENT 'date time updated',
  `verification_token` varchar(255) DEFAULT NULL COMMENT 'auto generated key to allow user access the system',
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
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='List of users of the system';

-- Dumping data for table db_bpsu_timesheet.user: ~31 rows (approximately)
INSERT INTO `user` (`id`, `student_idno`, `student_year`, `student_section`, `ref_program_id`, `ref_program_major_id`, `ref_department_id`, `ref_position_id`, `fname`, `mname`, `sname`, `suffix`, `bday`, `sex`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `mobile_no`, `tel_no`, `address`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
	(2, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'Juan', 'Reyes', 'Dela Cruz', '', '1995-10-12', 'M', 'admin123', 'mLv-KdIB84pIgOrOKnopaaXc51uQml-_', '$2y$13$e4Dcc2wVy3ur10rqQ8mkae0JLsO58dHURdZnvqhZTTDxYu5XI64gO', NULL, 'admin@gm.com', NULL, '', '', 10, 1678168986, 1678168986, 'alqvh-uTo-NSx86JuSUvY_5iG3xkpOQG_1678168986'),
	(81, '19-05009', 4, 'A', 1, 3, NULL, NULL, 'Erika Eunice', 'Dalampasig', 'Catalan', '', '2001-06-24', 'F', 'trainee', '', '$2y$13$.g3ejbgUTB6P0pJO4oYouOAwpw94FL4N4nPP.cSiELE1eBe4QIKKy', NULL, 'eedcatalan@bpsu.edu.ph', '2147483647', '', '001 Magsaysay Street, kitang 1 Limay Bataan', 10, 0, 0, NULL),
	(82, '19-03547', 4, 'A', 1, 3, NULL, NULL, 'Nick John', 'Gonzales', 'Gloria', NULL, '2001-07-05', 'M', '19-03547', '', '$2y$13$oZOi2gHPozyUtI7MBfC15.4w9wMK325Hn8onKm60CRp8ABmOWaDeC', NULL, 'njggloria@bpsu.edu.ph', '2147483647', '', 'Calaylayan Abucay, Bataan', 10, 0, 0, NULL),
	(83, '19-04831', 4, 'A', 1, 3, NULL, NULL, 'Christian Jay', 'Nival', 'Tuyor', NULL, '2001-07-19', 'M', '19-04831', '', '$2y$13$.fjkG86FhEl9CB50SaF39uJmCT8x.YjJr7E.grAXX6gjx8Lm/4dMy', NULL, 'cjntuyor@bpsu.edu.ph', '2147483647', '', '0875 Ilang-Ilang St. Alangan, Limay Bataan', 10, 0, 0, NULL),
	(84, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Richmon', '', 'Carabeo', '', '1990-07-18', 'M', 'richmon', 'xeKrkWbpp2Og4Y6YUh20HS2jr6R5L0F_', '$2y$13$0epnfH3pZrTPMKp6gF5b1e2aBznxdVdOiIHNKQYtkULmovvrvjv4G', NULL, 'rlcarabeo@bpsu.edu.ph', '2147483647', '', 'Balanga, Bataan', 9, 0, 0, 'Sgd_MPB1r01H37c9Khh5GmcDW_7604Ck_1682513410'),
	(85, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'Noel', '', 'Tolentino', '', '1991-09-28', 'M', 'coor', 'dbp4vxsZtzjnmOBtedNE8xYT4Hcu_LLD', '$2y$13$rVQSi3Ba4L.5EiIfymurTuA4pnO7uneXkaPZGuk5RbVQfe1NhTA5S', NULL, 'nntolentino@bpsu.edu.ph', '2147483647', '', 'Balanga, Bataan', 10, 0, 0, 'RRfFV67w_kcmmj0iFh1EbcojfF4jogdd_1682513529'),
	(86, NULL, NULL, NULL, NULL, 0, 3, 4, 'Ruby', 'DeLuna', 'De Leon', '', '1971-04-04', 'F', 'super', 'mREQyfo5iulCBUYgVjcrvB3jN5PxKb3q', '$2y$13$0gXZPfOYWZ1ixdCdnXERmO.DcKrLwyfrlCo7eHZBlILfKzSaOwKfe', NULL, 'rubydeluna18@yahoo.com', '2147483647', '', 'Abucay, Bataan', 10, 0, 0, 'bzZphT7jVIBRDZ2q-8b6lVcJWUJeaoei_1682513752'),
	(87, '19-01554', 4, 'E', 1, 3, 3, NULL, 'Erika Cate ', 'Manalo', 'DeLa Cruz', '', '2000-10-21', 'F', 'trainee1', 'N_P1h7-amljNPm6b_frZpS6E_f7YTu1r', '$2y$13$4G2a8RJupUdEAYi1CLpkZu3m9WS3Jys0d5kkZHt1YTy5yaFUkIf1S', NULL, 'ecmdelacruz@bpsu.edu.ph', '2147483647', '', '27 Mabini Street Culis Hermosa, Bataan', 10, 0, 0, 'jh7FfTpp1Ef__R1slL0nvNSHH_fvgnJ0_1682557365'),
	(88, '19-01903', 4, 'B', 1, 3, 3, NULL, 'Rose', 'DelaCruz', 'De Luna', '', '1995-05-18', 'F', 'roseanne', 'oc5TsH46MLanoq_EzHTC3152XXQ1T7fX', '$2y$13$/GzJm6CnBdncQgsEgc5UCuSHSOvvNhB6pp0ZWv/i4QXvxEkuJamMu', NULL, 'rose@gmail.com', '2147483647', '', 'Balanga, Bataan', 10, 0, 0, 'oR4sYfNsRr4cwYejPgKlrH0NmPVibGvz_1682585333'),
	(89, '19-00635', 4, 'D', 1, 3, NULL, NULL, 'Alfonso', 'Andraneda', 'Manago', NULL, '2000-07-16', 'M', '19-00635', '', '$2y$13$clnxZSwJOCtB.xjImFJO/e3ZRCKw4Goj5M3t9NuDc6b6aCLK/k8ES', NULL, 'aamanago@bpsu.edu.ph', '2147483647', '', 'Lot 34, Blk 3, La Katrina Village, Brgy. Sibacan, Balanga City, Bataan', 10, 0, 0, NULL),
	(90, '19-04616', 4, 'A', 1, 3, NULL, NULL, 'Neil Anthony', 'Cabrera', 'Aspiras', NULL, '2000-12-16', 'M', '19-04616', '', '$2y$13$BgkO.NlC3qBl.nmWpZfI5e.hAzMhZTJFH4HB2JSQLfSmnepFQSr0i', NULL, 'nacaspiras@bpsu.edu.ph', '2147483647', '', '765 Muli Avenue, Dinalupihan, Bataan', 10, 0, 0, NULL),
	(91, '19-02685', 4, 'C', 1, 3, NULL, NULL, 'Angelica', 'Aninon', 'Berdugo', NULL, '1999-04-14', 'F', '19-02685', '', '$2y$13$VYKPpudRl6VuMDKg.A5qLeioTTkrYkR5PRdEuUT2vi7SIhyj6fS32', NULL, 'aaberdugo@bpsu.edu.ph', '2147483647', '', '245 Cristina Village, Togatog, Orani, Bataan', 10, 0, 0, NULL),
	(92, '19-', 4, 'A', 1, 3, NULL, NULL, 'Tristan Joel', 'Mendiola', 'Binungcal', NULL, '2000-10-08', 'M', '19-', '', '$2y$13$gys2OFpBzoLrgjwwLd6d..I5/9KSa.nBBg67AWLyYEdnUlRpeVQHa', NULL, 'tjmbinungcal@bpsu.edu.ph', '2147483647', '', '0376 Camacho Street Tenejero, Balanga, Bataan', 10, 0, 0, NULL),
	(93, '19-00915', 4, 'C', 1, 3, NULL, NULL, 'Kennedy Lyndon', 'Santos', 'Santos', NULL, '2000-06-17', 'M', '19-00915', '', '$2y$13$H26xKsEi6Fzuf3PweaQK1.tTQVa6C4Mr4YlvcmYEOjyQK.6pUYodi', NULL, 'klssantos@bpsu.edu.ph', '2147483647', '', '1338 Howthorne Street, Mulawin Heights, Orani, Bataan', 10, 0, 0, NULL),
	(94, '19-03079', 4, 'D', 1, 3, NULL, NULL, 'Erickson', 'Cornelio', 'Yalo', NULL, '2000-08-22', 'M', '19-03079', '', '$2y$13$1yBvviPKXvQbSCOXjdcNbeOrU2QTWDUpYQGMjKILV.7Zm.x.3opmG', NULL, 'ecyalo@bpsu.edu.ph', '2147483647', '', '1678 Sampaguita Street, Talimundoc, Orani, Bataan', 10, 0, 0, NULL),
	(95, '19-01601', 4, 'A', 1, 3, NULL, NULL, 'Jan Andrei', 'Rafael', 'Catubuan', NULL, '2001-04-27', 'M', '19-01601', '', '$2y$13$vYmYT90zWMJ2bMkoMJnFveuIog7mTPEZcRCWHYzt1oavFbD7KP.wC', NULL, 'jarcatubuan@bpsu.edu.ph', '2147483647', '', '0246 Silverland Phase 3, Duale, Limay, Bataan', 10, 0, 0, NULL),
	(96, '19-03565', 4, 'A', 1, 3, NULL, NULL, 'Jom Vincent', 'Gamboa', 'Bacarizas', NULL, '2001-09-09', 'M', '19-03565', '', '$2y$13$mTk.M574HBvnvwyGxK6R9eMS5yNCd4ZPglXLdXetulk6oSjB9A1PO', NULL, 'jvgbacarizas@bpsu.edu.ph', '2147483647', '', '0537 Lower Tundol, Reformista, Limay, Bataan', 10, 0, 0, NULL),
	(97, '19-019010', 4, 'C', 1, 3, 1, NULL, 'Anne', 'Lucas', 'Panganiban', '', '2000-09-08', 'F', 'anne', 'yzLcK9cMcqbvEmNntKtI5lSI1bKMPwlW', '$2y$13$7lYjR4Cg/vRwOXWPfch2LuJ2uC4r4cUmy76Zak/u5GWT.0NW35YNK', NULL, 'anne@yahoo.com', '2147483647', '', 'Abucay, Bataan', 10, 0, 0, 'd22xyu6mmkxjJkdc8FhXJH-M0yQlmRPP_1682687345'),
	(98, '19-01905', 4, 'A', 1, 3, 1, NULL, 'Jhaema', 'Santos', 'Nicdao', '', '2000-09-05', 'F', 'blinkot4', 'ZgHZxoE1KK9uz5XyXGjqvEyPgZswOXTC', '$2y$13$2./igfaQgl2V8eO0fdlGGejEBxFoYSbduPZx6uiB54YuArP28WbPa', NULL, 'jsnicdao@bpsu.edu.ph', '2147483647', '', '#293 Purok 1 Colo Dinalupihan, Bataan', 10, 0, 0, 'uoj84GX8WJ4medQd3Z36BLm5awlu59JG_1683291099'),
	(99, '123434', 4, 'A', 1, 3, 2, NULL, 'Mark Angelo', 'Dayagmil', 'Bon', '', '2005-05-11', 'M', 'madbon_hsMdV', '5mPnDubiDQZ0ikY4UHC9D3ulBXI4J8_r', '$2y$13$a76dVMTX6rZ6LU6mwVqNI.7Pr.EV7aRXGSmEw5hxR6ylHgEFmOex2', NULL, 'madbon@bpsu.edu.ph', '9902020202', '', '123232 st.', 10, 0, 0, 'SuaXuAP1k9XOJberk9AvrL-EJbkDoO9y_1683782477'),
	(100, NULL, NULL, NULL, NULL, 0, 2, NULL, 'Lionel', '', 'Messi', '', NULL, '', 'lmessi_WhDXS', '1jtHoMX9eyObjUozRpVoUqlY0deLBJD6', '$2y$13$yFhayEcOpzWHRq9hSQt7CuVpcGRKRHo9odzVGs/XGZNV9gA1OsEsS', NULL, 'lionelmessi@gm.com', '', '', '', 10, 0, 0, 'XixXDWNkkOxFE4wETZu2TebZs3ELEylo_1683788380'),
	(103, '909029', NULL, '', NULL, NULL, NULL, NULL, 'Mark', 'El Trible', 'Bon Reyes', '', NULL, '', 'metbonreyes_53Jv9', '_bRAxo7YxIKBcvfwKMvZH43G0o3HXw-D', '$2y$13$GRSjDB5nh.19DMR4eU/YmuK69ozunL9QnztQtzF5qPqjL9RlTI2kS', NULL, 'metbonreyes@bpsu.edu.ph', '', '', '', 10, 0, 0, 'ZKEms6Mz7SnUKaMHE8mVL1pIUMWUQzaT_1683857366'),
	(104, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yes', '', 'yes', '', '2005-05-11', 'M', 'yyes_mVf_i', 'I56pD6ICSc1hM3muCzU8MBVwfnr9wgLb', '$2y$13$XOv31mL8tSAlytwL9w9x0OIgv1Q8aWApskCQdXk3o9jzbcq7l8ZfG', NULL, 'yesyes@gmail.com', '0920320323', '3433423', 'somere st.', 10, 0, 0, '1-jk_gMYlXpqHqGvxL1Gbn28CioXHvPG_1683859258'),
	(105, '12323232', NULL, '', NULL, NULL, NULL, NULL, 'marcus', 'el terible', 'yas terible', '', NULL, '', 'metyasterible_47A7A', 'bIhyNaZZj1H_HSG2_FiLfUj1Oz8dSRGD', '$2y$13$/bH/XKl44oBQWbCYYUygb.UmXww9ziOoaNEiJvp.H2jFn1LTVRLlu', NULL, 'metyasterible@bpsu.edu.ph', '', '', '', 10, 0, 0, 'AuYwPXb2WclXkY403laG40tA9I36s2ye_1683869968'),
	(106, '19-019051', 4, 'A', 1, 3, 1, NULL, 'Jhaema', 'Del Mundo', 'Nicdao', '', '2000-09-05', 'M', 'jdmnicdao', 'V4BRjBPtuAzjOi_WctAzDzlZpVAd9BOv', '$2y$13$JoQvq5ZvS6ZiaW14kVL3Sepxm.GNXH4XWSahVZTwhV4Zi/GpssA6G', NULL, 'jdmnicdao@yead.com', '9123456789', '', '033B Somewhere St.', 10, 0, 0, '7MMoCkoP5MGtbR8rH18BfUCmNKd-5Kyu_1683873505'),
	(107, '19-050091', 4, 'A', 1, 3, NULL, NULL, 'Ericka Eunice', 'El Nino', 'Catalan', NULL, '2001-06-24', 'F', 'eeencatalan_gksmp', 'GnY4Rwdoh-54ROUUVgsIDWrFOrrnG0sN', '$2y$13$L0F7X.nS6Wf1xJgsTOPwF.VaWu2aiv7Ai4cPhsusgZ1j5pVMAgYGW', NULL, 'eeencatalan@bpsu.edu.ph', '9123456788', '', '031B Somewhere St.', 10, 0, 0, 'sioOhIfbl98Zjh55N3t7mJpSA-Ml7gPD_1683873506'),
	(108, '19-035471', 4, 'A', 1, 3, NULL, NULL, 'Nick John', 'Rantesema', 'Gloria', NULL, '2001-07-05', 'F', 'njrgloria_yz6Ct', 'VJYoS4IJs7t3JWuoXaEBKX_-7iWxr1gp', '$2y$13$/hppLvRpZFFjTozMMU9ppeu43pzNCjp343z52Y3WS06VLYmka2am2', NULL, 'njrgloria@bpsu.edu.ph', '9123356788', '', '030B Somewhere St.', 10, 0, 0, 'p_gHOMP5op8dh4-V6CAMUKBXzNYVtCHI_1683873507'),
	(109, '19-048311', 4, 'A', 1, 3, NULL, NULL, 'Christian Jay', 'Zambales', 'Tuyor', NULL, '2001-07-19', 'F', 'cjztuyor_rmP2p', '_7wkElNSS28vfTipAldNB0TqUpLYnzqS', '$2y$13$gigNwPKnVHPLATylfjmpPu36uHMAS5WIzXXpU5INj3p33lfG6deSq', NULL, 'cjztuyor@bpsu.edu.ph', '9423356788', '', '042B Somewhere St.', 10, 0, 0, 'eAF47kteHgny8bXKfzayx069PTEJ00hx_1683873508'),
	(110, '78292920', 3, 'C', 2, 5, 3, NULL, 'Preferado', '', 'Reyes', '', '2005-05-12', 'M', 'preyes_WPl-0', 'XBPJ8afWgwq_ygVzmMGlLZdj4LeGnI6u', '$2y$13$Mu6ceYW2f0cSo.jOTZ23ZuFvzViR7pjLZZ7EFL97UAyQffWrDsLZm', NULL, 'preyes@bpsu.edu.ph', '9790009320', '', '909209 johnwick st.', 10, 0, 0, '2hqgffR4x6Zxpw_vfvNQajeExJVtjtur_1683874327'),
	(111, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fsdfdsf', '', 'fsdfdf', '', NULL, '', 'ffsdfdf_F6V-2', '5ZsjVDlaM2aYaW-bgdswG47SSHfg5B9U', '$2y$13$8Y3bdhTh3UqFhsNExUQn/.x3VTu3iSt.88J/qHvcLKTEGGxymuLLu', NULL, 'ffsdfdf@bpsu.edu.ph', '', '', '', 10, 0, 0, 'Ejww7d1De07FbkDHLYuBgZCroZkCbb8u_1683874461'),
	(112, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'James', '', 'Robles', '', NULL, '', 'jrobles_kT1Gs', 'Y5ArN9fGaAGq2KqtBpG0YlWhiUbJq_ir', '$2y$13$yG32oJ2q2urgRe7V/9.r6etOdHfakCdNmexnzgK5jy3vzLxaRSR1y', NULL, 'jamesrobles@gmail.com', '', '', '', 10, 0, 0, '49Ufop4ISam97_UxHa8y5DQvqhw64dNz_1683874528');

-- Dumping structure for table db_bpsu_timesheet.user_archive
CREATE TABLE IF NOT EXISTS `user_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_status` int(11) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_bpsu_timesheet.user_archive: ~3 rows (approximately)
INSERT INTO `user_archive` (`id`, `user_id`, `user_status`, `date_time`) VALUES
	(1, 84, 9, '2023-05-08 21:55:20'),
	(2, 101, 9, '2023-05-12 09:46:26'),
	(3, 102, 9, '2023-05-12 13:37:45');

-- Dumping structure for table db_bpsu_timesheet.user_company
CREATE TABLE IF NOT EXISTS `user_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id',
  `user_id` int(11) DEFAULT NULL COMMENT 'foreign key id of user table (trainee or supervisor)',
  `ref_company_id` int(11) DEFAULT NULL COMMENT 'foreign key id of ref_company table (assigned company)',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `ref_company_id` (`ref_company_id`),
  KEY `id` (`id`),
  CONSTRAINT `user_company_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='List of users (trainee and supervisor) assigned company';

-- Dumping data for table db_bpsu_timesheet.user_company: ~16 rows (approximately)
INSERT INTO `user_company` (`id`, `user_id`, `ref_company_id`) VALUES
	(1, 84, NULL),
	(2, 85, NULL),
	(3, 86, 1),
	(5, 87, 1),
	(6, 88, 1),
	(7, 97, 1),
	(8, 98, 1),
	(9, 81, NULL),
	(10, 99, 1),
	(11, 100, 1),
	(14, 103, NULL),
	(15, 104, 1),
	(16, 105, NULL),
	(17, 106, 2),
	(18, 110, 4),
	(19, 111, NULL),
	(20, 112, 5);

-- Dumping structure for table db_bpsu_timesheet.user_timesheet
CREATE TABLE IF NOT EXISTS `user_timesheet` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id',
  `user_id` int(11) DEFAULT NULL COMMENT 'foreign key id of user table (trainee)',
  `time_in_am` time DEFAULT NULL COMMENT 'time in (AM)',
  `time_out_am` time DEFAULT NULL COMMENT 'time out (AM)',
  `time_in_pm` time DEFAULT NULL COMMENT 'time in (PM)',
  `time_out_pm` time DEFAULT NULL COMMENT 'time out (PM)',
  `date` date DEFAULT NULL COMMENT 'date recorded',
  `remarks` varchar(50) DEFAULT NULL COMMENT 'remarks details per row',
  `status` int(11) NOT NULL COMMENT 'PENDING or VALIDATED',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `time_in_am` (`time_in_am`),
  KEY `time_out_am` (`time_out_am`),
  KEY `time_in_pm` (`time_in_pm`),
  KEY `time_out_pm` (`time_out_pm`),
  KEY `date` (`date`),
  KEY `id` (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='This table serves as storage of time in/out that displays in the DTR of trainee';

-- Dumping data for table db_bpsu_timesheet.user_timesheet: ~24 rows (approximately)
INSERT INTO `user_timesheet` (`id`, `user_id`, `time_in_am`, `time_out_am`, `time_in_pm`, `time_out_pm`, `date`, `remarks`, `status`) VALUES
	(1, 80, NULL, NULL, '21:10:25', '21:13:00', '2023-04-26', '', 1),
	(2, 87, NULL, NULL, NULL, NULL, '2023-04-27', 'earthquake drill', 1),
	(3, 87, NULL, NULL, '13:06:52', '15:55:53', '2023-04-28', NULL, 1),
	(4, 87, NULL, NULL, NULL, NULL, '2023-04-03', 'Holiday for example', 1),
	(6, 98, '08:03:11', NULL, NULL, '12:03:50', '2023-04-10', NULL, 0),
	(7, 98, '08:01:54', '11:33:04', '13:01:15', '18:01:52', '2023-05-06', NULL, 0),
	(8, 98, '08:03:32', NULL, NULL, '12:01:03', '2023-03-09', NULL, 0),
	(9, 98, NULL, NULL, '13:01:26', '13:01:27', '2023-03-09', NULL, 0),
	(10, 98, NULL, NULL, '17:03:11', '19:13:56', '2023-03-09', NULL, 0),
	(11, 98, '08:01:22', '11:56:16', '13:01:00', '19:00:48', '2023-03-10', NULL, 0),
	(12, 98, '08:04:58', '11:59:29', '13:01:22', '18:31:10', '2023-03-11', NULL, 0),
	(13, 98, NULL, NULL, '14:13:47', NULL, '2023-05-06', NULL, 0),
	(14, 98, '08:01:58', NULL, NULL, '12:01:52', '2023-03-12', NULL, 0),
	(15, 87, NULL, NULL, '15:01:47', '16:20:39', '2023-04-28', NULL, 1),
	(16, 87, NULL, NULL, NULL, NULL, '2023-04-01', 'April fools day', 0),
	(17, 87, NULL, NULL, NULL, NULL, '2023-05-10', 'INDEPENCE DAY', 1),
	(18, 87, NULL, NULL, NULL, NULL, '2023-05-14', 'Araw ng Kagitingan', 1),
	(19, 87, NULL, NULL, NULL, NULL, '2023-05-20', 'Special Non-working day', 1),
	(22, 87, NULL, NULL, NULL, NULL, '2023-05-24', 'Sample holiday', 1),
	(24, 87, NULL, NULL, NULL, NULL, '2023-05-29', 'sample', 1),
	(25, 87, NULL, NULL, '15:10:15', '17:00:00', '2023-04-20', 'sample holiday kaibigan', 1),
	(26, 87, '08:42:14', '11:59:00', '13:30:00', '13:45:00', '2023-04-22', 'sample holiday in 22 s', 1),
	(27, 87, NULL, NULL, '13:45:06', '13:45:14', '2023-04-22', 'Holiday', 1),
	(29, 87, NULL, NULL, '13:45:21', '13:45:31', '2023-05-13', NULL, 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
