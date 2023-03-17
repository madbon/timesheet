-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2023 at 11:49 AM
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
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `time_in` varchar(20) DEFAULT NULL,
  `time_out` varchar(20) DEFAULT NULL,
  `remarks` varchar(50) DEFAULT NULL,
  `access_type` varchar(50) DEFAULT NULL COMMENT 'facial recognition or thru password'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
('Administrator', '23', NULL),
('Administrator', '6', NULL),
('CompanySupervisor', '15', NULL),
('CompanySupervisor', '31', NULL),
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
('CompanySupervisor', 1, '', NULL, NULL, NULL, NULL),
('create-button-administrator', 2, '', NULL, NULL, NULL, NULL),
('create-button-company-supervisor', 2, '', NULL, NULL, NULL, NULL),
('create-button-ojt-coordinator', 2, '', NULL, NULL, NULL, NULL),
('create-button-trainee', 2, '', NULL, NULL, NULL, NULL),
('menu-map-markers', 2, '', NULL, NULL, NULL, NULL),
('menu-settings', 2, '', NULL, NULL, NULL, NULL),
('menu-timesheet', 2, '', NULL, NULL, NULL, NULL),
('menu-user-management', 2, '', NULL, NULL, NULL, NULL),
('OjtCoordinator', 1, '', NULL, NULL, NULL, NULL),
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
('Trainee', 1, '', NULL, NULL, NULL, NULL),
('upload-signature', 2, 'permission to upload signature', NULL, NULL, NULL, NULL),
('user-management-create', 2, NULL, NULL, NULL, NULL, NULL),
('user-management-delete', 2, '', NULL, NULL, NULL, NULL),
('user-management-delete-role-assigned', 2, '', NULL, NULL, NULL, NULL),
('user-management-index', 2, '', NULL, NULL, NULL, NULL),
('USER-MANAGEMENT-MODULE', 2, 'access to all permissions of user management', NULL, NULL, NULL, NULL),
('user-management-update', 2, '', NULL, NULL, NULL, NULL),
('user-management-upload-file', 2, '', NULL, NULL, NULL, NULL),
('user-management-view', 2, '', NULL, NULL, NULL, NULL);

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
('Administrator', 'USER-MANAGEMENT-MODULE'),
('CompanySupervisor', 'access-trainee-index'),
('CompanySupervisor', 'menu-user-management'),
('CompanySupervisor', 'SETTINGS'),
('CompanySupervisor', 'settings-index'),
('CompanySupervisor', 'upload-signature'),
('CompanySupervisor', 'user-management-index'),
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
('SETTINGS', 'settings-index'),
('SETTINGS', 'settings-list-positions'),
('Trainee', 'menu-timesheet'),
('Trainee', 'time-in-out'),
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
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `user_id`, `model_name`, `model_id`, `file_name`, `extension`, `file_hash`, `remarks`, `created_at`) VALUES
(2, 2, 'UserData', 4, 'esig3', 'png', '65f7ebb4bf92b7b7bef7e59a25ecbb98', NULL, 1678335075),
(3, 2, 'UserData', 5, 'esig4', 'png', '4fe59a1eba5fbe2e9380e3fd87f26fe9', NULL, 1678335090),
(4, 2, 'UserData', 6, 'esig2', 'png', 'e1301f064511d0d59140ab37dbd553f6', NULL, 1678335098),
(6, 2, 'UserData', 2, 'esig1', 'png', 'cb82b1232e6bd27563d9b4b121f6c506', NULL, 1678335196),
(7, 2, 'UserData', 9, 'esig2', 'png', 'db8c00be880f4084d57946a7ee2cf1e3', NULL, 1678345294),
(8, 2, 'UserData', 12, 'esig3', 'png', '66a9e2ea397cbbbf4f9a4b160796a596', NULL, 1678348171),
(9, 2, 'UserData', 28, 'esig4', 'png', '47e2d40cf57a1028c173b4c50eb61bf7', NULL, 1678957490),
(10, 31, 'UserData', 31, 'esig1', 'png', '787c4cbba8e7efd94fd124ee927b60af', NULL, 1678975571);

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
('m200409_110543_rbac_update_mssql_trigger', 1678417445);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_tags`
--

CREATE TABLE `post_tags` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `ref_program_id` int(11) DEFAULT NULL,
  `ref_program_major_id` int(11) DEFAULT NULL,
  `ref_department_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(14, 'Sky Cable', 'Sky Cable, Saturn, Mandaluyong, Metro Manila, Philippines', '14.5791861', '121.0249454', ''),
