-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2023 at 02:37 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_bpsu_timesheet`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `id` int(11) NOT NULL,
  `viewer_type` varchar(50) DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `content_title` varchar(250) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `date_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`id`, `viewer_type`, `user_id`, `content_title`, `content`, `date_time`) VALUES
(1, 'assigned_program', 37, '', 'Be ready to your thesis defense on Wednesday. Good luck.', '2023-04-09 23:25:05');

-- --------------------------------------------------------

--
-- Table structure for table `announcement_program_tags`
--

CREATE TABLE `announcement_program_tags` (
  `id` int(11) NOT NULL,
  `announcement_id` int(11) DEFAULT NULL,
  `ref_program_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement_program_tags`
--

INSERT INTO `announcement_program_tags` (`id`, `announcement_id`, `ref_program_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_assignment`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text DEFAULT NULL,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item`
--

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
('user-management-register-face', 2, '', NULL, NULL, NULL, NULL),
('user-management-update', 2, '', NULL, NULL, NULL, NULL),
('user-management-upload-file', 2, '', NULL, NULL, NULL, NULL),
('user-management-view', 2, '', NULL, NULL, NULL, NULL),
('validate-timesheet', 2, '', NULL, NULL, NULL, NULL),
('view-column-course-program', 2, NULL, NULL, NULL, NULL, NULL),
('view-other-timesheet', 2, '', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item_child`
--

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
('Administrator', 'user-management-register-face'),
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
('OjtCoordinator', 'user-management-register-face'),
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

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coordinator_programs`
--

CREATE TABLE `coordinator_programs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ref_program_id` int(11) DEFAULT NULL,
  `ref_program_major_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coordinator_programs`
--

INSERT INTO `coordinator_programs` (`id`, `user_id`, `ref_program_id`, `ref_program_major_id`) VALUES
(3, 42, 2, NULL),
(4, 43, 3, NULL),
(9, 45, 1, NULL),
(10, 45, 2, NULL),
(11, 37, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `model_name` varchar(50) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `file_name` varchar(250) DEFAULT NULL,
  `extension` varchar(10) DEFAULT NULL,
  `file_hash` varchar(150) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `user_timesheet_time` time DEFAULT NULL,
  `user_timesheet_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `user_id`, `model_name`, `model_id`, `file_name`, `extension`, `file_hash`, `remarks`, `created_at`, `user_timesheet_time`, `user_timesheet_id`) VALUES
(124, 35, 'UserFacialRegister', 35, '6434e9060fc6f.png', 'png', '6434e9060fc6f.png', NULL, 1681189126, NULL, NULL),
(125, 35, 'UserFacialRegister', 35, '6434e9778d9c7.png', 'png', '6434e9778d9c7.png', NULL, 1681189239, NULL, NULL),
(126, 35, 'UserFacialRegister', 35, '6434e9956dbf2.png', 'png', '6434e9956dbf2.png', NULL, 1681189269, NULL, NULL),
(127, 35, 'UserFacialRegister', 35, '6434e9bf67a0b.png', 'png', '6434e9bf67a0b.png', NULL, 1681189311, NULL, NULL),
(128, 35, 'UserFacialRegister', 35, '6434e9d411d0c.png', 'png', '6434e9d411d0c.png', NULL, 1681189332, NULL, NULL),
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
(157, 35, 'UserTimesheet', 35, '64376499b9d0e.png', 'png', '64376499b9d0e.png', NULL, 1681351833, '10:10:33', 18);

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `migration`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `ref_company`
--

CREATE TABLE `ref_company` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `contact_info` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ref_company`
--

INSERT INTO `ref_company` (`id`, `name`, `address`, `latitude`, `longitude`, `contact_info`) VALUES
(1, 'Department of the Interior and Local Government - Central Office', 'DILG-NAPOLCOM Center, Edsa Corner Quezon Avenue, Quezon City, Metro Manila, Philippines', '14.6447149', '121.0367449', ''),
(2, 'DOST-Philippine Institute of Volcanology and Seismology', 'PHIVOLCS, Diliman, Quezon City, Metro Manila, Philippines', '14.6521266', '121.0587245', ''),
(3, 'Department of Public Works and Highways - Head Office', 'DPWH Head Office, Bonifacio Drive Port Area, 652 Zone 068, Manila, Metro Manila, Philippines', '14.5878506', '120.9722474', '');

-- --------------------------------------------------------

--
-- Table structure for table `ref_department`
--

CREATE TABLE `ref_department` (
  `id` int(11) NOT NULL,
  `title` varchar(250) DEFAULT NULL,
  `abbreviation` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ref_department`
--

INSERT INTO `ref_department` (`id`, `title`, `abbreviation`) VALUES
(1, 'IT Department', ''),
(2, 'Human Resource Department', ''),
(3, 'Financial Management Department', '');

-- --------------------------------------------------------

--
-- Table structure for table `ref_document_assignment`
--

CREATE TABLE `ref_document_assignment` (
  `id` int(11) NOT NULL,
  `ref_document_type_id` int(11) DEFAULT NULL,
  `auth_item` varchar(50) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `filter_type` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ref_document_assignment`
--

INSERT INTO `ref_document_assignment` (`id`, `ref_document_type_id`, `auth_item`, `type`, `filter_type`) VALUES
(1, 1, 'CompanySupervisor', 'SENDER', 'based_on_company_department'),
(2, 1, 'OjtCoordinator', 'RECEIVER', 'based_on_course'),
(3, 3, 'Trainee', 'SENDER', 'based_on_login_id'),
(4, 3, 'OjtCoordinator', 'RECEIVER', 'based_on_course'),
(5, 5, 'CompanySupervisor', 'SENDER', 'based_on_company_department'),
(6, 5, 'Trainee', 'RECEIVER', 'based_on_company_department');

-- --------------------------------------------------------

--
-- Table structure for table `ref_document_type`
--

CREATE TABLE `ref_document_type` (
  `id` int(11) NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `action_title` varchar(150) DEFAULT NULL,
  `required_uploading` int(11) NOT NULL,
  `enable_tagging` int(11) NOT NULL,
  `enable_commenting` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ref_document_type`
--

INSERT INTO `ref_document_type` (`id`, `title`, `action_title`, `required_uploading`, `enable_tagging`, `enable_commenting`) VALUES
(1, 'Trainees Evaluation Form', 'Submit Trainees Evaluation Form', 1, 1, 0),
(3, 'Accomplishment Report', 'Submit Accomplishment Report', 1, 0, 1),
(5, 'Activity Reminder', 'Create Activity Reminder', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ref_position`
--

CREATE TABLE `ref_position` (
  `id` int(11) NOT NULL,
  `position` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ref_position`
--

INSERT INTO `ref_position` (`id`, `position`) VALUES
(1, 'Software Engineer'),
(2, 'HR Head'),
(3, 'HR Staff'),
(4, 'Financial Specialist'),
(5, 'Database Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `ref_program`
--

CREATE TABLE `ref_program` (
  `id` int(11) NOT NULL,
  `title` varchar(250) DEFAULT NULL,
  `abbreviation` varchar(20) DEFAULT NULL,
  `required_hours` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ref_program`
--

INSERT INTO `ref_program` (`id`, `title`, `abbreviation`, `required_hours`) VALUES
(1, 'Bachelor of Science in Information Technology', 'BSIT', 486),
(2, 'Bachelor of Science in Computer Science', 'BSCS', 162),
(3, 'Bachelor of Science in Computer Engineering', 'BSCE', 0),
(4, 'Bachelor of Science in Electronics Engineering', 'BSECE', 0),
(5, 'Bachelor of Science in Entrepreneurship Management', 'BSEM', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ref_program_major`
--

CREATE TABLE `ref_program_major` (
  `id` int(11) NOT NULL,
  `ref_program_id` int(11) DEFAULT NULL,
  `title` varchar(250) DEFAULT NULL,
  `abbreviation` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ref_program_major`
--

INSERT INTO `ref_program_major` (`id`, `ref_program_id`, `title`, `abbreviation`) VALUES
(3, 1, 'Network and Web Application', 'NW');

-- --------------------------------------------------------

--
-- Table structure for table `student_section`
--

CREATE TABLE `student_section` (
  `section` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_section`
--

INSERT INTO `student_section` (`section`) VALUES
('A'),
('B'),
('C'),
('D'),
('E');

-- --------------------------------------------------------

--
-- Table structure for table `student_year`
--

CREATE TABLE `student_year` (
  `year` int(1) NOT NULL,
  `title` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_year`
--

INSERT INTO `student_year` (`year`, `title`) VALUES
(3, '3rd Year'),
(4, '4th Year'),
(5, '5th Year');

-- --------------------------------------------------------

--
-- Table structure for table `submission_reply`
--

CREATE TABLE `submission_reply` (
  `id` int(11) NOT NULL,
  `submission_thread_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `date_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `submission_thread`
--

CREATE TABLE `submission_thread` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tagged_user_id` int(11) DEFAULT NULL,
  `subject` varchar(250) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `ref_document_type_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `submission_thread`
--

INSERT INTO `submission_thread` (`id`, `user_id`, `tagged_user_id`, `subject`, `remarks`, `ref_document_type_id`, `created_at`, `date_time`) VALUES
(1, 35, NULL, NULL, 'AR for April', 3, 1681051540, '2023-04-09 22:45:40'),
(2, 44, NULL, NULL, 'Hello', 3, 1681053264, '2023-04-09 23:14:24'),
(3, 38, 44, NULL, 'Please see the attached file', 1, 1681053320, '2023-04-09 23:15:20');

-- --------------------------------------------------------

--
-- Table structure for table `submission_thread_seen`
--

CREATE TABLE `submission_thread_seen` (
  `id` int(11) NOT NULL,
  `submission_thread_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `submission_thread_seen`
--

INSERT INTO `submission_thread_seen` (`id`, `submission_thread_id`, `user_id`, `date_time`) VALUES
(1, 3, 37, '2023-04-09 23:16:36');

-- --------------------------------------------------------

--
-- Table structure for table `suffix`
--

CREATE TABLE `suffix` (
  `title` varchar(10) NOT NULL,
  `meaning` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suffix`
--

INSERT INTO `suffix` (`title`, `meaning`) VALUES
('II', 'the Second'),
('III', 'the Third'),
('IV', 'the Fourth'),
('Jr.', 'Junior'),
('Sr.', 'Senior'),
('V', 'the Fifth');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
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
  `verification_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `student_idno`, `student_year`, `student_section`, `ref_program_id`, `ref_program_major_id`, `ref_department_id`, `ref_position_id`, `fname`, `mname`, `sname`, `suffix`, `bday`, `sex`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `mobile_no`, `tel_no`, `address`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Juan', 'Reyes', 'Dela Cruz', NULL, '1995-10-12', 'M', 'admin', 'mLv-KdIB84pIgOrOKnopaaXc51uQml-_', '$2y$13$Mg3jk2B0jWku6FC8vR66i.I1HFd.DrEFuPNv9s1z9QTZDF.73ZUv6', NULL, 'admin@gm.com', NULL, '', NULL, 10, 1678168986, 1678168986, 'alqvh-uTo-NSx86JuSUvY_5iG3xkpOQG_1678168986'),
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

-- --------------------------------------------------------

--
-- Table structure for table `user_company`
--

CREATE TABLE `user_company` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ref_company_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_company`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `user_timesheet`
--

CREATE TABLE `user_timesheet` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `time_in_am` time DEFAULT NULL,
  `time_out_am` time DEFAULT NULL,
  `time_in_pm` time DEFAULT NULL,
  `time_out_pm` time DEFAULT NULL,
  `date` date DEFAULT NULL,
  `remarks` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_timesheet`
--

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
(18, 35, '10:10:02', '10:10:33', NULL, NULL, '2023-04-13', NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `id` (`id`),
  ADD KEY `created_at` (`date_time`) USING BTREE;

--
-- Indexes for table `announcement_program_tags`
--
ALTER TABLE `announcement_program_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `idx-auth_assignment-user_id` (`user_id`),
  ADD KEY `item_name` (`item_name`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`),
  ADD KEY `parent` (`parent`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `coordinator_programs`
--
ALTER TABLE `coordinator_programs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `id` (`id`),
  ADD KEY `model_id` (`model_id`),
  ADD KEY `created_at` (`created_at`),
  ADD KEY `model_name` (`model_name`),
  ADD KEY `file_name` (`file_name`),
  ADD KEY `extension` (`extension`),
  ADD KEY `file_hash` (`file_hash`),
  ADD KEY `user_timesheet_time` (`user_timesheet_time`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `ref_company`
--
ALTER TABLE `ref_company`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `ref_department`
--
ALTER TABLE `ref_department`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `ref_document_assignment`
--
ALTER TABLE `ref_document_assignment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `ref_document_type_id` (`ref_document_type_id`),
  ADD KEY `auth_item` (`auth_item`),
  ADD KEY `type` (`type`),
  ADD KEY `filter_type` (`filter_type`);

--
-- Indexes for table `ref_document_type`
--
ALTER TABLE `ref_document_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `required_uploading` (`required_uploading`),
  ADD KEY `enable_tagging` (`enable_tagging`),
  ADD KEY `enable_commenting` (`enable_commenting`);

--
-- Indexes for table `ref_position`
--
ALTER TABLE `ref_position`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `ref_program`
--
ALTER TABLE `ref_program`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `ref_program_major`
--
ALTER TABLE `ref_program_major`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `ref_program_id` (`ref_program_id`);

--
-- Indexes for table `student_section`
--
ALTER TABLE `student_section`
  ADD PRIMARY KEY (`section`),
  ADD UNIQUE KEY `section` (`section`);

--
-- Indexes for table `student_year`
--
ALTER TABLE `student_year`
  ADD PRIMARY KEY (`year`),
  ADD UNIQUE KEY `year` (`year`);

--
-- Indexes for table `submission_reply`
--
ALTER TABLE `submission_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `submission_thread_id` (`submission_thread_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `date_time` (`date_time`);

--
-- Indexes for table `submission_thread`
--
ALTER TABLE `submission_thread`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `ref_document_type_id` (`ref_document_type_id`),
  ADD KEY `id` (`id`),
  ADD KEY `tagged_user_id` (`tagged_user_id`);

--
-- Indexes for table `submission_thread_seen`
--
ALTER TABLE `submission_thread_seen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `submission_thread_id` (`submission_thread_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `suffix`
--
ALTER TABLE `suffix`
  ADD PRIMARY KEY (`title`),
  ADD KEY `title` (`title`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`),
  ADD KEY `id` (`id`),
  ADD KEY `mobile_no` (`mobile_no`),
  ADD KEY `suffix` (`suffix`),
  ADD KEY `student_idno` (`student_idno`),
  ADD KEY `ref_program_id` (`ref_program_id`),
  ADD KEY `ref_program_major_id` (`ref_program_major_id`),
  ADD KEY `ref_department_id` (`ref_department_id`),
  ADD KEY `ref_position_id` (`ref_position_id`);

--
-- Indexes for table `user_company`
--
ALTER TABLE `user_company`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `ref_company_id` (`ref_company_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `user_timesheet`
--
ALTER TABLE `user_timesheet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `time_in_am` (`time_in_am`),
  ADD KEY `time_out_am` (`time_out_am`),
  ADD KEY `time_in_pm` (`time_in_pm`),
  ADD KEY `time_out_pm` (`time_out_pm`),
  ADD KEY `date` (`date`),
  ADD KEY `id` (`id`),
  ADD KEY `status` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `announcement_program_tags`
--
ALTER TABLE `announcement_program_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coordinator_programs`
--
ALTER TABLE `coordinator_programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT for table `ref_company`
--
ALTER TABLE `ref_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ref_department`
--
ALTER TABLE `ref_department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ref_document_assignment`
--
ALTER TABLE `ref_document_assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ref_document_type`
--
ALTER TABLE `ref_document_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ref_position`
--
ALTER TABLE `ref_position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ref_program`
--
ALTER TABLE `ref_program`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ref_program_major`
--
ALTER TABLE `ref_program_major`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `submission_reply`
--
ALTER TABLE `submission_reply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `submission_thread`
--
ALTER TABLE `submission_thread`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `submission_thread_seen`
--
ALTER TABLE `submission_thread_seen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `user_company`
--
ALTER TABLE `user_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_timesheet`
--
ALTER TABLE `user_timesheet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcement`
--
ALTER TABLE `announcement`
  ADD CONSTRAINT `announcement_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `submission_thread`
--
ALTER TABLE `submission_thread`
  ADD CONSTRAINT `submission_thread_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `submission_thread_ibfk_2` FOREIGN KEY (`ref_document_type_id`) REFERENCES `ref_document_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_company`
--
ALTER TABLE `user_company`
  ADD CONSTRAINT `user_company_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
