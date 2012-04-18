-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 18, 2012 at 03:27 PM
-- Server version: 5.1.44
-- PHP Version: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rabbit`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `is_venue` tinyint(4) NOT NULL,
  `address_type` varchar(50) NOT NULL,
  `address_1` varchar(100) DEFAULT NULL,
  `address_2` varchar(100) DEFAULT NULL,
  `postcode` varchar(10) NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_address_user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `address`
--

INSERT INTO `address` VALUES(1, 1, 0, '', '23 QUEENS COURT, BARRACK ROAD', 'NEWCASTLE UPON TYNE', 'NE4 6BJ', 54.9759321700125, -1.62853858465576);

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `ci_sessions`
--


-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `u1_id` int(11) NOT NULL,
  `u2_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `befriended` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_user1_id` (`u1_id`),
  KEY `FK_user2_id` (`u2_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` VALUES(1, 1, 2, 'friend', '2012-01-28');
INSERT INTO `friends` VALUES(3, 2, 1, 'friend', '2012-02-08');
INSERT INTO `friends` VALUES(58, 3, 1, 'friend', '2012-03-30');
INSERT INTO `friends` VALUES(59, 1, 3, 'friend', '2012-03-30');
INSERT INTO `friends` VALUES(61, 1, 4, 'requested', '0000-00-00');
INSERT INTO `friends` VALUES(62, 1, 5, 'requested', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `gallery`
--


-- --------------------------------------------------------

--
-- Table structure for table `gallery_image`
--

CREATE TABLE `gallery_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `gallery_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_gallery_id` (`gallery_id`),
  KEY `FK_image_id` (`image_id`),
  KEY `FK_user_image_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `gallery_image`
--


-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) NOT NULL,
  `formed_date` date NOT NULL,
  `mission_statement` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `group`
--


-- --------------------------------------------------------

--
-- Table structure for table `group_users`
--

CREATE TABLE `group_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_admin` char(1) NOT NULL,
  `join_date` date NOT NULL,
  `is_creator` char(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_group_users_user_id` (`user_id`),
  KEY `FK_group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `group_users`
--


-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `alt` varchar(255) DEFAULT NULL,
  `thumb_path` varchar(255) NOT NULL,
  `large_path` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_image_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `image`
--


-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) COLLATE utf8_bin NOT NULL,
  `login` varchar(50) COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Dumping data for table `login_attempts`
--


-- --------------------------------------------------------

--
-- Table structure for table `role_types`
--

CREATE TABLE `role_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `role_types`
--

INSERT INTO `role_types` VALUES(1, 'Oils');
INSERT INTO `role_types` VALUES(3, 'Acrylics');
INSERT INTO `role_types` VALUES(4, 'Watercolours');
INSERT INTO `role_types` VALUES(5, 'Sculpting');
INSERT INTO `role_types` VALUES(6, 'Mixed media');
INSERT INTO `role_types` VALUES(7, 'Venue owner');

-- --------------------------------------------------------

--
-- Table structure for table `timeline`
--