(17, 'Converge ICT Solutions Inc', 'Converge ICT Solutions Inc, Eulogio Rodriguez Jr. Avenue, Pasig, Metro Manila, Philippines', '14.5779240', '121.0739720', '2343434'),
(18, 'La Bella Villa Resort', 'La Bella Villa Resort, Bgy, San Baraquiel, St, Valenzuela, Metro Manila, Philippines', '14.7411074', '120.9862269', '2343-12323'),
(19, 'Accenture Gateway Tower 2', 'Accenture Gateway Tower 2, General Aguinaldo Avenue, Cubao, Quezon City, Metro Manila, Philippines', '14.6226048', '121.0530741', '');

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
-- Table structure for table `ref_document_type`
--

CREATE TABLE `ref_document_type` (
  `id` int(11) NOT NULL,
  `title` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `abbreviation` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ref_program`
--

INSERT INTO `ref_program` (`id`, `title`, `abbreviation`) VALUES
(1, 'Bachelor of Science in Information Technology', 'BSIT'),
(2, 'Bachelor of Science in Computer Science', 'BSCS'),
(3, 'Bachelor of Science in Computer Engineering', 'BSCE'),
(4, 'Bachelor of Science in Electronics Engineering', 'BSECE'),
(5, 'Bachelor of Science in Entrepreneurship Management', 'BSEM');

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
(1, 1, 'Computer Programming', 'CP'),
(2, 1, 'Information System', 'IS');

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
(1, '1st Year'),
(2, '2nd Year'),
(3, '3rd Year'),
(4, '4th Year'),
(5, '5th Year');

-- --------------------------------------------------------

--
-- Table structure for table `submission_thread`
--

CREATE TABLE `submission_thread` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `ref_document_type_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kim', '', 'Martinez', NULL, '2013-03-08', 'M', 'kimberjune', 'bx-_6DrWVLfMIFcL8-k0CGC26BOz3VcM', '$2y$13$h7lpx1SzzRtc2KJ901p5a.jbVuRvp8gPB9oZwxJeVQ8rxCOYXvNSy', NULL, 'kimberjune@gm.com', NULL, '', NULL, 10, 0, 0, 'xKBM92taJZO9cPOGj3rWqTFxV7AJDNkC_1678246557'),
(5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Daniel', '', 'Padilla', NULL, '2013-03-06', 'M', 'deniel', 'hxDbgPXGZO0gakuA3txWWRNhyXni59em', '$2y$13$R4RgHgwzDxpswiMNafbik.gYvtjVAkAn6oGGS9Wckj2gzdNZaxgli', NULL, 'deniel@gm.com', NULL, '', NULL, 10, 0, 0, 'mYTqg1KsP60Preuf65HXCGDQcoL4MFtU_1678246620'),
(6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'michael', '', 'cortuna', NULL, '2005-03-10', 'M', 'michael', 'oLilpGzQJpOIgtFM1aXYqM2ok_KqkQBO', '$2y$13$X6X3L09c3UulgABB57juGuSMyXWinjxuEywPsj42zn3tU7MLzklEi', NULL, 'michael@gm.com', NULL, '', NULL, 10, 0, 0, 'SaZragbYd24ey-M-75NKQJIdch1xKVNK_1678246940'),
(9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Jimmy', '', 'Reyes', NULL, '2013-03-05', 'M', 'jim', 'CN7MzQ0oh4UBa7nkjDfEhM8mv1jNkeVZ', '$2y$13$uoHRirwat1nHhm8YblA6VOVf7v293eVs75BZyG5Vyrj7a9.3FuCN2', NULL, 'jim@gmail.com', NULL, '', NULL, 10, 0, 0, 'nVx0wFrsd2FUXw3JeNetkPL-mGmd3P4H_1678344963'),
(10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Jojo', '', 'Vito', NULL, '2013-03-05', 'M', 'jojo', 'kgnloB8kX1qv5R0N78G0CJIdH1JQcqNb', '$2y$13$kIL70sEYgnrCazTa8vMite4vvwuRPMwXdeeEmC8pnYBP5IrSIgNee', NULL, 'jojo@gm.com', NULL, '', NULL, 10, 0, 0, 'he3TEKOJUefD02o1eDVd1CE7fOBEuups_1678345337'),
(12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Warren', '', 'Celeste', NULL, '2013-03-05', 'M', 'warren', 'b8b5ohQe2b088Ag4oODLFGuZukUMf9Lf', '$2y$13$0BQ2nKuyj0JepnxthYtxKefTIv1A1g/8saAhcQFstW6OMAreXFpGO', NULL, 'warren@gm.com', NULL, '', NULL, 10, 0, 0, 'srcOj_S0cmMgsrccugdmIcu0aIvBUx7s_1678348138'),
(13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ken', '', 'Mateo', NULL, '2005-03-10', 'M', 'ken', 'dU_YwJsZbxPpzMhLenmo62G3HUQRQByy', '$2y$13$d6/4LxP7LqGnJM3JJQLyf.XdJpnWfaSau3/Kn4Hb5pgaZc09hEfP.', NULL, 'ken@gm.com', NULL, '', NULL, 10, 0, 0, 'aFFYT7PA5MtXlgmzAwrrYi2kS4Er3kj-_1678434605'),
(15, NULL, NULL, NULL, NULL, NULL, 2, 2, 'sdfdfd', 'fdfd', 'fdfdf', '', '2005-03-10', 'M', 'asdsd', 'Uas9Q6lT6K2ZleRjQUe7u9-f0STX8fUZ', '$2y$13$o5HF8ta/VDg0f7sn5hd1HekdePk7Jr5dPq7JoksNSUsYOHYzltH3K', NULL, 'sdfdf@gf.com', NULL, '', '', 10, 0, 0, 'Gx2hofcN7X0ltP3xHFAfi0lBd4RgzE6y_1678435021'),
(18, '234343', 2, 'B', NULL, NULL, 2, NULL, 'sdfd', 'fdf', 'dfdf', 'II', '2005-03-06', 'M', 'jer', 'yxYFkfmyTqysOAk8W9TjQ2-kUVmy4j7h', '$2y$13$02lOdIuKb3YUsiNzI9/SW.q9BXChjTWbUT0saWAPwY3dZzlCnRhjC', NULL, 'jer@gm.com', 2147483647, '1232323', '033B Elma Street, Don Fabian, Brgy. Commonwealth, Quezon City, 1121', 10, 0, 0, 'O6NNP9b9x-dPjyaHeh8J_r_J_SYx7VKV_1678674129'),
(20, '1232090', 1, 'B', 1, 1, 1, 1, 'John', '', 'Smooth', 'IV', '2005-03-06', 'M', 'trainee', 'a7jMTVWHllh3qnNl9HE4lLBrexdWRYh8', '$2y$13$bBA.7wEkNaHZUm9WTxjoieI8XTckTg2eMoDltOdMeq9Y7eNfil27W', NULL, 'nap@gm.com', 2147483647, '2343434', '12323 address', 10, 0, 0, 'BI5HOKRlYM6YNi6HhzRDRJX7jH7Fu3Xg_1678677157'),
(21, '2313553', 4, 'B', 1, 2, 3, NULL, 'vilma', '', 'dayagmil', '', '2005-03-06', 'M', 'vilma', 'bQW83W97gNRv8h_OLOQQEcBKt82ZKDtG', '$2y$13$p12B2eY8FRiAArUz1ONr7.bugwXDqwfCjh7diU2YcVSc.BYIbHJQ6', NULL, 'vilma@gm.com', 9232323, 'sdfdf', 'sdfdfd', 10, 0, 0, 'mEhL6bWT6Dms3Cs8-jvfRt8N-D9OqWPL_1678677395'),
(22, '234343', 4, 'E', 4, NULL, 1, NULL, 'france', '', 'dacales', '', '2005-02-28', 'F', 'france', 'LEH7yRVrvsCkfYGvvykGSekyD_gq3q5S', '$2y$13$oqmSvq5yfCPHkOARf8Wyye5s4WnZjXJ8ilMdqmgFWjXT9hQah8LSK', NULL, 'france@gm.com', 2147483647, '2343434', 'sdfdfd', 10, 0, 0, 'NuE-OGiB9RnY3zRC6Qe7OGar1-Up5vrx_1678677582'),
(23, NULL, NULL, NULL, 2, NULL, NULL, NULL, 'alvin', '', 'sibaluca', 'II', '2005-03-06', 'M', 'alvin', 'Jt2FFZ4bDd5qIpZXNgDVJgD5zdGcnaAN', '$2y$13$4PWK6Ic8FySi/zmcrSa16O698puS9W3ESCemobfyMHm1/FnJsNj0i', NULL, 'alvin@gm.com', 2147483647, 'tel12323', '031 Elma Stree, Don Fabian,  Brgy. Commonwealth, Quezon City, Metro Manila, 1121', 10, 0, 0, 'ycVi4JFu-nQdW7jEf0KESszpRK-XsFt2_1678687295'),
(24, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'Nicka', '', 'De Guzman', '', '2005-02-27', 'M', 'coor', '1Veun2dt3r9hnBJQ7Qn0G5H0Tkagzu84', '$2y$13$27LnUZ568Q46.lXRp4yXa.a689gXPsxms76TphmARiO9gbgUVIKqq', NULL, 'nickadg@gm.com', 2147483647, '2323323', 'Tabing Ilog, Malolos, Bulacan', 10, 0, 0, 'DlnHssTWDN0RLchN0Bf_udvgnI7qnM0C_1678689072'),
(25, NULL, NULL, NULL, 2, NULL, NULL, NULL, 'Marcus', 'dfdf', 'Reyes', 'III', '2005-03-07', 'M', 'marcus', 'mS36TXMKD9ktQFooRCC1a1p6q6NK3qq7', '$2y$13$60UT0u3vkMLSTaMCP6vHG.uaWhFLVTrQQsvKbJEP3gDac.miq.qJS', NULL, 'marcus@gm.com', 2147483647, '1232323', 'fsdfdf', 10, 0, 0, 'EOoPNX67A_NLXRYhBO5xW-_22LSVzd1U_1678689188'),
(26, NULL, NULL, NULL, 3, NULL, NULL, NULL, 'Leonel', '', 'Coor', 'Jr.', '2005-03-09', 'M', 'leonelcoor', '361qo_APVzQbGJDIs_lE4ZhkvLLfEVkk', '$2y$13$ijx.ka0GfD0WB0glocpag.lpcpMs7RsDJHiV0.TDt2sTPoIdkIJXe', NULL, 'leonelcoor@gm.com', 2147483647, '4342314', 'Elma Street, Comm', 10, 0, 0, '2RVtFc_XyO12dJyLeZNLDHE1-t__S44V_1678689352'),
(27, NULL, NULL, NULL, 4, NULL, NULL, NULL, 'Romnick', '', 'Alfons', 'III', '2005-03-07', 'M', 'romnickalfons', '4YtvYAdGttEKx2ro_xL25Cr5v4hl8S7N', '$2y$13$2L2AdxFpw/uiu99rp15myev4.KptVpC2180EmucCNZYMnvN9miWhi', NULL, 'romnickalfons@gm.com', 2147483647, '', 'Batangas City', 10, 0, 0, 'mQKXx69OXzkobBHTxn_m7HqO3hOVG8zb_1678689520'),
(28, '890232', 4, 'A', 5, NULL, 1, NULL, 'Genese', '', 'Luna', '', '2005-03-15', 'F', 'genluna', 'PiowCQ7Fw-U9np-bROC2IsXvT9S2SY0I', '$2y$13$JItdkwe.rjAQqV2ofRJjaeVIp4afiNwBxxov3/CcHWgQ5k/TTMYQ6', NULL, 'genluna@gm.com', 923239232, '123-1232', 'Bocaue, Bulacan', 10, 0, 0, 'Nstb34KJO89hoarjamjI6F0WwMGrhSy9_1678847596'),
(29, '12-209323', 2, 'C', 3, NULL, 1, NULL, 'NOEL', '', 'YESOR', 'Sr.', '2005-03-16', 'M', 'noelyessor', 'dmovFCrz1sHsQdC6W0qPjN92ZKFArEoh', '$2y$13$21oUDcAN7rbchJjgkWanweu4Ordf7IZZGJOmnoTB9h1XfS4JGf8py', NULL, 'noelyessor@gm.com', 912323232, '2343-4343', '394 Panga St. Don Fabian Brgy. Commonwealth, Quezon City', 10, 0, 0, '7Mg8dwkIznybc-MDFMQfMfz684kxp0Hm_1678948982'),
(30, '12-0932323', 4, 'C', 2, NULL, 1, NULL, 'Coco', '', 'Martin', 'IV', '2005-03-07', 'M', 'cocomartin', 'j18zpNSDWoU7FIhBPg8rp8F54wDKvYbb', '$2y$13$SrkIl5Upg5cnC9tHtKu0VetZkr9Tpqd7mzYflToxNshTO5w.AitA2', NULL, 'cocomartin@gm.com', 934343434, '23434', '9123 Coco St. Brgy. Matapang, Bataan', 10, 0, 0, 'MAbkw-ZokCSnRrD3iKD7pz31CvudetfX_1678949188'),
(31, NULL, NULL, NULL, NULL, NULL, 1, 1, 'Heather', '', 'Miranda', '', '2005-03-15', 'F', 'supervisor', 'NiMqkvUJL1-jlIOs3H7Ev6kWEiD4wFdw', '$2y$13$DVoW8H6dS.U6pVz//e4LGuUPr3c1Pxddt3Pk.tOL.v4O7lrNPW3L6', NULL, 'heather@gm.com', 912323232, '454-45454', 'Malolos, Bulacan', 10, 0, 0, '5VPdHej0dhW3AmqIg2uDyLaym6ktx8Wl_1678957717');

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
(1, 18, 19),
(2, 20, 19),
(3, 21, 18),
(4, 22, 14),
(5, 28, 17),
(6, 29, 19),
(7, 30, 19),
(8, 15, 17),
(9, 31, 19),
(10, 24, NULL);

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
  `remarks` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_timesheet`
--

INSERT INTO `user_timesheet` (`id`, `user_id`, `time_in_am`, `time_out_am`, `time_in_pm`, `time_out_pm`, `date`, `remarks`) VALUES
(12, 20, '08:00:00', '12:00:00', '14:48:13', '20:48:15', '2023-03-16', 'Sample remarks'),
(14, 20, NULL, NULL, '17:58:55', '17:59:05', '2023-03-17', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `idx-auth_assignment-user_id` (`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `id` (`id`),
  ADD KEY `model_id` (`model_id`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_at` (`created_at`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `post_tags`
--
ALTER TABLE `post_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `ref_department_id` (`ref_department_id`),
  ADD KEY `ref_program_id` (`ref_program_id`),
  ADD KEY `ref_program_major_id` (`ref_program_major_id`),
  ADD KEY `user_id` (`user_id`);

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
-- Indexes for table `ref_document_type`
--
ALTER TABLE `ref_document_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

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
-- Indexes for table `submission_thread`
--
ALTER TABLE `submission_thread`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `ref_document_type_id` (`ref_document_type_id`);

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
  ADD KEY `ref_company_id` (`ref_company_id`);

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
  ADD KEY `date` (`date`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_tags`
--
ALTER TABLE `post_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ref_company`
--
ALTER TABLE `ref_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `ref_department`
--
ALTER TABLE `ref_department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ref_document_type`
--
ALTER TABLE `ref_document_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `submission_thread`
--
ALTER TABLE `submission_thread`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user_company`
--
ALTER TABLE `user_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_timesheet`
--
ALTER TABLE `user_timesheet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

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
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `post_tags`
--
ALTER TABLE `post_tags`
  ADD CONSTRAINT `post_tags_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `post_tags_ibfk_2` FOREIGN KEY (`ref_department_id`) REFERENCES `ref_department` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `post_tags_ibfk_3` FOREIGN KEY (`ref_program_id`) REFERENCES `ref_program` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `post_tags_ibfk_4` FOREIGN KEY (`ref_program_major_id`) REFERENCES `ref_program_major` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `post_tags_ibfk_5` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
