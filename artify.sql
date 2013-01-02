-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 23, 2012 at 02:46 AM
-- Server version: 5.1.44
-- PHP Version: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `artify`
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
  `city` varchar(255) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `country` varchar(50) NOT NULL,
  `lat` double NOT NULL,
  `lon` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_address_user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `address`
--

INSERT INTO `address` VALUES(5, 1, 0, '', '23 Queens Court', 'Barrack Road', 'Newcastle upon Tyne', 'NE4 6BJ', '', 55.2519418889556, -1.94053076875002);
INSERT INTO `address` VALUES(6, 1, 0, '1', '16 Richborne Terrace', 'London Borough of Lambeth', 'London', 'SW8 1AU', '', 51.4792222, -0.116817573016306);

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
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `events`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=119 ;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` VALUES(91, 1, 4, 'requested', '0000-00-00');
INSERT INTO `friends` VALUES(114, 2, 1, 'friend', '2012-12-16');
INSERT INTO `friends` VALUES(115, 1, 2, 'friend', '2012-12-16');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_gallery_user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` VALUES(1, 1, 'My First Gallery', 'This is my first artwork gallery test');
INSERT INTO `gallery` VALUES(3, 1, 'My First Gallery test test', 'wooooo hop you like these!');

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
  `created_date` datetime NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `group`
--

INSERT INTO `group` VALUES(10, 'ttttt', '2012-11-27 21:28:44', 'sdfgadf sdfg sfdgsdfgvs');
INSERT INTO `group` VALUES(16, 'chris''s group', '2012-12-16 17:36:46', 'test test test');
INSERT INTO `group` VALUES(17, 'marks new group', '2012-12-18 20:49:54', 'test test test');

-- --------------------------------------------------------

--
-- Table structure for table `group_users`
--

CREATE TABLE `group_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `join_date` date NOT NULL,
  `rights` char(1) NOT NULL DEFAULT '4',
  PRIMARY KEY (`id`),
  KEY `FK_group_users_user_id` (`user_id`),
  KEY `FK_group_id` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `group_users`
--

INSERT INTO `group_users` VALUES(12, 10, 1, '2012-11-27', '1');
INSERT INTO `group_users` VALUES(20, 10, 2, '2012-12-10', '3');
INSERT INTO `group_users` VALUES(21, 16, 2, '2012-12-16', '1');
INSERT INTO `group_users` VALUES(23, 16, 1, '2012-12-16', '4');
INSERT INTO `group_users` VALUES(24, 17, 1, '2012-12-18', '1');
INSERT INTO `group_users` VALUES(25, 17, 2, '2012-09-29', '4');

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `alt` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_image_user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `image`
--

INSERT INTO `image` VALUES(17, 1, 'Lollipop', '', '10411227245098445a283251.59367418.jpg', 'This is the first in the Little Girl series.', '2012-11-15 07:33:53');
INSERT INTO `image` VALUES(18, 1, 'Starry starry skyline', '', '1907461393509ac7157c33e6.44520053.jpg', 'This was my first ever painting!', '2012-11-15 07:28:43');
INSERT INTO `image` VALUES(19, 1, 'Weeping tree', '', '64257247050b7e7872e2158.24339244.jpg', 'Weeping tree', '2012-11-30 09:56:04');

-- --------------------------------------------------------

--
-- Table structure for table `interests`
--

CREATE TABLE `interests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `interests`
--

