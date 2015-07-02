-- phpMyAdmin SQL Dump
-- version 4.0.10.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 02, 2015 at 01:08 AM
-- Server version: 5.6.19
-- PHP Version: 5.4.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jobfairdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `api_auth`
--

CREATE TABLE IF NOT EXISTS `api_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valid_key` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key_UNIQUE` (`valid_key`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `api_auth`
--

INSERT INTO `api_auth` (`id`, `valid_key`, `description`) VALUES
(2, 'WDHP5VP681NXND0YFBCW', 'cbapi'),
(3, '5595740829812660', 'indeed');

-- --------------------------------------------------------

--
-- Table structure for table `api_status`
--

CREATE TABLE IF NOT EXISTS `api_status` (
  `date_modified` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`date_modified`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `api_status`
--

INSERT INTO `api_status` (`date_modified`, `status`) VALUES
('2014-10-11 20:36:35', 1),
('2014-12-11 10:08:13', 0),
('2014-12-11 10:08:15', 1),
('2014-12-11 10:36:14', 0),
('2014-12-11 10:36:15', 1),
('2014-12-11 10:58:16', 0),
('2014-12-11 10:58:17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE IF NOT EXISTS `application` (
  `jobid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `application_date` varchar(45) NOT NULL,
  `coverletter` text,
  PRIMARY KEY (`jobid`,`userid`),
  KEY `idx_userid` (`userid`),
  KEY `idx_jobid` (`jobid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `basic_info`
--

CREATE TABLE IF NOT EXISTS `basic_info` (
  `userid` int(11) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `state` varchar(45) DEFAULT NULL,
  `zip_code` varchar(15) DEFAULT NULL,
  `about_me` text,
  `hide_phone` int(11) DEFAULT NULL,
  `allowSMS` int(11) DEFAULT NULL,
  `validated` int(11) DEFAULT NULL,
  `smsCode` int(11) DEFAULT NULL,
  `tries` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`),
  KEY `idx_userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `basic_info`
--

INSERT INTO `basic_info` (`userid`, `phone`, `city`, `state`, `zip_code`, `about_me`, `hide_phone`, `allowSMS`, `validated`, `smsCode`, `tries`) VALUES
(5, NULL, 'Miami/Fort Lauderdale Area', NULL, '0', 'Attended Florida International University', NULL, NULL, NULL, NULL, 0),
(8, NULL, NULL, NULL, '0', 'Laura Alonso, From: Progressive Insurance (Other)', 1, 0, 1, NULL, 0),
(9, '', 'Alaska', 'Alaska', '99676', '', NULL, 0, 0, NULL, 0),
(11, '', 'Miami', 'FL', '0', 'Just checking out your site. Yii sucks.', 0, 0, NULL, NULL, 0),
(12, '', 'Miami', 'Florida', '0', 'This is my Bio.', 0, 0, 0, NULL, 0),
(14, '3053334444', 'Columbia', 'Illinois', '65284', '', NULL, 0, 0, 3785, 0),
(15, '', 'Great Bend', 'Kansas', '67530', '', NULL, 0, 0, NULL, 0),
(16, '', 'Salt Lake City', 'Utah', '84645', '', NULL, 0, 0, NULL, 0),
(17, '', 'Oregon', 'Oregon', '97754', '', NULL, 0, 0, NULL, 0),
(18, '', 'Alaska', 'Alaska', '33125', '', NULL, 0, 0, NULL, 0),
(23, '(305) 348-2744', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0),
(24, NULL, 'Miami', 'Florida', NULL, 'Guest Employer Account', 1, 0, NULL, NULL, 0),
(26, NULL, 'Miami/Fort Lauderdale Area', NULL, NULL, 'Director of Professional Master of Science in Information Technology Program at Florida International University', NULL, NULL, NULL, NULL, 0),
(55, '13054955901', 'Miami/Fort Lauderdale Area', '', '33196', 'Student at Florida International University', NULL, 0, 0, NULL, 0),
(56, '', 'Miami', 'Florida', NULL, 'This is a test employer.', 0, 0, NULL, NULL, 0),
(57, '', 'Miami', 'Florida', NULL, 'This is a test employer', 0, 0, NULL, NULL, 0),
(60, '1111111111', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0),
(61, '2222222222', 'Miami', 'Florida', NULL, 'I am a test automated recruited @ VJF', 0, 0, NULL, NULL, 0),
(71, '3053334444', 'Miami', 'FL', '33172', 'I am a Computer Science student.', 1, 1, 0, 6349, 0),
(72, '3055554444', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0),
(73, '3052224444', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0),
(74, '3053334444', 'Miami', 'FL', NULL, 'Hello hi', 1, 1, 0, NULL, 0),
(75, '9545873232', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0),
(82, '3052224444', 'Miami', 'FL', NULL, 'This is a fake employer.', 1, 1, NULL, NULL, 0),
(83, '3053334444', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0),
(84, '3053334444', 'Miami', 'FL', NULL, 'g', 1, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `company_info`
--

CREATE TABLE IF NOT EXISTS `company_info` (
  `FK_userid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `street` varchar(45) DEFAULT NULL,
  `street2` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `state` varchar(45) DEFAULT NULL,
  `zipcode` varchar(45) DEFAULT NULL,
  `website` varchar(45) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`FK_userid`),
  KEY `idx_FK_userid` (`FK_userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=85 ;

--
-- Dumping data for table `company_info`
--

INSERT INTO `company_info` (`FK_userid`, `name`, `street`, `street2`, `city`, `state`, `zipcode`, `website`, `description`) VALUES
(8, 'Progressive Insurance', NULL, NULL, NULL, NULL, NULL, 'http://www.progressive.com', '<p>Join a place where you can apply your hard-earned skills, test your limits and love what you do.&nbsp;</p>\r\n\r\n<p><strong>Why Progressive?</strong>&nbsp; From day one, you&rsquo;ll contribute to projects integral to company success.&nbsp; We work hard as a team, and our employees are invested in each other&rsquo;s success as much as their own.</p>\r\n\r\n<p>&nbsp;</p>\r\n'),
(11, 'Coplat', '7131 SW 142PL', '', 'Miami', 'FL', '33183', '', 'Stuff blah blah blah'),
(12, 'asdasd', '92919', '', 'Miami', 'florida', '33125', 'employertwo.cis.fiu.edu', 'This is my company name.'),
(24, 'Posted by a Guest Employer ', '11200 SW 8th Street, University Park', NULL, 'Miami', 'Florida', '33174', 'www.cs.fiu.edu', 'This is the general company profile for the Guest Employers that post jobs in our system anonymously.'),
(56, 'FIU', '11200 SW 8th St.', '', 'Miami', 'Florida', '33199', 'www.cis.fiu.edu', 'This is FIU.'),
(57, 'FIU', '11200 SW 8th St.', '', 'Miami', 'Florida', '33199', 'www.cis.fiu.edu', 'This is FIU.'),
(61, 'Virtual Company for Testing', '123 main', '', 'Miami', 'Florida', '330178', 'www.vjf.cis.fiu.edu', 'This is a virtual company for system testing purposes'),
(74, 'Android Fake Studio', '123 Main Street', '', 'Miami', 'FL', '33174', '', 'Hello this'),
(82, 'RComp1', '8888 S Flagler St', '', 'Miami', 'FL', '33174', '', 'This is a fake company.'),
(84, 'Fake', '123 Main St', '', 'Miami', 'FL', '33133', '', 'g');

-- --------------------------------------------------------

--
-- Table structure for table `cover_letter`
--

CREATE TABLE IF NOT EXISTS `cover_letter` (
  `id` int(11) NOT NULL,
  `file_path` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cover_letter`
--

INSERT INTO `cover_letter` (`id`, `file_path`) VALUES
(71, '/JobFair/coverletters/71-StudentCoverLetter.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE IF NOT EXISTS `education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `degree` varchar(45) NOT NULL,
  `major` varchar(45) NOT NULL,
  `graduation_date` date NOT NULL,
  `FK_school_id` int(11) DEFAULT NULL,
  `FK_user_id` int(11) DEFAULT NULL,
  `gpa` float DEFAULT NULL,
  `additional_info` text,
  PRIMARY KEY (`id`),
  KEY `idx_FK_school_id` (`FK_school_id`),
  KEY `idx_FK_user_id` (`FK_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=87 ;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`id`, `degree`, `major`, `graduation_date`, `FK_school_id`, `FK_user_id`, `gpa`, `additional_info`) VALUES
(1, 'Bachelor''s degree', 'Computer Science', '2014-10-04', 1, 5, NULL, ''),
(4, 'Bachelor in Science', 'Computer Science', '2014-11-18', 3, 9, NULL, ''),
(8, 'Bachelor in Science', 'Computer Science', '2014-12-17', 3, 14, NULL, ''),
(9, 'Bachelor in Science', 'Information Technology', '2014-12-12', 7, 15, NULL, ''),
(10, 'Master in Science', 'Information Technology', '2014-12-25', 8, 16, NULL, ''),
(11, 'Master in Science', 'Computer Science', '2014-12-26', 9, 17, NULL, ''),
(12, 'Bachelor in Science', 'Computer Science', '2014-12-19', 3, 18, NULL, ''),
(56, 'Ph.D.', 'Computer Science', '2015-03-04', 12, 26, NULL, ''),
(57, 'Bachelor of Science (BS)', 'Computer Engineering', '1995-03-04', 13, 26, NULL, ''),
(82, '', '', '2015-03-30', 1, 55, NULL, ''),
(83, 'N+', 'Information Technology', '2015-03-30', 10, 55, NULL, ''),
(84, 'Bachelor', 'Computer Science; Software Development', '1969-12-31', 1, 55, NULL, ''),
(86, 'BS', 'Computer Science', '2015-07-31', 1, 71, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `experience`
--

CREATE TABLE IF NOT EXISTS `experience` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FK_userid` int(11) DEFAULT NULL,
  `company_name` varchar(45) DEFAULT NULL,
  `job_title` varchar(45) DEFAULT NULL,
  `job_description` text,
  `startdate` datetime DEFAULT NULL,
  `enddate` datetime DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `state` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_FK_userid` (`FK_userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `experience`
--

INSERT INTO `experience` (`id`, `FK_userid`, `company_name`, `job_title`, `job_description`, `startdate`, `enddate`, `city`, `state`) VALUES
(22, 26, 'Florida International University', 'Director of Professional Master of Science in', '', '2014-01-01 00:00:00', '0000-00-00 00:00:00', '', ''),
(23, 26, 'Flordia International University', 'Associate Professor', '', '2010-08-01 00:00:00', '0000-00-00 00:00:00', '', ''),
(24, 26, 'Florida International University', 'Assistant Professor', '', '2004-08-01 00:00:00', '2010-08-01 00:00:00', '', ''),
(33, 55, 'Ravenscroft Ship Management INC', 'IT Technical Support Officer', 'Supported the roll out of new servers and applications. Installed and configured computer operating systems and\napplications. Monitored and maintained corporation networks and computer systems. Supported and maintained\ncorporate databases playing a key role within the organization. Manage users creating and profiles policy scripts\nwhile dealing with passwords related issues. Provided offsite support to clients and staff to help resolve computer\nsystems issues. Tested and evaluated new technologies later used within the organization.', '2007-01-01 00:00:00', '2014-05-01 00:00:00', '', ''),
(35, 71, 'Florida International University', 'Software Engineer ', 'Developer', '2015-06-10 00:00:00', '0000-00-00 00:00:00', 'Miami', 'FL');

-- --------------------------------------------------------

--
-- Table structure for table `general_skills`
--

CREATE TABLE IF NOT EXISTS `general_skills` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `general_skills`
--

INSERT INTO `general_skills` (`id`, `name`) VALUES
(1, 'Programming'),
(2, 'Web'),
(3, 'Mobile'),
(4, 'Database'),
(5, 'Testing');

-- --------------------------------------------------------

--
-- Table structure for table `handshake`
--

CREATE TABLE IF NOT EXISTS `handshake` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jobid` int(11) DEFAULT NULL,
  `employerid` int(11) NOT NULL,
  `studentid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_employerid` (`employerid`),
  KEY `idx_jobid` (`jobid`),
  KEY `idx_studentid` (`studentid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `job`
--

CREATE TABLE IF NOT EXISTS `job` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL,
  `title` varchar(45) NOT NULL,
  `FK_poster` int(11) NOT NULL,
  `post_date` datetime NOT NULL,
  `deadline` datetime DEFAULT NULL,
  `description` longtext NOT NULL,
  `compensation` varchar(45) DEFAULT NULL,
  `other_requirements` text,
  `email_notification` int(11) DEFAULT NULL,
  `active` int(11) DEFAULT '1',
  `matches_found` int(11) DEFAULT NULL,
  `posting_url` text,
  `comp_name` varchar(255) DEFAULT NULL,
  `poster_email` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_FK_poster` (`FK_poster`),
  FULLTEXT KEY `type` (`type`,`title`,`description`,`comp_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=157 ;

-- --------------------------------------------------------

--
-- Table structure for table `job_match`
--

CREATE TABLE IF NOT EXISTS `job_match` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jobID` int(11) NOT NULL,
  `studentID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_jobid` (`jobID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `job_skill_map`
--

CREATE TABLE IF NOT EXISTS `job_skill_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jobid` int(11) NOT NULL,
  `skillid` int(11) NOT NULL,
  `level` varchar(45) DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_jobid` (`jobid`),
  KEY `idx_skillid` (`skillid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2352 ;

-- --------------------------------------------------------

--
-- Table structure for table `match_notification`
--

CREATE TABLE IF NOT EXISTS `match_notification` (
  `userid` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `match_notification`
--

INSERT INTO `match_notification` (`userid`, `status`, `date_modified`) VALUES
(2, 1, '2014-10-26 23:56:47'),
(2, 0, '2014-12-11 15:08:31'),
(2, 1, '2014-12-11 15:08:32'),
(2, 0, '2014-12-11 15:36:35'),
(2, 1, '2014-12-11 15:36:35'),
(2, 0, '2014-12-11 15:58:32'),
(2, 1, '2014-12-11 15:58:33');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FK_receiver` varchar(45) NOT NULL,
  `FK_sender` varchar(45) NOT NULL,
  `message` text,
  `date` datetime DEFAULT NULL,
  `been_read` int(11) DEFAULT NULL,
  `been_deleted` int(11) NOT NULL DEFAULT '0',
  `sender_deleted` int(11) NOT NULL DEFAULT '0',
  `subject` varchar(255) DEFAULT NULL,
  `userImage` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_FK_receiver` (`FK_receiver`),
  KEY `idx_FK_sender` (`FK_sender`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `datetime` time NOT NULL,
  `been_read` int(11) NOT NULL,
  `message` varchar(5000) DEFAULT NULL,
  `link` varchar(150) DEFAULT NULL,
  `importancy` int(11) NOT NULL,
  `msgID` int(11) DEFAULT NULL,
  `jobMatchID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1009 ;

-- --------------------------------------------------------

--
-- Table structure for table `resume`
--

CREATE TABLE IF NOT EXISTS `resume` (
  `id` int(11) NOT NULL,
  `resume` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `resume`
--

INSERT INTO `resume` (`id`, `resume`) VALUES
(55, '/JobFair/resumes/55-Rogelio Alonso Resume.pdf'),
(60, '/JobFair/resumes/60-Student.pdf'),
(71, '/JobFair/resumes/71-StudentResume.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `saved_queries`
--

CREATE TABLE IF NOT EXISTS `saved_queries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FK_userid` int(11) NOT NULL,
  `query_tag` varchar(25) NOT NULL,
  `query` text NOT NULL,
  `location` varchar(25) DEFAULT '',
  `active` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_userid` (`FK_userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

--
-- Dumping data for table `saved_queries`
--

INSERT INTO `saved_queries` (`id`, `FK_userid`, `query_tag`, `query`, `location`, `active`) VALUES
(6, 5, 'hello', '+java ', '', 0),
(7, 9, 'thequery', '+java ', '', 0),
(21, 12, '', '~skills:Javascript +php +iPhone Application Development ', '', 0),
(25, 12, '', '~position:Application Support Specialist ', '', 0),
(27, 12, '', '~experience:Manage ', '', 0),
(28, 12, '', '~skills:java ~school:Florida International University ~graduation:2014-10 ', '', 0),
(29, 12, '', '~ZIPcode:true ~major:Computer Science ', '', 0),
(31, 12, '', '~school:Florida International University ', '', 0),
(50, 24, 'Java', '+Java ', '', 0),
(51, 24, 'PHP', '+PHP ', '', 0),
(52, 26, 'JavaWeb', 'Java + Web ', 'Miami, Florida', 0),
(53, 23, 'JavaWeb', 'Java + Web ', 'Miami, Florida', 0);

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE IF NOT EXISTS `school` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email_string` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `school`
--

INSERT INTO `school` (`id`, `name`, `email_string`) VALUES
(1, 'Florida International University', NULL),
(2, 'Miami-Dade College', NULL),
(3, 'Harvard', NULL),
(4, 'Miami Dade', NULL),
(5, 'Stanford University', NULL),
(6, 'Hardvard', NULL),
(7, 'University of Kansas', NULL),
(8, 'University of Utah', NULL),
(9, 'University of Oregon', NULL),
(10, 'Pearson VUE Testing Center', NULL),
(11, 'FIU', NULL),
(12, 'Michigan State University', NULL),
(13, 'University of Tehran', NULL),
(14, 'h', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `skillset`
--

CREATE TABLE IF NOT EXISTS `skillset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `FK_general_skills` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=126 ;

--
-- Dumping data for table `skillset`
--

INSERT INTO `skillset` (`id`, `name`, `FK_general_skills`) VALUES
(1, 'Java', 1),
(2, 'SQL', 4),
(3, 'PHP', 2),
(6, 'High Availability', 1),
(7, 'Windows', 1),
(8, 'HTML', 2),
(9, 'OS X', 1),
(10, 'Team Leadership', 1),
(11, 'Customer Service', 1),
(12, 'Microsoft Office', 1),
(13, 'Customer Satisfaction', 1),
(14, 'MySQL', 4),
(15, 'PL/SQL', 4),
(16, 'JavaScript', 2),
(17, 'CSS', 2),
(18, 'Web Page Automation', 2),
(19, 'Selenium', 5),
(20, 'Linux', 1),
(21, 'PostgreSQL', 4),
(24, 'Unix', 1),
(25, 'AJAX', 2),
(27, 'jQuery', 2),
(28, 'MVC', 1),
(29, 'Web Development', 2),
(30, 'Yii', 2),
(31, 'Wordpress', 2),
(32, 'Android Development', 3),
(33, 'C', 1),
(34, 'LAMP', 2),
(36, 'Database Design', 4),
(37, 'Relational Databases', 4),
(38, 'JSP', 2),
(39, 'Objective-C', 1),
(40, 'iPhone Application Development', 3),
(41, 'iOS Development', 1),
(42, 'Microsoft Excel', 1),
(43, 'Microsoft Word', 1),
(44, 'PowerPoint', 1),
(45, 'Research', 1),
(46, 'Photoshop', 1),
(47, 'Social Media', 1),
(48, 'Teamwork', 1),
(49, 'Public Speaking', 1),
(50, 'C++', 1),
(51, 'Ruby on Rails', 1),
(52, 'c socket programing', 1),
(53, 'F#', 1),
(54, 'Programming', 1),
(55, 'Managing Database', 4),
(56, 'Linux Kernel', 1),
(57, 'Software Engineering', 1),
(58, '', 1),
(59, 'Software Development', 1),
(60, 'Microsoft Visual Studio C++', 1),
(61, 'Microsoft SQL Server', 4),
(62, 'NetBeans', 1),
(63, 'Android SDK', 3),
(64, 'XML', 2),
(65, 'Maven', 1),
(66, 'JUnit', 5),
(67, 'F', 0),
(68, 'Recording', 0),
(69, 'Bootstrap', 0),
(70, 'Apache', 0),
(71, 'HTML5', 0),
(72, 'PhpMyAdmin', 0),
(73, 'ESB', 0),
(74, 'BizTalk', 0),
(75, 'Web Services', 0),
(76, 'REST', 0),
(77, 'SOAP', 0),
(80, 'Skill A', 0),
(81, 'XPATH', 0),
(82, 'ORACLE', 0),
(83, 'Hadoop', 0),
(84, 'Computer Science', 0),
(85, 'Communications Audits', 0),
(86, 'Academic Writing', 0),
(87, 'Machine Learning', 0),
(88, 'Algorithms', 0),
(89, 'R', 0),
(90, 'Distributed Systems', 0),
(91, 'LaTeX', 0),
(92, 'Simulations', 0),
(93, 'Parallel Computing', 0),
(94, 'Databases', 0),
(95, 'MPI', 0),
(96, 'Data Mining', 0),
(97, 'High Performance Computing', 0),
(98, 'Parallel Programming', 0),
(99, 'Python', 0),
(100, 'Pattern Recognition', 0),
(101, 'Perl', 0),
(102, 'Image Processing', 0),
(103, 'Computer Architecture', 0),
(104, 'Mathematical Modeling', 0),
(105, 'Signal Processing', 0),
(106, 'Matlab', 0),
(107, 'Artificial Intelligence', 0),
(108, 'Scientific Computing', 0),
(109, 'Fortran', 0),
(110, 'Optimization', 0),
(111, 'Mathematica', 0),
(112, 'Numerical Analysis', 0),
(113, 'Computer Vision', 0),
(114, 'Wireless Sensor Networks', 0),
(115, 'Information Retrieval', 0),
(116, 'Statistics', 0),
(117, 'Theory', 0),
(118, 'University Teaching', 0),
(119, 'Eclipse', 0),
(120, 'Simulink', 0),
(121, 'Bash', 0),
(122, 'Bioinformatics', 0),
(123, 'C#', 0),
(124, 'Design Patterns', 0),
(125, 'Testing', 0);

-- --------------------------------------------------------

--
-- Table structure for table `SMS`
--

CREATE TABLE IF NOT EXISTS `SMS` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `receiver_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `Message` text,
  PRIMARY KEY (`id`),
  KEY `idx_receiver_id` (`receiver_id`),
  KEY `idx_sender_id` (`sender_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `solr`
--
CREATE TABLE IF NOT EXISTS `solr` (
`id` varchar(22)
,`username` varchar(45)
,`email` varchar(45)
,`registration_date` datetime
,`first_name` varchar(45)
,`last_name` varchar(45)
,`image_url` varchar(255)
,`type` varchar(45)
,`title` varchar(45)
,`post_date` datetime
,`deadline` datetime
,`description` longtext
,`compensation` varchar(45)
,`other_requirements` text
,`email_notification` int(11)
,`matches_found` int(11)
,`posting_url` text
,`comp_name` varchar(255)
,`poster_email` varchar(40)
);
-- --------------------------------------------------------

--
-- Table structure for table `student_skill_map`
--

CREATE TABLE IF NOT EXISTS `student_skill_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `skillid` int(11) DEFAULT NULL,
  `level` varchar(45) DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_skillid` (`skillid`),
  KEY `idx_userid` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=305 ;

--
-- Dumping data for table `student_skill_map`
--

INSERT INTO `student_skill_map` (`id`, `userid`, `skillid`, `level`, `ordering`) VALUES
(1, 5, 54, NULL, 1),
(2, 5, 55, NULL, 2),
(3, 5, 56, NULL, 3),
(4, 5, 57, NULL, 4),
(5, 5, 1, NULL, 5),
(6, 5, 16, NULL, 6),
(7, 5, 3, NULL, 7),
(8, 5, 8, NULL, 8),
(9, 5, 17, NULL, 9),
(10, 5, 53, NULL, 10),
(11, 5, 33, NULL, 11),
(12, 5, 14, NULL, 12),
(36, 14, 3, NULL, 1),
(37, 14, 16, NULL, 2),
(38, 14, 2, NULL, 3),
(39, 14, 56, NULL, 4),
(40, 14, 40, NULL, 5),
(41, 14, 32, NULL, 6),
(48, 17, 6, NULL, 1),
(49, 17, 27, NULL, 2),
(50, 17, 30, NULL, 3),
(52, 17, 13, NULL, 5),
(53, 9, 6, NULL, 1),
(54, 9, 18, NULL, 2),
(55, 9, 52, NULL, 3),
(56, 9, 49, NULL, 4),
(57, 9, 18, NULL, 5),
(58, 18, 2, NULL, 1),
(59, 18, 7, NULL, 2),
(60, 18, 12, NULL, 3),
(61, 18, 51, NULL, 4),
(62, 18, 33, NULL, 5),
(63, 18, 17, NULL, 6),
(64, 18, 39, NULL, 7),
(65, 18, 28, NULL, 8),
(66, 18, 49, NULL, 9),
(194, 26, 83, NULL, 1),
(195, 26, 84, NULL, 2),
(196, 26, 85, NULL, 3),
(197, 26, 86, NULL, 4),
(198, 26, 87, NULL, 5),
(199, 26, 88, NULL, 6),
(200, 26, 57, NULL, 7),
(201, 26, 20, NULL, 8),
(202, 26, 89, NULL, 9),
(203, 26, 90, NULL, 10),
(204, 26, 91, NULL, 11),
(205, 26, 3, NULL, 12),
(206, 26, 45, NULL, 13),
(207, 26, 1, NULL, 14),
(208, 26, 33, NULL, 15),
(209, 26, 92, NULL, 16),
(210, 26, 93, NULL, 17),
(211, 26, 94, NULL, 18),
(212, 26, 2, NULL, 19),
(213, 26, 95, NULL, 20),
(214, 26, 96, NULL, 21),
(215, 26, 97, NULL, 22),
(216, 26, 98, NULL, 23),
(217, 26, 50, NULL, 24),
(218, 26, 99, NULL, 25),
(219, 26, 100, NULL, 26),
(220, 26, 14, NULL, 27),
(221, 26, 54, NULL, 28),
(222, 26, 101, NULL, 29),
(223, 26, 102, NULL, 30),
(224, 26, 103, NULL, 31),
(225, 26, 104, NULL, 32),
(226, 26, 105, NULL, 33),
(227, 26, 106, NULL, 34),
(228, 26, 107, NULL, 35),
(229, 26, 108, NULL, 36),
(230, 26, 109, NULL, 37),
(231, 26, 110, NULL, 38),
(232, 26, 111, NULL, 39),
(233, 26, 112, NULL, 40),
(234, 26, 113, NULL, 41),
(235, 26, 114, NULL, 42),
(236, 26, 115, NULL, 43),
(237, 26, 116, NULL, 44),
(238, 26, 117, NULL, 45),
(239, 26, 118, NULL, 46),
(240, 26, 119, NULL, 47),
(241, 26, 120, NULL, 48),
(242, 26, 121, NULL, 49),
(243, 26, 122, NULL, 50),
(245, 55, 3, NULL, 1),
(246, 55, 1, NULL, 2),
(247, 55, 16, NULL, 3),
(248, 55, 27, NULL, 4),
(249, 55, 17, NULL, 5),
(250, 55, 69, NULL, 6),
(251, 55, 70, NULL, 7),
(252, 55, 62, NULL, 8),
(253, 55, 20, NULL, 9),
(254, 55, 14, NULL, 10),
(255, 55, 71, NULL, 11),
(256, 55, 8, NULL, 12),
(257, 55, 72, NULL, 13),
(258, 55, 29, NULL, 14),
(259, 55, 73, NULL, 15),
(260, 55, 74, NULL, 16),
(261, 55, 75, NULL, 17),
(262, 55, 76, NULL, 18),
(263, 55, 77, NULL, 19),
(264, 16, 8, NULL, 1),
(265, 16, 21, NULL, 2),
(266, 16, 11, NULL, 3),
(267, 16, 6, NULL, 4),
(268, 16, 10, NULL, 5),
(269, 16, 67, NULL, 6),
(270, 16, 3, NULL, 7),
(285, 15, 3, NULL, 1),
(286, 15, 53, NULL, 2),
(287, 15, 50, NULL, 3),
(288, 15, 30, NULL, 4),
(295, 76, 3, NULL, 1),
(296, 76, 30, NULL, 2),
(297, 76, 125, NULL, 3),
(298, 76, 1, NULL, 4),
(302, 71, 123, NULL, 1),
(303, 71, 57, NULL, 2),
(304, 71, 124, NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_migration`
--

CREATE TABLE IF NOT EXISTS `tbl_migration` (
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_migration`
--

INSERT INTO `tbl_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1412113298),
('m140601_035609_initial', 1412113302),
('m140607_063219_create_match_notification_table', 1412113302),
('m140610_182901_careerpath_sync', 1412113302),
('m140617_034311_alter_user_table', 1412113302),
('m140622_223610_alter_user_table_add_column_looking_for_job', 1412113302),
('m140624_000947_fiu_account_id', 1412113302),
('m140624_020245_company_name_column', 1412113303),
('m140701_040841_api_status', 1412113303),
('m140707_183328_alter_user_table_job_interest', 1412113303),
('m140714_221600_create_table_saved_queries', 1412113303),
('m140721_070311_api_auth_description', 1412113303);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `FK_usertype` int(11) NOT NULL,
  `email` varchar(45) NOT NULL,
  `registration_date` datetime DEFAULT NULL,
  `activation_string` varchar(45) DEFAULT NULL,
  `activated` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `disable` int(11) NOT NULL DEFAULT '0',
  `has_viewed_profile` int(11) DEFAULT NULL,
  `linkedinid` varchar(45) DEFAULT NULL,
  `googleid` varchar(45) DEFAULT NULL,
  `fiucsid` varchar(45) DEFAULT NULL,
  `hide_email` int(11) DEFAULT NULL,
  `job_notification` tinyint(1) NOT NULL DEFAULT '1',
  `fiu_account_id` varchar(45) DEFAULT NULL,
  `looking_for_job` tinyint(1) NOT NULL DEFAULT '1',
  `job_int_date` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_FK_usertype` (`FK_usertype`),
  KEY `idx_FK_username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=85 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `FK_usertype`, `email`, `registration_date`, `activation_string`, `activated`, `image_url`, `first_name`, `last_name`, `disable`, `has_viewed_profile`, `linkedinid`, `googleid`, `fiucsid`, `hide_email`, `job_notification`, `fiu_account_id`, `looking_for_job`, `job_int_date`) VALUES
(2, 'admin', '$2a$08$UovPrdGi/NfiYryxCAbEAeS3XvScYmkEx51QeTxNE6N2tXm7HWwBq', 3, 'admin@mail.com', '2014-06-10 06:57:27', '', 1, '/JobFair/images/profileimages/user-default.png', 'Admin', 'Admin', 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0),
(5, 'earen003@fiu.edu', '$2a$08$.wTFdqjfaVSAekwumRTumOHdMmMcaantOW2SVefl8Od1gCgOTmA/u', 1, 'earen003123@fiu.edu', '2014-10-04 15:37:55', 'google', 1, 'https://media.licdn.com/mpr/mprx/0_Gj0mWYPz0DWq_3q5iYr8oxrMUpvN6Cq5iaTi70GUveqBC_QITDYCDzvdlhm', 'Erick', 'Arenas', 0, 1, 'DywORbIHTc', '107193070609153671555', NULL, NULL, 1, NULL, 1, 5),
(8, 'test_cis_fiu_edu', '$2a$08$0L3h//kusVHOdsX1.63B5.eZsXumUFCzudt1EVJCEGFTowlIyRIIG', 2, 'test@cis.fiu.edu', '2014-10-11 20:36:39', NULL, 1, '/JobFair/images/profileimages/user-default.png', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0),
(9, 'student8', '$2a$08$lc0rNoh.imE0DMCJPjqyGObn3m4ztqECqE2kKbmBgkX9oudrg0dHi', 1, 'arenaserick123@yahoo.com', '2014-11-06 13:30:00', '3vlsgjawyq', 1, '/JobFair/images/profileimages/user-default.png', 'erickkk', 'arenass', 0, 1, NULL, NULL, NULL, NULL, 1, NULL, 1, 5),
(11, 'nmad43', '$2a$08$41tQbGBVPNnLRY5pQxUicOqtmLy2t/SqbMuzJ4z7DAHdt3QfJtosK', 2, 'nmada002@fiu.edu', '2014-11-13 13:10:32', 'vihzwtsplq', NULL, '/JobFair/images/profileimages/user-default.png', 'Nicholas', 'Madariaga', 0, NULL, NULL, NULL, NULL, 1, 1, NULL, 1, 0),
(12, 'employer10', '$2a$08$oLylkwLN2eMvx.B9AtLVhu4dSoLvAvVc7oWTSTGhKt2pDlZY8uBB.', 2, 'employertwo@mail.com', '2014-11-23 17:33:16', '5qjanjsv5n', 1, '/JobFair/images/profileimages/user-default.png', 'emp', 'two', 0, NULL, NULL, NULL, NULL, 0, 0, NULL, 1, 5),
(14, 'student3', '$2a$08$oPt5manAQUtYPPwKBzEtW.Bjn4OXGYJvHqSfoLQ1neU4xn3sNcy5e', 1, 'student3@mail.com', '2014-12-08 12:10:29', '0dm6r4sm8x', 1, '/JobFair/images/profileimages/user-default.png', 'student', 'three', 0, 1, NULL, NULL, NULL, NULL, 1, NULL, 1, 0),
(15, 'student4', '$2a$08$CdHaBhoQniFWjXQxIztgX.BGeH0m2ApEjd4U.Hl11P9EUHtZi9c/i', 1, 'student4@mail.com', '2014-12-08 12:10:56', 'civrojoyt8', 1, '/JobFair/images/profileimages/student4avatar.jpg', 'student', 'four', 0, 1, NULL, NULL, NULL, NULL, 1, NULL, 1, 0),
(16, 'student5', '$2a$08$1RtOrIfXEZFZEKF72IaKOewYIZodUdPaR7.uvjJ6ijwM3L6gv96nu', 1, 'student5@mail.com', '2014-12-08 12:11:33', 'yjupo61fkh', 1, '/JobFair/images/profileimages/user-default.png', 'student', 'five', 0, 1, NULL, NULL, NULL, NULL, 1, NULL, 1, 0),
(17, 'student6', '$2a$08$IMOemea88AkVFg9DyR8Luuh7LQ1Z7GV1T7x3iSr.ad6piQanEeq66', 1, 'student6@mail.com', '2014-12-08 12:11:54', 's85trcxv1p', 1, '/JobFair/images/profileimages/user-default.png', 'student', 'six', 0, 1, NULL, NULL, NULL, NULL, 1, NULL, 1, 0),
(18, 'student7', '$2a$08$5Q1dX6zQSfwlfsEINQx9WeuwMxLKIfQE3SPQOmR80TSWNYvac27CS', 1, 'student7@mail.com', '2014-12-08 12:12:27', '7kai06xc65', 1, '/JobFair/images/profileimages/user-default.png', 'student', 'seven', 0, 1, NULL, NULL, NULL, NULL, 1, NULL, 1, 0),
(19, 'student10', '$2a$08$vwEAweAqJJMnewbed.YVZOycFb4nvS9UdRGcWYcwPfg1RTE8dp2aG', 1, 'student10@mail.com', '2014-12-11 10:06:13', 'bosv3vqir3', NULL, '/JobFair/images/profileimages/user-default.png', 'student', 'ten', 0, NULL, NULL, NULL, NULL, 0, 1, NULL, 1, 0),
(22, 'jtrav029@fiu.edu', '$2a$08$igvNQYv.yFI.3JrqELQXte2srqEr0sytDBPrfaNLQpkSRZCO/G9di', 1, 'jtrav029@fiu.edu', '2015-02-01 04:43:13', 'fiu', 1, 'https://lh3.googleusercontent.com/-xjXKxJLmagc/AAAAAAAAAAI/AAAAAAAAACI/8JbHCPrKBYM/photo.jpg', 'Jorge', 'Travieso', 0, NULL, NULL, NULL, NULL, NULL, 1, '116231147857551021368', 1, 0),
(23, 'Guest', '$2a$08$8PspUXq1ggIuTn8.92.qG.rbCwv55mh9irvpfrQY2JiWy4r44k6Pe', 4, 'gueststudent@cs.fiu.edu', '2015-02-07 16:51:19', 'h6c5hy7r70', 1, '/JobFair/images/profileimages/user-default.png', 'Guest', 'Account', 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0),
(24, 'GuestEmployer', '$2a$08$gWRjrpq9Xsd.XJmuWWc9.Ot/S/iP3MkrcyYewl7BXaknLNQupxKA6', 5, 'guestemployer@cs.fiu.edu', '2015-02-05 22:47:06', 'yekce5xo6s', 1, '/JobFair/images/profileimages/user-default.png', 'Guest', 'Employer', 0, NULL, NULL, NULL, NULL, 1, 1, NULL, 1, 2),
(26, 'sadjadis@gmail.com', '$2a$08$czIQv8g6mh2xH/m/UlpPFOfJv1ksBHaFA4XIe1XgEcGtZ3/HvYy4W', 1, 'sadjadi@cs.fiu.edu', '2015-02-18 09:19:11', 'google', 1, 'https://lh3.googleusercontent.com/-QnmiMU0SQEQ/AAAAAAAAAAI/AAAAAAAAMtw/6TS6oscVgj8/photo.jpg', 'Masoud', 'Sadjadi', 0, 1, '-q_utmm44e', '110291442056614091691', NULL, NULL, 1, NULL, 1, 0),
(55, 'RogerSTU', '$2a$08$NG1FTRUINW7fwsajTe06/eGjJ9uvKLIJAFGoUEMq78TJkrkXlX50m', 1, 'ralon038@fiu.edu', '2015-03-03 00:07:12', 'srxnpcjlcz', 1, '/JobFair/images/profileimages/RogerSTUavatar.JPG', 'Rogelio', 'Alonso', 0, 1, NULL, NULL, NULL, NULL, 1, NULL, 1, 0),
(56, 'testemployer', '$2a$08$A0EViiZBj42D2UfBAhMxyOXy/BxulKDLuQR3HntZfkt9P/3XO32sC', 2, 'sadjadi@cis.fiu.edu', '2015-03-04 12:05:40', 'nt0tjgeiv3', 1, '/JobFair/images/profileimages/user-default.png', 'Test', 'Employer', 0, NULL, NULL, NULL, NULL, 0, 1, NULL, 1, 0),
(57, 'testemployer1', '$2a$08$dGfD0MmHskr6esTPXYx1m.w2L0p1f0U48UGWwP8bITiYoeZMEY4Ey', 2, 'sadjadi@fiu.edu', '2015-03-04 12:08:41', '2qxr3xbbb4', 1, '/JobFair/images/profileimages/user-default.png', 'Test', 'Employer', 0, NULL, NULL, NULL, NULL, 0, 1, NULL, 1, 0),
(60, 'RogerStuTest1', '$2a$08$xRtI.tW7PieXx/zuVdKVhOMlmNZ2FfQhtozopEJdgE0trTT6t/rJ.', 1, 'rog.stu.001@gmail.com', '2015-03-04 12:18:09', 'la4k5nqbbv', 1, '/JobFair/images/profileimages/RogerStuTest1avatar.JPG', 'RogerTest', 'StudentTest', 0, 1, NULL, NULL, NULL, NULL, 1, NULL, 1, 0),
(61, 'RogerEmpTest', '$2a$08$7JQwicSIr3u9kl.IwlZ.X.DWboOqTvuNLbe6VqsoyH/xUlUPLwDAy', 2, 'rog.emp.001@gmail.com', '2015-03-04 12:18:17', 'hgk9neax66', 1, '/JobFair/images/profileimages/user-default.png', 'RogerTest', 'EmployerTest', 0, NULL, NULL, NULL, NULL, 0, 1, NULL, 1, 0),
(63, 'hgutierrez.jobs@gmail.com', '$2a$08$HYwdV8.ws5pUCgnL0RUh0ONXun0Km2gH5ihMMsreTW6rKps8972OK', 1, 'hgutierrez.jobs@gmail.com', '2015-04-06 23:27:15', 'google', 1, 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg', 'Heidy', 'Gutierrez', 0, NULL, NULL, '105478010618083573451', NULL, NULL, 1, NULL, 1, 0),
(71, 'ralfo028', '$2a$08$3A7HpQcR8uNaCtbY7ERp..TLmrXBqgtOXOVUpcifnZyZyhJy5cbfW', 1, 'renefakeemail@mail.com', '2015-06-12 00:28:58', '0mztifdaxz', 1, '/JobFair/images/profileimages/ralfo028avatar.jpg', 'Rene', 'Alfonso', 0, 1, NULL, NULL, NULL, NULL, 1, NULL, 1, 1),
(72, 'student15', '$2a$08$XoClsAqz7SUAWGP70Ho2yu9dlls6dIs41e45jkZ3yk5EX0FJZVREe', 1, 'student15@mail.com', '2015-06-12 00:38:37', '70luwuk0hc', NULL, '/JobFair/images/profileimages/user-default.png', 'Student', 'Fifteen', 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0),
(73, 'newstudent', '$2a$08$3AEZmYlRVVrVmxYSC5QQ1u8G8Hj8R9DnSipD3byrm5tB4YiJNXM52', 1, 'newstu@mail.com', '2015-06-12 01:10:56', '0fnx8phdcs', 0, '/JobFair/images/profileimages/user-default.png', 'NewStudent', 'DeleteMe', 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0),
(74, 'android', '$2a$08$HcWWf.a.A81YQwmrwlCb4eUsl/Vyn9vXIKAN/AD1KaXtq/g/QywDK', 2, 'androidfake@mail.com', '2015-06-12 04:54:18', '54d847sv48', 1, '/JobFair/images/profileimages/androidavatar.png', 'Android', 'Employer', 0, NULL, NULL, NULL, NULL, 1, 1, NULL, 1, 1),
(75, 'vjftester', '$2a$08$7jh2RaCJTSthoO4EGcSTeeRo.ZEip.zupEyAwdxbbb78FV.utFweK', 1, 'vjftester@gmail.com', '2015-06-12 19:48:33', 'jtcah42uk6', 1, '/JobFair/images/profileimages/user-default.png', 'Virtual', 'Tester', 0, 1, NULL, NULL, NULL, NULL, 1, NULL, 1, 0),
(76, 'ralon039@fiu.edu', '$2a$08$7jh2RaCJTSthoO4EGcSTeeRo.ZEip.zupEyAwdxbbb78FV.utFweK', 1, 'ralon039@fiu.edu', '2015-06-16 11:08:31', 'google', 1, 'https://lh3.googleusercontent.com/-Zq5RD96xaCU/AAAAAAAAAAI/AAAAAAAAAJM/JCnXPK3VeUo/photo.jpg', 'Rogelio', 'Alonso', 0, 1, NULL, '111259815576282894477', NULL, NULL, 1, NULL, 1, 0),
(82, 'RFakeEmp', '$2a$08$zTJMPu8y7j2F4YWpQDj16uIVzAwKp/NKiHPU9jHf.Prs8AdGPCd1S', 2, 'RFakeEmployer@gmail.com', '2015-06-19 20:13:22', 'w5q1wn0jr2', NULL, '/JobFair/images/profileimages/user-default.png', 'Employer', 'REmpLast', 0, NULL, NULL, NULL, NULL, 1, 1, NULL, 1, 0),
(83, 'NotificationStudent', '$2a$08$9RZ4H8eHYwI6YHWYdZCpI.uh.UQZgiedewvuUkofaAv0wPyMakZMa', 1, 'ofake@gmail.com', '2015-06-20 22:12:02', '73u6idruvh', 1, '/JobFair/images/profileimages/user-default.png', 'NotificationStudent', 'Student', 0, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0),
(84, 'testEmpDelete', '$2a$08$uCS0z3drTyCPAtl0kIj/VemhoR/GC3GU9c1I8wy2QOKnNuOOrsD.q', 2, 'fd@mail.com', '2015-06-30 21:52:06', '3qi0nil8ar', NULL, '/JobFair/images/profileimages/user-default.png', 'Rene', 'Lasr', 0, NULL, NULL, NULL, NULL, 1, 1, NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `usertype`
--

CREATE TABLE IF NOT EXISTS `usertype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `usertype`
--

INSERT INTO `usertype` (`id`, `type`) VALUES
(1, 'Student'),
(2, 'Employer'),
(3, 'admin'),
(4, 'Guest_Student'),
(5, 'Guest_Employer');

-- --------------------------------------------------------

--
-- Table structure for table `user_document`
--

CREATE TABLE IF NOT EXISTS `user_document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active_status` tinyint(1) NOT NULL,
  `document_id` varchar(256) NOT NULL,
  `local_user_id` int(11) NOT NULL,
  `remote_user_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `document_path` varchar(256) NOT NULL,
  `document_name` varchar(256) NOT NULL,
  `owner_url` varchar(256) NOT NULL,
  `viewer_url` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `video_interview`
--

CREATE TABLE IF NOT EXISTS `video_interview` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FK_employer` int(11) NOT NULL,
  `FK_student` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `session_key` varchar(45) NOT NULL,
  `notification_id` varchar(45) NOT NULL,
  `ScreenShareView` varchar(90) NOT NULL,
  `sharingscreen` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `video_interview`
--

INSERT INTO `video_interview` (`id`, `FK_employer`, `FK_student`, `date`, `time`, `session_key`, `notification_id`, `ScreenShareView`, `sharingscreen`) VALUES
(1, 3, 7, '2014-10-08', '01:50:00', '1VJFID7010597', '14', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `video_resume`
--

CREATE TABLE IF NOT EXISTS `video_resume` (
  `id` int(11) NOT NULL,
  `video_path` varchar(100) DEFAULT NULL,
  `publish_video` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `video_resume`
--

INSERT INTO `video_resume` (`id`, `video_path`, `publish_video`) VALUES
(71, 'YtV9zNqi_t0', 1),
(75, '7UKXmUPwa7w', 0);

-- --------------------------------------------------------

--
-- Table structure for table `whiteboard_sessions`
--

CREATE TABLE IF NOT EXISTS `whiteboard_sessions` (
  `user1` varchar(15) DEFAULT NULL,
  `user2` varchar(15) DEFAULT NULL,
  `interview_id` varchar(20) DEFAULT NULL,
  `image_name` varchar(50) DEFAULT 'none',
  `tmpstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure for view `solr`
--
DROP TABLE IF EXISTS `solr`;

CREATE ALGORITHM=UNDEFINED DEFINER=`vjfuser`@`localhost` SQL SECURITY DEFINER VIEW `solr` AS select concat(`user`.`id`,`job`.`id`) AS `id`,`user`.`username` AS `username`,`user`.`email` AS `email`,`user`.`registration_date` AS `registration_date`,`user`.`first_name` AS `first_name`,`user`.`last_name` AS `last_name`,`user`.`image_url` AS `image_url`,`job`.`type` AS `type`,`job`.`title` AS `title`,`job`.`post_date` AS `post_date`,`job`.`deadline` AS `deadline`,`job`.`description` AS `description`,`job`.`compensation` AS `compensation`,`job`.`other_requirements` AS `other_requirements`,`job`.`email_notification` AS `email_notification`,`job`.`matches_found` AS `matches_found`,`job`.`posting_url` AS `posting_url`,`job`.`comp_name` AS `comp_name`,`job`.`poster_email` AS `poster_email` from (`user` join `job`) where (`user`.`id` = `job`.`FK_poster`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `application`
--
ALTER TABLE `application`
  ADD CONSTRAINT `fk_application_job_jobid` FOREIGN KEY (`jobid`) REFERENCES `job` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_application_user_userid` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `basic_info`
--
ALTER TABLE `basic_info`
  ADD CONSTRAINT `fk_basic_info_user_userid` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `company_info`
--
ALTER TABLE `company_info`
  ADD CONSTRAINT `fk_company_info_user_FK_userid` FOREIGN KEY (`FK_userid`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `education`
--
ALTER TABLE `education`
  ADD CONSTRAINT `fk_education_school_FK_school_id` FOREIGN KEY (`FK_school_id`) REFERENCES `school` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_education_user_FK_user_id` FOREIGN KEY (`FK_user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `experience`
--
ALTER TABLE `experience`
  ADD CONSTRAINT `fk_experience_user_FK_userid` FOREIGN KEY (`FK_userid`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `handshake`
--
ALTER TABLE `handshake`
  ADD CONSTRAINT `fk_handshake_job_jobid` FOREIGN KEY (`jobid`) REFERENCES `job` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_handshake_user_employerid` FOREIGN KEY (`employerid`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_handshake_user_studentid` FOREIGN KEY (`studentid`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `job`
--
ALTER TABLE `job`
  ADD CONSTRAINT `fk_job_user_FK_poster` FOREIGN KEY (`FK_poster`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `job_skill_map`
--
ALTER TABLE `job_skill_map`
  ADD CONSTRAINT `fk_job_skill_map_job_jobid` FOREIGN KEY (`jobid`) REFERENCES `job` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_job_skill_map_skillset_skillid` FOREIGN KEY (`skillid`) REFERENCES `skillset` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk_message_user_FK_receiver` FOREIGN KEY (`FK_receiver`) REFERENCES `user` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_message_user_FK_sender` FOREIGN KEY (`FK_sender`) REFERENCES `user` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `saved_queries`
--
ALTER TABLE `saved_queries`
  ADD CONSTRAINT `saved_queries_ibfk_1` FOREIGN KEY (`FK_userid`) REFERENCES `user` (`id`);

--
-- Constraints for table `SMS`
--
ALTER TABLE `SMS`
  ADD CONSTRAINT `fk_SMS_user_receiver_id` FOREIGN KEY (`receiver_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_SMS_user_sender_id` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `student_skill_map`
--
ALTER TABLE `student_skill_map`
  ADD CONSTRAINT `fk_student_skill_map_skillset_skillid` FOREIGN KEY (`skillid`) REFERENCES `skillset` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_student_skill_map_user_userid` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_usertype_FK_usertype` FOREIGN KEY (`FK_usertype`) REFERENCES `usertype` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