CREATE TABLE `timeline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `table` varchar(100) DEFAULT NULL,
  `record_id` int(11) DEFAULT NULL,
  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `timeline`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `new_password_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `new_email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `new_email_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=7 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` VALUES(1, 'roppa_uk', '$2a$08$vSOeF4KmPaXh/sTV6B9Ay.OAtMwn/4Rxci3PQHr6CNzi4wYcDJm3G', 'roppa_uk@hotmail.com', 1, 0, NULL, NULL, NULL, NULL, 'a5991f5072eaa2569d015d796cad4f6f', '127.0.0.1', '2012-04-18 15:10:41', '2012-01-21 13:34:48', '2012-04-18 15:10:41');
INSERT INTO `users` VALUES(2, 'sompfrog', '$2a$08$xxAl6ZwZGAMkeO2KLBcpHO3PVpIDULTm7b6w/Gc8pCOPjjP0YLslK', 'chrisbewick@gmail.com', 1, 0, NULL, NULL, NULL, NULL, '700c92cfe378fdd91ef7b89fdb3a2d03', '127.0.0.1', '0000-00-00 00:00:00', '2012-01-28 10:12:30', '2012-01-28 10:12:59');
INSERT INTO `users` VALUES(3, 'neslisever', '$2a$08$lL2NJTtvb4N1HICUOsDDgOpMDchwSmD5HthcFozB1xburUlG9.WFW', 'neslisever@yahoo.com', 1, 0, NULL, NULL, NULL, NULL, 'a629e15716b12a16846e1416c5fd7453', '127.0.0.1', '2012-01-28 23:02:47', '2012-01-28 14:33:48', '2012-01-28 23:02:47');
INSERT INTO `users` VALUES(4, 'joch', '$2a$08$.QkhtqleQeoibY0NmVKyr.2L4f44k/kP9A4u0sbRRfQq68FZV56YO', 'joch@talktalk.net', 1, 0, NULL, NULL, NULL, NULL, '9a84fd9df2da3d9b71729212fb0f9a76', '127.0.0.1', '2012-03-31 18:38:45', '2012-02-10 20:59:22', '2012-03-31 18:38:45');
INSERT INTO `users` VALUES(5, 'maribell64', '$2a$08$vbejdYwcB12ALKiPsSaPKeTNI/AsXboX.310lJx.SoHh3l9uBTofm', 'maribell_vargas7@hotmail.com', 1, 0, NULL, NULL, NULL, NULL, '4cd08f03e2527ac592a2d1a047420711', '127.0.0.1', '2012-04-17 11:37:08', '2012-04-06 17:59:23', '2012-04-17 11:37:08');

-- --------------------------------------------------------

--
-- Table structure for table `user_autologin`
--

CREATE TABLE `user_autologin` (
  `key_id` char(32) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `user_autologin`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `user_id` int(11) NOT NULL,
  `website` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `first_name` varchar(10) COLLATE utf8_bin NOT NULL,
  `last_name` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `avatar_filename` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `sex` char(1) COLLATE utf8_bin DEFAULT NULL,
  `about_me` text COLLATE utf8_bin,
  `lat` double DEFAULT NULL,
  `lon` double DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `FK_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` VALUES(1, 'http://www.whiteforest.co.uk', 'Mark', 'Robson', NULL, 'Painting a pretty picture', 'm', 0x486572652069732061206c6974746c65206269742061626f7574206d652e20416e6420736f6d65206d6f72652061626f7574206d652e207465737420746573742074657374, 54.3272532765991, -3.73821410000005);
INSERT INTO `user_profiles` VALUES(2, 'http://chrisbewick.com/blog/', 'Chris', 'Bewick', NULL, 'Creativity', 'm', 0x486572652069732061206c6974746c65206269742061626f7574206d652e20416e6420736f6d65206d6f72652061626f7574206d652e, 49.4511846, -2.5695965);
INSERT INTO `user_profiles` VALUES(3, 'http://www.neslihansever.com/', 'Nesli', 'Sever', NULL, 'Kurdish art', 'f', 0x416476656e747572657320696e746f204b757264697368206172742e, 51.2703785915549, 1.07603845454071);
INSERT INTO `user_profiles` VALUES(4, 'http://www.google.co.uk', 'Joachim', 'Sefzik', NULL, NULL, NULL, 0x746869732069732061626f7574206d65, 48.1903468, 1.02);
INSERT INTO `user_profiles` VALUES(5, 'http://www.google.co.uk', 'Maribel', 'Vargas', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_role_user_id` (`user_id`),
  KEY `FK_role_type_id` (`role_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` VALUES(1, 1, 3);
INSERT INTO `user_roles` VALUES(2, 1, 4);
INSERT INTO `user_roles` VALUES(3, 3, 3);
INSERT INTO `user_roles` VALUES(4, 3, 6);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `FK_address_user_id` FOREIGN KEY (`user_id`) REFERENCES `user_profiles` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `FK_user1_id` FOREIGN KEY (`u1_id`) REFERENCES `user_profiles` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_user2_id` FOREIGN KEY (`u2_id`) REFERENCES `user_profiles` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gallery_image`
--
ALTER TABLE `gallery_image`
  ADD CONSTRAINT `FK_gallery_id` FOREIGN KEY (`gallery_id`) REFERENCES `gallery` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_image_id` FOREIGN KEY (`image_id`) REFERENCES `image` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `group_users`
--
ALTER TABLE `group_users`
  ADD CONSTRAINT `FK_group_id` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_group_users_user_id` FOREIGN KEY (`user_id`) REFERENCES `user_profiles` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `FK_image_user_id` FOREIGN KEY (`user_id`) REFERENCES `user_profiles` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `FK_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `FK_role_type_id` FOREIGN KEY (`role_type_id`) REFERENCES `role_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_role_user_id` FOREIGN KEY (`user_id`) REFERENCES `user_profiles` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