INSERT INTO `interests` VALUES(1, 'Oils');
INSERT INTO `interests` VALUES(3, 'Acrylics');
INSERT INTO `interests` VALUES(4, 'Watercolours');
INSERT INTO `interests` VALUES(5, 'Sculpting');
INSERT INTO `interests` VALUES(6, 'Mixed media');
INSERT INTO `interests` VALUES(7, 'Venue owner');
INSERT INTO `interests` VALUES(8, 'Curator');

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
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `date` datetime NOT NULL,
  `sender_id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `sender_is_group` tinyint(4) NOT NULL,
  `recipient_is_group` tinyint(4) NOT NULL,
  `is_read` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sender_id` (`sender_id`),
  KEY `FK_recipient_id` (`recipient_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` VALUES(1, 'Hey how are you doing', '2012-05-27 20:08:12', 1, 2, 0, 0, 0);
INSERT INTO `messages` VALUES(2, 'Not bad fella, how you doing?', '2012-05-27 20:08:58', 2, 1, 0, 0, 0);
INSERT INTO `messages` VALUES(3, 'Hey, are you who I think you are?', '2012-05-31 17:51:36', 1, 4, 0, 0, 0);
INSERT INTO `messages` VALUES(4, 'Its been a while', '2012-06-10 19:19:15', 1, 2, 0, 0, 0);
INSERT INTO `messages` VALUES(9, 'It''s Mark', '2012-08-15 22:04:43', 1, 4, 0, 0, 0);
INSERT INTO `messages` VALUES(10, 'Answer me please', '2012-08-15 22:08:05', 1, 4, 0, 0, 0);
INSERT INTO `messages` VALUES(11, 'buyuyfuf', '2012-08-18 00:00:58', 1, 2, 0, 0, 0);
INSERT INTO `messages` VALUES(12, 'tset', '2012-11-19 21:09:53', 1, 4, 0, 0, 0);
INSERT INTO `messages` VALUES(13, 'trtrtr', '2012-11-19 21:16:40', 1, 2, 0, 0, 0);
INSERT INTO `messages` VALUES(14, 'test', '2012-11-19 21:21:53', 1, 6, 0, 0, 0);
INSERT INTO `messages` VALUES(15, 'test', '2012-11-26 00:02:31', 1, 4, 0, 0, 0);
INSERT INTO `messages` VALUES(16, 'oi', '2012-11-26 20:16:28', 1, 4, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `profile_image`
--

CREATE TABLE `profile_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_img_user_id` (`user_id`),
  KEY `FK_prof_image_id` (`image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `profile_image`
--

INSERT INTO `profile_image` VALUES(1, 1, 19);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=8 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` VALUES(1, 'roppa_uk', '$2a$08$vSOeF4KmPaXh/sTV6B9Ay.OAtMwn/4Rxci3PQHr6CNzi4wYcDJm3G', 'roppa_uk@hotmail.com', 1, 0, NULL, NULL, NULL, NULL, 'a5991f5072eaa2569d015d796cad4f6f', '127.0.0.1', '2012-12-23 00:53:07', '2012-01-21 13:34:48', '2012-12-23 11:53:07');
INSERT INTO `users` VALUES(2, 'sompfrog', '$2a$08$xxAl6ZwZGAMkeO2KLBcpHO3PVpIDULTm7b6w/Gc8pCOPjjP0YLslK', 'chrisbewick@gmail.com', 1, 0, NULL, NULL, NULL, NULL, '700c92cfe378fdd91ef7b89fdb3a2d03', '127.0.0.1', '0000-00-00 00:00:00', '2012-01-28 10:12:30', '2012-01-28 21:12:59');
INSERT INTO `users` VALUES(3, 'neslisever', '$2a$08$lL2NJTtvb4N1HICUOsDDgOpMDchwSmD5HthcFozB1xburUlG9.WFW', 'neslisever@yahoo.com', 1, 0, NULL, NULL, NULL, NULL, 'a629e15716b12a16846e1416c5fd7453', '127.0.0.1', '2012-01-28 23:02:47', '2012-01-28 14:33:48', '2012-01-29 10:02:47');
INSERT INTO `users` VALUES(4, 'joch', '$2a$08$.QkhtqleQeoibY0NmVKyr.2L4f44k/kP9A4u0sbRRfQq68FZV56YO', 'joch@talktalk.net', 1, 0, NULL, NULL, NULL, NULL, '9a84fd9df2da3d9b71729212fb0f9a76', '127.0.0.1', '2012-03-31 18:38:45', '2012-02-10 20:59:22', '2012-04-01 03:38:45');
INSERT INTO `users` VALUES(5, 'maribell64', '$2a$08$vbejdYwcB12ALKiPsSaPKeTNI/AsXboX.310lJx.SoHh3l9uBTofm', 'maribell_vargas7@hotmail.com', 1, 0, NULL, NULL, NULL, NULL, '4cd08f03e2527ac592a2d1a047420711', '127.0.0.1', '2012-04-17 11:37:08', '2012-04-06 17:59:23', '2012-04-17 20:37:08');
INSERT INTO `users` VALUES(6, 'helen_pailing', '$2a$08$PERf8hy4tX8X8SQocRzDp.yjhl4D0TCblqMXX1.aZTDpKseaa9rAK', 'helen_pailing@hotmail.com', 1, 0, NULL, NULL, NULL, NULL, 'af287d2561040208d02a725c56d56237', '127.0.0.1', '2012-05-19 21:18:23', '2012-05-19 10:12:50', '2012-05-20 14:18:23');

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

INSERT INTO `user_autologin` VALUES('dd8b2a63c00d0c271354e5d885d7f96b', 7, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:16.0) Gecko/20100101 Firefox/16.0', '127.0.0.1', '2012-12-23 13:40:29');

-- --------------------------------------------------------

--
-- Table structure for table `user_interests`
--

CREATE TABLE `user_interests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `interest_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_interest_user_id` (`user_id`),
  KEY `FK_interest_type_id` (`interest_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `user_interests`
--

INSERT INTO `user_interests` VALUES(3, 3, 3);
INSERT INTO `user_interests` VALUES(4, 3, 6);
INSERT INTO `user_interests` VALUES(5, 1, 1);
INSERT INTO `user_interests` VALUES(8, 1, 4);
INSERT INTO `user_interests` VALUES(10, 1, 3);
INSERT INTO `user_interests` VALUES(11, 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `user_id` int(11) NOT NULL,
  `website` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `first_name` varchar(10) COLLATE utf8_bin NOT NULL,
  `last_name` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `avatar` int(11) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `sex` char(1) COLLATE utf8_bin DEFAULT NULL,
  `about_me` text COLLATE utf8_bin,
  `facebook_id` varchar(255) COLLATE utf8_bin NOT NULL,
  `twitter_id` varchar(255) COLLATE utf8_bin NOT NULL,
  `gfc_id` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `FK_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` VALUES(1, 'http://www.whiteforest.co.uk', 'Mark', 'Robson', 16, 'Painting a pretty picture', 'm', 0x492068617665206e6f74206265656e20666f726d616c6c7920747261696e656420616e6420626567616e207061696e74696e6720696e20446563656d626572203230313020616674657220616e20697272657369737469626c6520757267652e20416674657220636f6d706c6574696e67207468726565207061696e74696e6773204920626567616e20746f2067657420696d61676520616674657220696d61676520737072696e67696e6720696e746f206d79206d696e64202d2066756c6c7920666f726d656420616e642066696e6973686564207061696e74696e677320696e206120666c6173682e2054686520666c6f6f64676174657320686164206f70656e65642e2041667465722061207768696c652049207265616c69736564206d6f7374206f6620746865736520696d616765732077657265207265666c6578696f6e73206f66207768617420492073656520616e6420657870657269656e636520696e206d792064617920746f20646179206c6966652e2041206c6f74206f66207468656d20686f7765766572206172652066726f6d20736f6d65776865726520656c73652e2049206c696b6520746f207468696e6b206f66206d7920617274206173206d657461706879736963616c2e, '', '', '');
INSERT INTO `user_profiles` VALUES(2, 'http://chrisbewick.com/blog/', 'Chris', 'Bewick', NULL, 'Creativity', 'm', 0x486572652069732061206c6974746c65206269742061626f7574206d652e20416e6420736f6d65206d6f72652061626f7574206d652e, '', '', '');
INSERT INTO `user_profiles` VALUES(3, 'http://www.neslihansever.com/', 'Nesli', 'Sever', NULL, 'Kurdish art', 'f', 0x416476656e747572657320696e746f204b757264697368206172742e, '', '', '');
INSERT INTO `user_profiles` VALUES(4, 'http://www.google.co.uk', 'Joachim', 'Sefzik', NULL, NULL, NULL, 0x746869732069732061626f7574206d65, '', '', '');
INSERT INTO `user_profiles` VALUES(5, 'http://www.google.co.uk', 'Maribel', 'Vargas', NULL, NULL, NULL, NULL, '', '', '');
INSERT INTO `user_profiles` VALUES(6, 'http://www.helenpailing.com', 'Helen', 'Pailing', NULL, NULL, 'f', 0x546865206f626a6563747320492063726561746520657869737420696e2061207370616365206265747765656e20746865206d61646520616e642074686520756e6d6164653a20736f6d652061726520626f756e642c20726573747269637465642c2066697865643b206f746865727320617070656172206d6f726520707265636172696f75732061732074686f756768207468657920636f756c6420756e77726170206f7220756e726176656c20617420616e7920676976656e2074696d652e0d0a0d0a54686520776f726b20697320666f726d6564206f7574206f66206120706c617966756c20636f6c6c61626f726174696f6e206265747765656e206d6520616e6420746865206d6174657269616c732e20492073656172636820666f7220736f6d657468696e6720696e20616e20616374696f6e20726174686572207468616e2070726573656e74696e6720612064657369726564207065726d616e656e636520616e64207468652072657065746974696f6e206f6620612073696d706c652070726f63657373206f72206a6f696e696e6720746563686e69717565206973206120726563757272696e6720666561747572652e204920726573706f6e6420696e747569746976656c7920746f207365656d696e676c79206e6f6e2070726563696f7573206d616e206d616465206d6174657269616c7320616e64207468652064726177696e677320616e642070686f746f67726170687320746861742061726520626f726e206f7574206f6620746865206d616b696e672070726f636573732c2061726520616e20696e74656772616c2070617274206f662074686520776f726b2e0d0a0d0a4d6f76656d656e742c206d6174657269616c6974792c20616e642074686520706572666f726d616e636520706f74656e7469616c206f6620746865206576657279646179207374756666207468617420737572726f756e64732075732061726520736f6d65206f662074686520696465617320746861742064726976652074686520776f726b2e205468652066616d696c696172697479206f6620746865206d6174657269616c732049207573652061637420617320612077617920696e20746f20756e6465727374616e64696e67207468652076616c756573206f662074686520776f726b20697473656c662e, '', '', '');

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
-- Constraints for table `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `FK_gallery_user_id` FOREIGN KEY (`user_id`) REFERENCES `user_profiles` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `gallery_image`
--
ALTER TABLE `gallery_image`
  ADD CONSTRAINT `FK_gallery_id` FOREIGN KEY (`gallery_id`) REFERENCES `gallery` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_image_id` FOREIGN KEY (`image_id`) REFERENCES `image` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `FK_image_user_id` FOREIGN KEY (`user_id`) REFERENCES `user_profiles` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profile_image`
--
ALTER TABLE `profile_image`
  ADD CONSTRAINT `FK_prof_image_id` FOREIGN KEY (`image_id`) REFERENCES `image` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `FK_recipient_id` FOREIGN KEY (`recipient_id`) REFERENCES `user_profiles` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_sender_id` FOREIGN KEY (`sender_id`) REFERENCES `user_profiles` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `group_users`
--
ALTER TABLE `group_users`
  ADD CONSTRAINT `FK_group_id` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_group_users_user_id` FOREIGN KEY (`user_id`) REFERENCES `user_profiles` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_interests`
--
ALTER TABLE `user_interests`
  ADD CONSTRAINT `FK_interest_type_id` FOREIGN KEY (`interest_type_id`) REFERENCES `interests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_interest_user_id` FOREIGN KEY (`user_id`) REFERENCES `user_profiles` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `FK_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
