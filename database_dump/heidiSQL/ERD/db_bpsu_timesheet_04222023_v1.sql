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

-- Dumping data for table db_bpsu_timesheet.announcement: ~1 rows (approximately)
INSERT INTO `announcement` (`id`, `viewer_type`, `user_id`, `content_title`, `content`, `date_time`) VALUES
	(1, 'assigned_program', 37, '', 'Be ready to your thesis defense on Wednesday. Good luck.', '2023-04-09 23:25:05');

-- Dumping structure for table db_bpsu_timesheet.announcement_program_tags
CREATE TABLE IF NOT EXISTS `announcement_program_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID (auto generated)',
  `announcement_id` int(11) DEFAULT NULL COMMENT 'foreign key (announcement table)',
  `ref_program_id` int(11) DEFAULT NULL COMMENT 'foreign key (ref_program table)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='This table will store data on which courses/programs will see the announcement';

-- Dumping data for table db_bpsu_timesheet.announcement_program_tags: ~1 rows (approximately)
INSERT INTO `announcement_program_tags` (`id`, `announcement_id`, `ref_program_id`) VALUES
	(1, 1, 1);

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

-- Dumping data for table db_bpsu_timesheet.auth_assignment: ~21 rows (approximately)
INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
	('Administrator', '2', NULL),
	('Administrator', '39', NULL),
	('Administrator', '40', NULL),
	('CompanySupervisor', '38', NULL),
	('CompanySupervisor', '41', NULL),
	('CompanySupervisor', '47', NULL),
	('OjtCoordinator', '37', NULL),
	('OjtCoordinator', '42', NULL),
	('OjtCoordinator', '43', NULL),
	('OjtCoordinator', '45', NULL),
	('Trainee', '35', NULL),
	('Trainee', '44', NULL),
	('Trainee', '46', NULL),
	('Trainee', '64', NULL),
	('Trainee', '65', NULL),
	('Trainee', '66', NULL),
	('Trainee', '67', NULL),
	('Trainee', '68', NULL),
	('Trainee', '69', NULL),
	('Trainee', '70', NULL),
	('Trainee', '71', NULL);

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

-- Dumping data for table db_bpsu_timesheet.auth_item: ~73 rows (approximately)
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

-- Dumping data for table db_bpsu_timesheet.auth_item_child: ~102 rows (approximately)
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
	('Administrator', 'upload-others-esig'),
	('Administrator', 'USER-MANAGEMENT-MODULE'),
	('Administrator', 'view-column-course-program'),
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='here you can see the coordinator''s assigned programs/courses';

-- Dumping data for table db_bpsu_timesheet.coordinator_programs: ~5 rows (approximately)
INSERT INTO `coordinator_programs` (`id`, `user_id`, `ref_program_id`, `ref_program_major_id`) VALUES
	(3, 42, 2, NULL),
	(4, 43, 3, NULL),
	(9, 45, 1, NULL),
	(10, 45, 2, NULL),
	(11, 37, 1, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=239 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='in this table you can see all the files uploaded to the system';

-- Dumping data for table db_bpsu_timesheet.files: ~91 rows (approximately)
INSERT INTO `files` (`id`, `user_id`, `model_name`, `model_id`, `file_name`, `extension`, `file_hash`, `remarks`, `created_at`, `user_timesheet_time`, `user_timesheet_id`) VALUES
	(124, 35, 'UserFacialRegister', 35, '6434e9060fc6f.png', 'png', '6434e9060fc6f.png', NULL, 1681189126, NULL, NULL),
	(125, 35, 'UserFacialRegister', 35, '6434e9778d9c7.png', 'png', '6434e9778d9c7.png', NULL, 1681189239, NULL, NULL),
	(126, 35, 'UserFacialRegister', 35, '6434e9956dbf2.png', 'png', '6434e9956dbf2.png', NULL, 1681189269, NULL, NULL),
	(127, 35, 'UserFacialRegister', 35, '6434e9bf67a0b.png', 'png', '6434e9bf67a0b.png', NULL, 1681189311, NULL, NULL),
	(129, 46, 'UserFacialRegister', 46, '6434ea0b655d8.png', 'png', '6434ea0b655d8.png', NULL, 1681189387, NULL, NULL),
	(130, 46, 'UserFacialRegister', 46, '6434ea0eec953.png', 'png', '6434ea0eec953.png', NULL, 1681189390, NULL, NULL),
	(131, 46, 'UserFacialRegister', 46, '6434ea127bb90.png', 'png', '6434ea127bb90.png', NULL, 1681189394, NULL, NULL),
	(132, 46, 'UserFacialRegister', 46, '6434ea15957b6.png', 'png', '6434ea15957b6.png', NULL, 1681189397, NULL, NULL),
	(133, 46, 'UserFacialRegister', 46, '6434ea18a66b2.png', 'png', '6434ea18a66b2.png', NULL, 1681189400, NULL, NULL),
	(134, 46, 'UserFacialRegister', 46, '6434ea1dc737f.png', 'png', '6434ea1dc737f.png', NULL, 1681189405, NULL, NULL),
	(135, 46, 'UserFacialRegister', 46, '6434eaa607e01.png', 'png', '6434eaa607e01.png', NULL, 1681189542, NULL, NULL),
	(136, 35, 'UserFacialRegister', 35, '6434eb2408329.png', 'png', '6434eb2408329.png', NULL, 1681189668, NULL, NULL),
	(137, 35, 'UserFacialRegister', 35, '6434eb3c2e9dd.png', 'png', '6434eb3c2e9dd.png', NULL, 1681189692, NULL, NULL),
	(138, 35, 'UserFacialRegister', 35, '6434eb3fc6397.png', 'png', '6434eb3fc6397.png', NULL, 1681189695, NULL, NULL),
	(143, 46, 'UserFacialRegister', 46, '6434eba880710.png', 'png', '6434eba880710.png', NULL, 1681189800, NULL, NULL),
	(144, 46, 'UserFacialRegister', 46, '6434ebe297cff.png', 'png', '6434ebe297cff.png', NULL, 1681189858, NULL, NULL),
	(145, 46, 'UserFacialRegister', 46, '6434ebe7e5d65.png', 'png', '6434ebe7e5d65.png', NULL, 1681189863, NULL, NULL),
	(146, 46, 'UserFacialRegister', 46, '6434ebec059fd.png', 'png', '6434ebec059fd.png', NULL, 1681189868, NULL, NULL),
	(147, 46, 'UserTimesheet', 46, '6434ec6e27829.png', 'png', '6434ec6e27829.png', NULL, 1681189998, '13:13:18', 14),
	(148, 35, 'UserTimesheet', 35, '6434eca67785d.png', 'png', '6434eca67785d.png', NULL, 1681190054, '13:14:14', 15),
	(151, 35, 'UserTimesheet', 35, '6434eebb157d8.png', 'png', '6434eebb157d8.png', NULL, 1681190587, '13:23:07', 15),
	(152, 35, 'UserTimesheet', 35, '6434eed375374.png', 'png', '6434eed375374.png', NULL, 1681190611, '13:23:31', 16),
	(153, 35, 'UserTimesheet', 35, '643500922e17d.png', 'png', '643500922e17d.png', NULL, 1681195154, '14:39:14', 16),
	(154, 35, 'UserTimesheet', 35, '643763c774d27.png', 'png', '643763c774d27.png', NULL, 1681351623, '10:07:03', 17),
	(155, 35, 'UserTimesheet', 35, '643764644223c.png', 'png', '643764644223c.png', NULL, 1681351780, '10:09:40', 17),
	(156, 35, 'UserTimesheet', 35, '6437647a144d5.png', 'png', '6437647a144d5.png', NULL, 1681351802, '10:10:02', 18),
	(157, 35, 'UserTimesheet', 35, '64376499b9d0e.png', 'png', '64376499b9d0e.png', NULL, 1681351833, '10:10:33', 18),
	(158, 44, 'UserFacialRegister', 44, '643d008c463e4.png', 'png', '643d008c463e4.png', NULL, 1681719436, NULL, NULL),
	(159, 44, 'UserFacialRegister', 44, '643d00902a333.png', 'png', '643d00902a333.png', NULL, 1681719440, NULL, NULL),
	(160, 44, 'UserFacialRegister', 44, '643d0097cbb52.png', 'png', '643d0097cbb52.png', NULL, 1681719447, NULL, NULL),
	(161, 44, 'UserFacialRegister', 44, '643d009b2bdb2.png', 'png', '643d009b2bdb2.png', NULL, 1681719451, NULL, NULL),
	(162, 44, 'UserFacialRegister', 44, '643d009e521f9.png', 'png', '643d009e521f9.png', NULL, 1681719454, NULL, NULL),
	(163, 44, 'UserFacialRegister', 44, '643d00a13fa86.png', 'png', '643d00a13fa86.png', NULL, 1681719457, NULL, NULL),
	(164, 44, 'UserFacialRegister', 44, '643d00a42ea74.png', 'png', '643d00a42ea74.png', NULL, 1681719460, NULL, NULL),
	(165, 44, 'UserFacialRegister', 44, '643d00a6767ad.png', 'png', '643d00a6767ad.png', NULL, 1681719462, NULL, NULL),
	(166, 44, 'UserTimesheet', 44, '643d00c9b4127.png', 'png', '643d00c9b4127.png', NULL, 1681719497, '16:18:17', 19),
	(167, 35, 'UserFacialRegister', 35, '643d018281032.png', 'png', '643d018281032.png', NULL, 1681719682, NULL, NULL),
	(168, 35, 'UserFacialRegister', 35, '643d3cff04c8e.png', 'png', '643d3cff04c8e.png', NULL, 1681734911, NULL, NULL),
	(169, 35, 'UserFacialRegister', 35, '643d3cff33514.png', 'png', '643d3cff33514.png', NULL, 1681734911, NULL, NULL),
	(170, 35, 'UserFacialRegister', 35, '643d3d06aa853.png', 'png', '643d3d06aa853.png', NULL, 1681734918, NULL, NULL),
	(171, 35, 'UserFacialRegister', 35, '643d3d09e2ed7.png', 'png', '643d3d09e2ed7.png', NULL, 1681734921, NULL, NULL),
	(172, 35, 'UserFacialRegister', 35, '643d3d0e584d5.png', 'png', '643d3d0e584d5.png', NULL, 1681734926, NULL, NULL),
	(173, 35, 'UserFacialRegister', 35, '643d3d11f2ed7.png', 'png', '643d3d11f2ed7.png', NULL, 1681734930, NULL, NULL),
	(174, 35, 'UserTimesheet', 35, '6442954d1f439.png', 'png', '6442954d1f439.png', NULL, 1682085197, '21:53:17', 20),
	(175, 35, 'UserTimesheet', 35, '6442954d7c928.png', 'png', '6442954d7c928.png', NULL, 1682085197, '21:53:17', 20),
	(176, 35, 'UserTimesheet', 35, '6442959fab162.png', 'png', '6442959fab162.png', NULL, 1682085279, '21:54:39', 21),
	(177, 35, 'UserTimesheet', 35, '6442959fdb0d8.png', 'png', '6442959fdb0d8.png', NULL, 1682085279, '21:54:39', 21),
	(178, 35, 'UserTimesheet', 35, '644296d5d74f7.png', 'png', '644296d5d74f7.png', NULL, 1682085589, '21:59:49', 22),
	(179, 35, 'UserTimesheet', 35, '644297bc0647e.png', 'png', '644297bc0647e.png', NULL, 1682085820, '22:03:40', 22),
	(181, 35, 'UserTimesheet', 35, '644298196b826.png', 'png', '644298196b826.png', NULL, 1682085913, '22:05:13', 24),
	(182, 35, 'UserTimesheet', 35, '644298198279b.png', 'png', '644298198279b.png', NULL, 1682085913, '22:05:13', 24),
	(185, 35, 'UserTimesheet', 35, '64429a2313875.png', 'png', '64429a2313875.png', NULL, 1682086435, '22:13:55', 26),
	(186, 35, 'UserTimesheet', 35, '64429a239afe2.png', 'png', '64429a239afe2.png', NULL, 1682086435, '22:13:55', 26),
	(187, 35, 'UserTimesheet', 35, '64429d96cb019.png', 'png', '64429d96cb019.png', NULL, 1682087318, '22:28:38', 27),
	(188, 35, 'UserTimesheet', 35, '64429ddae85e3.png', 'png', '64429ddae85e3.png', NULL, 1682087387, '22:29:47', 27),
	(189, 35, 'UserTimesheet', 35, '64429ddb55188.png', 'png', '64429ddb55188.png', NULL, 1682087387, '22:29:47', 28),
	(190, 35, 'UserTimesheet', 35, '64429e09c2d1d.png', 'png', '64429e09c2d1d.png', NULL, 1682087433, '22:30:33', 28),
	(191, 35, 'UserTimesheet', 35, '64429e09f031a.png', 'png', '64429e09f031a.png', NULL, 1682087434, '22:30:34', 29),
	(192, 35, 'UserTimesheet', 35, '64429e2022060.png', 'png', '64429e2022060.png', NULL, 1682087456, '22:30:56', 29),
	(193, 35, 'UserTimesheet', 35, '64429e203c1b4.png', 'png', '64429e203c1b4.png', NULL, 1682087456, '22:30:56', 30),
	(194, 35, 'UserTimesheet', 35, '64429e6d8f623.png', 'png', '64429e6d8f623.png', NULL, 1682087533, '22:32:13', 30),
	(195, 35, 'UserTimesheet', 35, '64429e6dde65d.png', 'png', '64429e6dde65d.png', NULL, 1682087533, '22:32:13', 31),
	(196, 35, 'UserTimesheet', 35, '64429f6689f4f.png', 'png', '64429f6689f4f.png', NULL, 1682087782, '22:36:22', 31),
	(197, 35, 'UserTimesheet', 35, '64429f835de55.png', 'png', '64429f835de55.png', NULL, 1682087811, '22:36:51', 32),
	(198, 35, 'UserTimesheet', 35, '64429fa5f0733.png', 'png', '64429fa5f0733.png', NULL, 1682087846, '22:37:26', 32),
	(199, 35, 'UserTimesheet', 35, '64429fa62f0c1.png', 'png', '64429fa62f0c1.png', NULL, 1682087846, '22:37:26', 33),
	(200, 35, 'UserTimesheet', 35, '6442a0b7f064d.png', 'png', '6442a0b7f064d.png', NULL, 1682088120, '22:42:00', 33),
	(201, 35, 'UserTimesheet', 35, '6442a0c4f4054.png', 'png', '6442a0c4f4054.png', NULL, 1682088133, '22:42:13', 34),
	(202, 35, 'UserTimesheet', 35, '6442a0dccfbb4.png', 'png', '6442a0dccfbb4.png', NULL, 1682088156, '22:42:36', 34),
	(203, 35, 'UserTimesheet', 35, '6442a3ad46c77.png', 'png', '6442a3ad46c77.png', NULL, 1682088877, '22:54:37', 35),
	(205, 64, 'UserFacialRegister', 64, '6442a4e017b0f.png', 'png', '6442a4e017b0f.png', NULL, 1682089184, NULL, NULL),
	(206, 64, 'UserFacialRegister', 64, '6442a4f6541e5.png', 'png', '6442a4f6541e5.png', NULL, 1682089206, NULL, NULL),
	(207, 64, 'UserFacialRegister', 64, '6442a4f991a75.png', 'png', '6442a4f991a75.png', NULL, 1682089209, NULL, NULL),
	(208, 64, 'UserFacialRegister', 64, '6442a4fd3856e.png', 'png', '6442a4fd3856e.png', NULL, 1682089213, NULL, NULL),
	(209, 64, 'UserFacialRegister', 64, '6442a50250470.png', 'png', '6442a50250470.png', NULL, 1682089218, NULL, NULL),
	(210, 64, 'UserTimesheet', 64, '6442a519d4c29.png', 'png', '6442a519d4c29.png', NULL, 1682089241, '23:00:41', 36),
	(211, 35, 'UserTimesheet', 35, '6442a574366aa.png', 'png', '6442a574366aa.png', NULL, 1682089332, '23:02:12', 35),
	(212, 35, 'UserTimesheet', 35, '6442a656b9feb.png', 'png', '6442a656b9feb.png', NULL, 1682089558, '23:05:58', 37),
	(213, 64, 'UserTimesheet', 64, '6442a6705f1e0.png', 'png', '6442a6705f1e0.png', NULL, 1682089584, '23:06:24', 36),
	(214, 35, 'UserTimesheet', 35, '6442a6927c085.png', 'png', '6442a6927c085.png', NULL, 1682089618, '23:06:58', 37),
	(215, 35, 'SubmissionThread', 4, 'APRIL AR', 'pdf', '3acd92f4baddfe96444e7580476dcd33', NULL, 1682091164, NULL, NULL),
	(223, 35, 'UserData', 35, 'esig1', 'png', '4a9e7132ed30566b8b88d42b5b7fdfb9', NULL, 1682128265, NULL, NULL),
	(224, 35, 'ProfilePhoto', 35, 'WIN_20230125_14_44_59_Pro', 'jpg', '89f3269392b56d5205c04c011478fdfe', NULL, 1682128275, NULL, NULL),
	(225, 35, 'ProfilePhoto', 35, '12312323', 'png', '821a906faea6c9a487ecd275a6eb883f', NULL, 1682128368, NULL, NULL),
	(226, 35, 'ProfilePhoto', 35, 'WIN_20230125_14_44_59_Pro', 'jpg', '30184148c0561bc9d1da9302e647fd5c', NULL, 1682128382, NULL, NULL),
	(227, 35, 'UserData', 35, 'esig2', 'png', 'eb91b08bcc487ed8fb1861f5b7f7332d', NULL, 1682128390, NULL, NULL),
	(228, 35, 'UserTimesheet', 35, '64434ead41ef0.png', 'png', '64434ead41ef0.png', NULL, 1682132653, '11:04:13', 38),
	(229, 35, 'UserTimesheet', 35, '64434ec6a2768.png', 'png', '64434ec6a2768.png', NULL, 1682132678, '11:04:38', 38),
	(230, 35, 'UserTimesheet', 35, '64434ed5a7b8c.png', 'png', '64434ed5a7b8c.png', NULL, 1682132693, '11:04:53', 39),
	(232, 35, 'UserTimesheet', 35, '64434ffeb7f42.png', 'png', '64434ffeb7f42.png', NULL, 1682132990, '11:09:50', 39),
	(237, 35, 'UserTimesheet', 35, '6443bd02aec03.png', 'png', '6443bd02aec03.png', NULL, 1682160898, '18:54:58', 39);

-- Dumping structure for table db_bpsu_timesheet.migration
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL COMMENT 'migration file name',
  `apply_time` int(11) DEFAULT NULL COMMENT 'date time migrated',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='auto migrated table once you install the Yii2 PHP framework (serves as repository of migrated default tables of Yii2 Framework)';

-- Dumping data for table db_bpsu_timesheet.migration: ~10 rows (approximately)
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
	('m230402_125314_add_permission_assignment', 1680440013);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='reference table: you can see the encoded company details';

-- Dumping data for table db_bpsu_timesheet.ref_company: ~3 rows (approximately)
INSERT INTO `ref_company` (`id`, `name`, `address`, `latitude`, `longitude`, `contact_info`) VALUES
	(1, 'Department of the Interior and Local Government - Central Office', 'DILG-NAPOLCOM Center, Edsa Corner Quezon Avenue, Quezon City, Metro Manila, Philippines', 14.6447149, 121.0367449, ''),
	(2, 'DOST-Philippine Institute of Volcanology and Seismology', 'PHIVOLCS, Diliman, Quezon City, Metro Manila, Philippines', 14.6521266, 121.0587245, ''),
	(3, 'Department of Public Works and Highways - Head Office', 'DPWH Head Office, Bonifacio Drive Port Area, 652 Zone 068, Manila, Metro Manila, Philippines', 14.5878506, 120.9722474, '');

-- Dumping structure for table db_bpsu_timesheet.ref_department
CREATE TABLE IF NOT EXISTS `ref_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique ID (auto generated)',
  `title` varchar(250) DEFAULT NULL COMMENT 'department name',
  `abbreviation` varchar(20) DEFAULT NULL COMMENT 'department abbreviation',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='reference table: the company''s departments are stored here';

