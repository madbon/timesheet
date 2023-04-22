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
  KEY `id_2` (`id`),
  KEY `viewer_type` (`viewer_type`),
  CONSTRAINT `announcement_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='This table would allow you to store announcement details/content.';

-- Data exporting was unselected.

-- Dumping structure for table db_bpsu_timesheet.announcement_program_tags
CREATE TABLE IF NOT EXISTS `announcement_program_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID (auto generated)',
  `announcement_id` int(11) DEFAULT NULL COMMENT 'foreign key (announcement table)',
  `ref_program_id` int(11) DEFAULT NULL COMMENT 'foreign key (ref_program table)',
  PRIMARY KEY (`id`),
  KEY `announcement_id` (`announcement_id`),
  KEY `ref_program_id` (`ref_program_id`),
  CONSTRAINT `announcement_program_tags_ibfk_1` FOREIGN KEY (`announcement_id`) REFERENCES `announcement` (`id`),
  CONSTRAINT `announcement_program_tags_ibfk_2` FOREIGN KEY (`ref_program_id`) REFERENCES `ref_program` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='This table will store data on which courses/programs will see the announcement';

-- Data exporting was unselected.

-- Dumping structure for table db_bpsu_timesheet.auth_assignment
CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) NOT NULL COMMENT 'foreign key (unique name of role)',
  `user_id` int(11) NOT NULL COMMENT 'unique id, foreign key from user table',
  `created_at` int(11) DEFAULT NULL COMMENT 'date and time created',
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `idx-auth_assignment-user_id` (`user_id`),
  KEY `item_name` (`item_name`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_assignment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='this table will store the data of users who have an assigned role or permission to access the system';

-- Data exporting was unselected.

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

-- Data exporting was unselected.

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

-- Data exporting was unselected.

-- Dumping structure for table db_bpsu_timesheet.auth_rule
CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Please disregard this table because we didn''t use it, but it was automatically migrated to the database once you installed the yii2 php framework, so it might be useful, so don''t delete it.';

-- Data exporting was unselected.

-- Dumping structure for table db_bpsu_timesheet.coordinator_programs
CREATE TABLE IF NOT EXISTS `coordinator_programs` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique ID',
  `user_id` int(11) DEFAULT NULL COMMENT 'foreign key from user table (coordinator id)',
  `ref_program_id` int(11) DEFAULT NULL COMMENT 'foreign key from ref_program table (unique id of program/course)',
  `ref_program_major_id` int(11) DEFAULT NULL COMMENT 'just ready in case the different majors need to be assigned to the coordinator',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `user_id` (`user_id`),
  KEY `ref_program_id` (`ref_program_id`),
  KEY `ref_program_major_id` (`ref_program_major_id`),
  CONSTRAINT `coordinator_programs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `coordinator_programs_ibfk_2` FOREIGN KEY (`ref_program_id`) REFERENCES `ref_program` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `coordinator_programs_ibfk_3` FOREIGN KEY (`ref_program_major_id`) REFERENCES `ref_program_major` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='here you can see the coordinator''s assigned programs/courses';

-- Data exporting was unselected.

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
  KEY `user_timesheet_id` (`user_timesheet_id`),
  CONSTRAINT `files_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `files_ibfk_2` FOREIGN KEY (`user_timesheet_id`) REFERENCES `user_timesheet` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=174 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='in this table you can see all the files uploaded to the system';

-- Data exporting was unselected.

-- Dumping structure for table db_bpsu_timesheet.migration
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL COMMENT 'migration file name',
  `apply_time` int(11) DEFAULT NULL COMMENT 'date time migrated',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='auto migrated table once you install the Yii2 PHP framework (serves as repository of migrated default tables of Yii2 Framework)';

-- Data exporting was unselected.

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

-- Data exporting was unselected.

-- Dumping structure for table db_bpsu_timesheet.ref_department
CREATE TABLE IF NOT EXISTS `ref_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique ID (auto generated)',
  `title` varchar(250) DEFAULT NULL COMMENT 'department name',
  `abbreviation` varchar(20) DEFAULT NULL COMMENT 'department abbreviation',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='reference table: the company''s departments are stored here';

-- Data exporting was unselected.

-- Dumping structure for table db_bpsu_timesheet.ref_document_assignment
CREATE TABLE IF NOT EXISTS `ref_document_assignment` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id (auto generated)',
  `ref_document_type_id` int(11) DEFAULT NULL COMMENT 'foreign key of ref_document_type table',
  `auth_item` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'role/permission name (auth_item table)',
  `type` varchar(20) DEFAULT NULL COMMENT 'task identifier (SENDER or RECEIVER)',
  `filter_type` varchar(150) DEFAULT NULL COMMENT 'Backend filter identifier (this serves as basis to filter the task)',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `ref_document_type_id` (`ref_document_type_id`),
  KEY `auth_item` (`auth_item`),
  KEY `type` (`type`),
  KEY `filter_type` (`filter_type`),
  CONSTRAINT `ref_document_assignment_ibfk_1` FOREIGN KEY (`ref_document_type_id`) REFERENCES `ref_document_type` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `ref_document_assignment_ibfk_2` FOREIGN KEY (`auth_item`) REFERENCES `auth_item` (`name`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='reference table: serves as the system''s basis for who is the receiver or sender of the Accomplishment Report, Evaluation Form, & Activity Reminder';

-- Data exporting was unselected.

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

-- Data exporting was unselected.

-- Dumping structure for table db_bpsu_timesheet.ref_position
CREATE TABLE IF NOT EXISTS `ref_position` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id of position (auto generated)',
  `position` varchar(100) DEFAULT NULL COMMENT 'position title',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Reference table: list of company positions';

-- Data exporting was unselected.

-- Dumping structure for table db_bpsu_timesheet.ref_program
CREATE TABLE IF NOT EXISTS `ref_program` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id of program/course (auto generated)',
  `title` varchar(250) DEFAULT NULL COMMENT 'title of program/course',
  `abbreviation` varchar(20) DEFAULT NULL COMMENT 'abbreviation of program/course',
  `required_hours` int(11) NOT NULL COMMENT 'required hours to be rendered in OJT',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Reference table: list of programs/courses';

-- Data exporting was unselected.

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

-- Data exporting was unselected.

-- Dumping structure for table db_bpsu_timesheet.student_section
CREATE TABLE IF NOT EXISTS `student_section` (
  `section` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  UNIQUE KEY `section` (`section`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Reference table: list of sections';

-- Data exporting was unselected.

-- Dumping structure for table db_bpsu_timesheet.student_year
CREATE TABLE IF NOT EXISTS `student_year` (
  `year` int(1) NOT NULL,
  `title` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`year`),
  UNIQUE KEY `year` (`year`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Reference table: list of years';

-- Data exporting was unselected.

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='transaction table: this table allows user to store messages/comment regarding the submitted document (AR) or performed tasks (creating activity reminder) (messenger)';

-- Data exporting was unselected.

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
  CONSTRAINT `submission_thread_ibfk_2` FOREIGN KEY (`ref_document_type_id`) REFERENCES `ref_document_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `submission_thread_ibfk_3` FOREIGN KEY (`tagged_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='transactional table: here you can store all transaction regarding the tasks or submission of Accomplishment Report, Evaluation Form, and Activity Reminder.';

-- Data exporting was unselected.

-- Dumping structure for table db_bpsu_timesheet.submission_thread_seen
CREATE TABLE IF NOT EXISTS `submission_thread_seen` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id (auto generated)',
  `submission_thread_id` int(11) DEFAULT NULL COMMENT 'foreign key id of submission_thread table',
  `user_id` int(11) DEFAULT NULL COMMENT 'forein key id of user table (who viewed the created tasks or submitted document)',
  `date_time` datetime DEFAULT NULL COMMENT 'date time seen',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `submission_thread_id` (`submission_thread_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `submission_thread_seen_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `submission_thread_seen_ibfk_2` FOREIGN KEY (`submission_thread_id`) REFERENCES `submission_thread` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Transactional table: serves as basis if the user seen the submitted document or viewed the created activity reminder';

-- Data exporting was unselected.

-- Dumping structure for table db_bpsu_timesheet.suffix
CREATE TABLE IF NOT EXISTS `suffix` (
  `title` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `meaning` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`title`),
  KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Reference table: list of suffixes';

-- Data exporting was unselected.

-- Dumping structure for table db_bpsu_timesheet.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id of user',
  `student_idno` varchar(50) DEFAULT NULL COMMENT 'student id no',
  `student_year` int(1) DEFAULT NULL COMMENT 'student''s year',
  `student_section` varchar(5) DEFAULT NULL COMMENT 'student''s section',
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
  KEY `ref_position_id` (`ref_position_id`),
  KEY `status` (`status`),
  KEY `sex` (`sex`),
  KEY `bday` (`bday`),
  KEY `student_section` (`student_section`),
  KEY `student_year` (`student_year`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`student_section`) REFERENCES `student_section` (`section`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `user_ibfk_2` FOREIGN KEY (`suffix`) REFERENCES `suffix` (`title`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `user_ibfk_3` FOREIGN KEY (`student_year`) REFERENCES `student_year` (`year`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `user_ibfk_4` FOREIGN KEY (`ref_program_id`) REFERENCES `ref_program` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `user_ibfk_5` FOREIGN KEY (`ref_program_major_id`) REFERENCES `ref_program_major` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `user_ibfk_6` FOREIGN KEY (`ref_position_id`) REFERENCES `ref_position` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `user_ibfk_7` FOREIGN KEY (`ref_department_id`) REFERENCES `ref_department` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='List of users of the system';

-- Data exporting was unselected.

-- Dumping structure for table db_bpsu_timesheet.user_archive
CREATE TABLE IF NOT EXISTS `user_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_status` smallint(6) DEFAULT NULL,
  `date_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `id` (`id`),
  KEY `user_status` (`user_status`),
  CONSTRAINT `user_archive_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `user_archive_ibfk_2` FOREIGN KEY (`user_status`) REFERENCES `user` (`status`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Data exporting was unselected.

-- Dumping structure for table db_bpsu_timesheet.user_company
CREATE TABLE IF NOT EXISTS `user_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'unique id',
  `user_id` int(11) DEFAULT NULL COMMENT 'foreign key id of user table (trainee or supervisor)',
  `ref_company_id` int(11) DEFAULT NULL COMMENT 'foreign key id of ref_company table (assigned company)',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `ref_company_id` (`ref_company_id`),
  KEY `id` (`id`),
  CONSTRAINT `user_company_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `user_company_ibfk_2` FOREIGN KEY (`ref_company_id`) REFERENCES `ref_company` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='List of users (trainee and supervisor) assigned company';

-- Data exporting was unselected.

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
  KEY `status` (`status`),
  CONSTRAINT `user_timesheet_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='This table serves as storage of time in/out that displays in the DTR of trainee';

-- Data exporting was unselected.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
