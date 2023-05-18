-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2023 at 01:59 PM
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
  `id` int(11) NOT NULL COMMENT 'unique id of announcement (auto generated)',
  `viewer_type` varchar(50) DEFAULT NULL COMMENT 'serve as identifier to filter who can view the announcement (all courses, only assigned courses, or selected courses)',
  `user_id` int(11) DEFAULT NULL COMMENT 'foreign key unique id (user table) creator of announcement',
  `content_title` varchar(250) DEFAULT NULL COMMENT 'optional field (title of announcement)',
  `content` text DEFAULT NULL COMMENT 'details of announcement',
  `date_time` datetime DEFAULT NULL COMMENT 'date and time that announcement has been created/posted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='This table would allow you to store announcement details/content.';

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`id`, `viewer_type`, `user_id`, `content_title`, `content`, `date_time`) VALUES
(1, 'selected_program', 85, 'Reports due', 'Reports are due tomorrow only.', '2023-04-27 17:18:27');

-- --------------------------------------------------------

--
-- Table structure for table `announcement_program_tags`
--

CREATE TABLE `announcement_program_tags` (
  `id` int(11) NOT NULL COMMENT 'Unique ID (auto generated)',
  `announcement_id` int(11) DEFAULT NULL COMMENT 'foreign key (announcement table)',
  `ref_program_id` int(11) DEFAULT NULL COMMENT 'foreign key (ref_program table)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='This table will store data on which courses/programs will see the announcement';

--
-- Dumping data for table `announcement_program_tags`
--

INSERT INTO `announcement_program_tags` (`id`, `announcement_id`, `ref_program_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `announcement_seen`
--

CREATE TABLE `announcement_seen` (
  `id` int(11) NOT NULL,
  `announcement_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) NOT NULL COMMENT 'foreign key (unique name of role)',
  `user_id` varchar(64) NOT NULL COMMENT 'unique id, foreign key from user table',
  `created_at` int(11) DEFAULT NULL COMMENT 'date and time created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='this table will store the data of users who have an assigned role or permission to access the system';

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('Administrator', '2', NULL),
('CompanySupervisor', '86', NULL),
('OjtCoordinator', '84', NULL),
('OjtCoordinator', '85', NULL),
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
('Trainee', '98', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) NOT NULL COMMENT 'unique name of roles/permissions',
  `type` smallint(6) NOT NULL COMMENT 'type of access (1 - role of the user / 2 - permission to access the specific or special features of the system)',
  `description` text DEFAULT NULL COMMENT 'description of the role and permission',
  `rule_name` varchar(64) DEFAULT NULL COMMENT 'disregard this column',
  `data` blob DEFAULT NULL COMMENT 'disregard this column',
  `created_at` int(11) DEFAULT NULL COMMENT 'date and time created',
  `updated_at` int(11) DEFAULT NULL COMMENT 'date and time updated'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='In this table are stored the permissions and roles that can be assigned to users so that they have access to the system and the special features of the system';

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
('settings-evaluation-criteria', 2, '', NULL, NULL, NULL, NULL),
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

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) NOT NULL COMMENT 'unique name of role and permission',
  `child` varchar(64) NOT NULL COMMENT 'unique name of role and permission (assigned permission to role)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='In this table, the assigned permissions to each role are stored.';

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
('Administrator', 'import-button-trainees'),
('Administrator', 'menu-settings'),
('Administrator', 'menu-user-management'),
('Administrator', 'SETTINGS'),
('Administrator', 'settings-coordinator-assigned-programs-container'),
('Administrator', 'settings-evaluation-criteria'),
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

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Please disregard this table because we didn''t use it, but it was automatically migrated to the database once you installed the yii2 php framework, so it might be useful, so don''t delete it.';

-- --------------------------------------------------------

--
-- Table structure for table `coordinator_programs`
--