-- Dumping data for table db_bpsu_timesheet.ref_department: ~3 rows (approximately)
INSERT INTO `ref_department` (`id`, `title`, `abbreviation`) VALUES
	(1, 'IT Department', ''),
	(2, 'Human Resource Department', ''),
	(3, 'Financial Management Department', '');

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
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `required_uploading` (`required_uploading`),
  KEY `enable_tagging` (`enable_tagging`),
  KEY `enable_commenting` (`enable_commenting`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Reference table: types of task';

-- Dumping data for table db_bpsu_timesheet.ref_document_type: ~3 rows (approximately)
INSERT INTO `ref_document_type` (`id`, `title`, `action_title`, `required_uploading`, `enable_tagging`, `enable_commenting`) VALUES
	(1, 'Trainees Evaluation Form', 'Submit Trainees Evaluation Form', 1, 1, 0),
	(3, 'Accomplishment Report', 'Submit Accomplishment Report', 1, 0, 1),
	(5, 'Activity Reminder', 'Create Activity Reminder', 0, 0, 0);

-- Dumping structure for table db_bpsu_timesheet.ref_position
CREATE TABLE IF NOT EXISTS `ref_position` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id of position (auto generated)',
  `position` varchar(100) DEFAULT NULL COMMENT 'position title',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Reference table: list of company positions';

-- Dumping data for table db_bpsu_timesheet.ref_position: ~5 rows (approximately)
INSERT INTO `ref_position` (`id`, `position`) VALUES
	(1, 'Software Engineer'),
	(2, 'HR Head'),
	(3, 'HR Staff'),
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
	(1, 'Bachelor of Science in Information Technology', 'BSIT', 486),
	(2, 'Bachelor of Science in Computer Science', 'BSCS', 162),
	(3, 'Bachelor of Science in Computer Engineering', 'BSCE', 0),
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
  KEY `ref_program_id` (`ref_program_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Refererence table: list of program''s majors';

-- Dumping data for table db_bpsu_timesheet.ref_program_major: ~1 rows (approximately)
INSERT INTO `ref_program_major` (`id`, `ref_program_id`, `title`, `abbreviation`) VALUES
	(3, 1, 'Network and Web Application', 'NW');

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
  KEY `date_time` (`date_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='transaction table: this table allows user to store messages/comment regarding the submitted document (AR) or performed tasks (creating activity reminder) (messenger)';

-- Dumping data for table db_bpsu_timesheet.submission_reply: ~0 rows (approximately)

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
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `ref_document_type_id` (`ref_document_type_id`),
  KEY `id` (`id`),
  KEY `tagged_user_id` (`tagged_user_id`),
  CONSTRAINT `submission_thread_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `submission_thread_ibfk_2` FOREIGN KEY (`ref_document_type_id`) REFERENCES `ref_document_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='transactional table: here you can store all transaction regarding the tasks or submission of Accomplishment Report, Evaluation Form, and Activity Reminder.';

-- Dumping data for table db_bpsu_timesheet.submission_thread: ~4 rows (approximately)
INSERT INTO `submission_thread` (`id`, `user_id`, `tagged_user_id`, `subject`, `remarks`, `ref_document_type_id`, `created_at`, `date_time`) VALUES
	(1, 35, NULL, NULL, 'AR for April', 3, 1681051540, '2023-04-09 22:45:40'),
	(2, 44, NULL, NULL, 'Hello', 3, 1681053264, '2023-04-09 23:14:24'),
	(3, 38, 44, NULL, 'Please see the attached file', 1, 1681053320, '2023-04-09 23:15:20'),
	(4, 35, NULL, NULL, 'This is my AR for the month of APRIL', 3, 1682091164, '2023-04-21 23:32:44');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Transactional table: serves as basis if the user seen the submitted document or viewed the created activity reminder';

-- Dumping data for table db_bpsu_timesheet.submission_thread_seen: ~1 rows (approximately)
INSERT INTO `submission_thread_seen` (`id`, `submission_thread_id`, `user_id`, `date_time`) VALUES
	(1, 3, 37, '2023-04-09 23:16:36');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_bpsu_timesheet.system_other_feature: ~1 rows (approximately)
INSERT INTO `system_other_feature` (`id`, `feature`, `enabled`) VALUES
	(1, 'confirmation_after_face_recognized', 0);

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
  `mobile_no` int(10) DEFAULT NULL COMMENT 'user''s mobile no.',
  `tel_no` varchar(150) NOT NULL COMMENT 'user''s telephone no.',
  `address` text DEFAULT NULL COMMENT 'user''s address details',
  `status` smallint(6) NOT NULL DEFAULT 10 COMMENT 'account''s status (ACTIVE or INACTIVE)',
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
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='List of users of the system';

-- Dumping data for table db_bpsu_timesheet.user: ~17 rows (approximately)
INSERT INTO `user` (`id`, `student_idno`, `student_year`, `student_section`, `ref_program_id`, `ref_program_major_id`, `ref_department_id`, `ref_position_id`, `fname`, `mname`, `sname`, `suffix`, `bday`, `sex`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `mobile_no`, `tel_no`, `address`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
	(2, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'Juan', 'Reyes', 'Dela Cruz', '', '1995-10-12', 'M', 'admin123', 'mLv-KdIB84pIgOrOKnopaaXc51uQml-_', '$2y$13$e4Dcc2wVy3ur10rqQ8mkae0JLsO58dHURdZnvqhZTTDxYu5XI64gO', NULL, 'admin@gm.com', NULL, '', '', 10, 1678168986, 1678168986, 'alqvh-uTo-NSx86JuSUvY_5iG3xkpOQG_1678168986'),
	(35, '120994', 4, 'A', 1, 3, 1, NULL, 'John', '', 'Wick', '', '2005-04-01', 'M', 'johnwick', 'AI1i1WwV90rEZNAmjGxS-rTYYrmtxZSy', '$2y$13$i1T8ERONFUSt2BjuuC4lhu8voClgiPJz.tdJpLuzhUcT5/LiXfdSe', NULL, 'trainee@gm.com', 1234567890, '2343434', '031 Paris St, Brgy. Pinagbarilan, Bataan City', 10, 0, 0, 'wYE4Gfo3VfeF1blsL_VtQyiZUTrDY96o_1680313003'),
	(37, '', NULL, '', NULL, NULL, NULL, NULL, 'Helen', '', 'Wick', '', '2005-03-28', 'F', 'coor', 'kQcZ4MQ_0mncIcJdLY_G3yzqNegC3Udn', '$2y$13$EGGucJYrGZofQvza3X3tmOjxJyCv/hqJRlzso5Knxekwbbi26oddO', NULL, 'coor@gmi.com', 912323232, '23232323', '0934 something st.', 10, 0, 0, '0nXO9Xo1e9juosRRgY7T-h4Leaiq5xB2_1680313634'),
	(38, NULL, NULL, NULL, NULL, NULL, 1, 1, 'Lionelsy', '', 'Wick', '', '2005-03-30', 'M', 'super', 'XM5rIqW7oN9pajeCuNVNPv-OB-hUpEsW', '$2y$13$DCmmrQYvvuf2LjVqVLKp1e/ujon/S0V2ADz8GpdDej9Mvj8oRzvD2', NULL, 'super@gm.com', 912323232, '23232323', '2343 SOmething St.', 10, 0, 0, 'd1UVUsGwsvcpJoAFkw8KUNJaOipQLD3E_1680313693'),
	(39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ronaldo', '', 'Wick', 'Sr.', '2004-05-13', 'M', 'admin2', 'WS8Pvipq8dFDWtMSNL52A6SGSp_O0Bsa', '$2y$13$Ius3FGRYNMYEF6t2RVVmjeflXV8sPmfjnaQ8j2NhBE7USqQeSW7T2', NULL, 'admin2@gmi.com', 902343434, '09090234', '90343 something st.', 10, 0, 0, 'CNg0sHuIsRLyeahqrKMrK0818wdExATS_1680313743'),
	(40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin3', '', 'admin3', '', '2005-04-01', 'M', 'admin3', 'GlV9q5D1_Rx-Z5Q8PFOHpvfguW6SWNlE', '$2y$13$TOmzFfwOdAfFIftosqHNreuTl2AGSAB.TIOKIYblFLL2U5Qt73lNW', NULL, '02394343@gmail.com', 1232312323, '123232', '09232 sdfdf', 10, 0, 0, 'DQ20SHNQCKDVg4RF4vaW8qYmWmZTpP7J_1680316383'),
	(41, NULL, NULL, NULL, NULL, NULL, 2, 2, 'super2', '', 'super2', '', '2005-03-31', 'M', 'super2', '0Gzv5hStM575hW4CMIoRuJSpmxTHfFJ7', '$2y$13$CgnUfKZq3kOwxl5otSSRjuq8FKbq4BvzgrzrzRc5TnKOYA1Rvcq7q', NULL, 'super2@gm.com', 901232309, '092434309043', '1343 somewhere st', 10, 0, 0, 'q4S3pbAAw9os3P5Pu7CVAByaz2uStN4__1680316471'),
	(42, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'coor2', '', 'coor2', 'II', '2005-03-31', 'M', 'coor2', 'Q0yEqPX_XTeI0I_ByGttvYKE0i18WMPm', '$2y$13$D/JvM87m5S/tcsHi1RIBfOzJA9c5fHPYy57Q2qMol/yEO.Pel1To6', NULL, 'coor2@gm.com', 901234904, '109023239032323', '12323 somewhere st.', 10, 0, 0, 'gt_BVFGfPbHp4yaicZCjV1CopZSGNVHa_1680316525'),
	(43, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'coor3', '', 'coor3', '', '2005-03-30', 'F', 'coor3', '6WfvkgTJ_yKJgxFgQXkh_xxW23dYNcH4', '$2y$13$ZLQSI3sT9gn4QYkZwIQjRugDV3VZIw7jVi7QhvCib4Py/XUnHS96e', NULL, 'coor3@gm.com', 2147483647, '2343434', '6767 somewhere st.', 10, 0, 0, 'eE8y2WwtERlVjhgtb4VEB2PSNH6fB_lg_1680316634'),
	(44, '120993', 4, 'B', 1, 3, 1, NULL, 'Leonardo', '', 'Carpio', '', '2005-04-01', 'F', 'leonardo', '2rEZW-2L1SKXcGtQH4WUoRSCSOtMz1EF', '$2y$13$fQeUXPxCvdcLJa2fwyAUFu8eP6xnpJX5YbAAdBVJ5qhbdMJn7YvRu', NULL, 'trainee2@gm.com', 912342403, '32535454344', '990 somewhere st.', 10, 0, 0, 'vlVLZ9RDQL34uLDqgL_Iz5RfWOG8MTEF_1680316868'),
	(45, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Makie', '', 'Wick', '', '2005-04-01', 'M', 'coor4', 'apTx0SoKm39x1eTPU0_5BbRkElRPbS__', '$2y$13$5BKfl.mrfEj3gW9VXCzqweZq.L3Zp.aeloRR1dQcCHuAEwryh5b3S', NULL, 'coor4@gm.com', 2147483647, '90-2343', '0902 somewhere st.', 10, 0, 0, '2KFGYpUI6W4d1CedkZk_gpKUxtD9-X3M_1680404822'),
	(46, '120995', 4, 'C', 2, 0, 1, NULL, 'Myrna', '', 'Reyes', '', '2005-03-08', 'F', 'myrnareyes', 'PGYJmmpl_4i_kkJXA-g3PFMRw6mO43lC', '$2y$13$n2UEn4hRsJ6lWKaxudIPl.8IL/CHm0aSJ5j.izgIiq.RChx9h0Ghy', NULL, 'trainee3@gm.com', 920903290, '123-2323', '94556 somewhere st.', 10, 0, 0, '7y_t9frc6TACW60MjXqPdsfEHc5N80b__1680435026'),
	(47, NULL, NULL, NULL, NULL, NULL, 1, 1, 'super3', '', 'super3', '', '2005-03-31', 'M', 'super3', 'pJep-m_W1QnGSK4v4UOH-uQ3QuoilfVN', '$2y$13$bQMz3mFFWpumnWEifobuhOKPescDJkbOquY.AskHxxtrPcmyxG8hS', NULL, 'super3@gm.com', 912343432, '343-2323', '2344 somewhere st.', 10, 0, 0, 'EPGln7aRFUj56UCoWq0y_zlfWu2F97JV_1680435185'),
	(64, '1209232', 4, 'A', 1, 1, NULL, NULL, 'Rodrigo', 'Roa', 'Duterte', 'Jr.', '0000-00-00', 'M', '1209232', '', '$2y$13$ro64rm1rp4WAV/7/CI7HDOY/xY4AD8cYnkGT5oF1gKXzO09pQ6gTa', NULL, 'duterte@gm.com', 2147483647, '', '033B Somewhere St.', 10, 0, 0, NULL),
	(65, '1209200', 4, 'B', 1, 2, NULL, NULL, 'Leila', NULL, 'De Lima', NULL, '0000-00-00', 'F', '1209200', '', '$2y$13$khcqtiRtXnfnBsx9zwUYV.P8Z3KTivHQnQTygOgADsugN3gX7fFmq', NULL, 'delima@gm.com', 2147483647, '', '031B Somewhere St.', 10, 0, 0, NULL),
	(66, '120990', 4, 'C', 1, 1, NULL, NULL, 'Risa', NULL, 'Hontiveros', NULL, '0000-00-00', 'F', '120990', '', '$2y$13$bVgdLrSkfksFX2yowwiMZOfeGq6RjjumTegt219Bm5nQ3StLJRrna', NULL, 'hontiveros@gm.com', 2147483647, '', '030B Somewhere St.', 10, 0, 0, NULL),
	(67, '19900', 4, 'D', 1, 2, NULL, NULL, 'Leni', 'Gerona', 'Robredro', NULL, '0000-00-00', 'F', '19900', '', '$2y$13$m3Fwk3e/2RXQKJnBJYp4TurCLs4CM3yhrZ75znrZo0idTYcQOBgsa', NULL, 'robredo@gm.com', 2147483647, '', '042B Somewhere St.', 10, 0, 0, NULL);

-- Dumping structure for table db_bpsu_timesheet.user_archive
CREATE TABLE IF NOT EXISTS `user_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_status` int(11) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_bpsu_timesheet.user_archive: ~0 rows (approximately)

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='List of users (trainee and supervisor) assigned company';

-- Dumping data for table db_bpsu_timesheet.user_company: ~15 rows (approximately)
INSERT INTO `user_company` (`id`, `user_id`, `ref_company_id`) VALUES
	(1, 35, 1),
	(2, 37, NULL),
	(3, 38, 1),
	(4, 39, NULL),
	(5, NULL, 1),
	(6, NULL, 1),
	(7, 40, NULL),
	(8, 41, 1),
	(9, 42, NULL),
	(10, 43, NULL),
	(11, 44, 1),
	(12, 45, NULL),
	(13, 46, 3),
	(14, 47, 3),
	(15, 2, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='This table serves as storage of time in/out that displays in the DTR of trainee';

-- Dumping data for table db_bpsu_timesheet.user_timesheet: ~32 rows (approximately)
INSERT INTO `user_timesheet` (`id`, `user_id`, `time_in_am`, `time_out_am`, `time_in_pm`, `time_out_pm`, `date`, `remarks`, `status`) VALUES
	(1, 35, NULL, NULL, '18:42:37', '18:48:13', '2023-03-08', NULL, 0),
	(2, 35, NULL, NULL, '18:48:39', '19:27:37', '2023-04-08', NULL, 0),
	(4, 35, '08:11:34', '09:20:41', '19:53:48', '19:57:56', '2023-04-09', NULL, 0),
	(5, 35, NULL, NULL, '22:15:04', NULL, '2023-04-09', NULL, 0),
	(6, 35, NULL, NULL, '22:20:27', '22:24:16', '2023-04-10', NULL, 0),
	(7, 35, NULL, NULL, '22:26:06', '22:26:24', '2023-04-10', NULL, 0),
	(8, 35, NULL, NULL, '12:44:16', '12:44:33', '2023-04-11', NULL, 0),
	(9, 35, NULL, NULL, '12:45:04', '12:56:47', '2023-04-11', NULL, 0),
	(14, 46, NULL, NULL, '13:13:18', NULL, '2023-04-11', NULL, 0),
	(15, 35, NULL, NULL, '13:14:14', '13:23:07', '2023-04-11', NULL, 0),
	(16, 35, NULL, NULL, '13:23:31', '14:39:14', '2023-04-11', NULL, 0),
	(17, 35, '10:07:03', '10:09:40', NULL, NULL, '2023-04-13', NULL, 0),
	(18, 35, '10:10:02', '10:10:33', NULL, NULL, '2023-04-13', NULL, 0),
	(19, 44, NULL, NULL, '16:18:17', NULL, '2023-04-17', NULL, 0),
	(20, 35, NULL, NULL, '21:53:17', '21:53:17', '2023-04-21', NULL, 0),
	(21, 35, NULL, NULL, '21:54:39', '21:54:39', '2023-04-21', NULL, 0),
	(22, 35, NULL, NULL, '21:59:49', '22:03:40', '2023-04-21', NULL, 0),
	(24, 35, NULL, NULL, '22:05:13', '22:05:13', '2023-04-21', NULL, 0),
	(26, 35, NULL, NULL, '22:13:55', '22:13:55', '2023-04-21', NULL, 0),
	(27, 35, NULL, NULL, '22:28:38', '22:29:47', '2023-04-21', NULL, 0),
	(28, 35, NULL, NULL, '22:29:47', '22:30:33', '2023-04-21', NULL, 0),
	(29, 35, NULL, NULL, '22:30:34', '22:30:56', '2023-04-21', NULL, 0),
	(30, 35, NULL, NULL, '22:30:56', '22:32:13', '2023-04-21', NULL, 0),
	(31, 35, NULL, NULL, '22:32:13', '22:36:22', '2023-04-21', NULL, 0),
	(32, 35, NULL, NULL, '22:36:51', '22:37:26', '2023-04-21', NULL, 0),
	(33, 35, NULL, NULL, '22:37:26', '22:42:00', '2023-04-21', NULL, 0),
	(34, 35, NULL, NULL, '22:42:13', '22:42:36', '2023-04-21', NULL, 0),
	(35, 35, NULL, NULL, '22:54:37', '23:02:12', '2023-04-21', NULL, 0),
	(36, 64, NULL, NULL, '23:00:41', '23:06:24', '2023-04-21', NULL, 0),
	(37, 35, NULL, NULL, '23:05:58', '23:06:58', '2023-04-21', NULL, 0),
	(38, 35, '11:04:13', '11:04:38', NULL, NULL, '2023-04-22', NULL, 0),
	(39, 35, '11:04:53', '11:09:50', '18:54:58', NULL, '2023-04-22', NULL, 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
