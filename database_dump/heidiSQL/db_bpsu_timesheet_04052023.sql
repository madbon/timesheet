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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `viewer_type` varchar(50) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `content_title` varchar(250) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `id` (`id`),
  KEY `created_at` (`date_time`) USING BTREE,
  CONSTRAINT `announcement_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.announcement: ~2 rows (approximately)
INSERT INTO `announcement` (`id`, `viewer_type`, `user_id`, `content_title`, `content`, `date_time`) VALUES
	(35, 'assigned_program', 42, 'sample', 'sample content 2', '2023-04-05 19:51:13'),
	(36, 'all_program', 42, 'yesterday announcement', 'content 3', '2023-04-04 21:45:37'),
	(37, 'selected_program', 37, 'sample helen announcement', 'content', '2023-04-05 22:38:23'),
	(38, 'selected_program', 42, 'announcement for BSEM', 'content', '2023-04-05 22:48:34');

-- Dumping structure for table db_bpsu_timesheet.announcement_program_tags
CREATE TABLE IF NOT EXISTS `announcement_program_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `announcement_id` int(11) DEFAULT NULL,
  `ref_program_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.announcement_program_tags: ~3 rows (approximately)
INSERT INTO `announcement_program_tags` (`id`, `announcement_id`, `ref_program_id`) VALUES
	(47, 35, 1),
	(48, 35, 2),
	(49, 35, 3),
	(50, 37, 4),
	(51, 38, 5);

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

-- Dumping data for table db_bpsu_timesheet.auth_assignment: ~13 rows (approximately)
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
	('Trainee', '46', NULL);

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

-- Dumping data for table db_bpsu_timesheet.auth_item: ~66 rows (approximately)
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
	('view-column-course-program', 2, NULL, NULL, NULL, NULL, NULL),
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

-- Dumping data for table db_bpsu_timesheet.auth_item_child: ~96 rows (approximately)
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

-- Dumping structure for table db_bpsu_timesheet.coordinator_programs
CREATE TABLE IF NOT EXISTS `coordinator_programs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `ref_program_id` int(11) DEFAULT NULL,
  `ref_program_major_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.coordinator_programs: ~5 rows (approximately)
INSERT INTO `coordinator_programs` (`id`, `user_id`, `ref_program_id`, `ref_program_major_id`) VALUES
	(1, 37, 1, NULL),
	(2, 37, 2, NULL),
	(3, 37, 3, NULL),
	(4, 42, 1, NULL),
	(5, 43, 1, NULL),
	(6, 42, 2, NULL),
	(7, 42, 3, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_bpsu_timesheet.files: ~23 rows (approximately)
INSERT INTO `files` (`id`, `user_id`, `model_name`, `model_id`, `file_name`, `extension`, `file_hash`, `remarks`, `created_at`) VALUES
	(1, 35, 'UserTimesheet', 1, '64279de2712eb.png', 'png', '64279de2712eb.png', NULL, 1680317922),
	(2, 35, 'UserTimesheet', 1, '6427a1699237c.png', 'png', '6427a1699237c.png', NULL, 1680318826),
	(3, 35, 'UserTimesheet', 2, '6427a17d95edb.png', 'png', '6427a17d95edb.png', NULL, 1680318846),
	(4, 35, 'UserTimesheet', 2, '6427a18e999d2.png', 'png', '6427a18e999d2.png', NULL, 1680318863),
	(5, 35, 'SubmissionThread', 1, 'ACCOMPLISHMENT REPORT - JANUARY', 'pdf', '55abb60e68085937a1a78a4dd2c6654c', NULL, 1680442404),
	(6, 37, 'SubmissionReply', 1, 'ID Picture', 'png', '7a38867e5a2dff298a49f02004b0e117', NULL, 1680443921),
	(7, 35, 'UserTimesheet', 3, '642b8d389b969.png', 'png', '642b8d389b969.png', NULL, 1680575801),
	(8, 35, 'UserTimesheet', 3, '642b8d4f67c57.png', 'png', '642b8d4f67c57.png', NULL, 1680575824),
	(9, 37, 'Announcement', 12, '324178353_1022661049137417_367828090756338909_n', 'png', 'ea6379597b273f77a50832f9d0972c50', NULL, 1680660684),
	(10, 37, 'Announcement', 12, 'DTR EMC-DAT 2022 - ABUBO', 'pdf', 'e48bcdf104177544b7a064bd0e94e045', NULL, 1680660684),
	(11, 37, 'Announcement', 13, '1', 'png', 'cc3b2e227d4c9b4906589f4feeddeced', NULL, 1680663322),
	(12, 37, 'Announcement', 13, '2', 'png', '3dd7efba6ebf2e4e2951cad83af16cef', NULL, 1680663322),
	(13, 37, 'Announcement', 13, '3', 'png', '73c994221ead35add2597154a7c58644', NULL, 1680663322),
	(14, 37, 'Announcement', 13, '4', 'png', 'c027b085cb9a2fb57772273d2fba97a7', NULL, 1680663322),
	(15, 37, 'Announcement', 13, '5', 'png', 'c961a256bd4073b1bba33372e43ad6c6', NULL, 1680663322),
	(16, 37, 'Announcement', 14, '324178353_1022661049137417_367828090756338909_n', 'png', '8a92545323072a9e79628b33bb4c59ba', NULL, 1680663780),
	(17, 37, 'Announcement', 14, '334907677_2381587235326145_2200731762565676254_n', 'png', '71b7f7c1e4d7877e0d816f68086d68d5', NULL, 1680663780),
	(19, 37, 'Announcement', 15, 'how-to_2', 'docx', 'c3ad74cf73624b0b416ed7762ffdd883', NULL, 1680682982),
	(20, 37, 'Announcement', 16, 'coordinator', 'xlsx', '2a46ca3d84d55f37cf1c2ddf45e336ea', NULL, 1680683368),
	(22, 37, 'Announcement', 17, '324178353_1022661049137417_367828090756338909_n', 'png', '5ab8267e3aef834ce8d5026d6bca47f8', NULL, 1680685911),
	(23, 37, 'Announcement', 17, 'Plan & Budget (Total No. of Created Reports)', 'pdf', '5f6e531ed56fb71aca6d088230c66690', NULL, 1680685911),
	(24, 37, 'Announcement', 17, 'Plan & Budget (No. of LGUs that have been endorsed)', 'pdf', '37cf2577bed07bd63b8de80df95b383b', NULL, 1680685911),
	(25, 37, 'Announcement', 17, 'how-to_2', 'docx', 'e5ffc5425ecfd9c70bdb96a7c595dbb6', NULL, 1680685911),
	(26, 42, 'Announcement', 33, 'Plan & Budget (No. of LGUs that have been endorsed)', 'pdf', '232cd6fc40120f2e2b17b1ab87933002', NULL, 1680693401),
	(27, 42, 'Announcement', 34, '324178353_1022661049137417_367828090756338909_n', 'png', 'f58237bcf1665802af2a83784a898426', NULL, 1680694735),
	(28, 42, 'Announcement', 34, 'Plan & Budget (No. of LGUs that have been endorsed)', 'pdf', '6bf2411d95a99fca0dd9bd3e3a911678', NULL, 1680694735),
	(29, 42, 'Announcement', 35, 'Plan & Budget (No. of LGUs that have been endorsed)', 'pdf', 'b126caa8f5cc826f302524f2e9e71d36', NULL, 1680695473),
	(30, 42, 'Announcement', 35, 'Plan & Budget (Total No. of Created Reports)', 'pdf', '30b03e28aa602de12410d63fda171002', NULL, 1680695819),
	(31, 42, 'Announcement', 35, 'Plan & Budget (No. of LGUs that have been endorsed)', 'pdf', '9872a80546dc477551efa6a4e766a102', NULL, 1680696099);

-- Dumping structure for table db_bpsu_timesheet.migration
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `contact_info` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.ref_company: ~3 rows (approximately)
INSERT INTO `ref_company` (`id`, `name`, `address`, `latitude`, `longitude`, `contact_info`) VALUES
	(1, 'Department of the Interior and Local Government - Central Office', 'DILG-NAPOLCOM Center, Edsa Corner Quezon Avenue, Quezon City, Metro Manila, Philippines', 14.6447149, 121.0367449, ''),
	(2, 'DOST-Philippine Institute of Volcanology and Seismology', 'PHIVOLCS, Diliman, Quezon City, Metro Manila, Philippines', 14.6521266, 121.0587245, ''),
	(3, 'Department of Public Works and Highways - Head Office', 'DPWH Head Office, Bonifacio Drive Port Area, 652 Zone 068, Manila, Metro Manila, Philippines', 14.5878506, 120.9722474, '');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.submission_reply: ~1 rows (approximately)
INSERT INTO `submission_reply` (`id`, `submission_thread_id`, `user_id`, `message`, `date_time`) VALUES
	(1, 1, 37, 'just want to add this', '2023-04-02 21:58:41');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.submission_thread: ~2 rows (approximately)
INSERT INTO `submission_thread` (`id`, `user_id`, `tagged_user_id`, `subject`, `remarks`, `ref_document_type_id`, `created_at`, `date_time`) VALUES
	(1, 35, NULL, NULL, 'Here\'s my AR for the Month of January', 3, 1680442404, '2023-04-02 21:33:24'),
	(2, 38, NULL, NULL, 'sample reminder', 5, 1680445644, '2023-04-02 22:27:24');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.submission_thread_seen: ~2 rows (approximately)
INSERT INTO `submission_thread_seen` (`id`, `submission_thread_id`, `user_id`, `date_time`) VALUES
	(1, 1, 37, '2023-04-02 21:56:51'),
	(2, 2, 35, '2023-04-02 22:29:48');

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
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table db_bpsu_timesheet.user: ~13 rows (approximately)
INSERT INTO `user` (`id`, `student_idno`, `student_year`, `student_section`, `ref_program_id`, `ref_program_major_id`, `ref_department_id`, `ref_position_id`, `fname`, `mname`, `sname`, `suffix`, `bday`, `sex`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `mobile_no`, `tel_no`, `address`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
	(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Juan', 'Reyes', 'Dela Cruz', NULL, '1995-10-12', 'M', 'admin', 'mLv-KdIB84pIgOrOKnopaaXc51uQml-_', '$2y$13$Mg3jk2B0jWku6FC8vR66i.I1HFd.DrEFuPNv9s1z9QTZDF.73ZUv6', NULL, 'admin@gm.com', NULL, '', NULL, 10, 1678168986, 1678168986, 'alqvh-uTo-NSx86JuSUvY_5iG3xkpOQG_1678168986'),
	(35, '120994', 4, 'A', 1, 1, 1, NULL, 'John', '', 'Wick', '', '2005-04-01', 'M', 'trainee', 'AI1i1WwV90rEZNAmjGxS-rTYYrmtxZSy', '$2y$13$wjqWhWecWGBxWDNSErwqQeGbsd7EKKCTtOnDl64kl7q6u/6QybRqi', NULL, 'trainee@gm.com', 1234567890, '2343434', '031 Paris St, Brgy. Pinagbarilan, Bataan City', 10, 0, 0, 'wYE4Gfo3VfeF1blsL_VtQyiZUTrDY96o_1680313003'),
	(37, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Helen', '', 'Wick', '', '2005-03-28', 'F', 'coor', 'kQcZ4MQ_0mncIcJdLY_G3yzqNegC3Udn', '$2y$13$EGGucJYrGZofQvza3X3tmOjxJyCv/hqJRlzso5Knxekwbbi26oddO', NULL, 'coor@gmi.com', 912323232, '23232323', '0934 something st.', 10, 0, 0, '0nXO9Xo1e9juosRRgY7T-h4Leaiq5xB2_1680313634'),
	(38, NULL, NULL, NULL, NULL, NULL, 1, 1, 'Lionelsy', '', 'Wick', '', '2005-03-30', 'M', 'super', 'XM5rIqW7oN9pajeCuNVNPv-OB-hUpEsW', '$2y$13$DCmmrQYvvuf2LjVqVLKp1e/ujon/S0V2ADz8GpdDej9Mvj8oRzvD2', NULL, 'super@gm.com', 912323232, '23232323', '2343 SOmething St.', 10, 0, 0, 'd1UVUsGwsvcpJoAFkw8KUNJaOipQLD3E_1680313693'),
	(39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ronaldo', '', 'Wick', 'Sr.', '2004-05-13', 'M', 'admin2', 'WS8Pvipq8dFDWtMSNL52A6SGSp_O0Bsa', '$2y$13$Ius3FGRYNMYEF6t2RVVmjeflXV8sPmfjnaQ8j2NhBE7USqQeSW7T2', NULL, 'admin2@gmi.com', 902343434, '09090234', '90343 something st.', 10, 0, 0, 'CNg0sHuIsRLyeahqrKMrK0818wdExATS_1680313743'),
	(40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin3', '', 'admin3', '', '2005-04-01', 'M', 'admin3', 'GlV9q5D1_Rx-Z5Q8PFOHpvfguW6SWNlE', '$2y$13$TOmzFfwOdAfFIftosqHNreuTl2AGSAB.TIOKIYblFLL2U5Qt73lNW', NULL, '02394343@gmail.com', 1232312323, '123232', '09232 sdfdf', 10, 0, 0, 'DQ20SHNQCKDVg4RF4vaW8qYmWmZTpP7J_1680316383'),
	(41, NULL, NULL, NULL, NULL, NULL, 2, 2, 'super2', '', 'super2', '', '2005-03-31', 'M', 'super2', '0Gzv5hStM575hW4CMIoRuJSpmxTHfFJ7', '$2y$13$CgnUfKZq3kOwxl5otSSRjuq8FKbq4BvzgrzrzRc5TnKOYA1Rvcq7q', NULL, 'super2@gm.com', 901232309, '092434309043', '1343 somewhere st', 10, 0, 0, 'q4S3pbAAw9os3P5Pu7CVAByaz2uStN4__1680316471'),
	(42, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'coor2', '', 'coor2', 'II', '2005-03-31', 'M', 'coor2', 'Q0yEqPX_XTeI0I_ByGttvYKE0i18WMPm', '$2y$13$D/JvM87m5S/tcsHi1RIBfOzJA9c5fHPYy57Q2qMol/yEO.Pel1To6', NULL, 'coor2@gm.com', 901234904, '109023239032323', '12323 somewhere st.', 10, 0, 0, 'gt_BVFGfPbHp4yaicZCjV1CopZSGNVHa_1680316525'),
	(43, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'coor3', '', 'coor3', '', '2005-03-30', 'F', 'coor3', '6WfvkgTJ_yKJgxFgQXkh_xxW23dYNcH4', '$2y$13$ZLQSI3sT9gn4QYkZwIQjRugDV3VZIw7jVi7QhvCib4Py/XUnHS96e', NULL, 'coor3@gm.com', 2147483647, '2343434', '6767 somewhere st.', 10, 0, 0, 'eE8y2WwtERlVjhgtb4VEB2PSNH6fB_lg_1680316634'),
	(44, '120993', 2, 'B', 2, 0, 1, NULL, 'trainee2', 'trainee2', 'trainee2', '', '2005-04-01', 'F', 'trainee2', '2rEZW-2L1SKXcGtQH4WUoRSCSOtMz1EF', '$2y$13$nGNpo6D.zqSGmbx4000fMeGVJApmi2u3I4IY1ZPAFCfAWcvHOyziC', NULL, 'trainee2@gm.com', 912342403, '32535454344', '990 somewhere st.', 10, 0, 0, 'vlVLZ9RDQL34uLDqgL_Iz5RfWOG8MTEF_1680316868'),
	(45, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Makie', '', 'Wick', '', '2005-04-01', 'M', 'coor4', 'apTx0SoKm39x1eTPU0_5BbRkElRPbS__', '$2y$13$5BKfl.mrfEj3gW9VXCzqweZq.L3Zp.aeloRR1dQcCHuAEwryh5b3S', NULL, 'coor4@gm.com', 2147483647, '90-2343', '0902 somewhere st.', 10, 0, 0, '2KFGYpUI6W4d1CedkZk_gpKUxtD9-X3M_1680404822'),
	(46, '120995', 4, 'C', 3, 0, 1, NULL, 'Trainee3', '', 'Trainee3', '', '2005-03-08', 'F', 'trainee3', 'PGYJmmpl_4i_kkJXA-g3PFMRw6mO43lC', '$2y$13$aDcU7OHrhPk9BP/KtgqDm.tuskcbZusafl/xSLmbGimNjxbdW7rAq', NULL, 'trainee3@gm.com', 920903290, '123-2323', '94556 somewhere st.', 10, 0, 0, '7y_t9frc6TACW60MjXqPdsfEHc5N80b__1680435026'),
	(47, NULL, NULL, NULL, NULL, NULL, 1, 1, 'super3', '', 'super3', '', '2005-03-31', 'M', 'super3', 'pJep-m_W1QnGSK4v4UOH-uQ3QuoilfVN', '$2y$13$bQMz3mFFWpumnWEifobuhOKPescDJkbOquY.AskHxxtrPcmyxG8hS', NULL, 'super3@gm.com', 912343432, '343-2323', '2344 somewhere st.', 10, 0, 0, 'EPGln7aRFUj56UCoWq0y_zlfWu2F97JV_1680435185');

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.user_company: ~14 rows (approximately)
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
	(14, 47, 3);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_bpsu_timesheet.user_timesheet: ~3 rows (approximately)
INSERT INTO `user_timesheet` (`id`, `user_id`, `time_in_am`, `time_out_am`, `time_in_pm`, `time_out_pm`, `date`, `remarks`, `status`) VALUES
	(1, 35, '08:00:00', '10:00:00', NULL, NULL, '2023-04-01', NULL, 0),
	(2, 35, '11:30:00', NULL, NULL, '17:00:00', '2023-04-01', NULL, 0),
	(3, 35, '10:36:41', '10:37:04', NULL, NULL, '2023-04-04', NULL, 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
