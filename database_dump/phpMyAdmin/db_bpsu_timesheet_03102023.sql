-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2023 at 09:14 AM
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
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `user_info_id` int(11) DEFAULT NULL,
  `region_c` varchar(2) DEFAULT NULL,
  `province_c` varchar(3) DEFAULT NULL,
  `citymun_c` varchar(3) DEFAULT NULL,
  `barangay_c` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
('Administrator', '6', NULL),
('CompanySupervisor', '15', NULL);

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
('Administrator', 'USER-MANAGEMENT-MODULE'),
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
-- Table structure for table `cms_actions`
--

CREATE TABLE `cms_actions` (
  `id` int(11) NOT NULL,
  `title` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cms_role`
--

CREATE TABLE `cms_role` (
  `id` int(11) NOT NULL,
  `title` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cms_role`
--

INSERT INTO `cms_role` (`id`, `title`) VALUES
(1, 'Administrator'),
(2, 'Coordinator'),
(3, 'Trainee');

-- --------------------------------------------------------

--
-- Table structure for table `cms_role_actions`
--

CREATE TABLE `cms_role_actions` (
  `id` int(11) NOT NULL,
  `cms_role_id` int(11) DEFAULT NULL,
  `cms_actions_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cms_role_assignment`
--

CREATE TABLE `cms_role_assignment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `cms_role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cms_role_assignment`
--

INSERT INTO `cms_role_assignment` (`id`, `user_id`, `cms_role_id`) VALUES
(1, NULL, 0),
(2, 12, 2),
(3, 2, 3),
(4, 4, 2),
(5, 9, 2),
(6, 5, 3),
(7, 6, 3);

-- --------------------------------------------------------

--
-- Table structure for table `contact_info`
--

CREATE TABLE `contact_info` (
  `id` int(11) NOT NULL,
  `user_info_id` int(10) DEFAULT NULL,
  `mobile_no` int(10) DEFAULT NULL,
  `landline_no` varchar(25) DEFAULT NULL,
  `email_add` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
(8, 2, 'UserData', 12, 'esig3', 'png', '66a9e2ea397cbbbf4f9a4b160796a596', NULL, 1678348171);

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
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
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
  `verification_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_info_id` (`user_info_id`),
  ADD KEY `id` (`id`),
  ADD KEY `region_c` (`region_c`),
  ADD KEY `province_c` (`province_c`),
  ADD KEY `citymun_c` (`citymun_c`),
  ADD KEY `barangay_c` (`barangay_c`);

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
-- Indexes for table `cms_actions`
--
ALTER TABLE `cms_actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `title` (`title`);

--
-- Indexes for table `cms_role`
--
ALTER TABLE `cms_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role` (`title`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `cms_role_actions`
--
ALTER TABLE `cms_role_actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `cms_role_id` (`cms_role_id`),
  ADD KEY `cms_actions_id` (`cms_actions_id`);

--
-- Indexes for table `cms_role_assignment`
--
ALTER TABLE `cms_role_assignment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `cms_role_id` (`cms_role_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `contact_info`
--
ALTER TABLE `contact_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_info_id` (`user_info_id`),
  ADD KEY `id` (`id`);

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
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cms_actions`
--
ALTER TABLE `cms_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cms_role`
--
ALTER TABLE `cms_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cms_role_actions`
--
ALTER TABLE `cms_role_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cms_role_assignment`
--
ALTER TABLE `cms_role_assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
-- Constraints for table `cms_role_actions`
--
ALTER TABLE `cms_role_actions`
  ADD CONSTRAINT `cms_role_actions_ibfk_1` FOREIGN KEY (`cms_role_id`) REFERENCES `cms_role` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `cms_role_actions_ibfk_2` FOREIGN KEY (`cms_actions_id`) REFERENCES `cms_actions` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `cms_role_assignment`
--
ALTER TABLE `cms_role_assignment`
  ADD CONSTRAINT `cms_role_assignment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