CREATE TABLE `coordinator_programs` (
  `id` int(11) NOT NULL COMMENT 'unique ID',
  `user_id` int(11) DEFAULT NULL COMMENT 'foreign key from user table (coordinator id)',
  `ref_program_id` int(11) DEFAULT NULL COMMENT 'foreign key from ref_program table (unique id of program/course)',
  `ref_program_major_id` int(11) DEFAULT NULL COMMENT 'just ready in case the different majors need to be assigned to the coordinator'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='here you can see the coordinator''s assigned programs/courses';

--
-- Dumping data for table `coordinator_programs`
--

INSERT INTO `coordinator_programs` (`id`, `user_id`, `ref_program_id`, `ref_program_major_id`) VALUES
(1, 84, 3, NULL),
(2, 85, 1, NULL),
(3, 85, 2, NULL),
(4, 85, 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_criteria`
--

CREATE TABLE `evaluation_criteria` (
  `id` int(11) NOT NULL,
  `title` varchar(250) DEFAULT NULL,
  `max_points` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `evaluation_criteria`
--

INSERT INTO `evaluation_criteria` (`id`, `title`, `max_points`) VALUES
(1, '1. Knowledge of Work', 20),
(2, '2. Productivity', 20),
(3, '3. Initiative', 15),
(4, '4. Dedication to Duty', 15),
(5, '5. Cooperation', 10),
(6, '6. Safety of Housekeeping', 10),
(7, '7. Attendance and Punctuality', 10);

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_form`
--

CREATE TABLE `evaluation_form` (
  `id` int(11) NOT NULL,
  `submission_thread_id` int(11) DEFAULT NULL,
  `trainee_user_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `evaluation_criteria_id` int(11) DEFAULT NULL,
  `points_scored` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL COMMENT 'unique id of file (auto generated)',
  `user_id` int(11) DEFAULT NULL COMMENT 'foreign key from user table (uploader)',
  `model_name` varchar(50) DEFAULT NULL COMMENT 'identifier (category of the file / table name)',
  `model_id` int(11) DEFAULT NULL COMMENT 'table id',
  `file_name` varchar(250) DEFAULT NULL COMMENT 'file name',
  `extension` varchar(10) DEFAULT NULL COMMENT 'file type or extension name',
  `file_hash` varchar(150) DEFAULT NULL COMMENT 'unique hash code of the file (auto generated by the system)',
  `remarks` text DEFAULT NULL COMMENT 'in case the uploader want to add some remarks or message regarding the uploaded file',
  `created_at` int(11) DEFAULT NULL COMMENT 'date time uploaded',
  `user_timesheet_time` time DEFAULT NULL COMMENT 'serves as basis in DTR time in/out captured photo of user',
  `user_timesheet_id` int(11) DEFAULT NULL COMMENT 'foreign key of user_timesheet table'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='in this table you can see all the files uploaded to the system';

--
-- Dumping data for table `files`
--

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
(116, 98, 'UserTimesheet', 98, '640da30222238.png', 'png', '640da30222238.png', NULL, 1678615299, '18:01:39', 15);

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL COMMENT 'migration file name',
  `apply_time` int(11) DEFAULT NULL COMMENT 'date time migrated'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='auto migrated table once you install the Yii2 PHP framework (serves as repository of migrated default tables of Yii2 Framework)';

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
('m230402_125314_add_permission_assignment', 1680440013),
('m230502_084102_update_mobile_no', 1683548187),
('m230503_000856_add_column_ref_document_type_required_remarks', 1683548187),
('m230503_004527_update_required_uploading', 1683548187),
('m230515_073556_add_col_submission_thread', 1684410540);

-- --------------------------------------------------------

--
-- Table structure for table `ref_company`
--

CREATE TABLE `ref_company` (
  `id` int(11) NOT NULL COMMENT 'unique id (auto generated)',
  `name` varchar(255) DEFAULT NULL COMMENT 'company name',
  `address` varchar(255) DEFAULT NULL COMMENT 'company address',
  `latitude` decimal(10,7) DEFAULT NULL COMMENT 'company location (latitude)',
  `longitude` decimal(10,7) DEFAULT NULL COMMENT 'company location (longitude)',
  `contact_info` varchar(150) DEFAULT NULL COMMENT 'contact details of the company'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='reference table: you can see the encoded company details';

--
-- Dumping data for table `ref_company`
--

INSERT INTO `ref_company` (`id`, `name`, `address`, `latitude`, `longitude`, `contact_info`) VALUES
(1, 'Technical Education and Skills Development Authority', 'TESDA, Kinatawan Road, City of Balanga, Bataan, Philippines', '14.6767056', '120.5310184', ''),
(2, 'The Bunker', 'The Bunker, City of Balanga, Bataan, Philippines', '14.6756875', '120.5290961', ''),
(3, 'Bataan Peninsula State University', 'Bataan Peninsula State University, Capitol Drive, City of Balanga, Bataan, Philippines', '14.6769210', '120.5306378', ''),
(4, 'Accenture Gateway Tower 2', 'Accenture Gateway Tower 2, General Aguinaldo Avenue, Cubao, Quezon City, Metro Manila, Philippines', '14.6226048', '121.0530741', ''),
(5, 'AMPC', 'AMPC, Magtanong Street, Abucay, Bataan, Philippines', '14.7245510', '120.5323474', '');

-- --------------------------------------------------------

--
-- Table structure for table `ref_department`
--

CREATE TABLE `ref_department` (
  `id` int(11) NOT NULL COMMENT 'unique ID (auto generated)',
  `title` varchar(250) DEFAULT NULL COMMENT 'department name',
  `abbreviation` varchar(20) DEFAULT NULL COMMENT 'department abbreviation'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='reference table: the company''s departments are stored here';

--
-- Dumping data for table `ref_department`
--

INSERT INTO `ref_department` (`id`, `title`, `abbreviation`) VALUES
(1, 'IT Department', ''),
(2, 'Human Resource Department', ''),
(3, 'Financial Management Department', ''),
(4, 'Engineering Department', '');

-- --------------------------------------------------------

--
-- Table structure for table `ref_document_assignment`
--

CREATE TABLE `ref_document_assignment` (
  `id` int(11) NOT NULL COMMENT 'unique id (auto generated)',
  `ref_document_type_id` int(11) DEFAULT NULL COMMENT 'foreign key of ref_document_type table',
  `auth_item` varchar(50) DEFAULT NULL COMMENT 'role/permission name (auth_item table)',
  `type` varchar(20) DEFAULT NULL COMMENT 'task identifier (SENDER or RECEIVER)',
  `filter_type` varchar(150) DEFAULT NULL COMMENT 'Backend filter identifier (this serves as basis to filter the task)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='reference table: serves as the system''s basis for who is the receiver or sender of the Accomplishment Report, Evaluation Form, & Activity Reminder';

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
  `id` int(11) NOT NULL COMMENT 'unique ID (auto generated)',
  `title` varchar(150) DEFAULT NULL COMMENT 'title of task once RECEIVED',
  `action_title` varchar(150) DEFAULT NULL COMMENT 'title of task to be performed',
  `required_uploading` int(11) NOT NULL COMMENT '1 - required uploading of file / 0 - optional',
  `enable_tagging` int(11) NOT NULL COMMENT '1 - enable tagging of user / 0 - disabl tagging of user',
  `enable_commenting` int(11) NOT NULL COMMENT '1 - enable creating comment / 0 - disable creating of comment',
  `required_remarks` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Reference table: types of task';

--
-- Dumping data for table `ref_document_type`
--

INSERT INTO `ref_document_type` (`id`, `title`, `action_title`, `required_uploading`, `enable_tagging`, `enable_commenting`, `required_remarks`) VALUES
(1, 'Trainees Evaluation Form', 'Submit Trainees Evaluation Form', 1, 1, 0, 0),
(3, 'Accomplishment Report', 'Submit Accomplishment Report', 1, 0, 1, 0),
(5, 'Activity Reminder', 'Create Activity Reminder', 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ref_position`
--

CREATE TABLE `ref_position` (
  `id` int(11) NOT NULL COMMENT 'unique id of position (auto generated)',
  `position` varchar(100) DEFAULT NULL COMMENT 'position title'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Reference table: list of company positions';

--
-- Dumping data for table `ref_position`
--

INSERT INTO `ref_position` (`id`, `position`) VALUES
(1, 'Administrative Assistant'),
(2, 'Director'),
(3, 'Manager'),
(4, 'Financial Specialist'),
(5, 'Database Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `ref_program`
--

CREATE TABLE `ref_program` (
  `id` int(11) NOT NULL COMMENT 'unique id of program/course (auto generated)',
  `title` varchar(250) DEFAULT NULL COMMENT 'title of program/course',
  `abbreviation` varchar(20) DEFAULT NULL COMMENT 'abbreviation of program/course',
  `required_hours` int(11) NOT NULL COMMENT 'required hours to be rendered in OJT'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Reference table: list of programs/courses';

--
-- Dumping data for table `ref_program`
--

INSERT INTO `ref_program` (`id`, `title`, `abbreviation`, `required_hours`) VALUES
(1, 'Bachelor of Science in Information Technology', 'BSIT', 324),
(2, 'Bachelor of Science in Computer Science', 'BSCS', 162),
(3, 'Bachelor of Science in Entertainment & Multimedia Computing', 'BSEMC', 486),
(4, 'Bachelor of Science in Electronics Engineering', 'BSECE', 0),
(5, 'Bachelor of Science in Entrepreneurship Management', 'BSEM', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ref_program_major`
--

CREATE TABLE `ref_program_major` (
  `id` int(11) NOT NULL COMMENT 'unique if of major (auto generated)',
  `ref_program_id` int(11) DEFAULT NULL COMMENT 'foreign key of ref_program table',
  `title` varchar(250) DEFAULT NULL COMMENT 'title of Major',
  `abbreviation` varchar(10) DEFAULT NULL COMMENT 'abbreviation of Major'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Refererence table: list of program''s majors';

--
-- Dumping data for table `ref_program_major`
--

INSERT INTO `ref_program_major` (`id`, `ref_program_id`, `title`, `abbreviation`) VALUES
(3, 1, 'Network and Web Application', 'NW'),
(4, 2, 'Network and Data Communication', 'ND'),
(5, 2, 'Software Development', 'SD'),
(6, 3, 'Game Development', 'GD'),
(7, 3, 'Digital Animation Technology', 'DAT');

-- --------------------------------------------------------

--
-- Table structure for table `student_section`
--

CREATE TABLE `student_section` (
  `section` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Reference table: list of sections';

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Reference table: list of years';

--
-- Dumping data for table `student_year`
--

INSERT INTO `student_year` (`year`, `title`) VALUES
(3, '3rd Year'),
(4, '4th Year'),
(5, '5th Year');

-- --------------------------------------------------------

--
-- Table structure for table `submission_archive`
--

CREATE TABLE `submission_archive` (
  `id` int(11) NOT NULL,
  `submission_thread_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `submission_reply`
--

CREATE TABLE `submission_reply` (
  `id` int(11) NOT NULL COMMENT 'unique id of messages (auto generated)',
  `submission_thread_id` int(11) DEFAULT NULL COMMENT 'foreign key id of submission_thread table (under of what task is this thread)',
  `user_id` int(11) DEFAULT NULL COMMENT 'foreign key id of user table (creator of message)',
  `message` text DEFAULT NULL COMMENT 'message content',
  `date_time` datetime DEFAULT NULL COMMENT 'date time created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='transaction table: this table allows user to store messages/comment regarding the submitted document (AR) or performed tasks (creating activity reminder) (messenger)';

-- --------------------------------------------------------

--
-- Table structure for table `submission_reply_seen`
--

CREATE TABLE `submission_reply_seen` (
  `id` int(11) NOT NULL COMMENT 'unique id (auto generated)',
  `submission_thread_id` int(11) DEFAULT NULL,
  `submission_reply_id` int(11) DEFAULT NULL COMMENT 'foreign key of submission_reply table',
  `user_id` int(11) DEFAULT NULL COMMENT 'foreign key of user table (who seen the reply)',
  `date_time` datetime DEFAULT NULL COMMENT 'date/time seen'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='here you can see if the user has seen the reply or message regarding the AR submission';

-- --------------------------------------------------------

--
-- Table structure for table `submission_thread`
--

CREATE TABLE `submission_thread` (
  `id` int(11) NOT NULL COMMENT 'unique ID (auto generated)',
  `user_id` int(11) DEFAULT NULL COMMENT 'foreign key id of user table (submitted by / created by)',
  `tagged_user_id` int(11) DEFAULT NULL COMMENT 'foreign key id (The company supervisor will tag whose evaluation form to submit)',
  `subject` varchar(250) DEFAULT NULL COMMENT 'disregard this column',
  `remarks` text DEFAULT NULL COMMENT 'remarks or message details regarding the submitted document or created activity reminder',
  `ref_document_type_id` int(11) DEFAULT NULL COMMENT 'foreign key id of ref_document_type table (identifier if AR, Evaluation Form, or Activity Reminder)',
  `created_at` int(11) DEFAULT NULL COMMENT 'disregard this column',
  `date_time` datetime DEFAULT NULL COMMENT 'date time created/submitted',
  `date_commenced` date DEFAULT NULL,
  `date_completed` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='transactional table: here you can store all transaction regarding the tasks or submission of Accomplishment Report, Evaluation Form, and Activity Reminder.';

--
-- Dumping data for table `submission_thread`
--

INSERT INTO `submission_thread` (`id`, `user_id`, `tagged_user_id`, `subject`, `remarks`, `ref_document_type_id`, `created_at`, `date_time`, `date_commenced`, `date_completed`) VALUES
(3, 86, NULL, NULL, 'checking of system', 5, 1682587378, '2023-04-27 17:22:58', NULL, NULL),
(4, 86, NULL, NULL, 'eat your breaky', 5, 1682596891, '2023-04-27 20:01:31', NULL, NULL),
(5, 86, NULL, NULL, '', 5, 1682687683, '2023-04-28 21:14:43', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `submission_thread_seen`
--

CREATE TABLE `submission_thread_seen` (
  `id` int(11) NOT NULL COMMENT 'unique id (auto generated)',
  `submission_thread_id` int(11) DEFAULT NULL COMMENT 'foreign key id of submission_thread table',
  `user_id` int(11) DEFAULT NULL COMMENT 'forein key id of user table (who viewed the created tasks or submitted document)',
  `date_time` datetime DEFAULT NULL COMMENT 'date time seen'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Transactional table: serves as basis if the user seen the submitted document or viewed the created activity reminder';

-- --------------------------------------------------------

--
-- Table structure for table `suffix`
--

CREATE TABLE `suffix` (
  `title` varchar(10) NOT NULL,
  `meaning` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Reference table: list of suffixes';

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
-- Table structure for table `system_other_feature`
--

CREATE TABLE `system_other_feature` (
  `id` int(11) NOT NULL,
  `feature` varchar(250) DEFAULT NULL,
  `enabled` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `system_other_feature`
--

INSERT INTO `system_other_feature` (`id`, `feature`, `enabled`) VALUES
(2, 'time_inout_using_login_credential', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL COMMENT 'unique id of user',
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
  `verification_token` varchar(255) DEFAULT NULL COMMENT 'auto generated key to allow user access the system'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='List of users of the system';

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `student_idno`, `student_year`, `student_section`, `ref_program_id`, `ref_program_major_id`, `ref_department_id`, `ref_position_id`, `fname`, `mname`, `sname`, `suffix`, `bday`, `sex`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `mobile_no`, `tel_no`, `address`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
(2, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'Juan', 'Reyes', 'Dela Cruz', '', '1995-10-12', 'M', 'admin123', 'mLv-KdIB84pIgOrOKnopaaXc51uQml-_', '$2y$13$e4Dcc2wVy3ur10rqQ8mkae0JLsO58dHURdZnvqhZTTDxYu5XI64gO', NULL, 'admin@gm.com', NULL, '', '', 10, 1678168986, 1678168986, 'alqvh-uTo-NSx86JuSUvY_5iG3xkpOQG_1678168986'),
(81, '19-05009', 4, 'A', 1, 3, NULL, NULL, 'Erika Eunice', 'Dalampasig', 'Catalan', NULL, '2001-06-24', 'F', '19-05009', '', '$2y$13$uicO0ZMf5n1VTOi432DFqOdA7jg36MR2KuHa6iI6Pp/iWS2/o.Giq', NULL, 'eedcatalan@bpsu.edu.ph', '2147483647', '', '001 Magsaysay Street, kitang 1 Limay Bataan', 10, 0, 0, NULL),
(82, '19-03547', 4, 'A', 1, 3, NULL, NULL, 'Nick John', 'Gonzales', 'Gloria', NULL, '2001-07-05', 'M', '19-03547', '', '$2y$13$oZOi2gHPozyUtI7MBfC15.4w9wMK325Hn8onKm60CRp8ABmOWaDeC', NULL, 'njggloria@bpsu.edu.ph', '2147483647', '', 'Calaylayan Abucay, Bataan', 10, 0, 0, NULL),
(83, '19-04831', 4, 'A', 1, 3, NULL, NULL, 'Christian Jay', 'Nival', 'Tuyor', NULL, '2001-07-19', 'M', '19-04831', '', '$2y$13$.fjkG86FhEl9CB50SaF39uJmCT8x.YjJr7E.grAXX6gjx8Lm/4dMy', NULL, 'cjntuyor@bpsu.edu.ph', '2147483647', '', '0875 Ilang-Ilang St. Alangan, Limay Bataan', 10, 0, 0, NULL),
(84, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Richmon', '', 'Carabeo', '', '1990-07-18', 'M', 'richmon', 'xeKrkWbpp2Og4Y6YUh20HS2jr6R5L0F_', '$2y$13$0epnfH3pZrTPMKp6gF5b1e2aBznxdVdOiIHNKQYtkULmovvrvjv4G', NULL, 'rlcarabeo@bpsu.edu.ph', '2147483647', '', 'Balanga, Bataan', 10, 0, 0, 'Sgd_MPB1r01H37c9Khh5GmcDW_7604Ck_1682513410'),
(85, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'Noel', '', 'Tolentino', '', '1991-09-28', 'M', 'noel', 'dbp4vxsZtzjnmOBtedNE8xYT4Hcu_LLD', '$2y$13$l9.KtcYnML6K0rK2w/dgtek5mtlHMq2WtxMzDQR6RgOJ3OBqlyzN2', NULL, 'nntolentino@bpsu.edu.ph', '2147483647', '', 'Balanga, Bataan', 10, 0, 0, 'RRfFV67w_kcmmj0iFh1EbcojfF4jogdd_1682513529'),
(86, NULL, NULL, NULL, NULL, NULL, 3, 4, 'Ruby', 'DeLuna', 'De Leon', '', '1971-04-04', 'F', 'jollydelacruz', 'mREQyfo5iulCBUYgVjcrvB3jN5PxKb3q', '$2y$13$YtqisIs8aHqnp586BkFPbuG1J9RekhA0dDX1oqakjjRwpI/JFCvYa', NULL, 'rubydeluna18@yahoo.com', '2147483647', '', 'Abucay, Bataan', 10, 0, 0, 'bzZphT7jVIBRDZ2q-8b6lVcJWUJeaoei_1682513752'),
(87, '19-01554', 4, 'E', 1, 3, 3, NULL, 'Erika Cate ', 'Manalo', 'DeLa Cruz', '', '2000-10-21', 'F', 'aeikr', 'N_P1h7-amljNPm6b_frZpS6E_f7YTu1r', '$2y$13$Lf.33BVmzNW7UDhOVgw/oe3AP3GNzecoZY0pJFW41g/RvjpckydvC', NULL, 'ecmdelacruz@bpsu.edu.ph', '2147483647', '', '27 Mabini Street Culis Hermosa, Bataan', 10, 0, 0, 'jh7FfTpp1Ef__R1slL0nvNSHH_fvgnJ0_1682557365'),
(88, '19-01903', 4, 'B', 1, 3, 1, NULL, 'Rose', 'DelaCruz', 'De Luna', '', '1995-05-18', 'F', 'roseanne', 'oc5TsH46MLanoq_EzHTC3152XXQ1T7fX', '$2y$13$/GzJm6CnBdncQgsEgc5UCuSHSOvvNhB6pp0ZWv/i4QXvxEkuJamMu', NULL, 'rose@gmail.com', '2147483647', '', 'Balanga, Bataan', 10, 0, 0, 'oR4sYfNsRr4cwYejPgKlrH0NmPVibGvz_1682585333'),
(89, '19-00635', 4, 'D', 1, 3, NULL, NULL, 'Alfonso', 'Andraneda', 'Manago', NULL, '2000-07-16', 'M', '19-00635', '', '$2y$13$clnxZSwJOCtB.xjImFJO/e3ZRCKw4Goj5M3t9NuDc6b6aCLK/k8ES', NULL, 'aamanago@bpsu.edu.ph', '2147483647', '', 'Lot 34, Blk 3, La Katrina Village, Brgy. Sibacan, Balanga City, Bataan', 10, 0, 0, NULL),
(90, '19-04616', 4, 'A', 1, 3, NULL, NULL, 'Neil Anthony', 'Cabrera', 'Aspiras', NULL, '2000-12-16', 'M', '19-04616', '', '$2y$13$BgkO.NlC3qBl.nmWpZfI5e.hAzMhZTJFH4HB2JSQLfSmnepFQSr0i', NULL, 'nacaspiras@bpsu.edu.ph', '2147483647', '', '765 Muli Avenue, Dinalupihan, Bataan', 10, 0, 0, NULL),
(91, '19-02685', 4, 'C', 1, 3, NULL, NULL, 'Angelica', 'Aninon', 'Berdugo', NULL, '1999-04-14', 'F', '19-02685', '', '$2y$13$VYKPpudRl6VuMDKg.A5qLeioTTkrYkR5PRdEuUT2vi7SIhyj6fS32', NULL, 'aaberdugo@bpsu.edu.ph', '2147483647', '', '245 Cristina Village, Togatog, Orani, Bataan', 10, 0, 0, NULL),
(92, '19-', 4, 'A', 1, 3, NULL, NULL, 'Tristan Joel', 'Mendiola', 'Binungcal', NULL, '2000-10-08', 'M', '19-', '', '$2y$13$gys2OFpBzoLrgjwwLd6d..I5/9KSa.nBBg67AWLyYEdnUlRpeVQHa', NULL, 'tjmbinungcal@bpsu.edu.ph', '2147483647', '', '0376 Camacho Street Tenejero, Balanga, Bataan', 10, 0, 0, NULL),
(93, '19-00915', 4, 'C', 1, 3, NULL, NULL, 'Kennedy Lyndon', 'Santos', 'Santos', NULL, '2000-06-17', 'M', '19-00915', '', '$2y$13$H26xKsEi6Fzuf3PweaQK1.tTQVa6C4Mr4YlvcmYEOjyQK.6pUYodi', NULL, 'klssantos@bpsu.edu.ph', '2147483647', '', '1338 Howthorne Street, Mulawin Heights, Orani, Bataan', 10, 0, 0, NULL),
(94, '19-03079', 4, 'D', 1, 3, NULL, NULL, 'Erickson', 'Cornelio', 'Yalo', NULL, '2000-08-22', 'M', '19-03079', '', '$2y$13$1yBvviPKXvQbSCOXjdcNbeOrU2QTWDUpYQGMjKILV.7Zm.x.3opmG', NULL, 'ecyalo@bpsu.edu.ph', '2147483647', '', '1678 Sampaguita Street, Talimundoc, Orani, Bataan', 10, 0, 0, NULL),
(95, '19-01601', 4, 'A', 1, 3, NULL, NULL, 'Jan Andrei', 'Rafael', 'Catubuan', NULL, '2001-04-27', 'M', '19-01601', '', '$2y$13$vYmYT90zWMJ2bMkoMJnFveuIog7mTPEZcRCWHYzt1oavFbD7KP.wC', NULL, 'jarcatubuan@bpsu.edu.ph', '2147483647', '', '0246 Silverland Phase 3, Duale, Limay, Bataan', 10, 0, 0, NULL),
(96, '19-03565', 4, 'A', 1, 3, NULL, NULL, 'Jom Vincent', 'Gamboa', 'Bacarizas', NULL, '2001-09-09', 'M', '19-03565', '', '$2y$13$mTk.M574HBvnvwyGxK6R9eMS5yNCd4ZPglXLdXetulk6oSjB9A1PO', NULL, 'jvgbacarizas@bpsu.edu.ph', '2147483647', '', '0537 Lower Tundol, Reformista, Limay, Bataan', 10, 0, 0, NULL),
(97, '19-019010', 4, 'C', 1, 3, 1, NULL, 'Anne', 'Lucas', 'Panganiban', '', '2000-09-08', 'F', 'anne', 'yzLcK9cMcqbvEmNntKtI5lSI1bKMPwlW', '$2y$13$7lYjR4Cg/vRwOXWPfch2LuJ2uC4r4cUmy76Zak/u5GWT.0NW35YNK', NULL, 'anne@yahoo.com', '2147483647', '', 'Abucay, Bataan', 10, 0, 0, 'd22xyu6mmkxjJkdc8FhXJH-M0yQlmRPP_1682687345'),
(98, '19-01905', 4, 'A', 1, 3, 1, NULL, 'Jhaema', 'Santos', 'Nicdao', '', '2000-09-05', 'F', 'blinkot4', 'ZgHZxoE1KK9uz5XyXGjqvEyPgZswOXTC', '$2y$13$2./igfaQgl2V8eO0fdlGGejEBxFoYSbduPZx6uiB54YuArP28WbPa', NULL, 'jsnicdao@bpsu.edu.ph', '2147483647', '', '#293 Purok 1 Colo Dinalupihan, Bataan', 10, 0, 0, 'uoj84GX8WJ4medQd3Z36BLm5awlu59JG_1683291099');

-- --------------------------------------------------------

--
-- Table structure for table `user_archive`
--

CREATE TABLE `user_archive` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_status` int(11) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_company`
--

CREATE TABLE `user_company` (
  `id` int(11) NOT NULL COMMENT 'unique id',
  `user_id` int(11) DEFAULT NULL COMMENT 'foreign key id of user table (trainee or supervisor)',
  `ref_company_id` int(11) DEFAULT NULL COMMENT 'foreign key id of ref_company table (assigned company)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='List of users (trainee and supervisor) assigned company';

--
-- Dumping data for table `user_company`
--

INSERT INTO `user_company` (`id`, `user_id`, `ref_company_id`) VALUES
(1, 84, NULL),
(2, 85, NULL),
(3, 86, 1),
(5, 87, 1),
(6, 88, 1),
(7, 97, 1),
(8, 98, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_timesheet`
--

CREATE TABLE `user_timesheet` (
  `id` int(11) NOT NULL COMMENT 'unique id',
  `user_id` int(11) DEFAULT NULL COMMENT 'foreign key id of user table (trainee)',
  `time_in_am` time DEFAULT NULL COMMENT 'time in (AM)',
  `time_out_am` time DEFAULT NULL COMMENT 'time out (AM)',
  `time_in_pm` time DEFAULT NULL COMMENT 'time in (PM)',
  `time_out_pm` time DEFAULT NULL COMMENT 'time out (PM)',
  `date` date DEFAULT NULL COMMENT 'date recorded',
  `remarks` varchar(50) DEFAULT NULL COMMENT 'remarks details per row',
  `status` int(11) NOT NULL COMMENT 'PENDING or VALIDATED'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='This table serves as storage of time in/out that displays in the DTR of trainee';

--
-- Dumping data for table `user_timesheet`
--

INSERT INTO `user_timesheet` (`id`, `user_id`, `time_in_am`, `time_out_am`, `time_in_pm`, `time_out_pm`, `date`, `remarks`, `status`) VALUES
(1, 80, NULL, NULL, '21:10:25', '21:13:00', '2023-04-26', '', 1),
(2, 87, '09:12:32', NULL, NULL, NULL, '2023-04-27', NULL, 0),
(3, 80, NULL, NULL, '17:06:52', '19:55:53', '2023-04-27', NULL, 1),
(4, 80, '06:09:40', '06:09:41', '20:01:51', '20:03:05', '2023-04-28', NULL, 1),
(5, 98, '08:01:45', NULL, NULL, '17:04:24', '2023-03-08', NULL, 0),
(6, 98, '08:03:11', NULL, NULL, '12:03:50', '2023-04-10', NULL, 0),
(7, 98, '08:01:54', '11:33:04', '13:01:15', '18:01:52', '2023-05-06', NULL, 0),
(8, 98, '08:03:32', NULL, NULL, '12:01:03', '2023-03-09', NULL, 0),
(9, 98, NULL, NULL, '13:01:26', '13:01:27', '2023-03-09', NULL, 0),
(10, 98, NULL, NULL, '17:03:11', '19:13:56', '2023-03-09', NULL, 0),
(11, 98, '08:01:22', '11:56:16', '13:01:00', '19:00:48', '2023-03-10', NULL, 0),
(12, 98, '08:04:58', '11:59:29', '13:01:22', '18:31:10', '2023-03-11', NULL, 0),
(13, 98, NULL, NULL, '14:13:47', NULL, '2023-05-06', NULL, 0),
(14, 98, '08:01:58', NULL, NULL, '12:01:52', '2023-03-12', NULL, 0),
(15, 98, NULL, NULL, '13:01:47', '18:01:39', '2023-03-12', NULL, 0);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcement_id` (`announcement_id`),
  ADD KEY `ref_program_id` (`ref_program_id`);

--
-- Indexes for table `announcement_seen`
--
ALTER TABLE `announcement_seen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcement_id` (`announcement_id`),
  ADD KEY `user_id` (`user_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `ref_program_id` (`ref_program_id`);

--
-- Indexes for table `evaluation_criteria`
--
ALTER TABLE `evaluation_criteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `evaluation_form`
--
ALTER TABLE `evaluation_form`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trainee_user_id` (`trainee_user_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `evaluation_criteria_id` (`evaluation_criteria_id`),
  ADD KEY `submission_thread_id` (`submission_thread_id`);

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
-- Indexes for table `submission_archive`
--
ALTER TABLE `submission_archive`
  ADD PRIMARY KEY (`id`),
  ADD KEY `submission_thread_id` (`submission_thread_id`),
  ADD KEY `user_id` (`user_id`);

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
-- Indexes for table `submission_reply_seen`
--
ALTER TABLE `submission_reply_seen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `submission_reply_id` (`submission_reply_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `submission_thread_id` (`submission_thread_id`);

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
-- Indexes for table `system_other_feature`
--
ALTER TABLE `system_other_feature`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `user_archive`
--
ALTER TABLE `user_archive`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id of announcement (auto generated)', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `announcement_program_tags`
--
ALTER TABLE `announcement_program_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID (auto generated)', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `announcement_seen`
--
ALTER TABLE `announcement_seen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coordinator_programs`
--
ALTER TABLE `coordinator_programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique ID', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `evaluation_criteria`
--
ALTER TABLE `evaluation_criteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `evaluation_form`
--
ALTER TABLE `evaluation_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id of file (auto generated)', AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `ref_company`
--
ALTER TABLE `ref_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id (auto generated)', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ref_department`
--
ALTER TABLE `ref_department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique ID (auto generated)', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ref_document_assignment`
--
ALTER TABLE `ref_document_assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id (auto generated)', AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ref_document_type`
--
ALTER TABLE `ref_document_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique ID (auto generated)', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ref_position`
--
ALTER TABLE `ref_position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id of position (auto generated)', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ref_program`
--
ALTER TABLE `ref_program`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id of program/course (auto generated)', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ref_program_major`
--
ALTER TABLE `ref_program_major`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique if of major (auto generated)', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `submission_archive`
--
ALTER TABLE `submission_archive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `submission_reply`
--
ALTER TABLE `submission_reply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id of messages (auto generated)', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `submission_reply_seen`
--
ALTER TABLE `submission_reply_seen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id (auto generated)', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `submission_thread`
--
ALTER TABLE `submission_thread`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique ID (auto generated)', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `submission_thread_seen`
--
ALTER TABLE `submission_thread_seen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id (auto generated)', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `system_other_feature`
--
ALTER TABLE `system_other_feature`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id of user', AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `user_archive`
--
ALTER TABLE `user_archive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_company`
--
ALTER TABLE `user_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id', AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_timesheet`
--
ALTER TABLE `user_timesheet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id', AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcement`
--
ALTER TABLE `announcement`
  ADD CONSTRAINT `announcement_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `announcement_program_tags`
--
ALTER TABLE `announcement_program_tags`
  ADD CONSTRAINT `announcement_program_tags_ibfk_1` FOREIGN KEY (`announcement_id`) REFERENCES `announcement` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `announcement_program_tags_ibfk_2` FOREIGN KEY (`ref_program_id`) REFERENCES `ref_program` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `announcement_seen`
--
ALTER TABLE `announcement_seen`
  ADD CONSTRAINT `announcement_seen_ibfk_1` FOREIGN KEY (`announcement_id`) REFERENCES `announcement` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `announcement_seen_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

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
-- Constraints for table `coordinator_programs`
--
ALTER TABLE `coordinator_programs`
  ADD CONSTRAINT `coordinator_programs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `coordinator_programs_ibfk_2` FOREIGN KEY (`ref_program_id`) REFERENCES `ref_program` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `evaluation_form`
--
ALTER TABLE `evaluation_form`
  ADD CONSTRAINT `evaluation_form_ibfk_1` FOREIGN KEY (`evaluation_criteria_id`) REFERENCES `evaluation_criteria` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `evaluation_form_ibfk_2` FOREIGN KEY (`trainee_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `evaluation_form_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `evaluation_form_ibfk_4` FOREIGN KEY (`submission_thread_id`) REFERENCES `submission_thread` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ref_program_major`
--
ALTER TABLE `ref_program_major`
  ADD CONSTRAINT `ref_program_major_ibfk_1` FOREIGN KEY (`ref_program_id`) REFERENCES `ref_program` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `submission_archive`
--
ALTER TABLE `submission_archive`
  ADD CONSTRAINT `submission_archive_ibfk_1` FOREIGN KEY (`submission_thread_id`) REFERENCES `submission_thread` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `submission_archive_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `submission_reply`
--
ALTER TABLE `submission_reply`
  ADD CONSTRAINT `submission_reply_ibfk_1` FOREIGN KEY (`submission_thread_id`) REFERENCES `submission_thread` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `submission_reply_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `submission_reply_seen`
--
ALTER TABLE `submission_reply_seen`
  ADD CONSTRAINT `submission_reply_seen_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `submission_reply_seen_ibfk_2` FOREIGN KEY (`submission_thread_id`) REFERENCES `submission_thread` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `submission_thread`
--
ALTER TABLE `submission_thread`
  ADD CONSTRAINT `submission_thread_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `submission_thread_ibfk_2` FOREIGN KEY (`ref_document_type_id`) REFERENCES `ref_document_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `submission_thread_seen`
--
ALTER TABLE `submission_thread_seen`
  ADD CONSTRAINT `submission_thread_seen_ibfk_1` FOREIGN KEY (`submission_thread_id`) REFERENCES `submission_thread` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `user_company`
--
ALTER TABLE `user_company`
  ADD CONSTRAINT `user_company_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
