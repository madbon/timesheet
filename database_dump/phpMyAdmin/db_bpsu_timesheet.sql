-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2023 at 05:31 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `announcement_program_tags`
--

CREATE TABLE `announcement_program_tags` (
  `id` int(11) NOT NULL COMMENT 'Unique ID (auto generated)',
  `announcement_id` int(11) DEFAULT NULL COMMENT 'foreign key (announcement table)',
  `ref_program_id` int(11) DEFAULT NULL COMMENT 'foreign key (ref_program table)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='This table will store data on which courses/programs will see the announcement';

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
('Administrator', '2', NULL);

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
('m230402_125314_add_permission_assignment', 1680440013);

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
(3, 'Financial Management Department', '');

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
  `enable_commenting` int(11) NOT NULL COMMENT '1 - enable creating comment / 0 - disable creating of comment'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Reference table: types of task';

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
  `id` int(11) NOT NULL COMMENT 'unique id of position (auto generated)',
  `position` varchar(100) DEFAULT NULL COMMENT 'position title'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Reference table: list of company positions';

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
  `id` int(11) NOT NULL COMMENT 'unique id of program/course (auto generated)',
  `title` varchar(250) DEFAULT NULL COMMENT 'title of program/course',
  `abbreviation` varchar(20) DEFAULT NULL COMMENT 'abbreviation of program/course',
  `required_hours` int(11) NOT NULL COMMENT 'required hours to be rendered in OJT'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Reference table: list of programs/courses';

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
  `id` int(11) NOT NULL COMMENT 'unique if of major (auto generated)',
  `ref_program_id` int(11) DEFAULT NULL COMMENT 'foreign key of ref_program table',
  `title` varchar(250) DEFAULT NULL COMMENT 'title of Major',
  `abbreviation` varchar(10) DEFAULT NULL COMMENT 'abbreviation of Major'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Refererence table: list of program''s majors';

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
  `date_time` datetime DEFAULT NULL COMMENT 'date time created/submitted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='transactional table: here you can store all transaction regarding the tasks or submission of Accomplishment Report, Evaluation Form, and Activity Reminder.';

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
(1, 'confirmation_after_face_recognized', 0);

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
  `mobile_no` int(10) DEFAULT NULL COMMENT 'user''s mobile no.',
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
(2, NULL, NULL, NULL, NULL, 0, NULL, NULL, 'Juan', 'Reyes', 'Dela Cruz', '', '1995-10-12', 'M', 'admin123', 'mLv-KdIB84pIgOrOKnopaaXc51uQml-_', '$2y$13$e4Dcc2wVy3ur10rqQ8mkae0JLsO58dHURdZnvqhZTTDxYu5XI64gO', NULL, 'admin@gm.com', NULL, '', '', 10, 1678168986, 1678168986, 'alqvh-uTo-NSx86JuSUvY_5iG3xkpOQG_1678168986');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id of announcement (auto generated)';

--
-- AUTO_INCREMENT for table `announcement_program_tags`
--
ALTER TABLE `announcement_program_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID (auto generated)';

--
-- AUTO_INCREMENT for table `coordinator_programs`
--
ALTER TABLE `coordinator_programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique ID';

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id of file (auto generated)';

--
-- AUTO_INCREMENT for table `ref_company`
--
ALTER TABLE `ref_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id (auto generated)';

--
-- AUTO_INCREMENT for table `ref_department`
--
ALTER TABLE `ref_department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique ID (auto generated)', AUTO_INCREMENT=4;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique if of major (auto generated)', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `submission_reply`
--
ALTER TABLE `submission_reply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id of messages (auto generated)';

--
-- AUTO_INCREMENT for table `submission_reply_seen`
--
ALTER TABLE `submission_reply_seen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id (auto generated)';

--
-- AUTO_INCREMENT for table `submission_thread`
--
ALTER TABLE `submission_thread`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique ID (auto generated)';

--
-- AUTO_INCREMENT for table `submission_thread_seen`
--
ALTER TABLE `submission_thread_seen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id (auto generated)';

--
-- AUTO_INCREMENT for table `system_other_feature`
--
ALTER TABLE `system_other_feature`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id of user', AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `user_archive`
--
ALTER TABLE `user_archive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_company`
--
ALTER TABLE `user_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id';

--
-- AUTO_INCREMENT for table `user_timesheet`
--
ALTER TABLE `user_timesheet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id';

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
-- Constraints for table `submission_reply`
--
ALTER TABLE `submission_reply`
  ADD CONSTRAINT `submission_reply_ibfk_1` FOREIGN KEY (`submission_thread_id`) REFERENCES `submission_thread` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

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
-- Constraints for table `user_company`
--
ALTER TABLE `user_company`
  ADD CONSTRAINT `user_company_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
