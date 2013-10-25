#
# Powered by XCloner Site Backup
# http://www.xcloner.com
#
# Host: localhost
# Generation Time: Jan 26, 2013 at 10:10
# PHP Version: 5.3.10-1ubuntu3.5
# Mysql Compatibility: 
# MYSQL innodb_version: 1.1.8
# MYSQL protocol_version: 10
# MYSQL slave_type_conversions: 
# MYSQL version: 5.5.29-0ubuntu0.12.04.1
# MYSQL version_comment: (Ubuntu)
# MYSQL version_compile_machine: i686
# MYSQL version_compile_os: debian-linux-gnu
#
# Database : `Social_Garbage`
# --------------------------------------------------------


#
# Table structure for table `se_actionmedia`
#

CREATE TABLE `se_actionmedia` (
  `actionmedia_id` int(9) NOT NULL AUTO_INCREMENT,
  `actionmedia_action_id` int(9) NOT NULL,
  `actionmedia_path` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `actionmedia_link` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `actionmedia_width` int(3) NOT NULL,
  `actionmedia_height` int(3) NOT NULL,
  PRIMARY KEY (`actionmedia_id`),
  KEY `actionmedia_action_id` (`actionmedia_action_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_actionmedia`
#

#
# Dumping data for table `se_actionmedia`
#

INSERT INTO `se_actionmedia` VALUES ('1', '4', './uploads_user/1000/1/0_5033.jpg', 'http://localhost/Social/profile.php?user=Cyberalphabetizador', '66', '100');

#
# Table structure for table `se_actions`
#

CREATE TABLE `se_actions` (
  `action_id` int(9) NOT NULL AUTO_INCREMENT,
  `action_actiontype_id` int(9) NOT NULL DEFAULT '0',
  `action_date` int(14) NOT NULL DEFAULT '0',
  `action_user_id` int(9) NOT NULL DEFAULT '0',
  `action_text` text COLLATE utf8_unicode_ci NOT NULL,
  `action_object_owner` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `action_object_owner_id` int(9) NOT NULL DEFAULT '0',
  `action_object_privacy` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`action_id`),
  KEY `action_user_id` (`action_user_id`),
  KEY `action_date` (`action_date`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_actions`
#

#
# Dumping data for table `se_actions`
#

INSERT INTO `se_actions` VALUES ('1', '6', '1357838959', '1', 'a:2:{i:0;s:19:\"Cyberalphabetizador\";i:1;s:17:\"Norberto Márquez\";}', 'user', '1', '63');
INSERT INTO `se_actions` VALUES ('2', '7', '1357840683', '1', 'a:3:{i:0;s:19:\"Cyberalphabetizador\";i:1;s:17:\"Norberto Márquez\";i:2;s:8:\"Probando\";}', 'user', '1', '63');
INSERT INTO `se_actions` VALUES ('3', '3', '1357840755', '1', 'a:2:{i:0;s:19:\"Cyberalphabetizador\";i:1;s:9:\"Celestina\";}', 'user', '1', '63');
INSERT INTO `se_actions` VALUES ('4', '2', '1357840843', '1', 'a:2:{i:0;s:19:\"Cyberalphabetizador\";i:1;s:9:\"Celestina\";}', 'user', '1', '63');

#
# Table structure for table `se_actiontypes`
#

CREATE TABLE `se_actiontypes` (
  `actiontype_id` int(9) NOT NULL AUTO_INCREMENT,
  `actiontype_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `actiontype_icon` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `actiontype_setting` int(1) NOT NULL DEFAULT '0',
  `actiontype_enabled` int(1) NOT NULL DEFAULT '0',
  `actiontype_desc` int(9) NOT NULL DEFAULT '0',
  `actiontype_text` int(9) NOT NULL DEFAULT '0',
  `actiontype_vars` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `actiontype_media` int(1) NOT NULL,
  PRIMARY KEY (`actiontype_id`),
  UNIQUE KEY `actiontype_name` (`actiontype_name`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_actiontypes`
#

#
# Dumping data for table `se_actiontypes`
#

INSERT INTO `se_actiontypes` VALUES ('1', 'login', 'action_login.gif', '1', '0', '700008', '700001', '[username],[displayname]', '0');
INSERT INTO `se_actiontypes` VALUES ('2', 'editphoto', 'action_editphoto.gif', '1', '1', '700009', '700002', '[username],[displayname]', '1');
INSERT INTO `se_actiontypes` VALUES ('3', 'editprofile', 'action_editprofile.gif', '1', '1', '700010', '700003', '[username],[displayname]', '0');
INSERT INTO `se_actiontypes` VALUES ('4', 'profilecomment', 'action_postcomment.gif', '1', '1', '700011', '700004', '[username1],[displayname1],[username2],[displayname2],[comment]', '0');
INSERT INTO `se_actiontypes` VALUES ('5', 'addfriend', 'action_addfriend.gif', '1', '1', '700012', '700005', '[username1],[displayname1],[username2],[displayname2]', '0');
INSERT INTO `se_actiontypes` VALUES ('6', 'signup', 'action_signup.gif', '0', '1', '700013', '700006', '[username],[displayname]', '0');
INSERT INTO `se_actiontypes` VALUES ('7', 'editstatus', 'action_editstatus.gif', '1', '1', '700014', '700007', '[username],[displayname],[status]', '0');

#
# Table structure for table `se_admins`
#

CREATE TABLE `se_admins` (
  `admin_id` int(9) NOT NULL AUTO_INCREMENT,
  `admin_username` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `admin_password` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `admin_password_method` tinyint(1) NOT NULL DEFAULT '0',
  `admin_code` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `admin_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `admin_email` varchar(70) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `admin_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `admin_language_id` smallint(3) NOT NULL DEFAULT '1',
  `admin_lostpassword_code` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `admin_lostpassword_time` int(14) NOT NULL DEFAULT '0',
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `UNIQUE` (`admin_username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_admins`
#

#
# Dumping data for table `se_admins`
#

INSERT INTO `se_admins` VALUES ('1', 'admin', '124282ebba44b1b35ff21e8de3b25931', '1', 'fVSsdx1BlZ6fS5Sd', 'El Cyberalphabetizador', 'cyberalpha@google.com', '1', '2', '', '0');

#
# Table structure for table `se_ads`
#

CREATE TABLE `se_ads` (
  `ad_id` int(9) NOT NULL AUTO_INCREMENT,
  `ad_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ad_date_start` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ad_date_end` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ad_paused` int(1) NOT NULL DEFAULT '0',
  `ad_limit_views` int(10) NOT NULL DEFAULT '0',
  `ad_limit_clicks` int(10) NOT NULL DEFAULT '0',
  `ad_limit_ctr` varchar(8) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `ad_public` int(1) NOT NULL DEFAULT '0',
  `ad_position` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ad_levels` text COLLATE utf8_unicode_ci NOT NULL,
  `ad_subnets` text COLLATE utf8_unicode_ci NOT NULL,
  `ad_html` text COLLATE utf8_unicode_ci NOT NULL,
  `ad_total_views` int(10) NOT NULL DEFAULT '0',
  `ad_total_clicks` int(10) NOT NULL DEFAULT '0',
  `ad_filename` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`ad_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_ads`
#

#
# Dumping data for table `se_ads`
#


#
# Table structure for table `se_announcements`
#

CREATE TABLE `se_announcements` (
  `announcement_id` int(9) NOT NULL AUTO_INCREMENT,
  `announcement_order` int(9) NOT NULL DEFAULT '0',
  `announcement_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `announcement_subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `announcement_body` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`announcement_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_announcements`
#

#
# Dumping data for table `se_announcements`
#


#
# Table structure for table `se_faqcats`
#

CREATE TABLE `se_faqcats` (
  `faqcat_id` int(9) NOT NULL AUTO_INCREMENT,
  `faqcat_order` int(5) NOT NULL DEFAULT '0',
  `faqcat_title` int(9) NOT NULL DEFAULT '0',
  PRIMARY KEY (`faqcat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_faqcats`
#

#
# Dumping data for table `se_faqcats`
#

INSERT INTO `se_faqcats` VALUES ('1', '0', '800001');
INSERT INTO `se_faqcats` VALUES ('2', '2', '800002');
INSERT INTO `se_faqcats` VALUES ('3', '3', '800003');

#
# Table structure for table `se_faqs`
#

CREATE TABLE `se_faqs` (
  `faq_id` int(9) NOT NULL AUTO_INCREMENT,
  `faq_faqcat_id` int(9) NOT NULL DEFAULT '0',
  `faq_order` int(5) NOT NULL DEFAULT '0',
  `faq_subject` int(9) NOT NULL DEFAULT '0',
  `faq_content` int(9) NOT NULL DEFAULT '0',
  `faq_datecreated` int(14) NOT NULL DEFAULT '0',
  `faq_dateupdated` int(14) NOT NULL DEFAULT '0',
  `faq_views` int(9) NOT NULL DEFAULT '0',
  PRIMARY KEY (`faq_id`),
  KEY `faq_faqcat_id` (`faq_faqcat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_faqs`
#

#
# Dumping data for table `se_faqs`
#

INSERT INTO `se_faqs` VALUES ('1', '1', '1', '800004', '800005', '1213374575', '1215547954', '64');
INSERT INTO `se_faqs` VALUES ('10', '1', '4', '800010', '800011', '1213382555', '1215547972', '22');
INSERT INTO `se_faqs` VALUES ('8', '1', '2', '800006', '800007', '1213382503', '1215547957', '49');
INSERT INTO `se_faqs` VALUES ('9', '1', '3', '800008', '800009', '1213382544', '1215547959', '35');
INSERT INTO `se_faqs` VALUES ('11', '1', '5', '800012', '800013', '1213382572', '1215547978', '17');
INSERT INTO `se_faqs` VALUES ('12', '2', '6', '800014', '800015', '1213382588', '1215547980', '27');
INSERT INTO `se_faqs` VALUES ('13', '2', '7', '800016', '800017', '1213382659', '1215547982', '17');
INSERT INTO `se_faqs` VALUES ('14', '3', '8', '800018', '800019', '1213382678', '1215547984', '22');
INSERT INTO `se_faqs` VALUES ('15', '3', '9', '800020', '800021', '1213382698', '1215547986', '13');
INSERT INTO `se_faqs` VALUES ('16', '3', '10', '800022', '800023', '1213382711', '1215547988', '14');

#
# Table structure for table `se_friendexplains`
#

CREATE TABLE `se_friendexplains` (
  `friendexplain_id` int(9) NOT NULL AUTO_INCREMENT,
  `friendexplain_friend_id` int(9) NOT NULL DEFAULT '0',
  `friendexplain_body` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`friendexplain_id`),
  KEY `friend_id` (`friendexplain_friend_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_friendexplains`
#

#
# Dumping data for table `se_friendexplains`
#


#
# Table structure for table `se_friends`
#

CREATE TABLE `se_friends` (
  `friend_id` int(9) NOT NULL AUTO_INCREMENT,
  `friend_user_id1` int(9) NOT NULL DEFAULT '0',
  `friend_user_id2` int(9) NOT NULL DEFAULT '0',
  `friend_status` int(1) NOT NULL DEFAULT '0',
  `friend_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`friend_id`),
  UNIQUE KEY `friend_user_id` (`friend_user_id1`,`friend_user_id2`),
  KEY `friend_status` (`friend_status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_friends`
#

#
# Dumping data for table `se_friends`
#


#
# Table structure for table `se_invites`
#

CREATE TABLE `se_invites` (
  `invite_id` int(9) NOT NULL AUTO_INCREMENT,
  `invite_user_id` int(9) NOT NULL DEFAULT '0',
  `invite_date` int(14) NOT NULL DEFAULT '0',
  `invite_email` varchar(70) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `invite_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`invite_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_invites`
#

#
# Dumping data for table `se_invites`
#


#
# Table structure for table `se_languages`
#

CREATE TABLE `se_languages` (
  `language_id` int(9) NOT NULL AUTO_INCREMENT,
  `language_code` varchar(8) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `language_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `language_autodetect_regex` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `language_setlocale` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `language_default` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`language_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_languages`
#

#
# Dumping data for table `se_languages`
#

INSERT INTO `se_languages` VALUES ('1', 'en', 'English', '/^en/i', '', '0');
INSERT INTO `se_languages` VALUES ('2', 'Es', 'Espa', '', ' ', '1');

#
# Table structure for table `se_languagevars`
#

CREATE TABLE `se_languagevars` (
  `languagevar_id` int(9) unsigned NOT NULL DEFAULT '0',
  `languagevar_language_id` int(9) NOT NULL DEFAULT '0',
  `languagevar_value` text COLLATE utf8_unicode_ci,
  `languagevar_default` text COLLATE utf8_unicode_ci,
  UNIQUE KEY `INDEX` (`languagevar_id`,`languagevar_language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_languagevars`
#

#
# Dumping data for table `se_languagevars`
#

INSERT INTO `se_languagevars` VALUES ('1', '1', 'Admin Panel', 'admin_header_global, ');
INSERT INTO `se_languagevars` VALUES ('2', '1', 'Network Management', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('3', '1', 'Summary', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('4', '1', 'View Users', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('5', '1', 'View Admins', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('6', '1', 'View Reports', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('7', '1', 'View Plugins', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('8', '1', 'User Levels', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('9', '1', 'Subnetworks', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('10', '1', 'Ad Campaigns', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('11', '1', 'Global Settings', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('12', '1', 'General Settings', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('13', '1', 'Signup Settings', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('14', '1', 'Recent Activity Feed', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('15', '1', 'HTML Templates', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('16', '1', 'Profile Fields', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('17', '1', 'Banning/Spam', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('18', '1', 'User Connections', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('19', '1', 'URL Settings', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('20', '1', 'System Emails', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('21', '1', 'Other Tools', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('22', '1', 'Invite Users', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('23', '1', 'Announcements', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('24', '1', 'Statistics', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('25', '1', 'Access Log', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('26', '1', 'Logout', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('27', '1', 'Administrator Login', '');
INSERT INTO `se_languagevars` VALUES ('28', '1', 'Username', 'user_account, signup, admin_viewusers, admin_viewreports, admin_viewadmins, admin_login, ');
INSERT INTO `se_languagevars` VALUES ('29', '1', 'Password', 'signup, login, home, admin_login, ');
INSERT INTO `se_languagevars` VALUES ('30', '1', 'Login', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_login, ');
INSERT INTO `se_languagevars` VALUES ('31', '1', 'Your browser does not have Javascript enabled. Please enable Javascript and try again.', 'admin_login, ');
INSERT INTO `se_languagevars` VALUES ('32', '1', 'The login details you provided were invalid. Did you <a href=\'admin_lostpass.php\'>forget your password</a>?', 'admin_login, ');
INSERT INTO `se_languagevars` VALUES ('33', '1', 'Lost Password', 'lostpass, admin_lostpass, ');
INSERT INTO `se_languagevars` VALUES ('34', '1', 'If you cannot login because you have forgotten your password, please enter your email address in the field below.', 'lostpass, admin_lostpass, ');
INSERT INTO `se_languagevars` VALUES ('35', '1', 'You have been sent an email with instructions how to reset your password. If the email does not arrive within several minutes, be sure to check your spam or junk mail folders.', 'lostpass, admin_lostpass, ');
INSERT INTO `se_languagevars` VALUES ('36', '1', 'The email you have entered was not found in the database. Please try again.', 'admin_lostpass, ');
INSERT INTO `se_languagevars` VALUES ('37', '1', 'Email Address:', 'signup, lostpass, help_contact, admin_viewusers_edit, admin_lostpass, ');
INSERT INTO `se_languagevars` VALUES ('38', '1', 'Submit', 'admin_lostpass, ');
INSERT INTO `se_languagevars` VALUES ('39', '1', 'Cancel', 'user_report, user_messages_new, user_home, user_friends_manage, user_friends_block, user_account_delete, profile, lostpass_reset, lostpass, admin_viewusers_edit, admin_viewusers, admin_viewadmins, admin_subnetworks, admin_profile, admin_lostpass_reset, admin_lostpass, admin_levels, admin_language_edit, admin_language, admin_fields, admin_faq, admin_announcements, admin_ads_modify, admin_ads, ');
INSERT INTO `se_languagevars` VALUES ('40', '1', 'Reset SocialEngine Admin Password Request', 'admin_lostpass, ');
INSERT INTO `se_languagevars` VALUES ('41', '1', 'Hello,\r\n\r\nYou have requested to reset your SocialEngine admin password. If you would like to do so, please click the link below. If you did not request a password reset, simply ignore this email.\r\n\r\n[link]\r\n\r\nThank You', 'admin_lostpass, ');
INSERT INTO `se_languagevars` VALUES ('42', '1', 'Reset Password', 'lostpass_reset, admin_lostpass_reset, ');
INSERT INTO `se_languagevars` VALUES ('43', '1', 'Lost Password Reset', 'lostpass_reset, admin_lostpass_reset, ');
INSERT INTO `se_languagevars` VALUES ('44', '1', 'Your password has been reset. <a href=\'admin_login.php\'>Click here</a> to login.', 'admin_lostpass_reset, ');
INSERT INTO `se_languagevars` VALUES ('45', '1', 'Complete the form below to reset your password.', 'lostpass_reset, admin_lostpass_reset, ');
INSERT INTO `se_languagevars` VALUES ('46', '1', 'New Password', 'user_account_pass, lostpass_reset, admin_viewadmins, admin_lostpass_reset, ');
INSERT INTO `se_languagevars` VALUES ('47', '1', 'Confirm New Password', 'user_account_pass, lostpass_reset, admin_viewadmins, admin_lostpass_reset, ');
INSERT INTO `se_languagevars` VALUES ('138', '1', 'Value', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('50', '1', 'This link is invalid or expired. Please <a href=\'admin_lostpass.php\'>resubmit</a> your password request and follow the link sent to your email address.', 'admin_lostpass_reset, ');
INSERT INTO `se_languagevars` VALUES ('51', '1', 'Please make sure you have completed all fields.', 'signup, admin_viewadmins, ');
INSERT INTO `se_languagevars` VALUES ('52', '1', 'Username and Password fields must be alpha-numeric.', 'admin_viewadmins, admin_lostpass_reset, ');
INSERT INTO `se_languagevars` VALUES ('53', '1', 'Passwords must be at least 6 characters in length.', 'signup, admin_lostpass_reset, ');
INSERT INTO `se_languagevars` VALUES ('54', '1', 'Password and Password Confirmation fields must match.', 'admin_lostpass_reset, ');
INSERT INTO `se_languagevars` VALUES ('55', '1', 'Hello, Admin!', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('56', '1', 'Welcome to your social network control panel. Here you can manage and modify every aspect of your social network. Directly below, you will find a quick snapshot of your social network including some useful statistics.', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('58', '1', 'SocialEngine License:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('59', '1', 'Version:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('60', '1', 'Upgrade Available', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('500405', '2', 'País', '');
INSERT INTO `se_languagevars` VALUES ('61', '1', 'Total Users:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('62', '1', 'Comments:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('63', '1', 'Private Messages:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('64', '1', 'User Levels:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('65', '1', 'Subnetworks:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('66', '1', 'Abuse Reports:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('67', '1', 'Friendships:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('68', '1', 'News Posts:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('69', '1', 'Views Today:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('70', '1', 'Signups Today:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('71', '1', 'Logins Today:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('72', '1', 'Admin Accounts:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('73', '1', 'User(s) Online:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('74', '1', '<h2>Getting Started</h2>If you have just setup SocialEngine and are ready to build your social network, here are some helpful suggestions:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('75', '1', 'Create Profile Fields', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('76', '1', 'One of the most defining aspects of your social network are your profile fields. These determine what information users share about each other on their profiles. They are an essential for emphasizing your social network\'s unique theme or subject.', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('77', '1', 'Edit Signup Settings', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('78', '1', 'After you\'ve created your profile fields, you will want to customize the user signup process. Here you can specify what information users have to provide, whether or not they must be invited to signup, and other important details.', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('79', '1', 'Edit Default User Level', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('80', '1', 'Now let\'s decide what features users have access to and what limits we will place on their accounts. You can accomplish this by editing the default user level or creating additional user levels.', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('81', '1', 'Install Plugins', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('82', '1', 'Plugins give your social network additional functionality and interactivity. If you\'ve already purchased any plugins, now would be an excellent time to install them and configure their settings.', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('83', '1', 'Customize Look & Feel', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('84', '1', 'The next step is to give your new social network its own style! You can edit any of the HTML templates (including a global header template and CSS file) to add your own personal design.', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('86', '1', 'This page contains a list of the last 300 login attempts. Use this page to observe suspicious login attempts to your social network.', 'admin_log, ');
INSERT INTO `se_languagevars` VALUES ('87', '1', 'ID', 'admin_viewusers, admin_viewreports, admin_viewadmins, admin_subnetworks, admin_log, admin_levels, admin_language_edit, admin_announcements, admin_ads, ');
INSERT INTO `se_languagevars` VALUES ('88', '1', 'Date', 'admin_log, admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('89', '1', 'Email', 'login, home, admin_viewusers, admin_viewadmins, admin_log, ');
INSERT INTO `se_languagevars` VALUES ('90', '1', 'Result', 'admin_log, ');
INSERT INTO `se_languagevars` VALUES ('91', '1', 'IP', 'admin_log, ');
INSERT INTO `se_languagevars` VALUES ('92', '1', 'Success', 'admin_log, ');
INSERT INTO `se_languagevars` VALUES ('93', '1', 'Failure', 'admin_log, ');
INSERT INTO `se_languagevars` VALUES ('95', '1', 'Your users will distinguish themselves through their profile page. You must give them profile fields that allow them to describe themselves in a way that is relevant to the theme of your social network. On this page, you can create profile categories, tabs, and fields.<br><br>If you want all users on your social network to have the same profile fields, you will only need to create one profile type. On the other hand, for example, you may want to have \'Musician\' profiles and \'Fan\' profiles, in which case you would create two profile types. You can create a unique set of profile tabs and fields for each profile type, meaning that Musicians and Fans will each fill out different profile fields. If you have created more than one profile type, users will select their profile type when they signup.<br><br>Profile tabs allow you to organize your profile fields into sections. Commonly used tabs are \'Personal Info\', \'Contact Info\', \'About Me\', etc., but you should create tabs that organize your fields appropriately.<br><br>Profile fields are the actual input fields into which your users will enter their information. Likewise, these should be relevant to the unique theme of your social network.<br><br>Please note that if you have additional language packs, you can translate the category, tab, and field names on the <a href=\'admin_language.php\'>Language Settings</a> page.', 'admin_profile, ');
INSERT INTO `se_languagevars` VALUES ('96', '1', 'Please ensure you have completed all the required fields.', '');
INSERT INTO `se_languagevars` VALUES ('97', '1', 'Please ensure you have filled out the fields in the proper format.', '');
INSERT INTO `se_languagevars` VALUES ('98', '1', 'Tabs', 'admin_profile, admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('99', '1', 'Add Tab', 'admin_profile, admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('100', '1', 'Fields', 'admin_profile, admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('101', '1', 'Add Field', 'admin_profile, admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('102', '1', 'Dependent Field', 'admin_profile, admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('103', '1', 'Profile Categories', 'admin_profile, ');
INSERT INTO `se_languagevars` VALUES ('104', '1', 'Add Category', 'admin_profile, admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('106', '1', 'Field Title:', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('105', '1', 'Are you sure you want to delete this category? NOTE: If you are deleting a main category, all subcategories and fields will be deleted as well.', 'admin_profile, admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('107', '1', 'Category:', 'admin_fields, admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('108', '1', 'Tab:', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('109', '1', 'Field Type:', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('110', '1', 'Text Field', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('111', '1', 'Multi-line Text Area', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('112', '1', 'Pull-down Select Box', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('113', '1', 'Radio Buttons', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('114', '1', 'Date Field', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('115', '1', 'Inline CSS Style:', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('116', '1', 'Field Description:', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('117', '1', 'Custom Error Message:', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('118', '1', 'Required:', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('119', '1', 'Not Required', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('120', '1', 'Required', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('121', '1', 'Search Type:', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('122', '1', 'Do Not Display Search Field', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('123', '1', 'Exact Value Search', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('124', '1', 'Range Search', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('125', '1', 'If you would like your users to be able to search based on this field, choose either an \"Exact Value Search\" or a \"Range Search\". If you select \"Exact Value Search\", results will need to match the exact search value entered by the user. If you select \"Range Search\", users will be able to input minimum and maximum search values. This is useful for numerical fields such as \"price\", \"square footage\", and \"age\". Please note that \"Range Search\" does not work for date fields.', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('126', '1', 'Allowed HTML Tags:', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('127', '1', 'By default, the user may not enter any HTML tags into this profile field. If you want to allow specific tags, you can enter them above (separated by commas). Example: <i>b, img, a, embed, font<i>', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('128', '1', 'Field Maxlength:', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('129', '1', 'Link Field To:', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('130', '1', 'If you want this field to link to another URL, enter the link format above. Note that this will override the \"Searchable/Linked\" setting above. Use [field_value] to represent the user\'s input for this field. Examples: <i>Regular link (if user\'s input is a URL - must begin with \"http://\"):</i> <strong>[field_value]</strong><br><i>Mailto link (if user\'s input is an email address):</i> <strong>mailto:[field_value]</strong><br><i>AIM Link (if user\'s input is an AIM screenname):</i> <strong>aim:goim?screenname=[field_value]</strong>', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('131', '1', 'Regex Validation:', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('132', '1', 'If you want to force the user to enter data in a certain format, enter the corresponding regular expression above. A preg_match() will be applied when the user enters data. This is optional - if you don\'t understand or need regular expressions, leave this blank.', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('133', '1', 'Options:', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('134', '1', 'Label', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('135', '1', 'Dependency?', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('136', '1', 'Dependent Field Label', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('137', '1', 'Add New Option', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('140', '1', 'Edit Field', 'admin_profile, admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('141', '1', 'Delete Field', 'admin_profile, admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('142', '1', 'Are you sure you want to delete this field?', 'admin_profile, admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('144', '1', 'No dep. field', 'admin_profile, admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('145', '1', 'Yes, has dep. field', 'admin_profile, admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('139', '1', 'Add select box, radio button, or checkbox options by filling out the fields below. The value field should be a positive integer, and each option should have a unique value. If you would like an additional field to display when a user selects one of your options, you can create a dependent field for that option.', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('148', '1', 'Edit Dependent Field', 'admin_profile, admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('146', '1', 'You must enter a non-negative integer for the option values.', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('143', '1', 'You must enter at least one option.', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('94', '1', 'Please enter a title for your field.', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('85', '1', 'You must specify a field type.', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('48', '1', 'Layout Settings', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('49', '1', 'Language Settings', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('147', '1', 'The layout of your social network includes hundreds of phrases of text which are stored in a language pack. SocialEngine comes with an English pack which is the default when you first install the platform. If you want to change any of these phrases on your social network, you can edit the pack below. If you want to allow users to pick from multiple languages, you can also create additional packs below. If you have multiple language packs, the pack you\'ve selected as your \"default\" will be the language that displays if a user has not selected any other language. Note: You can not delete the default language. To edit a language\'s details, click its name.', 'admin_language, ');
INSERT INTO `se_languagevars` VALUES ('149', '1', 'Language Name', 'admin_language, ');
INSERT INTO `se_languagevars` VALUES ('150', '1', 'Language Code', 'admin_language, ');
INSERT INTO `se_languagevars` VALUES ('151', '1', 'Autodetection Regex', 'admin_language, ');
INSERT INTO `se_languagevars` VALUES ('152', '1', 'Default', 'lostpass, admin_viewusers, admin_levels, admin_language, ');
INSERT INTO `se_languagevars` VALUES ('153', '1', 'Options', 'admin_viewusers, admin_viewreports, admin_viewadmins, admin_subnetworks, admin_levels, admin_language, admin_faq, admin_announcements, admin_ads, ');
INSERT INTO `se_languagevars` VALUES ('154', '1', 'edit phrases', 'admin_language, ');
INSERT INTO `se_languagevars` VALUES ('155', '1', 'delete', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_viewusers, admin_viewreports, admin_viewadmins, admin_subnetworks, admin_levels, admin_language, admin_faq, admin_announcements, admin_ads, ');
INSERT INTO `se_languagevars` VALUES ('156', '1', 'Create New Language Pack', 'admin_language, ');
INSERT INTO `se_languagevars` VALUES ('157', '1', 'Delete Language Pack', 'admin_language, ');
INSERT INTO `se_languagevars` VALUES ('158', '1', 'Create Language Pack', 'admin_language, ');
INSERT INTO `se_languagevars` VALUES ('159', '1', 'Edit Language Pack', 'admin_language, ');
INSERT INTO `se_languagevars` VALUES ('160', '1', 'Language Selection Settings', 'admin_language, ');
INSERT INTO `se_languagevars` VALUES ('161', '1', 'If you have more than one language pack, do you want to allow your <b>registered users</b> to select which one will be used while they are logged in? If you select \"Yes\", users will be able to choose their language on the signup page and the account settings page. Note that this will only apply if you have more than one language pack.', 'admin_language, ');
INSERT INTO `se_languagevars` VALUES ('162', '1', 'Yes, allow registered users to choose their own language.', 'admin_language, ');
INSERT INTO `se_languagevars` VALUES ('163', '1', 'No, do not allow registered users to save their language preference.', 'admin_language, ');
INSERT INTO `se_languagevars` VALUES ('164', '1', 'If you have more than one language pack, do you want to display a select box on your homepage so that <b>unregistered users</b> can change the language in which they view the social network? Note that this will only apply if you have more than one language pack.', 'admin_language, ');
INSERT INTO `se_languagevars` VALUES ('165', '1', 'Yes, display a select box that will allow unregistered users to change their language.', 'admin_language, ');
INSERT INTO `se_languagevars` VALUES ('166', '1', 'No, do not allow unregistered users to change the site language.', 'admin_language, ');
INSERT INTO `se_languagevars` VALUES ('167', '1', 'If you have more than one language pack, do you want the system to autodetect the language settings from your visitors\' browsers? If you select \"Yes\", the system will attempt to detect what language the user has set in their browser settings. If you have a matching language, your site will display in that language, otherwise it will display in the default language.<br><br>The system uses regexes used to detect the visitor\'s language. They will be run on the request header \"HTTP_ACCEPT_LANGUAGE\" after it has been cleaned. For example, here is a copy of your browser\'s language settings:', 'admin_language, ');
INSERT INTO `se_languagevars` VALUES ('168', '1', 'Your HTTP_ACCEPT_LANGUAGE is:', 'admin_language, ');
INSERT INTO `se_languagevars` VALUES ('169', '1', 'Your HTTP_ACCEPT_LANGUAGE after cleaning:', 'admin_language, ');
INSERT INTO `se_languagevars` VALUES ('170', '1', 'Your autodetected language with the current settings:', 'admin_language, ');
INSERT INTO `se_languagevars` VALUES ('171', '1', 'Yes, attempt to detect the visitor\'s language based on their browser settings.', 'admin_language, ');
INSERT INTO `se_languagevars` VALUES ('172', '1', 'No, do not autodetect the visitor\'s language.', 'admin_language, ');
INSERT INTO `se_languagevars` VALUES ('173', '1', 'Save Changes', 'user_home, user_editprofile_style, user_editprofile, user_account_privacy, user_account_pass, user_account, admin_viewusers_edit, admin_url, admin_templates, admin_signup, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_language, admin_general, admin_emails, admin_connections, admin_banning, admin_ads_modify, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('174', '1', 'Are you sure you want to delete this language pack?', 'admin_language, ');
INSERT INTO `se_languagevars` VALUES ('175', '1', 'Delete', 'user_account_delete, profile, admin_viewusers, admin_viewadmins, admin_subnetworks, admin_levels, admin_language, admin_faq, admin_announcements, admin_ads, ');
INSERT INTO `se_languagevars` VALUES ('176', '1', 'Please enter a name for your language.', 'admin_language, ');
INSERT INTO `se_languagevars` VALUES ('177', '1', 'Please enter your language pack\'s language name, language code (used to set content headers), setlocale code, and regex in the fields below. The setlocale code allows you to display dates in other languages and uses the PHP function <a href=\'http://www.php.net/manual/en/function.setlocale.php\'>setlocale()</a>. All of the available locale settings for your sever are provided below. If given the option, select the locale code with \"utf8\" in it, as dates may not display properly otherwise. If you leave this field blank, the default server language will be used.', 'admin_language, ');
INSERT INTO `se_languagevars` VALUES ('178', '1', 'Use this page to edit phrases of text within this language pack. Note that you can use the search box to find a specific phrase you may be looking for. If you cannot find the phrase, try just using one or two words from the phrase in the search box. When you edit a phrase, a small window will appear with a box for each language pack (if you have more than one) - you can enter all the different translations for this phrase into each respective box. After you close this popup window, the \"edit\" link for the next phrase will be automatically highlighted. If you want to edit the next phrase, you can press the \"Enter\" key on your keyboard to open the next phrase quickly. Note that if you change admin panel phrases, you may need to refresh the page to see the changes.', 'admin_language_edit, ');
INSERT INTO `se_languagevars` VALUES ('179', '1', '<b>Note: You do not have any phrases in this language pack. To add phrases, go to another language pack and edit the phrases there - you will be able to provide tranlsations for this language pack.</b>', 'admin_language_edit, ');
INSERT INTO `se_languagevars` VALUES ('180', '1', 'Partial Phrase:', 'admin_language_edit, ');
INSERT INTO `se_languagevars` VALUES ('181', '1', 'Find Phrase', 'admin_language_edit, ');
INSERT INTO `se_languagevars` VALUES ('182', '1', 'Last Page', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_language_edit, ');
INSERT INTO `se_languagevars` VALUES ('183', '1', 'Next Page', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_language_edit, ');
INSERT INTO `se_languagevars` VALUES ('184', '1', 'viewing result %1$s of %2$s', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_language_edit, ');
INSERT INTO `se_languagevars` VALUES ('185', '1', 'viewing results %1$s-%2$s of %3$s', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_language_edit, ');
INSERT INTO `se_languagevars` VALUES ('186', '1', 'Phrase', 'admin_language_edit, ');
INSERT INTO `se_languagevars` VALUES ('187', '1', 'edit', 'profile, admin_viewusers, admin_viewadmins, admin_subnetworks, admin_levels, admin_language_edit, admin_faq, admin_announcements, admin_ads, ');
INSERT INTO `se_languagevars` VALUES ('188', '1', 'Edit Phrase', 'admin_language_edit, ');
INSERT INTO `se_languagevars` VALUES ('189', '1', 'Change your phrases in the languages below:', 'admin_language_edit, ');
INSERT INTO `se_languagevars` VALUES ('190', '1', 'This page contains general settings that affect your entire social network.', 'admin_general, ');
INSERT INTO `se_languagevars` VALUES ('191', '1', 'Your changes have been saved.', 'user_editprofile_style, user_editprofile, user_account_privacy, user_account_pass, admin_url, admin_signup, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_general, admin_emails, admin_connections, admin_banning, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('192', '1', 'Public Permission Defaults', 'admin_general, ');
INSERT INTO `se_languagevars` VALUES ('193', '1', 'Select whether or not you want to let the public (visitors that are not logged-in) to view the following sections of your social network. In some cases (such as Profiles), if you have given them the option, your users will be able to make their pages private even though you have made them publically viewable here.', 'admin_general, ');
INSERT INTO `se_languagevars` VALUES ('194', '1', 'Profiles', 'admin_general, ');
INSERT INTO `se_languagevars` VALUES ('195', '1', 'Yes, the public can view profiles unless they are made private.', 'admin_general, ');
INSERT INTO `se_languagevars` VALUES ('196', '1', 'No, the public cannot view profiles.', 'admin_general, ');
INSERT INTO `se_languagevars` VALUES ('197', '1', 'Invite Page', 'admin_general, ');
INSERT INTO `se_languagevars` VALUES ('198', '1', 'Yes, the public can use the invite page.', 'admin_general, ');
INSERT INTO `se_languagevars` VALUES ('199', '1', 'No, the public cannot use the invite page.', 'admin_general, ');
INSERT INTO `se_languagevars` VALUES ('200', '1', 'Search Page', 'admin_general, ');
INSERT INTO `se_languagevars` VALUES ('201', '1', 'Yes, the public can use the search page.', 'admin_general, ');
INSERT INTO `se_languagevars` VALUES ('202', '1', 'No, the public cannot use the search page.', 'admin_general, ');
INSERT INTO `se_languagevars` VALUES ('203', '1', 'Portal Page', 'admin_general, ');
INSERT INTO `se_languagevars` VALUES ('204', '1', 'Yes, the public view use the portal page.', 'admin_general, ');
INSERT INTO `se_languagevars` VALUES ('205', '1', 'No, the public cannot view the portal page.', 'admin_general, ');
INSERT INTO `se_languagevars` VALUES ('206', '1', 'Timezone', 'user_account, signup, admin_general, ');
INSERT INTO `se_languagevars` VALUES ('207', '1', 'Please select a default timezone setting for your social network. This will be the default timezone applied to users\' accounts if they do not select a timezone during signup, or if they are not logged in.', 'admin_general, ');
INSERT INTO `se_languagevars` VALUES ('208', '1', 'Date Format', 'admin_general, ');
INSERT INTO `se_languagevars` VALUES ('209', '1', 'Select the date format you want to use on your social network. This will affect the appearance of the dates that appear on your social network pages.', 'admin_general, ');
INSERT INTO `se_languagevars` VALUES ('210', '1', 'Social networks are often the target of aggressive spam tactics. This most often comes in the form of fake user accounts and spam in comments. On this page, you can manage various anti-spam and censorship features. Note: To turn on the signup image verification feature (a popular anti-spam tool), see the <a href=\'admin_signup.php\'>Signup Settings</a> page.', 'admin_banning, ');
INSERT INTO `se_languagevars` VALUES ('211', '1', 'Ban Users by IP Address', 'admin_banning, ');
INSERT INTO `se_languagevars` VALUES ('212', '1', 'To ban users by their IP address, enter their address into the field below. Addresses should be separated by commas, like <i>123.456.789.123, 23.45.67.89</i>', 'admin_banning, ');
INSERT INTO `se_languagevars` VALUES ('213', '1', 'Ban Users by Email Address', 'admin_banning, ');
INSERT INTO `se_languagevars` VALUES ('214', '1', 'To ban users by their email address, enter their email into the field below. Emails should be separated by commas, like <i>user1@domain1.com, user2@domain2.com</i>. Note that you can ban all email addresses with a specific domain as follows: <i>*@domain.com</i>', 'admin_banning, ');
INSERT INTO `se_languagevars` VALUES ('215', '1', 'Ban Users by Username', 'admin_banning, ');
INSERT INTO `se_languagevars` VALUES ('216', '1', 'Enter the usernames that are not permitted on your social network. Usernames should be separated by commas, like <i>username1, username2</i>', 'admin_banning, ');
INSERT INTO `se_languagevars` VALUES ('217', '1', 'Censored Words on Profiles and Plugins', 'admin_banning, ');
INSERT INTO `se_languagevars` VALUES ('218', '1', 'Enter any words that you you want to censor on your users\' profiles as well as any plugins you have installed. These will be replaced with asterisks (*). Separate words by commas like <i>word1, word2</i>', 'admin_banning, ');
INSERT INTO `se_languagevars` VALUES ('219', '1', 'Require users to enter validation code when commenting?', 'admin_banning, ');
INSERT INTO `se_languagevars` VALUES ('220', '1', 'If you have selected Yes, an image containing a random sequence of 6 numbers will be shown to users on the \"write a comment\" page. Users will be required to enter these numbers into the Verification Code field in order to post their comment. This feature helps prevent users from trying to create comment spam. For this feature to work properly, your server must have the GD Libraries (2.0 or higher) installed and configured to work with PHP. If you are seeing errors, try turning this off.', 'admin_banning, ');
INSERT INTO `se_languagevars` VALUES ('221', '1', 'Yes, enable validation code for commenting.', 'admin_banning, ');
INSERT INTO `se_languagevars` VALUES ('222', '1', 'No, disable validation code for commenting.', 'admin_banning, ');
INSERT INTO `se_languagevars` VALUES ('223', '1', 'Require users to enter validation code when inviting others?', 'admin_banning, ');
INSERT INTO `se_languagevars` VALUES ('224', '1', 'If you have selected Yes, an image containing a random sequence of 6 numbers will be shown to users on the \"invite\" page. Users will be required to enter these numbers into the Verification Code field in order to send their invitation. This feature helps prevent users from trying to create comment spam. For this feature to work properly, your server must have the GD Libraries (2.0 or higher) installed and configured to work with PHP. If you are seeing errors, try turning this off.', 'admin_banning, ');
INSERT INTO `se_languagevars` VALUES ('225', '1', 'Yes, enable validation code for inviting.', 'admin_banning, ');
INSERT INTO `se_languagevars` VALUES ('226', '1', 'No, disable validation code for inviting.', 'admin_banning, ');
INSERT INTO `se_languagevars` VALUES ('227', '1', 'Facilitating associations and relationships between users is essential to building a successful social network. There are several different types of connections that can exist between users. Use this page to determine how your users will associate with each other. Note that although we refer to these relationships as \"friendships\" in this control panel, you should use a word that best fits with your social network\'s theme. For example, if you are running a business-oriented social network, you may want to change this word to \"connections.\"', 'admin_connections, ');
INSERT INTO `se_languagevars` VALUES ('228', '1', 'Who can users invite to become friends?', 'admin_connections, ');
INSERT INTO `se_languagevars` VALUES ('229', '1', 'Please select who users can invite to become their friends. Note that if you select \"nobody\", none of the other settings on this page will apply.', 'admin_connections, ');
INSERT INTO `se_languagevars` VALUES ('230', '1', 'Nobody', 'admin_connections, ');
INSERT INTO `se_languagevars` VALUES ('231', '1', 'Users cannot invite anyone to become friends.', 'admin_connections, ');
INSERT INTO `se_languagevars` VALUES ('232', '1', 'Anybody', 'admin_connections, ');
INSERT INTO `se_languagevars` VALUES ('233', '1', 'Users can invite any other user to become friends.', 'admin_connections, ');
INSERT INTO `se_languagevars` VALUES ('234', '1', 'Same Subnetwork', 'admin_connections, ');
INSERT INTO `se_languagevars` VALUES ('235', '1', 'Users can only invite other users in the same subnetwork to become friends.', 'admin_connections, ');
INSERT INTO `se_languagevars` VALUES ('236', '1', 'Friends of Friends', 'admin_connections, ');
INSERT INTO `se_languagevars` VALUES ('237', '1', 'Users can only invite their current friends\' friends to become friends.', 'admin_connections, ');
INSERT INTO `se_languagevars` VALUES ('238', '1', 'Friendship Framework', 'admin_connections, ');
INSERT INTO `se_languagevars` VALUES ('239', '1', 'Please select how you want the friendship request process to work. If you change this setting from \"Verified Friendships\" to \"Unverified Friendships\", all pending friendships will be automatically confirmed.', 'admin_connections, ');
INSERT INTO `se_languagevars` VALUES ('240', '1', 'Verified Friendships (Two-way)', 'admin_connections, ');
INSERT INTO `se_languagevars` VALUES ('241', '1', 'When UserA invites UserB to become friends, UserB is added to UserA\'s friend list and UserA is added to UserB\'s friend list after UserB confirms the friendship.', 'admin_connections, ');
INSERT INTO `se_languagevars` VALUES ('242', '1', 'Verified Friendships (One-way)', 'admin_connections, ');
INSERT INTO `se_languagevars` VALUES ('243', '1', 'When UserA invites UserB to become friends, UserB is added to UserA\'s friend list after UserB confirms the friendship.', 'admin_connections, ');
INSERT INTO `se_languagevars` VALUES ('244', '1', 'Unverified Friendships (Two-way)', 'admin_connections, ');
INSERT INTO `se_languagevars` VALUES ('245', '1', 'When UserA invites UserB to become friends, UserB is immediately listed in UserA\'s friend list, and UserA is immediately listed in UserB\'s friend list.', 'admin_connections, ');
INSERT INTO `se_languagevars` VALUES ('246', '1', 'Unverified Friendships (One-way)', 'admin_connections, ');
INSERT INTO `se_languagevars` VALUES ('247', '1', 'When UserA invites UserB to become friends, UserB is immediately listed in UserA\'s friend list.', 'admin_connections, ');
INSERT INTO `se_languagevars` VALUES ('248', '1', 'Friendship Types', 'admin_connections, ');
INSERT INTO `se_languagevars` VALUES ('249', '1', 'Add friendship types to allow your users to specify their varying degrees of friendships. Example friendship types include \"Acquaintance\", \"Co-Worker\", \"Best Friend\", \"Significant Other\", etc. If you only specify one friendship type or leave this area blank, users will not be prompted to specify a friendship type when connecting to other users.', 'admin_connections, ');
INSERT INTO `se_languagevars` VALUES ('250', '1', 'Add New Type', 'admin_connections, ');
INSERT INTO `se_languagevars` VALUES ('251', '1', 'Custom Friendship Types', 'admin_connections, ');
INSERT INTO `se_languagevars` VALUES ('252', '1', 'Allow users to specify a custom friendship type.', 'admin_connections, ');
INSERT INTO `se_languagevars` VALUES ('253', '1', 'Do not allow users to specify a custom friendship type.', 'admin_connections, ');
INSERT INTO `se_languagevars` VALUES ('254', '1', 'Friendship Explanation', 'admin_connections, ');
INSERT INTO `se_languagevars` VALUES ('255', '1', 'Allow users to provide an explanation of their friendships.', 'admin_connections, ');
INSERT INTO `se_languagevars` VALUES ('256', '1', 'Do not allow users to provide an explanation of their friendships.', 'admin_connections, ');
INSERT INTO `se_languagevars` VALUES ('257', '1', 'Your social network can have more than one administrator. This is useful if you want to have a staff of admins who maintain your social network. However, the first admin to be created (upon installation) is the \"superadmin\" and cannot be deleted. The superadmin can create and delete other admin accounts. All admin accounts on your system are listed below.', 'admin_viewadmins, ');
INSERT INTO `se_languagevars` VALUES ('258', '1', 'Name', 'help_contact, admin_viewadmins, admin_subnetworks, admin_levels_edit, admin_levels, admin_faq, admin_ads, ');
INSERT INTO `se_languagevars` VALUES ('259', '1', 'Status', 'admin_viewadmins, admin_ads, ');
INSERT INTO `se_languagevars` VALUES ('260', '1', 'Superadmin', 'admin_viewadmins, ');
INSERT INTO `se_languagevars` VALUES ('261', '1', 'Admin', 'admin_viewadmins, ');
INSERT INTO `se_languagevars` VALUES ('262', '1', 'Add Admin', 'admin_viewadmins, ');
INSERT INTO `se_languagevars` VALUES ('263', '1', 'Delete Admin', 'admin_viewadmins, ');
INSERT INTO `se_languagevars` VALUES ('264', '1', 'Are you sure you want to delete this admin?', 'admin_viewadmins, ');
INSERT INTO `se_languagevars` VALUES ('265', '1', 'Complete the form below to add/edit this admin account. Note that normal admins will not be able to delete or modify the superadmin account. If you want to change this admin\'s password, enter both the old and new passwords below - otherwise, leave them both blank.', 'admin_viewadmins, ');
INSERT INTO `se_languagevars` VALUES ('266', '1', 'Confirm Password', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('267', '1', 'The Old Password field must match this admin\'s old password.', 'admin_viewadmins, ');
INSERT INTO `se_languagevars` VALUES ('268', '1', 'The username you have entered is already in use by another admin.', '');
INSERT INTO `se_languagevars` VALUES ('269', '1', 'Old Password', 'user_account_pass, admin_viewadmins, ');
INSERT INTO `se_languagevars` VALUES ('270', '1', 'Edit Admin', 'admin_viewadmins, ');
INSERT INTO `se_languagevars` VALUES ('271', '1', 'If you want to put users into different groups with varying access to features (e.g. Bronze, Silver, and Gold membership plans), you can create multiple user groups. You must always have at least one group - your default group (which cannot be deleted). When users signup, they will be placed into the group you have designated as the default group on this page. You can change a user\'s group by editing their account from the <a href=\'admin_viewusers.php\'>View Users</a> page. If you want to give all users on your social network the same features and limits, you will only need one user level.', 'admin_levels, ');
INSERT INTO `se_languagevars` VALUES ('272', '1', 'Add User Level', 'admin_levels, ');
INSERT INTO `se_languagevars` VALUES ('273', '1', 'Users', 'admin_subnetworks, admin_levels, ');
INSERT INTO `se_languagevars` VALUES ('274', '1', 'user(s)', 'admin_levels, ');
INSERT INTO `se_languagevars` VALUES ('275', '1', 'To create a user level, complete the following form. Once it is created, you will be able to edit all the settings for this user level.', 'admin_levels, ');
INSERT INTO `se_languagevars` VALUES ('276', '1', 'Please specify a name for this user level.', 'admin_levels, ');
INSERT INTO `se_languagevars` VALUES ('277', '1', 'Description', 'admin_levels_edit, admin_levels, ');
INSERT INTO `se_languagevars` VALUES ('278', '1', 'Add Level', 'admin_levels, ');
INSERT INTO `se_languagevars` VALUES ('279', '1', 'Are you sure you want to delete this user level? Users in this level will be moved to the default user level.', 'admin_levels, ');
INSERT INTO `se_languagevars` VALUES ('280', '1', 'Delete User Level', 'admin_levels, ');
INSERT INTO `se_languagevars` VALUES ('281', '1', 'Edit User Level', 'admin_levels_edit, ');
INSERT INTO `se_languagevars` VALUES ('282', '1', 'You are currently editing this user level\'s settings. Remember, these settings only apply to the users that belong to this user level. When you\'re finished, you can edit the <a href=\'admin_levels.php\'>other levels here</a>.', 'admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, ');
INSERT INTO `se_languagevars` VALUES ('283', '1', 'To modify this user level, complete the following form.', 'admin_levels_edit, ');
INSERT INTO `se_languagevars` VALUES ('284', '1', 'Please specify a name for this user level.', 'admin_levels_edit, ');
INSERT INTO `se_languagevars` VALUES ('285', '1', 'Level Settings', 'admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, ');
INSERT INTO `se_languagevars` VALUES ('286', '1', 'User Settings', 'admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, ');
INSERT INTO `se_languagevars` VALUES ('287', '1', 'Message Settings', 'admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, ');
INSERT INTO `se_languagevars` VALUES ('288', '1', 'Editing User Level: %1$s', 'admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, ');
INSERT INTO `se_languagevars` VALUES ('289', '1', 'This page contains various settings that affect your users\' accounts.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('290', '1', 'Photo file types can only be gif, jpg, jpeg, or png.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('291', '1', 'Photo width and height must be integers between 1 and 999', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('292', '1', 'Can users block other users?', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('293', '1', 'If set to \"yes\", users can block other users from sending them private messages, requesting their friendship, and viewing their profile. This helps fight spam and network abuse.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('294', '1', 'Yes, users can block other users.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('295', '1', 'No, users cannot block other users.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('296', '1', 'Privacy Options', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('297', '1', 'Search Privacy Options', 'admin_levels_usersettings, admin_levels_albumsettings, ');
INSERT INTO `se_languagevars` VALUES ('298', '1', 'If you enable this feature, users will be able to exclude themselves from search results and the lists of users on the homepage (such as Recent Signups). Otherwise, all users will be included in search results.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('299', '1', 'Yes, allow users to exclude themselves from search results.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('300', '1', 'No, force all users to be included in search results.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('301', '1', 'Profile Privacy Options', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('302', '1', 'Your users can choose from any of the options checked below when they decide who can see their profile. If you do not check any options, everyone will be allowed to view profiles.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('303', '1', 'Profile Comment Options', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('304', '1', 'Your users can choose from any of the options checked below when they decide who can post comments on their profile. If you do not check any options, everyone will be allowed to post comments on profiles.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('305', '1', 'Allow User Photos?', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('306', '1', 'If you enable this feature, users can upload a small photo icon of themselves. This will be shown next to their name/username on their profiles, in search/browse results, next to their private messages, etc.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('307', '1', 'Yes, users can upload a photo.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('308', '1', 'No, users can not upload a photo.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('309', '1', 'If you have selected \"Yes\" above, please input the maximum dimensions for the user photos. If your users upload a photo that is larger than these dimensions, the server will attempt to scale them down automatically. This feature requires that your PHP server is compiled with support for the GD Libraries.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('310', '1', 'Maximum Width:', 'admin_levels_usersettings, admin_levels_albumsettings, ');
INSERT INTO `se_languagevars` VALUES ('311', '1', '(in pixels, between 1 and 999)', 'admin_levels_usersettings, admin_levels_albumsettings, ');
INSERT INTO `se_languagevars` VALUES ('312', '1', 'Maximum Height:', 'admin_levels_usersettings, admin_levels_albumsettings, ');
INSERT INTO `se_languagevars` VALUES ('313', '1', 'What file types do you want to allow for user photos (gif, jpg, jpeg, or png)? Separate file types with commas, i.e. <i>jpg, jpeg, gif, png</i>', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('314', '1', 'Allowed File Types:', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('315', '1', 'Allow custom CSS in profiles?', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('316', '1', 'Enable this feature if you want to allow users to customize the colors and fonts of their profiles with their own CSS styles.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('317', '1', 'Yes, users can add custom CSS styles to their profiles.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('318', '1', 'No, users cannot add custom CSS styles to their profiles.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('319', '1', 'Allow profile status messages?', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('320', '1', 'Enable this feature if you want to allow users to show their \"status\" on their profile. By updating their status, users can tell others what they are up to, what\'s on their minds, etc.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('321', '1', 'Yes, allow users to have a \"status\" message.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('322', '1', 'No, users cannot have a \"status\" message.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('323', '1', 'Everyone', 'user_account_privacy, admin_levels_usersettings, admin_levels_albumsettings, ');
INSERT INTO `se_languagevars` VALUES ('324', '1', 'All Registered Users', 'user_account_privacy, admin_levels_usersettings, admin_levels_albumsettings, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('325', '1', 'Only My Friends and Everyone within My Subnetwork', 'user_account_privacy, admin_levels_usersettings, admin_levels_albumsettings, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('326', '1', 'Only My Friends and Their Friends within My Subnetwork', 'user_account_privacy, admin_levels_usersettings, admin_levels_albumsettings, ');
INSERT INTO `se_languagevars` VALUES ('327', '1', 'Only My Friends', 'user_account_privacy, admin_levels_usersettings, admin_levels_albumsettings, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('328', '1', 'Only Me', 'user_account_privacy, admin_levels_usersettings, admin_levels_albumsettings, ');
INSERT INTO `se_languagevars` VALUES ('329', '1', 'Nobody', 'user_account_privacy, admin_levels_usersettings, admin_levels_albumsettings, ');
INSERT INTO `se_languagevars` VALUES ('330', '1', 'Facilitating user interactivity is the key to developing a successful social network. Allowing private messages between users is an excellent way to increase interactivity. From this page, you can enable the private messaging feature and configure its settings.', 'admin_levels_messagesettings, ');
INSERT INTO `se_languagevars` VALUES ('331', '1', 'Who can users send private messages to?', 'admin_levels_messagesettings, ');
INSERT INTO `se_languagevars` VALUES ('332', '1', 'If set to \"nobody\", none of the other settings on this page will apply. Otherwise, users will have access to their private message inbox and will be able to send each other messages.', 'admin_levels_messagesettings, ');
INSERT INTO `se_languagevars` VALUES ('333', '1', 'Nobody - users cannot send private messages.', 'admin_levels_messagesettings, ');
INSERT INTO `se_languagevars` VALUES ('334', '1', 'Friends only - users can send private messages to their friends only.', 'admin_levels_messagesettings, ');
INSERT INTO `se_languagevars` VALUES ('335', '1', 'Everyone - users can send private messages to anyone.', 'admin_levels_messagesettings, ');
INSERT INTO `se_languagevars` VALUES ('336', '1', 'Inbox/Outbox Capacity', 'admin_levels_messagesettings, ');
INSERT INTO `se_languagevars` VALUES ('337', '1', 'How many total conversations will users be allowed to store in their inbox and outbox? If a user\'s inbox or outbox is full and a new conversation is started, the oldest conversation will be automatically deleted.', 'admin_levels_messagesettings, ');
INSERT INTO `se_languagevars` VALUES ('338', '1', 'conversations in inbox folder.', 'admin_levels_messagesettings, ');
INSERT INTO `se_languagevars` VALUES ('339', '1', 'conversations in outbox folder.', 'admin_levels_messagesettings, ');
INSERT INTO `se_languagevars` VALUES ('340', '1', 'Use this page to invite new users to your social network. You can specify 10 email addresses at a time. If you have specified that users may signup by invitation only, this page will email an invitation code to the email addresses you specify. Otherwise, a simple invitation email will be sent. Both these emails can be modified on your <a href=\'admin_emails.php\'>System Emails</a> page.', 'admin_invite, ');
INSERT INTO `se_languagevars` VALUES ('341', '1', 'Invitations have been sent!', 'admin_invite, ');
INSERT INTO `se_languagevars` VALUES ('342', '1', 'Email Addresses', 'admin_invite, ');
INSERT INTO `se_languagevars` VALUES ('343', '1', 'Enter email addresses (max 10), separated by commas, in the field below.', 'admin_invite, ');
INSERT INTO `se_languagevars` VALUES ('344', '1', 'Create Advertising Campaign', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('345', '1', 'Follow this guide to design and launch a new advertising campaign.', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('346', '1', 'Advertisement Media', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('347', '1', 'Upload a banner image from your computer or specify your advertisement HTML code (e.g. Google Adsense). If you choose to upload an image, it must be a valid GIF, JPG, JPEG, or PNG file under 200kb.', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('348', '1', 'Upload Banner Image', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('349', '1', 'OR', 'signup, admin_language_edit, admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('350', '1', 'Insert Banner HTML', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('351', '1', 'Insert Banner HTML Code', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('352', '1', 'Save HTML Code & Preview', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('353', '1', 'Please insert your banner HTML before continuing.', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('354', '1', 'Banner Preview', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('355', '1', 'Save Banner', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('356', '1', 'Remove Banner', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('357', '1', 'Edit HTML', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('358', '1', 'Upload Banner Image', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('359', '1', 'File:', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('360', '1', 'Link URL:', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('361', '1', 'Upload Banner & Preview', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('362', '1', 'Please choose a file from your hard drive to upload.', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('363', '1', 'The file you specified failed to upload. Please make sure this is a valid image file and the /uploads_admin/ads directory is writeable on the server.', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('364', '1', 'Campaign Information', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('365', '1', 'Begin by naming this campaign and determining its start date and ending terms. If you select an ending date, the campaign will end immediately when that date is reached. If you specify a certain number of total views allowed or total clicks allowed, the campaign will end when that number of views or clicks is reached. If you specify a minimum CTR (click-through ratio, which is the ratio of clicks to views) and the campaign\'s CTR goes below your limit, the campaign will end. If you decide to specify a minimum CTR limit, you should enter it as a percentage of clicks to views (e.g. 0.05%). To create a campaign with no definite end, don\'t specify an end date or any other limits and your campaign will continue until you choose to end it.', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('366', '1', 'Note: Current date is %1$s', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('367', '1', 'Campaign Name:', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('368', '1', 'Start Date:', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('369', '1', 'End Date:', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('370', '1', 'Don\'t end this campaign on a specific date.', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('371', '1', 'End this campaign on a specific date.', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('372', '1', 'Total Views Allowed:', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('373', '1', 'Unlimited', 'admin_levels_albumsettings, admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('374', '1', 'Total Clicks Allowed:', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('375', '1', 'Minimum CTR:', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('376', '1', 'Select Placement Position', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('377', '1', 'Where on the page do you want your banners to display? You can place your banners at the very top of the page, just above the main content area, to the left of the content area, to the right of the content area, or at the very bottom of the page. Please note that this automatic placement will NOT work if you have removed the advertisement code Smarty variables from your header.tpl and footer.tpl files. Also note that if you select a position below, the banner will show up in that position on every page of the social network. You can insert banners on a single page (or a few pages) by following the manual insertion instructions below.', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('378', '1', 'If you want to have this advertisement display somewhere other than the site-wide positions shown above (e.g. within the content on a single page), you can insert the following code into any of your <a href=\'admin_templates.php\' target=\'_blank\'>templates</a> and it will display your advertisement once you\'ve created the campaign.', '');
INSERT INTO `se_languagevars` VALUES ('379', '1', 'Select Audience', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('380', '1', 'Specify which users will be shown advertisements from this campaign. To include the entire user population in this campaign, leave all of the <a href=\'admin_levels.php\' target=\'_blank\'>user levels</a> and <a href=\'admin_subnetworks.php\' target=\'_blank\'>subnetworks</a> selected. To select multiple user levels or subnetworks, use CTRL-click. Note that this advertising campaign will only be displayed to logged-in users that match both a user level <b>AND</b> a subnetwork you\'ve selected.', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('381', '1', 'Subnetworks', '');
INSERT INTO `se_languagevars` VALUES ('382', '1', '(signup default)', 'admin_announcements, admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('383', '1', 'Default Subnetwork', 'admin_announcements, admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('384', '1', 'Also show this advertisement to visitors that are not logged in.', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('385', '1', 'Create New Campaign', 'admin_ads_modify, admin_ads, ');
INSERT INTO `se_languagevars` VALUES ('386', '1', 'Please upload a banner or specify your advertisement HTML for this campaign.', '');
INSERT INTO `se_languagevars` VALUES ('387', '1', 'Please provide a name for this advertising campaign.', '');
INSERT INTO `se_languagevars` VALUES ('388', '1', 'Please provide a complete start date for this campaign.', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('389', '1', 'Please provide a complete end date for this campaign.', '');
INSERT INTO `se_languagevars` VALUES ('390', '1', 'Please select an end date that is later than your start date.', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('391', '1', 'Please provide a maximum number of views for this campaign. This must be an integer (e.g. 250000).', '');
INSERT INTO `se_languagevars` VALUES ('392', '1', 'Please provide a maximum number of clicks for this campaign. This must be an integer (e.g. 250).', '');
INSERT INTO `se_languagevars` VALUES ('393', '1', 'Please provide a minimum CTR limit in the form of a percentage of clicks to views (e.g. 1.50%). This value may not exceed 100%.', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('394', '1', 'Displaying advertisements is an excellent way to monetize your social network. By creating ad campaigns, you can determine exactly where your ads will appear, how long they will be displayed, and who they will be shown to. The key to generating substantial revenue from your social network is to create targeted ad campaigns. This means that you should make an effort to show specific ads to users based on their interests or personal characteristics (e.g. their profile information). To accomplish this, ad campaigns can be created for specific <a href=\'admin_levels.php\'>user levels</a> and/or <a href=\'admin_subnetworks.php\'>subnetworks</a>.', 'admin_ads, ');
INSERT INTO `se_languagevars` VALUES ('395', '1', 'Refresh Stats', 'admin_ads, ');
INSERT INTO `se_languagevars` VALUES ('396', '1', 'Views', 'admin_ads, ');
INSERT INTO `se_languagevars` VALUES ('397', '1', 'Clicks', 'admin_ads, ');
INSERT INTO `se_languagevars` VALUES ('398', '1', 'CTR', 'admin_ads, ');
INSERT INTO `se_languagevars` VALUES ('399', '1', 'pause', 'admin_ads, ');
INSERT INTO `se_languagevars` VALUES ('400', '1', 'unpause', 'admin_ads, ');
INSERT INTO `se_languagevars` VALUES ('401', '1', 'There are currently no advertising campaigns on your social network.', 'admin_ads, ');
INSERT INTO `se_languagevars` VALUES ('402', '1', 'Paused', 'admin_ads, ');
INSERT INTO `se_languagevars` VALUES ('403', '1', 'Active', 'admin_ads, ');
INSERT INTO `se_languagevars` VALUES ('404', '1', 'Waiting For Start Date', 'admin_ads, ');
INSERT INTO `se_languagevars` VALUES ('405', '1', 'Completed', 'admin_ads, ');
INSERT INTO `se_languagevars` VALUES ('406', '1', 'Delete Ad Campaign', 'admin_ads, ');
INSERT INTO `se_languagevars` VALUES ('407', '1', 'Are you sure you want to delete this ad campaign?', 'admin_ads, ');
INSERT INTO `se_languagevars` VALUES ('408', '1', 'Edit Advertising Campaign', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('409', '1', 'Edit this advertising campaign\'s details below.', 'admin_ads_modify, ');
INSERT INTO `se_languagevars` VALUES ('410', '1', 'The user signup process is a crucial element of your social network. You need to design a signup process that is user friendly but also gets the initial information you need from new users. On this page, you can configure your signup process.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('411', '1', 'Fields on Signup Page', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('412', '1', 'Your users will have an opportunity to begin filling out their profile when they signup. Below, you can specify which profile fields will appear on the signup page, and which will be required. Keep in mind that a lengthly signup process may deter some users from signing up to your social network. To add or delete profile fields, visit the <a href=\'admin_profile.php\'>Profile Fields</a> page.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('413', '1', 'User Photo Upload', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('414', '1', 'Do you want your users to be able to upload a photo of themselves upon signup?', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('415', '1', 'Yes, give users the option to upload a photo upon signup.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('416', '1', 'No, do not allow users to upload a photo upon signup.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('417', '1', 'Enable Users?', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('418', '1', 'If you have selected YES, users will automatically be enabled when they signup. If you select NO, you will need to manually enable users through the <a href=\'admin_viewusers.php\'>View Users</a> page. Users that are not enabled cannot login.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('419', '1', 'Yes, enable users upon signup.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('420', '1', 'No, do not enable users upon signup.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('421', '1', 'Send Welcome Email?', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('422', '1', 'Send users a welcome email upon signup? If you have email verification activated, this email will be sent upon verification. You can modify this email on the <a href=\'admin_emails.php\'>System Emails</a> page.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('423', '1', 'Yes, send users a welcome email.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('424', '1', 'No, do not send users a welcome email.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('425', '1', 'Invite Only?', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('426', '1', 'Do you want to turn off public signups and only allow invited users to signup? If yes, you can choose to have either admins and users invite new users, or just admins. If set to yes, an invite code will be required on the signup page.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('427', '1', 'Yes, admins and users must invite new users before they can signup.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('428', '1', 'Yes, admins must invite new users before they can signup.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('429', '1', 'No, disable the invite only feature.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('430', '1', 'Should each invite code be bound to each invited email address? If set to NO, anyone with a valid invite code can signup regardless of their email address. If set to YES, anyone with a valid invite code that matches an email address that was invited can signup.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('431', '1', 'Yes, check that a user\'s email address was invited before accepting their invite code.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('432', '1', 'No, anyone with an invite code can signup, regardless of their email address.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('433', '1', 'How many invites do users get when they signup? (If you want to give a particular user extra invites, you can do so via the <a href=\'admin_viewusers.php\'>View Users</a> page. Please enter a number between 0 and 999 below.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('434', '1', 'invites are given to each user when they signup.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('435', '1', 'Show \"Invite Friends\" Page?', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('436', '1', 'If you have selected YES, your users will be shown a page asking them to optionally invite one or more friends to signup. The \"invite friends\" feature is different from the \"invite only\" feature because \"invite friends\" simply sends an email to the invitee instead of sending them an actual invitation code. Because of this, you probably do not want to enable both \"invite friends\" and \"invite only\" features simultaneously.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('437', '1', 'Yes, show invite friends page.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('438', '1', 'No, do not show invite friends page.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('439', '1', 'Verify Email Address?', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('440', '1', 'Force users to verify their email address before they can login? If set to YES, users will be sent an email with a verification link which they must click to activate their account.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('441', '1', 'Yes, verify email addresses.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('442', '1', 'No, do not verify email addresses.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('443', '1', 'Require Users to Enter a Verification Code?', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('444', '1', 'If you have selected YES, an image containing a random sequence of 6 numbers will be shown to users on the signup page. Users will be required to enter these numbers into the Verification Code field before they can continue. This feature helps prevent users from trying to automatically create accounts on your system. For this feature to work properly, your server must have the GD Libraries (2.0 or higher) installed and configured to work with PHP. If you are seeing errors or users cannot signup, try turning this off.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('445', '1', 'Yes, show verification code image.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('446', '1', 'No, do not show verification code image.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('447', '1', 'Generate Random Passwords?', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('448', '1', 'If you have selected YES, a random password will be created for users when they signup. The password will be emailed to them upon the completion of the signup process. This is another method of verifying users\' email addresses.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('449', '1', 'Yes, generate random passwords and email to new users.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('450', '1', 'No, let users choose their own passwords.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('451', '1', 'Require users to agree to your terms of service?', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('452', '1', 'Note: If you have selected YES, users will be forced to click a checkbox during the signup process which signifies that they have read, understand, and agree to your terms of service. Enter your terms of service text in the field below. HTML is OK.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('453', '1', 'Yes, make users agree to your terms of service on signup.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('454', '1', 'No, users will not be shown a terms of service checkbox on signup.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('455', '1', 'There are no fields in this profile category.', 'admin_signup, ');
INSERT INTO `se_languagevars` VALUES ('456', '1', 'Some users prefer to have profile addresses (URLs) that are easier to remember, more visually appealing, and more search-engine friendly. By default, your users\' URLs will appear in the \"normal\" format as demonstrated below. If you want to give them \"subdirectory URLs\", your web server must be running Apache and have mod_rewrite installed.', 'admin_url, ');
INSERT INTO `se_languagevars` VALUES ('457', '1', 'URL Style', 'admin_url, ');
INSERT INTO `se_languagevars` VALUES ('458', '1', 'After you select a URL style and click the submit button below, you will be prompted with further instructions for enabling the URL style of your choice. Please follow these instructions carefully to ensure that your URLs are working properly.', 'admin_url, ');
INSERT INTO `se_languagevars` VALUES ('459', '1', '<b>Normal URLs</b><br>Profile URL: http://www.yourdomain.com/profile.php?user=username', 'admin_url, ');
INSERT INTO `se_languagevars` VALUES ('460', '1', '<b>Subdirectory URLs</b><br>Profile URL: http://www.yourdomain.com/username', 'admin_url, ');
INSERT INTO `se_languagevars` VALUES ('461', '1', 'Normal URLs', 'admin_url, ');
INSERT INTO `se_languagevars` VALUES ('462', '1', 'Subdirectory URLs', 'admin_url, ');
INSERT INTO `se_languagevars` VALUES ('463', '1', ' - (Need help? Review the instructions <a href=\'javascript:urlhelp();\'>here</a>.)', 'admin_url, ');
INSERT INTO `se_languagevars` VALUES ('464', '1', 'URL Settings Help', 'admin_url, ');
INSERT INTO `se_languagevars` VALUES ('465', '1', 'The system is now set to use subdirectory URLs, which require an .htaccess file in your SocialEngine root directory. Copy and paste the code in the following box into a blank text file named .htaccess, and place it into your SocialEngine root directory. This is the directory on your server in which you have installed SocialEngine.', 'admin_url, ');
INSERT INTO `se_languagevars` VALUES ('466', '1', 'Close', 'admin_url, admin_templates, admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('467', '1', 'You have complete control over the look and feel of your social network. The PHP code that powers your social network is completely separate from the HTML code used for presentation. Your HTML code is stored in the templates listed below, which can be edited directly on this page. To edit a template, simply click it\'s name.<br><br><b>About the template system:</b><br>The template system uses Smarty, which is the most advanced and renown third-party PHP templating system available. Although the templates are primarily HTML, some Smarty tags are used for various purposes. For help with the templating system, please visit the <a href=\'http://smarty.php.net\' target=\'_blank\'>Smarty</a> website. Note that many of the tags you will find in the templates are actually language variables. These are used to display bits of text that have been specified in your language pack. To change these bits of text, you must edit the language file you are using in the \"lang\" directory on your server.<br><br><b>Adding your website\'s header/footer wrapper:</b><br>The simplest way to integrate your social network into your main website is to copy your website\'s header/footer HTML and paste it into the \"Header/Footer Templates\" below. To make global changes to the CSS stylesheet, you can edit \"styles.css\".', 'admin_templates, ');
INSERT INTO `se_languagevars` VALUES ('468', '1', 'Logged-in User Pages', 'admin_templates, ');
INSERT INTO `se_languagevars` VALUES ('469', '1', 'Public Pages', 'admin_templates, ');
INSERT INTO `se_languagevars` VALUES ('470', '1', 'Header/Footer Templates', 'admin_templates, ');
INSERT INTO `se_languagevars` VALUES ('471', '1', 'Edit Template', 'admin_templates, ');
INSERT INTO `se_languagevars` VALUES ('472', '1', 'The HTML and Smarty code for this template is displayed below. After making your desired changes to the template, be sure to click the \"Save Changes\" button. For help with Smarty, see the <a href=\'http://smarty.php.net\' target=\'_blank\'>official website</a> and <a href=\'http://smarty.php.net/crashcourse.php\' target=\'_blank\'>crash course</a>.', 'admin_templates, ');
INSERT INTO `se_languagevars` VALUES ('473', '1', 'The file you specified is not a valid template file.', 'admin_templates, ');
INSERT INTO `se_languagevars` VALUES ('474', '1', 'The template you specified could not be found.', 'admin_templates, ');
INSERT INTO `se_languagevars` VALUES ('475', '1', 'The template you specified could not be read. Try setting full permissions (CHMOD 777) to this file and the templates directory.', 'admin_templates, ');
INSERT INTO `se_languagevars` VALUES ('476', '1', 'The template you specified is not writable. Try setting full permissions (CHMOD 777) to this file and the templates directory.', 'admin_templates, ');
INSERT INTO `se_languagevars` VALUES ('477', '1', 'Use this page to monitor network usage and traffic patterns. Begin by selecting one of the types of available statistics below.', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('478', '1', 'Quick Summary', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('479', '1', 'Visits/Impressions', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('480', '1', 'New Logins', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('481', '1', 'New Signups', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('482', '1', 'New Friendships', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('483', '1', 'Network Usage', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('484', '1', 'Other Stats', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('485', '1', 'Referring URLs', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('486', '1', 'Space Used', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('487', '1', 'Last Period', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('488', '1', 'Period:', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('489', '1', 'This Week (Daily)', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('490', '1', 'This Month (Daily)', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('491', '1', 'This Year (Monthly)', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('492', '1', 'Refresh', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('493', '1', 'Next Period', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('494', '1', 'URL', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('495', '1', 'These are the 100 most common referring URLs tracked from your <a href=\'../home.php\' target=\'_blank\'>home.php</a> file.<br>This indicates that most new traffic is coming from the following URLs.<br>Clearing the list periodically will give you fresh referrer data.', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('496', '1', 'clear now', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('497', '1', 'Hits', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('498', '1', 'The referrer URL list is currently empty.', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('499', '1', 'Uploaded Media:', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('500', '1', 'Database Size:', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('501', '1', 'Total Space Used (Estimated):', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('502', '1', 'Quick Network Statistics', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('503', '1', 'The following data is a quick snapshot of your social network.<br>The data does not include any items that have been deleted.', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('504', '1', 'Total Users:', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('505', '1', '%1$d users', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('506', '1', '%1$d messages', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('507', '1', '%1$d comments', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('508', '1', 'Page Views', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('510', '1', 'Hello, %1$s!', 'home, ');
INSERT INTO `se_languagevars` VALUES ('509', '1', '%1$s\'s Profile', 'user_friends_requests_outgoing, user_friends_requests, user_friends, search_advanced, search, profile, home, ');
INSERT INTO `se_languagevars` VALUES ('660', '1', 'Remember Me', 'login, home, ');
INSERT INTO `se_languagevars` VALUES ('512', '1', 'Week of', 'admin_stats, ');
INSERT INTO `se_languagevars` VALUES ('513', '1', 'This page allows you to change the content of email messages sent by the system.', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('514', '1', 'From Address', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('515', '1', 'Enter the name and email address you want the emails from the system to come from in the fields below.', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('516', '1', 'From Name:', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('517', '1', 'From Address:', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('518', '1', 'Invite Code Email', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('519', '1', 'This is the email that gets sent if you allow users to join by invite only.', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('520', '1', 'Subject', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_emails, admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('521', '1', 'Message', 'user_messages_new, help_contact, admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('523', '1', 'Invitation Email', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('524', '1', 'This is the email that gets sent when users invite their friends to join during the signup process.', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('526', '1', 'Verification Email', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('527', '1', 'This is the email that gets sent to users to verify their email addresses.', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('529', '1', 'New Password Email', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('530', '1', 'This is the email that gets sent if you have chosen to create a random password for users upon signup.', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('532', '1', 'Welcome Email', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('533', '1', 'This is the email that gets sent when a user signs up. Please note that if you have email verification enabled, the password variable is <b>not available</b>. This is due to the fact that passwords are securely encrypted upon signup and cannot be unencrypted when a user verifies their email address and the welcome email is sent.', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('535', '1', 'Lost Password Email', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('536', '1', 'This is the email that gets sent if a user forgets their password and requests to create a new one.', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('538', '1', 'Friend Request Email', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('539', '1', 'This is the email that gets sent to a user when they are added as a friend by another user.', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('541', '1', 'New Message Email', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('542', '1', 'This is the email that gets sent to a user when they receive a new message.', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('544', '1', 'New Profile Comment Email', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('545', '1', 'This is the email that gets sent to a user when a new comment is posted on their profile.', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('547', '1', 'The recent activity feed is an auto-updating list of actions that have recently occurred on your social network. This information is displayed (by default) on users\' \"My Home\" page. Also, each user\'s own personal activity list will be displayed on their profile page if enabled below. Please note that some of the settings here are not retroactive, meaning that changes you make here may not affect old feed items.', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('548', '1', 'Which actions do you want to include in the activity list?', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('549', '1', 'All of the possible actions that can appear in your recent activity feed are shown below. You can choose not to include them in the recent activity feed by unchecking the appropriate box, or you can alter their text. Note that some of the actions have variables that are replaced by the system (e.g. username, photo, comment). Also, note that installing new plugins may add new actions. Unchecking the designated checkbox will disable that action type, however any previously recorded actions of that type will not be deleted from the feed. You can also decide whether or not to allow users the option of disabling the activity feed type by checking or unchecking the appropriate box.<br><br><b>Note: If you are using more than one language on your social network, you can provide translations for these activity feed items on the <a href=\'admin_language.php\'>Language Settings</a> page.</b>', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('550', '1', 'Action Text', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('551', '1', 'Keyword', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('552', '1', 'How many actions should be stored about each user?', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('553', '1', 'How many recent actions do you want to store in the database for each user? A higher value will show more information about each user\'s activity, while a lower value will increase database performance. Note: If the number of actions you want to display on each user\'s profile is less than the number of actions you want to store in the database, you can edit the \"profile.tpl\" template file to limit the number of actions dispalyed.', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('554', '1', 'action(s) stored in the database and published on each user\'s profile page', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('555', '1', 'Feed Limits', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('556', '1', 'How many total actions do you want to display in the recent activity feed?', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('557', '1', 'action(s) published in the recent activity feed', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('558', '1', 'How long do want items to be visible in the recent activity feed? A shorter amount of time will generally result in a shorter list of actions. For small social networks, a longer time period may be more appropriate.', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('559', '1', 'minute(s)', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('560', '1', 'hour(s)', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('561', '1', 'day(s)', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('562', '1', 'week(s)', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('563', '1', 'month', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('564', '1', 'How many actions per user can be shown on the recent activity feed? It\'s important to have a nice mix of actions from various users on your social network, so here you can set a limit on the number of actions published about each user at any given time. For smaller social networks, a higher number of published actions per user might be more appropriate.', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('565', '1', 'action(s) published per user in the recent activity feed', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('566', '1', 'Should users be allowed to delete actions published about themselves?', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('567', '1', 'Do you want to give users the option of deleting actions published about themselves? This is generally an important freedom to give users because it helps to maintain their privacy.', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('568', '1', 'Yes, allow users to delete actions about themselves.', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('569', '1', 'No, users may not delete actions about themselves.', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('570', '1', 'Whose actions should users see in the recent activity list?', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('571', '1', 'When a user is looking at the recent activity feed, whose actions should they see? For smaller networks, it may make more sense to show recent actions from \"All Registered Users\" so the feed is quickly populated.', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('572', '1', 'Should users be able to prevent certain action types from being published?', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('573', '1', 'Do you want to allow users to prevent specific action types from being published about them? If yes, a setting will appear on your users\' account settings page allowing them to choose which action types to NOT publish in the recent activity feed.', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('574', '1', 'Yes, users can specify which action types will not be published about them.', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('575', '1', 'No, users cannot specify what actions will be published or not published about them.', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('576', '1', 'Include this action in the recent activity feed', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('577', '1', 'Display enable/disable option on user settings page', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('700001', '1', '<a href=\'profile.php?user=%1$s\'>%2$s</a> logged in.', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('700002', '1', '<a href=\'profile.php?user=%1$s\'>%2$s</a> updated their profile photo.<div class=\'recentaction_div_media\'>[media]</div>', 'user_home, profile, network, home, admin_viewusers_edit, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('700003', '1', '<a href=\'profile.php?user=%1$s\'>%2$s</a> updated their profile.', 'user_home, profile, network, home, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('700004', '1', '<a href=\'profile.php?user=%1$s\'>%2$s</a> posted a comment on <a href=\'profile.php?user=%3$s&v=comments\'>%4$s</a>\'s profile:<div class=\'recentaction_div\'>%5$s</div>', 'user_home, profile, network, home, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('700005', '1', '<a href=\'profile.php?user=%1$s\'>%2$s</a> and <a href=\'profile.php?user=%3$s\'>%4$s</a> are now friends.', 'user_home, profile, network, home, admin_viewusers_edit, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('700006', '1', '<a href=\'profile.php?user=%1$s\'>%2$s</a> signed up.', 'user_home, profile, network, home, admin_viewusers_edit, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('700007', '1', '<a href=\'profile.php?user=%1$s\'>%2$s</a> %3$s', 'user_home, profile, network, home, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('578', '1', 'Available Variables:', 'admin_emails, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('579', '1', 'MONTH', 'user_editprofile_style, user_editprofile_photo, user_editprofile, signup, search_advanced, admin_subnetworks, admin_signup, admin_profile, admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('580', '1', 'DAY', 'user_editprofile_style, user_editprofile_photo, user_editprofile, signup, search_advanced, admin_subnetworks, admin_signup, admin_profile, admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('581', '1', 'YEAR', 'user_editprofile_style, user_editprofile_photo, user_editprofile, signup, search_advanced, admin_subnetworks, admin_signup, admin_profile, admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('582', '1', 'There are no language variables in this language matching your search phrase.', 'admin_language_edit, ');
INSERT INTO `se_languagevars` VALUES ('583', '1', 'You can use announcements to get a message out to all the users on your social network. You can submit announcements via email or news items.', 'admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('584', '1', 'Send Email Announcement', 'admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('585', '1', 'Your announcement will be sent as an email to all of the users on your social network. If you have many users, this process may take some time to complete.', 'admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('586', '1', 'Post News Item', 'admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('587', '1', 'Your announcement will be posted on your social network portal page. Regardless of the size of your social network, this process is instantaneous. If you have posted any news items in the past, they will be listed below. If you have included HTML in your news items, it will not be rendered below but will display properly on your portal page.', 'admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('588', '1', 'Contents', 'admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('589', '1', 'Untitled', 'admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('590', '1', 'No Date Provided', 'admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('591', '1', 'move down', 'admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('592', '1', 'Post News Item', 'admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('593', '1', 'Please complete the following form to post your news item.', 'admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('594', '1', '(date will be displayed exactly as you enter it above)', 'admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('595', '1', '(HTML OK)', 'admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('596', '1', 'Save News Item', 'admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('597', '1', 'Edit News Item', 'admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('598', '1', 'Delete News Item', 'admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('599', '1', 'Are you sure you want to delete this news announcement?', 'admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('600', '1', 'Use this form to compose an email message to be sent to every registered user on the social network. When you click the send button below, the system will begin looping through the user database and emailing the message to each user. Increasing the number of emails per page will make the process complete more quickly. However, if your server is currently under stress or you\'re simply not concerned about time, selecting a lower number of emails per page will reduce the risk of a timeout.', 'admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('601', '1', 'From', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('602', '1', 'Emails Per Page', 'admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('603', '1', 'Recipients', 'admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('604', '1', 'Select which users will receive this email announcement. By default, all <a href=\'admin_levels.php\'>user levels</a> and <a href=\'admin_subnetworks.php\'>subnetworks</a> are selected - this means that every user on your social network will receive this announcement. Use CTRL-click to select or deselect multiple user levels or subnetworks. If a user matches any user level OR subnetwork you have selected here, they will receive this announcement.', 'admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('605', '1', 'Send Announcement', 'admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('606', '1', 'Please provide a message body for this announcement.', 'admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('607', '1', 'Please select at least one user level or subnetwork that will receive this announcement.', 'admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('608', '1', 'Emailing in Progress', 'admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('609', '1', 'Your announcement is being sent to users. Do not navigate away from this page until the process is complete. Please wait...', 'admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('610', '1', 'Emailing Complete', 'admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('611', '1', 'The emailing process has been completed. All users on your social network have been sent an email with your announcement.', 'admin_announcements, ');
INSERT INTO `se_languagevars` VALUES ('612', '1', 'Your social network has the ability to organize users into \"subnetworks\" based on profile information they have in common with each other. You can use this to limit access and privacy between subnetworks, display subnetwork-specific content in your templates, or to simply organize your users.', 'admin_subnetworks, ');
INSERT INTO `se_languagevars` VALUES ('613', '1', 'Show Detailed Instructions', 'admin_subnetworks, ');
INSERT INTO `se_languagevars` VALUES ('614', '1', '<b>Important:</b> The requirement fields you select must be set to \"Required on Signup\" on the <a href=\'admin_signup.php\'>Signup Settings</a> page. If they are not set to \"Required on Signup\", they may not appear during the signup process and users will not have an opportunity to fill them out. Because they have not filled out your requirement fields, they will automatically be placed in the \"Default Subnetwork\" until they fill out the fields. If you already have users in subnetworks on your social network and you change the requirement fields or the requirements of a specific subnetwork, users will remain in the same subnetworks (based on the original requirements or differentiation fields you had set) until their profile information is updated. All users that are not sorted into a subnetwork will be placed into the \"Default Subnetwork\" until their profile information is updated and matches the requirements of a different subnetwork. When a subnetwork is deleted, users within the deleted subnetwork will be moved into the \"Default Subnetwork\".<br><br><b>Example:</b> If you wanted to create two subnetworks - one for male users and one for female users - you must create a profile field called \"Gender\" and use it as your primary requirement field below. If you want to have four subnetworks - males in California, females in California, males outside California, females outside California - you should create a profile field called \"location\" and use it as your secondary requirement field. Then, create subnetworks with the appropriate requirements so that these four subnetworks are mutually exclusive.<br><br><b>Notes:</b> If you base your subnetworks on a Birthday (Age) field (such as older/younger than 18 years old), your users will not be automatically switched from one subnetwork (younger than 18 years old) to another (older than 18). They will need to update their profile. Alternatively, if you make your primary requirement field \"Profile Category\", be aware that your secondary requirement field may not apply to all profile categories and therefore may not be visible by some users.', 'admin_subnetworks, ');
INSERT INTO `se_languagevars` VALUES ('615', '1', 'Primary Requirement Field:', 'admin_subnetworks, ');
INSERT INTO `se_languagevars` VALUES ('616', '1', 'Email Address', 'user_account, admin_subnetworks, ');
INSERT INTO `se_languagevars` VALUES ('617', '1', 'Profile Category', 'admin_viewusers_edit, admin_subnetworks, ');
INSERT INTO `se_languagevars` VALUES ('618', '1', 'Secondary Requirement Field:', 'admin_subnetworks, ');
INSERT INTO `se_languagevars` VALUES ('619', '1', 'Update', 'admin_subnetworks, ');
INSERT INTO `se_languagevars` VALUES ('620', '1', 'Add New Subnetwork', 'admin_subnetworks, ');
INSERT INTO `se_languagevars` VALUES ('621', '1', 'Requirements', 'admin_subnetworks, ');
INSERT INTO `se_languagevars` VALUES ('622', '1', 'Default Subnetwork', 'admin_subnetworks, ');
INSERT INTO `se_languagevars` VALUES ('623', '1', 'Users Not In Another Subnetwork', 'admin_subnetworks, ');
INSERT INTO `se_languagevars` VALUES ('624', '1', 'Add Subnetwork', 'admin_subnetworks, ');
INSERT INTO `se_languagevars` VALUES ('625', '1', 'To create/modify a subnetwork, complete the following form. You will need to specify who can belong to this subnetwork. You can do this by creating requirements. Note that you must specify a requirement with regards to your primary requirement field. Requirements based on the secondary requirement field are optional. The use of wildcards (*) is accepted when using the \"is equal to (==)\" and \"is not equal to (!=)\" operators. String values (such as words and phrases) will NOT be case sensitive. Please make sure that subnetwork requirements are mutually exclusive; that is, make sure users can only be placed in one subnetwork based on the requirements you provide. If the requirements overlap with another subnetwork\'s requirements, users will be randomly placed into one of the overlapping subnetworks.', 'admin_subnetworks, ');
INSERT INTO `se_languagevars` VALUES ('626', '1', 'is equal to ( == )', 'admin_subnetworks, ');
INSERT INTO `se_languagevars` VALUES ('627', '1', 'is not equal to ( != )', 'admin_subnetworks, ');
INSERT INTO `se_languagevars` VALUES ('628', '1', 'is greater than ( > )', 'admin_subnetworks, ');
INSERT INTO `se_languagevars` VALUES ('629', '1', 'is less than ( < )', 'admin_subnetworks, ');
INSERT INTO `se_languagevars` VALUES ('630', '1', 'is greater than or equal to ( >= )', 'admin_subnetworks, ');
INSERT INTO `se_languagevars` VALUES ('631', '1', 'is less than or equal to ( <= )', 'admin_subnetworks, ');
INSERT INTO `se_languagevars` VALUES ('632', '1', 'And', '');
INSERT INTO `se_languagevars` VALUES ('633', '1', 'Please specify a name for this subnetwork.', 'admin_subnetworks, ');
INSERT INTO `se_languagevars` VALUES ('634', '1', 'You must specify a primary requirement.', 'admin_subnetworks, ');
INSERT INTO `se_languagevars` VALUES ('635', '1', 'Edit Subnetwork', 'admin_subnetworks, ');
INSERT INTO `se_languagevars` VALUES ('636', '1', 'Delete Subnetwork', 'admin_subnetworks, ');
INSERT INTO `se_languagevars` VALUES ('637', '1', 'Are you sure you want to delete this subnetwork? All users in this subnetwork will be moved to the default subnetwork.', 'admin_subnetworks, ');
INSERT INTO `se_languagevars` VALUES ('638', '1', 'The subnetwork you selected has been deleted.', 'admin_subnetworks, ');
INSERT INTO `se_languagevars` VALUES ('639', '1', 'An Error Has Occurred', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('640', '1', 'You do not have permission to view this page. The user whose page you are trying to view has placed you on their blocklist.', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('641', '1', 'Return', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('642', '1', 'Social Network', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('643', '1', 'Search:', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('644', '1', 'Go', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('645', '1', 'Home', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('646', '1', 'Search', 'user_friends, search, profile, ');
INSERT INTO `se_languagevars` VALUES ('647', '1', 'Invite', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('648', '1', 'Help', '');
INSERT INTO `se_languagevars` VALUES ('649', '1', 'Hello, %1$s', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('650', '1', 'Signup', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('651', '1', 'My Account', '');
INSERT INTO `se_languagevars` VALUES ('652', '1', 'Profile', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('653', '1', 'Friends', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('654', '1', 'Messages', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('655', '1', 'Settings', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('656', '1', 'You must be logged in to view this page. <a href=\'login.php\'>Click here</a> to login.', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('657', '1', 'This page is an example of what your social network\'s portal can look like. Various statistics about your social network can be displayed, as exemplified below. This gives users a convenient way to find the newest content and interesting people on your social network. You can also use this page to display news or any other content you place into the template. You can replace this text by going to the \"Language Settings\" page in your admin panel, opening your language pack, and editing the language phrase #657.', 'home, ');
INSERT INTO `se_languagevars` VALUES ('658', '1', 'Account Login', 'login, ');
INSERT INTO `se_languagevars` VALUES ('673', '1', 'Welcome to the social network! If you already have an account, you can login below.<br>If you don\'t have an account, you can <a href=\'signup.php\'>sign up here</a>!', 'login, ');
INSERT INTO `se_languagevars` VALUES ('674', '1', '<br>If you are still waiting to receive your verification email, <a href=\'signup_verify.php?task=resend\'>click here</a> to resend it.', 'login, ');
INSERT INTO `se_languagevars` VALUES ('659', '1', 'Member Login', 'home, ');
INSERT INTO `se_languagevars` VALUES ('511', '1', 'Network Statistics', 'home, ');
INSERT INTO `se_languagevars` VALUES ('661', '1', 'Members: %1$d members', 'home, ');
INSERT INTO `se_languagevars` VALUES ('662', '1', 'Friendships: %1$d friends', 'home, ');
INSERT INTO `se_languagevars` VALUES ('663', '1', 'Comments: %1$d comments', 'home, ');
INSERT INTO `se_languagevars` VALUES ('664', '1', 'Recent News', 'user_home, home, ');
INSERT INTO `se_languagevars` VALUES ('665', '1', 'People Online', 'user_home, home, ');
INSERT INTO `se_languagevars` VALUES ('666', '1', 'Newest Members', 'network, home, ');
INSERT INTO `se_languagevars` VALUES ('667', '1', 'No members have signed up yet.', 'home, ');
INSERT INTO `se_languagevars` VALUES ('668', '1', 'Popular Members', 'home, ');
INSERT INTO `se_languagevars` VALUES ('669', '1', '%1$d friends', 'home, ');
INSERT INTO `se_languagevars` VALUES ('670', '1', 'No members have become friends yet.', 'home, ');
INSERT INTO `se_languagevars` VALUES ('671', '1', 'Members Last Logged In', 'home, ');
INSERT INTO `se_languagevars` VALUES ('672', '1', 'No members have logged in yet.', 'home, ');
INSERT INTO `se_languagevars` VALUES ('675', '1', 'Forgot password?', 'login, ');
INSERT INTO `se_languagevars` VALUES ('676', '1', 'The login details you provided were invalid. Please try again.', 'login, ');
INSERT INTO `se_languagevars` VALUES ('677', '1', 'The administrator has disabled your account.', '');
INSERT INTO `se_languagevars` VALUES ('678', '1', 'You have not yet verified your email address. If you would like to have the email resent to you, please <a href=\'signup_verify.php?task=resend\'>click here</a>.', '');
INSERT INTO `se_languagevars` VALUES ('679', '1', 'Create Your Account', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('680', '1', 'Welcome to the social network! To create your account, please provide the following information.', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('681', '1', 'Login Information', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('682', '1', 'You will use your email address to login.', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('683', '1', 'Enter your password again for confirmation.', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('684', '1', 'Account Information', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('685', '1', 'This is the name others see when they view your profile. If you decide to change your username, you must enter one that has not already been taken by another person.', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('686', '1', 'This will be the name people see when they view your profile.', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('687', '1', 'Language', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('688', '1', 'Security Information', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('689', '1', 'Invitation Code', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('690', '1', 'Security Code', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('691', '1', 'Enter the numbers you see in this image into the field to its left. This helps keep our site free of spam. If you have trouble reading the code, click it to generate a new one.', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('692', '1', 'I have read and agree to the <a href=\'help_tos.php\' target=\'_blank\'>terms of service</a>.', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('693', '1', 'Continue...', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('694', '1', 'Please ensure your username is alphanumeric.', '');
INSERT INTO `se_languagevars` VALUES ('695', '1', 'The username you selected is banned. Please choose another.', '');
INSERT INTO `se_languagevars` VALUES ('696', '1', 'The username you selected is reserved. Please choose another.', '');
INSERT INTO `se_languagevars` VALUES ('697', '1', 'The email address you provided is banned. Please provide another.', '');
INSERT INTO `se_languagevars` VALUES ('698', '1', 'The email address you provided is not a valid email address.', 'help_contact, ');
INSERT INTO `se_languagevars` VALUES ('699', '1', 'The username you selected has already been taken. Please choose another.', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('700', '1', 'The email address you provided has already been taken. Please provide another.', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('701', '1', 'The old password you provided is incorrect. Please try again.', 'user_account_pass, ');
INSERT INTO `se_languagevars` VALUES ('702', '1', 'Please be sure you have provided the same password in both new password fields.', 'lostpass_reset, ');
INSERT INTO `se_languagevars` VALUES ('703', '1', 'Please provide a password with at least 6 letters or numbers.', 'lostpass_reset, ');
INSERT INTO `se_languagevars` VALUES ('704', '1', 'Please ensure your password is alphanumeric.', 'lostpass_reset, ');
INSERT INTO `se_languagevars` VALUES ('705', '1', 'The invite code and email address combination you have entered is invalid.', '');
INSERT INTO `se_languagevars` VALUES ('706', '1', 'The invite code you have entered is invalid.', '');
INSERT INTO `se_languagevars` VALUES ('707', '1', 'You must agree to the terms of service to signup.', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('708', '1', 'Please make sure you have correctly entered the verification code.', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('709', '1', 'Account Type', 'user_account, signup, ');
INSERT INTO `se_languagevars` VALUES ('710', '1', 'Create Your Profile', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('711', '1', 'Tell us a little more about yourself. Fields marked with an asterisk (*) are required.', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('800002', '1', 'Reporting Abuse', 'help, admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('712', '1', 'Upload Your Photo', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('713', '1', 'Upload a photo of yourself from your computer. This will be the icon other people will see on your profile.', 'user_editprofile_photo, signup, ');
INSERT INTO `se_languagevars` VALUES ('714', '1', 'Upload', 'user_editprofile_photo, signup, ');
INSERT INTO `se_languagevars` VALUES ('715', '1', 'To upload your photo, click the \"Browse\" button, locate the photo on your computer, and click the \"Upload\" button. Your photo must be less than 4 MB in size and must be one of these types:', 'user_editprofile_photo, signup, ');
INSERT INTO `se_languagevars` VALUES ('716', '1', 'Keep This Photo', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('717', '1', 'Skip This Step', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('718', '1', 'Upload failed. Please try again. If this problem persists, please contact the administrator for assistance.', '');
INSERT INTO `se_languagevars` VALUES ('719', '1', 'The size of your uploaded file is greater than the maximum allowed filesize.', '');
INSERT INTO `se_languagevars` VALUES ('720', '1', 'Your file\'s filetype is not allowed.', '');
INSERT INTO `se_languagevars` VALUES ('721', '1', 'Your image\'s dimensions are greater than the maximum allowed width and height.', '');
INSERT INTO `se_languagevars` VALUES ('722', '1', 'Invite Your Friends', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('723', '1', 'Invite your friends to join! Enter the email addresses of your friends separated by commas in the field below.', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('724', '1', 'Send Invitations To:', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('725', '1', 'Enter your friends\' email addresses (up to 5) below, separated by commas.', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('726', '1', 'Your Message', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('727', '1', 'If you want to include a personal message in your invitations, enter it here. (optional)', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('728', '1', 'Send Invitations', 'signup, invite, ');
INSERT INTO `se_languagevars` VALUES ('729', '1', 'Signup Complete!', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('730', '1', 'Congratulations! You have successfully created your account.', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('731', '1', 'You will be able to login after you have been approved by an administrator.', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('732', '1', 'Your password has been sent to the email address you provided.', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('733', '1', 'Click the button below to login.', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('734', '1', 'An email has been sent to the email address you provided. Please follow the link in that email to verify your email address.', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('735', '1', 'Return to Home', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('736', '1', '(Age)', 'search_advanced, admin_subnetworks, ');
INSERT INTO `se_languagevars` VALUES ('737', '1', 'What\'s New?', 'user_home, home, ');
INSERT INTO `se_languagevars` VALUES ('738', '1', 'There has not been any recent activity on the social network.', 'user_home, network, ');
INSERT INTO `se_languagevars` VALUES ('739', '1', 'Profile Stats', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('740', '1', '%1$d profile views', 'user_home, profile, ');
INSERT INTO `se_languagevars` VALUES ('741', '1', 'reset', 'user_home, ');
INSERT INTO `se_languagevars` VALUES ('742', '1', 'My Status', 'user_home, ');
INSERT INTO `se_languagevars` VALUES ('743', '1', 'Update your status.', 'user_home, profile, ');
INSERT INTO `se_languagevars` VALUES ('744', '1', 'is', 'user_home, profile, ');
INSERT INTO `se_languagevars` VALUES ('745', '1', 'update', 'user_home, profile, ');
INSERT INTO `se_languagevars` VALUES ('746', '1', 'save', 'user_home, profile, ');
INSERT INTO `se_languagevars` VALUES ('747', '1', 'cancel', 'user_home, profile, ');
INSERT INTO `se_languagevars` VALUES ('748', '1', 'The email you have entered was not found in the database. Please try again.', '');
INSERT INTO `se_languagevars` VALUES ('749', '1', 'Send Password', 'lostpass, ');
INSERT INTO `se_languagevars` VALUES ('750', '1', 'This link is invalid or expired. Please <a href=\'lostpass.php\'>resubmit</a> your password request and follow the link sent to your email address.', '');
INSERT INTO `se_languagevars` VALUES ('751', '1', 'Your password has been reset. <a href=\'login.php\'>Click here</a> to login.', 'lostpass_reset, ');
INSERT INTO `se_languagevars` VALUES ('752', '1', 'FAQ', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('753', '1', 'Terms of Service', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('754', '1', 'Contact Us', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('755', '1', 'Account Settings', 'user_account, ');
INSERT INTO `se_languagevars` VALUES ('756', '1', 'Change Password', 'user_account_privacy, user_account_pass, user_account_delete, user_account, ');
INSERT INTO `se_languagevars` VALUES ('757', '1', 'Delete Account', 'user_account_privacy, user_account_pass, user_account_delete, user_account, ');
INSERT INTO `se_languagevars` VALUES ('758', '1', 'If you want to change your account password, please complete the following form.', 'user_account_pass, ');
INSERT INTO `se_languagevars` VALUES ('759', '1', 'Delete Account?', 'user_account_delete, ');
INSERT INTO `se_languagevars` VALUES ('760', '1', 'Are you sure you want to delete your account? All of your account data, including any files you have uploaded, will be permanently deleted! Upon deletion of your account, you will be automatically logged out.', 'user_account_delete, ');
INSERT INTO `se_languagevars` VALUES ('761', '1', 'Delete My Account', 'user_account_delete, ');
INSERT INTO `se_languagevars` VALUES ('762', '1', 'Photo', 'user_editprofile_style, user_editprofile_photo, user_editprofile, ');
INSERT INTO `se_languagevars` VALUES ('763', '1', 'Profile Style', 'user_editprofile_style, user_editprofile_photo, user_editprofile, ');
INSERT INTO `se_languagevars` VALUES ('764', '1', 'Edit Profile: %1$s', 'user_editprofile, ');
INSERT INTO `se_languagevars` VALUES ('765', '1', 'Please provide some information about yourself.', 'user_editprofile, ');
INSERT INTO `se_languagevars` VALUES ('766', '1', 'Changing this field may change which network you belong to.<br>You currently belong to: %1$s', 'user_editprofile, user_account, ');
INSERT INTO `se_languagevars` VALUES ('767', '1', 'Your network has been changed from %1$s to %2$s.', 'user_editprofile, ');
INSERT INTO `se_languagevars` VALUES ('768', '1', 'Status', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('769', '1', 'Edit My Photo', 'user_editprofile_photo, ');
INSERT INTO `se_languagevars` VALUES ('770', '1', 'Current Photo', 'user_editprofile_photo, ');
INSERT INTO `se_languagevars` VALUES ('771', '1', 'remove photo', 'user_editprofile_photo, ');
INSERT INTO `se_languagevars` VALUES ('772', '1', 'Upload Photo', 'user_editprofile_photo, ');
INSERT INTO `se_languagevars` VALUES ('773', '1', '%1$d second(s) ago', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_lostpass_reset, admin_lostpass, admin_login, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_fields, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('774', '1', '%1$d minute(s) ago', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_lostpass_reset, admin_lostpass, admin_login, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_fields, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('775', '1', '%1$d hour(s) ago', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_lostpass_reset, admin_lostpass, admin_login, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_fields, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('776', '1', '%1$d day(s) ago', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_lostpass_reset, admin_lostpass, admin_login, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_fields, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('777', '1', '%1$d week(s) ago', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_lostpass_reset, admin_lostpass, admin_login, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_fields, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('778', '1', '%1$d month(s) ago', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_lostpass_reset, admin_lostpass, admin_login, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_fields, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('779', '1', '%1$d year(s) ago', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_lostpass_reset, admin_lostpass, admin_login, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_fields, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('780', '1', 'Inbox', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('781', '1', 'Sent Messages', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('782', '1', 'My Message Inbox', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('783', '1', 'You have %1$s unread conversation(s) in your inbox.', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('784', '1', 'Compose New Message', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('785', '1', 'Your inbox is empty. When you receive messages in the future, they will be listed here.', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('786', '1', '%1$s\'s Profile', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('787', '1', 'reply', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('788', '1', 'Delete Selected', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_viewusers, admin_viewreports, ');
INSERT INTO `se_languagevars` VALUES ('789', '1', 'Create your new message with the form below.<br>You can specify multiple recipients (up to %1$d) - you can either select a friend from the autosuggestion area or simply type a user\'s name and press Enter.', 'user_messages_new, ');
INSERT INTO `se_languagevars` VALUES ('790', '1', 'To', 'user_messages_outbox, user_messages_new, ');
INSERT INTO `se_languagevars` VALUES ('791', '1', 'Send Message', 'user_messages_view, user_messages_new, ');
INSERT INTO `se_languagevars` VALUES ('792', '1', 'Maximum Recipients', 'admin_levels_messagesettings, ');
INSERT INTO `se_languagevars` VALUES ('793', '1', 'How many recipients can a user send a message to at one time?', 'admin_levels_messagesettings, ');
INSERT INTO `se_languagevars` VALUES ('794', '1', 'recipient(s) at a time', 'admin_levels_messagesettings, ');
INSERT INTO `se_languagevars` VALUES ('795', '1', 'Please enter a valid recipient.', '');
INSERT INTO `se_languagevars` VALUES ('796', '1', 'You must enter a message.', 'user_messages_view, ');
INSERT INTO `se_languagevars` VALUES ('797', '1', 'My Sent Messages', 'user_messages_outbox, ');
INSERT INTO `se_languagevars` VALUES ('798', '1', 'You have %1$d total message(s) in your outbox.', 'user_messages_outbox, ');
INSERT INTO `se_languagevars` VALUES ('799', '1', 'Your outbox is empty. When you send messages in the future, they will be listed here.', 'user_messages_outbox, ');
INSERT INTO `se_languagevars` VALUES ('800', '1', '%1$s recipients', 'user_messages_outbox, ');
INSERT INTO `se_languagevars` VALUES ('801', '1', 'Between %1$s and You', 'user_messages_view, ');
INSERT INTO `se_languagevars` VALUES ('802', '1', 'Reply:', 'user_messages_view, ');
INSERT INTO `se_languagevars` VALUES ('803', '1', 'Reply All:', 'user_messages_view, ');
INSERT INTO `se_languagevars` VALUES ('804', '1', 'Your message has been sent!', 'user_messages_new, ');
INSERT INTO `se_languagevars` VALUES ('805', '1', 'Back to Inbox', 'user_messages_view, ');
INSERT INTO `se_languagevars` VALUES ('806', '1', 'Back to Outbox', 'user_messages_view, ');
INSERT INTO `se_languagevars` VALUES ('807', '1', 'You do not have permission to view this page. You have been banned from the network.', '');
INSERT INTO `se_languagevars` VALUES ('808', '1', 'If necessary, you can make changes to your account settings below.', 'user_account, ');
INSERT INTO `se_languagevars` VALUES ('809', '1', 'This is the name others see when they view your profile. If you decide to change your username, you must enter one that has not already been taken by another person.', 'user_account, ');
INSERT INTO `se_languagevars` VALUES ('810', '1', 'Note that changing your username will clear your recent activity feed.', 'user_account, ');
INSERT INTO `se_languagevars` VALUES ('811', '1', 'Recent Activity Privacy', 'user_account_privacy, ');
INSERT INTO `se_languagevars` VALUES ('812', '1', 'Which of the following things do you want to have published about you in the <a href=\'user_home.php\'>recent activity feed</a>?<br>Note that changing this setting will only affect future news feed items.', 'user_account_privacy, ');
INSERT INTO `se_languagevars` VALUES ('813', '1', 'Block List', 'user_account_privacy, ');
INSERT INTO `se_languagevars` VALUES ('814', '1', 'Adding a person to your block list makes your profile (and all of your other content) unviewable to them. Any connections you have to the blocked person will be canceled. To add someone to your block list, click the \"Add New Person\" link and enter their username. If you enter a username of someone that does not exist or has been deleted, they will not be added to your block list.', 'user_account_privacy, ');
INSERT INTO `se_languagevars` VALUES ('815', '1', 'Add New Person', 'user_account_privacy, ');
INSERT INTO `se_languagevars` VALUES ('700008', '1', 'Logging in.', '');
INSERT INTO `se_languagevars` VALUES ('700009', '1', 'Changing profile photo.', 'user_home, user_account_privacy, ');
INSERT INTO `se_languagevars` VALUES ('700010', '1', 'Editing profile', 'user_home, user_account_privacy, ');
INSERT INTO `se_languagevars` VALUES ('700011', '1', 'Posting a profile comment.', 'user_home, user_account_privacy, ');
INSERT INTO `se_languagevars` VALUES ('700012', '1', 'Adding a friend', 'user_home, user_account_privacy, ');
INSERT INTO `se_languagevars` VALUES ('700013', '1', 'Signing Up.', 'user_home, ');
INSERT INTO `se_languagevars` VALUES ('700014', '1', 'Changing status.', 'user_home, user_account_privacy, ');
INSERT INTO `se_languagevars` VALUES ('816', '1', 'Your changes have been saved. Before your new email becomes active, you must follow the link in the email sent to you.', '');
INSERT INTO `se_languagevars` VALUES ('817', '1', 'Your changes have been saved. Before your new email becomes active, you must follow the link in the email sent to you. Once you verify your email address, your network will be changed from %1$s to %1$s.', '');
INSERT INTO `se_languagevars` VALUES ('818', '1', 'Waiting for verification for %1$s.', 'user_account, ');
INSERT INTO `se_languagevars` VALUES ('819', '1', 'Your changes have been saved and your network has been changed from %1$s to %2$s.', '');
INSERT INTO `se_languagevars` VALUES ('820', '1', 'Allow username change?', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('821', '1', 'Enable this feature if you want to allow your users to be able to change their username. Note that if you have usernames disabled on the <a href=\'admin_general.php\'>General Settings</a> page, this feature is irrelevant.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('822', '1', 'Yes, allow users to change their username.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('823', '1', 'No, do not allow users to change their username.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('824', '1', 'Allow account deletion?', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('825', '1', 'Enable this feature if you would like to allow your users to delete their account manually.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('826', '1', 'Yes, allow users to delete their account.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('827', '1', 'No, do not allow users to delete their account.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('828', '1', 'The profile you are looking for has been deleted or does not exist.', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('829', '1', 'Write Something...', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('830', '1', 'Posting...', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('831', '1', 'Please enter a message.', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('832', '1', 'You have entered the wrong security code.', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('833', '1', 'Post Comment', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('834', '1', 'message', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('835', '1', 'Anonymous', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('836', '1', 'View %1$s\'s Friends', 'user_friends, ');
INSERT INTO `se_languagevars` VALUES ('837', '1', 'Remove from My Friends', 'user_friends, profile, ');
INSERT INTO `se_languagevars` VALUES ('838', '1', 'Add to My Friends', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('839', '1', 'Send Message', 'user_friends_requests_outgoing, user_friends_requests, user_friends, profile, help_contact, ');
INSERT INTO `se_languagevars` VALUES ('840', '1', 'Report this Person', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('841', '1', 'Unblock this Person', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('842', '1', 'Block this Person', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('843', '1', 'Private Profile', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('844', '1', 'You do not have permission to view this profile.', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('845', '1', '%1$s is online.', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('846', '1', 'Profile Views:', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('847', '1', 'Friends:', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('848', '1', '%1$d friends', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('849', '1', 'Updated', 'user_friends_requests_outgoing, user_friends_requests, user_friends, profile, ');
INSERT INTO `se_languagevars` VALUES ('850', '1', 'Signup Date:', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('851', '1', 'Recent Activity', 'profile, admin_viewusers_edit, ');
INSERT INTO `se_languagevars` VALUES ('852', '1', '%1$d years old', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('853', '1', 'view all friends', '');
INSERT INTO `se_languagevars` VALUES ('854', '1', 'Comments', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('855', '1', 'view all comments', '');
INSERT INTO `se_languagevars` VALUES ('856', '1', 'Enter the numbers you see to the left. If you have trouble reading the numbers, click them to generate new ones.', 'profile, invite, ');
INSERT INTO `se_languagevars` VALUES ('857', '1', 'Notify an Administrator', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('858', '1', 'Please complete the following form to notify the administration of this page.', 'user_report, ');
INSERT INTO `se_languagevars` VALUES ('859', '1', 'What are you reporting?', 'user_report, ');
INSERT INTO `se_languagevars` VALUES ('860', '1', 'Spam', 'user_report, admin_viewreports, ');
INSERT INTO `se_languagevars` VALUES ('861', '1', 'Inappropriate Content', 'user_report, admin_viewreports, ');
INSERT INTO `se_languagevars` VALUES ('862', '1', 'Abuse', 'user_report, admin_viewreports, ');
INSERT INTO `se_languagevars` VALUES ('863', '1', 'Other', 'user_report, user_friends_manage, admin_viewreports, ');
INSERT INTO `se_languagevars` VALUES ('864', '1', 'Please give us a short description of the problem.', 'user_report, ');
INSERT INTO `se_languagevars` VALUES ('865', '1', 'Send Report', 'user_report, ');
INSERT INTO `se_languagevars` VALUES ('866', '1', 'Thank you for your report. We have received it and will process it as soon as possible.', 'user_report, ');
INSERT INTO `se_languagevars` VALUES ('867', '1', 'You have successfully unblocked %1$s.', 'user_friends_block, ');
INSERT INTO `se_languagevars` VALUES ('868', '1', 'Block User', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('869', '1', 'Unblock User', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('870', '1', 'Are you sure you want to unblock %1$s?', 'user_friends_block, ');
INSERT INTO `se_languagevars` VALUES ('871', '1', 'Unblock', 'user_friends_block, ');
INSERT INTO `se_languagevars` VALUES ('872', '1', 'You have successfully blocked %1$s.', 'user_friends_block, ');
INSERT INTO `se_languagevars` VALUES ('873', '1', 'Are you sure you want to block %1$s?', 'user_friends_block, ');
INSERT INTO `se_languagevars` VALUES ('874', '1', 'Block', 'user_friends_block, ');
INSERT INTO `se_languagevars` VALUES ('875', '1', 'Awaiting Friendship Confirmation', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('876', '1', 'Add to My Friends', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('877', '1', 'Are you sure you want to remove %1$s from your friends?', 'user_friends_manage, ');
INSERT INTO `se_languagevars` VALUES ('878', '1', 'A message has been sent to this user to confirm your friendship.', 'user_friends_manage, ');
INSERT INTO `se_languagevars` VALUES ('879', '1', 'This user has been added to your friendlist.', 'user_friends_manage, ');
INSERT INTO `se_languagevars` VALUES ('880', '1', 'You are about to add %1$s to your friends. If you add this person to your friends, they will be able to see your profile (even if it\'s viewable by friends only). Are you sure you want to add %1$s to your friends?', 'user_friends_manage, ');
INSERT INTO `se_languagevars` VALUES ('881', '1', 'Tell us more about how you know %1$s.', 'user_friends_manage, ');
INSERT INTO `se_languagevars` VALUES ('882', '1', 'Friend Type:', 'user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends, profile, ');
INSERT INTO `se_languagevars` VALUES ('883', '1', 'How do you know this person?', 'user_friends_manage, ');
INSERT INTO `se_languagevars` VALUES ('884', '1', 'Add Friend', 'user_friends_manage, ');
INSERT INTO `se_languagevars` VALUES ('885', '1', 'Confirm Pending Friend Request', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('886', '1', 'This user\'s friendship request has been confirmed.', '');
INSERT INTO `se_languagevars` VALUES ('887', '1', 'Confirm Friend Request', 'user_friends_requests_outgoing, user_friends_requests, user_friends_manage, profile, ');
INSERT INTO `se_languagevars` VALUES ('888', '1', 'Are you sure you want to confirm %1$s\'s friendship request?', 'user_friends_manage, ');
INSERT INTO `se_languagevars` VALUES ('889', '1', 'Remove Friend', 'user_friends_manage, user_friends, ');
INSERT INTO `se_languagevars` VALUES ('890', '1', 'This user has been removed from your friendlist.', '');
INSERT INTO `se_languagevars` VALUES ('892', '1', 'HTML in Comments', 'admin_general, ');
INSERT INTO `se_languagevars` VALUES ('891', '1', 'Wall-to-Wall', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('893', '1', 'By default, the user may not enter any HTML tags into comments. If you want to allow specific tags, you can enter them below (separated by commas). Example: <i>b, img, a, embed, font<i>', 'admin_general, ');
INSERT INTO `se_languagevars` VALUES ('894', '1', 'Current Friends', 'user_friends_requests_outgoing, user_friends_requests, user_friends, ');
INSERT INTO `se_languagevars` VALUES ('895', '1', 'Friend Requests', 'user_friends_requests_outgoing, user_friends_requests, user_friends, ');
INSERT INTO `se_languagevars` VALUES ('896', '1', 'Outgoing Friend Requests', 'user_friends_requests_outgoing, user_friends_requests, user_friends, ');
INSERT INTO `se_languagevars` VALUES ('897', '1', 'My Friends', 'user_friends, ');
INSERT INTO `se_languagevars` VALUES ('898', '1', 'Everyone currently on your friend list is shown here. To search for a specific friend, enter a keyword in the field below.', 'user_friends, ');
INSERT INTO `se_languagevars` VALUES ('899', '1', 'Search my friends:', 'user_friends, ');
INSERT INTO `se_languagevars` VALUES ('900', '1', 'Sort by:', 'user_friends, ');
INSERT INTO `se_languagevars` VALUES ('901', '1', 'Recently Updated', 'user_friends, ');
INSERT INTO `se_languagevars` VALUES ('902', '1', 'Recently Logged-In', 'user_friends, ');
INSERT INTO `se_languagevars` VALUES ('903', '1', 'Friend Type', 'user_friends, ');
INSERT INTO `se_languagevars` VALUES ('904', '1', 'Your friend list is empty.', 'user_friends, ');
INSERT INTO `se_languagevars` VALUES ('905', '1', 'None of your friends match your search criteria.', 'user_friends, ');
INSERT INTO `se_languagevars` VALUES ('906', '1', 'Last Login:', 'user_friends_requests_outgoing, user_friends_requests, user_friends, ');
INSERT INTO `se_languagevars` VALUES ('907', '1', 'Details:', 'user_friends_requests_outgoing, user_friends_requests, user_friends, profile, ');
INSERT INTO `se_languagevars` VALUES ('908', '1', 'Edit Friendship', 'user_friends, ');
INSERT INTO `se_languagevars` VALUES ('909', '1', 'When other people request to become your friend, their requests appear here. You can approve or reject their requests.', 'user_friends_requests, ');
INSERT INTO `se_languagevars` VALUES ('910', '1', 'You do not have any friend requests at this time.', 'user_friends_requests, ');
INSERT INTO `se_languagevars` VALUES ('911', '1', 'Reject Friend Request', 'user_friends_requests, ');
INSERT INTO `se_languagevars` VALUES ('912', '1', 'Are you sure you want to reject %1$s\'s friendship request?', 'user_friends_manage, ');
INSERT INTO `se_languagevars` VALUES ('913', '1', 'Reject Request', 'user_friends_manage, ');
INSERT INTO `se_languagevars` VALUES ('914', '1', 'You have successfully rejected this user\'s friendship request.', '');
INSERT INTO `se_languagevars` VALUES ('915', '1', 'When you ask other people to be your friend, your pending requests will appear here until they are approved or rejected.', 'user_friends_requests_outgoing, ');
INSERT INTO `se_languagevars` VALUES ('916', '1', 'You do not have any outgoing friend requests at this time.', 'user_friends_requests_outgoing, ');
INSERT INTO `se_languagevars` VALUES ('917', '1', 'Cancel Friendship Request', 'user_friends_requests_outgoing, ');
INSERT INTO `se_languagevars` VALUES ('918', '1', 'You are waiting for a friendship confirmation from %1$s. Are you sure you want to cancel your request for friendship with %1$s?', 'user_friends_manage, ');
INSERT INTO `se_languagevars` VALUES ('919', '1', 'Cancel Request', 'user_friends_manage, ');
INSERT INTO `se_languagevars` VALUES ('920', '1', 'You have successfully canceled your friendship request to this user.', '');
INSERT INTO `se_languagevars` VALUES ('921', '1', 'To edit the details of your friendship with %1$s, complete the form below.', 'user_friends_manage, ');
INSERT INTO `se_languagevars` VALUES ('922', '1', 'Edit Friendship', 'user_friends_manage, ');
INSERT INTO `se_languagevars` VALUES ('923', '1', 'You have successfully edited the details of this friendship.', '');
INSERT INTO `se_languagevars` VALUES ('924', '1', 'Search the social network.', 'search, ');
INSERT INTO `se_languagevars` VALUES ('925', '1', 'Search for:', 'search, ');
INSERT INTO `se_languagevars` VALUES ('926', '1', 'Advanced Search', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('927', '1', 'No results for \"<b>%1$s</b>\" were found.', 'search, ');
INSERT INTO `se_languagevars` VALUES ('928', '1', '%1$s seconds', 'search, ');
INSERT INTO `se_languagevars` VALUES ('929', '1', 'Currently Online', 'search, ');
INSERT INTO `se_languagevars` VALUES ('930', '1', '%1$s\'s Friends', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('931', '1', 'The following people are listed as %1$s\'s friends.', '');
INSERT INTO `se_languagevars` VALUES ('932', '1', '%1$s has not yet added any friends.', '');
INSERT INTO `se_languagevars` VALUES ('933', '1', 'Search %1$s\'s friends:', '');
INSERT INTO `se_languagevars` VALUES ('934', '1', 'None of %1$s\'s friends match your search criteria.', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('935', '1', 'FAQ Manager', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('936', '1', 'A frequently asked questions (FAQ) page can help you reduce your support responsibilities by allowing users to find answers to their common questions in your help area. Add any questions and answers that you feel are appropriate for your social network here. Also, be sure to organize your questions into relevant categories to help your users find answers more easily.', 'admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('937', '1', 'Add Question', 'admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('938', '1', 'Answer:<br>(HTML OK)', 'admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('939', '1', 'Question', 'admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('940', '1', 'Avg. Daily Views', 'admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('941', '1', 'Created', 'admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('942', '1', 'Updated', 'admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('943', '1', 'move up', 'admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('944', '1', 'Please provide a title for this FAQ category.', 'admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('945', '1', 'Please specify a name for this category.', 'admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('800001', '1', 'Your Account', 'help, admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('800003', '1', 'Privacy', 'help, admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('946', '1', 'Question:', 'admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('947', '1', 'Please specify a question.', 'admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('948', '1', 'Please provide some information about this FAQ question.', 'admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('800004', '1', 'I can&#039;t login, or I forgot my username or password.', 'help, admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('800005', '1', 'If you can\'t login, check to make sure that your \"caps lock\" key is off. Your username and password are CaSe SeNsItIvE. If you still cannot login, you can request to <a href=\'lostpass.php\'>reset your password</a> or <a href=\'help_contact.php\'>contact us</a>.', 'help, admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('1097', '1', 'Suggestions:', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('949', '1', '%1$d total views', 'admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('950', '1', 'Reset the views for this question?', 'admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('1012', '1', 'Are you sure you want to delete this user?', 'admin_viewusers, ');
INSERT INTO `se_languagevars` VALUES ('951', '1', 'Edit Category', 'admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('954', '1', 'Edit Question', 'admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('952', '1', 'Delete Category?', 'admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('953', '1', 'Are you sure you want to delete this category? NOTE: All questions within this category will also be deleted!', 'admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('955', '1', 'Delete Question?', 'admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('800007', '1', 'If you are aboslutely sure that you want to delete your account, you can do so <a href=\'user_account_delete.php\'>here</a>. Please note that your account will be permanently deleted and irrecoverable!', 'help, admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('800006', '1', 'How can I delete my account?', 'help, admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('956', '1', 'Are you sure you want to delete this question?', 'admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('800008', '1', 'How can I update my profile?', 'help, admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('800009', '1', 'To update your profile, you must visit the <a href=\'user_editprofile.php\'>Edit Profile</a> page. You can move through the different parts of your profile by clicking the tabs at the top of the page.', 'help, admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('800010', '1', 'How can I update my email address?', 'help, admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('800011', '1', 'You can update your email address on the <a href=\'user_account.php\'>My Account</a> page.', 'help, admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('800012', '1', 'How can I report an error or other problem with the site?', 'help, admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('800013', '1', 'To report an error or problem with the site, you can contact us <a href=\'help_contact.php\'>here</a>.', 'help, admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('800014', '1', 'How can I deal with someone that is bothering me?', 'help, admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('800015', '1', 'If someone is bothering or harassing you, blocking them is usually the best solution. Visit the <a href=\'user_account.php\'>Account Settings</a> page to learn how to block people. If someone continues to harass you despite your efforts, you can report them <a href=\'help_contact.php\'>here</a>.', 'help, admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('800016', '1', 'How can I report spam or other inappropriate content?', 'help, admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('800017', '1', 'You can report spam, pornography, or any other inappropriate content <a href=\'help_contact.php\'>here</a>, or by clicking the \"Report\" link on the page containing the content you wish to report.', 'help, admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('800018', '1', 'Is my information kept private?', 'help, admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('800019', '1', 'Absolutely. We do not share any personally identifying information about you to any third party.', 'help, admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('800020', '1', 'How can I make my profile private?', 'help, admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('800021', '1', 'If the administrator has enabled it, you can make your profile private by visiting the <a href=\'user_account_privacy.php\'>Account Privacy</a> page.', 'help, admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('800022', '1', 'How can I block users from contacting me?', 'help, admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('800023', '1', 'You can block people by adding their username to your blocked users list. Visit the <a href=\'user_account.php\'>Account Settings</a> page to learn more about how to block people.', 'help, admin_faq, ');
INSERT INTO `se_languagevars` VALUES ('957', '1', 'Frequently Asked Questions', 'help, ');
INSERT INTO `se_languagevars` VALUES ('958', '1', 'If you need help, the answer to your question is likely to be found on this page.', 'help, ');
INSERT INTO `se_languagevars` VALUES ('959', '1', 'Email Notifications', 'user_account, ');
INSERT INTO `se_languagevars` VALUES ('960', '1', 'Which of the following things do you want to receive email notifications for?', 'user_account, ');
INSERT INTO `se_languagevars` VALUES ('961', '1', 'When I receive a message.', 'user_account, ');
INSERT INTO `se_languagevars` VALUES ('962', '1', 'When I receive a friend request.', 'user_account, ');
INSERT INTO `se_languagevars` VALUES ('963', '1', 'When I receive a profile comment.', 'user_account, ');
INSERT INTO `se_languagevars` VALUES ('964', '1', 'Edit your profile\'s style here.', 'user_editprofile_style, ');
INSERT INTO `se_languagevars` VALUES ('965', '1', 'Profile Style', 'user_editprofile_style, ');
INSERT INTO `se_languagevars` VALUES ('966', '1', 'Add your own CSS code below to give your profile a more personalized look.<br>The contents of the text area below will be output between &lt;style&gt; tags on your profile.', 'user_editprofile_style, ');
INSERT INTO `se_languagevars` VALUES ('967', '1', 'Profile Privacy', 'user_account_privacy, ');
INSERT INTO `se_languagevars` VALUES ('968', '1', 'Who can view your profile?', 'user_account_privacy, ');
INSERT INTO `se_languagevars` VALUES ('969', '1', 'Comments Privacy', 'user_account_privacy, ');
INSERT INTO `se_languagevars` VALUES ('970', '1', 'Who can post comments on your profile?', 'user_account_privacy, ');
INSERT INTO `se_languagevars` VALUES ('971', '1', 'Search Privacy', 'user_account_privacy, ');
INSERT INTO `se_languagevars` VALUES ('972', '1', 'Do you want to be included in search results?<br>Note that this privacy setting also applies to users displayed on the homepage (such as Most Popular User).', 'user_account_privacy, ');
INSERT INTO `se_languagevars` VALUES ('973', '1', 'Yes, include my profile in search results.', 'user_account_privacy, ');
INSERT INTO `se_languagevars` VALUES ('974', '1', 'No, do not include my profile in search results.', 'user_account_privacy, ');
INSERT INTO `se_languagevars` VALUES ('750001', '1', '%1$d Friend Request(s)', 'user_report, user_home, user_friends_requests, user_friends_manage, user_account_privacy, user_account_pass, user_account_delete, user_account, search, profile, network, ');
INSERT INTO `se_languagevars` VALUES ('850011', '1', 'Social Network - Lost Password', 'lostpass, admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('850012', '1', 'Hello %1$s,<br><br>You have requested to reset your password because you have forgotten your password. If you did not request this, please ignore it. It will expire in 24 hours.To reset your password, please click the following link:<br><br>%3$s<br><br>Best Regards,<br>Social Network Administration', 'lostpass, admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('850013', '1', '%2$s has added you as a friend.', 'user_friends_manage, admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('850014', '1', 'Hello %1$s,<br><br>%2$s has added you as a friend. Please click the following link to login and confirm this friendship request:<br><br>%3$s<br><br>Best Regards,<br>Social Network Administration', 'user_friends_manage, admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('850015', '1', 'You have received a new message.', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('850016', '1', 'Hello %1$s,<br><br>You have just received a new message from %2$s. Please click the following link to login and view it:<br><br>%3$s<br><br>Best Regards,<br>Social Network Administration', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('750002', '1', '%1$d New Messages', '');
INSERT INTO `se_languagevars` VALUES ('750003', '1', '%1$d New Profile Comment(s)', '');
INSERT INTO `se_languagevars` VALUES ('850001', '1', 'You have received an invitation to join our social network!', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('850002', '1', 'Hello,<br><br>You have been invited by %1$s to join our social network. To join, please follow the link below and enter your invite code.<br><br>%5$s<br><br>Invite Code: %4$s<br><br>Best Regards,<br>Social Network Administration<br><br>----------------------------------------<br>%3$s', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('850003', '1', 'You have received an invitation to join our social network.', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('850004', '1', 'Hello,<br><br>You have been invited by %1$s to join our social network. To join, please follow the link below:<br>%4$s<br><br>Best Regards,<br>Social Network Administration<br><br>----------------------------------------<br>%3$s', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('850005', '1', 'Social Network - Email Verification', 'signup, admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('978', '1', 'Enable this feature if you want your users to choose from existing CSS samples. To add additional samples, simply insert a row into the se_stylesamples database table containing the exact CSS code that should be entered into the Profile Style textarea and, optionally, the path to a thumbnail for the template.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('976', '1', '%1$s and %2$d guest(s)', 'user_home, home, admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('977', '1', '%1$d guest(s)', 'user_home, home, admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('975', '1', '[ Refresh ]', 'signup, ');
INSERT INTO `se_languagevars` VALUES ('982', '1', 'Yes, users can choose from the provided sample CSS.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('983', '1', 'No, users can not choose from the provided sample CSS.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('984', '1', 'Site Online?', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('985', '1', 'Use this feature when you want to take your site offline for maintenance or upgrades. When your users attempt to access the site, a message will be displayed letting them know the site is undergoing routine maintenance and will be available again soon. If you are logged in as an administrator, you will be able to browse the site freely.', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('979', '1', 'Sample Profile Layouts', 'user_editprofile_style, ');
INSERT INTO `se_languagevars` VALUES ('980', '1', 'Click on one of the sample layouts below to select it for your profile.<br><b>NOTE:</b> Choosing one of the sample layouts below will remove your current layout.', 'user_editprofile_style, ');
INSERT INTO `se_languagevars` VALUES ('981', '1', 'Are you sure you want to replace your profile style with this template?', 'user_editprofile_style, ');
INSERT INTO `se_languagevars` VALUES ('986', '1', 'Yes, the site is online.', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('987', '1', 'No, the site is offline for maintenance.', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('988', '1', 'The site is currently down for maintenance. Check back again shortly!', 'home, ');
INSERT INTO `se_languagevars` VALUES ('989', '1', 'Checkboxes', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('990', '1', 'Display Type:', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('991', '1', 'Displayed, Linked on Profile', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('992', '1', 'Displayed on Profile', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('993', '1', 'Not Displayed on Profile', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('994', '1', 'Special Attribute:', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('995', '1', 'Birthday (Date Field Only)', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('996', '1', 'This page lists all of the users that exist on your social network. For more information about a specific user, click on the \"edit\" link in its row. Click the \"login\" link to login as a specific user. Use the filter fields to find specific users based on your criteria. To view all users on your system, leave all the filter fields blank.', 'admin_viewusers, ');
INSERT INTO `se_languagevars` VALUES ('997', '1', 'User Level', 'admin_viewusers, ');
INSERT INTO `se_languagevars` VALUES ('998', '1', 'Subnetwork', 'admin_viewusers, ');
INSERT INTO `se_languagevars` VALUES ('999', '1', 'Enabled', 'admin_viewusers_edit, admin_viewusers, ');
INSERT INTO `se_languagevars` VALUES ('1000', '1', 'Yes', 'admin_viewusers, ');
INSERT INTO `se_languagevars` VALUES ('1001', '1', 'No', 'admin_viewusers, ');
INSERT INTO `se_languagevars` VALUES ('1002', '1', 'Filter', 'admin_viewusers, admin_viewreports, ');
INSERT INTO `se_languagevars` VALUES ('1003', '1', 'No users were found.', 'admin_viewusers, ');
INSERT INTO `se_languagevars` VALUES ('1004', '1', '%1$d Users Found', 'admin_viewusers, ');
INSERT INTO `se_languagevars` VALUES ('1005', '1', 'Page:', 'admin_viewusers, admin_viewreports, ');
INSERT INTO `se_languagevars` VALUES ('1006', '1', 'Verified', 'admin_viewusers, ');
INSERT INTO `se_languagevars` VALUES ('1007', '1', 'Signup Date', 'admin_viewusers, ');
INSERT INTO `se_languagevars` VALUES ('1008', '1', 'unverified', 'admin_viewusers_edit, admin_viewusers, ');
INSERT INTO `se_languagevars` VALUES ('1009', '1', 'login', 'admin_viewusers, ');
INSERT INTO `se_languagevars` VALUES ('1010', '1', 'The site is now online.', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('1011', '1', 'The site is now offline.', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('1013', '1', 'Delete User', 'admin_viewusers, ');
INSERT INTO `se_languagevars` VALUES ('1014', '1', 'Note that if you change your Account Type, you may have to re-enter your profile information.', 'user_account, ');
INSERT INTO `se_languagevars` VALUES ('1015', '1', 'Your Email Address', 'signup_verify, ');
INSERT INTO `se_languagevars` VALUES ('1016', '1', 'Resend Verification', 'signup_verify, ');
INSERT INTO `se_languagevars` VALUES ('1072', '1', '%1$d profiles', 'search, ');
INSERT INTO `se_languagevars` VALUES ('1018', '1', 'Phrase ID:', 'admin_language_edit, ');
INSERT INTO `se_languagevars` VALUES ('1019', '1', '%1$s new update(s)', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('1017', '1', 'Continue To Login...', 'signup_verify, ');
INSERT INTO `se_languagevars` VALUES ('1020', '1', 'View Mutual Friends', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('1021', '1', 'view all', '');
INSERT INTO `se_languagevars` VALUES ('1022', '1', 'View All Friends', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('1023', '1', 'You do not have any friends in common with %1$s.', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('1024', '1', 'Mutual Friends with %1$s', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('1025', '1', 'Delete Comment', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('1026', '1', 'Are you sure you want to delete this comment?', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('1027', '1', '<b>Note:</b> This action has media (such as photos) associated with it. Simply include the tag <i>[media]</i> to display them.', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('1028', '1', 'Congratulations! You have successfully verified your email address. Click the button below to login.', 'signup_verify, ');
INSERT INTO `se_languagevars` VALUES ('1029', '1', 'First Name/1st Display Name (Text Field Only)', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('1030', '1', 'Last Name/2nd Display Name (Text Field Only)', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('1031', '1', 'This field allows you to treat certain profile fields differently. Designating a date field as \"Birthday\" will make a user\'s age display on their profile. If you would like to use the user\'s First Name or Last Name as their display name instead of their username, you can create special fields with these designations that will display instead of the user\'s username on their profile. It is advised that you only create one field per category with each special designation or unexpected results may occur.', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('1032', '1', 'Profile Comment Conversation', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('1033', '1', 'Conversation Between %1$s and %2$s', '');
INSERT INTO `se_languagevars` VALUES ('1034', '1', 'Allowed HTML Tags: %1$s', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('1073', '1', 'Please enter at least one recipient email address for your invitation.', '');
INSERT INTO `se_languagevars` VALUES ('1035', '1', 'If you want to ask us a question directly, please submit your message with the following form.', 'help_contact, ');
INSERT INTO `se_languagevars` VALUES ('1036', '1', 'Please provide a detailed message.', '');
INSERT INTO `se_languagevars` VALUES ('1037', '1', 'Another user has already taken this email address.', '');
INSERT INTO `se_languagevars` VALUES ('1038', '1', 'There is no user in the system with that email address. Please <a href=\'home.php\'>click here</a> to return to the home page.', '');
INSERT INTO `se_languagevars` VALUES ('1039', '1', 'The link you have clicked is invalid or expired. <a href=\'signup_verify.php?task=resend\'>Click here</a> to resend the verification email.', 'signup_verify, ');
INSERT INTO `se_languagevars` VALUES ('1040', '1', 'Your message has been received. We will assist you as soon as possible.', 'help_contact, ');
INSERT INTO `se_languagevars` VALUES ('1041', '1', 'Congratulations! You have successfully verified your email address and your network has been changed from %1$s to %2$s. Click the button below to login.', '');
INSERT INTO `se_languagevars` VALUES ('1042', '1', 'A new verification email has been sent to the email address you provided. Please follow the link within to verify your account.', '');
INSERT INTO `se_languagevars` VALUES ('1043', '1', 'To have the email verification resent, enter your email address in the field below. If you have reached this page in error, <a href=\'home.php\'>click here</a> to return to the home page.', 'signup_verify, ');
INSERT INTO `se_languagevars` VALUES ('1044', '1', 'The email address you have provided is already verified. If you have forgotten your password, please <a href=\'lostpass.php\'>click here</a> to have it sent to you.', 'signup_verify, ');
INSERT INTO `se_languagevars` VALUES ('1045', '1', 'Email Address Verification', 'signup_verify, ');
INSERT INTO `se_languagevars` VALUES ('1046', '1', 'Please provide your name.', '');
INSERT INTO `se_languagevars` VALUES ('1047', '1', 'Allow users to go invisible?', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('1048', '1', 'Enable this feature if you want to allow users to go \"invisible\" (not be displayed in the online users list even if they are online).', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('1049', '1', 'Allow users to see who viewed their profile?', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('1050', '1', 'If you enable this feature, users will be given the option of seeing which users have visited their profile.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('1051', '1', 'Yes, allow users to go invisible.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('1052', '1', 'No, do not allow users to go invisible.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('1053', '1', 'Yes, allow users to see who has viewed their profile.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('1054', '1', 'No, do not allow users to see who has viewed their profile.', 'admin_levels_usersettings, ');
INSERT INTO `se_languagevars` VALUES ('1055', '1', 'Privacy', 'user_account_privacy, user_account_pass, user_account_delete, user_account, ');
INSERT INTO `se_languagevars` VALUES ('1056', '1', 'Privacy Settings', 'user_account_privacy, ');
INSERT INTO `se_languagevars` VALUES ('1057', '1', 'Change your account\'s general privacy settings here.', 'user_account_privacy, ');
INSERT INTO `se_languagevars` VALUES ('1058', '1', 'Go Invisible', 'user_account_privacy, ');
INSERT INTO `se_languagevars` VALUES ('1059', '1', 'Do not display me in the \"Online Users\" list.', 'user_account_privacy, ');
INSERT INTO `se_languagevars` VALUES ('1060', '1', 'Show Profile Views', 'user_account_privacy, ');
INSERT INTO `se_languagevars` VALUES ('1061', '1', 'Yes, display users who viewed my profile.', 'user_account_privacy, ');
INSERT INTO `se_languagevars` VALUES ('1062', '1', 'Note: If you choose to display users who viewed your profile, other users will be able to track whether you viewed their profile. If you do not want other users to know you viewed their profile, do not enable this feature.', 'user_account_privacy, ');
INSERT INTO `se_languagevars` VALUES ('1063', '1', 'No users have viewed your profile yet.', 'user_home, ');
INSERT INTO `se_languagevars` VALUES ('1064', '1', 'Who viewed my profile?', 'user_home, ');
INSERT INTO `se_languagevars` VALUES ('1065', '1', 'Do you want to allow your users to decide which actions they want to see in their activity feed? If you enable this feature, users will be able specify actions they do and do not want to see in their recent activity feed.', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('1066', '1', 'Yes, allow users to specify which actions they will see in the activity feed.', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('1067', '1', 'No, do not allow users to specify which actions they will see in the activity feed.', 'admin_activity, ');
INSERT INTO `se_languagevars` VALUES ('1068', '1', 'Activity Feed Preferences', 'user_home, ');
INSERT INTO `se_languagevars` VALUES ('1069', '1', 'Which actions do you want to see in the recent activity feed?', 'user_home, ');
INSERT INTO `se_languagevars` VALUES ('1070', '1', 'Preferences', 'user_home, ');
INSERT INTO `se_languagevars` VALUES ('1071', '1', '[User Deleted]', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('1074', '1', 'Invite Your Friends', 'invite, ');
INSERT INTO `se_languagevars` VALUES ('1075', '1', 'Invite your friends to join! Enter up to 10 email addresses of your friends separated by commas in the field below.', 'invite, ');
INSERT INTO `se_languagevars` VALUES ('1076', '1', 'You must be logged in to invite other people.', 'invite, ');
INSERT INTO `se_languagevars` VALUES ('1077', '1', 'You have <b>%1$d</b> invites remaining.', 'invite, ');
INSERT INTO `se_languagevars` VALUES ('1078', '1', 'When they signup, they will be instantly added to your friends list.', 'invite, ');
INSERT INTO `se_languagevars` VALUES ('1079', '1', 'To:', 'invite, ');
INSERT INTO `se_languagevars` VALUES ('1080', '1', 'Separate multiple email addresses (up to 10) with commas.', 'invite, ');
INSERT INTO `se_languagevars` VALUES ('1081', '1', 'Message:', 'invite, ');
INSERT INTO `se_languagevars` VALUES ('1082', '1', 'Type your message here. (optional)', 'invite, ');
INSERT INTO `se_languagevars` VALUES ('1083', '1', 'Browsing members that match %1$s', 'search_advanced, ');
INSERT INTO `se_languagevars` VALUES ('1084', '1', 'We found %1$d member(s) with profiles that match %2$s.', 'search_advanced, ');
INSERT INTO `se_languagevars` VALUES ('1085', '1', 'No people matched your search criteria.', 'search_advanced, ');
INSERT INTO `se_languagevars` VALUES ('1086', '1', 'Online', 'search_advanced, ');
INSERT INTO `se_languagevars` VALUES ('1087', '1', 'Advanced Search Members', 'search_advanced, ');
INSERT INTO `se_languagevars` VALUES ('1088', '1', 'Search through our members with your own keywords and criteria.', 'search_advanced, ');
INSERT INTO `se_languagevars` VALUES ('1089', '1', 'Search Criteria', 'search_advanced, ');
INSERT INTO `se_languagevars` VALUES ('1090', '1', 'Update Results', 'search_advanced, ');
INSERT INTO `se_languagevars` VALUES ('1091', '1', 'Sort Results By:', 'search_advanced, ');
INSERT INTO `se_languagevars` VALUES ('1092', '1', 'Last Update', 'search_advanced, ');
INSERT INTO `se_languagevars` VALUES ('1093', '1', '(DESC)', 'search_advanced, ');
INSERT INTO `se_languagevars` VALUES ('1094', '1', '(ASC)', 'search_advanced, ');
INSERT INTO `se_languagevars` VALUES ('1095', '1', 'Last Login', 'search_advanced, ');
INSERT INTO `se_languagevars` VALUES ('1096', '1', 'Last Signup', 'search_advanced, ');
INSERT INTO `se_languagevars` VALUES ('850010', '1', 'Hello %1$s,<br><br>Thank you for joining our social network. Click the following link and enter your information below to login:<br><br>%4$s<br><br>Email: %2$s<br>Password: %3$s<br><br>Best Regards,<br>Social Network Administration', 'signup_verify, signup, admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('850006', '1', 'Hello %1$s,<br><br>Thank you for joining our social network. To verify your email address and continue, please click the following link:<br>%3$s<br><br>Best Regards,<br>Social Network Administration', 'signup, admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('850007', '1', 'Social Network - Login Details', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('850008', '1', 'Hello %1$s,<br><br>Thank you for joining our social network. Click the following link and enter your information below to login:<br><br>%4$s<br><br>Email: %2$s<br>Password: %3$s<br><br>Best Regards,<br>Social Network Administration', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('850009', '1', 'Welcome to the social network!', 'signup_verify, signup, home, admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('850017', '1', 'New Profile Comment', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('850018', '1', 'Hello %1$s,<br><br>A new comment has been posted on your profile by %2$s. Please click the following link to view it:<br><br>%3$s<br><br>Best Regards,<br>Social Network Administration', 'admin_emails, ');
INSERT INTO `se_languagevars` VALUES ('1098', '1', 'Add New Suggestion', '');
INSERT INTO `se_languagevars` VALUES ('1099', '1', 'If you would like this field to auto-suggest values to the user when they are filling out this field (such as US States), add suggestions below, separated by line breaks. Note that the user will not be restricted to these values, they will merely be suggested to the user as they are typing.', 'admin_fields, ');
INSERT INTO `se_languagevars` VALUES ('500364', '1', 'Personal Information', '');
INSERT INTO `se_languagevars` VALUES ('1100', '1', 'This page lists all of the reports your users have sent in regarding inappropriate content, system abuse, spam, and so forth. You can use the search field to look for reports that contain a particular word or phrase. Very old reports are periodically deleted by the system.', 'admin_viewreports, ');
INSERT INTO `se_languagevars` VALUES ('1101', '1', 'Reason', 'admin_viewreports, ');
INSERT INTO `se_languagevars` VALUES ('1102', '1', 'Details', 'admin_viewreports, ');
INSERT INTO `se_languagevars` VALUES ('1103', '1', 'No reports have been made.', 'admin_viewreports, ');
INSERT INTO `se_languagevars` VALUES ('1104', '1', '%1$d Reports Found', 'admin_viewreports, ');
INSERT INTO `se_languagevars` VALUES ('1105', '1', 'login & view', 'admin_viewreports, ');
INSERT INTO `se_languagevars` VALUES ('1106', '1', 'details', '');
INSERT INTO `se_languagevars` VALUES ('1107', '1', 'Any SocialEngine plugins that you have installed will appear on this page. Note that some plugins may have user level-specific settings which are available on the <a href=\'admin_levels.php\'>User Levels</a> page.', 'admin_viewplugins, ');
INSERT INTO `se_languagevars` VALUES ('1108', '1', 'There are currently no plugins installed. Visit the <a href=\'http://www.socialengine.net/\' target=\'_blank\'>SocialEngine website</a> to add plugins to your social network!', 'admin_viewplugins, ');
INSERT INTO `se_languagevars` VALUES ('1109', '1', 'Install Plugin', 'admin_viewplugins, ');
INSERT INTO `se_languagevars` VALUES ('1110', '1', 'Warning: You have not yet deleted install_%1$s.php. Leaving this file on your server is a security risk!', 'admin_viewplugins, ');
INSERT INTO `se_languagevars` VALUES ('1111', '1', 'Install Upgrade', 'admin_viewplugins, ');
INSERT INTO `se_languagevars` VALUES ('1112', '1', 'Upgrade Available!', 'admin_viewplugins, ');
INSERT INTO `se_languagevars` VALUES ('1113', '1', 'Updated:', 'user_home, profile, ');
INSERT INTO `se_languagevars` VALUES ('1114', '1', 'The admin has not enabled any advanced search fields.', 'search_advanced, ');
INSERT INTO `se_languagevars` VALUES ('500370', '1', 'First Name', '');
INSERT INTO `se_languagevars` VALUES ('1117', '1', 'MAX', 'search_advanced, ');
INSERT INTO `se_languagevars` VALUES ('1116', '1', 'MIN', 'search_advanced, ');
INSERT INTO `se_languagevars` VALUES ('1115', '1', 'Signup today!', 'home, ');
INSERT INTO `se_languagevars` VALUES ('500407', '2', '', '');
INSERT INTO `se_languagevars` VALUES ('1118', '1', 'Uninstall', 'admin_viewplugins, ');
INSERT INTO `se_languagevars` VALUES ('1119', '1', 'Network:', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('1120', '1', 'Account Type:', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('1121', '1', 'Online Users Only', 'search_advanced, ');
INSERT INTO `se_languagevars` VALUES ('1122', '1', 'Users with Photos Only', 'search_advanced, ');
INSERT INTO `se_languagevars` VALUES ('1123', '1', 'Editing User: %1$s', 'admin_viewusers_edit, ');
INSERT INTO `se_languagevars` VALUES ('1124', '1', 'To edit this users\'s account, make changes to the form below. If you want to temporarily prevent this user from logging in, you can set the user account to \"disabled\" below.', 'admin_viewusers_edit, ');
INSERT INTO `se_languagevars` VALUES ('1125', '1', 'total friends', 'admin_viewusers_edit, ');
INSERT INTO `se_languagevars` VALUES ('1126', '1', 'total logins', 'admin_viewusers_edit, ');
INSERT INTO `se_languagevars` VALUES ('1127', '1', 'total messages stored', 'admin_viewusers_edit, ');
INSERT INTO `se_languagevars` VALUES ('1128', '1', 'total comments made', 'admin_viewusers_edit, ');
INSERT INTO `se_languagevars` VALUES ('1129', '1', 'Last Login:', 'admin_viewusers_edit, ');
INSERT INTO `se_languagevars` VALUES ('1130', '1', 'Never', 'admin_viewusers_edit, ');
INSERT INTO `se_languagevars` VALUES ('1131', '1', 'resend verification email', 'admin_viewusers_edit, ');
INSERT INTO `se_languagevars` VALUES ('1132', '1', 'manually verify', 'admin_viewusers_edit, ');
INSERT INTO `se_languagevars` VALUES ('1133', '1', 'Username:', 'admin_viewusers_edit, ');
INSERT INTO `se_languagevars` VALUES ('1134', '1', 'Password:', 'admin_viewusers_edit, ');
INSERT INTO `se_languagevars` VALUES ('1135', '1', 'Only enter if you want to reset pass.', 'admin_viewusers_edit, ');
INSERT INTO `se_languagevars` VALUES ('1136', '1', 'Enabled?', 'admin_viewusers_edit, ');
INSERT INTO `se_languagevars` VALUES ('1137', '1', 'Disabled', 'admin_viewusers_edit, ');
INSERT INTO `se_languagevars` VALUES ('1138', '1', 'User Level:', 'admin_viewusers_edit, ');
INSERT INTO `se_languagevars` VALUES ('1139', '1', 'Invites Remaining:', 'admin_viewusers_edit, ');
INSERT INTO `se_languagevars` VALUES ('1140', '1', 'Email verification has been resent.', '');
INSERT INTO `se_languagevars` VALUES ('1141', '1', 'User email has been manually verified.', 'admin_viewusers_edit, ');
INSERT INTO `se_languagevars` VALUES ('1142', '1', 'The number of invites left must be between 0 and 999.', 'admin_viewusers_edit, ');
INSERT INTO `se_languagevars` VALUES ('1143', '1', 'Your changes have been saved and this user\'s subnetwork has been changed from %1$s to %2$s.', '');
INSERT INTO `se_languagevars` VALUES ('1144', '1', 'Signup IP:', 'admin_viewusers_edit, ');
INSERT INTO `se_languagevars` VALUES ('1145', '1', 'Last Recorded IP:', 'admin_viewusers_edit, ');
INSERT INTO `se_languagevars` VALUES ('1146', '1', 'Are you <b>REALLY</b> sure you want to delete your account? You account will be <i>permanently</i> deleted and you will not be able to restore any of your account data!', 'user_account_delete, ');
INSERT INTO `se_languagevars` VALUES ('1147', '1', 'Setlocale Code', 'admin_language, ');
INSERT INTO `se_languagevars` VALUES ('1148', '1', 'Enable Username?', 'admin_general, ');
INSERT INTO `se_languagevars` VALUES ('1149', '1', 'By default, usernames are used to uniquely identify your users. If you choose to disable this feature, your users will not be given the option to enter a username. Instead, their user ID will be used. Note that if you do decide to enable this feature, you should make sure to create special REQUIRED display name profile fields - otherwise the users\' IDs will be displayed. Also note that if you disable usernames after users have already signed up, their usernames will be <b>deleted</b> and any previous links to their content <b>will not work</b>, as the links will no longer use their username! Finally, <b>all recent activity and all notifications will be deleted</b> if you choose to disable usernames after previously having them enabled.', 'admin_general, ');
INSERT INTO `se_languagevars` VALUES ('1150', '1', 'Yes, users are uniquely identified by their username.', 'admin_general, ');
INSERT INTO `se_languagevars` VALUES ('1151', '1', 'No, usernames will not be used in this network.', 'admin_general, ');
INSERT INTO `se_languagevars` VALUES ('1152', '1', 'Display Name', 'admin_viewusers, ');
INSERT INTO `se_languagevars` VALUES ('1153', '1', 'Help Request: %1$s', 'help_contact, ');
INSERT INTO `se_languagevars` VALUES ('1154', '1', 'Hello %1$s,<br><br>You have received a support request:<br><br>Email: %2$s<br>Name: %3$s<br>Subject: %4$s<br><br>%5$s', 'help_contact, ');
INSERT INTO `se_languagevars` VALUES ('1155', '1', 'What\'s New In My Network: %1$s', 'network, ');
INSERT INTO `se_languagevars` VALUES ('1156', '1', 'Social Network Default Meta Tag Description', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('1157', '1', 'Terms of Service: %1$s', 'help_tos, ');
INSERT INTO `se_languagevars` VALUES ('1158', '1', '%1$s\'s Profile - %2$s', 'profile, ');
INSERT INTO `se_languagevars` VALUES ('1159', '1', 'Type', 'admin_language_edit, ');
INSERT INTO `se_languagevars` VALUES ('1160', '1', 'Default Location(s)', 'admin_language_edit, ');
INSERT INTO `se_languagevars` VALUES ('1161', '1', 'What\'s New', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('1162', '1', 'My Network', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('1163', '1', 'Edit Profile Information', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('1164', '1', 'Change Profile Photo', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('1165', '1', 'Edit Profile Layout', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('1166', '1', 'My Apps', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('1167', '1', 'Compose New Message', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('1168', '1', 'Message Inbox', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('1169', '1', 'Message Outbox', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('1170', '1', 'View My Friends', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('1171', '1', 'Incoming Friend Requests', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('1172', '1', 'Outgoing Friend Requests', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('1173', '1', 'Account Settings', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('1174', '1', 'Privacy Options', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('1175', '1', 'Copyright', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, ');
INSERT INTO `se_languagevars` VALUES ('1176', '1', 'Friends\' Birthdays', 'user_home, ');
INSERT INTO `se_languagevars` VALUES ('1177', '1', 'Recent Status Updates', 'network, ');
INSERT INTO `se_languagevars` VALUES ('1178', '1', 'No one has changed their status recently.', 'network, ');
INSERT INTO `se_languagevars` VALUES ('1179', '1', 'No users have joined this network yet.', 'network, ');
INSERT INTO `se_languagevars` VALUES ('1180', '1', 'There are no upcoming birthdays.', 'user_home, ');
INSERT INTO `se_languagevars` VALUES ('1181', '1', 'Delete this message.', 'user_messages_view, ');
INSERT INTO `se_languagevars` VALUES ('1182', '1', '(Listed By Most Recent Visitor)', 'user_home, ');
INSERT INTO `se_languagevars` VALUES ('500403', '2', '', '');
INSERT INTO `se_languagevars` VALUES ('500371', '1', '', '');
INSERT INTO `se_languagevars` VALUES ('500366', '1', 'Band Information', '');
INSERT INTO `se_languagevars` VALUES ('500400', '2', '', '');
INSERT INTO `se_languagevars` VALUES ('500399', '2', 'Localidad', '');
INSERT INTO `se_languagevars` VALUES ('500397', '2', '', '');
INSERT INTO `se_languagevars` VALUES ('500396', '2', 'Barrio', '');
INSERT INTO `se_languagevars` VALUES ('500394', '2', '', '');
INSERT INTO `se_languagevars` VALUES ('500391', '2', '', '');
INSERT INTO `se_languagevars` VALUES ('500372', '1', '', '');
INSERT INTO `se_languagevars` VALUES ('500362', '1', 'Standard Users', '');
INSERT INTO `se_languagevars` VALUES ('500363', '1', 'Musicians', '');
INSERT INTO `se_languagevars` VALUES ('750004', '1', 'When I receive a friend request', '');
INSERT INTO `se_languagevars` VALUES ('750005', '1', 'When I receive a message', '');
INSERT INTO `se_languagevars` VALUES ('750006', '1', 'When I receive a profile comment', '');
INSERT INTO `se_languagevars` VALUES ('1183', '1', 'Having trouble uploading files? Click here to use the simple uploader.', '');
INSERT INTO `se_languagevars` VALUES ('1184', '1', 'File 1:', '');
INSERT INTO `se_languagevars` VALUES ('1185', '1', 'File 2:', '');
INSERT INTO `se_languagevars` VALUES ('1186', '1', 'File 3:', '');
INSERT INTO `se_languagevars` VALUES ('1187', '1', 'File 4:', '');
INSERT INTO `se_languagevars` VALUES ('1188', '1', 'File 5:', '');
INSERT INTO `se_languagevars` VALUES ('1189', '1', 'Upload Selected Files', '');
INSERT INTO `se_languagevars` VALUES ('1190', '1', 'Uploading', '');
INSERT INTO `se_languagevars` VALUES ('1191', '1', 'Add Files', '');
INSERT INTO `se_languagevars` VALUES ('1192', '1', 'Overall Progress', '');
INSERT INTO `se_languagevars` VALUES ('1193', '1', 'File Progress', '');
INSERT INTO `se_languagevars` VALUES ('1194', '1', 'Please specify a file to upload by clicking the \"Add Files\" link.', '');
INSERT INTO `se_languagevars` VALUES ('1195', '1', 'Upload with %1$s/2. Time left: ~%2$s', '');
INSERT INTO `se_languagevars` VALUES ('1196', '1', 'Upload complete!', '');
INSERT INTO `se_languagevars` VALUES ('1197', '1', 'Search Friends', '');
INSERT INTO `se_languagevars` VALUES ('1198', '1', 'New Updates', '');
INSERT INTO `se_languagevars` VALUES ('1199', '1', 'You have %1$s new update(s):', '');
INSERT INTO `se_languagevars` VALUES ('1200', '1', 'Enable Plugin', '');
INSERT INTO `se_languagevars` VALUES ('1201', '1', 'Disable Plugin', '');
INSERT INTO `se_languagevars` VALUES ('1202', '1', 'Subcategories', '');
INSERT INTO `se_languagevars` VALUES ('1203', '1', 'Add Subcategory', '');
INSERT INTO `se_languagevars` VALUES ('1204', '1', 'Photos of %1$s (%2$d)', '');
INSERT INTO `se_languagevars` VALUES ('1205', '1', 'Photos of <a href=\'%1$s\'>%2$s</a>', '');
INSERT INTO `se_languagevars` VALUES ('1206', '1', 'download this file', '');
INSERT INTO `se_languagevars` VALUES ('1207', '1', 'Viewing #%1$d of %2$d <a href=\'%3$s\'>photos of %4$s</a> &nbsp;|&nbsp; <a href=\'%5$s\'>Return to %4$s\'s Profile</a>', '');
INSERT INTO `se_languagevars` VALUES ('1208', '1', 'Last', '');
INSERT INTO `se_languagevars` VALUES ('1209', '1', 'Next', '');
INSERT INTO `se_languagevars` VALUES ('1210', '1', 'These are the terms of service of this social network.', '');
INSERT INTO `se_languagevars` VALUES ('1211', '1', 'Plugin Settings', '');
INSERT INTO `se_languagevars` VALUES ('1212', '1', 'Add Tag', '');
INSERT INTO `se_languagevars` VALUES ('1213', '1', 'Type a tag or select a name from the list:', '');
INSERT INTO `se_languagevars` VALUES ('1214', '1', ' (me)', '');
INSERT INTO `se_languagevars` VALUES ('1215', '1', 'Save', '');
INSERT INTO `se_languagevars` VALUES ('1216', '1', 'From <a href=\'%1$s\'>%2$s</a> by <a href=\'%3$s\'>%4$s</a>', '');
INSERT INTO `se_languagevars` VALUES ('1217', '1', 'From <a href=\'%1$s\'>%2$s</a>', '');
INSERT INTO `se_languagevars` VALUES ('1218', '1', 'In this photo: ', '');
INSERT INTO `se_languagevars` VALUES ('1219', '1', 'Uploaded %1$s', '');
INSERT INTO `se_languagevars` VALUES ('1220', '1', 'Share This', '');
INSERT INTO `se_languagevars` VALUES ('1221', '1', 'Report Inappropriate Content', '');
INSERT INTO `se_languagevars` VALUES ('1222', '1', 'To share this photo or embed it on another web page, please copy and paste the code of your choosing:', '');
INSERT INTO `se_languagevars` VALUES ('1223', '1', 'Direct Link', '');
INSERT INTO `se_languagevars` VALUES ('1224', '1', 'HTML - Embedded Image', '');
INSERT INTO `se_languagevars` VALUES ('1225', '1', 'HTML - Text Link', '');
INSERT INTO `se_languagevars` VALUES ('1226', '1', 'UBB Code (for forums)', '');
INSERT INTO `se_languagevars` VALUES ('1227', '1', 'Close Window', '');
INSERT INTO `se_languagevars` VALUES ('1228', '1', 'remove tag', '');
INSERT INTO `se_languagevars` VALUES ('1229', '1', 'The file \"%2$s\" exceeds the max allowed file size: %1$s bytes', 'user_upload');
INSERT INTO `se_languagevars` VALUES ('1230', '1', 'You may not upload more than %1$s file(s) at a time.', 'user_upload');
INSERT INTO `se_languagevars` VALUES ('1231', '1', 'Unknown Error', 'user_upload');
INSERT INTO `se_languagevars` VALUES ('1232', '1', 'The extension of the file \"%2$s\" is not in the list of allowed extensions: %1$s', 'user_upload');
INSERT INTO `se_languagevars` VALUES ('1233', '1', 'Require users to enter validation code when logging in?', 'admin_banning');
INSERT INTO `se_languagevars` VALUES ('1234', '1', 'If you have selected Yes, an image containing a random sequence of 6 numbers will be shown to users on the \"login\" page. Users will be required to enter these numbers into the Verification Code field in order to login. This feature helps prevent users from trying to spam the login form. For this feature to work properly, your server must have the GD Libraries (2.0 or higher) installed and configured to work with PHP. If you are seeing errors, try turning this off.', 'admin_banning');
INSERT INTO `se_languagevars` VALUES ('1235', '1', 'Yes, enable validation code for logging in.', 'admin_banning');
INSERT INTO `se_languagevars` VALUES ('1236', '1', 'No, disable validation code for logging in.', 'admin_banning');
INSERT INTO `se_languagevars` VALUES ('1237', '1', 'If \"no\" is selected in the setting directly above, a Verification Code will be displayed to the user only after a certain number of failed logins. You can set this to 0 to never display a code.', 'admin_banning');
INSERT INTO `se_languagevars` VALUES ('1238', '1', 'failed logins', 'admin_banning');
INSERT INTO `se_languagevars` VALUES ('1239', '1', 'Require users to enter validation code when using the contact form?', 'admin_banning');
INSERT INTO `se_languagevars` VALUES ('1240', '1', 'If you have selected Yes, an image containing a random sequence of 6 numbers will be shown to users on the \"contact\" page. Users will be required to enter these numbers into the Verification Code field in order to contact you. This feature helps prevent users from trying to spam the contact form. For this feature to work properly, your server must have the GD Libraries (2.0 or higher) installed and configured to work with PHP. If you are seeing errors, try turning this off.', 'admin_banning');
INSERT INTO `se_languagevars` VALUES ('1241', '1', 'Yes, enable validation code for the contact form.', 'admin_banning');
INSERT INTO `se_languagevars` VALUES ('1242', '1', 'No, disable validation code for the contact form.', 'admin_banning');
INSERT INTO `se_languagevars` VALUES ('1243', '1', 'Caching', 'admin_cache, admin_header');
INSERT INTO `se_languagevars` VALUES ('1244', '1', 'Sessions', 'admin_header, admin_session');
INSERT INTO `se_languagevars` VALUES ('1245', '1', 'For very large social networks, it may be necessary to enable caching to improve performance. If there is a noticable decrease in performance on your social network, consider enabling caching below (or upgrading your hardware). Caching takes some load off the database server by storing commonly retrieved data in temporary files (file-based caching) or memcached (memory-based caching). If you are not familiar with caching, we don\'t recommend that you change any of these settings.', 'admin_header, admin_cache');
INSERT INTO `se_languagevars` VALUES ('1246', '1', 'Once you have set up caching, you can generate a configuration file to put in your include folder. This will allow the cache to initialize earlier and will be able to cache the site settings, which contain the cache connection info.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1247', '1', 'Click <a href=\"%1$s\" onclick=\"%2$s\">here</a> to generate.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1248', '1', 'Server', 'admin_cache, admin_session');
INSERT INTO `se_languagevars` VALUES ('1249', '1', 'General Cache Settings', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1250', '1', 'Enable caching?', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1251', '1', 'Enabling caching will decrease the CPU usage of your database server (resulting in a decrease of page load times). While some non-critical data may appear slightly out of date, this will usually not be noticable to users. For example, some of the general site statistics on your homepage may take longer to update. This will not be noticable if your social network is already large and populated with a lot of data.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1252', '1', 'Yes, enable caching.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1253', '1', 'No, do not enable caching.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1254', '1', 'What kind of caching do you want to enable by default?', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1255', '1', 'If you have enabled caching above, please select the type of caching that you want to use. Memcache caching (if available) will use memory (RAM) which is not as abundant as disk space, however it will be faster than file-based caching when performing read/write operations.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1256', '1', 'Note to developers: If you are writing custom code, it is possible to override the type of caching used. If you choose not to do this, the system will use this default setting.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1257', '1', 'File-based', 'admin_cache, admin_session');
INSERT INTO `se_languagevars` VALUES ('1258', '1', 'Memcache', 'admin_cache, admin_session');
INSERT INTO `se_languagevars` VALUES ('1259', '1', 'Default cache lifetime.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1260', '1', 'This determines how long the system will keep cached data before reloading it from the database server. A shorter cache lifetime causes greater database server CPU usage, however the data will be more current. We recommend starting off with 60-120 seconds.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1261', '1', 'Note to developers: This will only affect places that do not specify a lifetime. To modify those, you will have to adjust the settings in that plugin or module, or change the code manually.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1262', '1', 'seconds', 'admin_cache, admin_session');
INSERT INTO `se_languagevars` VALUES ('1263', '1', 'File-based Cache Settings', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1264', '1', 'The settings below are applicable if you have selected file-based caching above.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1265', '1', 'Successfully initialized. The cache folder exists and is writable.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1266', '1', 'The file caching was unable to initialize. The folder might not be writable - please set it to chmod 777.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1267', '1', 'Temporary directory location.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1268', '1', 'This is where the temporary files containing the cached data are stored. Folder must be writable (chmod 777). This should be a path relative to the base directory where SocialEngine is installed.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1269', '1', 'File locking.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1270', '1', 'This is used to prevent two Apache processes from trying to write to the same file at the same time. Some operating systems may not support file locking.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1271', '1', 'Enable file locking?', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1272', '1', 'Memcache-based Cache Settings', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1273', '1', 'The settings below are applicable if you have selected Memcache-based caching above. In this case, data is stored in memory using <a target=\"_blank\" href=\"http://www.danga.com/memcached/\">memcached</a> and its <a target=\"_blank\" href=\"http://www.php.net/memcache\">PHP extension</a>. You must set up a memcached server in order to use this option.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1274', '1', 'Successfully initialized. The Memcache extension was detected.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1275', '1', 'The Memcache extension was not detected or we were unable to connect to the memcached server.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1276', '1', 'Use compression?', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1277', '1', 'Compression will decrease the amount of memory used, however will increase processor usage.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1278', '1', 'Enable compression', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1279', '1', 'Memcached server configuration.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1280', '1', 'Click <a href=\"%1$s\" onclick=\"%2$s\">here</a> to add an additional server.', 'admin_cache, admin_session');
INSERT INTO `se_languagevars` VALUES ('1281', '1', 'Host', 'admin_cache, admin_session');
INSERT INTO `se_languagevars` VALUES ('1282', '1', 'Port', 'admin_cache, admin_session');
INSERT INTO `se_languagevars` VALUES ('1283', '1', 'export', 'admin_language');
INSERT INTO `se_languagevars` VALUES ('1284', '1', 'Import Pack from File', 'admin_language');
INSERT INTO `se_languagevars` VALUES ('1285', '1', 'Language Import Tool', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1286', '1', 'Here you can import a language pack from an exported file. If generated by SocialEngine, the file will contain all of the necessary info to create a new language pack.', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1287', '1', 'Updated:', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1288', '1', 'Inserted:', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1289', '1', 'Skipped:', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1290', '1', 'Failed:', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1291', '1', 'Import Options', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1292', '1', 'Please select an existing language or \"New Language\". If you select \"New Language\", the imported file will be used to create a new language pack.', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1293', '1', 'New Language', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1294', '1', 'You are about to replace an existing language pack with the one you are importing. Any new language phrases in the imported file will be added automatically. How do you want to handle changes to existing language phrases?', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1295', '1', 'Replace all phrases with those in the imported file.', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1296', '1', 'Do not replace any existing phrases, just add new ones.', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1297', '1', 'Please select a language file to import.', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1298', '1', 'Import', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1299', '1', 'SocialEngine uses sessions to authenticate users and keep them logged-in. The settings below only need to be changed if your users are having trouble logging in (e.g. if your server does not allow native sessions) or if you want to improve system performance by enabling Memcache sessions. If you are not familiar with sessions, we do not recommend that you change any of these settings.', 'admin_session');
INSERT INTO `se_languagevars` VALUES ('1300', '1', 'General Session Settings', 'admin_session');
INSERT INTO `se_languagevars` VALUES ('1301', '1', 'The native method uses the current setting of <a href=\"http://www.php.net/manual/en/session.configuration.php\">session.save_handler</a>, in php.ini, which is file-based by default. <b>Note: If you change the session storage method, all of your users will be logged out.</b>', 'admin_session');
INSERT INTO `se_languagevars` VALUES ('1302', '1', 'Native', 'admin_session');
INSERT INTO `se_languagevars` VALUES ('1303', '1', 'How many seconds of inactivity is allowed before the session expires? An expired session will cause the user to be logged out and may invalidate forms that were partially filled out. This cannot be disabled, instead set it to a high value such as 259200 (3 days).', 'admin_session');
INSERT INTO `se_languagevars` VALUES ('1304', '1', 'File Session Settings', 'admin_session');
INSERT INTO `se_languagevars` VALUES ('1305', '1', 'If you have enabled file-based sessions above, please provide the path (relative to your SocialEngine base directory) to where you want to store session data. This directory must be writable (chmod 777).', 'admin_session');
INSERT INTO `se_languagevars` VALUES ('1306', '1', 'Memcache Session Settings', 'admin_session');
INSERT INTO `se_languagevars` VALUES ('1307', '1', 'Memcached supports multiple servers.', 'admin_session');
INSERT INTO `se_languagevars` VALUES ('1308', '1', 'Could not read file.', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1309', '1', 'A language code was not specified in the file.', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1310', '1', 'A language name was not specified in the file.', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1311', '1', 'Could not create new language', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1312', '1', 'Admin Interface Language', 'admin_home');
INSERT INTO `se_languagevars` VALUES ('1313', '1', 'If you have multiple language packs installed, you can change the language the admin interface is displayed in.', 'admin_home');
INSERT INTO `se_languagevars` VALUES ('1314', '1', 'You have not yet deleted install.php and/or installsql.php. Leaving these files on your server is a security risk!', 'admin_home');
INSERT INTO `se_languagevars` VALUES ('1315', '1', 'You have not yet deleted upgrade.php and/or upgradesql.php. Leaving these files on your server is a security risk!', 'admin_home');
INSERT INTO `se_languagevars` VALUES ('1316', '1', 'More ...', 'header');
INSERT INTO `se_languagevars` VALUES ('1317', '1', 'More ...', 'profile');
INSERT INTO `se_languagevars` VALUES ('1318', '1', 'Some problems have been detected with your installation or server configuration.', 'admin_home');
INSERT INTO `se_languagevars` VALUES ('1319', '1', 'Click to expand.', 'admin_home');
INSERT INTO `se_languagevars` VALUES ('1320', '1', 'Your version file (%1$s) does not contain the same version as your database (%2$s). You may have not uploaded include/version.php or not run the upgrade script. In the latter case, database corruption may occur if using different file and database versions.', 'admin_home');
INSERT INTO `se_languagevars` VALUES ('1321', '1', 'Reply could not be sent because the recipient blocked you.', 'user_messages_view');
INSERT INTO `se_languagevars` VALUES ('1', '2', 'Panel del Administrador', 'admin_header_global,');
INSERT INTO `se_languagevars` VALUES ('2', '2', 'Gestión de la Red', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('3', '2', 'Resumen', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('4', '2', 'Ver usuarios', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('5', '2', 'Ver administradores', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('6', '2', 'Ver informes', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('7', '2', 'Ver plugins', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('8', '2', 'Niveles de usuario', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('9', '2', 'Subredes', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('10', '2', 'Campañas publicitarias', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('11', '2', 'Configuración global', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('12', '2', 'Configuración general', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('13', '2', 'Configuración de registro', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('14', '2', 'Informe de actividad reciente ', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('15', '2', 'Plantillas HTML', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('16', '2', 'Campos del perfil', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('17', '2', 'Suprimir/Spam', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('18', '2', 'Conexiones de usuarios', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('19', '2', 'Configuración de URL ', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('20', '2', 'Correos electrónicos del sistema', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('21', '2', 'Otras herramientas', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('22', '2', 'Invitar usuarios', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('23', '2', 'Anuncios', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('24', '2', 'Estadísticas', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('25', '2', 'Registro de acceso', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('26', '2', 'Finalización de la sesión', 'admin_header');
INSERT INTO `se_languagevars` VALUES ('27', '2', 'Acceso del administrador ', '');
INSERT INTO `se_languagevars` VALUES ('28', '2', 'Nombre de usuario', 'user_account, signup, admin_viewusers, admin_viewreports, admin_viewadmins, admin_login,');
INSERT INTO `se_languagevars` VALUES ('29', '2', 'Contraseña', 'signup, login, home, admin_login,');
INSERT INTO `se_languagevars` VALUES ('30', '2', 'Inicio de sesión', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_login,');
INSERT INTO `se_languagevars` VALUES ('31', '2', 'Su navegador no tiene Javascript activado.  Por favor active el Javascript y vuelva a intentarlo.', 'admin_login,');
INSERT INTO `se_languagevars` VALUES ('32', '2', 'Los datos de acceso proporcionados no eran válidos.  ¿Ha <a href=\'admin_lostpass.php\'> olvidado su contraseña</ a>?', 'admin_login,');
INSERT INTO `se_languagevars` VALUES ('33', '2', 'Contraseña perdida', 'lostpass, admin_lostpass,');
INSERT INTO `se_languagevars` VALUES ('34', '2', 'Si no puede iniciar sesión porque ha olvidado su contraseña, por favor, introduzca su dirección de correo electrónico en el campo de abajo.', 'lostpass, admin_lostpass,');
INSERT INTO `se_languagevars` VALUES ('35', '2', 'Se le ha enviado un mensaje de correo electrónico con instrucciones sobre cómo restablecer su contraseña.  Si el mensaje no llega en varios minutos, asegúrese de revisar su spam (correo basura) o las carpetas de correo basura.', 'lostpass, admin_lostpass,');
INSERT INTO `se_languagevars` VALUES ('36', '2', 'El correo electrónico que ha introducido no se ha encontrado en la base de datos. Por favor, inténtelo de nuevo.', 'admin_lostpass,');
INSERT INTO `se_languagevars` VALUES ('37', '2', 'Dirección de correo electrónico:', 'signup, lostpass, help_contact, admin_viewusers_edit, admin_lostpass,');
INSERT INTO `se_languagevars` VALUES ('38', '2', 'Enviar ', 'admin_lostpass,');
INSERT INTO `se_languagevars` VALUES ('39', '2', 'Cancelar', 'user_report, user_messages_new, user_home, user_friends_manage, user_friends_block, user_account_delete, profile, lostpass_reset, lostpass, admin_viewusers_edit, admin_viewusers, admin_viewadmins, admin_subnetworks, admin_profile, admin_lostpass_reset, admin_lostpass, admin_levels, admin_language_edit, admin_language, admin_fields, admin_faq, admin_announcements, admin_ads_modify, admin_ads,');
INSERT INTO `se_languagevars` VALUES ('40', '2', 'Solicitar restablecer contraseña de administrador de SocialEngine ', 'admin_lostpass,');
INSERT INTO `se_languagevars` VALUES ('41', '2', 'Hola, Ha solicitado restablecer su contraseña de administrador de SocialEngine. Si desea hacerlo, por favor haga clic en el enlace que aparece a continuación. Si no ha solicitado restablecer una contraseña, simplemente ignore este mensaje. [enlace] Gracias\"', 'admin_lostpass,');
INSERT INTO `se_languagevars` VALUES ('42', '2', 'Restablecer la contraseña', 'lostpass_reset, admin_lostpass_reset,');
INSERT INTO `se_languagevars` VALUES ('43', '2', ' Restablecimiento de la contraseña olvidada', 'lostpass_reset, admin_lostpass_reset,');
INSERT INTO `se_languagevars` VALUES ('44', '2', 'Su contraseña se ha restablecido.  <a href=\'admin_login.php\'> Haga clic aquí </ a> para acceder a su cuenta.', 'admin_lostpass_reset,');
INSERT INTO `se_languagevars` VALUES ('45', '2', 'Complete el formulario que aparece a continuación para restablecer su contraseña.', 'lostpass_reset, admin_lostpass_reset,');
INSERT INTO `se_languagevars` VALUES ('46', '2', 'Nueva contraseña', 'user_account_pass, lostpass_reset, admin_viewadmins, admin_lostpass_reset,');
INSERT INTO `se_languagevars` VALUES ('47', '2', 'Confirme la nueva contraseña', 'user_account_pass, lostpass_reset, admin_viewadmins, admin_lostpass_reset,');
INSERT INTO `se_languagevars` VALUES ('138', '2', 'Valor ', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('50', '2', 'Este enlace no es válido o ha caducado. Por favor  <a href=\'admin_lostpass.php\'> vuelva a enviar</ a> la solicitud de su contraseña y haga clic en el enlace enviado a su dirección de correo electrónico.', 'admin_lostpass_reset,');
INSERT INTO `se_languagevars` VALUES ('51', '2', 'Por favor, asegúrese de que ha completado todos los campos.', 'signup, admin_viewadmins,');
INSERT INTO `se_languagevars` VALUES ('52', '2', 'Los campos de  nombre de usuario y contraseña deben ser alfa-numéricos.', 'admin_viewadmins, admin_lostpass_reset,');
INSERT INTO `se_languagevars` VALUES ('53', '2', 'La contraseña debe tener al menos 6 caracteres.', 'signup, admin_lostpass_reset,');
INSERT INTO `se_languagevars` VALUES ('54', '2', 'Los campos de la contraseña y la confirmación de la contraseña deben coincidir.', 'admin_lostpass_reset,');
INSERT INTO `se_languagevars` VALUES ('55', '2', '¡Hola, Administrador!', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('56', '2', 'Bienvenidos a Social Network', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('57', '2', 'Advertencia:  Usted todavía no ha eliminado install.php y/o installsql.php. Dejar estos archivos en su servidor es ¡un riesgo para la seguridad!', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('58', '2', 'Licencia de SocialEngine:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('59', '2', 'Versión:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('60', '2', 'Actualización disponible', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('500404', '2', '', '');
INSERT INTO `se_languagevars` VALUES ('61', '2', 'Total de usuarios:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('62', '2', 'Comentarios:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('63', '2', 'Mensajes privados:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('64', '2', 'Niveles de usuario:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('65', '2', 'Subredes:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('66', '2', 'Denuncias de abuso:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('67', '2', 'Amistades:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('68', '2', 'Noticias publicadas:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('69', '2', 'Visitas de hoy:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('70', '2', 'Registros de hoy:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('71', '2', 'Accesos de hoy:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('72', '2', 'Cuentas del administrador:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('73', '2', 'Usuario(s) en línea:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('74', '2', ' <h2> Primeros pasos </h2> Si usted acaba de configurar SocialEngine y está dispuesto a construir su red social, le ofrecemos algunas sugerencias útiles:', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('75', '2', 'Crear campos de perfil', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('76', '2', 'Entre los aspectos principales de su red social se encuentran sus campos de perfil. Estos determinan el tipo de información que los usuarios comparten entre sí sobre sus perfiles. Estos son elementos esenciales que enfatizan el tema o asunto exclusivo de su red social.', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('77', '2', 'Editar la configuración de registro', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('78', '2', 'Después de haber creado sus campos de perfil, usted deberá personalizar el proceso de registro de usuario.  Aquí puede especificar la información que los usuarios deberán proporcionar y otros detalles importantes, lo hagan o no, estos deben ser invitados a registrarse.', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('79', '2', 'Editar el nivel de usuario por defecto', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('80', '2', 'Ahora, definamos las características a las que los usuarios tienen acceso y qué límites y pondremos en sus cuentas. Esto se puede lograr editando el nivel de usuario por defecto o creando nuevos niveles de usuario.', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('81', '2', 'Instalar plugins', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('82', '2', 'Los plugins le brindan a su red social funcionalidad e interactividad adicionales.  Si ya ha comprado algunos plugins, este es el momento ideal para instalar y configurar sus ajustes.', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('83', '2', 'Personalizar su aspecto visual y emocional', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('84', '2', 'El siguiente paso es otorgar a su nueva red social ¡su propio estilo!  Se puede editar cualquiera de las plantillas HTML (incluida una plantilla de cabecera global y un archivo CSS) para agregar su propio diseño. ', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('86', '2', 'Esta página contiene una lista de los últimos 300 intentos de acceso.  Utilice esta página para observar los intentos sospechosos de acceso a su red social.', 'admin_log,');
INSERT INTO `se_languagevars` VALUES ('87', '2', 'ID', 'admin_viewusers, admin_viewreports, admin_viewadmins, admin_subnetworks, admin_log, admin_levels, admin_language_edit, admin_announcements, admin_ads,');
INSERT INTO `se_languagevars` VALUES ('88', '2', 'Fecha ', 'admin_log, admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('89', '2', 'Correo electrónico', 'login, home, admin_viewusers, admin_viewadmins, admin_log,');
INSERT INTO `se_languagevars` VALUES ('90', '2', 'Resultados', 'admin_log,');
INSERT INTO `se_languagevars` VALUES ('91', '2', 'IP', 'admin_log,');
INSERT INTO `se_languagevars` VALUES ('92', '2', 'Exitoso', 'admin_log,');
INSERT INTO `se_languagevars` VALUES ('93', '2', 'Falló', 'admin_log,');
INSERT INTO `se_languagevars` VALUES ('95', '2', 'Los usuarios se distinguirán a través de sus propias páginas de perfil. Usted debe darles campos de perfil, los cuales les permiten describirse de una manera relevante para el tema de su red social.  En esta página, se pueden crear categorías de perfil, pestañas, y campos. <br><br> Si desea que todos los usuarios de su red social tengan los mismos campos de perfil, sólo se necesita crear un tipo de perfil.  Por otro lado, por ejemplo, si se desea  tener perfiles de “Músicos” y de “Fans”, se tendrá que crear dos tipos de perfil.  Se puede crear un conjunto único de pestañas y de campos para cada tipo de perfil, lo que implica que los músicos y los fans deberán completar cada uno un campo de perfil diferente. Si se ha creado más de un tipo de perfil, los usuarios seleccionarán su tipo de perfil cuando se registran. <br><br> Las pestañas del perfil le permiten organizar sus campos de perfil en secciones. Las pestañas comúnmente utilizadas son las de “Información personal”, “Información de contacto”, “Acerca de mí”, etc., pero se deben crear pestañas que organicen los campos correctamente. <br><br> Los campos de perfil son los campos de entrada reales en los que sus usuarios introducirán su información.  Del mismo modo, estos deben ser pertinentes para el tema exclusivo de su red social. <br> <br> Por favor, recuerde que si usted tiene paquetes de idioma adicionales, se pueden traducir la categoría, las pestañas, y los nombres de campo en la página de<a href = \'admin_language.php \"> Configuración de idioma</a>.', 'admin_profile,');
INSERT INTO `se_languagevars` VALUES ('96', '2', 'Por favor, asegúrese de haber completado todos los campos obligatorios.', '');
INSERT INTO `se_languagevars` VALUES ('97', '2', 'Por favor, asegúrese de haber completado los campos en el formato adecuado.', '');
INSERT INTO `se_languagevars` VALUES ('98', '2', 'Pestañas', 'admin_profile, admin_fields,');
INSERT INTO `se_languagevars` VALUES ('99', '2', 'Añadir pestaña', 'admin_profile, admin_fields,');
INSERT INTO `se_languagevars` VALUES ('100', '2', 'Campos', 'admin_profile, admin_fields,');
INSERT INTO `se_languagevars` VALUES ('101', '2', 'Añadir campo', 'admin_profile, admin_fields,');
INSERT INTO `se_languagevars` VALUES ('102', '2', 'Campo dependiente', 'admin_profile, admin_fields,');
INSERT INTO `se_languagevars` VALUES ('103', '2', 'Categorías de perfil  ', 'admin_profile,');
INSERT INTO `se_languagevars` VALUES ('104', '2', 'Añadir categoría ', 'admin_profile, admin_faq,');
INSERT INTO `se_languagevars` VALUES ('106', '2', 'Título del campo:', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('105', '2', '¿Está seguro que desea eliminar esta categoría?  NOTA: Si está eliminando una categoría principal, todas las subcategorías y los campos se eliminarán también.', 'admin_profile, admin_fields,');
INSERT INTO `se_languagevars` VALUES ('107', '2', 'Categoría:', 'admin_fields, admin_faq,');
INSERT INTO `se_languagevars` VALUES ('108', '2', 'Pestaña:', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('109', '2', 'Tipo de campo:', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('110', '2', 'Campo de texto ', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('111', '2', 'Área de texto multilínea ', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('112', '2', 'Casilla de selección desplegable', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('113', '2', 'Botones de opción', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('114', '2', 'Campo de la fecha', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('115', '2', 'Estilo en línea CSS:', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('116', '2', 'Descripción del campo: ', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('117', '2', 'Mensaje de error personalizado: ', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('118', '2', 'Obligatorio:', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('119', '2', 'No obligatorio', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('120', '2', 'Obligatorio', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('121', '2', 'Tipo de búsqueda:', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('122', '2', 'No mostrar el campo de búsqueda', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('123', '2', 'Búsqueda de valor exacto ', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('124', '2', 'Búsqueda de rango ', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('125', '2', 'Si desea que sus usuarios tengan la posibilidad de realizar búsquedas basadas en este campo, se debe elegir ya sea una “búsqueda de valor exacto ”, o una “búsqueda de rango”. Si selecciona \"búsqueda de valor exacto\", los resultados tendrán que coincidir con el valor exacto de búsqueda introducido por el usuario.  Si selecciona la opción \"Búsqueda de rango\", los usuarios podrán introducir valores de búsqueda mínimos y máximos.    Esto es útil para campos numéricos como el \"precio\", \"pies cuadrados\", y \"edad\". Tenga en cuenta que la \"búsqueda de rango\" no funciona para los campos de fecha.', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('126', '2', 'Etiquetas HTML permitidas:', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('127', '2', 'De forma predeterminada, el usuario no podrá añadir ninguna etiqueta HTML en este campo del perfil.  Si desea permitir etiquetas específicas, puede introducirlas más arriba (separadas por comas). Ejemplo: <i> b, img, a, incrustar, fuente<i>', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('128', '2', 'Campo Maxlength:', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('129', '2', 'Vincular el campo con:', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('130', '2', 'Si usted desea que este campo se vincule con otra URL, introduzca el formato de enlace que se encuentra más arriba.  Tenga en cuenta que esto anulará la configuración de \"búsqueda/ relacionada\" de más arriba. Utilice [field_value] para representar la entrada del usuario para este campo. Ejemplos:  <i>Enlace regular (si la entrada del usuario es una URL, debe comenzar con \"http://\"):</i> <strong>[field_value]</strong><br><i>enlace Mailto (si la entrada del usuario es una dirección de correo electrónico):</i> <strong> mailto:[field_value]</strong> <br><i> enlace AIM (si la entrada del usuario es un screenname AIM):</i> <strong>aim:goim?screenname=[field_value]</strong>', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('131', '2', 'Validación Regex:', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('132', '2', 'Si desea exigir al usuario que introduzca datos en un determinado formato, ingrese la expresión usual correspondiente de más arriba. Se aplicará un preg_match() cuando el usuario introduzca datos. Esto es opcional, si usted no entiende o necesita expresiones usuales, déjelo en blanco.', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('133', '2', 'Opciones:', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('134', '2', 'Etiqueta', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('135', '2', '¿Dependencia?', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('136', '2', 'Etiqueta de campo dependiente ', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('137', '2', 'Añadir nueva opción', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('140', '2', 'Editar campo', 'admin_profile, admin_fields,');
INSERT INTO `se_languagevars` VALUES ('141', '2', 'Eliminar campo', 'admin_profile, admin_fields,');
INSERT INTO `se_languagevars` VALUES ('142', '2', '¿Está seguro que desea eliminar este campo? ', 'admin_profile, admin_fields,');
INSERT INTO `se_languagevars` VALUES ('144', '2', 'No existe campo dependiente', 'admin_profile, admin_fields,');
INSERT INTO `se_languagevars` VALUES ('145', '2', 'Sí, tiene campo dependiente ', 'admin_profile, admin_fields,');
INSERT INTO `se_languagevars` VALUES ('139', '2', 'Añadir opciones como: casilla de selección, botón de opción o casilla de verificación, completando los campos a continuación.  El campo de valor debería ser un entero positivo, y cada una de las opciones debe tener un valor único.  Si desea que se muestre un campo adicional cuando un usuario selecciona una de sus opciones, se puede crear un campo dependiente para esa opción.', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('148', '2', 'Editar campo dependiente', 'admin_profile, admin_fields,');
INSERT INTO `se_languagevars` VALUES ('146', '2', 'Debe introducir un entero no negativo para los valores de opción.', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('143', '2', 'Debe introducir al menos una opción.', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('94', '2', 'Por favor, introduzca un título para el campo.', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('85', '2', 'Debe especificar un tipo de campo.', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('48', '2', 'Configuración de diseños', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('49', '2', 'Configuración de idioma', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('147', '2', 'El diseño de su red social incluye cientos de frases de texto que se almacenan en un paquete de idioma. SocialEngine viene con un paquete en idioma Inglés que es el valor por defecto ofrecido cuando se instala la plataforma por primera vez. Si desea cambiar alguna de estas frases en su red social, puede modificar el paquete que se encuentra a continuación.   Si desea permitir que los usuarios elijan entre varios idiomas, también puede crear nuevos paquetes a continuación. Si tiene varios paquetes de idioma, el que ha seleccionado como su \"paquete por defecto\", será el idioma que se mostrará si un usuario no ha seleccionado ningún otro idioma. Nota: No se puede eliminar el idioma por defecto.   Para editar detalles de un idioma, haga clic en su nombre.', 'admin_language,');
INSERT INTO `se_languagevars` VALUES ('149', '2', 'Nombre del idioma ', 'admin_language,');
INSERT INTO `se_languagevars` VALUES ('150', '2', 'Código del idioma', 'admin_language,');
INSERT INTO `se_languagevars` VALUES ('151', '2', 'Autodetección Regex', 'admin_language,');
INSERT INTO `se_languagevars` VALUES ('152', '2', 'Por defecto', 'lostpass, admin_viewusers, admin_levels, admin_language,');
INSERT INTO `se_languagevars` VALUES ('153', '2', 'Opciones', 'admin_viewusers, admin_viewreports, admin_viewadmins, admin_subnetworks, admin_levels, admin_language, admin_faq, admin_announcements, admin_ads,');
INSERT INTO `se_languagevars` VALUES ('154', '2', 'Editar frases', 'admin_language,');
INSERT INTO `se_languagevars` VALUES ('155', '2', 'Eliminar ', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_viewusers, admin_viewreports, admin_viewadmins, admin_subnetworks, admin_levels, admin_language, admin_faq, admin_announcements, admin_ads,');
INSERT INTO `se_languagevars` VALUES ('156', '2', 'Crear un nuevo paquete de idioma', 'admin_language,');
INSERT INTO `se_languagevars` VALUES ('157', '2', 'Eliminar el paquete de idioma', 'admin_language,');
INSERT INTO `se_languagevars` VALUES ('158', '2', 'Crear un paquete de idioma', 'admin_language,');
INSERT INTO `se_languagevars` VALUES ('159', '2', 'Editar un paquete de idioma', 'admin_language,');
INSERT INTO `se_languagevars` VALUES ('160', '2', 'Configuración de la selección de idioma', 'admin_language,');
INSERT INTO `se_languagevars` VALUES ('161', '2', 'Si usted tiene más de un paquete de idiomas, ¿desea permitir que sus <b>usuarios registrados</b> elijan cuál de ellos se utilizará mientras están conectados?  Si selecciona \"Sí\", los usuarios podrán elegir su idioma en la página de registro y en la página de configuración de la cuenta. Tenga en cuenta que esto sólo se aplica si usted tiene más de un paquete de idiomas.', 'admin_language,');
INSERT INTO `se_languagevars` VALUES ('162', '2', 'Sí, permitir que los usuarios registrados elijan su propio idioma.', 'admin_language,');
INSERT INTO `se_languagevars` VALUES ('163', '2', 'No, no permitir que los usuarios registrados guarden sus preferencias de idioma.', 'admin_language,');
INSERT INTO `se_languagevars` VALUES ('164', '2', 'Si usted tiene más de un paquete de idiomas, ¿desea mostrar un cuadro de selección en su página principal para que los <b> usuarios no registrados</b> puedan cambiar el idioma en que visualizan la red social? Tenga en cuenta que esto sólo se aplica si usted tiene más de un paquete de idiomas.', 'admin_language,');
INSERT INTO `se_languagevars` VALUES ('165', '2', 'Sí, mostrar un cuadro de selección que les permitirá a los usuarios no registrados cambiar su idioma.', 'admin_language,');
INSERT INTO `se_languagevars` VALUES ('166', '2', 'No, no permitir que los usuarios no registrados cambien el idioma del sitio.', 'admin_language,');
INSERT INTO `se_languagevars` VALUES ('167', '2', 'Si usted tiene más de un paquete de idiomas, ¿desea que el sistema detecte de manera automática la configuración de idioma de los navegadores de sus visitantes?  Si selecciona \"Sí\", el sistema intentará detectar el idioma que el usuario ha establecido en la configuración de su navegador. Si se detecta la concordancia de idioma, su sitio se mostrará en ese idioma, de lo contrario se mostrará en el idioma por defecto. <br><br> El sistema utiliza regexes usados para detectar el idioma del visitante. Ellos se ejecutan en base a la cabecera de petición  \"HTTP_ACCEPT_LANGUAGE\" después de que esta ha sido limpiada. Por ejemplo, he aquí una copia de la configuración de idioma su navegador:', 'admin_language,');
INSERT INTO `se_languagevars` VALUES ('168', '2', 'Su HTTP_ACCEPT_LANGUAGE es:', 'admin_language,');
INSERT INTO `se_languagevars` VALUES ('169', '2', 'Su HTTP_ACCEPT_LANGUAGE después de la limpieza:', 'admin_language,');
INSERT INTO `se_languagevars` VALUES ('170', '2', 'Su idioma automáticamente detectado con la configuración actual:', 'admin_language,');
INSERT INTO `se_languagevars` VALUES ('171', '2', 'Sí, intentar detectar el idioma del visitante sobre la base de la configuración de su navegador.', 'admin_language,');
INSERT INTO `se_languagevars` VALUES ('172', '2', 'No, no detectar automáticamente el idioma del visitante.', 'admin_language,');
INSERT INTO `se_languagevars` VALUES ('173', '2', 'Guardar cambios', 'user_home, user_editprofile_style, user_editprofile, user_account_privacy, user_account_pass, user_account, admin_viewusers_edit, admin_url, admin_templates, admin_signup, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_language, admin_general, admin_emails, admin_connections, admin_banning, admin_ads_modify, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('174', '2', '¿Está seguro que desea eliminar este paquete de idioma? ', 'admin_language,');
INSERT INTO `se_languagevars` VALUES ('175', '2', 'Eliminar ', 'user_account_delete, profile, admin_viewusers, admin_viewadmins, admin_subnetworks, admin_levels, admin_language, admin_faq, admin_announcements, admin_ads,');
INSERT INTO `se_languagevars` VALUES ('176', '2', 'Por favor, introduzca un nombre para su idioma.', 'admin_language,');
INSERT INTO `se_languagevars` VALUES ('177', '2', 'Por favor, introduzca el nombre del idioma de su paquete de idioma, código del idioma (usado para determinar las cabeceras de contenido), código setlocale y regex en los campos a continuación. El código setlocale le permite mostrar las fechas en otros idiomas y utiliza la función PHP <a href=\'http://www.php.net/manual/en/function.setlocale.php\'>setlocale()</a>. Todas las configuraciones de los entornos (locales) disponibles para su servidor se proporcionan a continuación.  Si se le da la opción, seleccione el código locale con \"utf8\" en él, de lo contrario las fechas no se mostrarán correctamente.  Si deja este campo en blanco, se utilizará el idioma por defecto del servidor.', 'admin_language,');
INSERT INTO `se_languagevars` VALUES ('178', '2', 'Utilice esta página para editar las frases de texto dentro de este paquete de idioma. Tenga en cuenta que puede utilizar el cuadro de búsqueda para encontrar la frase específica que está buscando. Si no puede encontrar la frase, intente utilizar sólo una o dos palabras de la frase en el cuadro de búsqueda. Cuando edite una frase, aparecerá una pequeña ventana con una casilla para cada paquete de idioma (si tiene más de uno), usted puede introducir todas las distintas traducciones para esa frase en sus respectivas casillas. Después de cerrar esta ventana emergente, se resaltará automáticamente el enlace \"editar\" para la siguiente frase. Si desea editar la siguiente frase, puede pulsar la tecla \"Enter\" del teclado para abrir la siguiente frase rápidamente. Tenga en cuenta que si cambia las frases del panel del administrador, puede que tenga que actualizar la página para ver los cambios.', 'admin_language_edit,');
INSERT INTO `se_languagevars` VALUES ('179', '2', '<b> Nota:  Usted no tiene ninguna frase en este paquete de idioma.  Para añadir frases, vaya a otro paquete de idioma y edite las frases allí, usted podrá proporcionar traducciones para este paquete de idioma.</b>', 'admin_language_edit,');
INSERT INTO `se_languagevars` VALUES ('180', '2', 'Frase parcial:', 'admin_language_edit,');
INSERT INTO `se_languagevars` VALUES ('181', '2', 'Buscar frase', 'admin_language_edit,');
INSERT INTO `se_languagevars` VALUES ('182', '2', 'Última página ', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_language_edit,');
INSERT INTO `se_languagevars` VALUES ('183', '2', 'Página siguiente', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_language_edit,');
INSERT INTO `se_languagevars` VALUES ('184', '2', 'Ver resultado %1$s de %2$s', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_language_edit,');
INSERT INTO `se_languagevars` VALUES ('185', '2', 'Ver resultados %1$s-%2$s de %3$s', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_language_edit,');
INSERT INTO `se_languagevars` VALUES ('186', '2', 'Frase', 'admin_language_edit,');
INSERT INTO `se_languagevars` VALUES ('187', '2', 'Editar ', 'profile, admin_viewusers, admin_viewadmins, admin_subnetworks, admin_levels, admin_language_edit, admin_faq, admin_announcements, admin_ads,');
INSERT INTO `se_languagevars` VALUES ('188', '2', 'Editar frase', 'admin_language_edit,');
INSERT INTO `se_languagevars` VALUES ('189', '2', 'Cambie las frases en los idiomas a continuación:', 'admin_language_edit,');
INSERT INTO `se_languagevars` VALUES ('190', '2', 'Esta página contiene configuraciones generales que afectan a toda su red social.', 'admin_general,');
INSERT INTO `se_languagevars` VALUES ('191', '2', 'Sus cambios se han guardado.', 'user_editprofile_style, user_editprofile, user_account_privacy, user_account_pass, admin_url, admin_signup, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_general, admin_emails, admin_connections, admin_banning, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('192', '2', 'Valores predeterminados de permiso público', 'admin_general,');
INSERT INTO `se_languagevars` VALUES ('193', '2', 'Seleccione si desea o no permitir al público (visitantes que no se han identificado) ver las siguientes secciones de su red social. En algunos casos (como en de los perfiles), si les ha ofrecido la opción, los usuarios podrán hacer sus páginas privadas a pesar de que usted las haya hecho públicamente visibles aquí.', 'admin_general,');
INSERT INTO `se_languagevars` VALUES ('194', '2', 'Perfiles', 'admin_general,');
INSERT INTO `se_languagevars` VALUES ('195', '2', 'Sí, el público puede ver los perfiles, a menos que se hayan convertido en privados.', 'admin_general,');
INSERT INTO `se_languagevars` VALUES ('196', '2', 'El público no puede ver los perfiles.', 'admin_general,');
INSERT INTO `se_languagevars` VALUES ('197', '2', 'Página de invitación', 'admin_general,');
INSERT INTO `se_languagevars` VALUES ('198', '2', 'Sí, el público puede usar la página de invitación.', 'admin_general,');
INSERT INTO `se_languagevars` VALUES ('199', '2', 'No, el público no puede usar la página de invitación.', 'admin_general,');
INSERT INTO `se_languagevars` VALUES ('200', '2', 'Página de búsqueda', 'admin_general,');
INSERT INTO `se_languagevars` VALUES ('201', '2', 'Sí, el público puede usar la página de búsqueda.', 'admin_general,');
INSERT INTO `se_languagevars` VALUES ('202', '2', 'No, el público no puede usar la página de búsqueda.', 'admin_general,');
INSERT INTO `se_languagevars` VALUES ('203', '2', 'Página de inicio', 'admin_general,');
INSERT INTO `se_languagevars` VALUES ('204', '2', 'Sí, el público puede ver la página de inicio.', 'admin_general,');
INSERT INTO `se_languagevars` VALUES ('205', '2', 'No, el público no puede ver la página de inicio.', 'admin_general,');
INSERT INTO `se_languagevars` VALUES ('206', '2', 'Zona horaria', 'user_account, signup, admin_general,');
INSERT INTO `se_languagevars` VALUES ('207', '2', 'Por favor, elija una configuración de zona horaria predeterminada para su red social.  Esta será la zona horaria predeterminada que se aplicará a las cuentas de usuarios si estos no seleccionan una zona horaria durante el proceso de registro, o si no han iniciado su sesión.', 'admin_general,');
INSERT INTO `se_languagevars` VALUES ('208', '2', 'Formato de fecha', 'admin_general,');
INSERT INTO `se_languagevars` VALUES ('209', '2', 'Seleccione el formato de fecha que desea utilizar en su red social.  Esto afectará la apariencia de las fechas que aparecen en sus páginas de la red social.', 'admin_general,');
INSERT INTO `se_languagevars` VALUES ('210', '2', 'Las redes sociales son a menudo el blanco de agresivas tácticas de spam. Estas, la mayoría de las veces, llegan en forma de cuentas de usuario falsas y de spam en los comentarios. En esta página, puede administrar varias funciones anti-spam y de censura. Nota: Para activar la función de verificación de imagen de registro (una popular herramienta anti-spam) consulte la página <a href=\'admin_signup.php\'>Configuración de registro</a>.', 'admin_banning,');
INSERT INTO `se_languagevars` VALUES ('211', '2', 'Bloquear usuarios por su dirección IP', 'admin_banning,');
INSERT INTO `se_languagevars` VALUES ('212', '2', 'Para bloquear usuarios por su dirección IP, introduzca su dirección en el campo de abajo. Las direcciones deben estar separadas por comas, como <i>123.456.789.123, 23.45.67.89</i> ', 'admin_banning,');
INSERT INTO `se_languagevars` VALUES ('213', '2', 'Bloquear usuarios por su dirección de correo electrónico', 'admin_banning,');
INSERT INTO `se_languagevars` VALUES ('214', '2', 'Para bloquear usuarios por su dirección de correo electrónico, introduzca sus correos electrónicos en el campo de abajo.  Los correos electrónico deben estar separados por comas, como <i>user1@domain1.com, user2@domain2.com</i>. Tenga en cuenta que puede bloquear todas las direcciones de correo electrónico con un dominio específico de la siguiente manera: <i>*@domain.com</i>', 'admin_banning,');
INSERT INTO `se_languagevars` VALUES ('215', '2', 'Bloquear usuarios por nombre de usuario', 'admin_banning,');
INSERT INTO `se_languagevars` VALUES ('216', '2', 'Introduzca el nombre de los usuarios que no estén permitidos en su red social. Los nombres de usuario deben estar separados por comas, como <i>username1, username2</i>.', 'admin_banning,');
INSERT INTO `se_languagevars` VALUES ('217', '2', 'Palabras censuradas en los perfiles y plugins', 'admin_banning,');
INSERT INTO `se_languagevars` VALUES ('218', '2', 'Introduzca las palabras que usted desea censurar en los perfiles de sus usuarios, así como cualquier plugin que haya instalado.  Estas serán reemplazadas por asteriscos (*).  Separe las palabras por comas, como <i>word1, word2</i>', 'admin_banning,');
INSERT INTO `se_languagevars` VALUES ('219', '2', '¿Desea exigir a los usuarios que introduzcan el código de validación al realizar comentarios?', 'admin_banning,');
INSERT INTO `se_languagevars` VALUES ('220', '2', 'Si ha seleccionado “Sí”, los usuarios visualizarán una imagen que contiene una secuencia aleatoria de 6 números en la página “escribir un comentario”.  Los usuarios deberán introducir estos números en el campo del “Código de verificación” con el fin de publicar sus comentarios. Esta aplicación ayuda a evitar que los usuarios traten de crear comentarios no deseados (spam).  Para que esta aplicación funcione correctamente, su servidor debe tener el GD Libraries (2.0 o superior) instalado y configurado para trabajar con PHP. Si observa errores, intente desactivarla.', 'admin_banning,');
INSERT INTO `se_languagevars` VALUES ('221', '2', 'Sí, activar el código de verificación para la realización de comentarios.', 'admin_banning,');
INSERT INTO `se_languagevars` VALUES ('222', '2', 'No, desactivar el código de verificación para la realización de comentarios.', 'admin_banning,');
INSERT INTO `se_languagevars` VALUES ('223', '2', '¿Desea exigir a los usuarios que introduzcan el código de verificación cuando invitan a otros?', 'admin_banning,');
INSERT INTO `se_languagevars` VALUES ('224', '2', 'Si ha seleccionado “Sí”, los usuarios visualizarán una imagen que contiene una secuencia aleatoria de 6 números en la página “invitar”.  Los usuarios deberán introducir estos números en el campo del “Código de verificación” con el fin de enviar sus invitaciones. Esta aplicación ayuda a evitar que los usuarios traten de crear comentarios no deseados (spam).  Para que esta aplicación funcione correctamente, su servidor debe tener el GD Libraries (2.0 o superior) instalado y configurado para trabajar con PHP. Si observa errores, intente desactivarla.', 'admin_banning,');
INSERT INTO `se_languagevars` VALUES ('225', '2', 'Sí, activar el código de verificación para la realización de invitaciones.', 'admin_banning,');
INSERT INTO `se_languagevars` VALUES ('226', '2', 'No, desactivar el código de verificación para la realización de invitaciones.', 'admin_banning,');
INSERT INTO `se_languagevars` VALUES ('227', '2', 'Facilitar las asociaciones y las relaciones entre los usuarios es esencial para la construcción de una red social exitosa.  Existen varios tipos de conexiones que pueden existir entre los usuarios.  Utilice esta página para determinar la forma en que sus usuarios se asociarán unos con otros.  Tenga en cuenta que, si bien nos referimos a estas relaciones como \"amistad\" en este panel de control, debería elegir la palabra que mejor se adecue al tema de su red social. Por ejemplo, si está operando una red social orientada a las empresas, es posible que desee reemplazar esta palabra por “conexiones”.', 'admin_connections,');
INSERT INTO `se_languagevars` VALUES ('228', '2', '¿A quién(es) pueden invitar los usuarios a convertirse en amigos?', 'admin_connections,');
INSERT INTO `se_languagevars` VALUES ('229', '2', 'Por favor, seleccione a quienes los usuarios pueden invitar a convertirse en sus amigos. Tenga en cuenta que si selecciona \"nadie\", ninguna de las otras configuraciones en esta página tendrá efecto.', 'admin_connections,');
INSERT INTO `se_languagevars` VALUES ('230', '2', 'Nadie ', 'admin_connections,');
INSERT INTO `se_languagevars` VALUES ('231', '2', 'Los usuarios no pueden invitar a nadie a convertirse en amigos.', 'admin_connections,');
INSERT INTO `se_languagevars` VALUES ('232', '2', 'A todo el mundo', 'admin_connections,');
INSERT INTO `se_languagevars` VALUES ('233', '2', 'Los usuarios pueden invitar cualquier otro usuario a convertirse en amigo.', 'admin_connections,');
INSERT INTO `se_languagevars` VALUES ('234', '2', 'La misma subred', 'admin_connections,');
INSERT INTO `se_languagevars` VALUES ('235', '2', 'Los usuarios sólo pueden invitar a otros usuarios de la misma subred para convertirse en amigos.', 'admin_connections,');
INSERT INTO `se_languagevars` VALUES ('236', '2', 'Amigos de los amigos', 'admin_connections,');
INSERT INTO `se_languagevars` VALUES ('237', '2', 'Los usuarios sólo pueden invitar a los amigos de sus amigos para convertirse en amigos. ', 'admin_connections,');
INSERT INTO `se_languagevars` VALUES ('238', '2', 'Marco de la amistad', 'admin_connections,');
INSERT INTO `se_languagevars` VALUES ('239', '2', 'Por favor, seleccione cómo desea que funcione el proceso de solicitud de amistad. Si cambia esta configuración de “Amistades verificadas” por “Amistades no verificadas”, todas las amistades en espera serán automáticamente confirmadas.', 'admin_connections,');
INSERT INTO `se_languagevars` VALUES ('240', '2', 'Amistades verificadas (bidireccional)', 'admin_connections,');
INSERT INTO `se_languagevars` VALUES ('241', '2', 'Cuando el UsuarioA invita al UsuarioB a convertirse en amigos, el UsuarioB se añade a la lista de amigos del UsuarioA, y el UsuarioA se añade a la lista de amigos del UsuarioB después de que el UsuarioB confirma la relación de amistad.', 'admin_connections,');
INSERT INTO `se_languagevars` VALUES ('242', '2', 'Amistades verificadas (unidireccional)', 'admin_connections,');
INSERT INTO `se_languagevars` VALUES ('243', '2', 'Cuando el UsuarioA invita al UsuarioB a convertirse en amigos, el UsuarioB se añade a la lista de amigos del UsuarioA, después de que el UsuarioB confirma la relación de amistad.', 'admin_connections,');
INSERT INTO `se_languagevars` VALUES ('244', '2', 'Amistades no verificadas (bidireccional)', 'admin_connections,');
INSERT INTO `se_languagevars` VALUES ('245', '2', 'Cuando el UsuarioA invita al UsuarioB a convertirse en amigos, el UsuarioB se añade inmediatamente a la lista de amigos del UsuarioA, y el UsuarioA se añade inmediatamente a la lista de amigos del UsuarioB.', 'admin_connections,');
INSERT INTO `se_languagevars` VALUES ('246', '2', 'Amistades no verificadas (unidireccional)', 'admin_connections,');
INSERT INTO `se_languagevars` VALUES ('247', '2', 'Cuando el UsuarioA invita al UsuarioB a convertirse en amigos, el UsuarioB se añade inmediatamente a la lista de amigos del UsuarioA.', 'admin_connections,');
INSERT INTO `se_languagevars` VALUES ('248', '2', 'Tipos de Amistad', 'admin_connections,');
INSERT INTO `se_languagevars` VALUES ('249', '2', 'Añada tipos de amistad  para que los usuarios puedan especificar sus diversos grados de amistad.  Entre los ejemplos de tipos de amistad se incluyen “Conocido”, “Colaborador”, “Mejor amigo”, “Otros importantes”, etc. Si sólo especifica un tipo de amistad o deja esta área en blanco, los usuarios no serán invitados a especificar un tipo de amistad cuando se conecten con otros usuarios.', 'admin_connections,');
INSERT INTO `se_languagevars` VALUES ('250', '2', 'Añadir nuevo tipo', 'admin_connections,');
INSERT INTO `se_languagevars` VALUES ('251', '2', 'Personalizar tipos de amistad', 'admin_connections,');
INSERT INTO `se_languagevars` VALUES ('252', '2', 'Permitir a los usuarios especificar un tipo de amistad personalizada.', 'admin_connections,');
INSERT INTO `se_languagevars` VALUES ('253', '2', 'No permitir a los usuarios especificar un tipo de amistad personalizada.', 'admin_connections,');
INSERT INTO `se_languagevars` VALUES ('254', '2', 'Explicación sobre la Amistad', 'admin_connections,');
INSERT INTO `se_languagevars` VALUES ('255', '2', 'Permitir a los usuarios dar una explicación sobre sus amistades.', 'admin_connections,');
INSERT INTO `se_languagevars` VALUES ('256', '2', 'No permitir a los usuarios dar una explicación sobre sus amistades.', 'admin_connections,');
INSERT INTO `se_languagevars` VALUES ('257', '2', 'Su red social puede tener más de un administrador. Esto es útil si desea contar con un equipo de administradores que mantengan su red social. Sin embargo, el primer administrador que se cree (tras la instalación) es el “superadministrador” y no se puede eliminar. El superadministrador puede crear y eliminar otras cuentas de administradores.  Todas las cuentas de administrador en su sistema se enumeran a continuación.', 'admin_viewadmins,');
INSERT INTO `se_languagevars` VALUES ('258', '2', 'Nombre', 'help_contact, admin_viewadmins, admin_subnetworks, admin_levels_edit, admin_levels, admin_faq, admin_ads,');
INSERT INTO `se_languagevars` VALUES ('259', '2', 'Estado', 'admin_viewadmins, admin_ads,');
INSERT INTO `se_languagevars` VALUES ('260', '2', 'Superadministrador', 'admin_viewadmins,');
INSERT INTO `se_languagevars` VALUES ('261', '2', 'Administrador', 'admin_viewadmins,');
INSERT INTO `se_languagevars` VALUES ('262', '2', 'Añadir Administrador', 'admin_viewadmins,');
INSERT INTO `se_languagevars` VALUES ('263', '2', 'Eliminar Administrador', 'admin_viewadmins,');
INSERT INTO `se_languagevars` VALUES ('264', '2', '¿Está seguro que desea eliminar este administrador? ', 'admin_viewadmins,');
INSERT INTO `se_languagevars` VALUES ('265', '2', 'Complete el formulario que está a continuación para añadir/editar esta cuenta de administrador. Tenga en cuenta que los administradores comunes no podrán eliminar o modificar la cuenta superadministrador. Si desea cambiar la contraseña de este administrador, escriba tanto la vieja como la nueva contraseña a continuación, en caso contrario, deje ambas en blanco.', 'admin_viewadmins,');
INSERT INTO `se_languagevars` VALUES ('266', '2', 'Confirmar contraseña', 'signup,');
INSERT INTO `se_languagevars` VALUES ('267', '2', 'El campo de la antigua contraseña debe coincidir con la antigua contraseña de este administrador.', 'admin_viewadmins,');
INSERT INTO `se_languagevars` VALUES ('268', '2', 'El nombre de usuario que ha introducido ya está en uso por otro administrador.', '');
INSERT INTO `se_languagevars` VALUES ('269', '2', 'Antigua contraseña', 'user_account_pass, admin_viewadmins,');
INSERT INTO `se_languagevars` VALUES ('270', '2', 'Editar Administrador', 'admin_viewadmins,');
INSERT INTO `se_languagevars` VALUES ('271', '2', 'Si usted desea distribuir a los usuarios en diferentes grupos con mayor o menor acceso a las funciones (por ejemplo, planes de membresía de Bronce, de Plata, de Oro), puede crear varios grupos de usuarios. Siempre se debe tener al menos un grupo, su grupo por defecto (el cual no puede ser eliminado).  Cuando los usuarios se registran, estos ingresan al  grupo que usted ha designado como el grupo por defecto en esta página. Puede cambiar el grupo de un usuario, editando su cuenta desde la página <a href=\'admin_viewusers.php\'>Ver usuarios</a>.  Si desea dar a todos los usuarios de su red social las mismas funciones y límites, sólo un nivel de usuario es necesario.', 'admin_levels,');
INSERT INTO `se_languagevars` VALUES ('272', '2', 'Añadir nivel de usuario', 'admin_levels,');
INSERT INTO `se_languagevars` VALUES ('273', '2', 'Usuarios', 'admin_subnetworks, admin_levels,');
INSERT INTO `se_languagevars` VALUES ('274', '2', 'usuario(s)', 'admin_levels,');
INSERT INTO `se_languagevars` VALUES ('275', '2', 'Para crear un nivel de usuario, complete el siguiente formulario.  Una vez que este se ha creado, usted podrá editar todas las configuraciones para este nivel de usuario.', 'admin_levels,');
INSERT INTO `se_languagevars` VALUES ('276', '2', 'Por favor, especifique un nombre para este nivel de usuario.', 'admin_levels,');
INSERT INTO `se_languagevars` VALUES ('277', '2', 'Descripción', 'admin_levels_edit, admin_levels,');
INSERT INTO `se_languagevars` VALUES ('278', '2', 'Añadir nivel ', 'admin_levels,');
INSERT INTO `se_languagevars` VALUES ('279', '2', '¿Está seguro que desea eliminar este nivel de usuario?  Los usuarios en este nivel serán trasladados al nivel de usuario por defecto.', 'admin_levels,');
INSERT INTO `se_languagevars` VALUES ('280', '2', 'Eliminar nivel de usuario', 'admin_levels,');
INSERT INTO `se_languagevars` VALUES ('281', '2', 'Editar nivel de usuario', 'admin_levels_edit,');
INSERT INTO `se_languagevars` VALUES ('282', '2', 'Usted está editando la configuración de este nivel de usuario. Recuerde que estas configuraciones sólo se aplican a los usuarios que pertenecen a este nivel de usuario. Cuando haya terminado, puede editar <a href=\'admin_levels.php\'> los otros niveles aquí </a>. ', 'admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings,');
INSERT INTO `se_languagevars` VALUES ('283', '2', 'Para modificar un nivel de usuario, complete el siguiente formulario. ', 'admin_levels_edit,');
INSERT INTO `se_languagevars` VALUES ('284', '2', 'Por favor, especifique un nombre para este nivel de usuario.', 'admin_levels_edit,');
INSERT INTO `se_languagevars` VALUES ('285', '2', 'Configuración del nivel', 'admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings,');
INSERT INTO `se_languagevars` VALUES ('286', '2', 'Configuración de usuario ', 'admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings,');
INSERT INTO `se_languagevars` VALUES ('287', '2', 'Configuración de mensaje', 'admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings,');
INSERT INTO `se_languagevars` VALUES ('288', '2', 'Editar nivel de usuario: %1$s', 'admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings,');
INSERT INTO `se_languagevars` VALUES ('289', '2', 'Esta página contiene varias configuraciones que afectan las cuentas de sus usuarios.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('290', '2', 'Los archivos de fotografía sólo pueden ser del tipo gif, jpg, jpeg o png.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('291', '2', 'El ancho y la altura de las fotos deben estar expresados por enteros entre 1 y 999.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('292', '2', '¿Los usuarios pueden bloquear otros usuarios?', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('293', '2', 'Si se elige “Sí”, los usuarios pueden bloquear a otros usuarios e impedirles que les envíen mensajes privados, les soliciten su amistad, y vean sus perfiles. Esto ayuda a combatir el spam y el abuso de la red.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('294', '2', 'Sí, los usuarios pueden bloquear otros usuarios.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('295', '2', 'No, los usuarios no pueden bloquear otros usuarios.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('296', '2', 'Opciones de privacidad', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('297', '2', 'Opciones de privacidad en la búsqueda', 'admin_levels_usersettings, admin_levels_albumsettings,');
INSERT INTO `se_languagevars` VALUES ('298', '2', 'Si activa esta función, los usuarios podrán excluirse de los resultados de la búsqueda y de las listas de usuarios en la página de inicio (tales como los registros recientes). De lo contrario, todos los usuarios se incluirán en los resultados de la búsqueda.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('299', '2', 'Sí, permitir a los usuarios excluirse de los resultados de la búsqueda.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('300', '2', 'No, exigir a todos los usuarios que se incluyan en los resultados de la búsqueda.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('301', '2', 'Opciones de privacidad del perfil', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('302', '2', 'Los usuarios pueden elegir entre cualquiera de las opciones a continuación, cuando deciden quienes pueden ver su perfil. Si no se elige opción alguna, todos los usuarios podrán ver los perfiles.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('303', '2', 'Opciones de comentarios en perfil', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('304', '2', 'Los usuarios pueden elegir entre cualquiera de las opciones a continuación, cuando deciden quienes pueden publicar comentarios en sus perfiles.  Si no se elige opción alguna, todos los usuarios podrán publicar comentarios en los perfiles.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('305', '2', '¿Desea permitir fotografías del usuario?', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('306', '2', 'Si activa esta función, los usuarios pueden subir una pequeña fotografía icono de sí mismos. Esta se mostrará junto a su nombre/nombre de usuario en sus perfiles, en los resultados de la búsqueda/examen, junto a sus mensajes privados, etc.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('307', '2', 'Sí, los usuarios pueden subir una fotografía.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('308', '2', 'No, los usuarios no pueden subir una fotografía.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('309', '2', 'Si ha seleccionado “Sí” más arriba, por favor, introduzca las dimensiones máximas para las fotografías del usuario.  Si sus usuarios suben una fotografía de mayores dimensiones que las especificadas, el servidor intentará reducir su tamaño automáticamente. Esta función requiere que su servidor PHP cuente con soporte para GD Libraries.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('310', '2', 'Ancho máximo:', 'admin_levels_usersettings, admin_levels_albumsettings,');
INSERT INTO `se_languagevars` VALUES ('311', '2', '(en píxeles, entre 1 y 999)', 'admin_levels_usersettings, admin_levels_albumsettings,');
INSERT INTO `se_languagevars` VALUES ('312', '2', 'Altura máxima:', 'admin_levels_usersettings, admin_levels_albumsettings,');
INSERT INTO `se_languagevars` VALUES ('313', '2', '¿Qué tipos de archivo desea permitir para las fotografías del usuario (gif, jpg, jpeg o png)? Separe los tipos de archivo con comas, es decir, <i>jpg, jpeg, gif, png</i>', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('314', '2', 'Tipos de archivo permitidos:', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('315', '2', '¿Desea permitir CSS personalizado en los perfiles?', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('316', '2', 'Habilite esta función si desea permitir a los usuarios personalizar los colores y las fuentes de sus perfiles con sus propios estilos CSS.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('317', '2', 'Sí, los usuarios pueden añadir estilos CSS personalizados a sus perfiles.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('318', '2', 'No, los usuarios no pueden añadir estilos CSS personalizados a sus perfiles.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('319', '2', '¿Desea permitir mensajes sobre el estado del perfil?', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('320', '2', 'Habilite esta función si desea permitir a los usuarios mostrar su “estado” en sus perfiles.   Mediante la actualización de su estado, los usuarios pueden contarles a otros lo que están haciendo, lo que piensan, etc.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('321', '2', 'Sí, permitir a los usuarios tener un mensaje de “estado”.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('322', '2', 'No, no permitir a los usuarios tener un mensaje de “estado”.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('323', '2', 'A todos los usuarios', 'user_account_privacy, admin_levels_usersettings, admin_levels_albumsettings,');
INSERT INTO `se_languagevars` VALUES ('324', '2', 'A todos los usuarios registrados', 'user_account_privacy, admin_levels_usersettings, admin_levels_albumsettings, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('325', '2', 'Sólo a mis amigos y a todos los usuarios dentro de mi subred', 'user_account_privacy, admin_levels_usersettings, admin_levels_albumsettings, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('326', '2', 'Sólo a mis amigos y a sus amigos dentro de mi subred', 'user_account_privacy, admin_levels_usersettings, admin_levels_albumsettings,');
INSERT INTO `se_languagevars` VALUES ('327', '2', 'Sólo a mis amigos', 'user_account_privacy, admin_levels_usersettings, admin_levels_albumsettings, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('328', '2', 'Sólo yo', 'user_account_privacy, admin_levels_usersettings, admin_levels_albumsettings,');
INSERT INTO `se_languagevars` VALUES ('329', '2', 'Nadie ', 'user_account_privacy, admin_levels_usersettings, admin_levels_albumsettings,');
INSERT INTO `se_languagevars` VALUES ('330', '2', 'Facilitar la interactividad de los usuarios es la clave para el desarrollo de una red social exitosa. Permitir mensajes privados entre los usuarios es una excelente forma de incrementar la interactividad.  Desde esta página, puede activar la función de mensajería privada y configurar sus ajustes.', 'admin_levels_messagesettings,');
INSERT INTO `se_languagevars` VALUES ('331', '2', '¿A quién(es) pueden enviar mensajes privados los usuarios?', 'admin_levels_messagesettings,');
INSERT INTO `se_languagevars` VALUES ('332', '2', 'Si se elige a “nadie”, ninguna de las otras configuraciones en esta página se aplicará. De lo contrario, los usuarios tendrán acceso a sus bandejas de entrada de mensajes privados y podrán enviarse mensajes entre sí. ', 'admin_levels_messagesettings,');
INSERT INTO `se_languagevars` VALUES ('333', '2', 'A nadie -  los usuarios no pueden enviar mensajes privados.', 'admin_levels_messagesettings,');
INSERT INTO `se_languagevars` VALUES ('334', '2', 'Sólo a los amigos  - los usuarios pueden enviar mensajes privados sólo a sus amigos. ', 'admin_levels_messagesettings,');
INSERT INTO `se_languagevars` VALUES ('335', '2', 'A todos los usuarios - los usuarios pueden enviar mensajes privados a todos los usuarios. ', 'admin_levels_messagesettings,');
INSERT INTO `se_languagevars` VALUES ('336', '2', 'Capacidad de la bandeja de entrada/salida ', 'admin_levels_messagesettings,');
INSERT INTO `se_languagevars` VALUES ('337', '2', '¿Cuántas conversaciones en total podrán los usuarios almacenar en sus bandejas de entrada y salida?  Si la bandeja de entrada o salida de un usuario está llena y se inicia una nueva conversación, la conversación más antigua será automáticamente eliminada.', 'admin_levels_messagesettings,');
INSERT INTO `se_languagevars` VALUES ('338', '2', 'Conversaciones en la carpeta de la bandeja de entrada.', 'admin_levels_messagesettings,');
INSERT INTO `se_languagevars` VALUES ('339', '2', 'Conversaciones en la carpeta de la bandeja de salida.', 'admin_levels_messagesettings,');
INSERT INTO `se_languagevars` VALUES ('340', '2', 'Use esta página para invitar a nuevos usuarios a su red social.  Puede especificar 10 direcciones de correo electrónico a la vez. Si ha especificado que los usuarios pueden registrarse sólo si tienen invitación, esta página enviará un correo electrónico con un código de invitación a las direcciones de correo electrónico que usted especifique.  De lo contrario, se enviará una simple invitación a través del correo electrónico.  Estos dos correos electrónicos pueden ser modificados en su página <a href=\'admin_emails.php\'>Correos electrónicos del sistema</a>.', 'admin_invite,');
INSERT INTO `se_languagevars` VALUES ('341', '2', '¡Las invitaciones han sido enviadas!', 'admin_invite,');
INSERT INTO `se_languagevars` VALUES ('342', '2', 'Direcciones de correo electrónico', 'admin_invite,');
INSERT INTO `se_languagevars` VALUES ('343', '2', 'Introduzca las direcciones de correo electrónico (máximo 10), separadas por comas, en el campo de abajo.', 'admin_invite,');
INSERT INTO `se_languagevars` VALUES ('344', '2', 'Crear campaña publicitaria', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('345', '2', 'Siga esta guía para diseñar y lanzar una nueva campaña publicitaria.', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('346', '2', 'Medios publicitarios', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('347', '2', 'Suba una imagen banner de su ordenador o especifique el código HTML de su anuncio publicitario (por ejemplo, Google AdSense).  Si decide subir una imagen, debe ser un archivo válido GIF, JPG, JPEG o PNG de menos de 200kb. ', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('348', '2', 'Subir imagen banner ', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('349', '2', 'O', 'signup, admin_language_edit, admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('350', '2', 'Insertar el HTML del banner ', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('351', '2', 'Insertar el código de HTML del banner', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('352', '2', 'Guardar el código HTML y realizar una vista previa', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('353', '2', 'Por favor, introduzca el HTML de su banner antes de continuar.', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('354', '2', 'Vista previa del banner ', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('355', '2', 'Guardar el banner', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('356', '2', 'Eliminar el banner ', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('357', '2', 'Editar HTML', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('358', '2', 'Subir imagen banner ', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('359', '2', 'Archivo:', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('360', '2', 'Enlace URL:', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('361', '2', 'Subir imagen banner y realizar una vista previa', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('362', '2', 'Por favor, elija un archivo de su disco duro para subir.', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('363', '2', 'El archivo que ha especificado no se pudo subir. Por favor, asegúrese de que este es un archivo de imagen válido y que el directorio /uploads_admin/ads tiene permiso de escritura del servidor.', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('364', '2', 'Información de la campaña', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('365', '2', 'Comience por dar un nombre a esta campaña y por determinar su fecha de inicio y finalización. Si selecciona una fecha de finalización, la campaña finalizará de inmediato al llegar esa fecha. Si especifica un cierto número total de visitas permitido o un total de clics permitidos, la campaña terminará cuando se alcance ese número de visitas o clics.   Si se especifica un mínimo porcentaje de clics (click-through ratio CTR), que es la relación clics/opiniones) y el CTR de la campaña está por debajo de su límite, la campaña finalizará.   Si decide especificar un límite de CTR mínimo, debe introducirlo como un porcentaje de clics/visitas (por ejemplo, 0,05%).  Para crear una campaña sin finalización definida, no especifique una fecha de finalización o cualquier otro límite y su campaña continuará hasta que decida ponerle fin. ', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('366', '2', 'Tenga en cuenta: la fecha actual es %1$s', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('367', '2', 'Nombre de la campaña: ', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('368', '2', 'Fecha de inicio:', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('369', '2', 'Fecha de finalización:', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('370', '2', 'No finalizar esta campaña en una fecha específica.', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('371', '2', 'Finalizar esta campaña en una fecha específica.', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('372', '2', 'Total de visitas autorizadas:', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('373', '2', 'Ilimitado', 'admin_levels_albumsettings, admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('374', '2', 'Total de clics autorizados:', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('375', '2', 'CTR mínimo:', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('376', '2', 'Seleccionar la posición de ubicación', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('377', '2', '¿En qué lugar de la página desea mostrar sus banners? Puede colocar su banner en la parte superior de la página, justo encima del área de contenido principal, a la izquierda del área de contenido, a la derecha del área de contenido, o en la parte inferior de la página.  Por favor, tenga en cuenta que esta colocación automática NO funcionará si ha eliminado las variables Smarty del código del anuncio de sus archivos header.tpl y footer.tpl.  También tenga en cuenta que si selecciona una posición más abajo, el banner se mostrará en esa posición en todas las páginas de la red social.  Puede insertar banners en una sola página (o unas cuantas páginas) siguiendo las instrucciones de inserción manual a continuación.', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('378', '2', 'Si usted desea que este anuncio aparezca en otra ubicación en el sitio, que no sea ninguna de las que se ha indicado anteriormente (por ejemplo, en el contenido en una sola página), puede insertar el siguiente código en cualquiera de sus <a href=\'admin_templates.php\' target=\'_blank\'>templates</a> y aparecerá su anuncio una vez que haya creado la campaña.', '');
INSERT INTO `se_languagevars` VALUES ('379', '2', 'Seleccionar el público', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('380', '2', 'Especifique los usuarios a quienes se les mostrarán los anuncios de esta campaña.  Para incluir a toda la población de usuarios en esta campaña, deje todos los <a href=\'admin_levels.php\' target=\'_blank\'>niveles de usuario </a> y <a href=\'admin_subnetworks.php\' target=\'_blank\'>subredes</a> seleccionados. Para seleccionar varios niveles de usuario o subredes, utilice Ctrl + clic.  Tenga en cuenta que esta campaña publicitaria sólo se mostrará a los usuarios registrados cuyos datos coinciden con un nivel de usuario <b>Y</ b> con la subred que ha seleccionado. ', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('381', '2', 'Subredes', '');
INSERT INTO `se_languagevars` VALUES ('382', '2', '(registro por defecto)', 'admin_announcements, admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('383', '2', 'Subred por defecto', 'admin_announcements, admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('384', '2', 'Mostrar también este anuncio a los visitantes que no se han registrado.', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('385', '2', 'Crear nueva campaña', 'admin_ads_modify, admin_ads,');
INSERT INTO `se_languagevars` VALUES ('386', '2', 'Por favor, suba un banner o especifique el HTML de su anuncio para esta campaña.', '');
INSERT INTO `se_languagevars` VALUES ('387', '2', 'Por favor, proporcione un nombre para esta campaña publicitaria.', '');
INSERT INTO `se_languagevars` VALUES ('388', '2', 'Por favor, proporcione una fecha de inicio para esta campaña.', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('389', '2', 'Por favor, proporcione una fecha de finalización para esta campaña.', '');
INSERT INTO `se_languagevars` VALUES ('390', '2', 'Por favor, elija una fecha de finalización que sea posterior a su fecha de inicio. ', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('391', '2', 'Por favor, proporcione un número máximo de visitas para esta campaña. Este debe ser un número entero (por ejemplo 250.000).', '');
INSERT INTO `se_languagevars` VALUES ('392', '2', 'Por favor, proporcione un número máximo de clics para esta campaña. Este debe ser un número entero (por ejemplo 250).', '');
INSERT INTO `se_languagevars` VALUES ('393', '2', 'Por favor proporcione un límite de CTR mínimo, debe introducirlo como un porcentaje de clics/visitas (por ejemplo, 1,50%). Este valor no podrá superar el 100%.', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('394', '2', 'Mostrar sus anuncios publicitarios es una excelente forma de monetizar su red social.  Mediante la creación de campañas publicitarias, se puede determinar exactamente el lugar en que aparecerán sus anuncios, cuánto tiempo se mostrarán, y quienes podrán verlos. La clave para generar importantes ingresos de su red social es la creación de campañas publicitarias orientadas.  Esto significa que usted debe hacer un esfuerzo para mostrar anuncios específicos a los usuarios sobre la base de sus intereses o características personales (por ejemplo, su información de perfil).  Para lograr esto, las campañas publicitarias pueden ser diseñadas para determinados <a href=\'admin_levels.php\'> niveles de usuario </a> y/o <a href=\'admin_subnetworks.php\'>subredes</a>.', 'admin_ads,');
INSERT INTO `se_languagevars` VALUES ('395', '2', 'Actualizar estadísticas', 'admin_ads,');
INSERT INTO `se_languagevars` VALUES ('396', '2', 'Visitas', 'admin_ads,');
INSERT INTO `se_languagevars` VALUES ('397', '2', 'Clics', 'admin_ads,');
INSERT INTO `se_languagevars` VALUES ('398', '2', 'CTR', 'admin_ads,');
INSERT INTO `se_languagevars` VALUES ('399', '2', 'pausa', 'admin_ads,');
INSERT INTO `se_languagevars` VALUES ('400', '2', 'reanudar', 'admin_ads,');
INSERT INTO `se_languagevars` VALUES ('401', '2', 'Actualmente no hay campañas publicitarias en su red social.', 'admin_ads,');
INSERT INTO `se_languagevars` VALUES ('402', '2', 'En pausa', 'admin_ads,');
INSERT INTO `se_languagevars` VALUES ('403', '2', 'Activo', 'admin_ads,');
INSERT INTO `se_languagevars` VALUES ('404', '2', 'Esperando la fecha de inicio', 'admin_ads,');
INSERT INTO `se_languagevars` VALUES ('405', '2', 'Completado ', 'admin_ads,');
INSERT INTO `se_languagevars` VALUES ('406', '2', 'Eliminar la campaña publicitaria', 'admin_ads,');
INSERT INTO `se_languagevars` VALUES ('407', '2', '¿Está seguro que desea eliminar esta campaña publicitaria? ', 'admin_ads,');
INSERT INTO `se_languagevars` VALUES ('408', '2', 'Editar campaña publicitaria', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('409', '2', 'Editar los detalles de esta campaña publicitaria a continuación.', 'admin_ads_modify,');
INSERT INTO `se_languagevars` VALUES ('410', '2', 'El proceso de registro de usuario es un elemento crucial para su red social.  Usted debe diseñar un proceso de registro que no sólo sea fácil de utilizar, sino que también reciba la información inicial que necesita de los nuevos usuarios.  En esta página, usted podrá configurar el proceso de registro.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('411', '2', 'Campos en la página de registro', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('412', '2', 'Los usuarios tendrán la oportunidad de comenzar a completar su perfil cuando se registren.  A continuación, puede especificar qué campos de perfil aparecerán en la página de registro, y cuáles serán obligatorios.  Tenga en cuenta que un largo proceso de registro puede disuadir a algunos usuarios de registrarse en su red social. Para añadir o eliminar campos de perfil, visite la página <a href=\'admin_profile.php\'>Campos del perfil </a>.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('413', '2', 'Subir foto del usuario ', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('414', '2', '416 ¿Desea que sus usuarios suban una fotografía de sí mismos una vez registrados?', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('415', '2', 'Sí, ofrecer a los usuarios la opción de subir una fotografía una vez registrados.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('416', '2', 'No, no permitir a los usuarios subir una fotografía una vez registrados.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('417', '2', '¿Desea habilitar a los usuarios?', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('418', '2', 'Si ha seleccionado “Sí”, los usuarios se habilitarán automáticamente cuando se registren.  Si selecciona “NO”, tendrá que habilitar manualmente a los usuarios a través de la página <a href=\'admin_viewusers.php\'>Ver usuarios</a>. Los usuarios que no están habilitadas no pueden iniciar sesión.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('419', '2', 'Sí, habilitar a los usuarios una vez registrados.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('420', '2', 'No, no habilitar a los usuarios una vez registrados.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('421', '2', '¿Desea enviar un mensaje de bienvenida por correo electrónico?', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('422', '2', '¿Desea enviar a los usuarios un mensaje de bienvenida por correo electrónico una vez registrados?  Si tiene la verificación de correo electrónico activada, este mensaje será enviado después de verificado.  Usted puede modificar este mensaje en la página <a href=\'admin_emails.php\'>Correos electrónicos del sistema</a>.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('423', '2', 'Sí, enviar a los usuarios un mensaje de bienvenida por correo electrónico. ', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('424', '2', 'No, no enviar a los usuarios un mensaje de bienvenida por correo electrónico. ', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('425', '2', '¿Desea invitar solamente?', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('426', '2', '¿Desea desactivar el registro público y sólo permitir a los usuarios invitados registrarse?  Si la respuesta es “Sí”, usted puede decidir que tanto los administradores como los usuarios inviten a nuevos usuarios, o que simplemente lo hagan los administradores.  Si elige “Sí”, se le exigirá que introduzca el código de la invitación en la página de registro.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('427', '2', 'Sí, los administradores y los usuarios deben invitar a los nuevos usuarios antes de que estos puedan registrarse.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('428', '2', 'Sí, los administradores deben invitar a los nuevos usuarios antes de que estos puedan registrarse.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('429', '2', 'No, desactivar la función “sólo por invitación”.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('430', '2', '¿Deberá cada código de invitación corresponder exactamente a cada dirección de correo electrónico invitada? Si se elige “No”, cualquier persona con un código válido de invitación puede registrarse, independientemente de su dirección de correo electrónico.  Si se elige “Sí”, cualquier persona con un código válido de invitación que coincida con la dirección de correo electrónico invitada puede registrarse. ', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('431', '2', 'Sí, comprobar que la dirección de correo electrónico de un usuario fue invitada antes de aceptar su código de invitación.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('432', '2', 'No, cualquier persona con un código válido de invitación puede registrarse, independientemente de su dirección de correo electrónico. ', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('433', '2', '¿Cuántas invitaciones se conceden a los usuarios cuando se registran? (Si desea dar a un usuario invitaciones adicionales, puede hacerlo a través de la página <a href=\'admin_viewusers.php\'> Ver usuarios </a>. Por favor, introduzca un número entre 0 y 999 a continuación.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('434', '2', 'Las invitaciones se conceden a cada usuario cuando se registra.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('435', '2', '¿Desea mostrar la página “Invitar amigos”?', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('436', '2', 'Si ha seleccionado “Sí”, sus usuarios verán una página donde se les pedirá que, opcionalmente, inviten a uno o más amigos a registrarse.  La función “invitar amigos” es diferente a la “sólo por invitación”, porque “invitar amigos” simplemente envía un correo electrónico al invitado en lugar de enviarle un código de invitación real. Debido a esto, es probable que no desee activar ambas funciones, “invitar a amigos” y “sólo por invitación”, simultáneamente.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('437', '2', 'Sí, mostrar la página “invitar a amigos”.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('438', '2', 'No, no mostrar la página “invitar a amigos”.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('439', '2', '¿Desea verificar la dirección de correo electrónico?', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('440', '2', '¿Desea exigir a los usuarios que verifiquen su dirección de correo electrónico antes de registrarse?  Si elige “Sí”, se les enviará a los usuarios un correo electrónico con un enlace de verificación, al que deben hacer clic para activar su cuenta.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('441', '2', 'Sí, verificar las direcciones de correo electrónico.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('442', '2', 'No, no verificar las direcciones de correo electrónico.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('443', '2', '¿Desea exigir a los usuarios que introduzcan un código de verificación?', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('444', '2', 'Si ha seleccionado “Sí”, los usuarios visualizarán una imagen que contiene una secuencia aleatoria de 6 números en la página de registro.  Los usuarios deberán introducir estos números en el campo del “Código de verificación” antes proseguir. Esta función ayuda a impedir que los usuarios traten de crear cuentas en su sistema automáticamente.  Para que esta función funcione correctamente, su servidor debe tener el GD Libraries (2.0 o superior) instalado y configurado para trabajar con PHP. Si observa errores o los usuarios no pueden registrarse, intente desactivarla.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('445', '2', 'Sí, mostrar la imagen del código de verificación.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('446', '2', 'No, no mostrar la imagen del código de verificación.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('447', '2', '¿Desea generar contraseñas aleatorias?', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('448', '2', 'Si ha seleccionado “Sí”, se creará una contraseña aleatoria para los usuarios cuando se registren.  La contraseña les será enviada por correo electrónico una vez finalizado el proceso de registro.  Este es otro método de verificación de las direcciones de correo electrónico de los usuarios.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('449', '2', 'Sí, generar contraseñas aleatorias y enviarlas por correo electrónico a los nuevos usuarios.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('450', '2', 'No, permitir a los usuarios elegir sus propias contraseñas.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('451', '2', '¿Desea exigir a los usuarios que firmen el acuerdo de sus condiciones de servicio?', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('452', '2', 'Nota: Si ha seleccionado Sí, los usuarios deberán hacer clic en una casilla de verificación durante el proceso de registro, lo cual implica que han leído, entendido, y están de acuerdo con sus condiciones de servicio.  Introduzca el texto de sus condiciones de servicio en el campo a continuación.  HTML es correcto.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('453', '2', 'Sí, exigir a los usuarios que firmen el acuerdo de sus condiciones de servicio al registrarse.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('454', '2', 'No, los usuarios no verán una casilla de verificación para las condiciones del servicio al registrarse.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('455', '2', 'No hay campos en esta categoría de perfil.', 'admin_signup,');
INSERT INTO `se_languagevars` VALUES ('456', '2', 'Algunos usuarios prefieren tener direcciones de perfil (URLs) que son más fáciles de recordar, visualmente más atractivas, y más accesibles para los motores de búsqueda.  Por defecto, los URLs de los usuarios aparecerán en el formato “normal” como se muestra a continuación.  Si desea darles “URLs de un subdirectorio”, su servidor Web debe estar ejecutando Apache y contar con un mod_rewrite instalado.', 'admin_url,');
INSERT INTO `se_languagevars` VALUES ('457', '2', 'Estilo de URL ', 'admin_url,');
INSERT INTO `se_languagevars` VALUES ('458', '2', 'Después de seleccionar un estilo de URL y de hacer clic en el botón de enviar a continuación, se le guiará con más instrucciones para que active el estilo de la URL de su elección.  Por favor, siga estas instrucciones cuidadosamente para asegurarse de que sus URLs están funcionando correctamente.', 'admin_url,');
INSERT INTO `se_languagevars` VALUES ('459', '2', '<b>Normal URLs</b><br>URL del perfil:  http://www.yourdomain.com/profile.php?user=username', 'admin_url,');
INSERT INTO `se_languagevars` VALUES ('460', '2', '<b>URLs de Subdirectorio</b><br>URL del perfil:  http://www.yourdomain.com/username', 'admin_url,');
INSERT INTO `se_languagevars` VALUES ('461', '2', 'URLs Normales', 'admin_url,');
INSERT INTO `se_languagevars` VALUES ('462', '2', 'URLs del subdirectorio', 'admin_url,');
INSERT INTO `se_languagevars` VALUES ('463', '2', ' - (¿Necesita ayuda?  Revise las instrucciones <a href=\'javascript:urlhelp();\'>aquí</a>). ', 'admin_url,');
INSERT INTO `se_languagevars` VALUES ('464', '2', 'Ayuda para la configuración de URL ', 'admin_url,');
INSERT INTO `se_languagevars` VALUES ('465', '2', 'El sistema está configurado para utilizar URLs del subdirectorio, que requieren un archivo .htaccess en el directorio raíz de SocialEngine. Copie y pegue el código que se encuentra en el siguiente casillero en un archivo de texto en blanco denominado .htaccess, y colóquelo en el directorio raíz de su SocialEngine.  Este es el directorio de su servidor en el que usted ha instalado SocialEngine.', 'admin_url,');
INSERT INTO `se_languagevars` VALUES ('466', '2', 'Cerrar', 'admin_url, admin_templates, admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('467', '2', 'Usted tiene un control absoluto sobre el aspecto visual y emocional de su red social. El código PHP que impulsa su red social es totalmente independiente del código HTML utilizado para su presentación.  Su código HTML se almacena en las plantillas que se presentan a continuación, el cual puede ser editado directamente en esta página.  Para editar una plantilla, simplemente haga clic en su nombre. <br><br><b> Sobre el sistema de plantillas:</b><br> El sistema de plantillas  utiliza Smarty, que es el más avanzado y renombrado sistema de plantillas PHP de terceros disponible.  Aunque las plantillas son principalmente HTML, se utilizan algunas etiquetas Smarty para diversos fines.  Para obtener ayuda con el sistema de plantillas, por favor visite el sitio web <a href=\'http://smarty.php.net\' target=\'_blank\'>Smarty</a>. Tenga en cuenta que muchas de las etiquetas que usted encontrará en las plantillas son en realidad variables del idioma.  Estas se utilizan para mostrar fragmentos de texto que se han especificado en su paquete de idioma.  Para cambiar estos fragmentos de texto, debe editar el archivo de idioma que está utilizando en el directorio “idioma” de su servidor. <br><br><b> Agregar un empaquetador (wrapper) de encabezado y de pie de página a su sitio Web: </b><br> La forma más sencilla de integrar su red social a su sitio Web principal es copiar el HTML del encabezado/pie de página de su sitio Web y pegarlo en las “Plantillas encabezado/pie de página” a continuación.  Para realizar cambios generales a la hoja de estilos CSS, puede modificar “styles.css”.', 'admin_templates,');
INSERT INTO `se_languagevars` VALUES ('468', '2', 'Páginas de usuarios identificados', 'admin_templates,');
INSERT INTO `se_languagevars` VALUES ('469', '2', 'Páginas públicas', 'admin_templates,');
INSERT INTO `se_languagevars` VALUES ('470', '2', 'Plantillas de encabezado/pie de página ', 'admin_templates,');
INSERT INTO `se_languagevars` VALUES ('471', '2', 'Editar plantilla', 'admin_templates,');
INSERT INTO `se_languagevars` VALUES ('472', '2', 'El código de HTML y el de Smarty para esta plantilla se muestran a continuación.  Después de realizar los cambios deseados a la plantilla, asegúrese de hacer clic en el botón “Guardar cambios”. Para obtener ayuda con Smarty, consulte el <a href=\'http://smarty.php.net\' target=\'_blank\'>sitio oficial</a> y <a href=\'http://smarty.php.net/crashcourse.php\' target=\'_blank\'>curso acelerado</a>.', 'admin_templates,');
INSERT INTO `se_languagevars` VALUES ('473', '2', 'El archivo que ha especificado no es un archivo de plantilla válido.', 'admin_templates,');
INSERT INTO `se_languagevars` VALUES ('474', '2', 'La plantilla que ha especificado no se ha encontrado.', 'admin_templates,');
INSERT INTO `se_languagevars` VALUES ('475', '2', 'La plantilla que ha especificado no se puede leer. Pruebe configurar permisos absolutos (CHMOD 777) para este archivo y para el directorio de plantillas.', 'admin_templates,');
INSERT INTO `se_languagevars` VALUES ('476', '2', 'La plantilla que ha especificado no es grabable. Pruebe configurar permisos absolutos (CHMOD 777) para este archivo y para el directorio de plantillas.', 'admin_templates,');
INSERT INTO `se_languagevars` VALUES ('477', '2', 'Use esta página para supervisar el uso de la red y los patrones de tráfico.  Comience por seleccionar uno de los tipos de estadísticas disponibles ofrecidas a continuación.', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('478', '2', 'Breve resumen', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('479', '2', 'Visitas/Impresiones', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('480', '2', 'Nuevas conexiones', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('481', '2', 'Nuevos registros ', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('482', '2', 'Nuevas amistades ', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('483', '2', 'Uso de la red', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('484', '2', 'Otras estadísticas', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('485', '2', 'URLs de referencia', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('486', '2', 'Espacio utilizado', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('487', '2', 'Último período ', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('488', '2', 'Período:', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('489', '2', 'Esta semana (diario)', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('490', '2', 'Este mes (diario)', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('491', '2', 'Este año (Mensual)', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('492', '2', 'Actualizar', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('493', '2', 'Próximo período ', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('494', '2', 'URL', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('495', '2', 'Estas son las 100 URLs de referencia más comunes rastreadas de su <a href=\'../home.php\' target=\'_blank\'>home.php</a> archivo.<br> Esto indica que la mayor parte del nuevo tráfico está llegando de las siguientes URLs. <br>La limpieza periódica de la lista le dará nuevos datos de referencia.', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('496', '2', 'Limpiar ahora', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('497', '2', 'Hits', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('498', '2', 'La lista de URL de referencia está actualmente vacía.', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('499', '2', 'Medios subidos:', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('500', '2', 'Tamaño de la base de datos:', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('501', '2', ' Espacio total utilizado (estimado):', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('502', '2', 'Estadísticas rápidas de la red', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('503', '2', 'Los siguientes datos son un resumen rápido de su red social. <br>Los datos no incluyen los artículos que han sido eliminados.', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('504', '2', 'Total de usuarios:', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('505', '2', '%1$d usuarios', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('506', '2', '%1$d mensajes', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('507', '2', '%1$d comentarios', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('508', '2', 'Visitas a la página', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('510', '2', '¡Hola, %1$s!', 'home,');
INSERT INTO `se_languagevars` VALUES ('509', '2', 'Perfil de %1$s ', 'user_friends_requests_outgoing, user_friends_requests, user_friends, search_advanced, search, profile, home,');
INSERT INTO `se_languagevars` VALUES ('660', '2', 'Recordarme', 'login, home,');
INSERT INTO `se_languagevars` VALUES ('512', '2', 'Semana de', 'admin_stats,');
INSERT INTO `se_languagevars` VALUES ('513', '2', 'Esta página le permite modificar el contenido de los mensajes de correo electrónico enviados por el sistema.', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('514', '2', 'Desde la dirección', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('515', '2', 'Introduzca el nombre y la dirección de correo electrónico de la cuenta de origen de los correos electrónicos del sistema en los campos a continuación.', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('516', '2', 'De nombre: ', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('517', '2', 'Desde la dirección:', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('518', '2', 'Correo electrónico con el código de la invitación ', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('519', '2', 'Este es el correo electrónico que se envía si se permite a los usuarios unirse sólo por invitación.', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('520', '2', 'Asunto ', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_emails, admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('521', '2', 'Mensaje ', 'user_messages_new, help_contact, admin_emails,');
INSERT INTO `se_languagevars` VALUES ('523', '2', 'Invitación por correo electrónico', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('524', '2', 'Este es el correo electrónico que se envía cuando los usuarios invitan a sus amigos a unirse a la red durante el proceso de registro.', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('526', '2', 'Correo electrónico de verificación ', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('527', '2', 'Este es el mensaje que se envía a los usuarios para verificar sus direcciones de correo electrónico.', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('529', '2', 'Correo electrónico con la nueva contraseña', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('530', '2', 'Este es el mensaje que se envía si ha optado por crear una contraseña aleatoria para los usuarios al registrarse.', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('532', '2', 'Correo electrónico de bienvenida', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('533', '2', 'Este es el correo electrónico que se envía cuando un usuario se registra.  Tenga en cuenta que si ha activado la verificación de correo electrónico, la variable de la contraseña es <b> no disponible </b>. Esto se debe al hecho de que las contraseñas son encriptadas al momento de registro y no se pueden desencriptar cuando un usuario verifica su dirección de correo electrónico y se envía el mensaje de bienvenida.', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('535', '2', 'Correo electrónico de contraseña perdida ', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('536', '2', 'Este es el mensaje de correo electrónico que se envía si un usuario olvida su contraseña y solicita crear una nueva.', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('538', '2', 'Solicitud de amigo por correo electrónico', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('539', '2', 'Este es el mensaje que se envía a un usuario cuando se añade como amigo de otro usuario.', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('541', '2', 'Nuevo mensaje de correo electrónico', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('542', '2', 'Este es el correo electrónico que se envía a un usuario cuando recibe un mensaje nuevo. ', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('544', '2', 'Correo electrónico de nuevo comentario en el perfil', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('545', '2', 'Este es el correo electrónico que se envía a un usuario cuando un nuevo comentario se publica en su perfil. ', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('547', '2', 'El informe de actividad reciente es una lista de acciones que se auto-actualiza. Este presenta actividades que se han llevado a cabo recientemente en su red social. Esta información se muestra (por defecto) en la página  \"Mi página de inicio\" de los usuarios. Además, lista de actividad personal de cada usuario se mostrará en su página de perfil, si se activa a continuación.  Tenga en cuenta que algunas de las configuraciones realizadas aquí no tienen efecto retroactivo, lo que significa que los cambios que realice aquí no podrán afectar antiguos temas del informe.', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('548', '2', '¿Qué acciones desea incluir en la lista de actividades?', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('549', '2', 'Todas las acciones posibles que pueden aparecer en su informe de actividad reciente se muestran a continuación.  Puede optar por no incluirlas en el informe de actividad reciente, desmarcando la casilla que corresponda, o modificando su texto. Tenga en cuenta que algunas de las acciones poseen variables que son sustituidas por el sistema (por ejemplo, nombre de usuario, fotografía, comentario).  Tenga presente, además, que la instalación de nuevos plugins puede añadir nuevas acciones. Si desmarca la casilla designada se desactivará ese tipo de acción, sin embargo todas las acciones de ese tipo previamente guardadas no serán eliminadas del informe.  También puede decidir si desea o no permitir a los usuarios la opción de desactivar el tipo de informe de actividad marcando o desmarcando la casilla correspondiente. <br><br><b> Nota: Si está usando más de un idioma en su red social, puede proporcionar traducciones para estos temas del informe de actividad en <a href=\'admin_language.php\'>Configuración de idioma</a> esta página.</b>', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('550', '2', 'Texto de acción ', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('551', '2', 'Palabra clave', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('552', '2', '¿Cuántas acciones se deben almacenar para cada usuario?', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('553', '2', '¿Cuántas acciones recientes desea almacenar en la base de datos para cada usuario?  Un valor mayor mostrará más información acerca de la actividad de cada usuario, mientras que un valor inferior aumentará el rendimiento de las bases de datos. Nota: Si el número de acciones que desea visualizar en cada perfil de usuario es inferior al número de acciones que desea almacenar en la base de datos, puede editar el archivo de la plantilla \"profile.tpl\" para limitar el número de acciones mostradas.', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('554', '2', 'Acción(es) almacenada(s) en la base de datos y publicada(s) en cada página de perfil del usuario. ', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('555', '2', 'Límites del informe', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('556', '2', '¿Cuántas acciones en total desea mostrar en el informe de actividad reciente? ', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('557', '2', 'Acción(es) publicada(s) en el informe de actividad reciente', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('558', '2', '¿Por cuánto tiempo desea que se vean los temas en el informe de actividad reciente?  Un periodo menor de tiempo implicará una menor lista de acciones. Para redes sociales pequeñas, un período más largo puede ser más apropiado.', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('559', '2', 'minuto(s)', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('560', '2', 'hora(s)', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('561', '2', 'día(s)', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('562', '2', 'semana(s)', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('563', '2', 'mes(ses)', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('564', '2', '¿Cuántas acciones por usuario se pueden mostrar en el informe de actividad reciente?   Es importante contar con una buena combinación de acciones de varios usuarios en su red social, por lo tanto aquí se puede establecer un límite al número de acciones publicadas acerca de cada usuario en cualquier momento dado.  Para redes sociales pequeñas, un mayor número de acciones publicadas por usuario puede resultar más apropiado.', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('565', '2', 'Acción(es) publicada(s) por usuario en el informe de actividad reciente', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('566', '2', '¿Se debería autorizar a los usuarios a eliminar las acciones publicadas que son de su incumbencia ?', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('567', '2', '¿Desea ofrecer a los usuarios la opción de eliminar las acciones publicadas que son de su incumbencia ?  Esta es, en general, una importante libertad otorgada a los usuarios, dado que ayuda a mantener su privacidad.', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('568', '2', 'Sí, permitir a los usuarios eliminar las acciones publicadas que son de su incumbencia.', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('569', '2', 'No, los usuarios no pueden eliminar las acciones publicadas que son de su incumbencia.', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('570', '2', '¿Las acciones de quién deberían ver los usuarios en la lista de actividad reciente?', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('571', '2', 'Cuando un usuario mira el informe de actividad reciente, ¿las acciones de quién debería ver? Para redes más pequeñas, tal vez  tenga más sentido mostrar las actividades recientes de \"Todos los usuarios registrados\" para que el informe se complete rápidamente.', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('572', '2', '¿Deberían los usuarios poder impedir que se publiquen determinados tipos de acciones?', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('573', '2', '¿Desea permitir a los usuarios que impidan la publicación de determinados tipos de acciones de su incumbencia?   Si la respuesta es “Sí”, aparecerá un ajuste en la página de configuración de cuenta de sus usuarios que les permite elegir qué tipos de acciones NO deben publicarse en el informe de actividad reciente.', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('574', '2', 'Sí, los usuarios pueden especificar qué tipos de acciones de su incumbencia no se publicarán.', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('575', '2', 'No, los usuarios no pueden especificar qué acciones de su incumbencia podrán, o no, ser publicadas.', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('576', '2', 'Incluir esta acción en el informe de actividad reciente.', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('577', '2', 'Mostrar la opción activar/desactivar en la página de configuración de usuario ', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('700001', '2', '<a href=\'profile.php?user=%1$s\'>%2$s</a> conectado.', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('700002', '2', '<a href=\'profile.php?user=%1$s\'>%2$s</a> ha actualizado la fotografía de su perfil. <div class=\'recentaction_div_media\'>[medios]</div>', 'user_home, profile, network, home, admin_viewusers_edit, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('700003', '2', '<a href=\'profile.php?user=%1$s\'>%2$s</a> ha actualizado su perfil.', 'user_home, profile, network, home, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('700004', '2', '<a href=\'profile.php?user=%1$s\'>%2$s</a> ha publicado un comentario sobre<a href=\'profile.php?user=%3$s&v=comments\'>%4$s</a>el perfil de:<div class=\'recentaction_div\'>%5$s</div>', 'user_home, profile, network, home, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('700005', '2', '<a href=\'profile.php?user=%1$s\'>%2$s</a> y <a href=\'profile.php?user=%3$s\'>%4$s</a> ahora son amigos.', 'user_home, profile, network, home, admin_viewusers_edit, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('700006', '2', '<a href=\'profile.php?user=%1$s\'>%2$s</a> se ha registrado.', 'user_home, profile, network, home, admin_viewusers_edit, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('700007', '2', '<a href=\'profile.php?user=%1$s\'>%2$s</a> %3$s', 'user_home, profile, network, home, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('578', '2', 'Variables disponibles:', 'admin_emails, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('579', '2', 'MES', 'user_editprofile_style, user_editprofile_photo, user_editprofile, signup, search_advanced, admin_subnetworks, admin_signup, admin_profile, admin_fields,');
INSERT INTO `se_languagevars` VALUES ('580', '2', 'DÍA', 'user_editprofile_style, user_editprofile_photo, user_editprofile, signup, search_advanced, admin_subnetworks, admin_signup, admin_profile, admin_fields,');
INSERT INTO `se_languagevars` VALUES ('581', '2', 'AÑO', 'user_editprofile_style, user_editprofile_photo, user_editprofile, signup, search_advanced, admin_subnetworks, admin_signup, admin_profile, admin_fields,');
INSERT INTO `se_languagevars` VALUES ('582', '2', 'No hay variables de idioma que coincidan con su frase de búsqueda en este idioma.', 'admin_language_edit,');
INSERT INTO `se_languagevars` VALUES ('583', '2', 'Puede utilizar anuncios para hacer llegar un mensaje a todos los usuarios de su red social. Puede enviar anuncios o noticias a través del correo electrónico.', 'admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('584', '2', 'Enviar un anuncio por correo electrónico ', 'admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('585', '2', 'Su anuncio se enviará por correo electrónico a todos los usuarios de su red social.  Si tiene muchos usuarios, este proceso puede tardar algún tiempo en completarse.', 'admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('586', '2', 'Publicar noticia', 'admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('587', '2', 'Su anuncio se publicará en la página de inicio de su red social. Este proceso es instantáneo, independientemente del tamaño de su red social. Si publicó algunas noticias en el pasado, podrá encontrarlas en la lista a continuación.  Si ha incluido HTML en sus noticias, no aparecerá a continuación, pero se mostrará correctamente en su página de inicio.', 'admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('588', '2', 'Contenidos ', 'admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('589', '2', 'Sin título', 'admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('590', '2', 'No se ha proporcionado una  fecha ', 'admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('591', '2', 'Bajar', 'admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('592', '2', 'Publicar noticia', 'admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('593', '2', 'Por favor, complete el siguiente formulario para publicar su noticia.', 'admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('594', '2', '(La fecha se mostrará exactamente como usted la introdujo más arriba)', 'admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('595', '2', '(HTML es correcto)', 'admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('596', '2', 'Guardar la noticia', 'admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('597', '2', 'Editar la noticia', 'admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('598', '2', 'Eliminar la noticia', 'admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('599', '2', ' ¿Está seguro que desea eliminar esta noticia? ', 'admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('600', '2', 'Utilice este formulario para redactar el mensaje de correo electrónico que se enviará a cada usuario registrado en la red social.  Al hacer clic en el botón enviar de más abajo, el sistema comenzará a repetir la secuencia a través de la base de datos de usuarios y a enviar el mensaje a cada uno de estos.  Si se aumenta el número de correos electrónicos por página, el proceso completo se llevará a cabo más rápidamente.  Sin embargo, si su servidor está actualmente sobrecargado, o si simplemente el tiempo no le preocupa, la selección de un menor número de correos electrónicos por página puede reducir el riesgo de desconexión.', 'admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('601', '2', 'De', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('602', '2', 'Correos electrónicos por página', 'admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('603', '2', 'Destinatarios', 'admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('604', '2', 'Seleccione los usuarios que recibirán este anuncio de correo electrónico.  Todos <a href=\'admin_levels.php\'>los niveles de usuario</a> y <a href=\'admin_subnetworks.php\'>las subredes</a>se seleccionan por defecto, esto significa que cada usuario de su red social recibirá este anuncio.  Utilice la tecla Ctrl + clic para seleccionar o deseleccionar múltiples niveles de usuario o subredes.  Si un usuario concuerda con algún nivel de usuario O alguna subred que usted haya seleccionado aquí, éste recibirá el presente anuncio.', 'admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('605', '2', 'Enviar anuncio ', 'admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('606', '2', 'Por favor proporcione un mensaje para el cuerpo de este anuncio.', 'admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('607', '2', 'Por favor, seleccione al menos un nivel de usuario o una subred como destinatario(s) de este anuncio.', 'admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('608', '2', 'Envío del correo electrónico en progreso', 'admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('609', '2', 'Su anuncio está siendo enviado a los usuarios. No navegue fuera de esta página hasta que el proceso se haya completado. Por favor, espere ... ', 'admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('610', '2', 'Envío del correo electrónico completado', 'admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('611', '2', 'El proceso de envío de correo electrónico se ha completado.  Se ha enviado un correo electrónico con su anuncio a todos los usuarios de su red social.', 'admin_announcements,');
INSERT INTO `se_languagevars` VALUES ('612', '2', 'Su red social tiene la capacidad de organizar a los usuarios en \"subredes\", basándose en la información del perfil que tienen en común unos con otros.  Usted puede utilizar esto para limitar el acceso y la privacidad entre subredes, mostrar contenidos específicos de una subred en sus plantillas, o simplemente para organizar sus usuarios. ', 'admin_subnetworks,');
INSERT INTO `se_languagevars` VALUES ('613', '2', 'Ver instrucciones detalladas', 'admin_subnetworks,');
INSERT INTO `se_languagevars` VALUES ('614', '2', '<b>Importante:</b> Los campos de requisitos que usted seleccione como obligatorios deben configurarse como \"Obligatorios para registrarse\" en la página de <a href=\'admin_signup.php\'>Configuración de registro </a>. Si no se configuran como “Obligatorios para registrarse\", pueden no aparecer durante el proceso de registro y los usuarios no tendrán la posibilidad de completarlos.  Debido a que estos no han completado sus campos de requisitos, se los colocará automáticamente en la \"Subred por defecto\" hasta que completen dichos campos. Si ya tiene usuarios en las subredes de su red social y modifica los campos de requisitos o los requisitos específicos de una subred, los usuarios permanecerán en las mismas subredes (se tendrá en cuenta los requisitos iniciales o campos de diferenciación que usted  había fijado) hasta que la información del perfil sea actualizada. Todos los usuarios que no están organizados en una subred serán colocados en la \"Subred por defecto\" hasta que la información de sus perfiles se actualice y cumpla con los requisitos de una subred diferente.  Cuando se elimina una subred, los usuarios dentro de la subred eliminada serán transferidos a la \"Subred por defecto\". <br><br><b> Ejemplo:</b> Si desea crear dos subredes, una  para varones y una para mujeres, debe crear un campo de perfil llamado \"Género\" y utilizarlo como su campo de requisito principal a continuación. Si desea tener cuatro subredes: hombres en California, mujeres en California, hombres fuera de California y mujeres fuera de California, deberá crear un campo de perfil llamado \"Ubicación\" y utilizarlo como su campo de requisito secundario. Luego, cree subredes con los requisitos pertinentes a fin de que estas cuatro subredes se excluyan mutuamente. <br><br><b>Notas: </b> Si basa sus subredes en el campo “Cumpleaños” (Edad) (por ejemplo mayores/menores de 18 años de edad), sus usuarios no serán transferidos automáticamente de una subred (menores de 18 años de edad) a otra (mayores de 18 años de edad).  Estos tendrán que actualizar su perfil.  Por otra parte, si usted hace de \"Perfil de la categoría\" su campo de requisito principal, tenga en cuenta que su campo de requisito secundario puede no ser aplicable a todas las categorías de perfil y, por tanto, no podrá ser visto por algunos usuarios.', 'admin_subnetworks,');
INSERT INTO `se_languagevars` VALUES ('615', '2', 'Campo de requisito principal:', 'admin_subnetworks,');
INSERT INTO `se_languagevars` VALUES ('616', '2', 'Dirección de correo electrónico', 'user_account, admin_subnetworks,');
INSERT INTO `se_languagevars` VALUES ('617', '2', 'Categoría de perfil  ', 'admin_viewusers_edit, admin_subnetworks,');
INSERT INTO `se_languagevars` VALUES ('618', '2', 'Campo de requisito secundario:', 'admin_subnetworks,');
INSERT INTO `se_languagevars` VALUES ('619', '2', 'Actualizar', 'admin_subnetworks,');
INSERT INTO `se_languagevars` VALUES ('620', '2', 'Añadir nueva subred', 'admin_subnetworks,');
INSERT INTO `se_languagevars` VALUES ('621', '2', 'Requisitos', 'admin_subnetworks,');
INSERT INTO `se_languagevars` VALUES ('622', '2', 'Subred por defecto', 'admin_subnetworks,');
INSERT INTO `se_languagevars` VALUES ('623', '2', 'Usuarios que no están en otra subred', 'admin_subnetworks,');
INSERT INTO `se_languagevars` VALUES ('624', '2', 'Añadir subred', 'admin_subnetworks,');
INSERT INTO `se_languagevars` VALUES ('625', '2', 'Para crear/modificar una subred, complete el siguiente formulario. Tendrá que especificar quienes pueden pertenecer a esta subred.  Puede hacer esto mediante la creación de requisitos.  Tenga en cuenta que debe especificar un requisito relacionado con su campo de requisito principal. Los requisitos basados en el campo del requisito secundario son opcionales.  El uso de comodines (*) se acepta cuando se usan los operadores \"es igual a (==)\" y \"no es igual a (!=)\". Los valores de una secuencia (por ejemplo, palabras y frases) NO distinguirán entre mayúsculas y minúsculas.  Por favor, asegúrese de que los requisitos de la subred se excluyen mutuamente, es decir, asegúrese de que los usuarios pueden ser colocados sólo en una subred considerando los requisitos que usted proporcione.  Si los requisitos se superponen con los requisitos de otra subred, los usuarios se colocan de manera aleatoria en una de las subredes superpuestas.', 'admin_subnetworks,');
INSERT INTO `se_languagevars` VALUES ('626', '2', 'es igual a (==)', 'admin_subnetworks,');
INSERT INTO `se_languagevars` VALUES ('627', '2', 'No es igual a ( != )', 'admin_subnetworks,');
INSERT INTO `se_languagevars` VALUES ('628', '2', 'Es mayor que ( > )', 'admin_subnetworks,');
INSERT INTO `se_languagevars` VALUES ('629', '2', 'Es menor que ( < )', 'admin_subnetworks,');
INSERT INTO `se_languagevars` VALUES ('630', '2', 'Es mayor o igual que (>=)', 'admin_subnetworks,');
INSERT INTO `se_languagevars` VALUES ('631', '2', 'Es menor o igual que (<= )', 'admin_subnetworks,');
INSERT INTO `se_languagevars` VALUES ('632', '2', 'Y', '');
INSERT INTO `se_languagevars` VALUES ('633', '2', 'Por favor, especifique un nombre para esta subred.', 'admin_subnetworks,');
INSERT INTO `se_languagevars` VALUES ('634', '2', 'Debe especificar un requisito principal.', 'admin_subnetworks,');
INSERT INTO `se_languagevars` VALUES ('635', '2', 'Editar subred', 'admin_subnetworks,');
INSERT INTO `se_languagevars` VALUES ('636', '2', 'Eliminar subred', 'admin_subnetworks,');
INSERT INTO `se_languagevars` VALUES ('637', '2', '¿Está seguro que desea eliminar esta subred?  Todos los usuarios en esta subred se trasladaran a la subred por defecto.', 'admin_subnetworks,');
INSERT INTO `se_languagevars` VALUES ('638', '2', 'La subred que ha seleccionado ha sido eliminada.', 'admin_subnetworks,');
INSERT INTO `se_languagevars` VALUES ('639', '2', 'Se ha producido un error', 'profile,');
INSERT INTO `se_languagevars` VALUES ('640', '2', 'No tiene autorización para ver esta página.  El usuario cuya página está tratando de visualizar lo ha incluido en su lista de bloqueo.', 'profile,');
INSERT INTO `se_languagevars` VALUES ('641', '2', 'Volver', 'profile,');
INSERT INTO `se_languagevars` VALUES ('642', '2', 'Red social', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('643', '2', 'Buscar:', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('644', '2', 'Ir', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('645', '2', 'Inicio', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('646', '2', 'Buscar', 'user_friends, search, profile,');
INSERT INTO `se_languagevars` VALUES ('647', '2', 'Invitar', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('648', '2', 'Ayuda', '');
INSERT INTO `se_languagevars` VALUES ('649', '2', 'Hola, %1$s', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('650', '2', 'Registrarse ', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('651', '2', 'Mi cuenta', '');
INSERT INTO `se_languagevars` VALUES ('652', '2', 'Perfil', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('653', '2', 'Amigos', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('654', '2', 'Mensajes', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('655', '2', 'Configuración', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('656', '2', 'Debe iniciar sesión para poder ver esta página.   <a href=\'login.php\'>Haga clic aquí</a> para acceder a su cuenta.', 'profile,');
INSERT INTO `se_languagevars` VALUES ('657', '2', 'Bienvenidos a Social Network, la comunidad en línea para padres que trabajan, viven o juegan en Londres.  El sitio está diseñado para dar a los padres un lugar para compartir consejos y trucos sobre la paternidad, conocer a otros padres y compartir una salida y, fundamentalmente para darles ideas sobre la manera de entretener a los pequeños traviesos del hogar.  El sitio está en fase beta por lo que agradecemos su aporte para construir el mejor recurso para los padres en Londres. ', 'home,');
INSERT INTO `se_languagevars` VALUES ('658', '2', 'Acceso a la cuenta', 'login,');
INSERT INTO `se_languagevars` VALUES ('673', '2', '¡Bienvenido a Social Network!  Si ya tiene una cuenta, puede acceder a continuación.<br>Si no tiene una cuenta, puede registrarse <a href=\'signup.php\'>aquí</a>!', 'login,');
INSERT INTO `se_languagevars` VALUES ('674', '2', '<br>Si todavía está a la espera de su correo electrónico de verificación, <a href=\'signup_verify.php?task=resend\'>haga clic aquí</a> para reenviarlo.', 'login,');
INSERT INTO `se_languagevars` VALUES ('659', '2', 'Acceso de un miembro', 'home,');
INSERT INTO `se_languagevars` VALUES ('511', '2', 'Estadísticas de la red', 'home,');
INSERT INTO `se_languagevars` VALUES ('661', '2', 'Miembros: %1$d miembros', 'home,');
INSERT INTO `se_languagevars` VALUES ('662', '2', 'Amistades: %1$d amigos', 'home,');
INSERT INTO `se_languagevars` VALUES ('663', '2', 'Comentarios: %1$d comentarios', 'home,');
INSERT INTO `se_languagevars` VALUES ('664', '2', 'Noticias recientes', 'user_home, home,');
INSERT INTO `se_languagevars` VALUES ('665', '2', 'Gente en línea', 'user_home, home,');
INSERT INTO `se_languagevars` VALUES ('666', '2', 'Miembros más recientes', 'network, home,');
INSERT INTO `se_languagevars` VALUES ('667', '2', 'Ningún miembro se ha registrado aún.', 'home,');
INSERT INTO `se_languagevars` VALUES ('668', '2', 'Miembros populares', 'home,');
INSERT INTO `se_languagevars` VALUES ('669', '2', '%1$d amigos', 'home,');
INSERT INTO `se_languagevars` VALUES ('670', '2', 'Ningún miembro se ha convertido en amigo aún.', 'home,');
INSERT INTO `se_languagevars` VALUES ('671', '2', 'Miembros conectados últimamente', 'home,');
INSERT INTO `se_languagevars` VALUES ('672', '2', 'Ningún miembro se ha conectado aún.', 'home,');
INSERT INTO `se_languagevars` VALUES ('675', '2', '¿Olvidó la contraseña?', 'login,');
INSERT INTO `se_languagevars` VALUES ('676', '2', 'Los datos de acceso proporcionados no eran válidos.  Por favor, inténtelo de nuevo.', 'login,');
INSERT INTO `se_languagevars` VALUES ('677', '2', 'El administrador ha desactivado su cuenta.', '');
INSERT INTO `se_languagevars` VALUES ('678', '2', 'Aún no ha verificado su dirección de correo electrónico.  Si desea que le reenvíen el correo electrónico por favor, <a href=\'signup_verify.php?task=resend\'>haga clic aquí</a>.', '');
INSERT INTO `se_languagevars` VALUES ('679', '2', 'Crear su cuenta', 'signup,');
INSERT INTO `se_languagevars` VALUES ('680', '2', '¡Bienvenido a Social Network!  Para crear su cuenta, por favor proporcione la siguiente información.', 'signup,');
INSERT INTO `se_languagevars` VALUES ('681', '2', 'Información de acceso', 'signup,');
INSERT INTO `se_languagevars` VALUES ('682', '2', 'Usted usará su dirección de correo electrónico para acceder a su cuenta.', 'signup,');
INSERT INTO `se_languagevars` VALUES ('683', '2', 'Introduzca la contraseña nuevamente para su confirmación.', 'signup,');
INSERT INTO `se_languagevars` VALUES ('684', '2', 'Información de la cuenta', 'signup,');
INSERT INTO `se_languagevars` VALUES ('685', '2', 'Este es el nombre que otros ven cuando visitan su perfil.  Si decide cambiar su nombre de usuario, debe introducir uno que no haya sido elegido por otra persona.', 'signup,');
INSERT INTO `se_languagevars` VALUES ('686', '2', 'Este será el nombre que otros verán cuando visiten su perfil. ', 'signup,');
INSERT INTO `se_languagevars` VALUES ('687', '2', 'Idioma', 'signup,');
INSERT INTO `se_languagevars` VALUES ('688', '2', 'Información de seguridad', 'signup,');
INSERT INTO `se_languagevars` VALUES ('689', '2', 'Código de la invitación', 'signup,');
INSERT INTO `se_languagevars` VALUES ('690', '2', 'Código de seguridad', 'signup,');
INSERT INTO `se_languagevars` VALUES ('691', '2', 'Introduzca los números que ve en esta imagen en el campo a su izquierda.  Esto ayuda a mantener nuestro sitio libre de spam. Si tiene problemas para leer el código, haga clic en él para generar uno nuevo.', 'signup,');
INSERT INTO `se_languagevars` VALUES ('692', '2', 'He leído y estoy de acuerdo con  <a href=\'help_tos.php\' target=\'_blank\'>las condiciones del servicio</a>.', 'signup,');
INSERT INTO `se_languagevars` VALUES ('693', '2', 'Continuar ...', 'signup,');
INSERT INTO `se_languagevars` VALUES ('694', '2', 'Por favor, asegúrese de que su nombre de usuario es alfanumérico.', '');
INSERT INTO `se_languagevars` VALUES ('695', '2', 'El nombre de usuario que ha seleccionado está prohibido.  Por favor, elija otro.', '');
INSERT INTO `se_languagevars` VALUES ('696', '2', 'El nombre de usuario que ha seleccionado está reservado.  Por favor, elija otro.', '');
INSERT INTO `se_languagevars` VALUES ('697', '2', 'La dirección de correo electrónico que ha proporcionado está prohibida.  Por favor, proporcione otra.', '');
INSERT INTO `se_languagevars` VALUES ('698', '2', 'La dirección de correo electrónico que ha proporcionado no es una dirección de correo electrónico válida.', 'help_contact,');
INSERT INTO `se_languagevars` VALUES ('699', '2', 'El nombre de usuario que ha seleccionado ya ha sido seleccionado. Por favor, elija otro.', 'signup,');
INSERT INTO `se_languagevars` VALUES ('700', '2', 'La dirección de correo electrónico que nos ha proporcionado ya ha sido seleccionada Por favor, proporcione otra.', 'signup,');
INSERT INTO `se_languagevars` VALUES ('701', '2', 'La antigua contraseña que ha proporcionado es incorrecta. Por favor, inténtelo de nuevo.', 'user_account_pass,');
INSERT INTO `se_languagevars` VALUES ('702', '2', 'Por favor, asegúrese de haber proporcionado la misma contraseña en ambos campos de la nueva contraseña.', 'lostpass_reset,');
INSERT INTO `se_languagevars` VALUES ('703', '2', 'Por favor, proporcione una contraseña con al menos 6 letras o números.', 'lostpass_reset,');
INSERT INTO `se_languagevars` VALUES ('704', '2', 'Por favor, asegúrese de que su contraseña es alfanumérica.', 'lostpass_reset,');
INSERT INTO `se_languagevars` VALUES ('705', '2', 'La combinación de código de invitación y dirección de correo electrónico que ha insertado no es válida.', '');
INSERT INTO `se_languagevars` VALUES ('706', '2', 'El código de invitación que ha introducido no es válido.', '');
INSERT INTO `se_languagevars` VALUES ('707', '2', 'Debe aceptar las condiciones del servicio para registrarse.', 'signup,');
INSERT INTO `se_languagevars` VALUES ('708', '2', 'Por favor, asegúrese de haber introducido correctamente el código de verificación.', 'signup,');
INSERT INTO `se_languagevars` VALUES ('709', '2', 'Tipo de cuenta', 'user_account, signup,');
INSERT INTO `se_languagevars` VALUES ('710', '2', 'Cree su perfil', 'signup,');
INSERT INTO `se_languagevars` VALUES ('711', '2', 'Cuéntenos un poco más sobre usted mismo.  Los campos marcados con un asterisco (*) son obligatorios.', 'signup,');
INSERT INTO `se_languagevars` VALUES ('800002', '2', 'Denunciar abuso', 'help, admin_faq,');
INSERT INTO `se_languagevars` VALUES ('712', '2', 'Subir su fotografía', 'signup,');
INSERT INTO `se_languagevars` VALUES ('713', '2', 'Suba una fotografía suya desde su ordenador.  Este será el ícono que otras personas verán en su perfil. ', 'user_editprofile_photo, signup,');
INSERT INTO `se_languagevars` VALUES ('714', '2', 'Subir', 'user_editprofile_photo, signup,');
INSERT INTO `se_languagevars` VALUES ('715', '2', 'Para subir su foto, haga clic en el botón \"Examinar\", busque la fotografía en su ordenador y haga clic en el botón \"Subir\".  Su fotografía debe tener un tamaño inferior a 4 MB y debe ser de uno de estos tipos:', 'user_editprofile_photo, signup,');
INSERT INTO `se_languagevars` VALUES ('716', '2', 'Guardar esta foto', 'signup,');
INSERT INTO `se_languagevars` VALUES ('717', '2', 'Omitir este paso', 'signup,');
INSERT INTO `se_languagevars` VALUES ('718', '2', 'Error al subir la fotografía.  Por favor, inténtelo de nuevo. Si el problema persiste, póngase en contacto con el administrador para obtener ayuda. ', '');
INSERT INTO `se_languagevars` VALUES ('719', '2', 'El tamaño del archivo que ha subido es mayor que el máximo permitido.', '');
INSERT INTO `se_languagevars` VALUES ('720', '2', 'El tipo de archivo de su archivo no está permitido.', '');
INSERT INTO `se_languagevars` VALUES ('721', '2', 'Las dimensiones de su imagen son mayores que el ancho y la altura máximos permitidos.', '');
INSERT INTO `se_languagevars` VALUES ('722', '2', 'Invitar a sus amigos', 'signup,');
INSERT INTO `se_languagevars` VALUES ('723', '2', '¡Invite a sus amigos a participar!  Introduzca las direcciones de correo electrónico de sus amigos separadas por comas en el campo de abajo.', 'signup,');
INSERT INTO `se_languagevars` VALUES ('724', '2', 'Enviar invitaciones a:', 'signup,');
INSERT INTO `se_languagevars` VALUES ('725', '2', 'Introduzca las direcciones de correo electrónico de sus amigos (hasta 5) a continuación, separadas por comas.', 'signup,');
INSERT INTO `se_languagevars` VALUES ('726', '2', 'Su mensaje', 'signup,');
INSERT INTO `se_languagevars` VALUES ('727', '2', 'Si desea incluir un mensaje personal en sus invitaciones, introdúzcalo aquí. (opcional)', 'signup,');
INSERT INTO `se_languagevars` VALUES ('728', '2', 'Enviar invitaciones', 'signup, invite,');
INSERT INTO `se_languagevars` VALUES ('729', '2', '¡Registro completado!', 'signup,');
INSERT INTO `se_languagevars` VALUES ('730', '2', '¡Enhorabuena!  Ha creado su cuenta exitosamente.', 'signup,');
INSERT INTO `se_languagevars` VALUES ('731', '2', 'Usted podrá iniciar su sesión después de recibir la  aprobación de un administrador.', 'signup,');
INSERT INTO `se_languagevars` VALUES ('732', '2', 'Su contraseña ha sido enviada a la dirección de correo electrónico que nos ha proporcionado.', 'signup,');
INSERT INTO `se_languagevars` VALUES ('733', '2', 'Haga clic en el botón a continuación para acceder a su cuenta.', 'signup,');
INSERT INTO `se_languagevars` VALUES ('734', '2', 'Se ha enviado un mensaje de correo electrónico a la dirección de correo electrónico que nos ha proporcionado. Por favor siga el enlace que aparece en el mensaje para verificar su dirección de correo electrónico.', 'signup,');
INSERT INTO `se_languagevars` VALUES ('735', '2', 'Volver a la pagina de inicio', 'signup,');
INSERT INTO `se_languagevars` VALUES ('736', '2', '(Edad)', 'search_advanced, admin_subnetworks,');
INSERT INTO `se_languagevars` VALUES ('737', '2', '¿Qué novedades hay?', 'user_home, home,');
INSERT INTO `se_languagevars` VALUES ('738', '2', 'No ha habido ninguna actividad reciente en la red social.', 'user_home, network,');
INSERT INTO `se_languagevars` VALUES ('739', '2', 'Estadísticas del perfil  ', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('740', '2', '%1$d visitas al perfil ', 'user_home, profile,');
INSERT INTO `se_languagevars` VALUES ('741', '2', 'Restablecer', 'user_home,');
INSERT INTO `se_languagevars` VALUES ('742', '2', 'Mi estado', 'user_home,');
INSERT INTO `se_languagevars` VALUES ('743', '2', 'Actualizar su estado.', 'user_home, profile,');
INSERT INTO `se_languagevars` VALUES ('744', '2', 'es', 'user_home, profile,');
INSERT INTO `se_languagevars` VALUES ('745', '2', 'Actualizar', 'user_home, profile,');
INSERT INTO `se_languagevars` VALUES ('746', '2', 'Guardar', 'user_home, profile,');
INSERT INTO `se_languagevars` VALUES ('747', '2', 'Cancelar', 'user_home, profile,');
INSERT INTO `se_languagevars` VALUES ('748', '2', 'El correo electrónico que ha introducido no se ha encontrado en la base de datos. Por favor, inténtelo de nuevo.', '');
INSERT INTO `se_languagevars` VALUES ('749', '2', 'Enviar contraseña', 'lostpass,');
INSERT INTO `se_languagevars` VALUES ('750', '2', 'Este enlace no es válido o ha caducado. Por favor, <a href=\'lostpass.php\'>reenvíe</a> su solicitud de contraseña y haga clic en el enlace enviado a su dirección de correo electrónico.', '');
INSERT INTO `se_languagevars` VALUES ('751', '2', 'Su contraseña se ha restablecido.  <a href=\'login.php\'>Haga clic aquí</a> para acceder a su cuenta.', 'lostpass_reset,');
INSERT INTO `se_languagevars` VALUES ('752', '2', 'Preguntas más frecuentes (FAQ)', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('753', '2', 'Condiciones del servicio', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('754', '2', 'Póngase en contacto con nosotros', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('755', '2', 'Configuración de la cuenta', 'user_account,');
INSERT INTO `se_languagevars` VALUES ('756', '2', 'Cambiar contraseña', 'user_account_privacy, user_account_pass, user_account_delete, user_account,');
INSERT INTO `se_languagevars` VALUES ('757', '2', 'Eliminar la cuenta', 'user_account_privacy, user_account_pass, user_account_delete, user_account,');
INSERT INTO `se_languagevars` VALUES ('758', '2', 'Si desea cambiar la contraseña de su cuenta, por favor complete el siguiente formulario.', 'user_account_pass,');
INSERT INTO `se_languagevars` VALUES ('759', '2', '¿Desea eliminar la cuenta?', 'user_account_delete,');
INSERT INTO `se_languagevars` VALUES ('760', '2', '¿Está seguro que desea eliminar su cuenta? Todos los datos de su cuenta, incluidos los archivos que ha subido, ¡se eliminarán definitivamente!  Tras la eliminación de su cuenta, la sesión se cerrará automáticamente.', 'user_account_delete,');
INSERT INTO `se_languagevars` VALUES ('761', '2', 'Eliminar mi cuenta', 'user_account_delete,');
INSERT INTO `se_languagevars` VALUES ('762', '2', 'Fotografía', 'user_editprofile_style, user_editprofile_photo, user_editprofile,');
INSERT INTO `se_languagevars` VALUES ('763', '2', 'Estilo del perfil  ', 'user_editprofile_style, user_editprofile_photo, user_editprofile,');
INSERT INTO `se_languagevars` VALUES ('764', '2', 'Editar perfil: %1$s', 'user_editprofile,');
INSERT INTO `se_languagevars` VALUES ('765', '2', 'Por favor, proporcione alguna información sobre usted.', 'user_editprofile,');
INSERT INTO `se_languagevars` VALUES ('766', '2', 'Si modifica este campo, puede modificar la red a la cual usted pertenece.<br>Actualmente pertenece a: %1$s', 'user_editprofile, user_account,');
INSERT INTO `se_languagevars` VALUES ('767', '2', 'Su red se ha modificado de %1$s a %2$s.', 'user_editprofile,');
INSERT INTO `se_languagevars` VALUES ('768', '2', 'Estado', 'profile,');
INSERT INTO `se_languagevars` VALUES ('769', '2', 'Editar mi fotografía', 'user_editprofile_photo,');
INSERT INTO `se_languagevars` VALUES ('770', '2', 'Fotografía actual', 'user_editprofile_photo,');
INSERT INTO `se_languagevars` VALUES ('771', '2', 'Quitar la fotografía', 'user_editprofile_photo,');
INSERT INTO `se_languagevars` VALUES ('772', '2', 'Subir una fotografía', 'user_editprofile_photo,');
INSERT INTO `se_languagevars` VALUES ('773', '2', 'hace %1$d segundo(s) ', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_lostpass_reset, admin_lostpass, admin_login, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_fields, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('774', '2', 'hace %1$d minuto(s) ', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_lostpass_reset, admin_lostpass, admin_login, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_fields, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('775', '2', 'hace %1$d hora(s) ', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_lostpass_reset, admin_lostpass, admin_login, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_fields, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('776', '2', 'hace %1$d día(s) ', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_lostpass_reset, admin_lostpass, admin_login, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_fields, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('777', '2', 'hace %1$d semana(s) ', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_lostpass_reset, admin_lostpass, admin_login, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_fields, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('778', '2', 'hace %1$d mes(es) ', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_lostpass_reset, admin_lostpass, admin_login, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_fields, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('779', '2', 'hace %1$d año(s) ', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_lostpass_reset, admin_lostpass, admin_login, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_fields, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('780', '2', 'Bandeja de entrada', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('781', '2', 'Mensajes enviados', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('782', '2', 'Mi bandeja de entrada de mensajes ', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('783', '2', 'Usted tiene %1$s conversación(es) no leída(s) en su bandeja de entrada.', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('784', '2', 'Redactar un mensaje nuevo', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('785', '2', 'Su bandeja de entrada está vacía.  Cuando usted reciba mensajes en el futuro, podrá encontrarlos aquí.', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('786', '2', 'Perfil de %1$s ', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('787', '2', 'Responder', 'profile,');
INSERT INTO `se_languagevars` VALUES ('788', '2', 'Eliminar seleccionados', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help, admin_viewusers, admin_viewreports,');
INSERT INTO `se_languagevars` VALUES ('789', '2', 'Cree su nuevo mensaje usando el siguiente formulario. <br>Puede especificar varios destinatarios (hasta $1%d),  usted puede seleccionar ya sea un amigo del área de  auto-sugerencias o, simplemente, escribir un nombre de usuario y pulsar Enter.', 'user_messages_new,');
INSERT INTO `se_languagevars` VALUES ('790', '2', 'Para', 'user_messages_outbox, user_messages_new,');
INSERT INTO `se_languagevars` VALUES ('791', '2', 'Enviar mensaje', 'user_messages_view, user_messages_new,');
INSERT INTO `se_languagevars` VALUES ('792', '2', 'Número máximo de destinatarios', 'admin_levels_messagesettings,');
INSERT INTO `se_languagevars` VALUES ('793', '2', '¿A cuántos destinatarios puede un usuario enviar un mensaje a la vez? ', 'admin_levels_messagesettings,');
INSERT INTO `se_languagevars` VALUES ('794', '2', 'Destinatario(s) a la vez', 'admin_levels_messagesettings,');
INSERT INTO `se_languagevars` VALUES ('795', '2', 'Por favor, introduzca un destinatario válido.', '');
INSERT INTO `se_languagevars` VALUES ('796', '2', 'Debe introducir un mensaje.', 'user_messages_view,');
INSERT INTO `se_languagevars` VALUES ('797', '2', 'Mis mensajes enviados', 'user_messages_outbox,');
INSERT INTO `se_languagevars` VALUES ('798', '2', 'Usted tiene un total de %1$d mensaje(s) en su bandeja de salida.', 'user_messages_outbox,');
INSERT INTO `se_languagevars` VALUES ('799', '2', 'Su bandeja de salida está vacía.  Cuando usted envíe mensajes en el futuro, podrá encontrarlos aquí.', 'user_messages_outbox,');
INSERT INTO `se_languagevars` VALUES ('800', '2', '%1$s destinatarios', 'user_messages_outbox,');
INSERT INTO `se_languagevars` VALUES ('801', '2', 'Entre %1$s y Usted', 'user_messages_view,');
INSERT INTO `se_languagevars` VALUES ('802', '2', 'Responder:', 'user_messages_view,');
INSERT INTO `se_languagevars` VALUES ('803', '2', 'Responder a todos:', 'user_messages_view,');
INSERT INTO `se_languagevars` VALUES ('804', '2', '¡Su mensaje ha sido enviado!', 'user_messages_new,');
INSERT INTO `se_languagevars` VALUES ('805', '2', 'Volver a la bandeja de entrada', 'user_messages_view,');
INSERT INTO `se_languagevars` VALUES ('806', '2', 'Volver a la bandeja de salida', 'user_messages_view,');
INSERT INTO `se_languagevars` VALUES ('807', '2', 'No tiene autorización para ver esta página.  Se le ha prohibido el acceso a la red.', '');
INSERT INTO `se_languagevars` VALUES ('808', '2', 'Si es necesario, puede realizar cambios en la configuración de su cuenta a continuación.', 'user_account,');
INSERT INTO `se_languagevars` VALUES ('809', '2', 'Este es el nombre que otros ven cuando visitan su perfil.  Si decide cambiar su nombre de usuario, debe introducir uno que no haya sido elegido por otra persona.', 'user_account,');
INSERT INTO `se_languagevars` VALUES ('810', '2', 'Tenga en cuenta que al cambiar su nombre de usuario borrará su informe de actividad reciente.', 'user_account,');
INSERT INTO `se_languagevars` VALUES ('811', '2', 'Privacidad de la actividad reciente ', 'user_account_privacy,');
INSERT INTO `se_languagevars` VALUES ('812', '2', '¿Qué desea que se publique sobre usted en el <a href=\'user_home.php\'> informe de actividad reciente</a>?<br> Tenga en cuenta que si modifica esta configuración, sólo afectará las futuras noticias del informe.', 'user_account_privacy,');
INSERT INTO `se_languagevars` VALUES ('813', '2', 'Lista de bloqueo', 'user_account_privacy,');
INSERT INTO `se_languagevars` VALUES ('814', '2', 'Si añade una persona a su lista de bloqueo, su perfil (y todos sus demás contenidos) se oculta para la misma.  Todas las conexiones que tenga con una persona bloqueada, serán canceladas.  Para añadir a alguien a su lista de bloqueo, haga clic en el enlace \"Añadir nueva persona\" e introduzca su nombre de usuario.  Si introduce el nombre de usuario de alguien que no existe o ha sido eliminado, este no se añadirá a su lista de bloqueo.', 'user_account_privacy,');
INSERT INTO `se_languagevars` VALUES ('815', '2', 'Añadir nueva persona', 'user_account_privacy,');
INSERT INTO `se_languagevars` VALUES ('700008', '2', 'Iniciar sesión', '');
INSERT INTO `se_languagevars` VALUES ('700009', '2', 'Cambiar la fotografía del perfil ', 'user_home, user_account_privacy,');
INSERT INTO `se_languagevars` VALUES ('700010', '2', 'Editar perfil', 'user_home, user_account_privacy,');
INSERT INTO `se_languagevars` VALUES ('700011', '2', 'Publicar un comentario en el perfil.', 'user_home, user_account_privacy,');
INSERT INTO `se_languagevars` VALUES ('700012', '2', 'Añadir un amigo', 'user_home, user_account_privacy,');
INSERT INTO `se_languagevars` VALUES ('700013', '2', 'Registrarse ', 'user_home,');
INSERT INTO `se_languagevars` VALUES ('700014', '2', 'Cambiar de estado.', 'user_home, user_account_privacy,');
INSERT INTO `se_languagevars` VALUES ('816', '2', 'Sus cambios se han guardado. Antes de que su nueva dirección de correo electrónico se active, usted debe seguir el enlace que se le ha enviado por correo electrónico. ', '');
INSERT INTO `se_languagevars` VALUES ('817', '2', 'Sus cambios se han guardado. Antes de que su nueva dirección de correo electrónico se active, usted debe seguir el enlace que se le ha enviado por correo electrónico.  Una vez que ha verificado su dirección de correo electrónico, su red se habrá modificado de %1$s a %1$s.', '');
INSERT INTO `se_languagevars` VALUES ('818', '2', 'En espera de la verificación para %1$s.', 'user_account,');
INSERT INTO `se_languagevars` VALUES ('819', '2', 'Sus cambios se han guardado y su red se ha modificado de% 1$s a% 2$s.', '');
INSERT INTO `se_languagevars` VALUES ('820', '2', '¿Desea permitir cambiar el nombre de usuario?', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('821', '2', 'Active esta función si desea permitir que sus usuarios cambien su nombre de usuario.  Tenga en cuenta que si tiene los nombres de usuario desactivados en la página<a href=\'admin_general.php\'>Configuración general</a>, esta función es irrelevante.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('822', '2', 'Sí, permitir a los usuarios cambiar sus nombres de usuario.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('823', '2', 'No, no permitir a los usuarios cambiar su nombre de usuario.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('824', '2', '¿Desea permitir la eliminación de una cuenta?', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('825', '2', 'Active esta función si desea permitir que sus usuarios eliminen sus cuentas manualmente. ', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('826', '2', 'Sí, permitir a los usuarios que eliminen sus cuentas.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('827', '2', 'No, no permitir a los usuarios que eliminen sus cuentas.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('828', '2', 'El perfil que busca se ha eliminado o no existe.', 'profile,');
INSERT INTO `se_languagevars` VALUES ('829', '2', 'Escribir algo…', 'profile,');
INSERT INTO `se_languagevars` VALUES ('830', '2', 'Publicando…', 'profile,');
INSERT INTO `se_languagevars` VALUES ('831', '2', 'Por favor, introduzca un mensaje.', 'profile,');
INSERT INTO `se_languagevars` VALUES ('832', '2', 'Ha introducido el código de seguridad incorrecto.', 'profile,');
INSERT INTO `se_languagevars` VALUES ('833', '2', 'Publicar un comentario', 'profile,');
INSERT INTO `se_languagevars` VALUES ('834', '2', 'Mensaje ', 'profile,');
INSERT INTO `se_languagevars` VALUES ('835', '2', 'Anónimo', 'profile,');
INSERT INTO `se_languagevars` VALUES ('836', '2', 'Ver amigos de %1$s  ', 'user_friends,');
INSERT INTO `se_languagevars` VALUES ('837', '2', 'Eliminar de “Mis amigos”', 'user_friends, profile,');
INSERT INTO `se_languagevars` VALUES ('838', '2', 'Añadir a “Mis amigos”', 'profile,');
INSERT INTO `se_languagevars` VALUES ('839', '2', 'Enviar mensaje', 'user_friends_requests_outgoing, user_friends_requests, user_friends, profile, help_contact,');
INSERT INTO `se_languagevars` VALUES ('840', '2', 'Denunciar a esta persona', 'profile,');
INSERT INTO `se_languagevars` VALUES ('841', '2', 'Desbloquear a esta persona', 'profile,');
INSERT INTO `se_languagevars` VALUES ('842', '2', 'Bloquear a esta persona', 'profile,');
INSERT INTO `se_languagevars` VALUES ('843', '2', 'Perfil privado', 'profile,');
INSERT INTO `se_languagevars` VALUES ('844', '2', 'No tiene autorización para ver este perfil. ', 'profile,');
INSERT INTO `se_languagevars` VALUES ('845', '2', '%1$s está en línea', 'profile,');
INSERT INTO `se_languagevars` VALUES ('846', '2', 'Visitas al  perfil:', 'profile,');
INSERT INTO `se_languagevars` VALUES ('847', '2', 'Amigos:', 'profile,');
INSERT INTO `se_languagevars` VALUES ('848', '2', '%1$d amigos', 'profile,');
INSERT INTO `se_languagevars` VALUES ('849', '2', 'Actualizado', 'user_friends_requests_outgoing, user_friends_requests, user_friends, profile,');
INSERT INTO `se_languagevars` VALUES ('850', '2', 'Fecha de registro:', 'profile,');
INSERT INTO `se_languagevars` VALUES ('851', '2', 'Actividad reciente ', 'profile, admin_viewusers_edit,');
INSERT INTO `se_languagevars` VALUES ('852', '2', '%1$d años de edad ', 'profile,');
INSERT INTO `se_languagevars` VALUES ('853', '2', 'Ver todos los amigos', '');
INSERT INTO `se_languagevars` VALUES ('854', '2', 'Comentarios', 'profile,');
INSERT INTO `se_languagevars` VALUES ('855', '2', 'Ver todos los comentarios', '');
INSERT INTO `se_languagevars` VALUES ('856', '2', 'Introduzca los números que ve a la izquierda.  Si tiene problemas para leer los números, haga clic en estos para generar otros nuevos.', 'profile, invite,');
INSERT INTO `se_languagevars` VALUES ('857', '2', 'Notificar a un administrador', 'profile,');
INSERT INTO `se_languagevars` VALUES ('858', '2', 'Por favor, complete el siguiente formulario para notificar a la administración sobre esta página.', 'user_report,');
INSERT INTO `se_languagevars` VALUES ('859', '2', '¿Qué desea denunciar?', 'user_report,');
INSERT INTO `se_languagevars` VALUES ('860', '2', 'Spam', 'user_report, admin_viewreports,');
INSERT INTO `se_languagevars` VALUES ('861', '2', 'Contenido inapropiado', 'user_report, admin_viewreports,');
INSERT INTO `se_languagevars` VALUES ('862', '2', 'Abuso', 'user_report, admin_viewreports,');
INSERT INTO `se_languagevars` VALUES ('863', '2', 'Otros', 'user_report, user_friends_manage, admin_viewreports,');
INSERT INTO `se_languagevars` VALUES ('864', '2', 'Por favor, proporcione una breve descripción del problema.', 'user_report,');
INSERT INTO `se_languagevars` VALUES ('865', '2', 'Enviar denuncia ', 'user_report,');
INSERT INTO `se_languagevars` VALUES ('866', '2', 'Gracias por su denuncia.  La hemos recibido y la procesaremos lo antes posible.', 'user_report,');
INSERT INTO `se_languagevars` VALUES ('867', '2', 'Ha desbloqueado exitosamente a %1$s.', 'user_friends_block,');
INSERT INTO `se_languagevars` VALUES ('868', '2', 'Bloquear usuario', 'profile,');
INSERT INTO `se_languagevars` VALUES ('869', '2', 'Desbloquear usuario', 'profile,');
INSERT INTO `se_languagevars` VALUES ('870', '2', '¿Está seguro que desea desbloquear a %1$s? ', 'user_friends_block,');
INSERT INTO `se_languagevars` VALUES ('871', '2', 'Desbloquear', 'user_friends_block,');
INSERT INTO `se_languagevars` VALUES ('872', '2', 'Ha bloqueado exitosamente a %1$s.', 'user_friends_block,');
INSERT INTO `se_languagevars` VALUES ('873', '2', '¿Está seguro que desea bloquear a %1$s? ', 'user_friends_block,');
INSERT INTO `se_languagevars` VALUES ('874', '2', 'Bloquear', 'user_friends_block,');
INSERT INTO `se_languagevars` VALUES ('875', '2', 'En espera de la confirmación de amistad', 'profile,');
INSERT INTO `se_languagevars` VALUES ('876', '2', 'Añadir a “Mis amigos”', 'profile,');
INSERT INTO `se_languagevars` VALUES ('877', '2', '¿Está seguro que desea eliminar a %1$s de sus amigos? ', 'user_friends_manage,');
INSERT INTO `se_languagevars` VALUES ('878', '2', 'Se ha enviado un mensaje a este usuario para confirmar su amistad.', 'user_friends_manage,');
INSERT INTO `se_languagevars` VALUES ('879', '2', 'Este usuario se ha añadido a su lista de amigos.', 'user_friends_manage,');
INSERT INTO `se_languagevars` VALUES ('880', '2', 'Usted está a punto de añadir %1$s a sus amigos.  Si añade a esta persona a sus amigos, ésta podrá ver su perfil (aún cuando el mismo sea visible sólo para amigos).  ¿Está seguro que desea añadir %1$s a sus amigos? ', 'user_friends_manage,');
INSERT INTO `se_languagevars` VALUES ('881', '2', 'Cuéntenos más sobre cómo conoce a %1$s.', 'user_friends_manage,');
INSERT INTO `se_languagevars` VALUES ('882', '2', 'Tipo de amigo:', 'user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends, profile,');
INSERT INTO `se_languagevars` VALUES ('883', '2', '¿Cómo conoce a esta persona?', 'user_friends_manage,');
INSERT INTO `se_languagevars` VALUES ('884', '2', 'Añadir un amigo ', 'user_friends_manage,');
INSERT INTO `se_languagevars` VALUES ('885', '2', 'Confirmar solicitud de amigo pendiente', 'profile,');
INSERT INTO `se_languagevars` VALUES ('886', '2', 'La solicitud de amistad de este usuario ha sido confirmada.', '');
INSERT INTO `se_languagevars` VALUES ('887', '2', 'Confirmar solicitud de amigo', 'user_friends_requests_outgoing, user_friends_requests, user_friends_manage, profile,');
INSERT INTO `se_languagevars` VALUES ('888', '2', '¿Está seguro que desea confirmar la solicitud de amistad de %1$s? ', 'user_friends_manage,');
INSERT INTO `se_languagevars` VALUES ('889', '2', 'Eliminar un amigo ', 'user_friends_manage, user_friends,');
INSERT INTO `se_languagevars` VALUES ('890', '2', 'Este usuario ha sido eliminado a su lista de amigos.', '');
INSERT INTO `se_languagevars` VALUES ('892', '2', 'HTML en los comentarios', 'admin_general,');
INSERT INTO `se_languagevars` VALUES ('891', '2', 'Completo', 'profile,');
INSERT INTO `se_languagevars` VALUES ('893', '2', 'Por defecto, el usuario no puede introducir etiquetas HTML en los comentarios. Si desea permitir etiquetas específicas, puede introducirlas a continuación (separadas por comas).  Ejemplo: <i>b, img, a, incrustar, fuente<i>', 'admin_general,');
INSERT INTO `se_languagevars` VALUES ('894', '2', 'Amigos actuales', 'user_friends_requests_outgoing, user_friends_requests, user_friends,');
INSERT INTO `se_languagevars` VALUES ('895', '2', 'Solicitudes de amigo', 'user_friends_requests_outgoing, user_friends_requests, user_friends,');
INSERT INTO `se_languagevars` VALUES ('896', '2', 'Solicitudes de amigo salientes', 'user_friends_requests_outgoing, user_friends_requests, user_friends,');
INSERT INTO `se_languagevars` VALUES ('897', '2', 'Mis amigos', 'user_friends,');
INSERT INTO `se_languagevars` VALUES ('898', '2', 'Todos los que se encuentran actualmente en su lista de amigos se muestran aquí. Para buscar un amigo en especial, introduzca una palabra clave en el campo de abajo.', 'user_friends,');
INSERT INTO `se_languagevars` VALUES ('899', '2', 'Buscar a mis amigos:', 'user_friends,');
INSERT INTO `se_languagevars` VALUES ('900', '2', 'Ordenar por:', 'user_friends,');
INSERT INTO `se_languagevars` VALUES ('901', '2', 'Recientemente actualizados', 'user_friends,');
INSERT INTO `se_languagevars` VALUES ('902', '2', 'Recientemente conectados ', 'user_friends,');
INSERT INTO `se_languagevars` VALUES ('903', '2', 'Tipo de amigo', 'user_friends,');
INSERT INTO `se_languagevars` VALUES ('904', '2', 'Su lista de amigos está vacía. ', 'user_friends,');
INSERT INTO `se_languagevars` VALUES ('905', '2', 'Ninguno de sus amigos coincide con sus criterios de búsqueda.', 'user_friends,');
INSERT INTO `se_languagevars` VALUES ('906', '2', 'Último inicio de sesión:', 'user_friends_requests_outgoing, user_friends_requests, user_friends,');
INSERT INTO `se_languagevars` VALUES ('907', '2', 'Detalles:', 'user_friends_requests_outgoing, user_friends_requests, user_friends, profile,');
INSERT INTO `se_languagevars` VALUES ('908', '2', 'Editar amistad', 'user_friends,');
INSERT INTO `se_languagevars` VALUES ('909', '2', 'Cuando otras personas solicitan convertirse en sus amigos, sus peticiones aparecen aquí.  Puede aprobar o rechazar sus solicitudes. ', 'user_friends_requests,');
INSERT INTO `se_languagevars` VALUES ('910', '2', 'Usted no tiene ninguna solicitud de amigo en este momento.', 'user_friends_requests,');
INSERT INTO `se_languagevars` VALUES ('911', '2', 'Rechazar solicitud de amigo', 'user_friends_requests,');
INSERT INTO `se_languagevars` VALUES ('912', '2', '¿Está seguro que desea rechazar la solicitud de amistad de %1$s? ', 'user_friends_manage,');
INSERT INTO `se_languagevars` VALUES ('913', '2', 'Rechazar la solicitud ', 'user_friends_manage,');
INSERT INTO `se_languagevars` VALUES ('914', '2', 'Ha rechazado la solicitud de amistad de este usuario exitosamente.', '');
INSERT INTO `se_languagevars` VALUES ('915', '2', 'Cuando les solicite a otras personas que sean sus amigos, sus peticiones pendientes se publicarán aquí hasta que sean aprobadas o rechazadas.', 'user_friends_requests_outgoing,');
INSERT INTO `se_languagevars` VALUES ('916', '2', 'Usted no tiene ninguna solicitud de amigo saliente en este momento.', 'user_friends_requests_outgoing,');
INSERT INTO `se_languagevars` VALUES ('917', '2', 'Cancelar la solicitud de amistad', 'user_friends_requests_outgoing,');
INSERT INTO `se_languagevars` VALUES ('918', '2', 'Usted está esperando una confirmación de amistad de %1$s. ¿Está seguro que desea cancelar su solicitud de amistad con %1$s?', 'user_friends_manage,');
INSERT INTO `se_languagevars` VALUES ('919', '2', 'Cancelar la solicitud ', 'user_friends_manage,');
INSERT INTO `se_languagevars` VALUES ('920', '2', 'Ha cancelado con éxito la solicitud de amistad que le hizo a este usuario.', '');
INSERT INTO `se_languagevars` VALUES ('921', '2', 'Para editar los detalles de su amistad con %1$s, complete el formulario que aparece a continuación.', 'user_friends_manage,');
INSERT INTO `se_languagevars` VALUES ('922', '2', 'Editar amistad', 'user_friends_manage,');
INSERT INTO `se_languagevars` VALUES ('923', '2', 'Ha editado los detalles de esta amistad exitosamente.', '');
INSERT INTO `se_languagevars` VALUES ('924', '2', 'Buscar en la red social.', 'search,');
INSERT INTO `se_languagevars` VALUES ('925', '2', 'Buscar:', 'search,');
INSERT INTO `se_languagevars` VALUES ('926', '2', 'Búsqueda avanzada', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('927', '2', 'No se encontraron resultados para \"<b>%1$s</ b>\".', 'search,');
INSERT INTO `se_languagevars` VALUES ('928', '2', '%1$s segundos', 'search,');
INSERT INTO `se_languagevars` VALUES ('929', '2', 'Actualmente en línea', 'search,');
INSERT INTO `se_languagevars` VALUES ('930', '2', 'Amigos de %1$s ', 'profile,');
INSERT INTO `se_languagevars` VALUES ('931', '2', 'Las siguientes personas se encuentran en la lista como amigos de %1$s ', '');
INSERT INTO `se_languagevars` VALUES ('932', '2', '%1$s aún no ha añadido ningún amigo.', '');
INSERT INTO `se_languagevars` VALUES ('933', '2', 'Buscar amigos de %1$s:  ', '');
INSERT INTO `se_languagevars` VALUES ('934', '2', 'Ninguno de los amigos de %1$s coincide con sus criterios de búsqueda.', 'profile,');
INSERT INTO `se_languagevars` VALUES ('935', '2', 'Administrador de preguntas más frecuentes ', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('936', '2', 'La página de  preguntas más frecuentes (FAQ) puede ayudarle a reducir sus responsabilidades de brindar apoyo, ya que les permite a los usuarios encontrar respuestas a sus preguntas mas frecuentes en su área de ayuda.  Añada aquí las  preguntas y respuestas que considere apropiadas para su red social.  Asimismo, asegúrese de organizar sus preguntas en las categorías pertinentes para ayudar a sus usuarios a encontrar respuestas con más facilidad.', 'admin_faq,');
INSERT INTO `se_languagevars` VALUES ('937', '2', 'Añadir una pregunta', 'admin_faq,');
INSERT INTO `se_languagevars` VALUES ('938', '2', 'Respuesta:<br>(HTML OK)', 'admin_faq,');
INSERT INTO `se_languagevars` VALUES ('939', '2', 'Pregunta', 'admin_faq,');
INSERT INTO `se_languagevars` VALUES ('940', '2', 'Promedio de visitas diarias ', 'admin_faq,');
INSERT INTO `se_languagevars` VALUES ('941', '2', 'Creada', 'admin_faq,');
INSERT INTO `se_languagevars` VALUES ('942', '2', 'Actualizada', 'admin_faq,');
INSERT INTO `se_languagevars` VALUES ('943', '2', 'Subir', 'admin_faq,');
INSERT INTO `se_languagevars` VALUES ('944', '2', 'Por favor proporcione un título para esta categoría de preguntas más frecuentes.', 'admin_faq,');
INSERT INTO `se_languagevars` VALUES ('945', '2', 'Por favor, especifique un nombre para esta categoría.', 'admin_faq,');
INSERT INTO `se_languagevars` VALUES ('800001', '2', 'Su cuenta', 'help, admin_faq,');
INSERT INTO `se_languagevars` VALUES ('800003', '2', 'Privacidad', 'help, admin_faq,');
INSERT INTO `se_languagevars` VALUES ('946', '2', 'Pregunta:', 'admin_faq,');
INSERT INTO `se_languagevars` VALUES ('947', '2', 'Por favor, especifique una pregunta.', 'admin_faq,');
INSERT INTO `se_languagevars` VALUES ('948', '2', 'Por favor, proporcione alguna información sobre esta pregunta frecuente.', 'admin_faq,');
INSERT INTO `se_languagevars` VALUES ('800004', '2', 'No puedo conectarme, o he olvidado mi nombre de usuario o contraseña.', 'help, admin_faq,');
INSERT INTO `se_languagevars` VALUES ('800005', '2', 'Si no puede conectarse, asegúrese de que su tecla \"Bloqueo de mayúsculas\" (caps lock) está desactivada.  Su nombre de usuario y contraseña distinguen entre mayúsculas y minúsculas. Si aún así no puede iniciar sesión, puede solicitar que se <a href=\'lostpass.php\'>restablezca su contraseña</a> o <a href=\'help_contact.php\'>ponerse en contacto con nosotros</a>.', 'help, admin_faq,');
INSERT INTO `se_languagevars` VALUES ('1097', '2', 'Sugerencias:', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('949', '2', '%1$d visitas en total', 'admin_faq,');
INSERT INTO `se_languagevars` VALUES ('950', '2', '¿Desea restablecer las visitas para esta pregunta?', 'admin_faq,');
INSERT INTO `se_languagevars` VALUES ('1012', '2', '¿Está seguro que desea eliminar este usuario? ', 'admin_viewusers,');
INSERT INTO `se_languagevars` VALUES ('951', '2', 'Editar categoría ', 'admin_faq,');
INSERT INTO `se_languagevars` VALUES ('954', '2', 'Editar pregunta', 'admin_faq,');
INSERT INTO `se_languagevars` VALUES ('952', '2', '¿Desea eliminar la categoría?', 'admin_faq,');
INSERT INTO `se_languagevars` VALUES ('953', '2', '¿Está seguro que desea eliminar esta categoría?  NOTA: Todas las preguntas dentro de esta categoría ¡también se eliminarán!', 'admin_faq,');
INSERT INTO `se_languagevars` VALUES ('955', '2', '¿Desea eliminar la pregunta?', 'admin_faq,');
INSERT INTO `se_languagevars` VALUES ('800007', '2', 'Si está completamente seguro de que quiere eliminar su cuenta, puede hacerlo <a href=\'user_account_delete.php\'>aquí</a>.  Por favor, tenga en cuenta que su cuenta será eliminada  definitivamente y será ¡irrecuperable!', 'help, admin_faq,');
INSERT INTO `se_languagevars` VALUES ('800006', '2', '¿Cómo puedo eliminar mi cuenta?', 'help, admin_faq,');
INSERT INTO `se_languagevars` VALUES ('956', '2', '¿Está seguro que desea eliminar esta pregunta? ', 'admin_faq,');
INSERT INTO `se_languagevars` VALUES ('800008', '2', '¿Cómo puedo actualizar mi perfil?', 'help, admin_faq,');
INSERT INTO `se_languagevars` VALUES ('800009', '2', 'Para actualizar su perfil, deberá visitar la página <a href=\'user_editprofile.php\'>Editar perfil</a>. Puede recorrer las diferentes partes de su perfil haciendo clic en las pestañas en la parte superior de la página.', 'help, admin_faq,');
INSERT INTO `se_languagevars` VALUES ('800010', '2', '¿Cómo puedo actualizar mi dirección de correo electrónico?', 'help, admin_faq,');
INSERT INTO `se_languagevars` VALUES ('800011', '2', 'Puede actualizar su dirección de correo electrónico en la página <a href=\'user_account.php\'>Mi cuenta</a>.', 'help, admin_faq,');
INSERT INTO `se_languagevars` VALUES ('800012', '2', '¿Cómo puedo informar de un error u otro problema en el sitio?', 'help, admin_faq,');
INSERT INTO `se_languagevars` VALUES ('800013', '2', 'Para informar sobre un error o un problema en el sitio Web, puede ponerse en contacto con nosotros <a href=\'help_contact.php\'>aquí</a>.', 'help, admin_faq,');
INSERT INTO `se_languagevars` VALUES ('800014', '2', '¿Qué puedo hacer con alguien que me está molestando?', 'help, admin_faq,');
INSERT INTO `se_languagevars` VALUES ('800015', '2', 'Si alguien lo está molestando o acosando, el bloqueo es, por lo general, la mejor solución.  Visite la página <a href=\'user_account.php\'>  Configuración de la cuenta</a> para aprender cómo bloquear a las personas.  Si alguien continúa acosándolo, a pesar de sus esfuerzos, puede denunciarlo <a href=\'help_contact.php\'>aquí</a>.', 'help, admin_faq,');
INSERT INTO `se_languagevars` VALUES ('800016', '2', '¿Cómo puedo denunciar el spam u otro contenido inapropiado?', 'help, admin_faq,');
INSERT INTO `se_languagevars` VALUES ('800017', '2', 'Puede denunciar el spam, la pornografía, o cualquier otro contenido inapropiado <a href=\'help_contact.php\'>aquí</a>, o haciendo clic en el enlace \"Denunciar\" de la página que contiene el contenido que desea denunciar.', 'help, admin_faq,');
INSERT INTO `se_languagevars` VALUES ('800018', '2', '¿Es mi información confidencial?', 'help, admin_faq,');
INSERT INTO `se_languagevars` VALUES ('800019', '2', 'Absolutamente. No compartimos ninguna información de identificación personal sobre usted u otras terceras partes.', 'help, admin_faq,');
INSERT INTO `se_languagevars` VALUES ('800020', '2', '¿Cómo puedo hacer para que mi perfil sea privado?', 'help, admin_faq,');
INSERT INTO `se_languagevars` VALUES ('800021', '2', 'Si el administrador lo ha permitido, puede hacer que su perfil sea privado, visitando la página <a href=\'user_account_privacy\'.php\'>Privacidad de la cuenta</a>.', 'help, admin_faq,');
INSERT INTO `se_languagevars` VALUES ('800022', '2', '¿Cómo puedo impedir que los usuarios se pongan en contacto conmigo?', 'help, admin_faq,');
INSERT INTO `se_languagevars` VALUES ('800023', '2', 'Puede bloquear personas agregando sus nombres de usuario a su lista de usuarios bloqueados. Visite la página <a href=\'user_account.php\'>Configuración de la cuenta</a> para obtener más información acerca de cómo bloquear a las personas. ', 'help, admin_faq,');
INSERT INTO `se_languagevars` VALUES ('957', '2', 'Preguntas más frecuentes (FAQ)', 'help,');
INSERT INTO `se_languagevars` VALUES ('958', '2', 'Si necesita ayuda, seguramente encontrará la respuesta a su pregunta en esta página.', 'help,');
INSERT INTO `se_languagevars` VALUES ('959', '2', 'Notificaciones por correo electrónico', 'user_account,');
INSERT INTO `se_languagevars` VALUES ('960', '2', '¿Sobre cuál de estos asuntos desea recibir notificaciones por correo electrónico?', 'user_account,');
INSERT INTO `se_languagevars` VALUES ('961', '2', 'Cuando recibo un mensaje.', 'user_account,');
INSERT INTO `se_languagevars` VALUES ('962', '2', 'Cuando recibo una solicitud de amigo.', 'user_account,');
INSERT INTO `se_languagevars` VALUES ('963', '2', 'Cuando recibo un comentario en el perfil.', 'user_account,');
INSERT INTO `se_languagevars` VALUES ('964', '2', 'Edite el estilo de su perfil aquí.', 'user_editprofile_style,');
INSERT INTO `se_languagevars` VALUES ('965', '2', 'Estilo del perfil  ', 'user_editprofile_style,');
INSERT INTO `se_languagevars` VALUES ('966', '2', 'Añada su propio código CSS a continuación, para dar a su perfil un aspecto más personalizado. <br>Los contenidos del área de texto a continuación se publicarán entre las etiquetas &lt;estilo&gt; de su perfil.', 'user_editprofile_style,');
INSERT INTO `se_languagevars` VALUES ('967', '2', 'Privacidad del  perfil', 'user_account_privacy,');
INSERT INTO `se_languagevars` VALUES ('968', '2', '¿Quién puede ver su perfil?', 'user_account_privacy,');
INSERT INTO `se_languagevars` VALUES ('969', '2', 'Privacidad de los comentarios', 'user_account_privacy,');
INSERT INTO `se_languagevars` VALUES ('970', '2', '¿Quién puede publicar comentarios en su perfil?', 'user_account_privacy,');
INSERT INTO `se_languagevars` VALUES ('971', '2', 'Privacidad de la búsqueda', 'user_account_privacy,');
INSERT INTO `se_languagevars` VALUES ('972', '2', '¿Desea ser incluido en los resultados de búsqueda? <br>Tenga en cuenta que esta configuración de privacidad se aplica también a los usuarios que aparecen en la página de inicio (como por ejemplo “El usuario más popular”).', 'user_account_privacy,');
INSERT INTO `se_languagevars` VALUES ('973', '2', 'Sí, incluir mi perfil en los resultados de búsqueda.', 'user_account_privacy,');
INSERT INTO `se_languagevars` VALUES ('974', '2', 'No, no incluir mi perfil en los resultados de búsqueda.', 'user_account_privacy,');
INSERT INTO `se_languagevars` VALUES ('750001', '2', '%1$d Solicitud(es) de amigo ', 'user_report, user_home, user_friends_requests, user_friends_manage, user_account_privacy, user_account_pass, user_account_delete, user_account, search, profile, network,');
INSERT INTO `se_languagevars` VALUES ('850011', '2', 'Red social – Contraseña perdida', 'lostpass, admin_emails,');
INSERT INTO `se_languagevars` VALUES ('850012', '2', 'Hola %1$s,<br><br>ha solicitado restablecer su contraseña porque ha olvidado la misma.  Si no ha solicitado esto, por favor, haga caso omiso de este mensaje. El plazo vencerá en 24 hours. Para restablecer su contraseña, por favor haga clic en el siguiente enlace: <br><br>%3$s<br><br>Saludos cordiales,<br> La Administración de la Red Social', 'lostpass, admin_emails,');
INSERT INTO `se_languagevars` VALUES ('850013', '2', '%2$s lo ha añadido como su amigo.', 'user_friends_manage, admin_emails,');
INSERT INTO `se_languagevars` VALUES ('850014', '2', 'Hola %1$s,<br><br>%2$s te ha añadido como su amigo. Por favor, haga clic en el siguiente enlace para acceder a su cuenta y confirmar esta solicitud de amistad:<br><br>%3$s<br><br>Saludos cordiales,<br>La Administración de la Red Social ', 'user_friends_manage, admin_emails,');
INSERT INTO `se_languagevars` VALUES ('850015', '2', 'Ha recibido un nuevo mensaje.', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('850016', '2', 'Hola %1$s,<br><br>acaba de recibir un nuevo mensaje de %2$s. Por favor, haga clic en el siguiente enlace para acceder a su cuenta y verlo:<br><br>%3$s<br><br>Saludos cordiales,<br>La Administración de la Red Social ', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('750002', '2', '%1$d  nuevos mensajes', '');
INSERT INTO `se_languagevars` VALUES ('750003', '2', '%1$d nuevo(s) comentario(s) en el perfil', '');
INSERT INTO `se_languagevars` VALUES ('850001', '2', '¡Ha recibido una invitación para unirse a nuestra red social!', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('850002', '2', 'Hola, <br><br>%1$s le ha invitado a unirse a nuestra red social. Para unirse a nosotros, por favor siga el enlace que aparece a continuación y escriba su código de invitación. <br><br>%5$s<br><br>Código de invitación: %4$s<br><br>Saludos cordiales,<br>La Administración de la Red Social<br><br>----------------------------------------<br>%3$s', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('850003', '2', 'Ha recibido una invitación para unirse a nuestra red social.', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('850004', '2', 'Hola, <br><br>%1$s le ha invitado a unirse a nuestra red social. Para unirse a nosotros, por favor siga el enlace que aparece a continuación:<br>%4$s<br><br>Saludos cordiales,<br>La Administración de la Red Social<br><br>----------------------------------------<br>%3$s', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('850005', '2', 'Red social – Verificación de correo electrónico', 'signup, admin_emails,');
INSERT INTO `se_languagevars` VALUES ('978', '2', 'Habilite esta configuración si desea que sus usuarios elijan entre las muestras CSS. Para añadir más muestras, basta con insertar una fila en la tabla de base de datos se_stylesamples que contiene el código CSS exacto que deberá introducirse en el área de texto del “Estilo de perfil” y,  opcionalmente, la ruta hacia una miniatura para la plantilla.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('976', '2', '%1$s y %2$d invitado(s)', 'user_home, home, admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('977', '2', '%1$d  invitado(s) ', 'user_home, home, admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('975', '2', '[ Actualizar ]', 'signup,');
INSERT INTO `se_languagevars` VALUES ('982', '2', 'Sí, los usuarios pueden elegir entre las muestras CSS proporcionadas.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('983', '2', 'No, los usuarios no pueden elegir entre las muestras CSS proporcionadas.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('984', '2', '¿Está el sitio en línea?', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('985', '2', 'Utilice esta función cuando desee poner su sitio fuera de servicio para realizarle mantenimiento o actualizaciones.  Cuando los usuarios intenten acceder al sitio, se visualizará un mensaje haciéndoles saber que el sitio se encuentra en mantenimiento de rutina y estará disponible pronto.  Si está conectado como administrador, podrá navegar por el sitio sin problemas.', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('979', '2', 'Diseños de perfil de muestra ', 'user_editprofile_style,');
INSERT INTO `se_languagevars` VALUES ('980', '2', 'Haga clic en uno de los diseños de muestra a continuación para seleccionar esa opción para su perfil.<br><b>NOTA:</b> Si elige uno de los diseños de muestra presentados a continuación, su actual diseño se eliminará.', 'user_editprofile_style,');
INSERT INTO `se_languagevars` VALUES ('981', '2', '¿Está seguro que desea sustituir su estilo de perfil por esta plantilla?', 'user_editprofile_style,');
INSERT INTO `se_languagevars` VALUES ('986', '2', 'Sí, el sitio está en línea.', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('987', '2', 'No, el sitio está fuera de servicio por mantenimiento.', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('988', '2', 'El sitio está actualmente fuera de servicio por mantenimiento. ¡Vuelva a intentar en breve!', 'home,');
INSERT INTO `se_languagevars` VALUES ('989', '2', 'Casillas', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('990', '2', 'Tipo de visualización:', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('991', '2', 'Visualizado, vinculado al perfil', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('992', '2', 'Visualizado en el perfil', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('993', '2', 'No visualizado en el perfil', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('994', '2', 'Atributo especial:', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('995', '2', 'Fecha de cumpleaños (Campo de la fecha únicamente)', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('996', '2', 'En esta página se muestran todos los usuarios que integran su red social. Para obtener más información sobre un usuario específico, haga clic en el enlace \"editar\" en su fila.  Haga clic en el enlace \"iniciar sesión\" para conectarse como un usuario específico. Use los campos del filtro para encontrar los usuarios específicos  sobre la base de sus criterios.  Para ver todos los usuarios en su sistema, deje todos los campos del filtro en blanco.', 'admin_viewusers,');
INSERT INTO `se_languagevars` VALUES ('997', '2', 'Nivel de usuario', 'admin_viewusers,');
INSERT INTO `se_languagevars` VALUES ('998', '2', 'Subred', 'admin_viewusers,');
INSERT INTO `se_languagevars` VALUES ('999', '2', 'Habilitado', 'admin_viewusers_edit, admin_viewusers,');
INSERT INTO `se_languagevars` VALUES ('1000', '2', 'Sí', 'admin_viewusers,');
INSERT INTO `se_languagevars` VALUES ('1001', '2', 'No', 'admin_viewusers,');
INSERT INTO `se_languagevars` VALUES ('1002', '2', 'Filtro', 'admin_viewusers, admin_viewreports,');
INSERT INTO `se_languagevars` VALUES ('1003', '2', 'No se encontraron usuarios.', 'admin_viewusers,');
INSERT INTO `se_languagevars` VALUES ('1004', '2', 'Se encontraron %1$d usuarios', 'admin_viewusers,');
INSERT INTO `se_languagevars` VALUES ('1005', '2', 'Página:', 'admin_viewusers, admin_viewreports,');
INSERT INTO `se_languagevars` VALUES ('1006', '2', 'Verificada', 'admin_viewusers,');
INSERT INTO `se_languagevars` VALUES ('1007', '2', 'Fecha de registro', 'admin_viewusers,');
INSERT INTO `se_languagevars` VALUES ('1008', '2', 'No verificada', 'admin_viewusers_edit, admin_viewusers,');
INSERT INTO `se_languagevars` VALUES ('1009', '2', 'Inicio de sesión', 'admin_viewusers,');
INSERT INTO `se_languagevars` VALUES ('1010', '2', 'El sitio está en línea.', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('1011', '2', 'El sitio está fuera de servicio por el momento.', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('1013', '2', 'Eliminar usuario', 'admin_viewusers,');
INSERT INTO `se_languagevars` VALUES ('1014', '2', 'Tenga en cuenta que si cambia su tipo de cuenta, puede que tenga que volver a introducir la información de su perfil.', 'user_account,');
INSERT INTO `se_languagevars` VALUES ('1015', '2', 'Su dirección de correo electrónico', 'signup_verify,');
INSERT INTO `se_languagevars` VALUES ('1016', '2', 'Reenviar verificación ', 'signup_verify,');
INSERT INTO `se_languagevars` VALUES ('1072', '2', '%1$d perfiles', 'search,');
INSERT INTO `se_languagevars` VALUES ('1018', '2', 'ID de la frase:', 'admin_language_edit,');
INSERT INTO `se_languagevars` VALUES ('1019', '2', '%1$s nueva(s) actualización(es)', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('1017', '2', 'Prosiga para iniciar sesión…', 'signup_verify,');
INSERT INTO `se_languagevars` VALUES ('1020', '2', 'Ver amigos comunes', 'profile,');
INSERT INTO `se_languagevars` VALUES ('1021', '2', 'Ver todos', '');
INSERT INTO `se_languagevars` VALUES ('1022', '2', 'Ver todos los amigos', 'profile,');
INSERT INTO `se_languagevars` VALUES ('1023', '2', 'Usted no tiene ningún amigo en común con %1$s. ', 'profile,');
INSERT INTO `se_languagevars` VALUES ('1024', '2', 'Amigos comunes con %1$s', 'profile,');
INSERT INTO `se_languagevars` VALUES ('1025', '2', 'Eliminar comentario', 'profile,');
INSERT INTO `se_languagevars` VALUES ('1026', '2', '¿Está seguro que desea eliminar este comentario? ', 'profile,');
INSERT INTO `se_languagevars` VALUES ('1027', '2', '<b>Note:</b> Esta acción tiene medios (como por ejemplo fotografías) relacionados a esta. Basta con incluir la etiqueta <i>[medios]</i> para mostrarlos.', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('1028', '2', '¡Enhorabuena!  Ha verificado con éxito su dirección de correo electrónico.  Haga clic en el botón a continuación para acceder a su cuenta.', 'signup_verify,');
INSERT INTO `se_languagevars` VALUES ('1029', '2', 'Nombre de pila/1ro Mostrar nombre (Campo del texto únicamente)', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('1030', '2', 'Apellido/2do Mostrar nombre (Campo del texto únicamente)', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('1031', '2', 'Este campo le permite tratar ciertos campos de perfil de manera diferente.  Si designa un campo de fecha con “fecha de cumpleaños\", la edad del usuario aparecerá en su perfil.  Si desea utilizar el nombre de pila o el apellido del usuario como su nombre para mostrar, en lugar de su nombre de usuario, puede crear campos especiales con estas designaciones que se mostrarán en lugar del nombre de usuario del usuario en su perfil. Se aconseja crear sólo un campo por categoría, cada uno con una designación especial, de no ser así pueden obtenerse resultados inesperados. ', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('1032', '2', 'Conversación sobre comentario en el perfil', 'profile,');
INSERT INTO `se_languagevars` VALUES ('1033', '2', 'Conversación entre %1$s y %2$s', '');
INSERT INTO `se_languagevars` VALUES ('1034', '2', 'Etiquetas HTML permitidas: %1$s', 'profile,');
INSERT INTO `se_languagevars` VALUES ('1073', '2', 'Por favor, introduzca al menos una dirección de correo electrónico de un destinatario para su invitación.', '');
INSERT INTO `se_languagevars` VALUES ('1035', '2', 'Si desea hacernos una pregunta directamente a nosotros, por favor envíe su mensaje en el siguiente formulario.', 'help_contact,');
INSERT INTO `se_languagevars` VALUES ('1036', '2', 'Por favor, proporcione un mensaje detallado.', '');
INSERT INTO `se_languagevars` VALUES ('1037', '2', 'Otro usuario ya ha elegido esta dirección de correo electrónico.', '');
INSERT INTO `se_languagevars` VALUES ('1038', '2', 'No hay ningún usuario en el sistema con esa dirección de correo electrónico.  Por favor <a href=\'home.php\'>haga clic aquí</a> para volver a la página de inicio.', '');
INSERT INTO `se_languagevars` VALUES ('1039', '2', 'El enlace que ha pulsado no es válido o ha caducado.  <a href=\'signup_verify.php?task=resend\'>haga clic aquí</a> para reenviar el mensaje de verificación.', 'signup_verify,');
INSERT INTO `se_languagevars` VALUES ('1040', '2', 'Su mensaje ha sido recibido. Le ayudaremos lo antes posible.', 'help_contact,');
INSERT INTO `se_languagevars` VALUES ('1041', '2', '¡Enhorabuena!  Ha verificado su dirección de correo electrónico y su red se ha cambiado de %1$s a %2$s. Haga clic en el botón de abajo para acceder a su cuenta.', '');
INSERT INTO `se_languagevars` VALUES ('1042', '2', 'Se ha enviado un nuevo mensaje de verificación a la dirección de correo electrónico que nos ha proporcionado. Por favor siga el enlace que aparece en el mensaje para verificar su cuenta.', '');
INSERT INTO `se_languagevars` VALUES ('1043', '2', 'Para que se le reenvíe la verificación de correo electrónico, introduzca su correo electrónico en el campo que aparece a continuación.  Si ha llegado a esta página por error, <a href=\'home.php\'>haga clic aquí</a> para volver a la página de inicio.', 'signup_verify,');
INSERT INTO `se_languagevars` VALUES ('1044', '2', 'La dirección de correo electrónico que nos ha proporcionado ya ha sido verificada. Si ha olvidado su contraseña, por favor <a href=\'lostpass.php\'>haga clic aquí</a>para que le sea reenviada.', 'signup_verify,');
INSERT INTO `se_languagevars` VALUES ('1045', '2', 'Verificación de dirección de correo electrónico:', 'signup_verify,');
INSERT INTO `se_languagevars` VALUES ('1046', '2', 'Por favor, proporcione su nombre.', '');
INSERT INTO `se_languagevars` VALUES ('1047', '2', '¿Desea permitir a sus usuarios hacerse invisibles?', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('1048', '2', 'Habilite esta función si desea permitir a los usuarios hacerse \"invisibles\" (es decir, no aparecer en la lista de usuarios en línea aunque en realidad lo estén).', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('1049', '2', '¿Desea permitir a los usuarios ver quién visitó sus perfiles?', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('1050', '2', 'Si habilita esta función, los usuarios podrán optar por ver los usuarios que han visitado su perfil.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('1051', '2', 'Sí, permitir a los usuarios hacerse invisibles.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('1052', '2', 'No, no permitir a los usuarios hacerse invisibles.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('1053', '2', 'Sí, permitir a los usuarios ver quién visitó sus perfiles.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('1054', '2', 'No, no permitir a los usuarios ver quién visitó sus perfiles.', 'admin_levels_usersettings,');
INSERT INTO `se_languagevars` VALUES ('1055', '2', 'Privacidad', 'user_account_privacy, user_account_pass, user_account_delete, user_account,');
INSERT INTO `se_languagevars` VALUES ('1056', '2', 'Configuración de la privacidad', 'user_account_privacy,');
INSERT INTO `se_languagevars` VALUES ('1057', '2', 'Modifique la configuración de privacidad general de su cuenta aquí.', 'user_account_privacy,');
INSERT INTO `se_languagevars` VALUES ('1058', '2', 'Hacerse invisible', 'user_account_privacy,');
INSERT INTO `se_languagevars` VALUES ('1059', '2', 'No mostrarme en la lista de “Usuarios en línea”.', 'user_account_privacy,');
INSERT INTO `se_languagevars` VALUES ('1060', '2', 'Mostrar las visitas al perfil', 'user_account_privacy,');
INSERT INTO `se_languagevars` VALUES ('1061', '2', 'Sí, mostrar los usuarios que visitaron mi perfil.', 'user_account_privacy,');
INSERT INTO `se_languagevars` VALUES ('1062', '2', 'Nota: Si elige mostrar los usuarios que visitaron su perfil, otros usuarios podrán hacer un seguimiento para saber si usted visitó sus perfiles. Si no desea que otros usuarios sepan que usted visitó sus perfiles, no habilite esta función. ', 'user_account_privacy,');
INSERT INTO `se_languagevars` VALUES ('1063', '2', 'Ningún usuario ha visitado su perfil aún.', 'user_home,');
INSERT INTO `se_languagevars` VALUES ('1064', '2', '¿Quién visitó mi perfil?', 'user_home,');
INSERT INTO `se_languagevars` VALUES ('1065', '2', '¿Desea permitir a sus usuarios decidir qué acciones desean ver en sus informes de actividades? Si habilita esta función, los usuarios podrán especificar las acciones que desean y no desean ver en sus informes de actividad reciente.', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('1066', '2', 'Sí, permitir a los usuarios especificar qué acciones verán en el informe de actividad.', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('1067', '2', 'No, no permitir a los usuarios especificar qué acciones verán en el informe de actividad.', 'admin_activity,');
INSERT INTO `se_languagevars` VALUES ('1068', '2', 'Preferencias del informe de actividad', 'user_home,');
INSERT INTO `se_languagevars` VALUES ('1069', '2', '¿Qué acciones desea ver en el informe de actividad reciente?', 'user_home,');
INSERT INTO `se_languagevars` VALUES ('1070', '2', 'Preferencias ', 'user_home,');
INSERT INTO `se_languagevars` VALUES ('1071', '2', '[Usuario eliminado]', 'profile,');
INSERT INTO `se_languagevars` VALUES ('1074', '2', 'Invitar a sus amigos', 'invite,');
INSERT INTO `se_languagevars` VALUES ('1075', '2', '¡Invite a sus amigos a participar!  Introduzca hasta 10 direcciones de correo electrónico de sus amigos separadas por comas, en el campo de abajo.', 'invite,');
INSERT INTO `se_languagevars` VALUES ('1076', '2', 'Debe iniciar sesión para invitar a otras personas. ', 'invite,');
INSERT INTO `se_languagevars` VALUES ('1077', '2', 'Le quedan <b>%1$d</b> invitaciones.', 'invite,');
INSERT INTO `se_languagevars` VALUES ('1078', '2', 'Cuando se registran, son inmediatamente añadidos a su lista de amigos.', 'invite,');
INSERT INTO `se_languagevars` VALUES ('1079', '2', 'Para:', 'invite,');
INSERT INTO `se_languagevars` VALUES ('1080', '2', 'Separe las direcciones de correo electrónico (hasta 10) con comas.', 'invite,');
INSERT INTO `se_languagevars` VALUES ('1081', '2', 'Mensaje:', 'invite,');
INSERT INTO `se_languagevars` VALUES ('1082', '2', 'Escriba su mensaje aquí. (opcional)', 'invite,');
INSERT INTO `se_languagevars` VALUES ('1083', '2', 'Buscar miembros que concuerden con %1$s', 'search_advanced,');
INSERT INTO `se_languagevars` VALUES ('1084', '2', 'Encontramos %1$d miembro(s) cuyos perfiles concuerdan con %2$s.', 'search_advanced,');
INSERT INTO `se_languagevars` VALUES ('1085', '2', 'Ningún miembro concuerda con sus criterios de búsqueda.', 'search_advanced,');
INSERT INTO `se_languagevars` VALUES ('1086', '2', 'En línea', 'search_advanced,');
INSERT INTO `se_languagevars` VALUES ('1087', '2', 'Búsqueda avanzada de miembros', 'search_advanced,');
INSERT INTO `se_languagevars` VALUES ('1088', '2', 'Buscar entre nuestros miembros con sus propias palabras clave y criterios de búsqueda.', 'search_advanced,');
INSERT INTO `se_languagevars` VALUES ('1089', '2', 'Criterios de búsqueda', 'search_advanced,');
INSERT INTO `se_languagevars` VALUES ('1090', '2', 'Actualizar resultados', 'search_advanced,');
INSERT INTO `se_languagevars` VALUES ('1091', '2', 'Ordenar resultados por:', 'search_advanced,');
INSERT INTO `se_languagevars` VALUES ('1092', '2', 'Última actualización', 'search_advanced,');
INSERT INTO `se_languagevars` VALUES ('1093', '2', '(DESC)', 'search_advanced,');
INSERT INTO `se_languagevars` VALUES ('1094', '2', '(ASC)', 'search_advanced,');
INSERT INTO `se_languagevars` VALUES ('1095', '2', 'Último inicio de sesión', 'search_advanced,');
INSERT INTO `se_languagevars` VALUES ('1096', '2', 'Último registro', 'search_advanced,');
INSERT INTO `se_languagevars` VALUES ('850010', '2', 'Hola  %1$s,<br><br>Gracias por unirse a nuestra red social. Haga clic en el siguiente enlace e introduzca su información a continuación para iniciar sesión:<br><br>%4$s<br><br>correo electrónico: %2$s<br>Contraseña: %3$s<br><br>Saludos cordiales,<br>La Administración de la Red Social', 'signup_verify, signup, admin_emails,');
INSERT INTO `se_languagevars` VALUES ('850006', '2', 'Hola %1$s,<br><br>Gracias por unirse a nuestra red social. Para verificar su dirección de correo electrónico y proseguir, por favor haga clic en el siguiente enlace:<br>%3$s<br><br>Saludos cordiales,<br>La Administración de la Red Social', 'signup, admin_emails,');
INSERT INTO `se_languagevars` VALUES ('850007', '2', 'Red social – Detalles del inicio de sesión', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('850008', '2', 'Hola %1$s,<br><br>Gracias por unirse a nuestra red social. Haga clic en el siguiente enlace e introduzca su información a continuación para iniciar sesión:<br><br>%4$s<br><br>correo electrónico: %2$s<br>Contraseña: %3$s<br><br>Saludos cordiales,<br>La Administración de la Red Social', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('850009', '2', '¡Bienvenido a Social Network.com! ', 'signup_verify, signup, home, admin_emails,');
INSERT INTO `se_languagevars` VALUES ('850017', '2', 'Nuevo comentario en el perfil', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('850018', '2', 'Hola %1$s,<br><br>%2$s acaba de publicar un nuevo comentario en su perfil . Por favor, haga clic en el siguiente enlace para verlo:<br><br>%3$s<br><br>Saludos cordiales,<br>La Administración de la Red Social ', 'admin_emails,');
INSERT INTO `se_languagevars` VALUES ('1098', '2', 'Añadir nueva sugerencia', '');
INSERT INTO `se_languagevars` VALUES ('1099', '2', 'Si desea que este campo sugiera valores de manera automática a los usuarios cuando están completándolo (como por ejemplo: EE.UU.), añada las sugerencias a continuación, separadas por saltos de línea. Tenga en cuenta que el usuario no tendrá obligación de usar estos valores, estos serán ofrecidos a modo de sugerencia para el usuario mientras está escribiendo.', 'admin_fields,');
INSERT INTO `se_languagevars` VALUES ('500364', '2', 'Información personal', '');
INSERT INTO `se_languagevars` VALUES ('1100', '2', 'En esta página se encuentra el listado de todas las denuncias relacionadas con contenido inapropiado, abuso del sistema, spam, etc.,  que sus usuarios han enviado.  Puede usar el campo de búsqueda para buscar denuncias que contengan una palabra o frase específica. Las denuncias antiguas son eliminadas periódicamente por el sistema.', 'admin_viewreports,');
INSERT INTO `se_languagevars` VALUES ('1101', '2', 'Razón', 'admin_viewreports,');
INSERT INTO `se_languagevars` VALUES ('1102', '2', 'Detalles', 'admin_viewreports,');
INSERT INTO `se_languagevars` VALUES ('1103', '2', 'No se han recibido denuncias.', 'admin_viewreports,');
INSERT INTO `se_languagevars` VALUES ('1104', '2', 'Se encontraron %1$d denuncia(s)', 'admin_viewreports,');
INSERT INTO `se_languagevars` VALUES ('1105', '2', 'Iniciar sesión y ver', 'admin_viewreports,');
INSERT INTO `se_languagevars` VALUES ('1106', '2', 'Detalles', '');
INSERT INTO `se_languagevars` VALUES ('1107', '2', 'Todos los plugins de SocialEngine que ha instalado, aparecerán en esta página. Tenga en cuenta que algunos plugins pueden tener una configuración específica para el nivel de usuario, la cual está disponible en la página <a href=\'admin_levels.php\'>Niveles de usuario</a>.', 'admin_viewplugins,');
INSERT INTO `se_languagevars` VALUES ('1108', '2', 'Actualmente no hay plugins instalados. Visite el <a href=\'http://www.socialengine.net/\' target=\'_blank\'>sitio Web de SocialEngine</a> para ¡añadir plugins a su red social!', 'admin_viewplugins,');
INSERT INTO `se_languagevars` VALUES ('1109', '2', 'Instalar plugins', 'admin_viewplugins,');
INSERT INTO `se_languagevars` VALUES ('1110', '2', 'Advertencia:  Usted todavía no ha eliminado install_%1$s.php. Dejar estos archivos en su servidor es ¡un riesgo para la seguridad!', 'admin_viewplugins,');
INSERT INTO `se_languagevars` VALUES ('1111', '2', 'Instalar actualización', 'admin_viewplugins,');
INSERT INTO `se_languagevars` VALUES ('1112', '2', '¡Actualización disponible!', 'admin_viewplugins,');
INSERT INTO `se_languagevars` VALUES ('1113', '2', 'Actualizado:', 'user_home, profile,');
INSERT INTO `se_languagevars` VALUES ('1114', '2', 'El administrador no ha habilitado ningún campo de búsqueda avanzada.', 'search_advanced,');
INSERT INTO `se_languagevars` VALUES ('500370', '2', 'Nombre de tu Casa', '');
INSERT INTO `se_languagevars` VALUES ('1117', '2', 'MAX', 'search_advanced,');
INSERT INTO `se_languagevars` VALUES ('1116', '2', 'MIN', 'search_advanced,');
INSERT INTO `se_languagevars` VALUES ('1115', '2', '¡Regístrese hoy mismo!', 'home,');
INSERT INTO `se_languagevars` VALUES ('500406', '2', '', '');
INSERT INTO `se_languagevars` VALUES ('1118', '2', 'Desinstalar', 'admin_viewplugins,');
INSERT INTO `se_languagevars` VALUES ('1119', '2', 'Red:', 'profile,');
INSERT INTO `se_languagevars` VALUES ('1120', '2', 'Tipo de cuenta:', 'profile,');
INSERT INTO `se_languagevars` VALUES ('1121', '2', 'Usuario(s) en línea únicamente', 'search_advanced,');
INSERT INTO `se_languagevars` VALUES ('1122', '2', 'Usuarios con fotografías únicamente ', 'search_advanced,');
INSERT INTO `se_languagevars` VALUES ('1123', '2', 'Editar usuario: %1$s', 'admin_viewusers_edit,');
INSERT INTO `se_languagevars` VALUES ('1124', '2', 'Para editar la cuenta de este usuario, realice modificaciones al formulario a continuación.  Si desea impedir que este usuario inicie sesión temporalmente, puede “desactivar” la cuenta del usuario a continuación.', 'admin_viewusers_edit,');
INSERT INTO `se_languagevars` VALUES ('1125', '2', 'Total de amigos', 'admin_viewusers_edit,');
INSERT INTO `se_languagevars` VALUES ('1126', '2', 'Total de accesos', 'admin_viewusers_edit,');
INSERT INTO `se_languagevars` VALUES ('1127', '2', 'Total de mensajes almacenados', 'admin_viewusers_edit,');
INSERT INTO `se_languagevars` VALUES ('1128', '2', 'Total de comentarios realizados', 'admin_viewusers_edit,');
INSERT INTO `se_languagevars` VALUES ('1129', '2', 'Último inicio de sesión:', 'admin_viewusers_edit,');
INSERT INTO `se_languagevars` VALUES ('1130', '2', 'Nunca', 'admin_viewusers_edit,');
INSERT INTO `se_languagevars` VALUES ('1131', '2', 'Reenviar correo electrónico de verificación', 'admin_viewusers_edit,');
INSERT INTO `se_languagevars` VALUES ('1132', '2', 'Verificar manualmente', 'admin_viewusers_edit,');
INSERT INTO `se_languagevars` VALUES ('1133', '2', 'Nombre de usuario:', 'admin_viewusers_edit,');
INSERT INTO `se_languagevars` VALUES ('1134', '2', 'Contraseña:', 'admin_viewusers_edit,');
INSERT INTO `se_languagevars` VALUES ('1135', '2', 'Ingrese únicamente si desea restablecer su contraseña.', 'admin_viewusers_edit,');
INSERT INTO `se_languagevars` VALUES ('1136', '2', '¿Está habilitado?', 'admin_viewusers_edit,');
INSERT INTO `se_languagevars` VALUES ('1137', '2', 'Deshabilitado', 'admin_viewusers_edit,');
INSERT INTO `se_languagevars` VALUES ('1138', '2', 'Nivel de usuario:', 'admin_viewusers_edit,');
INSERT INTO `se_languagevars` VALUES ('1139', '2', 'Invitaciones restantes:', 'admin_viewusers_edit,');
INSERT INTO `se_languagevars` VALUES ('1140', '2', 'Se ha enviado la verificación de correo electrónico.', '');
INSERT INTO `se_languagevars` VALUES ('1141', '2', 'Se ha verificado manualmente el correo electrónico del usuario.', 'admin_viewusers_edit,');
INSERT INTO `se_languagevars` VALUES ('1142', '2', 'El número de invitaciones restantes debe ser entre 0 y 999.', 'admin_viewusers_edit,');
INSERT INTO `se_languagevars` VALUES ('1143', '2', 'Sus cambios han sido guardados y la subred de este usuario se ha modificado de% 1$s a % 2$s.', '');
INSERT INTO `se_languagevars` VALUES ('1144', '2', 'IP de registro:', 'admin_viewusers_edit,');
INSERT INTO `se_languagevars` VALUES ('1145', '2', 'Último IP guardado:', 'admin_viewusers_edit,');
INSERT INTO `se_languagevars` VALUES ('1146', '2', '¿Está <b>REALMENTE</b> seguro que desea eliminar su cuenta? Su cuenta será eliminada <i>permanentemente</i> y ¡no podrá recuperar ningún dato de la misma!', 'user_account_delete,');
INSERT INTO `se_languagevars` VALUES ('1147', '2', 'Código para setlocale', 'admin_language,');
INSERT INTO `se_languagevars` VALUES ('1148', '2', '¿Desea habilitar el nombre de usuario?', 'admin_general,');
INSERT INTO `se_languagevars` VALUES ('1149', '2', 'Por defecto, los nombres de usuario se usan para individualizar a sus usuarios. Si opta por desactivar esta función, sus usuarios no tendrán la opción de introducir un nombre de usuario. En cambio, se usará el ID de usuario. Tenga en cuenta que si decide activar esta función, deberá asegurarse de crear campos de perfil OBLIGATORIOS especiales para mostrar el nombre, de lo contrario se mostrará el ID de los usuarios.  Además, recuerde que si deshabilita los nombres de usuario después de que estos se han registrado, sus nombres de usuario serán <b>eliminados</b> y todos los enlaces con sus contenidos anteriores <b>no funcionarán</b>, ya que los enlaces no tendrán más sus nombres de usuario. Finalmente, <b>se eliminarán toda la actividad reciente y todas las notificaciones</b> si elige desactivar los nombres de usuario después de haberlos habilitado previamente.', 'admin_general,');
INSERT INTO `se_languagevars` VALUES ('1150', '2', 'Sí, los usuarios son identificados únicamente por sus nombres de usuario.', 'admin_general,');
INSERT INTO `se_languagevars` VALUES ('1151', '2', 'No, los nombres de usuario no se usarán en esta red.', 'admin_general,');
INSERT INTO `se_languagevars` VALUES ('1152', '2', 'Mostrar nombre:', 'admin_viewusers,');
INSERT INTO `se_languagevars` VALUES ('1153', '2', 'Solicitar ayuda: %1$s', 'help_contact,');
INSERT INTO `se_languagevars` VALUES ('1154', '2', 'Hola %1$s,<br><br>Ha recibido una solicitud de soporte:<br><br>correo electrónico: %2$s<br>Nombre: %3$s<br>Tema: %4$s<br><br>%5$s', 'help_contact,');
INSERT INTO `se_languagevars` VALUES ('1155', '2', '¿Qué novedades hay en mi red? %1$s?', 'network,');
INSERT INTO `se_languagevars` VALUES ('1156', '2', 'Descripción por defecto de los meta tags de la red social', 'user_report, user_messages_view, user_messages_outbox, user_messages_new, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends_manage, user_friends_block, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile_comments, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('1157', '2', 'Condiciones del servicio: %1$s', 'help_tos,');
INSERT INTO `se_languagevars` VALUES ('1158', '2', 'Perfil de %1$s - %2$s', 'profile,');
INSERT INTO `se_languagevars` VALUES ('1159', '2', 'Tipo', 'admin_language_edit,');
INSERT INTO `se_languagevars` VALUES ('1160', '2', 'Ubicación(es) por defecto', 'admin_language_edit,');
INSERT INTO `se_languagevars` VALUES ('1161', '2', '¿Qué novedades hay?', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('1162', '2', 'Mi red:', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('1163', '2', 'Editar información de perfil', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('1164', '2', 'Cambiar la fotografía del perfil ', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('1165', '2', 'Editar diseño del perfil', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('1166', '2', 'Mis Aplicaciones', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('1167', '2', 'Redactar un mensaje nuevo', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('1168', '2', 'Bandeja de entrada de mensajes ', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('1169', '2', 'Bandeja de salida de mensajes', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('1170', '2', 'Ver a mis amigos', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('1171', '2', 'Solicitudes de amigo entrantes:', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('1172', '2', 'Solicitudes de amigo salientes', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('1173', '2', 'Configuración de la cuenta', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('1174', '2', 'Opciones de privacidad', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('1175', '2', 'Derechos de autor', 'user_messages_view, user_messages_outbox, user_messages, user_home, user_friends_requests_outgoing, user_friends_requests, user_friends, user_editprofile_style, user_editprofile_photo, user_editprofile, user_album, user_account_privacy, user_account_pass, user_account_delete, user_account, signup_verify, signup, search_advanced, search, profile, network, lostpass_reset, lostpass, login, invite, home, help_tos, help_contact, help,');
INSERT INTO `se_languagevars` VALUES ('1176', '2', 'Fechas de cumpleaños de amigos', 'user_home,');
INSERT INTO `se_languagevars` VALUES ('1177', '2', 'Actualizaciones de estado recientes', 'network,');
INSERT INTO `se_languagevars` VALUES ('1178', '2', 'Nadie ha modificado su estado últimamente.', 'network,');
INSERT INTO `se_languagevars` VALUES ('1179', '2', 'Ningún usuario se ha unido a esta red aún.', 'network,');
INSERT INTO `se_languagevars` VALUES ('1180', '2', 'No hay cumpleaños en los próximos días.', 'user_home,');
INSERT INTO `se_languagevars` VALUES ('1181', '2', 'Eliminar este mensaje.', 'user_messages_view,');
INSERT INTO `se_languagevars` VALUES ('1182', '2', '(ordenado por visitas más recientes) ', 'user_home,');
INSERT INTO `se_languagevars` VALUES ('500371', '2', '', '');
INSERT INTO `se_languagevars` VALUES ('500366', '2', 'Band Information', '');
INSERT INTO `se_languagevars` VALUES ('500402', '2', 'Provincia o Departamento', '');
INSERT INTO `se_languagevars` VALUES ('500398', '2', '', '');
INSERT INTO `se_languagevars` VALUES ('500395', '2', '', '');
INSERT INTO `se_languagevars` VALUES ('500393', '2', 'Código Postal', '');
INSERT INTO `se_languagevars` VALUES ('500390', '2', 'Número', '');
INSERT INTO `se_languagevars` VALUES ('500372', '2', '', '');
INSERT INTO `se_languagevars` VALUES ('500362', '2', 'Usuarios estándar ', '');
INSERT INTO `se_languagevars` VALUES ('500363', '2', 'Musicians', '');
INSERT INTO `se_languagevars` VALUES ('750004', '2', 'Cuando recibo una solicitud de amigo', '');
INSERT INTO `se_languagevars` VALUES ('750005', '2', 'Cuando recibo un mensaje', '');
INSERT INTO `se_languagevars` VALUES ('750006', '2', 'Cuando recibo un comentario en el perfil', '');
INSERT INTO `se_languagevars` VALUES ('1183', '2', '¿Tiene problemas para cargar archivos?  Haga clic aquí para utilizar el cargador de archivos simple.', '');
INSERT INTO `se_languagevars` VALUES ('1184', '2', 'Archivo 1:', '');
INSERT INTO `se_languagevars` VALUES ('1185', '2', 'Archivo 2:', '');
INSERT INTO `se_languagevars` VALUES ('1186', '2', 'Archivo 3:', '');
INSERT INTO `se_languagevars` VALUES ('1187', '2', 'Archivo 4:', '');
INSERT INTO `se_languagevars` VALUES ('1188', '2', 'Archivo 5:', '');
INSERT INTO `se_languagevars` VALUES ('1189', '2', 'Subir archivos seleccionados ', '');
INSERT INTO `se_languagevars` VALUES ('1190', '2', 'Cargando ', '');
INSERT INTO `se_languagevars` VALUES ('1191', '2', 'añade archivos', '');
INSERT INTO `se_languagevars` VALUES ('1192', '2', 'Progreso general ', '');
INSERT INTO `se_languagevars` VALUES ('1193', '2', 'Progreso del archivo ', '');
INSERT INTO `se_languagevars` VALUES ('1194', '2', 'Por favor, especifique un archivo para cargar, haciendo clic en el botón  del enlace “Añadir archivos”', '');
INSERT INTO `se_languagevars` VALUES ('1195', '2', 'Cargar con %1$s/2. Tiempo restante:  ~%2$s', '');
INSERT INTO `se_languagevars` VALUES ('1196', '2', '¡Carga completa! ', '');
INSERT INTO `se_languagevars` VALUES ('1197', '2', 'Nuevas actualizaciones ', '');
INSERT INTO `se_languagevars` VALUES ('1198', '2', 'Nuevas actualizaciones ', '');
INSERT INTO `se_languagevars` VALUES ('1199', '2', 'Tiene %1$s nueva(s) actualización(es)', '');
INSERT INTO `se_languagevars` VALUES ('1200', '2', 'Habilitar plugin ', '');
INSERT INTO `se_languagevars` VALUES ('1201', '2', 'Deshabilitar Plugin ', '');
INSERT INTO `se_languagevars` VALUES ('1202', '2', 'Subcategorías', '');
INSERT INTO `se_languagevars` VALUES ('1203', '2', 'Añadir subcategoría  ', '');
INSERT INTO `se_languagevars` VALUES ('1204', '2', 'Está viendo  #%1$d de %2$d <a href=\'%3$s\'>fotografías de %4$s</a> &nbsp;|&nbsp; <a href=\'%5$s\'>Volver al perfil de %4$s</a>', '');
INSERT INTO `se_languagevars` VALUES ('1205', '2', 'Fotografías de <a href=\'%1$s\'>%2$s</a>', '');
INSERT INTO `se_languagevars` VALUES ('1206', '2', 'Descargar este archivo ', '');
INSERT INTO `se_languagevars` VALUES ('1207', '2', 'Está viendo  #%1$d de %2$d <a href=\'%3$s\'>fotografías de %4$s</a> &nbsp;|&nbsp; <a href=\'%5$s\'>Volver al perfil de %4$s</a>', '');
INSERT INTO `se_languagevars` VALUES ('1208', '2', 'Último ', '');
INSERT INTO `se_languagevars` VALUES ('1209', '2', 'Siguiente ', '');
INSERT INTO `se_languagevars` VALUES ('1210', '2', 'Condiciones del servicio', '');
INSERT INTO `se_languagevars` VALUES ('1211', '2', 'Configuración del plugin ', '');
INSERT INTO `se_languagevars` VALUES ('1212', '2', 'Añadir etiqueta ', '');
INSERT INTO `se_languagevars` VALUES ('1213', '2', 'Escriba una etiqueta o seleccione un nombre de la lista:', '');
INSERT INTO `se_languagevars` VALUES ('1214', '2', '(yo)', '');
INSERT INTO `se_languagevars` VALUES ('1215', '2', 'Guardar', '');
INSERT INTO `se_languagevars` VALUES ('1216', '2', 'Desde <a href=\'%1$s\'>%2$s</a>por <a href=\'%3$s\'>%4$s</a>', '');
INSERT INTO `se_languagevars` VALUES ('1217', '2', 'Desde <a href=\'%1$s\'>%2$s</a>', '');
INSERT INTO `se_languagevars` VALUES ('1218', '2', 'En esta fotografía: ', '');
INSERT INTO `se_languagevars` VALUES ('1219', '2', 'Cargado %1$s', '');
INSERT INTO `se_languagevars` VALUES ('1220', '2', 'Compartir esto', '');
INSERT INTO `se_languagevars` VALUES ('1221', '2', 'Denunciar contenido inapropiado ', '');
INSERT INTO `se_languagevars` VALUES ('1222', '2', 'Para compartir esta fotografía o incrustarla en otra página Web, por favor, copie y pegue el código de su elección: ', '');
INSERT INTO `se_languagevars` VALUES ('1223', '2', 'Enlace directo ', '');
INSERT INTO `se_languagevars` VALUES ('1224', '2', 'HTML - Imagen incrustada', '');
INSERT INTO `se_languagevars` VALUES ('1225', '2', 'HTML - Enlace del texto ', '');
INSERT INTO `se_languagevars` VALUES ('1226', '2', 'Código UBB (para foros) ', '');
INSERT INTO `se_languagevars` VALUES ('1227', '2', 'Cerrar ventana', '');
INSERT INTO `se_languagevars` VALUES ('1228', '2', 'Quitar la etiqueta', '');
INSERT INTO `se_languagevars` VALUES ('1229', '2', 'The file \"%2$s\" exceeds the max allowed file size: %1$s bytes', 'user_upload');
INSERT INTO `se_languagevars` VALUES ('1230', '2', 'You may not upload more than %1$s file(s) at a time.', 'user_upload');
INSERT INTO `se_languagevars` VALUES ('1231', '2', 'Unknown Error', 'user_upload');
INSERT INTO `se_languagevars` VALUES ('1232', '2', 'The extension of the file \"%2$s\" is not in the list of allowed extensions: %1$s', 'user_upload');
INSERT INTO `se_languagevars` VALUES ('1233', '2', 'Require users to enter validation code when logging in?', 'admin_banning');
INSERT INTO `se_languagevars` VALUES ('1234', '2', 'If you have selected Yes, an image containing a random sequence of 6 numbers will be shown to users on the \"login\" page. Users will be required to enter these numbers into the Verification Code field in order to login. This feature helps prevent users from trying to spam the login form. For this feature to work properly, your server must have the GD Libraries (2.0 or higher) installed and configured to work with PHP. If you are seeing errors, try turning this off.', 'admin_banning');
INSERT INTO `se_languagevars` VALUES ('1235', '2', 'Yes, enable validation code for logging in.', 'admin_banning');
INSERT INTO `se_languagevars` VALUES ('1236', '2', 'No, disable validation code for logging in.', 'admin_banning');
INSERT INTO `se_languagevars` VALUES ('1237', '2', 'If \"no\" is selected in the setting directly above, a Verification Code will be displayed to the user only after a certain number of failed logins. You can set this to 0 to never display a code.', 'admin_banning');
INSERT INTO `se_languagevars` VALUES ('1238', '2', 'failed logins', 'admin_banning');
INSERT INTO `se_languagevars` VALUES ('1239', '2', 'Require users to enter validation code when using the contact form?', 'admin_banning');
INSERT INTO `se_languagevars` VALUES ('1240', '2', 'If you have selected Yes, an image containing a random sequence of 6 numbers will be shown to users on the \"contact\" page. Users will be required to enter these numbers into the Verification Code field in order to contact you. This feature helps prevent users from trying to spam the contact form. For this feature to work properly, your server must have the GD Libraries (2.0 or higher) installed and configured to work with PHP. If you are seeing errors, try turning this off.', 'admin_banning');
INSERT INTO `se_languagevars` VALUES ('1241', '2', 'Yes, enable validation code for the contact form.', 'admin_banning');
INSERT INTO `se_languagevars` VALUES ('1242', '2', 'No, disable validation code for the contact form.', 'admin_banning');
INSERT INTO `se_languagevars` VALUES ('1243', '2', 'Caching', 'admin_cache, admin_header');
INSERT INTO `se_languagevars` VALUES ('1244', '2', 'Sessions', 'admin_header, admin_session');
INSERT INTO `se_languagevars` VALUES ('1245', '2', 'For very large social networks, it may be necessary to enable caching to improve performance. If there is a noticable decrease in performance on your social network, consider enabling caching below (or upgrading your hardware). Caching takes some load off the database server by storing commonly retrieved data in temporary files (file-based caching) or memcached (memory-based caching). If you are not familiar with caching, we don\'t recommend that you change any of these settings.', 'admin_header, admin_cache');
INSERT INTO `se_languagevars` VALUES ('1246', '2', 'Once you have set up caching, you can generate a configuration file to put in your include folder. This will allow the cache to initialize earlier and will be able to cache the site settings, which contain the cache connection info.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1247', '2', 'Click <a href=\"%1$s\" onclick=\"%2$s\">here</a> to generate.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1248', '2', 'Server', 'admin_cache, admin_session');
INSERT INTO `se_languagevars` VALUES ('1249', '2', 'General Cache Settings', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1250', '2', 'Enable caching?', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1251', '2', 'Enabling caching will decrease the CPU usage of your database server (resulting in a decrease of page load times). While some non-critical data may appear slightly out of date, this will usually not be noticable to users. For example, some of the general site statistics on your homepage may take longer to update. This will not be noticable if your social network is already large and populated with a lot of data.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1252', '2', 'Yes, enable caching.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1253', '2', 'No, do not enable caching.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1254', '2', 'What kind of caching do you want to enable by default?', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1255', '2', 'If you have enabled caching above, please select the type of caching that you want to use. Memcache caching (if available) will use memory (RAM) which is not as abundant as disk space, however it will be faster than file-based caching when performing read/write operations.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1256', '2', 'Note to developers: If you are writing custom code, it is possible to override the type of caching used. If you choose not to do this, the system will use this default setting.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1257', '2', 'File-based', 'admin_cache, admin_session');
INSERT INTO `se_languagevars` VALUES ('1258', '2', 'Memcache', 'admin_cache, admin_session');
INSERT INTO `se_languagevars` VALUES ('1259', '2', 'Default cache lifetime.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1260', '2', 'This determines how long the system will keep cached data before reloading it from the database server. A shorter cache lifetime causes greater database server CPU usage, however the data will be more current. We recommend starting off with 60-120 seconds.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1261', '2', 'Note to developers: This will only affect places that do not specify a lifetime. To modify those, you will have to adjust the settings in that plugin or module, or change the code manually.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1262', '2', 'seconds', 'admin_cache, admin_session');
INSERT INTO `se_languagevars` VALUES ('1263', '2', 'File-based Cache Settings', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1264', '2', 'The settings below are applicable if you have selected file-based caching above.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1265', '2', 'Successfully initialized. The cache folder exists and is writable.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1266', '2', 'The file caching was unable to initialize. The folder might not be writable - please set it to chmod 777.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1267', '2', 'Temporary directory location.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1268', '2', 'This is where the temporary files containing the cached data are stored. Folder must be writable (chmod 777). This should be a path relative to the base directory where SocialEngine is installed.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1269', '2', 'File locking.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1270', '2', 'This is used to prevent two Apache processes from trying to write to the same file at the same time. Some operating systems may not support file locking.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1271', '2', 'Enable file locking?', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1272', '2', 'Memcache-based Cache Settings', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1273', '2', 'The settings below are applicable if you have selected Memcache-based caching above. In this case, data is stored in memory using <a target=\"_blank\" href=\"http://www.danga.com/memcached/\">memcached</a> and its <a target=\"_blank\" href=\"http://www.php.net/memcache\">PHP extension</a>. You must set up a memcached server in order to use this option.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1274', '2', 'Successfully initialized. The Memcache extension was detected.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1275', '2', 'The Memcache extension was not detected or we were unable to connect to the memcached server.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1276', '2', 'Use compression?', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1277', '2', 'Compression will decrease the amount of memory used, however will increase processor usage.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1278', '2', 'Enable compression', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1279', '2', 'Memcached server configuration.', 'admin_cache');
INSERT INTO `se_languagevars` VALUES ('1280', '2', 'Click <a href=\"%1$s\" onclick=\"%2$s\">here</a> to add an additional server.', 'admin_cache, admin_session');
INSERT INTO `se_languagevars` VALUES ('1281', '2', 'Host', 'admin_cache, admin_session');
INSERT INTO `se_languagevars` VALUES ('1282', '2', 'Port', 'admin_cache, admin_session');
INSERT INTO `se_languagevars` VALUES ('1283', '2', 'export', 'admin_language');
INSERT INTO `se_languagevars` VALUES ('1284', '2', 'Import Pack from File', 'admin_language');
INSERT INTO `se_languagevars` VALUES ('1285', '2', 'Language Import Tool', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1286', '2', 'Here you can import a language pack from an exported file. If generated by SocialEngine, the file will contain all of the necessary info to create a new language pack.', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1287', '2', 'Updated:', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1288', '2', 'Inserted:', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1289', '2', 'Skipped:', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1290', '2', 'Failed:', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1291', '2', 'Import Options', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1292', '2', 'Please select an existing language or \"New Language\". If you select \"New Language\", the imported file will be used to create a new language pack.', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1293', '2', 'New Language', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1294', '2', 'You are about to replace an existing language pack with the one you are importing. Any new language phrases in the imported file will be added automatically. How do you want to handle changes to existing language phrases?', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1295', '2', 'Replace all phrases with those in the imported file.', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1296', '2', 'Do not replace any existing phrases, just add new ones.', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1297', '2', 'Please select a language file to import.', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1298', '2', 'Import', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1299', '2', 'SocialEngine uses sessions to authenticate users and keep them logged-in. The settings below only need to be changed if your users are having trouble logging in (e.g. if your server does not allow native sessions) or if you want to improve system performance by enabling Memcache sessions. If you are not familiar with sessions, we do not recommend that you change any of these settings.', 'admin_session');
INSERT INTO `se_languagevars` VALUES ('1300', '2', 'General Session Settings', 'admin_session');
INSERT INTO `se_languagevars` VALUES ('1301', '2', 'The native method uses the current setting of <a href=\"http://www.php.net/manual/en/session.configuration.php\">session.save_handler</a>, in php.ini, which is file-based by default. <b>Note: If you change the session storage method, all of your users will be logged out.</b>', 'admin_session');
INSERT INTO `se_languagevars` VALUES ('1302', '2', 'Native', 'admin_session');
INSERT INTO `se_languagevars` VALUES ('1303', '2', 'How many seconds of inactivity is allowed before the session expires? An expired session will cause the user to be logged out and may invalidate forms that were partially filled out. This cannot be disabled, instead set it to a high value such as 259200 (3 days).', 'admin_session');
INSERT INTO `se_languagevars` VALUES ('1304', '2', 'File Session Settings', 'admin_session');
INSERT INTO `se_languagevars` VALUES ('1305', '2', 'If you have enabled file-based sessions above, please provide the path (relative to your SocialEngine base directory) to where you want to store session data. This directory must be writable (chmod 777).', 'admin_session');
INSERT INTO `se_languagevars` VALUES ('1306', '2', 'Memcache Session Settings', 'admin_session');
INSERT INTO `se_languagevars` VALUES ('1307', '2', 'Memcached supports multiple servers.', 'admin_session');
INSERT INTO `se_languagevars` VALUES ('1308', '2', 'Could not read file.', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1309', '2', 'A language code was not specified in the file.', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1310', '2', 'A language name was not specified in the file.', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1311', '2', 'Could not create new language', 'admin_language_import');
INSERT INTO `se_languagevars` VALUES ('1312', '2', 'Admin Interface Language', 'admin_home');
INSERT INTO `se_languagevars` VALUES ('1313', '2', 'If you have multiple language packs installed, you can change the language the admin interface is displayed in.', 'admin_home');
INSERT INTO `se_languagevars` VALUES ('1314', '2', 'You have not yet deleted install.php and/or installsql.php. Leaving these files on your server is a security risk!', 'admin_home');
INSERT INTO `se_languagevars` VALUES ('1315', '2', 'You have not yet deleted upgrade.php and/or upgradesql.php. Leaving these files on your server is a security risk!', 'admin_home');
INSERT INTO `se_languagevars` VALUES ('1316', '2', 'More ...', 'header');
INSERT INTO `se_languagevars` VALUES ('1317', '2', 'More ...', 'profile');
INSERT INTO `se_languagevars` VALUES ('1318', '2', 'Some problems have been detected with your installation or server configuration.', 'admin_home');
INSERT INTO `se_languagevars` VALUES ('1319', '2', 'Click to expand.', 'admin_home');
INSERT INTO `se_languagevars` VALUES ('1320', '2', 'Your version file (%1$s) does not contain the same version as your database (%2$s). You may have not uploaded include/version.php or not run the upgrade script. In the latter case, database corruption may occur if using different file and database versions.', 'admin_home');
INSERT INTO `se_languagevars` VALUES ('1321', '2', 'Reply could not be sent because the recipient blocked you.', 'user_messages_view');
INSERT INTO `se_languagevars` VALUES ('500401', '2', '', '');
INSERT INTO `se_languagevars` VALUES ('500392', '2', '', '');
INSERT INTO `se_languagevars` VALUES ('850019', '2', 'Ha sido invitado a unirse a %2$s.', '');
INSERT INTO `se_languagevars` VALUES ('850020', '2', 'Hola %1$s, Ha sido invitado a unirse a un grupo denominado %2$s. Por favor, haga clic en el enlace a continuación para iniciar sesión: %3$s <br>Saludos cordiales, <br> La Administración de la Red Social\"', '');
INSERT INTO `se_languagevars` VALUES ('850021', '2', 'Nuevo comentario del grupo', '');
INSERT INTO `se_languagevars` VALUES ('850022', '2', '\"Hola %1$s,<br><br>%2$s ha publicado un comentario sobre un grupo que usted lidera. Por favor haga clic en el enlace para verlo:<br><br>%3$s<br><br>\nSaludos cordiales, La Administración de la Red Social\"', '');
INSERT INTO `se_languagevars` VALUES ('850023', '2', 'Nuevo comentario sobre la fotografía del grupo', '');
INSERT INTO `se_languagevars` VALUES ('850024', '2', '\"Hola %1$s,<br><br>%2$s ha publicado un comentario sobre una fotografía en un grupo que usted lidera. Por favor haga clic en el enlace para verlo:<br><br>%3$s<br><br>\nSaludos cordiales, La Administración de la Red Social\"', '');
INSERT INTO `se_languagevars` VALUES ('850025', '2', 'Nuevo solicitud de membresía para un grupo', '');
INSERT INTO `se_languagevars` VALUES ('850026', '2', 'Hola %1$s,<br><br>%2$s desea unirse a su grupo \"\"%3$s\"\". Por favor, haga clic en el enlace a continuación para iniciar sesión y confirmar su membresía:<br><br>\n%4$s<br><br>Saludos cordiales,<br><br>La Administración de la Red Social\"', '');
INSERT INTO `se_languagevars` VALUES ('850027', '2', 'Nuevo comentario sobre los medios', '');
INSERT INTO `se_languagevars` VALUES ('850028', '2', 'Hola %1$s,<br><br>%2$s ha publicado un nuevo comentario sobre una de sus fotografías. Por favor, haga clic en el enlace a continuación para verlo:<br>%3$s<br><br>Saludos cordiales,<br><br>La Administración de la Red Social', '');
INSERT INTO `se_languagevars` VALUES ('850029', '2', 'Nuevo comentario sobre una entrada del blog', '');
INSERT INTO `se_languagevars` VALUES ('850030', '2', 'Hola %1$s,<br><br>%2$s ha publicado un nuevo comentario sobre una de las entradas de su blog. Por favor, haga clic en el enlace a continuación para verlo:<br>%3$s <br>Saludos cordiales,<br><br>La Administración de la Red Social\n', '');
INSERT INTO `se_languagevars` VALUES ('850031', '2', 'Nuevo comentario en el listado clasificado', '');
INSERT INTO `se_languagevars` VALUES ('850032', '2', 'Hola %1$s,<br><br>%2$s ha publicado un nuevo comentario en uno de sus listados clasificados. Por favor, haga clic en el enlace a continuación para verlo:<br>%3$s <br>Saludos cordiales,<br><br>La Administración de la Red Social\n', '');
INSERT INTO `se_languagevars` VALUES ('850033', '2', 'Ha sido invitado a concurrir a %2$s.', '');
INSERT INTO `se_languagevars` VALUES ('850034', '2', 'Hola %1$s,<br><br>Ha recibido una invitación para concurrir a un evento: %2$s. Por favor, haga clic en el enlace a continuación para verlo:<br>%3$s <br>Saludos cordiales,<br><br>La Administración de la Red Social\n', '');
INSERT INTO `se_languagevars` VALUES ('850035', '2', 'Nuevo comentario en el evento', '');
INSERT INTO `se_languagevars` VALUES ('850036', '2', 'Hola %1$s,<br>%2$s ha publicado un nuevo comentario sobre un evento que usted ha creado.<br>Por favor, haga clic en el enlace a continuación para verlo:<br>%3$s <br>Saludos cordiales,<br><br>La Administración de la Red Social\n', '');
INSERT INTO `se_languagevars` VALUES ('850037', '2', 'Nuevo comentario en la fotografía del evento', '');
INSERT INTO `se_languagevars` VALUES ('850038', '2', 'Hola %1$s,<br>%2$s ha publicado un nuevo comentario sobre una fotografía que usted ha creado.<br>Por favor, haga clic en el enlace a continuación para verlo:<br>%3$s <br>Saludos cordiales,<br><br>La Administración de la Red Social\n', '');
INSERT INTO `se_languagevars` VALUES ('850039', '2', 'Nueva solicitud de invitación para el evento', '');
INSERT INTO `se_languagevars` VALUES ('850040', '2', 'Hola %1$s,<br>%2$s ha solicitado una invitación para su evento \"\"%3$s\"\".<br>Por favor, haga clic en el enlace a continuación para verlo:<br>%3$s <br>Saludos cordiales,<br><br>La Administración de la Red Social\"\n', '');
INSERT INTO `se_languagevars` VALUES ('850041', '2', '¡Usted ha sido etiquetado en una fotografía! ', '');
INSERT INTO `se_languagevars` VALUES ('850042', '2', 'Hola %1$s, <br><br>Usted ha sido etiquetado en una fotografía. Por favor haga clic en el siguiente enlace para verla: <br><br>%2$s<br>', '');
INSERT INTO `se_languagevars` VALUES ('850043', '2', 'Nueva etiqueta en la fotografía ', '');
INSERT INTO `se_languagevars` VALUES ('850044', '2', 'Hola %1$s, <br><br> %2$s ha publicado una nueva etiqueta en una de sus fotografías. Por favor, haga clic en el siguiente enlace para verla:<br><br>%3$s<br> ', '');
INSERT INTO `se_languagevars` VALUES ('850045', '2', 'Nuevo trackback de una entrada del blog', '');
INSERT INTO `se_languagevars` VALUES ('850046', '2', 'Hola %1$s, una nueva respuesta ha sido publicada a través de un trackback en una de sus entradas en el blog desde un blog llamado <a href=\"%3$s\">%2$s</a>.  Por favor haga clic en el siguiente enlace para ver la respuesta: %4$s Saludos cordiales, La Administración de la red social', '');
INSERT INTO `se_languagevars` VALUES ('850047', '2', 'Nueva entrada en el blog desde un blog  suscrito ', '');
INSERT INTO `se_languagevars` VALUES ('850048', '2', 'Hola %1$s, 2$%s ha publicado una nueva entrada en el blog que ha suscrito. Por favor, haga clic en el siguiente enlace para verla: %3$s Saludos cordiales, La Administración de la red social', '');
INSERT INTO `se_languagevars` VALUES ('850049', '2', '¡Usted ha sido etiquetado en una fotografía de un grupo! ', '');
INSERT INTO `se_languagevars` VALUES ('850050', '2', 'Hola %1$s, Usted ha sido etiquetado en una fotografía de un grupo. Por favor, haga clic en el siguiente enlace para verla: %2$s Saludos cordiales, La Administración de la red social', '');
INSERT INTO `se_languagevars` VALUES ('850051', '2', 'Nueva etiqueta en la fotografía de un grupo', '');
INSERT INTO `se_languagevars` VALUES ('850052', '2', 'Hola %1$s, 2$%s ha publicado una nueva etiqueta en una de las fotografías de un grupo que usted lidera. Por favor, haga clic en el siguiente enlace para verla: %3$s Saludos cordiales, La Administración de la red social', '');
INSERT INTO `se_languagevars` VALUES ('850053', '2', 'Nuevo tema de debate en el grupo', '');
INSERT INTO `se_languagevars` VALUES ('850054', '2', 'Hola %1$s, %2$s ha publicado un nuevo tema de debate en un grupo que usted lidera. Por favor, haga clic en el siguiente enlace para verlo: %3$s Saludos cordiales, la Administración de la red social', '');
INSERT INTO `se_languagevars` VALUES ('850055', '2', '¡Usted ha sido etiquetado en una fotografía de un evento! ', '');
INSERT INTO `se_languagevars` VALUES ('850056', '2', 'Hola %1$s, Usted ha sido etiquetado en una fotografía de un evento. Por favor, haga clic en el siguiente enlace para verla: %2$s Saludos cordiales, La Administración de la red social', '');
INSERT INTO `se_languagevars` VALUES ('850057', '2', 'Nueva etiqueta en una fotografía de un evento ', '');
INSERT INTO `se_languagevars` VALUES ('850058', '2', 'Hola %1$s, 2$%s ha publicado una nueva etiqueta en una de las fotografías de un evento que usted lidera. Por favor, haga clic en el siguiente enlace para verla: %3$s Saludos cordiales, La Administración de la red social', '');
INSERT INTO `se_languagevars` VALUES ('1000001', '2', 'Nuevo comentario sobre los medios enviado por correo electrónico', '');
INSERT INTO `se_languagevars` VALUES ('1000002', '2', 'Este es el correo electrónico que se envía a un usuario cuando se publica un nuevo comentario sobre una de sus fotografías. ', '');
INSERT INTO `se_languagevars` VALUES ('1000003', '2', 'Configuración del plugin del álbum', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_lostpass_reset, admin_lostpass, admin_login, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_fields, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('1000004', '2', 'Ver álbumes de fotografías', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_lostpass_reset, admin_lostpass, admin_login, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_fields, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('1000005', '2', 'Configuración del álbum global', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_lostpass_reset, admin_lostpass, admin_login, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_fields, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('1000006', '2', 'Configuración del álbum', 'admin_viewusers_edit, admin_viewusers, admin_viewreports, admin_viewplugins, admin_viewadmins, admin_url, admin_templates, admin_subnetworks, admin_stats, admin_signup, admin_profile, admin_lostpass_reset, admin_lostpass, admin_login, admin_log, admin_levels_usersettings, admin_levels_messagesettings, admin_levels_edit, admin_levels_albumsettings, admin_levels, admin_language_edit, admin_language, admin_invite, admin_home, admin_general, admin_fields, admin_faq, admin_emails, admin_connections, admin_banning, admin_announcements, admin_ads_modify, admin_ads, admin_activity,');
INSERT INTO `se_languagevars` VALUES ('1000007', '2', 'Fotografías', 'header,');
INSERT INTO `se_languagevars` VALUES ('1000008', '2', 'Esta página contiene configuraciones generales del álbum que afectan a toda su red social.', '');
INSERT INTO `se_languagevars` VALUES ('1000009', '2', 'Seleccione si desea o no permitir al público (visitantes que no se han identificado) ver las siguientes secciones de su red social. En algunos casos (como en de los perfiles, blogs y álbumes), si les ha ofrecido la opción, los usuarios podrán hacer sus páginas privadas a pesar de que usted las haya hecho públicamente visibles aquí. Para acceder a más configuraciones de permisos por favor visite la página <a href=\'admin_general.php\'>Configuración general</a>.', '');
INSERT INTO `se_languagevars` VALUES ('1000010', '2', 'Sí, el público puede ver los álbumes, a menos que se hayan convertido en privados.', '');
INSERT INTO `se_languagevars` VALUES ('1000011', '2', 'No, el público no puede ver los álbumes.', '');
INSERT INTO `se_languagevars` VALUES ('1000012', '2', 'El campo del tamaño máximo del archivo debe contener un número entero entre 1 y 204800. ', '');
INSERT INTO `se_languagevars` VALUES ('1000013', '2', 'Los campos del ancho y la altura máximos deben contener números enteros entre 1 y 9999.', '');
INSERT INTO `se_languagevars` VALUES ('1000014', '2', 'El campo de número máximo de álbumes permitidos debe contener un número entero entre 1 y 999. ', '');
INSERT INTO `se_languagevars` VALUES ('1000015', '2', 'Si ha permitido a los usuarios tener álbumes, puede modificar sus datos desde esta página.', '');
INSERT INTO `se_languagevars` VALUES ('1000016', '2', '¿Desea permitir los álbumes?', '');
INSERT INTO `se_languagevars` VALUES ('1000017', '2', '¿Desea permitir a los usuarios tener álbumes? Si elige NO, el resto de las configuraciones en esta página no se aplicarán.', '');
INSERT INTO `se_languagevars` VALUES ('1000018', '2', 'Sí, permitir los álbumes.', '');
INSERT INTO `se_languagevars` VALUES ('1000019', '2', 'No, no permitir los álbumes. ', '');
INSERT INTO `se_languagevars` VALUES ('1000020', '2', 'Opciones de privacidad de los álbumes', '');
INSERT INTO `se_languagevars` VALUES ('1000021', '2', 'Si habilita esta función, los usuarios podrán excluir sus álbumes de los resultados de la búsqueda.  De lo contrario, todos los álbumes se incluirán en los resultados de la búsqueda.', '');
INSERT INTO `se_languagevars` VALUES ('1000022', '2', 'Sí, permitir a los usuarios excluir sus álbumes de los resultados de la búsqueda.', '');
INSERT INTO `se_languagevars` VALUES ('1000023', '2', 'No, exigir que se  incluyan todos los álbumes en los resultados de la búsqueda.', '');
INSERT INTO `se_languagevars` VALUES ('1000024', '2', 'Opciones de privacidad de los álbumes', '');
INSERT INTO `se_languagevars` VALUES ('1000025', '2', 'Los usuarios pueden elegir entre cualquiera de las opciones a continuación, cuando deciden quienes pueden ver sus álbumes. Si no se elige opción alguna, todos los usuarios podrán ver los álbumes.', '');
INSERT INTO `se_languagevars` VALUES ('1000026', '2', 'Opciones de comentarios de los medios', '');
INSERT INTO `se_languagevars` VALUES ('1000027', '2', 'Los usuarios pueden elegir entre cualquiera de las opciones a continuación, cuando deciden quienes pueden publicar comentarios sobre sus medios.  Si no se elige opción alguna, todos los usuarios podrán publicar comentarios sobre los medios.', '');
INSERT INTO `se_languagevars` VALUES ('1000028', '2', 'Número máximo de álbumes permitidos', '');
INSERT INTO `se_languagevars` VALUES ('1000029', '2', 'Introduzca el número máximo de álbumes permitidos. El campo debe contener un número entero entre 1 y 999.', '');
INSERT INTO `se_languagevars` VALUES ('1000030', '2', 'Álbumes permitidos', '');
INSERT INTO `se_languagevars` VALUES ('1000031', '2', 'Tipos de archivo permitidos', '');
INSERT INTO `se_languagevars` VALUES ('1000032', '2', 'Confeccione una lista con las siguientes extensiones de archivo que los usuarios están autorizados a cargar.  Separe las extensiones de archivo con comas, por ejemplo: jpg, gif, jpeg, png, bmp', '');
INSERT INTO `se_languagevars` VALUES ('1000033', '2', 'Tipos MIME permitidos', '');
INSERT INTO `se_languagevars` VALUES ('1000034', '2', 'Para poder cargar un archivo, el archivo debe tener una extensión de archivo permitida, así como también un tipo MIME permitido.  Esto impide que los usuarios disfracen los archivos maliciosos con una extensión falsa. Separe los tipos MIME con comas, por ejemplo: image/jpeg, image/gif, image/png, image/bmp', '');
INSERT INTO `se_languagevars` VALUES ('1000035', '2', 'Espacio de almacenamiento permitido ', '');
INSERT INTO `se_languagevars` VALUES ('1000036', '2', '¿Cuánto espacio de almacenamiento podrá disponer cada usuario para almacenar sus archivos? ', '');
INSERT INTO `se_languagevars` VALUES ('1000037', '2', 'Ilimitado', '');
INSERT INTO `se_languagevars` VALUES ('1000038', '2', 'Tamaño de archivo máximo ', '');
INSERT INTO `se_languagevars` VALUES ('1000039', '2', 'Introduzca el tamaño de archivo máximo que se podrá cargar expresado en KB. Este debe ser un número entre 1 y 204800.', '');
INSERT INTO `se_languagevars` VALUES ('1000040', '2', 'Introduzca el ancho y la altura máximos (en píxeles) para las imágenes subidas a los álbumes.  Se reducirá el tamaño de las imágenes con dimensiones que excedan este rango si su servidor tiene instalada GD Libraries.  Tenga en cuenta que los tipos de imágenes inusuales como TIFF y RAW, y otros no pueden ser redimensionados. ', '');
INSERT INTO `se_languagevars` VALUES ('1000041', '2', '¿Desea permitir estilos CSS personalizados?', '');
INSERT INTO `se_languagevars` VALUES ('1000042', '2', 'Si habilita esta función, sus usuarios podrán personalizar los colores y las fuentes de sus álbumes modificando sus estilos CSS.', '');
INSERT INTO `se_languagevars` VALUES ('1000043', '2', 'Sí, permitir la personalización de los estilos CSS. ', '');
INSERT INTO `se_languagevars` VALUES ('1000044', '2', 'No, desactivar la personalización de los estilos CSS. ', '');
INSERT INTO `se_languagevars` VALUES ('1000045', '2', 'En esta página se muestran todos los álbumes que los usuarios han creado en su red social. De acuerdo con los ajustes que haya especificado en este panel de control, los usuarios pueden crear álbumes y usarlos para cargar, organizar y compartir fotografías, música, vídeos y otros archivos.  Puede utilizar esta página para controlar estos álbumes y eliminar material ofensivo, si es necesario.  La introducción de criterios en los campos del filtro le ayudará a encontrar álbumes específicos.  Si se dejan los campos del filtro en blanco, se mostrarán todos los álbumes existentes en su red social. ', '');
INSERT INTO `se_languagevars` VALUES ('1000046', '2', 'Título ', '');
INSERT INTO `se_languagevars` VALUES ('1000047', '2', 'Propietario', '');
INSERT INTO `se_languagevars` VALUES ('1000048', '2', 'No se encontraron álbumes.', '');
INSERT INTO `se_languagevars` VALUES ('1000049', '2', 'Se encontraron %1$d álbumes', '');
INSERT INTO `se_languagevars` VALUES ('1000050', '2', 'Archivos ', '');
INSERT INTO `se_languagevars` VALUES ('1000051', '2', 'Espacio utilizado', '');
INSERT INTO `se_languagevars` VALUES ('1000052', '2', 'Ver', '');
INSERT INTO `se_languagevars` VALUES ('1000053', '2', '¿Está seguro que desea eliminar este álbum?  Advertencia: Todas las imágenes de este álbum ¡también se eliminarán!', '');
INSERT INTO `se_languagevars` VALUES ('1000054', '2', '¿Desea eliminar el álbum?', '');
INSERT INTO `se_languagevars` VALUES ('1000055', '2', 'Mis álbumes ', '');
INSERT INTO `se_languagevars` VALUES ('1000056', '2', 'Configuración del álbum', '');
INSERT INTO `se_languagevars` VALUES ('1000057', '2', 'Tiene %1$d álbumes y %2$d fotografías. ', '');
INSERT INTO `se_languagevars` VALUES ('1000058', '2', 'Usted tiene %1$s MB de espacio libre disponible. ', '');
INSERT INTO `se_languagevars` VALUES ('1000059', '2', 'Crear un nuevo álbum ', '');
INSERT INTO `se_languagevars` VALUES ('1000060', '2', 'Enlace de mis álbumes: ', '');
INSERT INTO `se_languagevars` VALUES ('1000061', '2', 'Creado:', '');
INSERT INTO `se_languagevars` VALUES ('1000062', '2', 'Última actualización:', '');
INSERT INTO `se_languagevars` VALUES ('1000063', '2', 'Archivos:', '');
INSERT INTO `se_languagevars` VALUES ('1000064', '2', '%1$s fotografías (%2$s MB)', '');
INSERT INTO `se_languagevars` VALUES ('1000065', '2', 'Visitas:', '');
INSERT INTO `se_languagevars` VALUES ('1000066', '2', '%1$d visitas', '');
INSERT INTO `se_languagevars` VALUES ('1000067', '2', 'Puede ser visto por:', '');
INSERT INTO `se_languagevars` VALUES ('1000068', '2', 'Ver álbum', '');
INSERT INTO `se_languagevars` VALUES ('1000069', '2', 'Editar el álbum', '');
INSERT INTO `se_languagevars` VALUES ('1000070', '2', 'Eliminar el álbum', '');
INSERT INTO `se_languagevars` VALUES ('1000071', '2', 'Usted no tiene ningún álbum.', '');
INSERT INTO `se_languagevars` VALUES ('1000072', '2', 'Cree un álbum para empezar a cargar archivos. ', '');
INSERT INTO `se_languagevars` VALUES ('1000073', '2', 'Por favor, introduzca un nombre para este álbum.', '');
INSERT INTO `se_languagevars` VALUES ('1000074', '2', 'Por favor, proporcione alguna información sobre su nuevo álbum.', '');
INSERT INTO `se_languagevars` VALUES ('1000075', '2', 'Ha alcanzado el número máximo de álbumes permitidos (%1$d).  Debe eliminar algunos de sus álbumes antiguos antes de poder crear uno nuevo. ', '');
INSERT INTO `se_languagevars` VALUES ('1000076', '2', 'Volver a mis álbumes ', '');
INSERT INTO `se_languagevars` VALUES ('1000077', '2', 'Nombre del álbum: ', '');
INSERT INTO `se_languagevars` VALUES ('1000078', '2', 'Descripción del álbum:', '');
INSERT INTO `se_languagevars` VALUES ('1000079', '2', '¿Desea incluir este álbum en los resultados de la búsqueda/exploración?', '');
INSERT INTO `se_languagevars` VALUES ('1000080', '2', 'Sí, incluir este álbum en los resultados de la búsqueda/exploración.', '');
INSERT INTO `se_languagevars` VALUES ('1000081', '2', 'No, excluir este álbum de los resultados de la búsqueda/exploración.', '');
INSERT INTO `se_languagevars` VALUES ('1000082', '2', '¿Quién puede ver este álbum?', '');
INSERT INTO `se_languagevars` VALUES ('1000083', '2', '¿Quién puede hacer un comentario en este álbum?', '');
INSERT INTO `se_languagevars` VALUES ('1000084', '2', 'Crear un álbum', '');
INSERT INTO `se_languagevars` VALUES ('1000085', '2', 'Usted no tiene espacio libre suficiente para cargar %1$s. ', '');
INSERT INTO `se_languagevars` VALUES ('1000086', '2', '%1$s fue cargado correctamente. ', '');
INSERT INTO `se_languagevars` VALUES ('1000087', '2', 'Subir fotografías:', '');
INSERT INTO `se_languagevars` VALUES ('1000088', '2', 'Para subir fotografías a este grupo desde su ordenador, haga clic en el botón \"Explorar\" (Browse), localícelas en su ordenador y haga clic en el botón \"Subir\". ', '');
INSERT INTO `se_languagevars` VALUES ('1000089', '2', 'Volver fotografías', '');
INSERT INTO `se_languagevars` VALUES ('1000090', '2', 'Usted puede subir los siguientes tipos de archivo: %1$s', '');
INSERT INTO `se_languagevars` VALUES ('1000091', '2', 'Usted puede subir archivos con tamaños de hasta %1$s KB. ', '');
INSERT INTO `se_languagevars` VALUES ('1000092', '2', 'Su álbum se ha restablecido.  Puede comenzar a subir fotografías a continuación. ', '');
INSERT INTO `se_languagevars` VALUES ('1000093', '2', 'Editar los detalles del álbum', '');
INSERT INTO `se_languagevars` VALUES ('1000094', '2', 'Utilice esta página para cambiar el nombre del álbum, la descripción o el nivel de privacidad. ', '');
INSERT INTO `se_languagevars` VALUES ('1000095', '2', 'Editar fotografías:', '');
INSERT INTO `se_languagevars` VALUES ('1000096', '2', 'Todas las fotografías en este álbum se encuentran en la lista a continuación. <br> Este álbum contiene <b>%1$s archivos </b> y ha sido visto <b>%2 veces $s</b>. ', '');
INSERT INTO `se_languagevars` VALUES ('1000097', '2', 'Volver a álbumes', '');
INSERT INTO `se_languagevars` VALUES ('1000098', '2', 'Añadir nuevas fotografías', '');
INSERT INTO `se_languagevars` VALUES ('1000099', '2', 'Editar la información del álbum', '');
INSERT INTO `se_languagevars` VALUES ('1000100', '2', 'No hay archivos en este álbum.', '');
INSERT INTO `se_languagevars` VALUES ('1000101', '2', 'Haga clic aquí para empezar a añadir archivos. ', '');
INSERT INTO `se_languagevars` VALUES ('1000102', '2', 'Pie de foto', '');
INSERT INTO `se_languagevars` VALUES ('1000103', '2', 'Eliminar la fotografía', '');
INSERT INTO `se_languagevars` VALUES ('1000104', '2', 'Portada del álbum', '');
INSERT INTO `se_languagevars` VALUES ('1000105', '2', 'Mover a:', '');
INSERT INTO `se_languagevars` VALUES ('1000106', '2', 'Ubicación del perfil ', '');
INSERT INTO `se_languagevars` VALUES ('1000107', '2', 'Los usuarios pueden elegir entre cualquiera de las opciones a continuación, cuando deciden el lugar en que sus álbumes aparecerán dentro de sus perfiles.', '');
INSERT INTO `se_languagevars` VALUES ('1000108', '2', 'Mostrar los álbumes en las pestañas', '');
INSERT INTO `se_languagevars` VALUES ('1000109', '2', 'Mostrar los álbumes en el margen lateral', '');
INSERT INTO `se_languagevars` VALUES ('1000110', '2', '¿En qué lugar del perfil desea mostrar sus álbumes?', '');
INSERT INTO `se_languagevars` VALUES ('1000111', '2', 'Editar la configuración del álbum, como por ejemplo el estilo de su álbum.', '');
INSERT INTO `se_languagevars` VALUES ('1000112', '2', 'El estilo de mis álbumes ', '');
INSERT INTO `se_languagevars` VALUES ('1000113', '2', 'Puede cambiar los colores, fuentes y estilos de sus álbumes añadiendo a continuación el código CSS. El contenido del área de texto a continuación, se mostrará entre las etiquetas &lt;style&gt; en su evento.', '');
INSERT INTO `se_languagevars` VALUES ('1000114', '2', 'Subir', '');
INSERT INTO `se_languagevars` VALUES ('1000115', '2', 'Girar a la izquierda ', '');
INSERT INTO `se_languagevars` VALUES ('1000116', '2', 'Girar a la derecha ', '');
INSERT INTO `se_languagevars` VALUES ('1000118', '2', '%1$d álbumes/fotografías ', '');
INSERT INTO `se_languagevars` VALUES ('1000119', '2', 'Fotografía: %1$s', '');
INSERT INTO `se_languagevars` VALUES ('1000120', '2', 'Álbum: %1$s', '');
INSERT INTO `se_languagevars` VALUES ('1000121', '2', 'Medios publicados por <a href=\'%1$s\'>%2$s</a><br>%3$s', '');
INSERT INTO `se_languagevars` VALUES ('1000122', '2', 'Álbum creado por <a href=\'%1$s\'>%2$s</a><br>%3$s', '');
INSERT INTO `se_languagevars` VALUES ('1000123', '2', 'Álbumes', '');
INSERT INTO `se_languagevars` VALUES ('1000124', '2', 'Actualizado  %1$s por <a href=\'%2$s\'>%3$s</a>', '');
INSERT INTO `se_languagevars` VALUES ('1000125', '2', 'No tiene autorización para ver este archivo. ', '');
INSERT INTO `se_languagevars` VALUES ('1000126', '2', 'Subido ', '');
INSERT INTO `se_languagevars` VALUES ('1000127', '2', 'Explorar los álbumes de fotografías', '');
INSERT INTO `se_languagevars` VALUES ('1000128', '2', 'Ver:', '');
INSERT INTO `se_languagevars` VALUES ('1000129', '2', 'Los álbumes de todos los usuarios', '');
INSERT INTO `se_languagevars` VALUES ('1000130', '2', 'Los álbumes de mis amigos', '');
INSERT INTO `se_languagevars` VALUES ('1000131', '2', 'Mostrar: ', '');
INSERT INTO `se_languagevars` VALUES ('1000132', '2', 'Recientemente actualizados', '');
INSERT INTO `se_languagevars` VALUES ('1000133', '2', 'Recientemente creados', '');
INSERT INTO `se_languagevars` VALUES ('1000134', '2', 'Opciones de etiquetado de fotografías ', '');
INSERT INTO `se_languagevars` VALUES ('1000135', '2', 'Los usuarios pueden elegir entre cualquiera de las opciones a continuación, cuando deciden quienes pueden etiquetar sus fotografías. Si no se elige opción alguna, todos los usuarios podrán etiquetar fotografías. ', '');
INSERT INTO `se_languagevars` VALUES ('1000136', '2', '¿Quién puede etiquetar fotografías en este álbum?', '');
INSERT INTO `se_languagevars` VALUES ('1000137', '2', 'Fotografías de %1$s (%2$d) ', '');
INSERT INTO `se_languagevars` VALUES ('1000138', '2', 'Álbumes de <a href=\'%1$s\'>%2$s</a>', '');
INSERT INTO `se_languagevars` VALUES ('1000139', '2', '%1$s no tiene ningún álbum.', '');
INSERT INTO `se_languagevars` VALUES ('1000140', '2', 'Actualizado %1$s', '');
INSERT INTO `se_languagevars` VALUES ('1000141', '2', '<a href=\'%3$s\'>álbumes</a> de <a href=\'%1$s\'>%2$s</a> ', '');
INSERT INTO `se_languagevars` VALUES ('1000142', '2', 'descargar audio ', '');
INSERT INTO `se_languagevars` VALUES ('1000143', '2', 'descargar video ', '');
INSERT INTO `se_languagevars` VALUES ('1000144', '2', 'descargar este archivo ', '');
INSERT INTO `se_languagevars` VALUES ('1000145', '2', 'Está viendo #%1$d de %2$d en <a href=\'%3$s\'>%4$s</a>', '');
INSERT INTO `se_languagevars` VALUES ('1000146', '2', 'Última', '');
INSERT INTO `se_languagevars` VALUES ('1000147', '2', 'Siguiente ', '');
INSERT INTO `se_languagevars` VALUES ('1000148', '2', 'Denunciar contenido inapropiado ', '');
INSERT INTO `se_languagevars` VALUES ('1000149', '2', 'Fotografías de <a href=\'% $s\'>%2$s</a>', '');
INSERT INTO `se_languagevars` VALUES ('1000150', '2', 'Está viendo  #%1$d de %2$d <a href=\'%3$s\'>fotografías de %4$s</a> &nbsp;|&nbsp; <a href=\'%5$s\'>Volver al perfil de %4$s</a>', '');
INSERT INTO `se_languagevars` VALUES ('1000151', '2', 'Notificación al ser etiquetado ', '');
INSERT INTO `se_languagevars` VALUES ('1000152', '2', 'Este es el correo electrónico que se envía a un usuario cuando alguien lo etiqueta en una  fotografía.', '');
INSERT INTO `se_languagevars` VALUES ('1000153', '2', 'Correo electrónico sobre nueva etiqueta en una foto ', '');
INSERT INTO `se_languagevars` VALUES ('1000154', '2', 'Este es el correo electrónico que se envía a un usuario cuando alguien etiqueta una  de sus fotografías.', '');
INSERT INTO `se_languagevars` VALUES ('1000155', '2', 'Álbum de %1$s: %2$s', '');
INSERT INTO `se_languagevars` VALUES ('1000156', '2', '%1$s', '');
INSERT INTO `se_languagevars` VALUES ('1000157', '2', 'Desde %1$s por <a href=\'%2$s\'>%3$s</a>', '');
INSERT INTO `se_languagevars` VALUES ('1000158', '2', 'Fotografía de %1$s - %2$s', '');
INSERT INTO `se_languagevars` VALUES ('1000159', '2', '%1$s', '');
INSERT INTO `se_languagevars` VALUES ('1000160', '2', 'Álbumes de %1$s', '');
INSERT INTO `se_languagevars` VALUES ('1000161', '2', 'Álbumes de %1$s', '');
INSERT INTO `se_languagevars` VALUES ('1000162', '2', 'En esta fotografía: ', '');
INSERT INTO `se_languagevars` VALUES ('1000163', '2', 'Añadir etiqueta ', '');
INSERT INTO `se_languagevars` VALUES ('1000164', '2', 'Compartir esto', '');
INSERT INTO `se_languagevars` VALUES ('1000165', '2', 'Para compartir esta fotografía o incrustarla en otra página Web, por favor, copie y pegue el código de su elección: ', '');
INSERT INTO `se_languagevars` VALUES ('1000166', '2', 'Enlace directo ', '');
INSERT INTO `se_languagevars` VALUES ('1000167', '2', 'HTML - Imagen incrustada', '');
INSERT INTO `se_languagevars` VALUES ('1000168', '2', 'HTML - Enlace del texto ', '');
INSERT INTO `se_languagevars` VALUES ('1000169', '2', 'Código UBB (para foros) ', '');
INSERT INTO `se_languagevars` VALUES ('1000170', '2', 'Cerrar ventana', '');
INSERT INTO `se_languagevars` VALUES ('1000171', '2', 'Álbumes de fotografías', '');
INSERT INTO `se_languagevars` VALUES ('1000172', '2', '%1$d fotografías ', '');
INSERT INTO `se_languagevars` VALUES ('1000173', '2', 'Quitar la etiqueta', '');
INSERT INTO `se_languagevars` VALUES ('1500001', '2', 'Configuración del blog', '');
INSERT INTO `se_languagevars` VALUES ('1500002', '2', 'Ver las entradas del blog', '');
INSERT INTO `se_languagevars` VALUES ('1500003', '2', 'Configuración del blog global ', '');
INSERT INTO `se_languagevars` VALUES ('1500004', '2', 'Configuración del blog', '');
INSERT INTO `se_languagevars` VALUES ('1500005', '2', 'Nuevo comentario en el blog enviado por correo electrónico', '');
INSERT INTO `se_languagevars` VALUES ('1500006', '2', 'Este es el correo electrónico que se envía a un usuario cuando  se publica un nuevo comentario sobre una de las entradas en su blog. ', '');
INSERT INTO `se_languagevars` VALUES ('1500007', '2', 'Blog', '');
INSERT INTO `se_languagevars` VALUES ('1500008', '2', 'Se debe especificar un ID de entrada  válido.', 'blog_ajax');
INSERT INTO `se_languagevars` VALUES ('1500009', '2', 'Se debe especificar una URL de retorno  válida.', 'blog_ajax');
INSERT INTO `se_languagevars` VALUES ('1500010', '2', 'La entrada especificada no existe. ', 'blog_ajax');
INSERT INTO `se_languagevars` VALUES ('1500011', '2', 'Este trackback ya se ha recibido. ', 'blog_ajax');
INSERT INTO `se_languagevars` VALUES ('1500012', '2', 'No puede enviar más de un trackback cada 15 segundos por dirección IP.', 'blog_ajax');
INSERT INTO `se_languagevars` VALUES ('1500013', '2', 'Se ha producido un error desconocido, no se añadió el trackback. ', 'blog_ajax');
INSERT INTO `se_languagevars` VALUES ('1500014', '2', 'El trackback fue recibido correctamente. ', 'blog_ajax');
INSERT INTO `se_languagevars` VALUES ('1500015', '2', 'Sin título', 'blog');
INSERT INTO `se_languagevars` VALUES ('1500016', '2', 'Publicado:', 'blog, profile_blog');
INSERT INTO `se_languagevars` VALUES ('1500017', '2', 'Comentarios:', 'blog, user_blog, user_blog_entry');
INSERT INTO `se_languagevars` VALUES ('1500018', '2', 'Trackbacks:', 'blog');
INSERT INTO `se_languagevars` VALUES ('1500019', '2', '%1$d comentario(s)', 'blog, user_blog, user_blog_entry');
INSERT INTO `se_languagevars` VALUES ('1500020', '2', '%1$d trackback(s)', 'blog');
INSERT INTO `se_languagevars` VALUES ('1500021', '2', 'Comentario', 'blog');
INSERT INTO `se_languagevars` VALUES ('1500022', '2', 'Trackback', 'blog');
INSERT INTO `se_languagevars` VALUES ('1500023', '2', '<b><a href=\"%2$s\">%1$s</a></b> no ha publicado ninguna entrada en el blog.', 'blog');
INSERT INTO `se_languagevars` VALUES ('1500024', '2', 'Volver al blog de %1$s  ', 'blog');
INSERT INTO `se_languagevars` VALUES ('1500025', '2', 'Trackbacks', 'blog');
INSERT INTO `se_languagevars` VALUES ('1500026', '2', 'Denunciar', 'blog');
INSERT INTO `se_languagevars` VALUES ('1500027', '2', 'Suscribirse', 'blog');
INSERT INTO `se_languagevars` VALUES ('1500028', '2', 'Darse de baja', 'blog');
INSERT INTO `se_languagevars` VALUES ('1500029', '2', 'Archivar', 'blog');
INSERT INTO `se_languagevars` VALUES ('1500030', '2', 'Categorías', 'blog');
INSERT INTO `se_languagevars` VALUES ('1500031', '2', 'Explorar las entradas del blog', 'browse_blogs');
INSERT INTO `se_languagevars` VALUES ('1500032', '2', 'Ver:', 'browse_blogs');
INSERT INTO `se_languagevars` VALUES ('1500033', '2', 'Ordenar: ', 'browse_blogs');
INSERT INTO `se_languagevars` VALUES ('1500034', '2', 'Categoría:', 'browse_blogs');
INSERT INTO `se_languagevars` VALUES ('1500035', '2', 'Sin categorizar', 'browse_blogs');
INSERT INTO `se_languagevars` VALUES ('1500036', '2', 'Fecha de publicación ', 'browse_blogs');
INSERT INTO `se_languagevars` VALUES ('1500037', '2', 'La más visitada', 'browse_blogs');
INSERT INTO `se_languagevars` VALUES ('1500038', '2', 'Más comentada ', 'browse_blogs');
INSERT INTO `se_languagevars` VALUES ('1500039', '2', '%1$s publicada por <a href=\"%2$s\">%3$s</a>', 'browse_blogs');
INSERT INTO `se_languagevars` VALUES ('1500040', '2', 'Visitas:', 'browse_blogs');
INSERT INTO `se_languagevars` VALUES ('1500041', '2', '%1$d visitas', 'browse_blogs');
INSERT INTO `se_languagevars` VALUES ('1500042', '2', '%1$d comentarios', 'browse_blogs');
INSERT INTO `se_languagevars` VALUES ('1500043', '2', 'Entradas en el blog', 'profile_blog');
INSERT INTO `se_languagevars` VALUES ('1500044', '2', 'Mis entradas en el blog', 'user_blog');
INSERT INTO `se_languagevars` VALUES ('1500045', '2', 'Su blog es el lugar donde usted puede compartir reflexiones personales y noticias con otras personas. Utilice esta página para buscar y administrar entradas que ya ha escrito en el blog.', 'user_blog');
INSERT INTO `se_languagevars` VALUES ('1500046', '2', 'Redactar una entrada nueva', 'user_blog');
INSERT INTO `se_languagevars` VALUES ('1500047', '2', 'Mis suscripciones', 'user_blog');
INSERT INTO `se_languagevars` VALUES ('1500048', '2', 'Buscar entradas', 'user_blog');
INSERT INTO `se_languagevars` VALUES ('1500049', '2', 'Buscar entradas para:', 'user_blog');
INSERT INTO `se_languagevars` VALUES ('1500050', '2', 'No se encontraron entradas en el blog.', 'user_blog');
INSERT INTO `se_languagevars` VALUES ('1500051', '2', 'Usted no tiene ninguna entrada en el blog. Haga clic <a href=\"%1$s\">aquí</a> para crear una.', 'user_blog');
INSERT INTO `se_languagevars` VALUES ('1500052', '2', 'Título ', 'user_blog');
INSERT INTO `se_languagevars` VALUES ('1500053', '2', 'Redactar una entrada en el blog', 'user_blog_entry');
INSERT INTO `se_languagevars` VALUES ('1500054', '2', 'Cree o edite su entrada a continuación, y luego haga clic en \"Publicar entrada\" para publicar la entrada en su blog. ', 'user_blog_entry');
INSERT INTO `se_languagevars` VALUES ('1500055', '2', 'Volver a Mi blog ', 'user_blog_entry, user_blog_settings, user_blog_subscriptions');
INSERT INTO `se_languagevars` VALUES ('1500056', '2', 'Título:', 'user_blog_entry');
INSERT INTO `se_languagevars` VALUES ('1500057', '2', 'Categoría:', 'user_blog_entry');
INSERT INTO `se_languagevars` VALUES ('1500058', '2', '<b><a href=\"%2$s\">%1$d comentarios</a></b> se han escrito acerca de esta entrada.', 'user_blog_entry');
INSERT INTO `se_languagevars` VALUES ('1500059', '2', 'Mostrar la configuración de la entrada', 'user_blog_entry');
INSERT INTO `se_languagevars` VALUES ('1500060', '2', 'Ocultar la configuración de la entrada', 'user_blog_entry');
INSERT INTO `se_languagevars` VALUES ('1500061', '2', '¿Desea incluir esta entrada de blog en los resultados de la búsqueda?', 'user_blog_entry');
INSERT INTO `se_languagevars` VALUES ('1500062', '2', 'Sí, incluir esta entrada de blog en los resultados de la búsqueda.', 'user_blog_entry');
INSERT INTO `se_languagevars` VALUES ('1500063', '2', 'No, excluir esta entrada de blog en los resultados de la búsqueda.', 'user_blog_entry');
INSERT INTO `se_languagevars` VALUES ('1500064', '2', 'Trackback URLs ', 'user_blog_entry');
INSERT INTO `se_languagevars` VALUES ('1500065', '2', 'Publicar una entrada', 'user_blog_entry');
INSERT INTO `se_languagevars` VALUES ('1500066', '2', 'Vista previa de la entrada', 'user_blog_entry');
INSERT INTO `se_languagevars` VALUES ('1500067', '2', 'Vista previa:', 'user_blog_entry');
INSERT INTO `se_languagevars` VALUES ('1500068', '2', 'Volver a la edición', 'user_blog_entry');
INSERT INTO `se_languagevars` VALUES ('1500069', '2', 'Editar la configuración del blog, como por ejemplo el estilo de su blog.', 'user_blog_settings');
INSERT INTO `se_languagevars` VALUES ('1500070', '2', 'Personalizar el estilo del blog', 'user_blog_settings');
INSERT INTO `se_languagevars` VALUES ('1500071', '2', 'Puede cambiar los colores, fuentes y estilos de tu blog añadiendo a continuación el código CSS.  El contenido del área de texto a continuación se mostrará entre las etiquetas &lt;style&gt; de su blog.', 'user_blog_settings');
INSERT INTO `se_languagevars` VALUES ('1500072', '2', 'Personalizar el estilo del blog', 'user_blog_settings');
INSERT INTO `se_languagevars` VALUES ('1500073', '2', 'Notificaciones del blog', 'user_blog_settings');
INSERT INTO `se_languagevars` VALUES ('1500074', '2', 'Notifíqueme por correo electrónico cuando alguien escribe un comentario en las entradas de mi blog. ', 'user_blog_settings');
INSERT INTO `se_languagevars` VALUES ('1500075', '2', 'Notifíqueme por correo electrónico cuando alguien responde a través de un “trackback” en una de las entradas de mi blog. ', 'user_blog_settings');
INSERT INTO `se_languagevars` VALUES ('1500076', '2', 'Notifíqueme por correo electrónico cuando una nueva entrada se publica en un blog que he suscrito. ', 'user_blog_settings');
INSERT INTO `se_languagevars` VALUES ('1500077', '2', 'Suscripciones a mi blog', 'user_blog_subscriptions');
INSERT INTO `se_languagevars` VALUES ('1500078', '2', 'Usted puede ver o administrar los blogs que ha suscrito aquí. ', 'user_blog_subscriptions');
INSERT INTO `se_languagevars` VALUES ('1500079', '2', 'Usted todavía no se ha suscrito a ningún blog.  ', 'user_blog_subscriptions');
INSERT INTO `se_languagevars` VALUES ('1500080', '2', 'Propietario', 'admin_viewblogs, user_blog_subscriptions');
INSERT INTO `se_languagevars` VALUES ('1500081', '2', 'Última publicación:', 'user_blog_subscriptions');
INSERT INTO `se_languagevars` VALUES ('1500082', '2', 'Entrada más reciente', 'user_blog_subscriptions');
INSERT INTO `se_languagevars` VALUES ('1500083', '2', 'Ver el blog', 'user_blog_subscriptions');
INSERT INTO `se_languagevars` VALUES ('1500084', '2', 'Esta página contiene configuraciones generales del blog que afectan a toda su red social.', 'admin_blog');
INSERT INTO `se_languagevars` VALUES ('1500085', '2', 'Valores predeterminados de permiso público', 'admin_blog');
INSERT INTO `se_languagevars` VALUES ('1500086', '2', 'Seleccione si desea o no permitir al público (visitantes que no se han identificado) ver las siguientes secciones de su red social. En algunos casos (como en el de los perfiles, blogs y álbumes), si les ha ofrecido la opción, los usuarios podrán hacer sus páginas privadas a pesar de que usted las haya hecho públicamente visibles aquí. Para acceder a más configuraciones de permisos por favor visite la página <a href=\'admin_general.php\'>Configuración general</a>.', 'admin_blog');
INSERT INTO `se_languagevars` VALUES ('1500087', '2', 'Sí, el público puede ver los blogs, a menos que se hayan convertido en privados.', 'admin_blog');
INSERT INTO `se_languagevars` VALUES ('1500088', '2', 'No, el público no puede ver los blogs.', 'admin_blog');
INSERT INTO `se_languagevars` VALUES ('1500089', '2', 'Categorías de las entradas del blog ', 'admin_blog');
INSERT INTO `se_languagevars` VALUES ('1500090', '2', 'Si desea permitir a sus usuarios clasificar sus entradas en el blog, cree las categorías a continuación.  Esta función es útil si desea crear una lista de todas las entradas de sus usuarios en el blog, ya que si no existen categorías, los usuarios no tendrán la opción de asignar una categoría de blog.  ', 'admin_blog');
INSERT INTO `se_languagevars` VALUES ('1500091', '2', 'Añadir categoría ', 'admin_blog');
INSERT INTO `se_languagevars` VALUES ('1500092', '2', 'Si ha permitido a los usuarios tener blogs, puede modificar sus datos desde esta página.', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('1500097', '2', 'Entradas por página', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('1500098', '2', '¿Cuántas entradas en el blog se mostrarán por página?  (Introduzca un número entre 1 y 999)  ', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('1500099', '2', '%1$s entradas por página', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('1500100', '2', 'Opciones de privacidad del blog', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('1500101', '2', '<b>  Opciones de privacidad de la búsqueda</b> <br> Si habilita esta característica, los usuarios podrán excluir sus entradas en el blog de los resultados de la búsqueda.  De lo contrario, todas las entradas en el blog se incluirán en los resultados la misma.', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('1500102', '2', 'Sí, permitir a los usuarios excluir sus entradas en el blog de los resultados de la búsqueda.', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('1500103', '2', 'No, obligar a todos los usuarios a incluir las entradas en el blog en los resultados de la búsqueda.', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('1500104', '2', '<b>Privacidad de las entradas del blog</b><br>Sus usuarios pueden elegir entre cualquiera de las opciones mostradas a continuación, cuando deciden quienes pueden ver sus entradas en el blog. Estas opciones aparecen en las páginas \"Añadir entrada\" y \"Editar entrada\" de sus usuarios.  Si no se elige opción alguna, todos los usuarios podrán ver los blogs.', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('1500105', '2', '<b>Opciones de los comentarios en el blog</b><br>Sus usuarios pueden elegir entre cualquiera de las opciones mostradas a continuación, cuando deciden quién puede publicar comentarios en sus entradas en el blog. Si no se elige opción alguna, todos los usuarios podrán publicar comentarios en las entradas.', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('1500106', '2', '¿Desea permitir estilos CSS personalizados?', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('1500107', '2', 'Si habilita esta función, sus usuarios podrán personalizar los colores y las fuentes de sus blogs modificando sus estilos CSS.', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('1500108', '2', 'Sí, permitir la personalización de los estilos CSS. ', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('1500109', '2', 'No, desactivar la personalización de los estilos CSS. ', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('1500110', '2', 'El número de entradas en el blog debe ser un número entre 1 y 999.', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('1500111', '2', 'Título ', 'admin_viewblogs');
INSERT INTO `se_languagevars` VALUES ('1500112', '2', 'No se encontraron entradas.', 'admin_viewblogs');
INSERT INTO `se_languagevars` VALUES ('1500113', '2', 'Se encontraron %1$d entradas en el blog', 'admin_viewblogs');
INSERT INTO `se_languagevars` VALUES ('1500114', '2', '¿Está seguro que desea eliminar esta entrada en el blog? ', 'admin_viewblogs');
INSERT INTO `se_languagevars` VALUES ('1500115', '2', 'Ver', 'admin_viewblogs');
INSERT INTO `se_languagevars` VALUES ('1500116', '2', 'Las entradas en el blog de todos los ususarios', 'browse_blogs');
INSERT INTO `se_languagevars` VALUES ('1500117', '2', 'Las entradas en el blog de mis amigos', 'browse_blogs');
INSERT INTO `se_languagevars` VALUES ('1500118', '2', 'Entrada en el blog:  %1$s', 'search');
INSERT INTO `se_languagevars` VALUES ('1500119', '2', 'Entrada en el blog publicada por <a href=\'%1$s\'>%2$s</a><br>%3$s', 'search');
INSERT INTO `se_languagevars` VALUES ('1500120', '2', ' %1$d entradas en el blog', 'search');
INSERT INTO `se_languagevars` VALUES ('1500121', '2', 'Ver todas las entradas ', 'blog');
INSERT INTO `se_languagevars` VALUES ('1500122', '2', '¿Desea eliminar la entrada en el blog?', 'user_blog');
INSERT INTO `se_languagevars` VALUES ('1500123', '2', 'Se ha producido un error al procesar su solicitud. ', '');
INSERT INTO `se_languagevars` VALUES ('1500124', '2', 'Blog de %1$s ', 'header_global');
INSERT INTO `se_languagevars` VALUES ('1500125', '2', 'Blog de %1$s - %2$s', 'header_global');
INSERT INTO `se_languagevars` VALUES ('1500126', '2', 'Los “trackbacks” o \"retroenlaces\" son una forma de notificar a otros blogs que usted ha creado un enlace con ellos. Añada las URLs de los trackbacks aquí, una por línea.', 'user_blog_entry');
INSERT INTO `se_languagevars` VALUES ('1500127', '2', 'Publicado %1$s', 'user_blog');
INSERT INTO `se_languagevars` VALUES ('1500128', '2', '[Crear] ', 'user_blog_entry');
INSERT INTO `se_languagevars` VALUES ('1500129', '2', 'Darse de baja', 'user_blog_subscriptions');
INSERT INTO `se_languagevars` VALUES ('1500130', '2', 'Editar la entrada en el blog', 'user_blog_entry');
INSERT INTO `se_languagevars` VALUES ('1500131', '2', 'En esta página se muestra una lista de todas las entradas que sus usuarios han publicado en el blog. Puede utilizar esta página para controlar estos blogs y eliminar material ofensivo, si es necesario.  La introducción de criterios en los campos del filtro le ayudará a encontrar entradas específicas en el blog.  Si se deja el filtro en blanco se mostrarán todas las entradas en el blog en su red social.', 'admin_viewblogs');
INSERT INTO `se_languagevars` VALUES ('1500132', '2', '¿Quién puede ver esta entrada?', 'user_blog_entry');
INSERT INTO `se_languagevars` VALUES ('1500133', '2', '¿Quién puede hacer un comentario en esta entrada?', 'user_blog_entry');
INSERT INTO `se_languagevars` VALUES ('1500134', '2', 'HTML en entradas en el blog ', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('1500135', '2', 'Si desea permitir etiquetas HTML específicas, puede introducirlas a continuación (separadas por comas).  Ejemplo: <i>b, img, a, incrustar, fuente<i>Ejemplo: <i> b, img, a, incrustar, fuente <i> ', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('1500136', '2', 'Trackbacks', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('1500137', '2', 'Los trackbacks permiten a los usuarios remotos utilizar el software para blogs para publicar una respuesta sobre el blog de un usuario.  Este será enviado a su servidor y se mostrará cuando se visualice la entrada en el blog como una respuesta. A su vez, al habilitar esta función permitirá a los usuarios locales enviar una respuesta a otros sitios de blogs mediante el suministro de una URL de un Trackback. ', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('1500138', '2', 'Sí, permitir a los usuarios remotos hacer un “trackback” a las entradas en el blog de este nivel de usuario.', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('1500139', '2', 'No, no permitir a los usuarios remotos hacer un trackback.', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('1500140', '2', 'Si ha habilitado los trackbacks, puede escanear el texto del cuerpo de las entradas en el blog, en busca de URLs para tratar de enviar un trackback.', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('1500141', '2', 'Sí, intentar detectar trackbacks en el texto del cuerpo de las entradas en el blog de este nivel de usuario. ', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('1500142', '2', 'No, no intentar detectar trackbacks.', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('1500143', '2', '¿Desea permitir la visualización y la creación de blogs?', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('1500144', '2', '¿Desea permitir a los usuarios ver los blogs? Si elige NO, algunas de las otras configuraciones en esta página no se aplicarán. ', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('1500145', '2', 'Sí, permitir la visualización y la suscripción de los blogs.', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('1500146', '2', 'No, no permitir la visualización del blog, como tampoco la suscripción al mismo. ', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('1500147', '2', '¿Desea permitir a los usuarios crear blogs? Si elige NO, algunas de las otras configuraciones en esta página no se aplicarán. Esto es útil si usted desea que los usuarios tengan la posibilidad de ver los blogs y gestionar sus suscripciones, pero sólo quiere que determinados niveles puedan crear blogs. ', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('1500148', '2', 'Sí, permitir la creación de blogs. ', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('1500149', '2', 'No, no permitir la creación de blogs.', 'admin_levels_blogsettings');
INSERT INTO `se_languagevars` VALUES ('2000001', '2', 'Configuración del grupo', '');
INSERT INTO `se_languagevars` VALUES ('2000002', '2', 'Ver grupos de usuarios', '');
INSERT INTO `se_languagevars` VALUES ('2000003', '2', 'Configuración del grupo global', '');
INSERT INTO `se_languagevars` VALUES ('2000004', '2', 'Configuración del grupo', '');
INSERT INTO `se_languagevars` VALUES ('2000005', '2', 'Correo electrónico de nueva invitación del grupo', '');
INSERT INTO `se_languagevars` VALUES ('2000006', '2', 'Este es el correo electrónico que se envía a un usuario cuando se lo invita a unirse a un grupo.', '');
INSERT INTO `se_languagevars` VALUES ('2000007', '2', 'Grupos', '');
INSERT INTO `se_languagevars` VALUES ('2000008', '2', 'Correo electrónico de nuevo comentario del grupo ', '');
INSERT INTO `se_languagevars` VALUES ('2000009', '2', 'Este es el correo electrónico que se envía a un usuario cuando se publica un nuevo comentario en el grupo que este lidera. ', '');
INSERT INTO `se_languagevars` VALUES ('2000010', '2', 'Correo electrónico de nuevo comentario sobre una fotografía del grupo ', '');
INSERT INTO `se_languagevars` VALUES ('2000011', '2', 'Este es el correo electrónico que se envía a un usuario cuando se publica un nuevo comentario sobre una fotografía del grupo que este lidera. ', '');
INSERT INTO `se_languagevars` VALUES ('2000012', '2', 'Correo electrónico de nueva solicitud de membresía para un grupo ', '');
INSERT INTO `se_languagevars` VALUES ('2000013', '2', 'Este es el correo electrónico que se envía a un usuario cuando alguien solicita la membresía para el grupo que este lidera. ', '');
INSERT INTO `se_languagevars` VALUES ('2000014', '2', 'Solo para los miembros del grupo, sus amigos y los amigos de sus amigos.', '');
INSERT INTO `se_languagevars` VALUES ('2000015', '2', 'Solo para los miembros del grupo y sus amigos. ', '');
INSERT INTO `se_languagevars` VALUES ('2000016', '2', 'Solo para los miembros del grupo y los amigos de los líderes del grupo.', '');
INSERT INTO `se_languagevars` VALUES ('2000017', '2', 'Sólo para los miembros del grupo', '');
INSERT INTO `se_languagevars` VALUES ('2000018', '2', 'Sólo para el líder del grupo', '');
INSERT INTO `se_languagevars` VALUES ('2000019', '2', 'El ancho y la altura de las fotos deben estar expresados por enteros entre 1 y 999.', '');
INSERT INTO `se_languagevars` VALUES ('2000020', '2', 'El campo del tamaño máximo del archivo debe contener un número entero entre 1 y 204800. ', '');
INSERT INTO `se_languagevars` VALUES ('2000021', '2', 'Los campos del ancho y la altura máximos de las fotos deben contener números enteros entre 1 y 9999.', '');
INSERT INTO `se_languagevars` VALUES ('2000022', '2', 'El campo de número máximo de álbumes permitidos debe contener un número entero entre 1 y 999. ', '');
INSERT INTO `se_languagevars` VALUES ('2000023', '2', 'Configuración del grupo de usuarios', '');
INSERT INTO `se_languagevars` VALUES ('2000024', '2', 'Si ha activado grupos de usuarios, los usuarios tendrán la opción de crear grupos e invitar a miembros.  Esta es una excelente manera de promover la interacción entre usuarios.  Utilice esta página para establecer la configuración de su grupo de usuarios. ', '');
INSERT INTO `se_languagevars` VALUES ('2000025', '2', '¿Desea permitir grupos de usuarios?', '');
INSERT INTO `se_languagevars` VALUES ('2000026', '2', 'Si ha elegido SÍ, sus usuarios tendrán la opción de crear y unirse a los grupos. Tenga en cuenta que si cambia de SÍ a NO, los usuarios perderán las membresías actuales que tienen en los grupos. ', '');
INSERT INTO `se_languagevars` VALUES ('2000027', '2', 'Sí, los usuarios pueden crear/unirse a grupos.', '');
INSERT INTO `se_languagevars` VALUES ('2000028', '2', 'No, los usuarios no pueden crear/unirse a grupos.', '');
INSERT INTO `se_languagevars` VALUES ('2000029', '2', '¿Desea permitir fotografías de los grupos?', '');
INSERT INTO `se_languagevars` VALUES ('2000030', '2', 'Si activa esta función, los usuarios pueden subir una pequeña fotografía icono cuando crean o editan un grupo. Esta se mostrará junto al nombre del grupo en los perfiles de los usuarios, en los resultados de la búsqueda/exploración, etc. ', '');
INSERT INTO `se_languagevars` VALUES ('2000031', '2', 'Sí, los usuarios pueden subir una fotografía ícono cuando crean/editan un grupo.', '');
INSERT INTO `se_languagevars` VALUES ('2000032', '2', 'No, los usuarios no pueden subir una fotografía ícono cuando crean/editan un grupo.', '');
INSERT INTO `se_languagevars` VALUES ('2000033', '2', 'Si ha seleccionado SÍ anteriormente, por favor, introduzca las dimensiones máximas para las fotografías del grupo.  Si sus usuarios suben una fotografía de mayores dimensiones que las especificadas, el servidor intentará reducir su tamaño automáticamente. Esta función requiere que su servidor PHP cuente con soporte para GD Libraries.', '');
INSERT INTO `se_languagevars` VALUES ('2000034', '2', '¿Qué tipos de archivo desea permitir para las fotografías del grupo (gif, jpg, jpeg o png)? Separe los tipos de archivo con comas, es decir, jpg, jpeg, gif, png. ', '');
INSERT INTO `se_languagevars` VALUES ('2000035', '2', 'Tipos de archivo permitidos:', '');
INSERT INTO `se_languagevars` VALUES ('2000036', '2', 'Opciones de privacidad del grupo', '');
INSERT INTO `se_languagevars` VALUES ('2000037', '2', 'Opciones de privacidad de la búsqueda', '');
INSERT INTO `se_languagevars` VALUES ('2000038', '2', 'Si habilita esta función, los líderes de los grupos podrán excluir a sus grupos de los resultados de la búsqueda.  De lo contrario, todos los grupos se incluirán en los resultados de la búsqueda.', '');
INSERT INTO `se_languagevars` VALUES ('2000039', '2', 'Sí, permitir a los líderes de los grupos excluir sus grupos de los resultados de la búsqueda.', '');
INSERT INTO `se_languagevars` VALUES ('2000040', '2', 'No, obligar a todos los grupos a incluirse en los resultados de la búsqueda.', '');
INSERT INTO `se_languagevars` VALUES ('2000041', '2', 'Privacidad general del grupo', '');
INSERT INTO `se_languagevars` VALUES ('2000042', '2', 'Los líderes de grupo pueden elegir entre cualquiera de las opciones a continuación, cuando deciden quienes pueden ver sus grupos.  Si no se elige opción alguna, todos los usuarios podrán ver los grupos.', '');
INSERT INTO `se_languagevars` VALUES ('2000043', '2', 'Opciones de comentarios del grupo', '');
INSERT INTO `se_languagevars` VALUES ('2000044', '2', 'Los líderes de grupo pueden elegir entre cualquiera de las opciones a continuación, cuando deciden quienes pueden publicar comentarios en sus grupos.  Si no se elige opción alguna, todos los usuarios podrán publicar comentarios en los grupos.', '');
INSERT INTO `se_languagevars` VALUES ('2000045', '2', 'Opciones de debate del grupo', '');
INSERT INTO `se_languagevars` VALUES ('2000046', '2', 'Los líderes de grupo pueden elegir entre cualquiera de las opciones a continuación, cuando deciden quienes pueden crear y publicar temas de debate en sus grupos. Si no se elige opción alguna, todos los usuarios podrán publicar temas de debate en los grupos.  ', '');
INSERT INTO `se_languagevars` VALUES ('2000047', '2', '¿Desea permitir los títulos de los miembros?', '');
INSERT INTO `se_languagevars` VALUES ('2000048', '2', 'Si elige SÍ, los propietarios/autoridades del grupo podrán dar a los miembros del grupo títulos especiales. (por ejemplo, \"Presidente\", \"Vicepresidente\", \"Tesorero\", etc.)', '');
INSERT INTO `se_languagevars` VALUES ('2000049', '2', 'Sí, permitir los títulos de los miembros.', '');
INSERT INTO `se_languagevars` VALUES ('2000050', '2', 'No, no permitir los títulos de los miembros. ', '');
INSERT INTO `se_languagevars` VALUES ('2000051', '2', '¿Desea permitir autoridades en los grupos?', '');
INSERT INTO `se_languagevars` VALUES ('2000052', '2', 'Si elige SÍ, los propietarios/autoridades del grupo podrán promover a los miembros del grupo a la categoría de “autoridades”. Las autoridades tienen todas las facultades de los propietarios del grupo, excepto la de remover al propietario del grupo. Nota: Si esta función se había configurado en SÍ y se la cambia a NO, toda autoridad existente dentro de los grupos recuperará automáticamente la categoría de simple miembro. ', '');
INSERT INTO `se_languagevars` VALUES ('2000053', '2', 'Sí, permitir autoridades en los grupos.', '');
INSERT INTO `se_languagevars` VALUES ('2000054', '2', 'No, no permitir autoridades en los grupos. ', '');
INSERT INTO `se_languagevars` VALUES ('2000055', '2', '¿Desea permitir la aprobación de los miembros?', '');
INSERT INTO `se_languagevars` VALUES ('2000056', '2', '¿Desea dar a los propietarios y autoridades la facultad de aprobar nuevos miembros?  Si elige Sí, los propietarios y las autoridades del grupo podrán activar la función “los miembros pueden ingresar al grupo sólo con aprobación”. Esto obliga a los posibles miembros a esperar su aprobación antes convertirse en miembros del grupo. ', '');
INSERT INTO `se_languagevars` VALUES ('2000057', '2', 'Sí, opcionalmente permitir la función de aprobación de miembros.  ', '');
INSERT INTO `se_languagevars` VALUES ('2000058', '2', 'No, no permitir la función de aprobación de miembros.  ', '');
INSERT INTO `se_languagevars` VALUES ('2000059', '2', '¿Desea permitir estilos CSS personalizados?', '');
INSERT INTO `se_languagevars` VALUES ('2000060', '2', 'Si habilita esta función, sus usuarios podrán personalizar los colores y las fuentes de sus grupos modificando sus estilos CSS.', '');
INSERT INTO `se_languagevars` VALUES ('2000061', '2', 'Sí, permitir la personalización de CSS. ', '');
INSERT INTO `se_languagevars` VALUES ('2000062', '2', 'No, no permitir la personalización de CSS. ', '');
INSERT INTO `se_languagevars` VALUES ('2000063', '2', 'Configuración del  archivo del grupo', '');
INSERT INTO `se_languagevars` VALUES ('2000064', '2', 'Confeccione una lista con las siguientes extensiones de archivo que los usuarios están autorizados a cargar. Separe las extensiones de archivo con comas, por ejemplo: jpg, gif, jpeg, png, bmp', '');
INSERT INTO `se_languagevars` VALUES ('2000065', '2', 'Para poder cargar un archivo, el mismo debe tener una extensión de archivo permitida, así como también un tipo MIME permitido.  Esto impide que los usuarios disfracen los archivos maliciosos con una extensión falsa. Separe los tipos MIME con comas, por ejemplo: image/jpeg, image/gif, image/png, image/bmp ', '');
INSERT INTO `se_languagevars` VALUES ('2000066', '2', '¿Cuánto espacio de almacenamiento deberá tener cada grupo para almacenar sus archivos? ', '');
INSERT INTO `se_languagevars` VALUES ('2000067', '2', 'Ilimitado', '');
INSERT INTO `se_languagevars` VALUES ('2000068', '2', 'Introduzca el tamaño de archivo máximo que se podrá cargar expresado en KB. Este debe ser un número entre 1 y 204800.', '');
INSERT INTO `se_languagevars` VALUES ('2000069', '2', 'Introduzca el ancho y la altura máximos (en píxeles) para las imágenes subidas a los grupos. Se reducirá el tamaño de las imágenes con dimensiones que excedan este rango si su servidor tiene instalada GD Libraries. Tenga en cuenta que los tipos de imágenes inusuales como BMP, TIFF, RAW, y otros no pueden ser redimensionados. ', '');
INSERT INTO `se_languagevars` VALUES ('2000070', '2', 'Número máximo de grupos permitido', '');
INSERT INTO `se_languagevars` VALUES ('2000071', '2', 'Introduzca el número máximo de grupos que cada usuario puede poseer. Este debe ser un número entero entre 1 y 999.', '');
INSERT INTO `se_languagevars` VALUES ('2000072', '2', 'Grupos permitidos', '');
INSERT INTO `se_languagevars` VALUES ('2000073', '2', 'Esta página contiene configuraciones de grupo generales que afectan a toda su red social.', '');
INSERT INTO `se_languagevars` VALUES ('2000074', '2', 'Seleccione si desea o no permitir al público (visitantes que no se han identificado) ver las siguientes secciones de su red social. En algunos casos (como en el de los perfiles, blogs y álbumes), si les ha ofrecido la opción, los usuarios podrán hacer sus páginas privadas a pesar de que usted las haya hecho públicamente visibles aquí. Para acceder a más configuraciones de permisos por favor visite la página <a href=\'admin_general.php\'>Configuración general</a>.  ', '');
INSERT INTO `se_languagevars` VALUES ('2000075', '2', 'Sí, el público puede ver los grupos, a menos que se hayan convertido en privados.', '');
INSERT INTO `se_languagevars` VALUES ('2000076', '2', 'No, el público no puede ver los grupos. ', '');
INSERT INTO `se_languagevars` VALUES ('2000077', '2', '¿Se exigirá a los usuarios introducir el código de verificación cuando inician o publican un tema de debate?', '');
INSERT INTO `se_languagevars` VALUES ('2000078', '2', 'Si ha seleccionado SÍ, los usuarios visualizarán una imagen que contiene una secuencia aleatoria de 6 números en las páginas “iniciar un tema” y “publicar respuesta a un tema”.  Los usuarios deberán introducir estos números en el campo del “Código de verificación” con el fin de publicar sus temas/respuestas. Esta aplicación ayuda a impedir que los usuarios traten de crear temas de debate no deseados (spam).  Para que esta aplicación funcione correctamente, su servidor debe tener GD Libraries (2.0 o superior) instalada y configurada para trabajar con PHP. Si observa errores, intente desactivarla.', '');
INSERT INTO `se_languagevars` VALUES ('2000079', '2', 'Sí, habilitar el código de verificación para los temas de debate.', '');
INSERT INTO `se_languagevars` VALUES ('2000080', '2', 'No, deshabilitar el código de verificación para los temas de debate.', '');
INSERT INTO `se_languagevars` VALUES ('2000081', '2', 'Categorías/campos de grupo', '');
INSERT INTO `se_languagevars` VALUES ('2000082', '2', 'Si lo desea, puede permitir a los usuarios clasificar sus grupos por tema, ubicación, etc. Los grupos clasificados facilitan a los usuarios la tarea de encontrar y unirse a grupos de su interés. Si desea permitir categorías de grupos, puede crearlas (junto con subcategorías) a continuación. <br><br>Dentro de cada categoría, usted puede crear campos de grupo. Cuando se crea un grupo, el creador del grupo (el propietario) describirá el grupo completando algunos campos con información sobre el mismo. Añada los campos que desee incluir a continuación.  Algunos ejemplos de campos de grupo son \"Ubicación\", \"Correo electrónico del grupo\", \"URL del sitio web\", etc. Recuerde que los campos \"Nombre del grupo\" y \"Descripción del grupo\" estarán siempre disponibles y serán obligatorios. Arrastre los iconos al lado de las categorías y los campos para reordenarlos. ', '');
INSERT INTO `se_languagevars` VALUES ('2000083', '2', 'Categorías de grupos', '');
INSERT INTO `se_languagevars` VALUES ('2000084', '2', 'Ver grupos creados por los usuarios', '');
INSERT INTO `se_languagevars` VALUES ('2000085', '2', 'En esta página se muestran todos los grupos que los usuarios han creado en su red social. Puede utilizar esta página para controlar estos grupos y eliminar el material ofensivo o no deseado, si es necesario.  La introducción de criterios en los campos del filtro le ayudará a encontrar grupos específicos.  Si se deja el filtro en blanco, se mostrarán todos los grupos existentes en su red social. ', '');
INSERT INTO `se_languagevars` VALUES ('2000086', '2', 'Líder ', '');
INSERT INTO `se_languagevars` VALUES ('2000087', '2', 'No se encontraron grupos.', '');
INSERT INTO `se_languagevars` VALUES ('2000088', '2', 'Se encontraron %1$d grupos', '');
INSERT INTO `se_languagevars` VALUES ('2000089', '2', 'Miembros', '');
INSERT INTO `se_languagevars` VALUES ('2000090', '2', 'Fecha de creación', '');
INSERT INTO `se_languagevars` VALUES ('2000091', '2', 'Ver', '');
INSERT INTO `se_languagevars` VALUES ('2000092', '2', '¿Desea eliminar el grupo?', '');
INSERT INTO `se_languagevars` VALUES ('2000093', '2', '¿Está seguro que desea eliminar este grupo? ', '');
INSERT INTO `se_languagevars` VALUES ('2000094', '2', 'Nombre del grupo ', '');
INSERT INTO `se_languagevars` VALUES ('2000095', '2', 'Crear un nuevo grupo', '');
INSERT INTO `se_languagevars` VALUES ('2000096', '2', 'Por favor, proporcione alguna información sobre su nuevo grupo. Después de haber creado su grupo, puede comenzar a invitar a otros usuarios a convertirse en miembros. ', '');
INSERT INTO `se_languagevars` VALUES ('2000097', '2', 'Detalles del grupo', '');
INSERT INTO `se_languagevars` VALUES ('2000098', '2', 'Descripción del grupo ', '');
INSERT INTO `se_languagevars` VALUES ('2000099', '2', 'Configuración del grupo', '');
INSERT INTO `se_languagevars` VALUES ('2000100', '2', 'Los nuevos miembros deben solicitar la aprobación para unirse. ', '');
INSERT INTO `se_languagevars` VALUES ('2000101', '2', 'Buscar miembros: %1$s', '');
INSERT INTO `se_languagevars` VALUES ('2000102', '2', 'Utilice esta página para hacer una lista o buscar miembros de un grupo. ', '');
INSERT INTO `se_languagevars` VALUES ('2000103', '2', 'Invitaciones pendientes', '');
INSERT INTO `se_languagevars` VALUES ('2000104', '2', '¿Desea incluir a este grupo en los resultados de la búsqueda/exploración?', '');
INSERT INTO `se_languagevars` VALUES ('2000105', '2', 'Sí, incluir a este grupo en los resultados de la búsqueda/exploración.', '');
INSERT INTO `se_languagevars` VALUES ('2000106', '2', 'No, excluir este grupo de los resultados de la búsqueda/exploración.', '');
INSERT INTO `se_languagevars` VALUES ('2000107', '2', '¿Quién puede ver este grupo?', '');
INSERT INTO `se_languagevars` VALUES ('2000108', '2', 'Usted puede decidir quién va a ver este grupo. ', '');
INSERT INTO `se_languagevars` VALUES ('2000109', '2', '¿Desea permitir comentarios?', '');
INSERT INTO `se_languagevars` VALUES ('2000110', '2', 'Usted puede decidir quién puede publicar comentarios en este grupo.  ', '');
INSERT INTO `se_languagevars` VALUES ('2000111', '2', '¿Desea permitir un foro de debate?', '');
INSERT INTO `se_languagevars` VALUES ('2000112', '2', 'Usted puede decidir quién puede crear y publicar temas de debate en este grupo.  ', '');
INSERT INTO `se_languagevars` VALUES ('2000113', '2', 'Añadir grupo ', '');
INSERT INTO `se_languagevars` VALUES ('2000114', '2', 'Usted ya ha creado el número máximo de grupos permitido. Para crear este nuevo grupo, usted debe dejar uno de los grupos que actualmente posee. ', '');
INSERT INTO `se_languagevars` VALUES ('2000115', '2', 'Por favor, introduzca un nombre para su grupo.', '');
INSERT INTO `se_languagevars` VALUES ('2000116', '2', 'Categoría del grupo', '');
INSERT INTO `se_languagevars` VALUES ('2000117', '2', 'Por favor, elija una categoría para este grupo.', '');
INSERT INTO `se_languagevars` VALUES ('2000118', '2', 'Miembros', '');
INSERT INTO `se_languagevars` VALUES ('2000119', '2', 'Configuración del grupo', '');
INSERT INTO `se_languagevars` VALUES ('2000120', '2', 'Volver a Mis grupos ', '');
INSERT INTO `se_languagevars` VALUES ('2000121', '2', 'Editar grupo: %1$s', '');
INSERT INTO `se_languagevars` VALUES ('2000122', '2', 'Todos los datos de este grupo se muestran a continuación y pueden ser modificados aquí mismo. ', '');
INSERT INTO `se_languagevars` VALUES ('2000123', '2', '¡Su grupo se ha creado con éxito!  Puede añadir una fotografía y editar los datos del grupo a continuación. ', '');
INSERT INTO `se_languagevars` VALUES ('2000124', '2', 'Fotografía del grupo', '');
INSERT INTO `se_languagevars` VALUES ('2000125', '2', 'Las imágenes deben tener un tamaño inferior a 4 MB y deben tener una de las siguientes extensiones: %1$s', '');
INSERT INTO `se_languagevars` VALUES ('2000126', '2', 'Explorar los grupos ', '');
INSERT INTO `se_languagevars` VALUES ('2000127', '2', 'Grupos de todos los usuarios', '');
INSERT INTO `se_languagevars` VALUES ('2000128', '2', 'Grupos de mis amigos ', '');
INSERT INTO `se_languagevars` VALUES ('2000129', '2', 'Más populares ', '');
INSERT INTO `se_languagevars` VALUES ('2000130', '2', 'Recientemente creados', '');
INSERT INTO `se_languagevars` VALUES ('2000131', '2', 'Todos los grupos ', '');
INSERT INTO `se_languagevars` VALUES ('2000132', '2', 'No se encontraron grupos que coincidan con sus criterios de búsqueda.', '');
INSERT INTO `se_languagevars` VALUES ('2000133', '2', '%1$d miembros, liderado por %2$s', '');
INSERT INTO `se_languagevars` VALUES ('2000134', '2', 'actualizado %1$s', '');
INSERT INTO `se_languagevars` VALUES ('2000135', '2', 'Configuración del grupo: %1$s', '');
INSERT INTO `se_languagevars` VALUES ('2000136', '2', 'Editar la configuración del grupo, como por ejemplo el estilo de sus grupos.', '');
INSERT INTO `se_languagevars` VALUES ('2000137', '2', 'Estilo del grupo  ', '');
INSERT INTO `se_languagevars` VALUES ('2000138', '2', 'Puede cambiar los colores, fuentes y estilos de su grupo añadiendo a continuación el código CSS.  El contenido del área de texto a continuación se mostrará entre las etiquetas &lt;style&gt; en su grupo.', '');
INSERT INTO `se_languagevars` VALUES ('2000139', '2', 'Aprobación de los miembros', '');
INSERT INTO `se_languagevars` VALUES ('2000140', '2', 'Cuando una persona intente unirse a este grupo, ¿se le permitirá ingresar de inmediato, o deberá esperar su aprobación?  La aprobación/reprobación de los miembros puede ser gestionada desde la página<a href=\'user_group_edit_members.php?group_id=%1$d\'>de los miembros</a>.', '');
INSERT INTO `se_languagevars` VALUES ('2000141', '2', 'Nota: Si desactiva la aprobación de miembros, todos los nuevos miembros en espera de su aprobación serán automáticamente aprobados. ', '');
INSERT INTO `se_languagevars` VALUES ('2000142', '2', 'Los nuevos miembros pueden unirse sin necesidad de aprobación. ', '');
INSERT INTO `se_languagevars` VALUES ('2000143', '2', '¿Desea incluir a este grupo en los resultados de la búsqueda/exploración?', '');
INSERT INTO `se_languagevars` VALUES ('2000144', '2', 'Sí, incluir a este grupo en los resultados de la búsqueda/exploración.', '');
INSERT INTO `se_languagevars` VALUES ('2000145', '2', 'No, excluir este grupo de los resultados de la búsqueda/exploración.', '');
INSERT INTO `se_languagevars` VALUES ('2000146', '2', '¿Quién puede ver este grupo?', '');
INSERT INTO `se_languagevars` VALUES ('2000147', '2', 'Usted puede decidir quienes van a ver este grupo. ', '');
INSERT INTO `se_languagevars` VALUES ('2000148', '2', '¿Desea permitir comentarios?', '');
INSERT INTO `se_languagevars` VALUES ('2000149', '2', 'Usted puede decidir quienes pueden publicar comentarios en este grupo.  ', '');
INSERT INTO `se_languagevars` VALUES ('2000150', '2', '¿Desea permitir un foro de debate?', '');
INSERT INTO `se_languagevars` VALUES ('2000151', '2', 'Usted puede decidir quienes pueden crear y publicar temas de debate en este grupo.  ', '');
INSERT INTO `se_languagevars` VALUES ('2000152', '2', 'Sólo el líder y las autoridades del grupo ', '');
INSERT INTO `se_languagevars` VALUES ('2000153', '2', 'Mis grupos', '');
INSERT INTO `se_languagevars` VALUES ('2000154', '2', 'A continuación se muestran todos los grupos a los que usted pertenece.<br> Para buscar nuevos grupos y unirse a ellos, visite la página <a href=\'browse_groups.php\'> Buscar grupos </a>. ', '');
INSERT INTO `se_languagevars` VALUES ('2000155', '2', 'Invitaciones a grupos (%1$s)', '');
INSERT INTO `se_languagevars` VALUES ('2000156', '2', 'No es miembro de ningún grupo. ', '');
INSERT INTO `se_languagevars` VALUES ('2000157', '2', '%1$d miembro(s), liderado por %2$s', '');
INSERT INTO `se_languagevars` VALUES ('2000158', '2', 'Ver grupo', '');
INSERT INTO `se_languagevars` VALUES ('2000159', '2', 'Editar grupo', '');
INSERT INTO `se_languagevars` VALUES ('2000160', '2', 'Dejar el grupo', '');
INSERT INTO `se_languagevars` VALUES ('2000161', '2', 'Ha dejado este grupo correctamente.', '');
INSERT INTO `se_languagevars` VALUES ('2000162', '2', 'Se ha unido a este grupo correctamente.', '');
INSERT INTO `se_languagevars` VALUES ('2000163', '2', 'Ha rechazado la invitación a unirse a este grupo correctamente.', '');
INSERT INTO `se_languagevars` VALUES ('2000164', '2', 'Ha solicitado unirse a este grupo. Una autoridad del grupo confirmará o rechazará su solicitud pronto. ', '');
INSERT INTO `se_languagevars` VALUES ('2000165', '2', 'Unirse a este grupo', '');
INSERT INTO `se_languagevars` VALUES ('2000166', '2', '¿Está seguro que desea dejar este grupo? ', '');
INSERT INTO `se_languagevars` VALUES ('2000167', '2', '<b> Nota:  Usted es actualmente el propietario de este grupo.  Si deja este grupo ahora, se eliminará todo el grupo. </b> Si desea dejar este grupo, sin que este sea eliminado, primero debe transferir su propiedad a otra persona en la <a href = \'user_group_edit_members.php? Group_id % 1 = $ d \'target =\' _parent \"> Página de los miembros </ a>. ', '');
INSERT INTO `se_languagevars` VALUES ('2000168', '2', '¿Está seguro que desea unirse a este grupo? ', '');
INSERT INTO `se_languagevars` VALUES ('2000169', '2', 'Miembros actuales', '');
INSERT INTO `se_languagevars` VALUES ('2000170', '2', 'Sólo autoridades', '');
INSERT INTO `se_languagevars` VALUES ('2000171', '2', 'Ver:', '');
INSERT INTO `se_languagevars` VALUES ('2000172', '2', 'Título del miembro', '');
INSERT INTO `se_languagevars` VALUES ('2000173', '2', 'Categoría del miembro', '');
INSERT INTO `se_languagevars` VALUES ('2000174', '2', 'Invitar nuevos miembros ', '');
INSERT INTO `se_languagevars` VALUES ('2000175', '2', 'Solicitudes de membresía', '');
INSERT INTO `se_languagevars` VALUES ('2000176', '2', 'No se encontraron miembros que coincidan con sus criterios de búsqueda.', '');
INSERT INTO `se_languagevars` VALUES ('2000177', '2', '¿Desea eliminar este grupo?', '');
INSERT INTO `se_languagevars` VALUES ('2000178', '2', 'Categoría de los miembros: %1$s', '');
INSERT INTO `se_languagevars` VALUES ('2000179', '2', 'Propietario', '');
INSERT INTO `se_languagevars` VALUES ('2000180', '2', 'Autoridad', '');
INSERT INTO `se_languagevars` VALUES ('2000181', '2', 'Miembro', '');
INSERT INTO `se_languagevars` VALUES ('2000182', '2', 'Categoría de los miembros: %1$s (%2$s)', '');
INSERT INTO `se_languagevars` VALUES ('2000183', '2', 'Última actualización:', '');
INSERT INTO `se_languagevars` VALUES ('2000184', '2', 'Editar los datos de los miembros ', '');
INSERT INTO `se_languagevars` VALUES ('2000185', '2', 'Eliminar un miembro ', '');
INSERT INTO `se_languagevars` VALUES ('2000186', '2', '¿Está seguro que desea eliminar el grupo \"%1$s\"?  Todo su contenido y todos sus miembros serán eliminados definitivamente. ', '');
INSERT INTO `se_languagevars` VALUES ('2000187', '2', 'Cuando una persona intente unirse a este grupo, ¿se le permitirá ingresar de inmediato, o deberá esperar su aprobación? ', '');
INSERT INTO `se_languagevars` VALUES ('2000188', '2', 'Otorgar la membresía', '');
INSERT INTO `se_languagevars` VALUES ('2000189', '2', 'Rechazar la solicitud ', '');
INSERT INTO `se_languagevars` VALUES ('2000190', '2', 'Cancelar la invitación ', '');
INSERT INTO `se_languagevars` VALUES ('2000191', '2', '¿Está seguro que desea eliminar este miembro del grupo? ', '');
INSERT INTO `se_languagevars` VALUES ('2000192', '2', 'Título del miembro:', '');
INSERT INTO `se_languagevars` VALUES ('2000193', '2', 'Categoría del miembro:', '');
INSERT INTO `se_languagevars` VALUES ('2000194', '2', 'Usted es actualmente el propietario del grupo.  Si desea transferir su propiedad a otro miembro, búsquelo en la página<a href=\'user_group_edit_members.php?group_id=%1$s\' target=\'_parent\'> Miembros del grupo</a> y edite su memebresía.  Cuando lo convierte en el propietario del grupo, usted adquiere la categoría de simple miembro del grupo. ', '');
INSERT INTO `se_languagevars` VALUES ('2000195', '2', '<b>Advertencia: </b> Usted está a punto de transferir la propiedad de este grupo a esta persona. ¿Está seguro que desea convertir a este miembro en el nuevo propietario del grupo?  ¡Usted adquirirá la categoría de simple miembro y será dado de baja del área de edición del grupo!   ', '');
INSERT INTO `se_languagevars` VALUES ('2000196', '2', 'Para invitar a un amigo a unirse a este grupo, marque la casilla junto a su nombre a continuación.  Recuerde que aunque este grupo esté configurado para ser visto \"sólo por los miembros\", las personas que usted invite podrán ver el grupo como si fueran miembros.  ', '');
INSERT INTO `se_languagevars` VALUES ('2000197', '2', '¡Las invitaciones se han enviado correctamente!', '');
INSERT INTO `se_languagevars` VALUES ('2000198', '2', 'Usted debe invitar a por lo menos un usuario a unirse a este grupo. ', '');
INSERT INTO `se_languagevars` VALUES ('2000199', '2', 'Seleccionar todos', '');
INSERT INTO `se_languagevars` VALUES ('2000200', '2', 'Deseleccionar todos', '');
INSERT INTO `se_languagevars` VALUES ('2000201', '2', 'Enviar invitaciones', '');
INSERT INTO `se_languagevars` VALUES ('2000202', '2', 'Usted no tiene amigos disponibles para formar parte de este grupo. ', '');
INSERT INTO `se_languagevars` VALUES ('2000203', '2', 'Aceptar/rechazar la invitación  ', '');
INSERT INTO `se_languagevars` VALUES ('2000204', '2', '¿Quiere aceptar o rechazar la invitación a unirse a este grupo? ', '');
INSERT INTO `se_languagevars` VALUES ('2000205', '2', 'Aceptar la invitación ', '');
INSERT INTO `se_languagevars` VALUES ('2000206', '2', 'Rechazar la invitación  ', '');
INSERT INTO `se_languagevars` VALUES ('2000207', '2', 'Usted debe esperar que alguna autoridad del grupo apruebe su solicitud de membresía.', '');
INSERT INTO `se_languagevars` VALUES ('2000208', '2', 'Opciones de carga del álbum del grupo ', '');
INSERT INTO `se_languagevars` VALUES ('2000209', '2', 'Los líderes de grupo pueden elegir entre cualquiera de las opciones a continuación, cuando deciden quienes pueden subir fotografías a su grupo.  Si no se elige opción alguna, todos los usuarios podrán subir fotografías a los grupos.', '');
INSERT INTO `se_languagevars` VALUES ('2000210', '2', 'Opciones de etiquetas del álbum del grupo ', '');
INSERT INTO `se_languagevars` VALUES ('2000211', '2', 'Los líderes de grupo pueden elegir entre cualquiera de las opciones a continuación, cuando deciden quienes pueden etiquetar fotografías en su grupo.  Si no se elige opción alguna, todos los usuarios podrán etiquetar fotografías en los grupos.', '');
INSERT INTO `se_languagevars` VALUES ('2000212', '2', '¿Desea permitir la carga de archivos?', '');
INSERT INTO `se_languagevars` VALUES ('2000213', '2', 'Usted puede decidir quién puede subir fotografías a este grupo.  ', '');
INSERT INTO `se_languagevars` VALUES ('2000214', '2', '¿Desea permitir el etiquetado de fotografías?', '');
INSERT INTO `se_languagevars` VALUES ('2000215', '2', 'Usted puede decidir quienes pueden etiquetar fotografías dentro de este grupo.  ', '');
INSERT INTO `se_languagevars` VALUES ('2000216', '2', '¿Desea permitir a los miembros del grupo invitar usuarios? ', '');
INSERT INTO `se_languagevars` VALUES ('2000217', '2', 'Sí, permitir a los miembros del grupo invitar a sus amigos a unirse al grupo. ', '');
INSERT INTO `se_languagevars` VALUES ('2000218', '2', 'No, sólo el líder y las autoridades del grupo podrán invitar usuarios a unirse al mismo. ', '');
INSERT INTO `se_languagevars` VALUES ('2000219', '2', 'El grupo que está buscando ha sido eliminado o no existe. ', '');
INSERT INTO `se_languagevars` VALUES ('2000220', '2', 'Miembros del grupo ', '');
INSERT INTO `se_languagevars` VALUES ('2000221', '2', 'Buscar miembros', '');
INSERT INTO `se_languagevars` VALUES ('2000222', '2', 'Ninguno de los miembros del grupo coincide con sus criterios de búsqueda.', '');
INSERT INTO `se_languagevars` VALUES ('2000223', '2', 'En espera de la aprobación de la membresía ', '');
INSERT INTO `se_languagevars` VALUES ('2000224', '2', 'Suscribirse al grupo ', '');
INSERT INTO `se_languagevars` VALUES ('2000225', '2', 'Darse de baja del grupo ', '');
INSERT INTO `se_languagevars` VALUES ('2000226', '2', 'Denunciar a este grupo', '');
INSERT INTO `se_languagevars` VALUES ('2000227', '2', 'Grupo privado', '');
INSERT INTO `se_languagevars` VALUES ('2000228', '2', 'No tiene autorización para ver este grupo. ', '');
INSERT INTO `se_languagevars` VALUES ('2000229', '2', 'Autoridades del grupo', '');
INSERT INTO `se_languagevars` VALUES ('2000230', '2', '(Líder)', '');
INSERT INTO `se_languagevars` VALUES ('2000231', '2', 'Detalles del grupo', '');
INSERT INTO `se_languagevars` VALUES ('2000232', '2', 'Fotografías', '');
INSERT INTO `se_languagevars` VALUES ('2000233', '2', 'Debates ', '');
INSERT INTO `se_languagevars` VALUES ('2000234', '2', '¿Está seguro que desea suscribirse a este grupo?  Una vez que se suscribe, recibirá notificaciones en su página “¿Qué novedades hay?” cada vez que un comentario, una fotografía, o un tema de debate se publica en este grupo. ', '');
INSERT INTO `se_languagevars` VALUES ('2000235', '2', 'Suscribirse', '');
INSERT INTO `se_languagevars` VALUES ('2000236', '2', '¿Está seguro que desea darse de baja de este grupo?  Usted dejará de recibir notificaciones en su página “¿Qué novedades hay?” cada vez que haya alguna actividad en este grupo. ', '');
INSERT INTO `se_languagevars` VALUES ('2000237', '2', 'Darse de baja', '');
INSERT INTO `se_languagevars` VALUES ('2000238', '2', 'Se ha suscrito a este grupo correctamente.', '');
INSERT INTO `se_languagevars` VALUES ('2000239', '2', 'Se ha dado de baja de este grupo correctamente.', '');
INSERT INTO `se_languagevars` VALUES ('2000240', '2', 'Suscripciones al grupo', '');
INSERT INTO `se_languagevars` VALUES ('2000241', '2', '%1$s nuevo(s) comentario(s)', '');
INSERT INTO `se_languagevars` VALUES ('2000242', '2', '%1$s nueva(s) entrada(s)', '');
INSERT INTO `se_languagevars` VALUES ('2000243', '2', '%1$s nueva(s) fotografía(s)', '');
INSERT INTO `se_languagevars` VALUES ('2000244', '2', 'No hay nuevas actualizaciones. ', '');
INSERT INTO `se_languagevars` VALUES ('2000245', '2', 'No hay ninguna actualización de grupo en este momento. ', '');
INSERT INTO `se_languagevars` VALUES ('2000246', '2', 'Para subir fotografías a este grupo desde su ordenador, haga clic en el botón “Explorar” (Browse), localice la fotografía en su ordenador y haga clic en el botón “Subir”. ', '');
INSERT INTO `se_languagevars` VALUES ('2000247', '2', 'Este grupo tiene %1$s MB de espacio libre disponible. ', '');
INSERT INTO `se_languagevars` VALUES ('2000248', '2', '%1$s fue cargado correctamente. ', '');
INSERT INTO `se_languagevars` VALUES ('2000249', '2', 'Usted puede subir archivos con tamaños de hasta %1$s KB y con las siguientes extensiones:  %2$s', '');
INSERT INTO `se_languagevars` VALUES ('2000250', '2', 'Este grupo no tiene espacio libre suficiente para cargar %1$s. ', '');
INSERT INTO `se_languagevars` VALUES ('2000251', '2', 'Añadir nuevas fotografías', '');
INSERT INTO `se_languagevars` VALUES ('2000252', '2', 'No se han añadido fotografías a este grupo todavía. ', '');
INSERT INTO `se_languagevars` VALUES ('2000253', '2', '¿Qué novedades hay?', '');
INSERT INTO `se_languagevars` VALUES ('2000254', '2', 'Información del grupo', '');
INSERT INTO `se_languagevars` VALUES ('2000255', '2', 'Descripción', '');
INSERT INTO `se_languagevars` VALUES ('2000256', '2', 'Categoría', '');
INSERT INTO `se_languagevars` VALUES ('2000257', '2', 'Temas de debate ', '');
INSERT INTO `se_languagevars` VALUES ('2000258', '2', 'Iniciar nuevo tema ', '');
INSERT INTO `se_languagevars` VALUES ('2000259', '2', 'No se ha iniciado ningún tema de debate en este grupo todavía. ', '');
INSERT INTO `se_languagevars` VALUES ('2000260', '2', '<div style=’font-size: 12pt;’>%1$s</div> respuestas', '');
INSERT INTO `se_languagevars` VALUES ('2000261', '2', '%1$s creado por <a href=’%2$s’>%3$s</a>', '');
INSERT INTO `se_languagevars` VALUES ('2000262', '2', '%1$s visitas', '');
INSERT INTO `se_languagevars` VALUES ('2000263', '2', '<a href=’%1$s’>Última entrada</a> hecha por <a href=’%2$s’>%3$s</a>', '');
INSERT INTO `se_languagevars` VALUES ('2000264', '2', 'Creada %1$s por %2$s', '');
INSERT INTO `se_languagevars` VALUES ('2000265', '2', '<a href=’%1$s’>Última entrada</a> hecha por %2$s', '');
INSERT INTO `se_languagevars` VALUES ('2000266', '2', 'Eliminar tema', '');
INSERT INTO `se_languagevars` VALUES ('2000267', '2', '¿Está seguro que desea eliminar este tema de debate? ', '');
INSERT INTO `se_languagevars` VALUES ('2000268', '2', 'descargar audio ', '');
INSERT INTO `se_languagevars` VALUES ('2000269', '2', 'descargar video ', '');
INSERT INTO `se_languagevars` VALUES ('2000270', '2', 'descargar este archivo ', '');
INSERT INTO `se_languagevars` VALUES ('2000271', '2', 'Está viendo #%1$d de %2$d en <a href=’%3$s’>%4$s</a>', '');
INSERT INTO `se_languagevars` VALUES ('2000272', '2', 'Último ', '');
INSERT INTO `se_languagevars` VALUES ('2000273', '2', 'Siguiente ', '');
INSERT INTO `se_languagevars` VALUES ('2000274', '2', 'En esta fotografía: ', '');
INSERT INTO `se_languagevars` VALUES ('2000275', '2', 'Añadir etiqueta ', '');
INSERT INTO `se_languagevars` VALUES ('2000276', '2', '%1$s subido por <a href=’%2$s’>%3$s</a>', '');
INSERT INTO `se_languagevars` VALUES ('2000277', '2', 'Subido %1$s', '');
INSERT INTO `se_languagevars` VALUES ('2000278', '2', 'Compartir esto', '');
INSERT INTO `se_languagevars` VALUES ('2000279', '2', 'Para compartir esta fotografía o incrustarla en otra página web, por favor, copie y pegue el código de su elección: ', '');
INSERT INTO `se_languagevars` VALUES ('2000280', '2', 'Enlace directo ', '');
INSERT INTO `se_languagevars` VALUES ('2000281', '2', 'HTML - Imagen incrustada', '');
INSERT INTO `se_languagevars` VALUES ('2000282', '2', 'HTML - Enlace del texto ', '');
INSERT INTO `se_languagevars` VALUES ('2000283', '2', 'Código UBB (para foros) ', '');
INSERT INTO `se_languagevars` VALUES ('2000284', '2', 'Cerrar ventana', '');
INSERT INTO `se_languagevars` VALUES ('2000285', '2', 'Editar los detalles de la fotografía ', '');
INSERT INTO `se_languagevars` VALUES ('2000286', '2', 'Eliminar fotografía', '');
INSERT INTO `se_languagevars` VALUES ('2000287', '2', '¿Está seguro que desea eliminar esta fotografía? ', '');
INSERT INTO `se_languagevars` VALUES ('2000288', '2', 'Introduzca un título y una descripción para esta fotografía en los campos a continuación. ', '');
INSERT INTO `se_languagevars` VALUES ('2000289', '2', 'Título:', '');
INSERT INTO `se_languagevars` VALUES ('2000290', '2', 'Descripción:', '');
INSERT INTO `se_languagevars` VALUES ('2000291', '2', '%1$d grupos', '');
INSERT INTO `se_languagevars` VALUES ('2000292', '2', 'Grupo: %1$s', '');
INSERT INTO `se_languagevars` VALUES ('2000293', '2', 'Fotografía del grupo: %1$s', '');
INSERT INTO `se_languagevars` VALUES ('2000294', '2', 'Tema de debate: %1$s', '');
INSERT INTO `se_languagevars` VALUES ('2000295', '2', '%1$s', '');
INSERT INTO `se_languagevars` VALUES ('2000296', '2', 'Medios publicados en <a href=’%1$s’>%2$s</a><br>%3$s', '');
INSERT INTO `se_languagevars` VALUES ('2000297', '2', 'Tema publicado en <a href=’%1$s’>%2$s</a><br>%3$s', '');
INSERT INTO `se_languagevars` VALUES ('2000298', '2', 'Por favor, introduzca un mensaje para publicar.', '');
INSERT INTO `se_languagevars` VALUES ('2000299', '2', 'Por favor, introduzca un asunto.', '');
INSERT INTO `se_languagevars` VALUES ('2000300', '2', 'Asunto', '');
INSERT INTO `se_languagevars` VALUES ('2000301', '2', 'Su mensaje', '');
INSERT INTO `se_languagevars` VALUES ('2000302', '2', 'Publicar el tema', '');
INSERT INTO `se_languagevars` VALUES ('2000303', '2', 'Volver al foro de debate  ', '');
INSERT INTO `se_languagevars` VALUES ('2000304', '2', 'Responder al tema ', '');
INSERT INTO `se_languagevars` VALUES ('2000305', '2', 'Convierta el tema en “pegajoso”', '');
INSERT INTO `se_languagevars` VALUES ('2000306', '2', 'Cerrar el tema', '');
INSERT INTO `se_languagevars` VALUES ('2000307', '2', 'Publicado en %1$s sobre %2$s', '');
INSERT INTO `se_languagevars` VALUES ('2000308', '2', 'Editar la entrada', '');
INSERT INTO `se_languagevars` VALUES ('2000309', '2', 'Eliminar la entrada', '');
INSERT INTO `se_languagevars` VALUES ('2000310', '2', 'Responder al tema:', '');
INSERT INTO `se_languagevars` VALUES ('2000311', '2', 'Publicar una respuesta', '');
INSERT INTO `se_languagevars` VALUES ('2000312', '2', '%1$s', '');
INSERT INTO `se_languagevars` VALUES ('2000313', '2', '%1$s', '');
INSERT INTO `se_languagevars` VALUES ('2000314', '2', '%1$s: %2$s', '');
INSERT INTO `se_languagevars` VALUES ('2000315', '2', '“Despegar” el tema', '');
INSERT INTO `se_languagevars` VALUES ('2000316', '2', 'Tema abierto', '');
INSERT INTO `se_languagevars` VALUES ('2000317', '2', 'Renombrar el tema ', '');
INSERT INTO `se_languagevars` VALUES ('2000318', '2', 'Renombrar/eliminar el tema', '');
INSERT INTO `se_languagevars` VALUES ('2000319', '2', 'Complete el formulario que está a continuación para renombrar/eliminar este tema.', '');
INSERT INTO `se_languagevars` VALUES ('2000320', '2', '¿Está seguro que desea eliminar esta entrada? ', '');
INSERT INTO `se_languagevars` VALUES ('2000321', '2', 'Esta entrada ha sido eliminada.', '');
INSERT INTO `se_languagevars` VALUES ('2000322', '2', 'Cita', '');
INSERT INTO `se_languagevars` VALUES ('2000323', '2', '%1$s dijo:', '');
INSERT INTO `se_languagevars` VALUES ('2000324', '2', 'Explorar los grupos ', '');
INSERT INTO `se_languagevars` VALUES ('2000325', '2', 'Explorar los grupos de nuestra red social. ', '');
INSERT INTO `se_languagevars` VALUES ('2000326', '2', '%1$s: Ver fotografía', '');
INSERT INTO `se_languagevars` VALUES ('2000327', '2', 'Una fotografía publicada en el grupo %1$s ', '');
INSERT INTO `se_languagevars` VALUES ('2000328', '2', 'Publicar nuevo tema ', '');
INSERT INTO `se_languagevars` VALUES ('2000329', '2', 'Publicar un nuevo tema para este grupo. ', '');
INSERT INTO `se_languagevars` VALUES ('2000330', '2', 'HTML en temas de debate ', '');
INSERT INTO `se_languagevars` VALUES ('2000331', '2', 'Por defecto, el usuario no puede introducir etiquetas HTML en los temas de debate. Si usted desea permitir etiquetas específicas, puede introducirlas a continuación (separadas por comas). Ejemplo: <i> b, img, a, incrustar, fuente <i> ', '');
INSERT INTO `se_languagevars` VALUES ('2000332', '2', 'Notificación al ser etiquetado en una fotografía del grupo ', '');
INSERT INTO `se_languagevars` VALUES ('2000333', '2', 'Este es el correo electrónico que se envía a un usuario cuando alguien lo etiqueta en una  fotografía del grupo.', '');
INSERT INTO `se_languagevars` VALUES ('2000334', '2', 'Correo electrónico sobre una etiqueta en la fotografía del grupo', '');
INSERT INTO `se_languagevars` VALUES ('2000335', '2', 'Este es el correo electrónico que se envía a un usuario cuando alguien etiqueta una de las fotografías del grupo que lidera.', '');
INSERT INTO `se_languagevars` VALUES ('2000336', '2', 'Correo electrónico sobre un nuevo tema de debate en el grupo', '');
INSERT INTO `se_languagevars` VALUES ('2000337', '2', 'Este es el correo electrónico que se envía a un usuario cuando se publica un nuevo tema de debate en el grupo que este lidera. ', '');
INSERT INTO `se_languagevars` VALUES ('2500001', '2', 'Configuración de la encuesta', '');
INSERT INTO `se_languagevars` VALUES ('2500002', '2', 'Ver encuestas', '');
INSERT INTO `se_languagevars` VALUES ('2500003', '2', 'Configuración global de la encuesta', '');
INSERT INTO `se_languagevars` VALUES ('2500004', '2', 'Configuración de la encuesta', '');
INSERT INTO `se_languagevars` VALUES ('2500005', '2', 'Encuestas', '');
INSERT INTO `se_languagevars` VALUES ('2500006', '2', 'Si ha permitido a los usuarios crear encuestas, puede modificar sus datos desde esta página.', 'admin_levels_pollsettings');
INSERT INTO `se_languagevars` VALUES ('2500007', '2', '¿Desea permitir las encuestas?', 'admin_levels_pollsettings');
INSERT INTO `se_languagevars` VALUES ('2500008', '2', '¿Desea permitir a los usuarios crear encuestas? Si elige NO, el resto de las configuraciones en esta página no se aplicarán.  ', 'admin_levels_pollsettings');
INSERT INTO `se_languagevars` VALUES ('2500009', '2', 'Sí, permitir a los usuarios crear encuestas.', 'admin_levels_pollsettings');
INSERT INTO `se_languagevars` VALUES ('2500010', '2', 'No, no permitir a los usuarios crear encuestas.', 'admin_levels_pollsettings');
INSERT INTO `se_languagevars` VALUES ('2500011', '2', 'Encuestas por página', 'admin_levels_pollsettings');
INSERT INTO `se_languagevars` VALUES ('2500012', '2', '¿Cuántas encuestas se mostrarán por página?  (Introduzca un número entre 1 y 999) ', 'admin_levels_pollsettings');
INSERT INTO `se_languagevars` VALUES ('2500013', '2', '%1$s encuestas por página', 'admin_levels_pollsettings');
INSERT INTO `se_languagevars` VALUES ('2500014', '2', 'Opciones de privacidad de las encuestas', 'admin_levels_pollsettings');
INSERT INTO `se_languagevars` VALUES ('2500015', '2', 'Opciones de privacidad de la búsqueda', 'admin_levels_pollsettings');
INSERT INTO `se_languagevars` VALUES ('2500016', '2', 'Si habilita esta función, los usuarios podrán excluir sus encuestas de los resultados de la búsqueda.  De lo contrario, todas las encuestas se incluirán en los resultados de la búsqueda.', 'admin_levels_pollsettings');
INSERT INTO `se_languagevars` VALUES ('2500017', '2', 'Sí, permitir a los usuarios excluir sus encuestas de los resultados de la búsqueda.', 'admin_levels_pollsettings');
INSERT INTO `se_languagevars` VALUES ('2500018', '2', 'No, exigir la inclusión de todas las encuestas en los resultados de la búsqueda.', 'admin_levels_pollsettings');
INSERT INTO `se_languagevars` VALUES ('2500019', '2', 'Privacidad de las encuestas', 'admin_levels_pollsettings');
INSERT INTO `se_languagevars` VALUES ('2500020', '2', 'Los usuarios pueden elegir entre cualquiera de las opciones a continuación, cuando deciden quienes pueden ver sus encuestas. Estas opciones aparecen en las páginas “Crear encuesta” y “Editar encuesta” de sus usuarios.  Si no se elige opción alguna, todos los usuarios podrán ver las encuestas.', 'admin_levels_pollsettings');
INSERT INTO `se_languagevars` VALUES ('2500021', '2', 'Opciones de comentarios sobre las encuestas', 'admin_levels_pollsettings');
INSERT INTO `se_languagevars` VALUES ('2500022', '2', 'Los usuarios pueden elegir entre cualquiera de las opciones a continuación, cuando deciden quienes pueden publicar comentarios sobre sus encuestas. Si no se elige opción alguna, todos los usuarios podrán publicar comentarios en las encuestas.', 'admin_levels_pollsettings');
INSERT INTO `se_languagevars` VALUES ('2500023', '2', 'Seleccione si desea o no permitir al público (visitantes que no se han identificado) ver las encuestas en su red social. Si les ha ofrecido la opción, los usuarios podrán decidir que sus encuestas sean de uso privado a pesar de que usted las haya hecho públicamente visibles aquí. Para acceder a más configuraciones de permisos, por favor visite la página Configuración general.', 'admin_poll');
INSERT INTO `se_languagevars` VALUES ('2500024', '2', 'Sí, el público visitante puede ver las encuestas si así lo permiten los creadores de las mismas. ', 'admin_poll');
INSERT INTO `se_languagevars` VALUES ('2500025', '2', 'No, el público no puede ver las encuestas. ', 'admin_poll');
INSERT INTO `se_languagevars` VALUES ('2500026', '2', 'Permitir a los usuarios crear encuestas incorpora algo más de interactividad y diversión a su red social. <br/> Para obtener más configuraciones relacionadas con las encuestas, vea la sección <a href=”admin_levels.php”> niveles de usuario </a>. ', 'admin_poll');
INSERT INTO `se_languagevars` VALUES ('2500027', '2', '<a href=”%2$s”>%1$s</a>de <a href=”%3$s”>encuestas</a>', 'poll, polls');
INSERT INTO `se_languagevars` VALUES ('2500028', '2', '%1$s votos', 'poll, polls, profile_poll, user_poll, user_poll_browse');
INSERT INTO `se_languagevars` VALUES ('2500029', '2', 'Creada en %1$s', 'poll, polls');
INSERT INTO `se_languagevars` VALUES ('2500030', '2', 'Votar', 'poll, polls');
INSERT INTO `se_languagevars` VALUES ('2500031', '2', 'o', 'poll, polls');
INSERT INTO `se_languagevars` VALUES ('2500032', '2', 'Ver resultados', 'poll, polls');
INSERT INTO `se_languagevars` VALUES ('2500033', '2', 'Volver a las encuestas de %1$s  ', 'poll, polls');
INSERT INTO `se_languagevars` VALUES ('2500034', '2', 'Volver a las opciones ', 'poll, polls');
INSERT INTO `se_languagevars` VALUES ('2500035', '2', 'Está viendo la encuesta %1$d de %2$d ', 'polls');
INSERT INTO `se_languagevars` VALUES ('2500036', '2', 'Está viendo las encuestas %1$d-%2$d de %3$d', 'polls');
INSERT INTO `se_languagevars` VALUES ('2500037', '2', 'Mis encuestas', 'user_poll, user_poll_browse, user_poll_delete, user_poll_edit');
INSERT INTO `se_languagevars` VALUES ('2500038', '2', 'Explorar otras encuestas', 'user_poll, user_poll_browse, user_poll_delete, user_poll_edit');
INSERT INTO `se_languagevars` VALUES ('2500039', '2', 'Todas las encuestas que ha creado en el pasado pueden administrarse desde aquí. ', 'user_poll');
INSERT INTO `se_languagevars` VALUES ('2500040', '2', 'Crear una nueva encuesta', 'user_poll');
INSERT INTO `se_languagevars` VALUES ('2500041', '2', 'Buscar en mis encuestas ', 'user_poll');
INSERT INTO `se_languagevars` VALUES ('2500042', '2', 'Buscar en mis encuestas lo siguiente:', 'user_poll');
INSERT INTO `se_languagevars` VALUES ('2500043', '2', 'No se encontraron encuestas que coincidan con sus criterios de búsqueda.', 'user_poll, user_poll_browse');
INSERT INTO `se_languagevars` VALUES ('2500044', '2', 'Usted actualmente no tiene ninguna encuesta. <a href=”user_poll_new.php”>Haga clic aquí</a> ¡para crear una!', 'user_poll');
INSERT INTO `se_languagevars` VALUES ('2500045', '2', 'Nombre de la encuesta', 'user_poll');
INSERT INTO `se_languagevars` VALUES ('2500046', '2', 'Encuesta abierta', 'user_poll');
INSERT INTO `se_languagevars` VALUES ('2500047', '2', 'Encuesta cerrada', 'user_poll');
INSERT INTO `se_languagevars` VALUES ('2500048', '2', 'Eliminar la encuesta', 'user_poll');
INSERT INTO `se_languagevars` VALUES ('2500049', '2', 'Explorar encuestas', 'user_poll_browse');
INSERT INTO `se_languagevars` VALUES ('2500050', '2', 'Echar un vistazo a algunas de las encuestas que otras personas han creado. ', 'user_poll_browse');
INSERT INTO `se_languagevars` VALUES ('2500051', '2', 'Buscar en mis encuestas lo siguiente:', 'user_poll_browse');
INSERT INTO `se_languagevars` VALUES ('2500052', '2', 'La más reciente', 'user_poll_browse');
INSERT INTO `se_languagevars` VALUES ('2500053', '2', 'La más votada', 'user_poll_browse');
INSERT INTO `se_languagevars` VALUES ('2500054', '2', 'No se encontraron encuestas. <a href=”user_poll_new.php”>Haga clic aquí</a> ¡para crear una!', 'user_poll_browse');
INSERT INTO `se_languagevars` VALUES ('2500055', '2', '¿Desea eliminar la encuesta?', 'user_poll');
INSERT INTO `se_languagevars` VALUES ('2500056', '2', '¿Está seguro que desea eliminar esta encuesta? ', 'user_poll, admin_viewpolls');
INSERT INTO `se_languagevars` VALUES ('2500057', '2', 'Editar encuesta', 'user_poll_edit');
INSERT INTO `se_languagevars` VALUES ('2500058', '2', 'Editar los datos de esta encuesta a continuación. ', 'user_poll_edit');
INSERT INTO `se_languagevars` VALUES ('2500059', '2', 'Título:', 'user_poll_edit, user_poll_new');
INSERT INTO `se_languagevars` VALUES ('2500060', '2', 'Descripción:', 'user_poll_edit, user_poll_new');
INSERT INTO `se_languagevars` VALUES ('2500061', '2', 'Mostrar la configuración de privacidad ', 'user_poll_edit, user_poll_new');
INSERT INTO `se_languagevars` VALUES ('2500062', '2', '¿Desea incluir esta encuesta en los resultados de la búsqueda?', 'user_poll_edit, user_poll_new');
INSERT INTO `se_languagevars` VALUES ('2500063', '2', 'Sí, incluir esta encuesta en los resultados de la búsqueda.', 'user_poll_edit, user_poll_new');
INSERT INTO `se_languagevars` VALUES ('2500064', '2', 'No, excluir esta encuesta en los resultados de la búsqueda.', 'user_poll_edit, user_poll_new');
INSERT INTO `se_languagevars` VALUES ('2500065', '2', '¿Quienes pueden ver esta encuesta?', 'user_poll_edit, user_poll_new');
INSERT INTO `se_languagevars` VALUES ('2500066', '2', '¿quienes pueden hacer un comentario sobre esta encuesta?', 'user_poll_edit, user_poll_new');
INSERT INTO `se_languagevars` VALUES ('2500067', '2', 'Esta encuesta se ha abierto para la votación. ', 'user_poll_edit');
INSERT INTO `se_languagevars` VALUES ('2500068', '2', 'Esta encuesta se ha cerrado para la votación.  Nadie podrá votar en esta, a menos que la misma se reabra. ', 'user_poll_edit');
INSERT INTO `se_languagevars` VALUES ('2500069', '2', 'Datos de la encuesta', 'user_poll_edit, user_poll_edit_comments');
INSERT INTO `se_languagevars` VALUES ('2500070', '2', 'Volver a Mis encuestas ', 'user_poll_edit, user_poll_edit_comments');
INSERT INTO `se_languagevars` VALUES ('2500071', '2', 'Comentarios sobre la encuesta:', 'user_poll_edit_comments');
INSERT INTO `se_languagevars` VALUES ('2500072', '2', 'Los comentarios sobre esta encuesta a continuación fueron escritos por otras personas.  Para eliminar los comentarios, haga clic en sus casillas de verificación y, a continuación, haga clic en el botón “Eliminar seleccionados” debajo de la lista de comentarios. ', 'user_poll_edit_comments');
INSERT INTO `se_languagevars` VALUES ('2500073', '2', 'ver comentarios %1$d-%2$d de %3$d', 'user_poll_edit_comments');
INSERT INTO `se_languagevars` VALUES ('2500074', '2', 'No se han publicado comentarios sobre esta encuesta. ', 'user_poll_edit_comments');
INSERT INTO `se_languagevars` VALUES ('2500075', '2', 'Crear una nueva encuesta', 'user_poll_new');
INSERT INTO `se_languagevars` VALUES ('2500076', '2', 'Déle a su nueva encuesta un título y una descripción. Si está haciendo una pregunta con esta encuesta, debería ponerla en su título. ', 'user_poll_new');
INSERT INTO `se_languagevars` VALUES ('2500077', '2', 'Crear encuesta', 'user_poll_new');
INSERT INTO `se_languagevars` VALUES ('2500078', '2', 'Opciones de la encuesta:', 'user_poll_new');
INSERT INTO `se_languagevars` VALUES ('2500079', '2', 'Opción', 'user_poll_new');
INSERT INTO `se_languagevars` VALUES ('2500080', '2', 'Añadir una opción', 'user_poll_new');
INSERT INTO `se_languagevars` VALUES ('2500081', '2', 'Crear encuesta', 'user_poll_new');
INSERT INTO `se_languagevars` VALUES ('2500082', '2', 'Título ', 'admin_viewpolls');
INSERT INTO `se_languagevars` VALUES ('2500083', '2', 'Creador ', 'admin_viewpolls');
INSERT INTO `se_languagevars` VALUES ('2500084', '2', 'Se encontraron %1$d encuestas', 'admin_viewpolls');
INSERT INTO `se_languagevars` VALUES ('2500085', '2', 'Votos ', 'admin_viewpolls');
INSERT INTO `se_languagevars` VALUES ('2500086', '2', 'Creada', 'admin_viewpolls');
INSERT INTO `se_languagevars` VALUES ('2500087', '2', 'Opciones', 'admin_viewpolls');
INSERT INTO `se_languagevars` VALUES ('2500088', '2', 'Ver', 'admin_viewpolls');
INSERT INTO `se_languagevars` VALUES ('2500089', '2', 'El campo de encuestas por página debe contener un número entero entre 1 y 999. ', 'admin_levels_pollsettings');
INSERT INTO `se_languagevars` VALUES ('2500090', '2', 'Se ha producido un error al intentar votar en esta encuesta. ', 'poll_vote');
INSERT INTO `se_languagevars` VALUES ('2500091', '2', 'Usted debe ser un usuario registrado para votar en esta encuesta. ', 'poll_vote');
INSERT INTO `se_languagevars` VALUES ('2500092', '2', 'Por favor, elija una opción antes de votar. ', 'poll_vote');
INSERT INTO `se_languagevars` VALUES ('2500093', '2', 'Ya ha votado en esta encuesta. ', 'poll_vote');
INSERT INTO `se_languagevars` VALUES ('2500094', '2', 'Lo sentimos, esta encuesta se ha cerrado para la votación. ', 'poll_vote');
INSERT INTO `se_languagevars` VALUES ('2500095', '2', 'Ver comentarios %1$d de %2$d ', 'user_poll_edit_comments');
INSERT INTO `se_languagevars` VALUES ('2500096', '2', 'Seleccionar todos los comentarios', 'user_poll_edit_comments');
INSERT INTO `se_languagevars` VALUES ('2500098', '2', 'Usted no puede crear más de veinte opciones.', 'user_poll_new');
INSERT INTO `se_languagevars` VALUES ('2500099', '2', 'En esta página se muestran todas las encuestas que los usuarios han creado en su red social. Puede utilizar esta página para controlar estas encuestas y eliminar el material ofensivo o no deseado, si es necesario.  La introducción de criterios en los campos del filtro le ayudará a encontrar encuestas específicas. Si se deja el filtro en blanco, se mostrarán todas las encuestas existentes en su red social. ', 'admin_viewpolls');
INSERT INTO `se_languagevars` VALUES ('2500100', '2', 'Explorar encuestas', 'browse_polls');
INSERT INTO `se_languagevars` VALUES ('2500101', '2', 'Ver:', 'browse_polls');
INSERT INTO `se_languagevars` VALUES ('2500102', '2', 'Ordenar: ', 'browse_polls');
INSERT INTO `se_languagevars` VALUES ('2500103', '2', 'Las encuestas de todos los usuarios', 'browse_polls');
INSERT INTO `se_languagevars` VALUES ('2500104', '2', 'Las encuestas de mis amigos', 'browse_polls');
INSERT INTO `se_languagevars` VALUES ('2500105', '2', 'Recientemente creadas', 'browse_polls');
INSERT INTO `se_languagevars` VALUES ('2500106', '2', 'La más votada', 'browse_polls');
INSERT INTO `se_languagevars` VALUES ('2500107', '2', 'La más visitada', 'browse_polls');
INSERT INTO `se_languagevars` VALUES ('2500108', '2', '%1$s creada por <a href=”%2$s”>%3$s</a>', 'browse_polls');
INSERT INTO `se_languagevars` VALUES ('2500109', '2', 'HTML en las encuestas ', 'admin_poll');
INSERT INTO `se_languagevars` VALUES ('2500110', '2', 'De forma predeterminada, el usuario no podrá añadir ninguna etiqueta HTML en la descripción de una encuesta o en las etiquetas de opción. Si desea permitir etiquetas específicas, puede introducirlas a continuación (separadas por comas).  Ejemplo: a, b, br, font, i, img, hr', 'admin_poll');
INSERT INTO `se_languagevars` VALUES ('2500111', '2', '%1$d encuestas', 'search');
INSERT INTO `se_languagevars` VALUES ('2500112', '2', 'Encuesta: %1$s', 'search');
INSERT INTO `se_languagevars` VALUES ('2500113', '2', 'Encuesta creada por <a href=’%1$s’>%2$s</a><br>%3$s', 'search');
INSERT INTO `se_languagevars` VALUES ('2500114', '2', 'Se ha producido un error al procesar su solicitud. ', 'poll_ajax');
INSERT INTO `se_languagevars` VALUES ('2500115', '2', 'Por favor, espere hasta que la operación anterior se complete para recién iniciar otra. ', 'poll_ajax');
INSERT INTO `se_languagevars` VALUES ('2500116', '2', 'Creada:', 'user_poll');
INSERT INTO `se_languagevars` VALUES ('2500117', '2', 'Visitas:', 'user_poll');
INSERT INTO `se_languagevars` VALUES ('2500118', '2', 'Votos:', 'user_poll');
INSERT INTO `se_languagevars` VALUES ('2500119', '2', 'Comentarios:', 'user_poll');
INSERT INTO `se_languagevars` VALUES ('2500120', '2', 'Puede ser vista por:', 'user_poll');
INSERT INTO `se_languagevars` VALUES ('2500121', '2', 'Ver encuesta', 'user_poll');
INSERT INTO `se_languagevars` VALUES ('2500122', '2', '%1$d visitas', 'user_poll');
INSERT INTO `se_languagevars` VALUES ('2500123', '2', 'Por favor, proporcione un título para esta nueva encuesta. ', 'user_poll_new');
INSERT INTO `se_languagevars` VALUES ('2500124', '2', 'Por favor, proporcione al menos dos opciones posibles para esta encuesta. ', 'user_poll_new');
INSERT INTO `se_languagevars` VALUES ('2500126', '2', 'Nuevo comentario sobre la encuesta enviado por correo electrónico', '');
INSERT INTO `se_languagevars` VALUES ('2500127', '2', 'Este es el correo electrónico que se envía a un usuario cuando se publica un nuevo comentario sobre una de sus encuestas', '');
INSERT INTO `se_languagevars` VALUES ('3000001', '2', 'Configuración del evento', '');
INSERT INTO `se_languagevars` VALUES ('3000002', '2', 'Ver eventos', '');
INSERT INTO `se_languagevars` VALUES ('3000003', '2', 'Configuración general del evento', '');
INSERT INTO `se_languagevars` VALUES ('3000004', '2', 'Configuración del evento', '');
INSERT INTO `se_languagevars` VALUES ('3000005', '2', 'Nueva invitación para el evento enviada por correo electrónico', '');
INSERT INTO `se_languagevars` VALUES ('3000006', '2', 'Este es el correo electrónico que se envía a un usuario cuando se lo invita a un evento.', '');
INSERT INTO `se_languagevars` VALUES ('3000007', '2', 'Eventos', '');
INSERT INTO `se_languagevars` VALUES ('3000008', '2', 'Nuevo comentario en el evento enviado por correo electrónico', '');
INSERT INTO `se_languagevars` VALUES ('3000009', '2', 'Este es el correo electrónico que se envía a un usuario cuando se publica un comentario sobre un evento que este ha creado. ', '');
INSERT INTO `se_languagevars` VALUES ('3000010', '2', 'Nuevo comentario en la fotografía del evento enviado por correo electrónico', '');
INSERT INTO `se_languagevars` VALUES ('3000011', '2', 'Este es el correo electrónico que se envía a un usuario cuando se publica un comentario sobre una fotografía de un evento que este ha creado. ', '');
INSERT INTO `se_languagevars` VALUES ('3000012', '2', '%1$d nueva solicitud de invitación para el evento enviada por correo electrónico:', '');
INSERT INTO `se_languagevars` VALUES ('3000013', '2', 'Este es el correo electrónico que se envía a un usuario cuando alguien solicita una invitación para un evento que este ha creado. ', '');
INSERT INTO `se_languagevars` VALUES ('3000014', '2', 'Solo para los usuarios invitados, sus amigos y los amigos de sus amigos.', '');
INSERT INTO `se_languagevars` VALUES ('3000015', '2', 'Solo para los usuarios invitados y sus amigos. ', '');
INSERT INTO `se_languagevars` VALUES ('3000016', '2', 'Solo para los usuarios invitados y los amigos del creador del evento. ', '');
INSERT INTO `se_languagevars` VALUES ('3000017', '2', 'Solo para usuarios invitados', '');
INSERT INTO `se_languagevars` VALUES ('3000018', '2', 'Solo para el creador del evento', '');
INSERT INTO `se_languagevars` VALUES ('3000019', '2', 'Configuración general del evento', 'admin_event');
INSERT INTO `se_languagevars` VALUES ('3000020', '2', 'Esta página contiene configuraciones generales de un evento que afectan a toda su red social.', 'admin_event');
INSERT INTO `se_languagevars` VALUES ('3000021', '2', 'Seleccione si desea o no permitir al público (visitantes que no se han identificado) ver las siguientes secciones de su red social. En algunos casos (como en el de los perfiles, blogs y álbumes), si les ha ofrecido la opción, los usuarios podrán hacer sus páginas privadas a pesar de que usted las haya hecho públicamente visibles aquí. Para acceder a más configuraciones de permisos por favor visite la página <a href=’admin_general.php’>Configuración general</a>.', 'admin_event');
INSERT INTO `se_languagevars` VALUES ('3000022', '2', 'Sí, el público puede ver los eventos, a menos que se hayan convertido en privados.', 'admin_event');
INSERT INTO `se_languagevars` VALUES ('3000023', '2', 'No, el público no puede ver los eventos. ', 'admin_event');
INSERT INTO `se_languagevars` VALUES ('3000024', '2', 'Categorías/campos del evento', 'admin_event');
INSERT INTO `se_languagevars` VALUES ('3000025', '2', 'Si lo desea, puede permitir a los usuarios clasificar sus eventos por tema, ubicación, etc. Si usted desea permitir categorías de eventos, puede crearlas (junto con subcategorías) a continuación. <br/> <br/> Dentro de cada categoría, usted puede crear campos. Cuando se crea un evento , el creador (el propietario) describirá el evento completando algunos campos con información sobre el evento. Añada los campos que desee incluir a continuación. Recuerde que los campos de “Título del evento ” y “Descripción del evento” estarán siempre disponibles y serán obligatorios. Arrastre los iconos junto a las categorías y a los campos para reordenarlos. ', 'admin_event');
INSERT INTO `se_languagevars` VALUES ('3000026', '2', 'Categorías de eventos', 'admin_event');
INSERT INTO `se_languagevars` VALUES ('3000027', '2', 'El ancho y la altura de las fotos deben estar expresados por enteros entre 1 y 999.', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000028', '2', 'El campo del tamaño máximo del archivo debe contener un número entero entre 1 y 204800. ', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000029', '2', 'Los campos del ancho y la altura máximos de las fotos deben contener números enteros entre 1 y 9999.', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000030', '2', 'Si ha habilitado los eventos, los usuarios tendrán la opción de crear eventos e invitar a miembros. Utilice esta página para establecer la configuración de sus eventos. ', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000031', '2', '¿Desea permitir eventos?', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000038', '2', '¿Desea permitir fotografías de los eventos?', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000039', '2', 'Si activa esta función, los usuarios pueden subir una pequeña fotografía icono cuando crean o editan un evento. Esta se mostrará junto al nombre del evento en los perfiles de los usuarios, en los resultados de la búsqueda/exploración, etc.', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000040', '2', 'Sí, los usuarios pueden subir una fotografía ícono cuando crean/editan un evento.', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000041', '2', 'No, los usuarios no pueden subir una fotografía ícono cuando crean/editan un evento.', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000042', '2', 'Si ha seleccionado SÍ anteriormente, por favor, introduzca las dimensiones máximas para las fotografías de los eventos. Si sus usuarios suben una fotografía de mayores dimensiones que las especificadas, el servidor intentará reducir su tamaño automáticamente. Esta función requiere que su servidor PHP cuente con soporte para GD Libraries.', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000043', '2', 'Ancho máximo:', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000044', '2', 'Altura máxima:', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000045', '2', '(en píxeles, entre %1$d y %1$d)', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000046', '2', '¿Qué tipos de archivo desea permitir para las fotografías de eventos? Separe los tipos de archivo con comas, es decir, jpg, jpeg, gif, png', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000047', '2', 'Tipos de archivo permitidos:', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000048', '2', 'Opciones de privacidad del evento', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000049', '2', '<b> Buscar opciones de privacidad</b> <br> Si habilita esta función, los líderes del evento podrán excluir sus eventos de los resultados de la búsqueda. De lo contrario, todos los eventos se incluirán en los resultados de la búsqueda.', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000050', '2', 'Sí, permitir a los líderes de los eventos excluir sus eventos de los resultados de la búsqueda.', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000051', '2', 'No, exigir que se  incluyan todos los eventos en los resultados de la búsqueda.', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000052', '2', '<b>Privacidad general del evento</b><br>Los líderes de grupo pueden elegir entre cualquiera de las opciones a continuación, cuando deciden quienes pueden ver sus eventos.  Si no se elige opción alguna, todos los usuarios podrán ver los eventos.', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000053', '2', '<b>Opciones de los comentarios en el evento</b><br>Los creadores del evento pueden elegir entre cualquiera de las opciones mostradas a continuación, cuando deciden quienes pueden publicar comentarios en sus eventos. Si no se elige opción alguna, todos los usuarios podrán publicar comentarios en los eventos.', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000054', '2', '¿Desea permitir eventos solo para invitados?', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000055', '2', '¿Desea dar a los propietarios y autoridades la facultad de crear eventos solo para invitados?  Si elige SÍ, los creadores de los eventos podrán configurar los eventos como “solo para invitados”. Esto significa que solo los usuarios invitados podrán confirmar asistencia (RSVP) al evento y que aquellos que no han sido invitados deberán solicitar una invitación.', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000056', '2', 'Sí, opcionalmente permitir eventos solo para invitados.  ', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000057', '2', 'No, no permitir eventos solo para invitados.  ', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000058', '2', '¿Desea permitir estilos CSS personalizados?', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000059', '2', 'Si habilita esta función, sus usuarios podrán personalizar los colores y las fuentes de sus eventos modificando sus estilos CSS.', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000060', '2', 'Sí, permitir la personalización de CSS. ', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000061', '2', 'No, no permitir la personalización de CSS. ', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000062', '2', 'Configuración del  archivo del evento', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000063', '2', 'Confeccione una lista con las siguientes extensiones de archivo que los usuarios están autorizados a cargar. Separe las extensiones de archivo con comas, por ejemplo: jpg, gif, jpeg, png, bmp', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000064', '2', 'Para poder cargar un archivo, el archivo debe tener una extensión de archivo permitida, así como también un tipo MIME permitido.  Esto impide que los usuarios disfracen los archivos maliciosos con una extensión falsa. Separe los tipos MIME con comas, por ejemplo: image/jpeg, image/gif, image/png, image/bmp', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000065', '2', '¿Cuánto espacio de almacenamiento deberá tener cada evento para almacenar sus archivos? ', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000066', '2', 'Ilimitado', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000067', '2', 'Introduzca el tamaño de archivo máximo que se podrá cargar expresado en KB. Este debe ser un número entre 1 y 204800.', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000068', '2', 'Introduzca el ancho y la altura máximos (en píxeles) para las imágenes subidas a los eventos.  Se reducirá el tamaño de las imágenes con dimensiones que excedan este rango si su servidor tiene instalada GD Libraries.  Tenga en cuenta que los tipos de imágenes inusuales como BMP, TIFF, RAW, y otros no pueden ser redimensionados. ', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000069', '2', '%1$s B', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000070', '2', '%1$s KB', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000071', '2', '%1$s MB', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000072', '2', '%1$s GB', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000073', '2', 'En esta página se muestran todos los eventos que los usuarios han creado en su red social. Puede utilizar esta página para controlar estos eventos y eliminar el material ofensivo o no deseado, si es necesario.  La introducción de criterios en los campos del filtro le ayudará a encontrar eventos específicos.  Si se dejan los campos del filtro en blanco, se mostrarán todos los eventos existentes en su red social. ', 'admin_viewevents');
INSERT INTO `se_languagevars` VALUES ('3000074', '2', 'Título ', 'admin_viewevents');
INSERT INTO `se_languagevars` VALUES ('3000075', '2', 'Creador ', 'admin_viewevents');
INSERT INTO `se_languagevars` VALUES ('3000076', '2', 'Se encontraron %1$d eventos', 'admin_viewevents');
INSERT INTO `se_languagevars` VALUES ('3000077', '2', 'Ver', 'admin_viewevents');
INSERT INTO `se_languagevars` VALUES ('3000078', '2', '¿Está seguro que desea eliminar este evento? ', 'admin_viewevents');
INSERT INTO `se_languagevars` VALUES ('3000079', '2', 'No se encontraron eventos.', 'admin_viewevents');
INSERT INTO `se_languagevars` VALUES ('3000080', '2', 'En espera de la aprobación ', 'event, user_event');
INSERT INTO `se_languagevars` VALUES ('3000081', '2', 'En espera de la respuesta ', 'event, user_event');
INSERT INTO `se_languagevars` VALUES ('3000082', '2', 'Asistiré', 'event, user_event');
INSERT INTO `se_languagevars` VALUES ('3000083', '2', 'Tal vez asista', 'event, user_event');
INSERT INTO `se_languagevars` VALUES ('3000084', '2', 'No asistiré', 'event, user_event');
INSERT INTO `se_languagevars` VALUES ('3000085', '2', 'Llegaré tarde', 'event, user_event');
INSERT INTO `se_languagevars` VALUES ('3000086', '2', 'Mis eventos', 'user_event');
INSERT INTO `se_languagevars` VALUES ('3000087', '2', 'A continuación se muestran todos los eventos que usted ha creado o a los que ha sido invitado.<br> Para buscar próximos eventos y participar en ellos, visite la página <a href=”%1$s”>Buscar eventos </a>. ', 'user_event');
INSERT INTO `se_languagevars` VALUES ('3000088', '2', 'Crear un nuevo evento ', 'user_event, user_event_add');
INSERT INTO `se_languagevars` VALUES ('3000089', '2', 'Buscar en mis eventos', 'user_event');
INSERT INTO `se_languagevars` VALUES ('3000090', '2', 'Ver:', 'browse_events, user_event');
INSERT INTO `se_languagevars` VALUES ('3000091', '2', 'Lista ', 'user_event');
INSERT INTO `se_languagevars` VALUES ('3000092', '2', 'Por mes ', 'user_event');
INSERT INTO `se_languagevars` VALUES ('3000093', '2', '¿Desea eliminar el evento?', 'event, user_event');
INSERT INTO `se_languagevars` VALUES ('3000094', '2', '¿Está seguro que desea eliminar este evento? ', 'user_event');
INSERT INTO `se_languagevars` VALUES ('3000095', '2', '¿Desea dejar el evento?', 'user_event');
INSERT INTO `se_languagevars` VALUES ('3000096', '2', '¿Está seguro que desea dejar este evento? ', 'user_event');
INSERT INTO `se_languagevars` VALUES ('3000097', '2', 'Confirmar asistencia (RSVP) al evento ', 'event, user_event');
INSERT INTO `se_languagevars` VALUES ('3000098', '2', 'Para confirmar asistencia (RSVP) a este evento, por favor, seleccione la opción correspondiente a continuación. ', 'event, user_event');
INSERT INTO `se_languagevars` VALUES ('3000099', '2', 'Sí, voy a asistir a este evento. ', 'event, user_event');
INSERT INTO `se_languagevars` VALUES ('3000100', '2', 'Tal vez asista a este evento. ', 'event, user_event');
INSERT INTO `se_languagevars` VALUES ('3000101', '2', 'No, no voy a asistir a este evento. ', 'event, user_event');
INSERT INTO `se_languagevars` VALUES ('3000102', '2', 'Usted no tiene ningún evento. Haga clic <a href=”%1$s”>aquí </a> para crear uno.', 'user_event');
INSERT INTO `se_languagevars` VALUES ('3000103', '2', 'Ningún evento coincide con sus criterios de búsqueda.', 'user_event');
INSERT INTO `se_languagevars` VALUES ('3000104', '2', 'Categoría:', 'user_event');
INSERT INTO `se_languagevars` VALUES ('3000105', '2', 'Cuándo: ', 'user_event');
INSERT INTO `se_languagevars` VALUES ('3000108', '2', 'Por favor, proporcione alguna información sobre su nuevo evento. Después de haber creado su evento, puede comenzar a invitar a otros usuarios a asistir al mismo. ', 'user_event_add');
INSERT INTO `se_languagevars` VALUES ('3000109', '2', 'Volver a Mis eventos ', 'user_event_add, user_event_edit');
INSERT INTO `se_languagevars` VALUES ('3000110', '2', 'Nombre del evento', 'user_event_add, user_event_edit');
INSERT INTO `se_languagevars` VALUES ('3000111', '2', 'Descripción del evento ', 'user_event_add, user_event_edit');
INSERT INTO `se_languagevars` VALUES ('3000112', '2', 'Hora de inicio', 'user_event_add, user_event_edit');
INSERT INTO `se_languagevars` VALUES ('3000113', '2', 'Hora de finalización', 'user_event_add, user_event_edit');
INSERT INTO `se_languagevars` VALUES ('3000114', '2', '(hh:mm am/pm, hh:mm)', 'user_event_add, user_event_edit');
INSERT INTO `se_languagevars` VALUES ('3000115', '2', 'Anfitrión ', 'user_event_add, user_event_edit');
INSERT INTO `se_languagevars` VALUES ('3000116', '2', 'Ubicación ', 'user_event_add, user_event_edit');
INSERT INTO `se_languagevars` VALUES ('3000117', '2', '¿Desea que sea solo para invitados?', 'user_event_add, user_event_edit_settings');
INSERT INTO `se_languagevars` VALUES ('3000118', '2', '¿Es necesario tener una invitación antes de que los usuarios puedan participar de este evento? ', 'user_event_add, user_event_edit_settings');
INSERT INTO `se_languagevars` VALUES ('3000119', '2', 'Sí, los usuarios pueden confirmar asistencia (RSVP) aunque no tengan invitación.', 'user_event_add, user_event_edit_settings');
INSERT INTO `se_languagevars` VALUES ('3000120', '2', 'No, los usuarios no pueden confirmar asistencia (RSVP) a menos que hayan sido invitados.', 'user_event_add, user_event_edit_settings');
INSERT INTO `se_languagevars` VALUES ('3000121', '2', 'Resultados de la búsqueda', 'user_event_add, user_event_edit_settings');
INSERT INTO `se_languagevars` VALUES ('3000122', '2', '¿Desea incluir este evento en los resultados de la búsqueda/exploración?', 'user_event_add, user_event_edit_settings');
INSERT INTO `se_languagevars` VALUES ('3000123', '2', 'Sí, incluir este evento en los resultados de la búsqueda/exploración.', 'user_event_add, user_event_edit_settings');
INSERT INTO `se_languagevars` VALUES ('3000124', '2', 'No, excluir este evento de los resultados de la búsqueda/exploración.', 'user_event_add, user_event_edit_settings');
INSERT INTO `se_languagevars` VALUES ('3000125', '2', '¿Desea permitir ver el evento? ', 'user_event_add, user_event_edit_settings');
INSERT INTO `se_languagevars` VALUES ('3000126', '2', 'Usted puede decidir quienes pueden ver este evento. ', 'user_event_add, user_event_edit_settings');
INSERT INTO `se_languagevars` VALUES ('3000127', '2', '¿Desea permitir comentarios?', 'user_event_add, user_event_edit_settings');
INSERT INTO `se_languagevars` VALUES ('3000128', '2', 'Usted puede decidir quienes pueden publicar comentarios en este evento.  ', 'user_event_add, user_event_edit_settings');
INSERT INTO `se_languagevars` VALUES ('3000129', '2', '¿Desea permitir la carga de archivos?', 'user_event_add, user_event_edit_settings');
INSERT INTO `se_languagevars` VALUES ('3000130', '2', 'Usted puede decidir quienes pueden subir fotografías a este evento.  ', 'user_event_add, user_event_edit_settings');
INSERT INTO `se_languagevars` VALUES ('3000131', '2', '¿Desea permitir el etiquetado de fotografías?', 'user_event_add, user_event_edit_settings');
INSERT INTO `se_languagevars` VALUES ('3000132', '2', 'Usted puede decidir quienes pueden etiquetar fotografías en este evento.  ', 'user_event_add, user_event_edit_settings');
INSERT INTO `se_languagevars` VALUES ('3000133', '2', 'Añadir evento ', 'user_event_add');
INSERT INTO `se_languagevars` VALUES ('3000134', '2', 'Categoría del evento', 'event, user_event_add, user_event_edit');
INSERT INTO `se_languagevars` VALUES ('3000135', '2', 'Editar evento: <a href=”%1$s”>%2$s</a>', 'user_event_edit');
INSERT INTO `se_languagevars` VALUES ('3000136', '2', 'Todos los detalles de este evento se muestran a continuación y pueden ser modificados a continuación. ', 'user_event_edit');
INSERT INTO `se_languagevars` VALUES ('3000137', '2', 'Detalles del evento ', 'event, user_event_edit');
INSERT INTO `se_languagevars` VALUES ('3000138', '2', 'Invitados', 'event, user_event_edit, user_event_edit_members, user_edit_event_settings');
INSERT INTO `se_languagevars` VALUES ('3000139', '2', '¡Su evento se ha creado con éxito!  Puede añadir una fotografía y editar los detalles del evento a continuación. ', 'user_event_edit');
INSERT INTO `se_languagevars` VALUES ('3000140', '2', 'Las imágenes deben tener un tamaño inferior a %1$s y deben tener una de las siguientes extensiones: %2$s', 'user_event_edit');
INSERT INTO `se_languagevars` VALUES ('3000141', '2', 'Buscar invitados: <a href=”%1$s”>%2$s</a>', 'user_event_edit_members');
INSERT INTO `se_languagevars` VALUES ('3000142', '2', 'Utilice esta página para hacer una lista o buscar invitados para el evento. ', 'user_event_edit_members');
INSERT INTO `se_languagevars` VALUES ('3000143', '2', 'Todos los invitados:', 'user_event_edit_members');
INSERT INTO `se_languagevars` VALUES ('3000144', '2', 'Ver:', 'user_event_edit_members');
INSERT INTO `se_languagevars` VALUES ('3000145', '2', 'Participar a nuevos invitados ', 'user_event_edit_members');
INSERT INTO `se_languagevars` VALUES ('3000146', '2', 'No se encontraron invitados que coincidan con sus criterios de búsqueda.', 'user_event_edit_members');
INSERT INTO `se_languagevars` VALUES ('3000147', '2', 'Respuesta actual: ', 'user_event_edit_members');
INSERT INTO `se_languagevars` VALUES ('3000148', '2', 'Última actualización:', 'user_event_edit_members');
INSERT INTO `se_languagevars` VALUES ('3000149', '2', 'Aceptar la solicitud ', 'user_event_edit_members');
INSERT INTO `se_languagevars` VALUES ('3000150', '2', 'Rechazar la solicitud ', 'user_event_edit_members');
INSERT INTO `se_languagevars` VALUES ('3000151', '2', 'Eliminar un invitado ', 'user_event_edit_members');
INSERT INTO `se_languagevars` VALUES ('3000152', '2', 'Líder del evento', 'event, user_event_edit_members');
INSERT INTO `se_languagevars` VALUES ('3000153', '2', 'Se ha producido un error al procesar su solicitud. ', 'user_event, user_event_edit_members');
INSERT INTO `se_languagevars` VALUES ('3000154', '2', '¿Desea eliminar este invitado?', 'user_event_edit_members');
INSERT INTO `se_languagevars` VALUES ('3000155', '2', '¿Está seguro que desea eliminar este invitado de su evento? ', 'user_event_edit_members');
INSERT INTO `se_languagevars` VALUES ('3000156', '2', 'Configuración del evento: <a href=”%1$s”>%2$s</a>', 'user_event_edit_settings');
INSERT INTO `se_languagevars` VALUES ('3000157', '2', 'Editar la configuración del evento, como por ejemplo el estilo de su evento.', 'user_event_edit_settings');
INSERT INTO `se_languagevars` VALUES ('3000158', '2', 'Estilo del evento  ', 'user_event_edit_settings');
INSERT INTO `se_languagevars` VALUES ('3000159', '2', 'Puede cambiar los colores, fuentes y estilos de su evento añadiendo a continuación el código CSS. El contenido del área de texto a continuación se mostrará entre las etiquetas &lt;style&gt; en su evento.', 'user_event_edit_settings');
INSERT INTO `se_languagevars` VALUES ('3000160', '2', 'Invitados al evento', 'event');
INSERT INTO `se_languagevars` VALUES ('3000161', '2', 'Buscar invitados:', 'event');
INSERT INTO `se_languagevars` VALUES ('3000162', '2', 'Ninguno de los invitados al evento coincide con sus criterios de búsqueda.', 'event');
INSERT INTO `se_languagevars` VALUES ('3000163', '2', 'Miembro', 'event');
INSERT INTO `se_languagevars` VALUES ('3000164', '2', 'Fotografías', 'event, event_album_file');
INSERT INTO `se_languagevars` VALUES ('3000165', '2', 'Añadir nuevas fotografías', 'event');
INSERT INTO `se_languagevars` VALUES ('3000166', '2', 'No se han añadido fotografías a este evento todavía. ', 'event');
INSERT INTO `se_languagevars` VALUES ('3000167', '2', 'Solicitar una invitación ', 'event');
INSERT INTO `se_languagevars` VALUES ('3000168', '2', 'Asistir a este evento', 'event');
INSERT INTO `se_languagevars` VALUES ('3000169', '2', 'Eliminar el evento', 'event');
INSERT INTO `se_languagevars` VALUES ('3000170', '2', 'Cancelar la solicitud ', 'event, user_event');
INSERT INTO `se_languagevars` VALUES ('3000172', '2', 'Denunciar este evento', 'event');
INSERT INTO `se_languagevars` VALUES ('3000173', '2', 'Evento privado', 'event');
INSERT INTO `se_languagevars` VALUES ('3000174', '2', 'Información del evento', 'event');
INSERT INTO `se_languagevars` VALUES ('3000175', '2', 'Fecha/Hora del evento', 'event');
INSERT INTO `se_languagevars` VALUES ('3000176', '2', 'Categoría', 'event');
INSERT INTO `se_languagevars` VALUES ('3000177', '2', 'Para subir fotografías a este evento desde su ordenador, haga clic en el botón “Examinar” (Browse), localice la fotografía en su ordenador y haga clic en el botón “Subir”. ', 'user_event_upload');
INSERT INTO `se_languagevars` VALUES ('3000178', '2', 'Este evento tiene %1$s MB de espacio libre disponible. ', 'user_event_upload');
INSERT INTO `se_languagevars` VALUES ('3000179', '2', 'Usted puede subir archivos con tamaños de hasta %1$s KB y con las siguientes extensiones:  %2$s', 'user_event_upload');
INSERT INTO `se_languagevars` VALUES ('3000180', '2', 'Descargar ', 'event_album_file');
INSERT INTO `se_languagevars` VALUES ('3000181', '2', 'Está viendo #%1$d de%2$d en <a href=”%3$s”>%4$s</a>', 'event_album_file');
INSERT INTO `se_languagevars` VALUES ('3000182', '2', 'Última', 'event_album_file');
INSERT INTO `se_languagevars` VALUES ('3000183', '2', 'Siguiente ', 'event_album_file');
INSERT INTO `se_languagevars` VALUES ('3000184', '2', 'En esta fotografía: ', 'event_album_file');
INSERT INTO `se_languagevars` VALUES ('3000185', '2', 'Añadir etiqueta ', 'event_album_file');
INSERT INTO `se_languagevars` VALUES ('3000186', '2', 'Compartir esto', 'event_album_file');
INSERT INTO `se_languagevars` VALUES ('3000187', '2', '%1$s subida por <a href=”%2$s”>%3$s</a>', 'event_album_file');
INSERT INTO `se_languagevars` VALUES ('3000188', '2', 'Subida %1$s', 'event_album_file');
INSERT INTO `se_languagevars` VALUES ('3000189', '2', 'Editar los detalles de la fotografía ', 'event_album_file');
INSERT INTO `se_languagevars` VALUES ('3000190', '2', 'Eliminar fotografía', 'event_album_file');
INSERT INTO `se_languagevars` VALUES ('3000191', '2', '¿Está seguro que desea eliminar esta fotografía? ', 'event_album_file');
INSERT INTO `se_languagevars` VALUES ('3000192', '2', 'Introduzca un título y una descripción para esta fotografía en los campos a continuación. ', 'event_album_file');
INSERT INTO `se_languagevars` VALUES ('3000193', '2', 'Título:', 'event_album_file');
INSERT INTO `se_languagevars` VALUES ('3000194', '2', 'Descripción:', 'event_album_file');
INSERT INTO `se_languagevars` VALUES ('3000195', '2', 'Para compartir esta fotografía o incrustarla en otra página web, por favor, copie y pegue el código de su elección: ', 'event_album_file');
INSERT INTO `se_languagevars` VALUES ('3000196', '2', 'Enlace directo ', 'event_album_file');
INSERT INTO `se_languagevars` VALUES ('3000197', '2', 'HTML - Imagen incrustada', 'event_album_file');
INSERT INTO `se_languagevars` VALUES ('3000198', '2', 'HTML - Enlace del texto ', 'event_album_file');
INSERT INTO `se_languagevars` VALUES ('3000199', '2', 'Código UBB (para foros) ', 'event_album_file');
INSERT INTO `se_languagevars` VALUES ('3000200', '2', 'Cerrar ventana', 'event_album_file');
INSERT INTO `se_languagevars` VALUES ('3000201', '2', '¿Qué novedades hay?', 'event');
INSERT INTO `se_languagevars` VALUES ('3000202', '2', '%1$s de %2$s para %3$s', 'event, user_event');
INSERT INTO `se_languagevars` VALUES ('3000203', '2', '%1$s en %2$s', 'event, user_event');
INSERT INTO `se_languagevars` VALUES ('3000204', '2', '%1$s para %2$s', 'event, user_event');
INSERT INTO `se_languagevars` VALUES ('3000205', '2', 'Explorar eventos', 'browse_events');
INSERT INTO `se_languagevars` VALUES ('3000206', '2', 'Los eventos de todos los usuarios', 'browse_events');
INSERT INTO `se_languagevars` VALUES ('3000207', '2', 'Eventos de mis amigos ', 'browse_events');
INSERT INTO `se_languagevars` VALUES ('3000208', '2', 'Ordenar: ', 'browse_events');
INSERT INTO `se_languagevars` VALUES ('3000209', '2', 'Más populares ', 'browse_events');
INSERT INTO `se_languagevars` VALUES ('3000210', '2', 'Próximos Eventos', 'browse_events');
INSERT INTO `se_languagevars` VALUES ('3000211', '2', 'Fecha de inicio', 'browse_events');
INSERT INTO `se_languagevars` VALUES ('3000212', '2', 'Fecha de finalización', 'browse_events');
INSERT INTO `se_languagevars` VALUES ('3000213', '2', 'Todos los eventos', 'browse_events');
INSERT INTO `se_languagevars` VALUES ('3000214', '2', 'No se encontraron eventos que coincidan con sus criterios de búsqueda.', 'browse_events');
INSERT INTO `se_languagevars` VALUES ('3000215', '2', '%1$d invitados', 'browse_events');
INSERT INTO `se_languagevars` VALUES ('3000216', '2', 'Liderado por <a href=”%2$s”>%1$s</a>', 'browse_events');
INSERT INTO `se_languagevars` VALUES ('3000217', '2', 'actualizado %1$s', 'browse_events');
INSERT INTO `se_languagevars` VALUES ('3000218', '2', 'Buscar en mis eventos lo siguiente:', 'user_event');
INSERT INTO `se_languagevars` VALUES ('3000219', '2', 'Dejar el evento', 'event, user_event');
INSERT INTO `se_languagevars` VALUES ('3000220', '2', '¿Está seguro que desea dejar este evento? ', 'event, user_event');
INSERT INTO `se_languagevars` VALUES ('3000221', '2', '¿Está seguro que desea cancelar la solicitud de invitación para este evento? ', 'event, user_event');
INSERT INTO `se_languagevars` VALUES ('3000222', '2', 'Usuarios invitados', 'user_event_edit_members');
INSERT INTO `se_languagevars` VALUES ('3000223', '2', 'Cancelar la invitación ', 'user_event_edit_members');
INSERT INTO `se_languagevars` VALUES ('3000224', '2', '¿Está seguro que desea cancelar su invitación para este usuario? ', 'user_event_edit_members');
INSERT INTO `se_languagevars` VALUES ('3000225', '2', 'Participar invitados', 'event, user_event_edit_members');
INSERT INTO `se_languagevars` VALUES ('3000226', '2', 'Para invitar a un amigo a unirse a este evento, marque la casilla junto a sus nombres a continuación.  Recuerde que aunque este evento esté configurado para ser visto “sólo por los miembros”, las personas que usted invite podrán ver el evento como si fueran miembros. ', 'event, user_event_edit_members');
INSERT INTO `se_languagevars` VALUES ('3000227', '2', 'Usted no tiene amigos disponibles para participar en este evento. ', 'event, user_event_edit_members');
INSERT INTO `se_languagevars` VALUES ('3000228', '2', 'Seleccionar todos', 'event, user_event_edit_members');
INSERT INTO `se_languagevars` VALUES ('3000229', '2', '%1$d invitación/invitaciones se ha(n) enviado correctamente.', 'event, user_event_edit_members');
INSERT INTO `se_languagevars` VALUES ('3000230', '2', 'Lunes ', 'event_calendar');
INSERT INTO `se_languagevars` VALUES ('3000231', '2', 'Martes ', 'event_calendar');
INSERT INTO `se_languagevars` VALUES ('3000232', '2', 'Miércoles ', 'event_calendar');
INSERT INTO `se_languagevars` VALUES ('3000233', '2', 'Jueves ', 'event_calendar');
INSERT INTO `se_languagevars` VALUES ('3000234', '2', 'Viernes ', 'event_calendar');
INSERT INTO `se_languagevars` VALUES ('3000235', '2', 'Sábado ', 'event_calendar');
INSERT INTO `se_languagevars` VALUES ('3000236', '2', 'Domingo ', 'event_calendar');
INSERT INTO `se_languagevars` VALUES ('3000237', '2', 'M', 'event_calendar');
INSERT INTO `se_languagevars` VALUES ('3000238', '2', 'T', 'event_calendar');
INSERT INTO `se_languagevars` VALUES ('3000239', '2', 'W ', 'event_calendar');
INSERT INTO `se_languagevars` VALUES ('3000240', '2', 'T', 'event_calendar');
INSERT INTO `se_languagevars` VALUES ('3000241', '2', 'F', 'event_calendar');
INSERT INTO `se_languagevars` VALUES ('3000242', '2', 'S', 'event_calendar');
INSERT INTO `se_languagevars` VALUES ('3000243', '2', 'S', 'event_calendar');
INSERT INTO `se_languagevars` VALUES ('3000244', '2', 'Calendario ', 'event, event_calendar');
INSERT INTO `se_languagevars` VALUES ('3000245', '2', 'Editar evento', 'event, user_event');
INSERT INTO `se_languagevars` VALUES ('3000246', '2', 'Debe introducir un título para su evento.', 'user_event_add, user_event_edit');
INSERT INTO `se_languagevars` VALUES ('3000247', '2', 'Debe seleccionar una categoría para su evento.', 'user_event_add, user_event_edit');
INSERT INTO `se_languagevars` VALUES ('3000248', '2', 'No tiene autorización para realizar esa operación. ', 'user_event_add, user_event_edit');
INSERT INTO `se_languagevars` VALUES ('3000249', '2', 'Si ha seleccionado una fecha de finalización, por favor, asegúrese de que sea posterior a la fecha de inicio. ', 'user_event_add, user_event_edit');
INSERT INTO `se_languagevars` VALUES ('3000250', '2', 'Debe introducir una fecha en el futuro. ', 'user_event_add, user_event_edit');
INSERT INTO `se_languagevars` VALUES ('3000251', '2', 'No se pudo encontrar el destino o puede que ya se haya realizado esta operación. ', 'user_event_add, user_event_edit');
INSERT INTO `se_languagevars` VALUES ('3000252', '2', 'Fotografía del evento', 'user_event_edit');
INSERT INTO `se_languagevars` VALUES ('3000253', '2', 'Notificación al ser etiquetado en la fotografía de un evento ', '');
INSERT INTO `se_languagevars` VALUES ('3000254', '2', 'Este es el correo electrónico que se envía a un usuario cuando alguien lo etiqueta en la fotografía de un evento.', '');
INSERT INTO `se_languagevars` VALUES ('3000255', '2', 'Correo electrónico sobre una etiqueta en la fotografía de un evento', '');
INSERT INTO `se_languagevars` VALUES ('3000256', '2', 'Este es el correo electrónico que se envía a un usuario cuando alguien etiqueta una de las fotografías en un evento que este lidera.', '');
INSERT INTO `se_languagevars` VALUES ('3000257', '2', '<b>Opciones de carga de archivos en el álbum de eventos</b><br />Los líderes de eventos pueden elegir entre las opciones a continuación, cuando deciden quienes pueden subir fotografías a sus eventos. Si no se elige opción alguna, todos los usuarios podrán subir fotografías a los eventos.', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000258', '2', '<b>Opciones de etiquetado en el álbum de eventos</b><br />Los líderes de eventos pueden elegir entre las opciones a continuación, cuando deciden quienes pueden etiquetar fotografías en sus eventos. Si no se elige opción alguna, todos los usuarios podrán etiquetar fotografías en los eventos.', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000259', '2', 'Usted puede elegir el tipo de acceso que tienen los usuarios en este nivel a los eventos.', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000260', '2', 'Los usuarios pueden ver y crear eventos y participar en los mismos.', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000261', '2', 'Los usuarios pueden ver los eventos y participar en los mismos.', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000262', '2', 'Los usuarios pueden únicamente ver los eventos.', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000263', '2', 'Los usuarios no pueden usar los eventos.', 'admin_levels_eventsettings');
INSERT INTO `se_languagevars` VALUES ('3000265', '2', 'Sí, permitir a los miembros del evento invitar a sus amigos a participar. ', 'user_event_add, user_event_edit_settings');
INSERT INTO `se_languagevars` VALUES ('3000266', '2', 'No, sólo el líder del evento puede invitar usuarios a participar en el mismo. ', 'user_event_add, user_event_edit_settings');
INSERT INTO `se_languagevars` VALUES ('3000267', '2', 'Invitación a un miembro', 'user_event_add, user_event_edit_settings');
INSERT INTO `se_languagevars` VALUES ('3000268', '2', '¿Desea permitir a los miembros del evento invitar a los usuarios? ', 'user_event_add, user_event_edit_settings');
INSERT INTO `se_languagevars` VALUES ('3000269', '2', 'Autoridades del evento', 'event');
INSERT INTO `se_languagevars` VALUES ('3000270', '2', 'Líder', 'event');
INSERT INTO `se_languagevars` VALUES ('3000272', '2', '%1$s', '');
INSERT INTO `se_languagevars` VALUES ('3000273', '2', '%1$s: %2$s', '');
INSERT INTO `se_languagevars` VALUES ('3000274', '2', 'Explorar eventos', '');
INSERT INTO `se_languagevars` VALUES ('3000275', '2', 'Explorar los eventos de nuestra red social. ', '');
INSERT INTO `se_languagevars` VALUES ('3000276', '2', 'Eventos de %1$s en %2$s', 'event_calendar');
INSERT INTO `se_languagevars` VALUES ('3000277', '2', 'Su estado:', 'user_event');
INSERT INTO `se_languagevars` VALUES ('3000278', '2', 'Mi confirmación de asistencia (RSVP)', 'event');
INSERT INTO `se_languagevars` VALUES ('3000279', '2', 'Su confirmación de asistencia (RSVP) se ha guardado.', 'event');
INSERT INTO `se_languagevars` VALUES ('3000280', '2', 'Tipo de evento', 'event');
INSERT INTO `se_languagevars` VALUES ('3000281', '2', '%1$d eventos', 'search');
INSERT INTO `se_languagevars` VALUES ('3000282', '2', 'Evento: %1$s', 'search');
INSERT INTO `se_languagevars` VALUES ('3000283', '2', 'Medios del evento: %1$s', 'search');
INSERT INTO `se_languagevars` VALUES ('3000284', '2', '%1$s', 'search');
INSERT INTO `se_languagevars` VALUES ('3000285', '2', 'Medios publicados en <a href=\'%1$s\'>%2$s</a><br>%3$s', 'search');
INSERT INTO `se_languagevars` VALUES ('3000286', '2', 'º', 'user_event_add, user_event_edit');
INSERT INTO `se_languagevars` VALUES ('3000287', '2', 'º', 'user_event_add, user_event_edit');
INSERT INTO `se_languagevars` VALUES ('3000288', '2', 'ª', 'user_event_add, user_event_edit');
INSERT INTO `se_languagevars` VALUES ('3000289', '2', 'º', 'user_event_add, user_event_edit');
INSERT INTO `se_languagevars` VALUES ('3000290', '2', '', 'user_event_add, user_event_edit');
INSERT INTO `se_languagevars` VALUES ('3500001', '2', 'Configuración del plugin del chat', '');
INSERT INTO `se_languagevars` VALUES ('3500002', '2', 'Configuración general del chat', '');
INSERT INTO `se_languagevars` VALUES ('3500003', '2', 'Configuración del chat', 'admin_chat');
INSERT INTO `se_languagevars` VALUES ('3500004', '2', '¡Bienvenido a la sala de chat! ', 'chat_frame');
INSERT INTO `se_languagevars` VALUES ('3500005', '2', 'Iniciando sesión como %1$s...', 'chat_frame');
INSERT INTO `se_languagevars` VALUES ('3500007', '2', 'Chat en vivo ', 'chat_frame');
INSERT INTO `se_languagevars` VALUES ('3500008', '2', 'Negrita ', 'chat_frame');
INSERT INTO `se_languagevars` VALUES ('3500009', '2', 'Cursiva ', 'chat_frame');
INSERT INTO `se_languagevars` VALUES ('3500010', '2', 'Subrayado ', 'chat_frame');
INSERT INTO `se_languagevars` VALUES ('3500011', '2', 'Smilies ', 'chat_frame');
INSERT INTO `se_languagevars` VALUES ('3500012', '2', 'Color ', 'chat_frame');
INSERT INTO `se_languagevars` VALUES ('3500013', '2', 'Fecha y hora ', 'chat_frame');
INSERT INTO `se_languagevars` VALUES ('3500014', '2', 'Audio Encendido/Apagado', 'chat_frame');
INSERT INTO `se_languagevars` VALUES ('3500015', '2', '%1$s persona conversando', 'chat_frame');
INSERT INTO `se_languagevars` VALUES ('3500016', '2', '%1$s personas conversando', 'chat_frame');
INSERT INTO `se_languagevars` VALUES ('3500017', '2', 'Usted ha salido de la sala de chat. <br> Ya sea porque ha tenido un problema de conexión, <br> o bien, ha sido expulsado por un administrador. <br> <br> Por favor, inténtelo de nuevo en unos minutos. ', 'chat_frame');
INSERT INTO `se_languagevars` VALUES ('3500018', '2', 'Su conexión con la sala de chat ha caducado.  <br><br>Por favor <a href=\\”chat_frame.php\\”>haga clic aquí</a> para ingresar nuevamente o inténtelo de nuevo más tarde. ', 'chat_frame');
INSERT INTO `se_languagevars` VALUES ('3500019', '2', 'Usted ha sido expulsado de la sala de chat por el administrador. <br> Usted podrá acceder de nuevo dentro de unos minutos. ', 'chat_frame');
INSERT INTO `se_languagevars` VALUES ('3500020', '2', 'El administrador le ha prohibido el acceso a la sala de chat.', 'chat_frame');
INSERT INTO `se_languagevars` VALUES ('3500021', '2', 'La sala de chat ha sido deshabilitada por el administrador. <br> ¡Intente de nuevo en unos minutos! ', 'chat_frame');
INSERT INTO `se_languagevars` VALUES ('3500022', '2', 'Usted no pudo acceder debido a un error del servidor. <br> ¡Por favor notifique al administrador! ', 'chat_frame');
INSERT INTO `se_languagevars` VALUES ('3500023', '2', '%1$s acaba de unirse a la charla.', 'chat_frame');
INSERT INTO `se_languagevars` VALUES ('3500024', '2', '%1$s acaba de unirse a la charla.', 'chat_frame');
INSERT INTO `se_languagevars` VALUES ('3500025', '2', 'Chat', 'header_chat');
INSERT INTO `se_languagevars` VALUES ('3501002', '2', 'El \"chat\" en vivo es una excelente manera de promover la interacción de los usuarios en su red social. Utilice la siguiente configuración para establecer el modo en que funcionará su sala de chat. También puede utilizar esta página para expulsar a los usuarios de la sala de chat o prohibirles el acceso a ella. ', 'admin_chat');
INSERT INTO `se_languagevars` VALUES ('3501004', '2', '%1$s ha sido expulsado de la sala de chat.', 'admin_chat');
INSERT INTO `se_languagevars` VALUES ('3501005', '2', 'Usuarios que están charlando en este momento', 'admin_chat');
INSERT INTO `se_languagevars` VALUES ('3501006', '2', 'Los siguientes usuarios están actualmente charlando en la sala de chat.  Al hacer clic en el nombre de un usuario, este es  <b>expulsado</b> de la sala de chat.  Cuando se expulsa un usuario, se impide que este ingrese de nuevo en la sala de chat por cinco minutos. Si desea prohibir permanentemente a alguien, vea el cuadro en la parte inferior de esta página. ', 'admin_chat');
INSERT INTO `se_languagevars` VALUES ('3501007', '2', 'Actualmente no hay usuarios charlando.', 'admin_chat');
INSERT INTO `se_languagevars` VALUES ('3501011', '2', 'milisegundos ', 'admin_chat');
INSERT INTO `se_languagevars` VALUES ('3501012', '2', 'Frecuencia de actualización ', 'admin_chat');
INSERT INTO `se_languagevars` VALUES ('3501013', '2', 'La aplicación de la sala de chat se conecta con su servidor (utilizando AJAX) cada pocos segundos para obtener nuevos datos. ¿Con qué frecuencia desea que se realice este proceso?  Un periodo de tiempo más corto hará que la charla sea un poco más rápida pero también consumirá más recursos del servidor. Si su servidor está experimentando problemas de desaceleración, intente aumentando este valor por defecto (2 segundos).  <b>Por favor introduzca un número entre 2000 y 20000 (milisegundos).</b>', 'admin_chat');
INSERT INTO `se_languagevars` VALUES ('3501014', '2', 'segundos', 'admin_chat');
INSERT INTO `se_languagevars` VALUES ('3501015', '2', 'Lista de usuarios en línea ', 'admin_chat');
INSERT INTO `se_languagevars` VALUES ('3501016', '2', 'La sala de chat incluye un cuadro que muestra los usuarios que están actualmente en la misma.  ¿Desea que esta lista sea simplemente una lista de texto con los nombres de usuario (como por ejemplo: la lista de amigos de AIM), o prefiere incluir la fotografía de cada usuario junto a su nombre de usuario?  Si usted espera que su sala tenga muchos usuarios en línea, usted puede mostrar sólo una lista con los nombres de usuario. ', 'admin_chat');
INSERT INTO `se_languagevars` VALUES ('3501017', '2', 'Sí, mostrar la fotografía de cada usuario junto a su nombre de usuario.', 'admin_chat');
INSERT INTO `se_languagevars` VALUES ('3501018', '2', 'No, mostrar sólo una lista de nombres de usuario. ', 'admin_chat');
INSERT INTO `se_languagevars` VALUES ('3501019', '2', 'Prohibir nombres de usuario ', 'admin_chat');
INSERT INTO `se_languagevars` VALUES ('3501020', '2', 'Si desea prohibir a determinados usuarios el acceso a la sala de chat, puede introducir sus nombres de usuario a continuación (separados por comas solamente).  ', 'admin_chat');
INSERT INTO `se_languagevars` VALUES ('3501021', '2', 'Configuraciones del chat y de mensajería instantánea (MI)', 'admin_levels_chatsettings');
INSERT INTO `se_languagevars` VALUES ('3501022', '2', 'Si ha permitido a los usuarios usar la sala de chat o la MI, puede modificar sus datos desde esta página.', 'admin_levels_chatsettings');
INSERT INTO `se_languagevars` VALUES ('3501023', '2', 'Permitir Chat/MI ', 'admin_chat, admin_levels_chatsettings');
INSERT INTO `se_languagevars` VALUES ('3501024', '2', '¿Desea permitir a los usuarios charlar en la sala de chat?', 'admin_chat, admin_levels_chatsettings');
INSERT INTO `se_languagevars` VALUES ('3501025', '2', 'Sí, permitir las charlas.', 'admin_chat, admin_levels_chatsettings');
INSERT INTO `se_languagevars` VALUES ('3501026', '2', 'No, no permitir las charlas. ', 'admin_chat, admin_levels_chatsettings');
INSERT INTO `se_languagevars` VALUES ('3501027', '2', '¿Desea permitir a los usuarios tener conversaciones privadas (MI)?', 'admin_chat, admin_levels_chatsettings');
INSERT INTO `se_languagevars` VALUES ('3501028', '2', 'Sí, permitir la MI.', 'admin_chat, admin_levels_chatsettings');
INSERT INTO `se_languagevars` VALUES ('3501029', '2', 'No, no permitir la MI. ', 'admin_chat, admin_levels_chatsettings');
INSERT INTO `se_languagevars` VALUES ('3501030', '2', 'HTML en la sala de chat y en la mensajería instantánea (MI)', 'admin_chat');
INSERT INTO `se_languagevars` VALUES ('3501031', '2', 'Por defecto, el usuario no puede introducir etiquetas HTML en las salas de chat ni en la mensajería instantánea.  Si desea permitir etiquetas específicas, puede introducirlas a continuación (separadas por comas).  Ejemplo: a, b, br, font, i, img, div', 'admin_chat');
INSERT INTO `se_languagevars` VALUES ('3510001', '2', 'desconocido ', 'header_chat');
INSERT INTO `se_languagevars` VALUES ('3510002', '2', 'Conversación ', 'header_chat');
INSERT INTO `se_languagevars` VALUES ('3510015', '2', 'Minimizar ', 'header_chat');
INSERT INTO `se_languagevars` VALUES ('3510016', '2', 'Cerrar', 'header_chat');
INSERT INTO `se_languagevars` VALUES ('3510017', '2', 'Cargando ... ', 'header_chat');
INSERT INTO `se_languagevars` VALUES ('3510018', '2', 'Ningún usuario se ha unido aún.', 'header_chat');
INSERT INTO `se_languagevars` VALUES ('3510019', '2', 'No se ha enviado ningún mensaje aún.', 'header_chat');
INSERT INTO `se_languagevars` VALUES ('3510020', '2', 'Usted se ha unido a la conversación.', 'header_chat');
INSERT INTO `se_languagevars` VALUES ('3510021', '2', '%1$s acaba de unirse a la conversación.', 'header_chat');
INSERT INTO `se_languagevars` VALUES ('3510022', '2', '%1$s acaba de abandonar la conversación.', 'header_chat');
INSERT INTO `se_languagevars` VALUES ('3510023', '2', '%1$s no está en línea.', 'header_chat');
INSERT INTO `se_languagevars` VALUES ('3510024', '2', 'Amigos', 'header_chat');
INSERT INTO `se_languagevars` VALUES ('3510025', '2', 'Ninguno de sus amigos está en línea.', 'header_chat');
INSERT INTO `se_languagevars` VALUES ('3510026', '2', 'Opciones', 'header_chat');
INSERT INTO `se_languagevars` VALUES ('3510027', '2', 'Fuera de línea ', 'header_chat');
INSERT INTO `se_languagevars` VALUES ('3510028', '2', 'En línea', 'header_chat');
INSERT INTO `se_languagevars` VALUES ('3510029', '2', 'Lejos', 'header_chat');
INSERT INTO `se_languagevars` VALUES ('3510030', '2', 'Ocupado ', 'header_chat');
INSERT INTO `se_languagevars` VALUES ('3510031', '2', 'Personalizar', 'header_chat');
INSERT INTO `se_languagevars` VALUES ('3510032', '2', 'Su estado', 'header_chat');
INSERT INTO `se_languagevars` VALUES ('3510033', '2', 'Enviar ', 'header_chat');
INSERT INTO `se_languagevars` VALUES ('3510034', '2', 'El usuario al que está intentando enviar un mensaje no está en línea. Su mensaje no ha sido recibido.', 'header_chat');
INSERT INTO `se_languagevars` VALUES ('3510035', '2', 'Nuevo mensaje de %1$s ', 'header_chat');
INSERT INTO `se_languagevars` VALUES ('3510036', '2', '%1$s está en línea', 'header_chat');
INSERT INTO `se_languagevars` VALUES ('3510037', '2', '%1$s está lejos ahora.', 'header_chat');
INSERT INTO `se_languagevars` VALUES ('3510038', '2', 'Error por desbordamiento: demasiadas conversaciones.  Por favor, cierre una de las conversaciones para abrir otra. ', 'header_chat');
INSERT INTO `se_languagevars` VALUES ('4000001', '2', 'Configuración de la musica', '');
INSERT INTO `se_languagevars` VALUES ('4000002', '2', 'Ver canciones', '');
INSERT INTO `se_languagevars` VALUES ('4000003', '2', 'Configuración de la musica', '');
INSERT INTO `se_languagevars` VALUES ('4000004', '2', 'Musica', '');
INSERT INTO `se_languagevars` VALUES ('4000005', '2', 'Si ha permitido a los usuarios añadir música a sus perfiles, puede modificar sus datos desde esta página.', 'admin_levels_musicsettings');
INSERT INTO `se_languagevars` VALUES ('4000006', '2', '¿Desea permitir música?', 'admin_levels_musicsettings');
INSERT INTO `se_languagevars` VALUES ('4000007', '2', '¿Desea permitir a los usuarios subir música a sus perfiles? ', 'admin_levels_musicsettings');
INSERT INTO `se_languagevars` VALUES ('4000008', '2', 'Sí, permitir música. ', 'admin_levels_musicsettings');
INSERT INTO `se_languagevars` VALUES ('4000009', '2', 'No, no permitir música.', 'admin_levels_musicsettings');
INSERT INTO `se_languagevars` VALUES ('4000010', '2', 'Número máximo de canciones permitido', 'admin_levels_musicsettings');
INSERT INTO `se_languagevars` VALUES ('4000011', '2', 'Introduzca el número máximo de canciones permitido. El campo debe contener un número entero entre 1 y 999.', 'admin_levels_musicsettings');
INSERT INTO `se_languagevars` VALUES ('4000012', '2', 'Canciones permitidas', 'admin_levels_musicsettings');
INSERT INTO `se_languagevars` VALUES ('4000013', '2', 'Tipos de archivo permitidos', 'admin_levels_musicsettings');
INSERT INTO `se_languagevars` VALUES ('4000014', '2', 'Confeccione una lista con las siguientes extensiones de archivo que los usuarios están autorizados a cargar. Separe las extensiones de archivo con comas, por ejemplo: mp3, mp4', 'admin_levels_musicsettings');
INSERT INTO `se_languagevars` VALUES ('4000015', '2', 'Tipos MIME permitidos', 'admin_levels_musicsettings');
INSERT INTO `se_languagevars` VALUES ('4000016', '2', 'Para poder cargar un archivo, el archivo debe tener una extensión de archivo permitida, así como también un tipo MIME permitido.  Esto impide que los usuarios disfracen los archivos maliciosos con una extensión falsa. Separe los tipos MIME con comas, por ejemplo: image/jpeg, image/gif, image/png, image/bmp', 'admin_levels_musicsettings');
INSERT INTO `se_languagevars` VALUES ('4000017', '2', 'Espacio de almacenamiento permitido ', 'admin_levels_musicsettings');
INSERT INTO `se_languagevars` VALUES ('4000018', '2', '¿Cuánto espacio de almacenamiento podrá disponer cada usuario para almacenar sus archivos? ', 'admin_levels_musicsettings');
INSERT INTO `se_languagevars` VALUES ('4000019', '2', 'Tamaño de archivo máximo ', 'admin_levels_musicsettings');
INSERT INTO `se_languagevars` VALUES ('4000020', '2', 'Introduzca el tamaño de archivo máximo que se podrá cargar expresado en KB. Este debe ser un número entre 1 y 204800.', 'admin_levels_musicsettings');
INSERT INTO `se_languagevars` VALUES ('4000021', '2', 'Usted está actualmente editando la configuración de este nivel de usuario. Recuerde que estas configuraciones sólo se aplican a los usuarios que pertenecen a este nivel de usuario. Cuando haya terminado, puede editar <a href=\'admin_levels.php\'> los otros niveles aquí </a>. ', 'admin_levels_musicsettings');
INSERT INTO `se_languagevars` VALUES ('4000022', '2', 'El campo del tamaño máximo del archivo debe contener un número entero entre 1 y 204800. ', 'admin_levels_musicsettings');
INSERT INTO `se_languagevars` VALUES ('4000023', '2', 'El campo de número máximo de canciones permitidas debe contener un número entero entre 1 y 999. ', 'admin_levels_musicsettings');
INSERT INTO `se_languagevars` VALUES ('4000024', '2', '¿Desea permitir carátulas?', 'admin_levels_musicsettings');
INSERT INTO `se_languagevars` VALUES ('4000025', '2', '¿Podrán los usuarios elegir sus propias carátulas?', 'admin_levels_musicsettings');
INSERT INTO `se_languagevars` VALUES ('4000026', '2', 'Sí, permitir las carátulas.', 'admin_levels_musicsettings');
INSERT INTO `se_languagevars` VALUES ('4000027', '2', 'No, no permitir las carátulas.', 'admin_levels_musicsettings');
INSERT INTO `se_languagevars` VALUES ('4000028', '2', 'Carátula por defecto', 'admin_levels_musicsettings');
INSERT INTO `se_languagevars` VALUES ('4000029', '2', 'Vista previa', 'admin_levels_musicsettings');
INSERT INTO `se_languagevars` VALUES ('4000030', '2', '%1$s KB', 'admin_levels_musicsettings');
INSERT INTO `se_languagevars` VALUES ('4000031', '2', 'Ver la música de los usuarios', 'admin_viewmusic');
INSERT INTO `se_languagevars` VALUES ('4000032', '2', 'En esta página se muestra una lista de toda la música que sus usuarios han publicado. Puede utilizar esta página para controlar la música y eliminarla si es necesario.  La introducción de criterios en los campos del filtro le ayudará a encontrar música específica.  Si se dejan los campos del filtro en blanco, se mostrará toda la música existente en su red social. ', 'admin_viewmusic');
INSERT INTO `se_languagevars` VALUES ('4000033', '2', 'Título ', 'admin_viewmusic');
INSERT INTO `se_languagevars` VALUES ('4000034', '2', 'Propietario', 'admin_viewmusic');
INSERT INTO `se_languagevars` VALUES ('4000035', '2', 'total de %1$d pistas', 'admin_viewmusic');
INSERT INTO `se_languagevars` VALUES ('4000036', '2', 'Páginas ', 'admin_viewmusic');
INSERT INTO `se_languagevars` VALUES ('4000037', '2', 'No hay pistas de música ', 'admin_viewmusic');
INSERT INTO `se_languagevars` VALUES ('4000038', '2', 'Eliminar la canción', 'admin_viewmusic');
INSERT INTO `se_languagevars` VALUES ('4000039', '2', '¿Está seguro que desea eliminar esta canción? ', 'admin_viewmusic, user_music_delete');
INSERT INTO `se_languagevars` VALUES ('4000040', '2', 'Vista previa', 'admin_viewmusic');
INSERT INTO `se_languagevars` VALUES ('4000041', '2', 'Música de %1$s', 'profile_music');
INSERT INTO `se_languagevars` VALUES ('4000042', '2', 'Mi lista de reproducción ', 'user_music');
INSERT INTO `se_languagevars` VALUES ('4000044', '2', 'Estas son las canciones que ha subido a su lista de reproducción.  La gente podrá escucharlas en su perfil. ', 'user_music');
INSERT INTO `se_languagevars` VALUES ('4000045', '2', 'Escriba el nuevo título de la pista a continuación y luego pulse “Actualizar canción” para hacer los cambios. ', 'user_music');
INSERT INTO `se_languagevars` VALUES ('4000046', '2', 'Título de la canción', 'user_music');
INSERT INTO `se_languagevars` VALUES ('4000047', '2', 'Subir canciones ', 'user_music, user_music_upload');
INSERT INTO `se_languagevars` VALUES ('4000048', '2', 'Tamaño ', 'user_music');
INSERT INTO `se_languagevars` VALUES ('4000049', '2', '%1$d MB', 'admin_levels_musicsettings, user_music');
INSERT INTO `se_languagevars` VALUES ('4000050', '2', '%1$d GB', 'admin_levels_musicsettings, user_music');
INSERT INTO `se_languagevars` VALUES ('4000051', '2', 'Eliminar las canciones seleccionadas', 'user_music');
INSERT INTO `se_languagevars` VALUES ('4000052', '2', 'Usted todavía no ha subido ninguna  canción.  ', 'user_music');
INSERT INTO `se_languagevars` VALUES ('4000053', '2', '¿Desea eliminar la canción?', 'user_music_delete');
INSERT INTO `se_languagevars` VALUES ('4000054', '2', 'Editar la configuración de la música', 'user_music_settings');
INSERT INTO `se_languagevars` VALUES ('4000055', '2', 'Configurar el reproductor de música en su perfil con estas configuraciones ', 'user_music_settings');
INSERT INTO `se_languagevars` VALUES ('4000056', '2', '¿Deseo la reproducción automática de mi música en mi perfil? ', 'user_music_settings');
INSERT INTO `se_languagevars` VALUES ('4000057', '2', 'Sí, reproducir mis canciones automáticamente cuando la gente visita mi perfil. ', 'user_music_settings');
INSERT INTO `se_languagevars` VALUES ('4000058', '2', 'No, los visitantes de mi perfil deben hacer clic en el botón de reproducción para escuchar mi música. ', 'user_music_settings');
INSERT INTO `se_languagevars` VALUES ('4000059', '2', '¿Desea la reproducción automática de la música de otras personas en sus perfiles? ', 'user_music_settings');
INSERT INTO `se_languagevars` VALUES ('4000060', '2', 'Sí, reproducir automáticamente la música de otras personas cuando visito sus perfiles.', 'user_music_settings');
INSERT INTO `se_languagevars` VALUES ('4000061', '2', 'No, deshabilitar la reproducción automática cuando visito los perfiles de otras personas.', 'user_music_settings');
INSERT INTO `se_languagevars` VALUES ('4000062', '2', 'Carátula del reproductor de música ', 'user_music_settings');
INSERT INTO `se_languagevars` VALUES ('4000063', '2', 'La música no está habilitada para este usuario', 'user_music_upload');
INSERT INTO `se_languagevars` VALUES ('4000064', '2', 'El archivo %1$s se ha subido correctamente. ', 'user_music_upload');
INSERT INTO `se_languagevars` VALUES ('4000065', '2', 'El archivo %1$s no pudo ser subido, por favor, inténtelo de nuevo más tarde. ', 'user_music_upload');
INSERT INTO `se_languagevars` VALUES ('4000066', '2', 'Hubo un error desconocido, por favor, inténtelo de nuevo más tarde. ', 'user_music_upload');
INSERT INTO `se_languagevars` VALUES ('4000067', '2', 'Subir música nueva ', 'user_music_upload');
INSERT INTO `se_languagevars` VALUES ('4000068', '2', 'Busque archivos de música en su ordenador y súbalos a su lista de reproducción. ', 'user_music_upload');
INSERT INTO `se_languagevars` VALUES ('4000069', '2', 'Volver a Mi lista de reproducción ', 'user_music_upload');
INSERT INTO `se_languagevars` VALUES ('4000070', '2', 'Usted puede subir archivos con tamaños de hasta %1$s MB ', 'user_music_upload');
INSERT INTO `se_languagevars` VALUES ('4000071', '2', 'Usted puede subir los siguientes tipos de archivo: %1$s.', 'user_music_upload');
INSERT INTO `se_languagevars` VALUES ('4000072', '2', 'Usted tiene %1$s MB de espacio libre disponible. ', 'user_music_upload');
INSERT INTO `se_languagevars` VALUES ('4000073', '2', 'Haga clic en “Añadir una canción” para cada canción que desee cargar (hasta 5 canciones). A continuación, haga clic en “Subir canciones’ para ponerlas en su perfil. ', 'user_music_upload');
INSERT INTO `se_languagevars` VALUES ('4000074', '2', 'Seleccione la canción que desea subir ', 'user_music_upload');
INSERT INTO `se_languagevars` VALUES ('4000075', '2', 'Añadir una canción', 'user_music_upload');
INSERT INTO `se_languagevars` VALUES ('4000076', '2', 'Limpiar la lista', 'user_music_upload');
INSERT INTO `se_languagevars` VALUES ('4000077', '2', 'Limpiar la lista', 'user_music_upload');
INSERT INTO `se_languagevars` VALUES ('4000078', '2', 'Progreso general ', 'user_music_upload');
INSERT INTO `se_languagevars` VALUES ('4000079', '2', 'Progreso del archivo ', 'user_music_upload');
INSERT INTO `se_languagevars` VALUES ('4000080', '2', 'Carga completa ', 'user_music_upload');
INSERT INTO `se_languagevars` VALUES ('4000081', '2', 'La señal de carga no era válida. Por favor, asegúrese de tener habilitadas las cookies en su navegador y de tener habilitado el soporte de sesión en el servidor ', 'user_music_upload');
INSERT INTO `se_languagevars` VALUES ('4000082', '2', 'Por favor, asegúrese de que está conectado.', 'user_music_upload');
INSERT INTO `se_languagevars` VALUES ('4000083', '2', 'La música no está habilitada para este usuario.', 'user_music_upload');
INSERT INTO `se_languagevars` VALUES ('4000084', '2', 'No se puede acceder a esta página desde una ventana del navegador. ', 'user_music_upload');
INSERT INTO `se_languagevars` VALUES ('4000085', '2', 'El archivo %1$s se ha subido correctamente. ', 'user_music_upload');
INSERT INTO `se_languagevars` VALUES ('4000086', '2', 'Canción sin título', 'user_music');
INSERT INTO `se_languagevars` VALUES ('4000087', '2', 'El/los archivo(s) subido(s) supera(n) su límite de almacenamiento. ', 'user_music_upload');
INSERT INTO `se_languagevars` VALUES ('4000088', '2', 'Usted ha subido %1$s canciones.', 'user_music');
INSERT INTO `se_languagevars` VALUES ('4000089', '2', 'Usted ha subido %1$d canciones y tiene %2$d canciones en su lista de reproducción. ', 'user_music');
INSERT INTO `se_languagevars` VALUES ('4000090', '2', 'confirmar ', 'user_music');
INSERT INTO `se_languagevars` VALUES ('4000091', '2', 'Descargas de música ', 'admin_levels_musicsettings');
INSERT INTO `se_languagevars` VALUES ('4000092', '2', '¿Desea permitir a los usuarios descargar canciones? <b>Esto puede ser ilegal en su área.</b> ', 'admin_levels_musicsettings');
INSERT INTO `se_languagevars` VALUES ('4000093', '2', 'Sí, permitir a los usuarios descargar canciones subidas.', 'admin_levels_musicsettings');
INSERT INTO `se_languagevars` VALUES ('4000094', '2', 'No, no permitir a los usuarios descargar canciones subidas.', 'admin_levels_musicsettings');
INSERT INTO `se_languagevars` VALUES ('4000095', '2', 'Descargar canción', 'browse_music');
INSERT INTO `se_languagevars` VALUES ('4000096', '2', 'Explorar la música', 'browse_music');
INSERT INTO `se_languagevars` VALUES ('4000097', '2', 'Ver:', 'browse_music');
INSERT INTO `se_languagevars` VALUES ('4000098', '2', 'La música de todos los usuarios', 'browse_music');
INSERT INTO `se_languagevars` VALUES ('4000099', '2', 'La música de mis amigos', 'browse_music');
INSERT INTO `se_languagevars` VALUES ('4000100', '2', 'Ordenar: ', 'browse_music');
INSERT INTO `se_languagevars` VALUES ('4000101', '2', 'Recientemente subida', 'browse_music');
INSERT INTO `se_languagevars` VALUES ('4000102', '2', 'Prioridad más alta en la lista de reproducción', 'browse_music');
INSERT INTO `se_languagevars` VALUES ('4000103', '2', '%1$s subido por <a href=”%2$s”>%3$s</a>', 'browse_music');
INSERT INTO `se_languagevars` VALUES ('4000104', '2', '%1$d canciones', 'search');
INSERT INTO `se_languagevars` VALUES ('4000105', '2', 'Canción: %1$s', 'search');
INSERT INTO `se_languagevars` VALUES ('4000106', '2', 'Canción subida por <a href=’%1$s’>%2$s</a><br>%3$s', 'search');
INSERT INTO `se_languagevars` VALUES ('4500001', '2', 'Configuraciones clasificadas', '');
INSERT INTO `se_languagevars` VALUES ('4500002', '2', 'Ver listados clasificados', '');
INSERT INTO `se_languagevars` VALUES ('4500003', '2', 'Configuraciones clasificadas globales', '');
INSERT INTO `se_languagevars` VALUES ('4500004', '2', 'Configuraciones clasificadas', '');
INSERT INTO `se_languagevars` VALUES ('4500005', '2', 'Nuevo comentario clasificado enviado por correo electrónico', '');
INSERT INTO `se_languagevars` VALUES ('4500006', '2', 'Este es el correo electrónico que se envía a un usuario cuando se publica un nuevo comentario en uno de sus listados clasificados.. ', '');
INSERT INTO `se_languagevars` VALUES ('4500007', '2', 'Clasificados', '');
INSERT INTO `se_languagevars` VALUES ('4500008', '2', 'Sus listados clasificados por pagina deben contiene un integer entre 1 y 999', 'Your listings per page field must contain an integer between 1 and 999.');
INSERT INTO `se_languagevars` VALUES ('4500009', '2', 'El ancho y la altura de las fotos deben estar expresados por enteros entre 1 y 999.', 'Photo width and height must be integers between 1 and 999.');
INSERT INTO `se_languagevars` VALUES ('4500010', '2', 'El campo del tamaño máximo del archivo debe contener un número entero entre 1 y 204800. ', 'Your maximum filesize field must contain an integer between 1 and 204800.');
INSERT INTO `se_languagevars` VALUES ('4500011', '2', 'Los campos del ancho y la altura máximos de las fotos deben contener números enteros entre 1 y 9999.', 'Your maximum width and height fields must contain integers between 1 and 9999.');
INSERT INTO `se_languagevars` VALUES ('4500012', '2', 'Si ha permitido a los usuarios crear clasificadas, puede modificar las desde esta página.', 'If you have allowed users to have classifieds listings, you can adjust their details from this page.');
INSERT INTO `se_languagevars` VALUES ('4500013', '2', 'Permitir Clasificadas?', 'Allow Classifieds?');
INSERT INTO `se_languagevars` VALUES ('4500014', '2', '¿Desea permitir a los usuarios crear listados clasificados? Si elige NO, el resto de las configuraciones en esta página no se aplicarán.  ', 'Do you want to let users have classified listings? If set to no, all other settings on this page will not apply.');
INSERT INTO `se_languagevars` VALUES ('4500015', '2', 'Sí, permitir las clasificadas.', 'Yes, allow classified listings.');
INSERT INTO `se_languagevars` VALUES ('4500016', '2', 'No, no permitir las clasificadas.', 'No, do not allow classified listings.');
INSERT INTO `se_languagevars` VALUES ('4500017', '2', 'Permitir fotografias de Clasificadas?', 'Allow Classified Photos?');
INSERT INTO `se_languagevars` VALUES ('4500018', '2', 'Si activa esta función, los usuarios pueden subir una pequeña fotografía icono cuando crean o editan un un listado clasificada. Esta se mostrará junto al clasificada', 'If you enable this feature, users will be able to upload a small photo icon when creating or editing a classified listing. This can be displayed next to the classified name in search/browse results, etc.');
INSERT INTO `se_languagevars` VALUES ('4500019', '2', 'Sí, los usuarios pueden subir una fotografía ícono cuando crean/editan un clasificado.', 'Yes, users can upload a photo icon when they create/edit a classified listing.');
INSERT INTO `se_languagevars` VALUES ('4500020', '2', 'No, los usuarios no pueden subir una fotografía ícono cuando crean/editan un clasificado.', 'No, users can not upload a photo icon when they create/edit a classified listing.');
INSERT INTO `se_languagevars` VALUES ('4500021', '2', 'Si ha seleccionado SÍ anteriormente, por favor, introduzca las dimensiones máximas para las fotografías del clasificado.  Si sus usuarios suben una fotografía de mayores dimensiones que las especificadas, el servidor intentará reducir su tamaño automáticamente. Esta función requiere que su servidor PHP cuente con soporte para GD Libraries.', 'If you have selected YES above, please input the maximum dimensions for the classified photos. If your users upload a photo that is larger than these dimensions, the server will attempt to scale them down automatically. This feature requires that your PHP server is compiled with support for the GD Libraries.');
INSERT INTO `se_languagevars` VALUES ('4500022', '2', 'Ancho máximo:', 'Maximum Width:');
INSERT INTO `se_languagevars` VALUES ('4500023', '2', 'Altura máxima:', 'Maximum Height:');
INSERT INTO `se_languagevars` VALUES ('4500024', '2', '(en píxeles, entre %1$d y %1$d)', '(in pixels, between 1 and 999)');
INSERT INTO `se_languagevars` VALUES ('4500025', '2', '¿Qué tipos de archivo desea permitir para las fotografías del clasificado (gif, jpg, jpeg o png)? Separe los tipos de archivo con comas, es decir, jpg, jpeg, gif, png. ', 'What file types do you want to allow for classified photos (gif, jpg, jpeg, or png)? Separate file types with commas, i.e. jpg, jpeg, gif, png');
INSERT INTO `se_languagevars` VALUES ('4500026', '2', 'Tipos de archivo permitidos:', 'Allowed File Types:');
INSERT INTO `se_languagevars` VALUES ('4500027', '2', 'Listados por página', 'Listings Per Page');
INSERT INTO `se_languagevars` VALUES ('4500028', '2', '¿Cuántas entradas en los clasificados se mostrarán por página?  (Introduzca un número entre 1 y 999)  ', 'How many classified listings will be shown per page? (Enter a number between 1 and 999)');
INSERT INTO `se_languagevars` VALUES ('4500029', '2', '¿Cuántas clasificados por página?', 'listings per page');
INSERT INTO `se_languagevars` VALUES ('4500030', '2', 'Opciones de privacidad de los clasificados', 'Classified Privacy Options');
INSERT INTO `se_languagevars` VALUES ('4500031', '2', '<b>  Opciones de privacidad de la búsqueda</b> <br> Si habilita esta característica, los usuarios podrán excluir sus listados clasificados de los resultados de la búsqueda.  De lo contrario, todas las clasificados se incluirán en los resultados la misma.', '<b>Search Privacy Options</b><br>If you enable this feature, users will be able to exclude their classified listings from search results. Otherwise, all classified listings will be included in search results.');
INSERT INTO `se_languagevars` VALUES ('4500032', '2', 'Sí, permitir a los usuarios excluir sus listados clasificados de los resultados de la búsqueda.', 'Yes, allow users to exclude their classified listings from search results.');
INSERT INTO `se_languagevars` VALUES ('4500033', '2', 'No, obligar a todos los usuarios a incluir los listados clasificados en los resultados de la búsqueda.', 'No, force all classified listings to be included in search results.');
INSERT INTO `se_languagevars` VALUES ('4500034', '2', '<b>Privacidad de las entradas de los clasificados</b><br>Sus usuarios pueden elegir entre cualquiera de las opciones mostradas a continuación, cuando deciden quienes pueden ver sus listados clasificados. Estas opciones aparecen en las páginas \"Añadir entrada\" y \"Editar entrada\" de sus usuarios.  Si no se elige opción alguna, todos los usuarios podrán ver los listados clasificados.', '<b>Classified Listing Privacy</b><br>Your users can choose from any of the options checked below when they decide who can see their classified listings. These options appear on your users\' \"Add listing\" and \"Edit listing\" pages. If you do not check any options, everyone will be allowed to view classifieds.');
INSERT INTO `se_languagevars` VALUES ('4500035', '2', '<b>Opciones de los comentarios en los listados clasificadas</b><br>Sus usuarios pueden elegir entre cualquiera de las opciones mostradas a continuación, cuando deciden quién puede publicar comentarios en sus listados clasificadas. Si no se elige opción alguna, todos los usuarios podrán publicar comentarios en los listados clasificadas.', '<b>Classified Comment Options</b><br>Your users can choose from any of the options checked below when they decide who can post comments on their listings. If you do not check any options, everyone will be allowed to post comments on listings.');
INSERT INTO `se_languagevars` VALUES ('4500036', '2', 'Configuración del  listado clasificado', 'Classified File Settings');
INSERT INTO `se_languagevars` VALUES ('4500037', '2', 'Confeccione una lista con las siguientes extensiones de archivo que los usuarios están autorizados a cargar. Separe las extensiones de archivo con comas, por ejemplo: jpg, gif, jpeg, png, bmp', 'List the following file extensions that users are allowed to upload. Separate file extensions with commas, for example: jpg, gif, jpeg, png, bmp');
INSERT INTO `se_languagevars` VALUES ('4500038', '2', 'Para poder cargar un archivo, el mismo debe tener una extensión de archivo permitida, así como también un tipo MIME permitido.  Esto impide que los usuarios disfracen los archivos maliciosos con una extensión falsa. Separe los tipos MIME con comas, por ejemplo: image/jpeg, image/gif, image/png, image/bmp ', 'To successfully upload a file, the file must have an allowed filetype extension as well as an allowed MIME type. This prevents users from disguising malicious files with a fake extension. Separate MIME types with commas, for example: image/jpeg, image/gif, image/png, image/bmp');
INSERT INTO `se_languagevars` VALUES ('4500039', '2', '¿Cuánto espacio de almacenamiento deberá tener cada clasificado para almacenar sus archivos? ', 'How much storage space should each listing have to store its files?');
INSERT INTO `se_languagevars` VALUES ('4500040', '2', 'Ilimitado', 'Unlimited');
INSERT INTO `se_languagevars` VALUES ('4500041', '2', '%1$s KB', '%1$s KB');
INSERT INTO `se_languagevars` VALUES ('4500042', '2', '%1$s MB', '%1$s MB');
INSERT INTO `se_languagevars` VALUES ('4500043', '2', '%1$s GB', '%1$s GB');
INSERT INTO `se_languagevars` VALUES ('4500044', '2', 'Introduzca el tamaño de archivo máximo que se podrá cargar expresado en KB. Este debe ser un número entre 1 y 204800.', 'Enter the maximum filesize for uploaded files in KB. This must be a number between 1 and 204800.');
INSERT INTO `se_languagevars` VALUES ('4500045', '2', 'Introduzca el ancho y la altura máximos (en píxeles) para las imágenes subidas a los clasificados. Se reducirá el tamaño de las imágenes con dimensiones que excedan este rango si su servidor tiene instalada GD Libraries. Tenga en cuenta que los tipos de imágenes inusuales como BMP, TIFF, RAW, y otros no pueden ser redimensionados. ', 'Enter the maximum width and height (in pixels) for images uploaded to listings. Images with dimensions outside this range will be sized down accordingly if your server has the GD Libraries installed. Note that unusual image types like BMP, TIFF, RAW, and others may not be resized.');
INSERT INTO `se_languagevars` VALUES ('4500046', '2', 'Ancho máximo:', 'Maximum Width:');
INSERT INTO `se_languagevars` VALUES ('4500047', '2', 'Altura máxima:', 'Maximum Height:');
INSERT INTO `se_languagevars` VALUES ('4500048', '2', '(en píxeles, entre %1$d y %1$d)', '(in pixels, between 1 and 9999)');
INSERT INTO `se_languagevars` VALUES ('4500049', '2', 'En esta página se muestran todos los listados clasificadas que los usuarios han creado en su red social. Puede utilizar esta página para controlar estos listados y eliminar el material ofensivo o no deseado, si es necesario.  La introducción de criterios en los campos del filtro le ayudará a encontrar eventos específicos.  Si se dejan los campos del filtro en blanco, se mostrarán todos los listadoss existentes en su red social. ', 'This page lists all of the classified listings your users have posted. You can use this page to monitor these classifieds and delete offensive material if necessary. Entering criteria into the filter fields will help you find specific classified listings. Leaving the filter fields blank will show all the classified listings on your social network.');
INSERT INTO `se_languagevars` VALUES ('4500050', '2', 'No se encontraron listados.', 'No listings were found.');
INSERT INTO `se_languagevars` VALUES ('4500051', '2', 'Se encontraron %1$d listadoss', '%1$d Classified Listings Found');
INSERT INTO `se_languagevars` VALUES ('4500052', '2', 'Título ', 'Title');
INSERT INTO `se_languagevars` VALUES ('4500053', '2', 'Creador ', 'Owner');
INSERT INTO `se_languagevars` VALUES ('4500054', '2', 'Ver', 'view');
INSERT INTO `se_languagevars` VALUES ('4500055', '2', '¿Está seguro que desea eliminar este evento? ', 'Are you sure you want to delete this classified listing?');
INSERT INTO `se_languagevars` VALUES ('4500056', '2', '<a href=\"%2$s\">%1$s</a>\'s <a href=\"%3$s\">Listados Clasificadas</a>', '<a href=\"%2$s\">%1$s</a>\'s <a href=\"%3$s\">Classified Listings</a>');
INSERT INTO `se_languagevars` VALUES ('4500057', '2', 'Creada: %1$s', 'Created: %1$s');
INSERT INTO `se_languagevars` VALUES ('4500058', '2', 'Categoría ', 'Category:');
INSERT INTO `se_languagevars` VALUES ('4500059', '2', 'Volver a listados', 'Back to %1$s\'s Listings');
INSERT INTO `se_languagevars` VALUES ('4500060', '2', '<a href=\"%2$s\">%1$s</a>\'s Listados Clasificadas', '<a href=\"%2$s\">%1$s</a>\'s Classified Listings');
INSERT INTO `se_languagevars` VALUES ('4500061', '2', '<b><a href=\"%2$s\">%1$s</a></b> no ha publicado ningunos listados', '<b><a href=\"%2$s\">%1$s</a></b> has not posted any classified listings.');
INSERT INTO `se_languagevars` VALUES ('4500062', '2', 'Visitas: %1$d visitas', 'Views: %1$d views');
INSERT INTO `se_languagevars` VALUES ('4500063', '2', 'Comentarios: %1$d comentarios', 'Comments: %1$d comments');
INSERT INTO `se_languagevars` VALUES ('4500064', '2', 'Publicado:', 'Posted:');
INSERT INTO `se_languagevars` VALUES ('4500065', '2', 'Publicar un nuevo listado', 'Post New Listing');
INSERT INTO `se_languagevars` VALUES ('4500066', '2', 'Configuración de los listados', 'Listing Settings');
INSERT INTO `se_languagevars` VALUES ('4500067', '2', 'Buscar en mis listados ', 'Search My Listings');
INSERT INTO `se_languagevars` VALUES ('4500068', '2', 'Mis Listados Clasificadas', 'My Classified Listings');
INSERT INTO `se_languagevars` VALUES ('4500069', '2', '', 'Classified listings are a great way to list something for sale, find items you need, look for jobs or simply meet new people.');
INSERT INTO `se_languagevars` VALUES ('4500070', '2', 'No se encontraron listados.', 'No classified listings were found.');
INSERT INTO `se_languagevars` VALUES ('4500071', '2', 'No tiene listados clasificadas. <a href=\"%1$s\">Click here</a> to post one.', 'You do not have any classified listings. <a href=\"%1$s\">Click here</a> to post one.');
INSERT INTO `se_languagevars` VALUES ('4500072', '2', '%1$d visitas', '%1$d views');
INSERT INTO `se_languagevars` VALUES ('4500073', '2', 'Nuevo clasificado', 'View Classified');
INSERT INTO `se_languagevars` VALUES ('4500074', '2', 'Editar clasificado', 'Edit Classified');
INSERT INTO `se_languagevars` VALUES ('4500075', '2', 'Editar fotografías', 'Edit Photos');
INSERT INTO `se_languagevars` VALUES ('4500076', '2', 'Eliminar clasificado', 'Delete Classified');
INSERT INTO `se_languagevars` VALUES ('4500077', '2', 'Configuraciones generales de los listados clasificadas', 'General Classified Settings');
INSERT INTO `se_languagevars` VALUES ('4500078', '2', 'Esta página contiene configuraciones generales delos listados clasificadas que afectan a toda su red social.', 'This page contains general classified settings that affect your entire social network.');
INSERT INTO `se_languagevars` VALUES ('4500079', '2', 'Seleccione si desea o no permitir al público (visitantes que no se han identificado) ver las siguientes secciones de su red social. En algunos casos (como en el de los perfiles, blogs y álbumes), si les ha ofrecido la opción, los usuarios podrán hacer sus páginas privadas a pesar de que usted las haya hecho públicamente visibles aquí. Para acceder a más configuraciones de permisos por favor visite la página <a href=\'admin_general.php\'>Configuración general</a>.', 'Select whether or not you want to let the public (visitors that are not logged-in) to view the following sections of your social network. In some cases (such as Profiles, Blogs, and Albums), if you have given them the option, your users will be able to make their pages private even though you have made them publically viewable here. For more permissions settings, please visit the <a href=\"admin_general.php\">General Settings</a> page.');
INSERT INTO `se_languagevars` VALUES ('4500080', '2', 'Sí, el público puede ver los listados clasificadas, a menos que se hayan convertido en privados.', 'Yes, the public can view classifieds unless they are made private.');
INSERT INTO `se_languagevars` VALUES ('4500081', '2', 'No, el público no puede ver los listados clasificadas.', 'No, the public cannot view classifieds.');
INSERT INTO `se_languagevars` VALUES ('4500082', '2', 'Categorías/Campos de los listados clasificadas.', 'Classified Categories/Fields');
INSERT INTO `se_languagevars` VALUES ('4500083', '2', 'Si lo desea, puede permitir a los usuarios clasificar sus listados clasificadas por tema, ubicación, etc. Los listados clasificadas facilitan a los usuarios de encontrar listados de su interés. Si desea permitir categorías de listados, puede crearlas (junto con subcategorías) a continuación. <br><br>Dentro de cada categoría, usted puede crear campos de listados. Cuando se crea un listado, el creador del grupo (el propietario) describirá el listado completando algunos campos con información sobre el mismo. Añada los campos que desee incluir a continuación.  Algunos ejemplos de campos de listado son \"Ubicación\", \"Correo electrónico del grupo\", \"URL del sitio web\", etc. Recuerde que los campos \"Nombre del listado\" y \"Descripción del listado\" estarán siempre disponibles y serán obligatorios. Arrastre los iconos al lado de las categorías y los campos para reordenarlos. ', 'You may want to allow your users to categorize their classified listings by subject, location, etc. Categorized classified listings make it easier for users to find and classifieds that interest them. If you want to allow classified listing categories, you can create them (along with subcategories) below.<br /><br />Within each category, you can create classified fields. When a classified is created, the creator (owner) will describe the classified by filling in some fields with information about the classified. Add the fields you want to include below. Some examples of classified fields are \"Location\", \"Price\", \"Contact Email\", etc. Remember that a \"Classified Title\" and \"Classified Description\" field will always be available and required. Drag the icons next to the categories and fields to reorder them.');
INSERT INTO `se_languagevars` VALUES ('4500084', '2', 'Categorías de los listados clasificadas.', 'Classified Categories');
INSERT INTO `se_languagevars` VALUES ('4500085', '2', 'Publicar el listado clasificado', 'Post Classified Listing');
INSERT INTO `se_languagevars` VALUES ('4500086', '2', 'Editar el listado clasificado', 'Edit Classified Listing');
INSERT INTO `se_languagevars` VALUES ('4500087', '2', 'Cree su listado a continuación, y luego haga clic en \"Publicar listado\" para publicar el listado. ', 'Write your new listing below, then click \"Post Listing\" to publish the listing on your classified.');
INSERT INTO `se_languagevars` VALUES ('4500088', '2', 'Editar los datos de esta listado clasificado a continuación. ', 'Edit the details of this classified listing below.');
INSERT INTO `se_languagevars` VALUES ('4500089', '2', 'Título de clasificado', 'Classified Title');
INSERT INTO `se_languagevars` VALUES ('4500090', '2', 'Descripción del clasificado', 'Classified Description');
INSERT INTO `se_languagevars` VALUES ('4500091', '2', 'Categoría del listado clasificada.', 'Classified Category');
INSERT INTO `se_languagevars` VALUES ('4500092', '2', '¿Desea incluir este clasificado en los resultados de la búsqueda/exploración?', 'Include this classified in search/browse results?');
INSERT INTO `se_languagevars` VALUES ('4500093', '2', 'Sí, incluir este clasificado en los resultados de la búsqueda/exploración.', 'Yes, include this group in search/browse results.');
INSERT INTO `se_languagevars` VALUES ('4500094', '2', 'No, excluir este clasificado de los resultados de la búsqueda/exploración.', 'No, exclude this group from search/browse results.');
INSERT INTO `se_languagevars` VALUES ('4500095', '2', '¿Quién puede ver este clasificado?', 'Who can see this classified?');
INSERT INTO `se_languagevars` VALUES ('4500096', '2', 'Usted puede decidir quién va a ver este clasificado. ', 'You can decide who gets to see this classified.');
INSERT INTO `se_languagevars` VALUES ('4500097', '2', '¿Desea permitir comentarios?', 'Allow Comments?');
INSERT INTO `se_languagevars` VALUES ('4500098', '2', 'Usted puede decidir quién puede publicar comentarios en este clasificado.  ', 'You can decide who can post comments on this classified.');
INSERT INTO `se_languagevars` VALUES ('4500099', '2', 'Publicar clasificado', 'Post Classified');
INSERT INTO `se_languagevars` VALUES ('4500100', '2', 'Por favor, introduzca un nombre para su clasificado.', 'Please enter a name for your classified.');
INSERT INTO `se_languagevars` VALUES ('4500101', '2', 'Por favor, introduzca una categoría para su clasificado.', 'Please select a category for this classified.');
INSERT INTO `se_languagevars` VALUES ('4500102', '2', 'Volver a Mis Clasificados', 'Back to My Classifieds');
INSERT INTO `se_languagevars` VALUES ('4500103', '2', 'Editar fotografías del listado', 'Edit Listing Photos');
INSERT INTO `se_languagevars` VALUES ('4500104', '2', 'Utilice esta página para cambiar los  fotografías de este listado clasificado', 'Use this page to change the photos shown on this classified listing.');
INSERT INTO `se_languagevars` VALUES ('4500105', '2', 'Su listado clasificado se ha publicado', 'Your classified listing has been posted! Do you want to add some photos?');
INSERT INTO `se_languagevars` VALUES ('4500106', '2', 'Añadir fotografías ahora', 'Add Photos Now');
INSERT INTO `se_languagevars` VALUES ('4500107', '2', 'Quizás más tarde. ', 'Maybe Later');
INSERT INTO `se_languagevars` VALUES ('4500108', '2', 'Pequeña fotografía', 'Small Photo');
INSERT INTO `se_languagevars` VALUES ('4500109', '2', 'Sustituir esta fotografía por:', 'Replace this photo with:');
INSERT INTO `se_languagevars` VALUES ('4500110', '2', 'Eliminar la fotografía', 'delete photo');
INSERT INTO `se_languagevars` VALUES ('4500111', '2', 'Eliminando la fotografía', 'Deleting photo...');
INSERT INTO `se_languagevars` VALUES ('4500112', '2', 'Añadir una fotografía:', 'Add a photo:');
INSERT INTO `se_languagevars` VALUES ('4500113', '2', 'Subir:', 'Upload');
INSERT INTO `se_languagevars` VALUES ('4500114', '2', 'Grandes fotografías', 'Large Photos');
INSERT INTO `se_languagevars` VALUES ('4500115', '2', 'Edite configuraciones generales de los listados clasificadas', 'Edit Classified Settings');
INSERT INTO `se_languagevars` VALUES ('4500116', '2', 'Edite configuraciones de sus listados clasificadas', 'Edit settings pertaining to your classified listings.');
INSERT INTO `se_languagevars` VALUES ('4500117', '2', 'Estilos personalizados de clasificados', 'Custom Classified Styles');
INSERT INTO `se_languagevars` VALUES ('4500118', '2', 'Puede cambiar los colores, fuentes y estilos de sus clasficados añadiendo a continuación el código CSS. El contenido del área de texto a continuación, se mostrará entre las etiquetas &lt;style&gt; en su clasificado.', 'You can change the colors, fonts, and styles of your classified listing by adding CSS code below. The contents of the text area below will be output between &lt;style&gt; tags on your classified listing.');
INSERT INTO `se_languagevars` VALUES ('4500119', '2', 'Notificaciones de los clasificados', 'Classified Notifications');
INSERT INTO `se_languagevars` VALUES ('4500120', '2', 'Notifíqueme por correo electrónico cuando alguien escribe un comentario en mis clasificados. ', 'Notify me by email when someone writes a comment on my classified listings.');
INSERT INTO `se_languagevars` VALUES ('4500121', '2', '¿Desea eliminar este listado clasificado?', 'Delete Classified Listing?');
INSERT INTO `se_languagevars` VALUES ('4500122', '2', '¿Está seguro que desea eliminar este listado clasificado? ', 'Are you sure you want to delete this classified listing?');
INSERT INTO `se_languagevars` VALUES ('4500123', '2', 'Se ha producido un error al procesar su solicitud. ', 'There was an error processing your request.');
INSERT INTO `se_languagevars` VALUES ('4500124', '2', 'Explorar listados clasificados', 'Browse Classified Listings');
INSERT INTO `se_languagevars` VALUES ('4500125', '2', 'Ver:', 'View:');
INSERT INTO `se_languagevars` VALUES ('4500126', '2', 'Ordenar: ', 'Order:');
INSERT INTO `se_languagevars` VALUES ('4500127', '2', 'Clasificados de todos los usuarios', 'Everyone\'s Classifieds');
INSERT INTO `se_languagevars` VALUES ('4500128', '2', 'Clasificados de mis amigos', 'My Friends\' Classifieds');
INSERT INTO `se_languagevars` VALUES ('4500129', '2', 'Recientemente creados', 'Recently Created');
INSERT INTO `se_languagevars` VALUES ('4500130', '2', 'Recientemente actualizados', 'Recently Updated');
INSERT INTO `se_languagevars` VALUES ('4500131', '2', 'La más visitada', 'Most Viewed');
INSERT INTO `se_languagevars` VALUES ('4500132', '2', 'Más comentada ', 'Most Commented');
INSERT INTO `se_languagevars` VALUES ('4500133', '2', 'Todos listados clasificados', 'All Classified Listings');
INSERT INTO `se_languagevars` VALUES ('4500134', '2', 'No se encontraron listados clasificados.', 'No classifieds were found matching your criteria.');
INSERT INTO `se_languagevars` VALUES ('4500135', '2', 'Creada %1$s', 'created %1$s');
INSERT INTO `se_languagevars` VALUES ('4500136', '2', 'actualizado %1$s', 'updated %1$s');
INSERT INTO `se_languagevars` VALUES ('4500137', '2', 'Listado clasificado: %1$s', 'Classified listing: %1$s');
INSERT INTO `se_languagevars` VALUES ('4500138', '2', '<a href=\'%1$s\'>%2$s</a><br>%3$s ha publicado un listado clasificado', 'Classified listing posted by <a href=\'%1$s\'>%2$s</a><br>%3$s');
INSERT INTO `se_languagevars` VALUES ('4500139', '2', '%1$d clasificados', '%1$d classifieds');
INSERT INTO `se_languagevars` VALUES ('4500140', '2', 'HTML en los listados clasificadas', 'HTML in Classified Listings');
INSERT INTO `se_languagevars` VALUES ('4500141', '2', 'Si desea permitir etiquetas HTML específicas, puede introducirlas a continuación (separadas por comas).  Ejemplo: <i>b, img, a, incrustar, fuente<i>Ejemplo: <i> b, img, a, incrustar, fuente <i> ', 'If you want to allow specific HTML tags, you can enter them below (separated by commas). Example: <i>b, img, a, embed, font<i>');
INSERT INTO `se_languagevars` VALUES ('4500142', '2', 'la fotografías de los listados clasificadas ', 'Classified Photo');
INSERT INTO `se_languagevars` VALUES ('4500143', '2', 'listados clasificados de %1$s', '%1$s\'s classified listings');
INSERT INTO `se_languagevars` VALUES ('4500144', '2', 'listados clasificados de %1$s - %2$s', '%1$s\'s classified listing - %2$s');
INSERT INTO `se_languagevars` VALUES ('500387', '2', 'Dirección', '');
INSERT INTO `se_languagevars` VALUES ('500388', '2', '', '');
INSERT INTO `se_languagevars` VALUES ('500389', '2', '', '');

#
# Table structure for table `se_levels`
#

CREATE TABLE `se_levels` (
  `level_id` int(9) NOT NULL AUTO_INCREMENT,
  `level_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `level_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `level_default` int(1) NOT NULL DEFAULT '0',
  `level_signup` int(1) NOT NULL DEFAULT '0',
  `level_message_allow` int(1) NOT NULL DEFAULT '0',
  `level_message_inbox` int(3) NOT NULL DEFAULT '0',
  `level_message_outbox` int(3) NOT NULL DEFAULT '0',
  `level_message_recipients` int(3) NOT NULL DEFAULT '1',
  `level_profile_style` int(1) NOT NULL DEFAULT '0',
  `level_profile_style_sample` int(1) NOT NULL DEFAULT '0',
  `level_profile_block` int(1) NOT NULL DEFAULT '0',
  `level_profile_search` int(1) NOT NULL DEFAULT '0',
  `level_profile_privacy` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `level_profile_comments` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `level_profile_status` int(1) NOT NULL DEFAULT '0',
  `level_profile_invisible` int(1) NOT NULL,
  `level_profile_views` int(1) NOT NULL,
  `level_profile_change` int(1) NOT NULL DEFAULT '0',
  `level_profile_delete` int(1) NOT NULL DEFAULT '0',
  `level_photo_allow` int(1) NOT NULL DEFAULT '0',
  `level_photo_width` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `level_photo_height` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `level_photo_exts` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`level_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_levels`
#

#
# Dumping data for table `se_levels`
#

INSERT INTO `se_levels` VALUES ('1', 'EcoHogar', 'Nivel por defecto de los usuarios.', '1', '0', '2', '100', '50', '10', '1', '1', '1', '1', 'a:6:{i:0;s:1:\"1\";i:1;s:1:\"3\";i:2;s:1:\"7\";i:3;s:2:\"15\";i:4;s:2:\"31\";i:5;s:2:\"63\";}', 'a:7:{i:0;s:1:\"0\";i:1;s:1:\"1\";i:2;s:1:\"3\";i:3;s:1:\"7\";i:4;s:2:\"15\";i:5;s:2:\"31\";i:6;s:2:\"63\";}', '1', '1', '1', '1', '1', '1', '200', '200', 'jpg,jpeg,gif,png');

#
# Table structure for table `se_logins`
#

CREATE TABLE `se_logins` (
  `login_id` int(9) NOT NULL AUTO_INCREMENT,
  `login_email` varchar(70) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `login_date` int(14) NOT NULL DEFAULT '0',
  `login_ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `login_result` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`login_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_logins`
#

#
# Dumping data for table `se_logins`
#

INSERT INTO `se_logins` VALUES ('1', 'cyberalpha@gmail.com', '1357838987', '127.0.0.1', '1');
INSERT INTO `se_logins` VALUES ('2', 'cyberalpha@gmail.com', '1357840602', '127.0.0.1', '1');

#
# Table structure for table `se_notifys`
#

CREATE TABLE `se_notifys` (
  `notify_id` int(9) NOT NULL AUTO_INCREMENT,
  `notify_user_id` int(9) NOT NULL DEFAULT '0',
  `notify_notifytype_id` int(9) NOT NULL DEFAULT '0',
  `notify_object_id` int(9) NOT NULL,
  `notify_urlvars` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `notify_text` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`notify_id`),
  KEY `notify_user_id` (`notify_user_id`),
  KEY `notify_object_id` (`notify_object_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_notifys`
#

#
# Dumping data for table `se_notifys`
#


#
# Table structure for table `se_notifytypes`
#

CREATE TABLE `se_notifytypes` (
  `notifytype_id` int(9) NOT NULL AUTO_INCREMENT,
  `notifytype_icon` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `notifytype_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `notifytype_title` int(9) NOT NULL DEFAULT '0',
  `notifytype_url` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `notifytype_desc` int(9) NOT NULL DEFAULT '0',
  `notifytype_group` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`notifytype_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_notifytypes`
#

#
# Dumping data for table `se_notifytypes`
#

INSERT INTO `se_notifytypes` VALUES ('1', 'menu_friends.gif', 'friendrequest', '750004', 'user_friends_requests.php', '750001', '1');
INSERT INTO `se_notifytypes` VALUES ('2', 'menu_messages.gif', 'message', '750005', 'user_messages.php', '750002', '1');
INSERT INTO `se_notifytypes` VALUES ('3', 'action_postcomment.gif', 'profilecomment', '750006', 'profile.php?user=%1$s&v=comments', '750003', '1');

#
# Table structure for table `se_plugins`
#

CREATE TABLE `se_plugins` (
  `plugin_id` int(9) NOT NULL AUTO_INCREMENT,
  `plugin_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `plugin_version` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `plugin_type` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `plugin_desc` text COLLATE utf8_unicode_ci NOT NULL,
  `plugin_icon` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `plugin_menu_title` int(9) NOT NULL,
  `plugin_pages_main` text COLLATE utf8_unicode_ci NOT NULL,
  `plugin_pages_level` text COLLATE utf8_unicode_ci NOT NULL,
  `plugin_url_htaccess` text COLLATE utf8_unicode_ci NOT NULL,
  `plugin_disabled` tinyint(1) NOT NULL DEFAULT '0',
  `plugin_order` smallint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`plugin_id`),
  UNIQUE KEY `plugin_type` (`plugin_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_plugins`
#

#
# Dumping data for table `se_plugins`
#


#
# Table structure for table `se_pmconvoops`
#

CREATE TABLE `se_pmconvoops` (
  `pmconvoop_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pmconvoop_pmconvo_id` int(10) unsigned NOT NULL DEFAULT '0',
  `pmconvoop_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `pmconvoop_read` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `pmconvoop_deleted_inbox` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `pmconvoop_deleted_outbox` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `pmconvoop_pmdate` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pmconvoop_id`),
  UNIQUE KEY `INDEX` (`pmconvoop_pmconvo_id`,`pmconvoop_user_id`),
  KEY `total_outbox` (`pmconvoop_user_id`,`pmconvoop_deleted_outbox`,`pmconvoop_read`),
  KEY `last_pm_date` (`pmconvoop_pmdate`),
  KEY `total_inbox` (`pmconvoop_user_id`,`pmconvoop_deleted_inbox`,`pmconvoop_read`,`pmconvoop_pmdate`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_pmconvoops`
#

#
# Dumping data for table `se_pmconvoops`
#


#
# Table structure for table `se_pmconvos`
#

CREATE TABLE `se_pmconvos` (
  `pmconvo_id` int(9) NOT NULL AUTO_INCREMENT,
  `pmconvo_subject` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pmconvo_recipients` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`pmconvo_id`),
  KEY `pmconvo_recipients` (`pmconvo_recipients`),
  FULLTEXT KEY `SEARCH` (`pmconvo_subject`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_pmconvos`
#

#
# Dumping data for table `se_pmconvos`
#


#
# Table structure for table `se_pms`
#

CREATE TABLE `se_pms` (
  `pm_id` int(9) NOT NULL AUTO_INCREMENT,
  `pm_authoruser_id` int(9) NOT NULL DEFAULT '0',
  `pm_pmconvo_id` int(9) NOT NULL DEFAULT '0',
  `pm_date` int(14) NOT NULL DEFAULT '0',
  `pm_body` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`pm_id`),
  KEY `pm_pmconvo_id` (`pm_pmconvo_id`),
  KEY `list_subquery` (`pm_pmconvo_id`,`pm_authoruser_id`,`pm_id`),
  FULLTEXT KEY `SEARCH` (`pm_body`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_pms`
#

#
# Dumping data for table `se_pms`
#


#
# Table structure for table `se_profilecats`
#

CREATE TABLE `se_profilecats` (
  `profilecat_id` int(9) NOT NULL AUTO_INCREMENT,
  `profilecat_title` int(9) NOT NULL DEFAULT '0',
  `profilecat_dependency` int(9) NOT NULL DEFAULT '0',
  `profilecat_order` int(2) NOT NULL DEFAULT '0',
  `profilecat_signup` int(1) NOT NULL,
  PRIMARY KEY (`profilecat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_profilecats`
#

#
# Dumping data for table `se_profilecats`
#

INSERT INTO `se_profilecats` VALUES ('1', '500362', '0', '1', '1');
INSERT INTO `se_profilecats` VALUES ('2', '500363', '0', '2', '0');
INSERT INTO `se_profilecats` VALUES ('3', '500364', '1', '1', '0');
INSERT INTO `se_profilecats` VALUES ('5', '500366', '2', '1', '0');

#
# Table structure for table `se_profilecomments`
#

CREATE TABLE `se_profilecomments` (
  `profilecomment_id` int(9) NOT NULL AUTO_INCREMENT,
  `profilecomment_user_id` int(9) NOT NULL DEFAULT '0',
  `profilecomment_authoruser_id` int(9) NOT NULL DEFAULT '0',
  `profilecomment_date` int(14) NOT NULL DEFAULT '0',
  `profilecomment_body` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`profilecomment_id`),
  KEY `profilecomment_user_id` (`profilecomment_user_id`,`profilecomment_authoruser_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_profilecomments`
#

#
# Dumping data for table `se_profilecomments`
#


#
# Table structure for table `se_profilefields`
#

CREATE TABLE `se_profilefields` (
  `profilefield_id` int(9) NOT NULL AUTO_INCREMENT,
  `profilefield_profilecat_id` int(9) NOT NULL DEFAULT '0',
  `profilefield_order` int(3) NOT NULL DEFAULT '0',
  `profilefield_dependency` int(9) NOT NULL DEFAULT '0',
  `profilefield_title` int(9) NOT NULL DEFAULT '0',
  `profilefield_desc` int(9) NOT NULL DEFAULT '0',
  `profilefield_error` int(9) NOT NULL DEFAULT '0',
  `profilefield_type` int(1) NOT NULL DEFAULT '0',
  `profilefield_signup` int(1) NOT NULL DEFAULT '0',
  `profilefield_style` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `profilefield_maxlength` int(3) NOT NULL DEFAULT '0',
  `profilefield_link` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `profilefield_options` longtext COLLATE utf8_unicode_ci,
  `profilefield_display` int(1) NOT NULL DEFAULT '1',
  `profilefield_required` int(1) NOT NULL DEFAULT '0',
  `profilefield_regex` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `profilefield_special` int(1) NOT NULL DEFAULT '0',
  `profilefield_html` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `profilefield_search` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`profilefield_id`),
  KEY `INDEX` (`profilefield_profilecat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_profilefields`
#

#
# Dumping data for table `se_profilefields`
#

INSERT INTO `se_profilefields` VALUES ('2', '3', '1', '0', '500370', '500371', '500372', '1', '1', '', '30', '', 'N;', '1', '1', '', '2', '', '1');
INSERT INTO `se_profilefields` VALUES ('8', '3', '6', '0', '500390', '500391', '500392', '1', '1', '', '30', '', 'N;', '1', '0', '', '0', '', '0');
INSERT INTO `se_profilefields` VALUES ('9', '3', '7', '0', '500393', '500394', '500395', '1', '1', '', '30', '', 'N;', '1', '0', '', '0', '', '0');
INSERT INTO `se_profilefields` VALUES ('10', '3', '8', '0', '500396', '500397', '500398', '1', '1', '', '30', '', 'N;', '1', '0', '', '0', '', '0');
INSERT INTO `se_profilefields` VALUES ('11', '3', '9', '0', '500399', '500400', '500401', '1', '1', '', '30', '', 'N;', '1', '0', '', '0', '', '0');
INSERT INTO `se_profilefields` VALUES ('12', '3', '10', '0', '500402', '500403', '500404', '1', '1', '', '30', '', 'N;', '1', '0', '', '0', '', '0');
INSERT INTO `se_profilefields` VALUES ('13', '3', '11', '0', '500405', '500406', '500407', '1', '1', '', '30', '', 'N;', '1', '0', '', '0', '', '0');
INSERT INTO `se_profilefields` VALUES ('7', '3', '5', '0', '500387', '500388', '500389', '1', '1', '', '30', '', 'N;', '1', '1', '', '0', '', '1');

#
# Table structure for table `se_profilestyles`
#

CREATE TABLE `se_profilestyles` (
  `profilestyle_id` int(9) NOT NULL AUTO_INCREMENT,
  `profilestyle_user_id` int(9) NOT NULL DEFAULT '0',
  `profilestyle_css` text COLLATE utf8_unicode_ci,
  `profilestyle_stylesample_id` int(9) NOT NULL DEFAULT '0',
  PRIMARY KEY (`profilestyle_id`),
  KEY `profilestyle_user_id` (`profilestyle_user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_profilestyles`
#

#
# Dumping data for table `se_profilestyles`
#

INSERT INTO `se_profilestyles` VALUES ('1', '1', '/* PROFILE CSS TEMPLATE  */\r\n/*     BLACKXS_FULL      */\r\n/* www.solarianoir.net   */\r\n\r\n\r\n\r\n/* GLOBAL STYLES */\r\n\r\nbody {\r\n	background: #393939 url(./images/sample_styles/blackxs/background.jpg) top center no-repeat; \r\n    /* custom cursor for Firefox, IE */ \r\n	cursor: url(./images/sample_styles/blackxs/cursor.cur), url(./images/sample_styles/pinkviolet/blackxs.gif), auto;\r\n	/* scrollbar colours */ \r\n	scrollbar-face-color: #212121;\r\n	scrollbar-highlight-color: #404040;\r\n	scrollbar-shadow-color: #000000;\r\n	scrollbar-3dlight-color: #616161;\r\n	scrollbar-arrow-color:  #A1A1A1;\r\n	scrollbar-track-color: #000000;\r\n	scrollbar-darkshadow-color: #000000;\r\n    padding-top: 126px; /* distance between top of page and content */\r\n    padding-bottom: 20px; /* distance between bottom of page and content */\r\n}\r\n\r\n\r\n/* Top Menu Links */\r\na.top_menu_item:link { color: #dddddd; background: url(./images/sample_styles/blackxs/twinkle.gif); text-decoration: none; }\r\na.top_menu_item:visited { color: #dddddd; background: url(./images/sample_styles/blackxs/twinkle.gif); text-decoration: none; }\r\na.top_menu_item:hover { color: #FFFFFF; background: none; text-decoration: none; }\r\n\r\n/* LOGGED IN Menu Links */\r\na.menu_item:link { color: #dddddd; background: url(./images/sample_styles/blackxs/twinkle.gif); text-decoration: none; }\r\na.menu_item:visited { color: #dddddd; background: url(./images/sample_styles/blackxs/twinkle.gif); text-decoration: none; }\r\na.menu_item:hover { color: #ffffff; background: none; text-decoration: none; }\r\n\r\n/* Global Links */\r\na:link { color: #dddddd; text-decoration: none; }\r\na:visited { color: #dddddd; text-decoration: none; }\r\na:hover { color: #ffffff; background: url(./images/sample_styles/blackxs/twinkle.gif); text-decoration: none; }\r\n\r\n/* Override All Links */\r\na {\r\n    font-weight: bold;\r\n}\r\n\r\n\r\n/* Content Box */\r\ntd.content {\r\n	background: transparent;\r\n	padding: 6px;\r\n}\r\n\r\n/* Applies to most interior content */\r\ndiv, td {\r\n	background: transparent;\r\n	font-family: arial; /* almost global font */\r\n	font-size: 11px;\r\n	color: #dddddd;\r\n}\r\n\r\n\r\n/* TOP MENU */\r\ntd.top_menu {\r\n	background: transparent;\r\n	border: 1px solid #AAAAAA;\r\n	border-right: none;\r\n}\r\n\r\ntd.top_menu img {\r\n	display: none;\r\n}\r\n\r\ntd.top_menu2 {\r\n	background: transparent;\r\n	border: 1px solid #AAAAAA;\r\n	border-left: none;\r\n}\r\n\r\n\r\n/* USER MENU */\r\ntd.menu_user {\r\n	background: transparent;\r\n}\r\ndiv.menu_dropdown {\r\n	background: #444444;\r\n}\r\ndiv.menu_item_dropdown a:hover {\r\n	background: transparent;\r\n}\r\n\r\n\r\n/* Yourname\'s profile Bar */\r\ndiv.page_header {\r\n	font-size: 16px;\r\n	font-weight: bold;\r\n	color: #ffffff;\r\n	background: transparent;\r\n	margin-bottom: 0px;\r\n	padding-top: 6px;\r\n	padding-left: 6px;\r\n}\r\n\r\n/* Global Headers - Titles */\r\ntd.header {\r\n	padding: 4px 2px 4px 4px;\r\n	border: 1px solid #666666;\r\n	border-bottom: none;\r\n	font-weight: bold;\r\n	background: #444444;\r\n	color: #ffffff;\r\n}\r\n\r\n\r\n\r\ntextarea {\r\n	color: #eeeeee;\r\n	height:100px;\r\n	background: transparent;\r\n	font-size: 12px;\r\n}\r\n\r\nimg.signup_code {\r\n	background: #ffffff;\r\n	padding: 0px;\r\n	border-width: 2px;\r\n	border-color: #000000;\r\n}\r\n\r\n\r\n\r\n\r\n\r\n/* PROFILE STYLES */\r\n\r\n/* Profile box */\r\ntd.profile {\r\n	background: #333333;\r\n	border-width: 1px; /* adjust the width for styling of content borders - 0 to remove borders */\r\n	border-color: #777777;\r\n	/* padding values to vary the distance between interior borders and their content */\r\n	padding-top: 12px;\r\n	padding-right: 12px;\r\n	padding-bottom: 12px; \r\n	padding-left: 12px;\r\n}\r\n\r\ntd.profile_tab a, td.profile_tab a:hover {\r\n	background-color: transparent;\r\n	padding: 7px 10px 7px 10px;\r\n	border: 1px solid #AAAAAA; \r\n	border-left: none;\r\n	font-weight: bold; \r\n	display: block;\r\n}\r\ntd.profile_tab a:hover {\r\n	background-color: #333333;\r\n}\r\ntd.profile_tab2 a, td.profile_tab2 a:hover {\r\n	background-color: #333333;\r\n	padding: 7px 10px 8px 10px;\r\n	border: 1px solid #AAAAAA; \r\n	border-left: none;\r\n	border-bottom: none;\r\n	font-weight: bold; \r\n	display: block;\r\n}\r\n#profile_tabs_profile { \r\n	border-left: 1px solid #AAAAAA;\r\n}\r\ntd.profile_tab_end {\r\n	border-bottom: 1px solid #AAAAAA;\r\n}\r\ndiv.profile_content {\r\n        background-color: #333333;\r\n}\r\n\r\ntd.profile_tab a { background: transparent; }\r\ntd.profile_tab a:hover { background: transparent; background: url(./images/sample_styles/blackxs/twinkle.gif); text-decoration: none; }\r\n\r\ndiv.browse_friends_result { background: transparent; }\r\n\r\ndiv.profile_comment_author { background: transparent; }\r\ndiv.profile_comment_date { background: transparent; }\r\ndiv.profile_postcomment { background: transparent; }\r\n\r\n/* Recent Activity */\r\ndiv.profile_action  {\r\n	border-bottom-width: 1px;\r\n	border-bottom-style: solid;\r\n	border-bottom-color: #444444;\r\n	font-size: 14px;\r\n}\r\n\r\n/* Profile Photo */\r\ntd.profile_photo {\r\n	padding: 0px;\r\n	padding-bottom: 8px;\r\n	background: url(./images/sample_styles/blackxs/spark.gif) no-repeat bottom;\r\n    border:0px;\r\n    border-color: #555555;\r\n    border-style: dotted;\r\n}\r\n\r\nimg.photo {\r\n	padding: 4px;\r\n    border-color: transparent;\r\n	\r\n}\r\n\r\n\r\n/* PAGE FOOTER */\r\ndiv.copyright a:link { color: #6A6962; text-decoration: none; }\r\ndiv.copyright a:visited { color: #6A6962; text-decoration: none; }\r\ndiv.copyright a:hover { color: #222222; text-decoration: none; }\r\ndiv.copyright { background: transparent; border: 1px solid #AAAAAA; }\r\n\r\n\r\n\r\n/* image verification input */\r\ninput.text, input.text_small {\r\n	border-color: #666666;\r\n	font-size: 12px;\r\n	color: #cccccc;\r\n	background-color: #444444;\r\n}\r\n\r\n', '0');

#
# Table structure for table `se_profilevalues`
#

CREATE TABLE `se_profilevalues` (
  `profilevalue_id` int(9) NOT NULL AUTO_INCREMENT,
  `profilevalue_user_id` int(9) NOT NULL DEFAULT '0',
  `profilevalue_2` varchar(250) COLLATE utf8_unicode_ci DEFAULT '',
  `profilevalue_7` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `profilevalue_8` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `profilevalue_9` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `profilevalue_10` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `profilevalue_11` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `profilevalue_12` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `profilevalue_13` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`profilevalue_id`),
  KEY `INDEX` (`profilevalue_user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_profilevalues`
#

#
# Dumping data for table `se_profilevalues`
#

INSERT INTO `se_profilevalues` VALUES ('1', '1', 'Celestina', 'Av. Almirante Brown', '1284', '1865', 'San Martín', 'San Vicente', 'Buenos Aires', 'Argentina');

#
# Table structure for table `se_profileviews`
#

CREATE TABLE `se_profileviews` (
  `profileview_user_id` int(1) NOT NULL,
  `profileview_views` int(9) NOT NULL,
  `profileview_viewers` text COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `profileview_user_id` (`profileview_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_profileviews`
#

#
# Dumping data for table `se_profileviews`
#

INSERT INTO `se_profileviews` VALUES ('1', '1', '');

#
# Table structure for table `se_reports`
#

CREATE TABLE `se_reports` (
  `report_id` int(9) NOT NULL AUTO_INCREMENT,
  `report_user_id` int(9) NOT NULL DEFAULT '0',
  `report_url` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `report_reason` int(1) NOT NULL DEFAULT '0',
  `report_details` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`report_id`),
  KEY `INDEX` (`report_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_reports`
#

#
# Dumping data for table `se_reports`
#


#
# Table structure for table `se_session_auth`
#

CREATE TABLE `se_session_auth` (
  `session_auth_key` char(40) COLLATE utf8_unicode_ci NOT NULL,
  `session_auth_user_id` int(9) NOT NULL,
  `session_auth_ip` int(9) NOT NULL,
  `session_auth_ua` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `session_auth_type` tinyint(1) NOT NULL,
  `session_auth_time` int(9) NOT NULL,
  PRIMARY KEY (`session_auth_key`),
  KEY `CLEANUP` (`session_auth_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_session_auth`
#

#
# Dumping data for table `se_session_auth`
#


#
# Table structure for table `se_session_data`
#

CREATE TABLE `se_session_data` (
  `session_data_id` char(32) NOT NULL,
  `session_data_body` longtext NOT NULL,
  `session_data_expires` int(11) NOT NULL,
  PRIMARY KEY (`session_data_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# End Structure for table `se_session_data`
#

#
# Dumping data for table `se_session_data`
#


#
# Table structure for table `se_settings`
#

CREATE TABLE `se_settings` (
  `setting_id` int(9) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `setting_version` varchar(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `setting_online` tinyint(1) NOT NULL DEFAULT '1',
  `setting_url` tinyint(1) NOT NULL DEFAULT '0',
  `setting_username` tinyint(1) NOT NULL DEFAULT '1',
  `setting_password_method` tinyint(1) NOT NULL DEFAULT '1',
  `setting_password_code_length` tinyint(2) NOT NULL DEFAULT '16',
  `setting_lang_allow` int(1) NOT NULL DEFAULT '1',
  `setting_lang_autodetect` tinyint(1) NOT NULL DEFAULT '1',
  `setting_lang_anonymous` tinyint(1) NOT NULL DEFAULT '1',
  `setting_timezone` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '-8',
  `setting_dateformat` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n/j/Y',
  `setting_timeformat` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'g:i A',
  `setting_permission_profile` tinyint(1) NOT NULL DEFAULT '1',
  `setting_permission_invite` tinyint(1) NOT NULL DEFAULT '1',
  `setting_permission_search` tinyint(1) NOT NULL DEFAULT '1',
  `setting_permission_portal` tinyint(1) NOT NULL DEFAULT '1',
  `setting_banned_ips` text COLLATE utf8_unicode_ci,
  `setting_banned_emails` text COLLATE utf8_unicode_ci,
  `setting_banned_usernames` text COLLATE utf8_unicode_ci,
  `setting_banned_words` text COLLATE utf8_unicode_ci,
  `setting_comment_code` tinyint(1) NOT NULL DEFAULT '0',
  `setting_comment_html` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `setting_connection_allow` tinyint(1) NOT NULL DEFAULT '3',
  `setting_connection_framework` tinyint(1) NOT NULL DEFAULT '0',
  `setting_connection_types` text COLLATE utf8_unicode_ci,
  `setting_connection_other` tinyint(1) NOT NULL DEFAULT '1',
  `setting_connection_explain` tinyint(1) NOT NULL DEFAULT '1',
  `setting_signup_photo` tinyint(1) NOT NULL DEFAULT '0',
  `setting_signup_enable` tinyint(1) NOT NULL DEFAULT '1',
  `setting_signup_welcome` tinyint(1) NOT NULL DEFAULT '1',
  `setting_signup_invite` tinyint(1) NOT NULL DEFAULT '0',
  `setting_signup_invite_checkemail` tinyint(1) NOT NULL DEFAULT '0',
  `setting_signup_invite_numgiven` smallint(3) NOT NULL DEFAULT '5',
  `setting_signup_invitepage` tinyint(1) NOT NULL DEFAULT '0',
  `setting_signup_verify` tinyint(1) NOT NULL DEFAULT '0',
  `setting_signup_code` tinyint(1) NOT NULL DEFAULT '1',
  `setting_signup_randpass` tinyint(1) NOT NULL DEFAULT '0',
  `setting_signup_tos` tinyint(1) NOT NULL DEFAULT '1',
  `setting_invite_code` tinyint(1) NOT NULL DEFAULT '1',
  `setting_actions_showlength` int(14) NOT NULL DEFAULT '2629743',
  `setting_actions_actionsperuser` smallint(2) NOT NULL DEFAULT '7',
  `setting_actions_selfdelete` smallint(2) NOT NULL DEFAULT '1',
  `setting_actions_privacy` smallint(2) NOT NULL DEFAULT '1',
  `setting_actions_actionsonprofile` smallint(2) NOT NULL DEFAULT '7',
  `setting_actions_actionsinlist` smallint(2) NOT NULL DEFAULT '35',
  `setting_actions_visibility` smallint(2) NOT NULL DEFAULT '1',
  `setting_actions_preference` smallint(1) NOT NULL DEFAULT '1',
  `setting_subnet_field1_id` int(9) NOT NULL DEFAULT '-2',
  `setting_subnet_field2_id` int(9) NOT NULL DEFAULT '-2',
  `setting_email_fromname` varchar(70) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `setting_email_fromemail` varchar(70) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `setting_cache_enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `setting_cache_default` varchar(32) COLLATE utf8_unicode_ci DEFAULT 'file',
  `setting_cache_lifetime` int(9) unsigned DEFAULT '120',
  `setting_cache_file_options` text COLLATE utf8_unicode_ci,
  `setting_cache_memcache_options` text COLLATE utf8_unicode_ci,
  `setting_cache_xcache_options` text COLLATE utf8_unicode_ci,
  `setting_session_options` text COLLATE utf8_unicode_ci,
  `setting_contact_code` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `setting_login_code` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `setting_login_code_failedcount` smallint(2) unsigned NOT NULL DEFAULT '0',
  `setting_stats_remote` tinyint(1) NOT NULL DEFAULT '1',
  `setting_stats_remote_last` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`setting_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_settings`
#

#
# Dumping data for table `se_settings`
#

INSERT INTO `se_settings` VALUES ('1', '7745-3022-8989-5184', '3.20', '1', '0', '1', '1', '16', '1', '1', '1', '-3', 'j/n/Y', 'H:i', '1', '1', '1', '1', '', '', '', '', '0', 'b,img,a,br', '3', '0', 'Significant Other<!>Friend<!>Co-Worker<!>test<!>test2<!>test3<!>test4', '1', '1', '1', '1', '1', '0', '0', '50', '0', '0', '1', '0', '1', '1', '2629743', '7', '1', '1', '7', '35', '1', '1', '-2', '-2', 'Site Administrator', 'email@domain.com', '0', 'file', '120', 'a:2:{s:4:\"root\";s:7:\"./cache\";s:7:\"locking\";b:1;}', 'a:1:{s:7:\"servers\";a:1:{i:0;a:2:{s:4:\"host\";s:9:\"localhost\";s:4:\"port\";i:11211;}}}', '', 'a:4:{s:7:\"storage\";s:4:\"none\";s:6:\"expire\";i:259200;s:4:\"name\";s:32:\"48527d738453dbef7cdf686804efdac7\";s:7:\"servers\";a:1:{i:0;a:2:{s:4:\"host\";s:9:\"localhost\";s:4:\"port\";i:11211;}}}', '1', '0', '0', '0', '0');

#
# Table structure for table `se_statrefs`
#

CREATE TABLE `se_statrefs` (
  `statref_id` int(9) NOT NULL AUTO_INCREMENT,
  `statref_hits` int(9) NOT NULL DEFAULT '0',
  `statref_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`statref_id`),
  UNIQUE KEY `statref_url` (`statref_url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_statrefs`
#

#
# Dumping data for table `se_statrefs`
#


#
# Table structure for table `se_stats`
#

CREATE TABLE `se_stats` (
  `stat_id` int(9) NOT NULL AUTO_INCREMENT,
  `stat_date` int(9) NOT NULL DEFAULT '0',
  `stat_views` int(9) NOT NULL DEFAULT '0',
  `stat_logins` int(9) NOT NULL DEFAULT '0',
  `stat_signups` int(9) NOT NULL DEFAULT '0',
  `stat_friends` int(9) NOT NULL DEFAULT '0',
  PRIMARY KEY (`stat_id`),
  UNIQUE KEY `stat_date` (`stat_date`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_stats`
#

#
# Dumping data for table `se_stats`
#

INSERT INTO `se_stats` VALUES ('1', '1357786800', '52', '2', '1', '0');

#
# Table structure for table `se_stylesamples`
#

CREATE TABLE `se_stylesamples` (
  `stylesample_id` int(9) NOT NULL AUTO_INCREMENT,
  `stylesample_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `stylesample_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `stylesample_thumb` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `stylesample_css` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`stylesample_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_stylesamples`
#

#
# Dumping data for table `se_stylesamples`
#

INSERT INTO `se_stylesamples` VALUES ('1', 'profile', 'Beige', 'beige/beige_full.gif', '/* PROFILE CSS TEMPLATE  */\r\n/*      BEIGE_FULL       */\r\n/* www.solarianoir.net   */\r\n\r\n\r\n\r\n/* GLOBAL STYLES */\r\n\r\nbody {\r\n    background:#DEDBC5 url(./images/sample_styles/beige/back_shadow.png) center repeat-y;    \r\n	/* custom cursor for IE, Firefox */ \r\n	cursor: url(./images/sample_styles/beige/cursor.cur), url(./images/sample_styles/beige/cursor.gif), auto;\r\n	/* scrollbar colours */ \r\n    scrollbar-arrow-color:#43260C;\r\n    scrollbar-track-color:#E9E2CF;\r\n    scrollbar-shadow-color:#E9E2CF;\r\n    scrollbar-face-color:#E9E2CF;\r\n    scrollbar-highlight-color:#E9E2CF;\r\n    scrollbar-darkshadow-color:#ffffff;\r\n    scrollbar-3dlight-color:#ffffff;\r\n    padding-top: 0px; /* distance between top of page and content */\r\n    padding-bottom: 0px; /* distance between bottom of page and content */\r\n}\r\n\r\n/* all links to bold */\r\na {\r\n	font-weight: bold;\r\n}\r\n\r\n/* LOGGED IN Menu Links */\r\na.menu_item:link { color: #7B7A70; text-decoration: none; }\r\na.menu_item:visited { color: #7B7A70; text-decoration: none; }\r\na.menu_item:hover { color: #222222; text-decoration: none; }\r\n\r\n/* Global Links */\r\na:link { color: #6A6962; text-decoration: none; }\r\na:visited { color: #6A6962; text-decoration: none; }\r\na:hover { color: #222222; text-decoration: none; }\r\n\r\n/* Content Box */\r\ndiv.content {\r\n	background: url(./images/sample_styles/beige/back_content.png);\r\n	padding: 6px;\r\n}\r\n\r\n/* Applies to most interior content */\r\ndiv, td {\r\n	background: transparent;\r\n	font-family: Arial; /* almost global font */\r\n	font-size: 11px;\r\n	color: #6A6962;\r\n}\r\n\r\n\r\n/* Yourname\'s profile Bar */\r\ndiv.page_header {\r\n    background: url(./images/sample_styles/beige/page_header.jpg) repeat-x;\r\n    text-align: right;\r\n    line-height: 42px;\r\n    font-size: 16px;\r\n    font-weight: bold;\r\n    color: #ffffff;\r\n    background-color: #D6D3BE;\r\n    padding: 0px 0px 0px 0px;\r\n}\r\n\r\n/* Global Headers - Titles */\r\ntd.header {\r\n	padding: 4px 2px 4px 4px;\r\n	border: 1px solid #F1EED9;\r\n	border-bottom: none;\r\n	background-image: none;\r\n	background-repeat: repeat-x;\r\n	color: #6A6962;\r\n	background: url(./images/sample_styles/beige/header.png);\r\n}\r\n\r\n\r\n\r\n/* Write Something - Post Comment */\r\ntextarea {\r\n	color: #6A6962;\r\n	height:100px;\r\n	background: none; \r\n	font-size: 12px;\r\n}\r\n\r\nimg.signup_code {\r\n	background: #ffffff;\r\n	padding: 0px;\r\n	border-width: 2px;\r\n	border-color: #ffffff;\r\n}\r\n\r\n/* image verification input */\r\ninput.text, input.text_small {\r\n	border-color: #ffffff;\r\n	font-size: 11px;\r\n	font-weight: bold;\r\n	color: #ffffff;\r\n	background-color: #B5B3A1;\r\n}\r\n\r\n/* PROFILE STYLES */\r\n\r\n/* Profile box */\r\ntd.profile {\r\n	background-color: #B8B6A7;\r\n    background: transparent;\r\n	border-width: 1px; /* adjust the width for styling of content borders - 0 to remove borders */\r\n	border-color: #F1EED9;\r\n	/* padding values to vary the distance between interior borders and their content */\r\n	padding-top: 12px;\r\n	padding-right: 22px;\r\n	padding-bottom: 12px; \r\n	padding-left: 22px;\r\n}\r\n\r\n\r\ntd.profile_tab a {\r\n	background-color: #d0cdb7;\r\n	padding: 7px 10px 7px 10px;\r\n	border: 1px solid #AAAAAA; \r\n	border-left: none;\r\n	font-weight: bold; \r\n	display: block;\r\n}\r\ntd.profile_tab a:hover {\r\n	background-color: #d7d4bf;\r\n	padding: 7px 10px 7px 10px;\r\n	border: 1px solid #AAAAAA; \r\n	border-left: none;\r\n	font-weight: bold; \r\n	display: block;\r\n}\r\ntd.profile_tab2 a, td.profile_tab2 a:hover {\r\n	background-color: #dedbc4;\r\n	padding: 7px 10px 8px 10px;\r\n	border: 1px solid #AAAAAA; \r\n	border-left: none;\r\n	border-bottom: none;\r\n	font-weight: bold; \r\n	display: block;\r\n}\r\n#profile_tabs_profile { \r\n	border-left: 1px solid #AAAAAA;\r\n}\r\ntd.profile_tab_end {\r\n	border-bottom: 1px solid #AAAAAA;\r\n}\r\n\r\n\r\n/* Recent Activity */\r\ndiv.profile_action  {\r\n	border-bottom-width: 1px;\r\n	border-bottom-style: solid;\r\n	border-bottom-color: #CFCDBB;\r\n	font-size: 14px;\r\n\r\n}\r\n\r\ndiv.profile_action_date {\r\n	color: #6A6962;\r\n	float: right;\r\n	padding-left: 5px;\r\n}\r\n\r\n/* Profile Photo */\r\ntd.profile_photo {\r\n	padding: 4px;\r\n	background-color: #B8B6A7;\r\n    border:1px #FFFCE2 dotted;\r\n}\r\n\r\nimg.photo {\r\n	border-top: 1px;\r\n	border-color: #DEDBC5;\r\n}\r\n\r\n/* PAGE FOOTER */\r\ndiv.copyright a:link { color: #6A6962; text-decoration: none; }\r\ndiv.copyright a:visited { color: #6A6962; text-decoration: none; }\r\ndiv.copyright a:hover { color: #222222; text-decoration: none; }');
INSERT INTO `se_stylesamples` VALUES ('2', 'profile', 'Beige II', 'beige/beige2_full.gif', '/* PROFILE CSS TEMPLATE  */\r\n/*      BEIGE2_FULL       */\r\n/* www.solarianoir.net   */\r\n\r\n\r\n\r\n/* GLOBAL STYLES */\r\n\r\nbody {\r\n    background:#DEDBC5 url(./images/sample_styles/beige/back_shadow2.jpg) top center no-repeat;    \r\n	/* custom cursor for IE, Firefox */ \r\n	cursor: url(./images/sample_styles/beige/cursor.cur), url(./images/sample_styles/beige/cursor.gif), auto;\r\n	/* scrollbar colours */ \r\n    scrollbar-arrow-color:#43260C;\r\n    scrollbar-track-color:#E9E2CF;\r\n    scrollbar-shadow-color:#E9E2CF;\r\n    scrollbar-face-color:#E9E2CF;\r\n    scrollbar-highlight-color:#E9E2CF;\r\n    scrollbar-darkshadow-color:#ffffff;\r\n    scrollbar-3dlight-color:#ffffff;\r\n    padding-top: 0px; /* distance between top of page and content */\r\n    padding-bottom: 0px; /* distance between bottom of page and content */\r\n}\r\n\r\n/* all links to bold */\r\na {\r\n	font-weight: bold;\r\n}\r\n\r\n/* LOGGED IN Menu Links */\r\na.menu_item:link { color: #7B7A70; text-decoration: none; }\r\na.menu_item:visited { color: #7B7A70; text-decoration: none; }\r\na.menu_item:hover { color: #222222; text-decoration: none; }\r\n\r\n/* Global Links */\r\na:link { color: #6A6962; text-decoration: none; }\r\na:visited { color: #6A6962; text-decoration: none; }\r\na:hover { color: #222222; text-decoration: none; }\r\n\r\n/* Content Box */\r\ndiv.content {\r\n	background: url(./images/sample_styles/beige/back_content.png);\r\n	padding: 6px;\r\n}\r\n\r\n/* Applies to most interior content */\r\ndiv, td {\r\n	background: transparent;\r\n	font-family: Arial; /* almost global font */\r\n	font-size: 11px;\r\n	color: #6A6962;\r\n}\r\n\r\n\r\n/* Yourname\'s profile Bar */\r\ndiv.page_header {\r\n    background: url(./images/sample_styles/beige/page_header2.jpg) repeat-x;\r\n    text-align: right;\r\n    line-height: 42px;\r\n    font-size: 16px;\r\n    font-weight: bold;\r\n    color: #ffffff;\r\n    background-color: #D6D3BE;\r\n    padding: 0px 0px 0px 0px;\r\n}\r\n\r\n/* Global Headers - Titles */\r\ntd.header {\r\n	padding: 4px 2px 4px 4px;\r\n	border: 1px solid #F1EED9;\r\n	border-bottom: none;\r\n	background-image: none;\r\n	background-repeat: repeat-x;\r\n	color: #6A6962;\r\n	background: url(./images/sample_styles/beige/header.png);\r\n}\r\n\r\n\r\n\r\n/* Write Something - Post Comment */\r\ntextarea {\r\n	color: #6A6962;\r\n	height:100px;\r\n	background: none; \r\n	font-size: 12px;\r\n}\r\n\r\nimg.signup_code {\r\n	background: #ffffff;\r\n	padding: 0px;\r\n	border-width: 2px;\r\n	border-color: #ffffff;\r\n}\r\n\r\n/* image verification input */\r\ninput.text, input.text_small {\r\n	border-color: #ffffff;\r\n	font-size: 11px;\r\n	font-weight: bold;\r\n	color: #ffffff;\r\n	background-color: #B5B3A1;\r\n}\r\n\r\n/* PROFILE STYLES */\r\n\r\n/* Profile box */\r\ntd.profile {\r\n	background-color: #B8B6A7;\r\n    background: transparent;\r\n	border-width: 1px; /* adjust the width for styling of content borders - 0 to remove borders */\r\n	border-color: #F1EED9;\r\n	/* padding values to vary the distance between interior borders and their content */\r\n	padding-top: 12px;\r\n	padding-right: 22px;\r\n	padding-bottom: 12px; \r\n	padding-left: 22px;\r\n}\r\n\r\n\r\n\r\ntd.profile_tab a {\r\n	background-color: #d0cdb7;\r\n	padding: 7px 10px 7px 10px;\r\n	border: 1px solid #AAAAAA; \r\n	border-left: none;\r\n	font-weight: bold; \r\n	display: block;\r\n}\r\ntd.profile_tab a:hover {\r\n	background-color: #d7d4bf;\r\n	padding: 7px 10px 7px 10px;\r\n	border: 1px solid #AAAAAA; \r\n	border-left: none;\r\n	font-weight: bold; \r\n	display: block;\r\n}\r\ntd.profile_tab2 a, td.profile_tab2 a:hover {\r\n	background-color: #dedbc4;\r\n	padding: 7px 10px 8px 10px;\r\n	border: 1px solid #AAAAAA; \r\n	border-left: none;\r\n	border-bottom: none;\r\n	font-weight: bold; \r\n	display: block;\r\n}\r\n#profile_tabs_profile { \r\n	border-left: 1px solid #AAAAAA;\r\n}\r\ntd.profile_tab_end {\r\n	border-bottom: 1px solid #AAAAAA;\r\n}\r\n\r\n/* Recent Activity */\r\ndiv.profile_action  {\r\n	border-bottom-width: 1px;\r\n	border-bottom-style: solid;\r\n	border-bottom-color: #CFCDBB;\r\n	font-size: 14px;\r\n\r\n}\r\n\r\ndiv.profile_action_date {\r\n	color: #6A6962;\r\n	float: right;\r\n	padding-left: 5px;\r\n}\r\n\r\n/* Profile Photo */\r\ntd.profile_photo {\r\n	padding: 4px;\r\n	background-color: #B8B6A7;\r\n    border:1px #FFFCE2 dotted;\r\n}\r\n\r\nimg.photo {\r\n	border-top: 1px;\r\n	border-color: #DEDBC5;\r\n}\r\n\r\n/* PAGE FOOTER */\r\ndiv.copyright a:link { color: #6A6962; text-decoration: none; }\r\ndiv.copyright a:visited { color: #6A6962; text-decoration: none; }\r\ndiv.copyright a:hover { color: #222222; text-decoration: none; }');
INSERT INTO `se_stylesamples` VALUES ('3', 'profile', 'Black XS', 'blackxs/blackxs_full.gif', '/* PROFILE CSS TEMPLATE  */\r\n/*     BLACKXS_FULL      */\r\n/* www.solarianoir.net   */\r\n\r\n\r\n\r\n/* GLOBAL STYLES */\r\n\r\nbody {\r\n	background: #393939 url(./images/sample_styles/blackxs/background.jpg) top center no-repeat; \r\n    /* custom cursor for Firefox, IE */ \r\n	cursor: url(./images/sample_styles/blackxs/cursor.cur), url(./images/sample_styles/pinkviolet/blackxs.gif), auto;\r\n	/* scrollbar colours */ \r\n	scrollbar-face-color: #212121;\r\n	scrollbar-highlight-color: #404040;\r\n	scrollbar-shadow-color: #000000;\r\n	scrollbar-3dlight-color: #616161;\r\n	scrollbar-arrow-color:  #A1A1A1;\r\n	scrollbar-track-color: #000000;\r\n	scrollbar-darkshadow-color: #000000;\r\n    padding-top: 126px; /* distance between top of page and content */\r\n    padding-bottom: 20px; /* distance between bottom of page and content */\r\n}\r\n\r\n\r\n/* Top Menu Links */\r\na.top_menu_item:link { color: #dddddd; background: url(./images/sample_styles/blackxs/twinkle.gif); text-decoration: none; }\r\na.top_menu_item:visited { color: #dddddd; background: url(./images/sample_styles/blackxs/twinkle.gif); text-decoration: none; }\r\na.top_menu_item:hover { color: #FFFFFF; background: none; text-decoration: none; }\r\n\r\n/* LOGGED IN Menu Links */\r\na.menu_item:link { color: #dddddd; background: url(./images/sample_styles/blackxs/twinkle.gif); text-decoration: none; }\r\na.menu_item:visited { color: #dddddd; background: url(./images/sample_styles/blackxs/twinkle.gif); text-decoration: none; }\r\na.menu_item:hover { color: #ffffff; background: none; text-decoration: none; }\r\n\r\n/* Global Links */\r\na:link { color: #dddddd; text-decoration: none; }\r\na:visited { color: #dddddd; text-decoration: none; }\r\na:hover { color: #ffffff; background: url(./images/sample_styles/blackxs/twinkle.gif); text-decoration: none; }\r\n\r\n/* Override All Links */\r\na {\r\n    font-weight: bold;\r\n}\r\n\r\n\r\n/* Content Box */\r\ntd.content {\r\n	background: transparent;\r\n	padding: 6px;\r\n}\r\n\r\n/* Applies to most interior content */\r\ndiv, td {\r\n	background: transparent;\r\n	font-family: arial; /* almost global font */\r\n	font-size: 11px;\r\n	color: #dddddd;\r\n}\r\n\r\n\r\n/* TOP MENU */\r\ntd.top_menu {\r\n	background: transparent;\r\n	border: 1px solid #AAAAAA;\r\n	border-right: none;\r\n}\r\n\r\ntd.top_menu img {\r\n	display: none;\r\n}\r\n\r\ntd.top_menu2 {\r\n	background: transparent;\r\n	border: 1px solid #AAAAAA;\r\n	border-left: none;\r\n}\r\n\r\n\r\n/* USER MENU */\r\ntd.menu_user {\r\n	background: transparent;\r\n}\r\ndiv.menu_dropdown {\r\n	background: #444444;\r\n}\r\ndiv.menu_item_dropdown a:hover {\r\n	background: transparent;\r\n}\r\n\r\n\r\n/* Yourname\'s profile Bar */\r\ndiv.page_header {\r\n	font-size: 16px;\r\n	font-weight: bold;\r\n	color: #ffffff;\r\n	background: transparent;\r\n	margin-bottom: 0px;\r\n	padding-top: 6px;\r\n	padding-left: 6px;\r\n}\r\n\r\n/* Global Headers - Titles */\r\ntd.header {\r\n	padding: 4px 2px 4px 4px;\r\n	border: 1px solid #666666;\r\n	border-bottom: none;\r\n	font-weight: bold;\r\n	background: #444444;\r\n	color: #ffffff;\r\n}\r\n\r\n\r\n\r\ntextarea {\r\n	color: #eeeeee;\r\n	height:100px;\r\n	background: transparent;\r\n	font-size: 12px;\r\n}\r\n\r\nimg.signup_code {\r\n	background: #ffffff;\r\n	padding: 0px;\r\n	border-width: 2px;\r\n	border-color: #000000;\r\n}\r\n\r\n\r\n\r\n\r\n\r\n/* PROFILE STYLES */\r\n\r\n/* Profile box */\r\ntd.profile {\r\n	background: #333333;\r\n	border-width: 1px; /* adjust the width for styling of content borders - 0 to remove borders */\r\n	border-color: #777777;\r\n	/* padding values to vary the distance between interior borders and their content */\r\n	padding-top: 12px;\r\n	padding-right: 12px;\r\n	padding-bottom: 12px; \r\n	padding-left: 12px;\r\n}\r\n\r\ntd.profile_tab a, td.profile_tab a:hover {\r\n	background-color: transparent;\r\n	padding: 7px 10px 7px 10px;\r\n	border: 1px solid #AAAAAA; \r\n	border-left: none;\r\n	font-weight: bold; \r\n	display: block;\r\n}\r\ntd.profile_tab a:hover {\r\n	background-color: #333333;\r\n}\r\ntd.profile_tab2 a, td.profile_tab2 a:hover {\r\n	background-color: #333333;\r\n	padding: 7px 10px 8px 10px;\r\n	border: 1px solid #AAAAAA; \r\n	border-left: none;\r\n	border-bottom: none;\r\n	font-weight: bold; \r\n	display: block;\r\n}\r\n#profile_tabs_profile { \r\n	border-left: 1px solid #AAAAAA;\r\n}\r\ntd.profile_tab_end {\r\n	border-bottom: 1px solid #AAAAAA;\r\n}\r\ndiv.profile_content {\r\n        background-color: #333333;\r\n}\r\n\r\ntd.profile_tab a { background: transparent; }\r\ntd.profile_tab a:hover { background: transparent; background: url(./images/sample_styles/blackxs/twinkle.gif); text-decoration: none; }\r\n\r\ndiv.browse_friends_result { background: transparent; }\r\n\r\ndiv.profile_comment_author { background: transparent; }\r\ndiv.profile_comment_date { background: transparent; }\r\ndiv.profile_postcomment { background: transparent; }\r\n\r\n/* Recent Activity */\r\ndiv.profile_action  {\r\n	border-bottom-width: 1px;\r\n	border-bottom-style: solid;\r\n	border-bottom-color: #444444;\r\n	font-size: 14px;\r\n}\r\n\r\n/* Profile Photo */\r\ntd.profile_photo {\r\n	padding: 0px;\r\n	padding-bottom: 8px;\r\n	background: url(./images/sample_styles/blackxs/spark.gif) no-repeat bottom;\r\n    border:0px;\r\n    border-color: #555555;\r\n    border-style: dotted;\r\n}\r\n\r\nimg.photo {\r\n	padding: 4px;\r\n    border-color: transparent;\r\n	\r\n}\r\n\r\n\r\n/* PAGE FOOTER */\r\ndiv.copyright a:link { color: #6A6962; text-decoration: none; }\r\ndiv.copyright a:visited { color: #6A6962; text-decoration: none; }\r\ndiv.copyright a:hover { color: #222222; text-decoration: none; }\r\ndiv.copyright { background: transparent; border: 1px solid #AAAAAA; }\r\n\r\n\r\n\r\n/* image verification input */\r\ninput.text, input.text_small {\r\n	border-color: #666666;\r\n	font-size: 12px;\r\n	color: #cccccc;\r\n	background-color: #444444;\r\n}\r\n\r\n');
INSERT INTO `se_stylesamples` VALUES ('4', 'profile', 'Dark Grey Basic', 'darkgrey/darkgrey_basic.gif', '/* PROFILE CSS TEMPLATE */\r\n/*   DARKGREY_BASIC     */\r\n/* www.solarianoir.net  */\r\n\r\ntextarea {\r\n  color: #FFFFFF;\r\n}\r\n\r\ndiv.copyright {\r\n  background: transparent;\r\n  border-top: 1px solid #444444;\r\n}\r\n\r\ntextarea.comment_area {\r\n	font-family: \"Lucida Sans\", verdana, arial, serif;\r\n	color: #FFFFFF; \r\n	width: 100%;\r\n	height: 70px;\r\n}\r\ntd.profile_tab a, td.profile_tab a:hover {\r\n	background-color: #333333;\r\n	padding: 7px 10px 7px 10px;\r\n	border: 1px solid #AAAAAA; \r\n	border-left: none;\r\n	font-weight: bold; \r\n	display: block;\r\n}\r\ntd.profile_tab a:hover {\r\n	background-color: #444444;\r\n}\r\ntd.profile_tab2 a, td.profile_tab2 a:hover {\r\n	background-color: #222222;\r\n	padding: 7px 10px 8px 10px;\r\n	border: 1px solid #AAAAAA; \r\n	border-left: none;\r\n	border-bottom: none;\r\n	font-weight: bold; \r\n	display: block;\r\n}\r\n#profile_tabs_profile { \r\n	border-left: 1px solid #AAAAAA;\r\n}\r\ntd.profile_tab_end {\r\n	border-bottom: 1px solid #AAAAAA;\r\n}\r\n\r\ntd.top_menu {\r\n        background: #333333;\r\n	border-top: 1px solid #666666; \r\n	border-bottom: 1px solid #666666;\r\n}\r\ntd.top_menu2 {\r\n        background: #333333;\r\n	width: 15%; \r\n	text-align: right; \r\n	border-right: 1px solid #666666; \r\n	border-top: 1px solid #666666; \r\n	border-bottom: 1px solid #666666; \r\n}\r\ntd.menu_user {\r\n        background: none;\r\n	padding: 5px 10px 5px 7px; \r\n        border: none;\r\n	text-align: left;\r\n}\r\ndiv.top_menu_link_container, div.top_menu_link_container_end {\r\n	float: left;\r\n	height: 31px;\r\n	border-left: 1px solid #666666;\r\n}\r\ndiv.top_menu_link_container_end {\r\n	border-left: 1px solid #666666;\r\n}\r\n\r\n\r\n\r\n/* GLOBAL STYLES */\r\nbody {\r\n	background: #222222;\r\n	cursor: crosshair;\r\n	/* scrollbar colours */ \r\n	scrollbar-face-color: #212121;\r\n	scrollbar-highlight-color: #404040;\r\n	scrollbar-shadow-color: #000000;\r\n	scrollbar-3dlight-color: #616161;\r\n	scrollbar-arrow-color:  #A1A1A1;\r\n	scrollbar-track-color: #000000;\r\n	scrollbar-darkshadow-color: #000000;\r\n	padding-top: 16px; /* distance between top of page and content */\r\n	padding-bottom: 20px; /* distance between bottom of page and content */\r\n}\r\n\r\n/* Top Menu Links */\r\na.top_menu_item:link { color: #cccccc; text-decoration: none; }\r\na.top_menu_item:visited { color: #cccccc; text-decoration: none; }\r\na.top_menu_item:hover { color: #FFFFFF; text-decoration: none; }\r\n\r\n/* LOGGED IN Menu Links */\r\na.menu_item:link { color: #888888; text-decoration: none; }\r\na.menu_item:visited { color: #888888; text-decoration: none; }\r\na.menu_item:hover { color: #888888; text-decoration: none; }\r\n\r\n/* Global Links */\r\na:link { color: #aaaaaa; text-decoration: none; }\r\na:visited { color: #aaaaaa; text-decoration: none; }\r\na:hover { color: #ffffff; text-decoration: none; }\r\n\r\n/* Content Box */\r\ntd.content {\r\n	background-color: #333333;\r\n	/* distance between outer borders and content box */\r\n	padding: 6px;\r\n}\r\n\r\n/* Applies to most interior content */\r\ndiv, td {\r\n	background: transparent;\r\n	font-family: arial; /* almost global font */\r\n	font-size: 11px;\r\n	color: #dddddd;\r\n        line-height: 140%; /* distance between lines of text */\r\n}\r\n\r\n/* TOP Menu */\r\ntd.topbar2, td.topbar2_right {\r\n	border: 0;\r\n	background-image: none;\r\n	background-color: #222222;\r\n	background-repeat: repeat-x; \r\n	font-weight: bold; \r\n	font-size: 16px; \r\n	padding: 10px 8px 10px 8px; \r\n	color: #FFFFFF;\r\n}\r\n\r\n/* User Logged In Menu */\r\ntd.menu {\r\n	background: none; \r\n	background-color: #222222;\r\n	border-width: 1px;\r\n	border-bottom: 4px;\r\n	border-color: #777777;\r\n}\r\n\r\n/* User Logged in Menu Items */\r\ntd.menu_item {\r\n	background: #222222;\r\n	padding-top: 5px;\r\n	padding-right: 6px;\r\n	padding-bottom: 5px;\r\n	padding-left: 6px;\r\n	font-size: 11px;\r\n	font-weight: bold;\r\n	font-family: arial;\r\n}\r\n\r\n/* User Logged in Menu Shadows */\r\ntd.shadow {\r\n	background: none; \r\n}\r\n\r\ntd.shadow img {\r\n	display: none; \r\n}\r\n\r\n/* Yourname\'s profile Bar */\r\ndiv.page_header {\r\n	font-size: 16px;\r\n	font-weight: bold;\r\n	color: #ffffff;\r\n	background-color: #333333;\r\n	margin-bottom: 6px;\r\n	padding-top: 6px;\r\n        padding-bottom: 6px;\r\n	padding-left: 6px;\r\n        border-top: 1px solid #666666;\r\n}\r\n\r\n/* Global Headers - Titles */\r\ntd.header {\r\n	padding: 4px 2px 4px 4px;\r\n	border: 1px solid #666666;\r\n	border-bottom: none;\r\n	font-weight: bold;\r\n	background-image: none;\r\n	background-repeat: repeat-x;\r\n	color: #ffffff;\r\n	background: #444444;\r\n}\r\n\r\n\r\ntextarea {\r\n	color: #eeeeee;\r\n	height:100px;\r\n	background: #444444; \r\n	border: 0px;\r\n	padding: 12px;\r\n	font-size: 12px;\r\n}\r\n\r\nimg.signup_code {\r\n	background: #ffffff;\r\n	padding: 0px;\r\n	border-width: 2px;\r\n	border-color: #000000;\r\n}\r\n\r\n#dhtmltooltip {\r\n	background: #555555;\r\n	border: 1px solid #AAAAAA;\r\n}\r\n\r\n\r\n\r\n\r\n\r\n/* PROFILE STYLES */\r\n\r\n/* Profile box */\r\ntd.profile {\r\n	background-color: #333333;\r\n	border-width: 1px; /* adjust the width for styling of content borders - 0 to remove borders */\r\n	border-color: #444444;\r\n	/* padding values to vary the distance between interior borders and their content */\r\n	padding-top: 12px;\r\n	padding-right: 22px;\r\n	padding-bottom: 12px; \r\n	padding-left: 22px;\r\n}\r\n\r\n/* Recent Activity */\r\ndiv.profile_action  {\r\n	border-bottom-width: 1px;\r\n	border-bottom-style: solid;\r\n	border-bottom-color: #444444;\r\n	font-size: 14px;\r\n}\r\n\r\n/* Profile Photo */\r\ntd.profile_photo {\r\n	border: 0px solid #aaaaaa;\r\n	padding: 4px;\r\n	background-color: #555555;\r\n    border:1px;\r\n    border-color: #000000;\r\n    border-style: dotted;\r\n}\r\n\r\nimg.photo {\r\n	border-top: 1px;\r\n	border-color: #000000;\r\n}\r\n\r\n/* Menu Options (below your profile image) */\r\ntable.profile_menu {\r\n	border: 0px;\r\n} \r\n\r\ntd.profile_menu1 a {\r\n	background-color: #333333;\r\n	background-image: none;\r\n	background-repeat: repeat-y;\r\n	background-position: top right;\r\n	border-bottom: 1px solid #444444;\r\n	padding: 5px 5px 5px 7px;\r\n	font-size: 11px;\r\n	font-weight: bold;\r\n}\r\n\r\ntd.profile_menu1 a:hover {\r\n	background-color: #555555;\r\n        color: #ffffff;\r\n	font-weight: bold;\r\n	background-image: none;\r\n}\r\n\r\n/* Comments Section */\r\ndiv.profile_postcomment {\r\n	padding: 8px;\r\n	border: none;\r\n    border-bottom: 1px solid #555555;\r\n    background: #333333;	\r\n    color: #cccccc;\r\n}\r\n\r\ndiv.profile_comment_author {\r\n        background: #333333;\r\n        border-top: 1px solid #666666;\r\n}\r\ndiv.profile_comment_date {\r\n        background: #333333;\r\n        border-top: 1px solid #666666;\r\n}\r\n\r\n/* image verification input */\r\ninput.text, input.text_small {\r\n	border-color: #666666;\r\n	font-size: 12px;\r\n	color: #cccccc;\r\n	background-color: #444444;\r\n}\r\n\r\n/* Events Section */\r\ndiv.profile_event_spacer {\r\n	border-top: 2px solid #555555; \r\n 	margin: 0px 0px 0px 0px;\r\n    padding: 4px;\r\n}\r\n\r\ntd.profile_event_popup_title {\r\n	font-size: 11pt;\r\n	vertical-align: bottom;\r\n	font-weight: bold;\r\n    padding: 10px;\r\n}\r\n\r\ntd.profile_event_popup2 {\r\n	background: #ffffff;\r\n	width: 640px; \r\n	padding: 8px;\r\n}\r\n\r\ntd.profile_event_transparent {\r\n	background: #000000;\r\n	opacity: 0.5; \r\n	filter: alpha(opacity=20); \r\n	-moz-opacity: 0.2;\r\n}');
INSERT INTO `se_stylesamples` VALUES ('5', 'profile', 'Dark Grey Full', 'darkgrey/darkgrey_basic_images.gif', '/* PROFILE CSS TEMPLATE  */\r\n/* DARKGREY_BASIC_IMAGES */\r\n/* www.solarianoir.net   */\r\n\r\n\r\ntd.menu_user {\r\n  background: #444444;\r\n}\r\ntd.top_menu {\r\n  background: #444444;\r\n}\r\ntd.top_menu2 {\r\n  background: #444444;\r\n}\r\ndiv.top_menu_link, div.top_menu_link_container_end, div.top_menu_link, div.top_menu_link_container, div.top_menu_link_loggedin {\r\n  background: transparent;\r\n}\r\n\r\n\r\ntd.profile_tab a, td.profile_tab a:hover {\r\n	background-color: #333333;\r\n	padding: 7px 10px 7px 10px;\r\n	border: 1px solid #AAAAAA; \r\n	border-left: none;\r\n        border-top: none;\r\n	font-weight: bold; \r\n	display: block;\r\n}\r\ntd.profile_tab a:hover {\r\n	background-color: #444444;\r\n}\r\ntd.profile_tab2 a, td.profile_tab2 a:hover {\r\n	background-color: #222222;\r\n	padding: 7px 10px 8px 10px;\r\n	border: 1px solid #AAAAAA; \r\n	border-left: none;\r\n	border-bottom: none;\r\n        border-top: none;\r\n	font-weight: bold; \r\n	display: block;\r\n}\r\n#profile_tabs_profile { \r\n	border-left: 1px solid #AAAAAA;\r\n}\r\ntd.profile_tab_end {\r\n	border-bottom: 1px solid #AAAAAA;\r\n}\r\n\r\n\r\n/* GLOBAL STYLES */\r\nbody {\r\n	background: #222222;\r\n	cursor: crosshair;\r\n	/* scrollbar colours */ \r\n	scrollbar-face-color: #212121;\r\n	scrollbar-highlight-color: #404040;\r\n	scrollbar-shadow-color: #000000;\r\n	scrollbar-3dlight-color: #616161;\r\n	scrollbar-arrow-color:  #A1A1A1;\r\n	scrollbar-track-color: #000000;\r\n	scrollbar-darkshadow-color: #000000;\r\n    padding-top: 16px; /* distance between top of page and content */\r\n    padding-bottom: 20px; /* distance between bottom of page and content */\r\n}\r\n\r\n/* Top Menu Links */\r\na.top_menu_item:link { color: #cccccc; text-decoration: none; }\r\na.top_menu_item:visited { color: #cccccc; text-decoration: none; }\r\na.top_menu_item:hover { color: #FFFFFF; text-decoration: none; }\r\n\r\n/* LOGGED IN Menu Links */\r\na.menu_item:link { color: #aaaaaa; text-decoration: none; }\r\na.menu_item:visited { color: #aaaaaa; text-decoration: none; }\r\na.menu_item:hover { color: #ffffff; text-decoration: none; }\r\n\r\n/* Global Links */\r\na:link { color: #aaaaaa; text-decoration: none; }\r\na:visited { color: #aaaaaa; text-decoration: none; }\r\na:hover { color: #ffffff; text-decoration: none; }\r\n\r\n/* Content Box */\r\ntd.content {\r\n	background-color: #222222;\r\n	/* distance between outer borders and content box */\r\n	padding: 10px;\r\n}\r\n\r\n/* Applies to most interior content */\r\ndiv, td {\r\n	font-family: arial; /* almost global font */\r\n	font-size: 11px;\r\n	color: #dddddd;\r\n    line-height: 140%; /* distance between lines of text */\r\n	text-align:justify;\r\n}\r\n\r\n\r\n/* TOP Menu */\r\ntd.topbar2, td.topbar2_right {\r\n	border: 0;\r\n	background-color: #222222;\r\n    background-image: url(./images/sample_styles/darkgrey/menu_bg.gif);\r\n	background-repeat: repeat-x; \r\n	font-weight: bold; \r\n	font-size: 16px; \r\n	padding: 10px 8px 10px 8px; \r\n	color: #FFFFFF;\r\n}\r\n\r\n/* User Logged In Menu */\r\ntd.menu {\r\n    background: #333333;\r\n/*    background-image: url(./images/sample_styles/darkgrey/menu2_bg.gif); 	*/\r\n    border-width: 0px;\r\n	border-bottom: 4px;\r\n	border-color: #777777;\r\n    padding-top:10px;\r\n    background-position: bottom;\r\n}\r\n\r\n/* User Logged in Menu Items */\r\ntd.menu_item {\r\n	background: #333333;\r\n/*    background-image: url(./images/sample_styles/darkgrey/menu2_bg.gif); 	*/\r\n	padding-top: 0px;\r\n	padding-right: 6px;\r\n	padding-bottom: 5px;\r\n	padding-left: 6px;\r\n	font-size: 11px;\r\n	font-weight: bold;\r\n	font-family: arial;\r\n    background-position: bottom;\r\n}\r\n\r\n/* User Logged in Menu Shadows */\r\ntd.shadow {\r\n	background: none; \r\n	visibility:hidden;\r\n}\r\n\r\ntd.shadow img {\r\n	display: none;\r\n    visibility:hidden; \r\n}\r\n\r\n/* Yourname\'s profile Bar */\r\ndiv.page_header {\r\n	font-size: 16px;\r\n	font-weight: bold;\r\n	color: #ffffff;\r\n	background-color: #333333;\r\n	margin-bottom: 10px;\r\n        padding: 8px 10px 8px 10px;\r\n        border-top: 1px solid #555555;\r\n}\r\n\r\n/* Global Headers - Titles */\r\ntd.header {\r\n	padding: 4px 2px 4px 4px;\r\n	border: 1px solid #666666;\r\n	border-bottom: none;\r\n	font-weight: bold;\r\n	background: #666666;\r\n    background-image: url(./images/sample_styles/darkgrey/header.gif);\r\n	background-repeat: repeat-x;\r\n	color: #ffffff;\r\n	\r\n}\r\n\r\n\r\n\r\n/* PROFILE STYLES */\r\n\r\n/* Profile Box */\r\ntd.profile {\r\n	background-color: #333333;\r\n	background-image: none;\r\n	background-repeat: repeat;\r\n	background-attachment: scroll;\r\n	border-width: 1px; /* adjust the width for styling of content borders */\r\n	border-color: #444444;\r\n	margin-bottom: 0px;\r\n	/* padding values to vary the distance between interior element borders and their content */\r\n	padding-top: 12px;\r\n	padding-right: 12px;\r\n	padding-bottom: 12px; \r\n	padding-left: 12px;\r\n}\r\n\r\n/* Recent Activity */\r\ndiv.profile_action  {\r\n	border-bottom-width: 1px;\r\n	border-bottom-style: solid;\r\n	border-bottom-color: #444444;\r\n	font-size: 14px;\r\n}\r\n\r\n/* Profile Photo */\r\ntd.profile_photo {\r\n	border: 0px solid #aaaaaa;\r\n	padding: 4px;\r\n	background-color: #555555;\r\n    border:1px;\r\n    border-color: #000000;\r\n    border-style: dotted;\r\n}\r\n\r\nimg.photo {\r\n	border-top: 1px;\r\n	border-color: #000000;\r\n}\r\n\r\n/* Menu Options (below your profile image) */\r\ntable.profile_menu {\r\n	border: 0px;\r\n} \r\n\r\ntd.profile_menu1 a {\r\n	background-color: #333333;\r\n	background-image: none;\r\n	background-repeat: repeat-y;\r\n	background-position: top right;\r\n	border-bottom: 1px solid #555555;\r\n	padding: 5px 5px 5px 7px;\r\n	font-size: 11px;\r\n	font-weight: bold;\r\n}\r\n\r\ntd.profile_menu1 a:hover {\r\n	background-color: #555555;\r\n    color: #ffffff;\r\n	font-weight: bold;\r\n	background-image: none;\r\n}\r\n\r\n/* Comments Section */\r\ntd.profile_viewcomments_postcomment {\r\n	padding: 1px;\r\n    color: #cccccc;\r\n	border: 0px solid #CCCCCC;\r\n	background: #333333;\r\n}\r\n\r\ntd.profile_postcomment {\r\n	padding: 18px;\r\n	border: none;\r\n    border-bottom: 1px solid #555555;\r\n    background: #333333;	\r\n    color: #cccccc;\r\n}\r\n\r\ntd.profile_comment_author {\r\n	padding: 5px 7px 5px 7px;\r\n	background: #444444;\r\n}\r\n\r\ntextarea {\r\n	color: #eeeeee;\r\n	height:100px;\r\n	background: #444444; \r\n	border: 0px;\r\n	padding: 12px;\r\n	font-size: 12px;\r\n}\r\n\r\nimg.signup_code {\r\n	background: #ffffff;\r\n	padding: 0px;\r\n	border-width: 2px;\r\n	border-color: #000000;\r\n}\r\n\r\n#dhtmltooltip {\r\n	background: #555555;\r\n	border: 1px solid #AAAAAA;\r\n}\r\n\r\n\r\n/* Events Section */\r\ndiv.profile_event_spacer {\r\n	border-top: 2px solid #555555; \r\n 	margin: 0px 0px 0px 0px;\r\n    padding: 4px;\r\n}\r\ntd.profile_event_popup_title {\r\n	font-size: 11pt;\r\n	vertical-align: bottom;\r\n	font-weight: bold;\r\n    padding: 10px;\r\n}\r\n\r\ntd.profile_event_popup2 {\r\n	background: #ffffff;\r\n	width: 640px; \r\n	padding: 8px;\r\n}\r\n\r\ntd.profile_event_transparent {\r\n	background: #000000;\r\n	opacity: 0.5; \r\n	filter: alpha(opacity=20); \r\n	-moz-opacity: 0.2;\r\n}');

#
# Table structure for table `se_subnets`
#

CREATE TABLE `se_subnets` (
  `subnet_id` int(9) NOT NULL AUTO_INCREMENT,
  `subnet_name` int(10) unsigned NOT NULL DEFAULT '0',
  `subnet_field1_qual` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `subnet_field1_value` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `subnet_field2_qual` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `subnet_field2_value` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`subnet_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_subnets`
#

#
# Dumping data for table `se_subnets`
#


#
# Table structure for table `se_systememails`
#

CREATE TABLE `se_systememails` (
  `systememail_id` int(9) NOT NULL AUTO_INCREMENT,
  `systememail_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `systememail_title` int(9) NOT NULL,
  `systememail_desc` int(9) NOT NULL,
  `systememail_subject` int(9) NOT NULL,
  `systememail_body` int(9) NOT NULL,
  `systememail_vars` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`systememail_id`),
  UNIQUE KEY `systememail_name` (`systememail_name`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_systememails`
#

#
# Dumping data for table `se_systememails`
#

INSERT INTO `se_systememails` VALUES ('1', 'invitecode', '518', '519', '850001', '850002', '[displayname],[email],[message],[code],[link]');
INSERT INTO `se_systememails` VALUES ('2', 'invite', '523', '524', '850003', '850004', '[displayname],[email],[message],[link]');
INSERT INTO `se_systememails` VALUES ('3', 'verification', '526', '527', '850005', '850006', '[displayname],[email],[link]');
INSERT INTO `se_systememails` VALUES ('4', 'newpassword', '529', '530', '850007', '850008', '[displayname],[email],[password],[link]');
INSERT INTO `se_systememails` VALUES ('5', 'welcome', '532', '533', '850009', '850010', '[displayname],[email],[password],[link]');
INSERT INTO `se_systememails` VALUES ('6', 'lostpassword', '535', '536', '850011', '850012', '[displayname],[email],[link]');
INSERT INTO `se_systememails` VALUES ('7', 'friendrequest', '538', '539', '850013', '850014', '[displayname],[friendname],[link]');
INSERT INTO `se_systememails` VALUES ('8', 'message', '541', '542', '850015', '850016', '[displayname],[sender],[link]');
INSERT INTO `se_systememails` VALUES ('9', 'profilecomment', '544', '545', '850017', '850018', '[displayname],[commenter],[link]');

#
# Table structure for table `se_urls`
#

CREATE TABLE `se_urls` (
  `url_id` int(9) NOT NULL AUTO_INCREMENT,
  `url_title` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `url_file` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `url_regular` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `url_subdirectory` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`url_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_urls`
#

#
# Dumping data for table `se_urls`
#


#
# Table structure for table `se_users`
#

CREATE TABLE `se_users` (
  `user_id` int(9) NOT NULL AUTO_INCREMENT,
  `user_level_id` int(9) NOT NULL DEFAULT '0',
  `user_subnet_id` int(9) NOT NULL DEFAULT '0',
  `user_profilecat_id` int(9) NOT NULL DEFAULT '0',
  `user_email` varchar(70) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_newemail` varchar(70) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_fname` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_lname` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_username` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_displayname` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_password` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_password_method` tinyint(1) NOT NULL DEFAULT '0',
  `user_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_enabled` int(1) NOT NULL DEFAULT '0',
  `user_verified` int(1) NOT NULL DEFAULT '0',
  `user_language_id` int(9) NOT NULL DEFAULT '0',
  `user_signupdate` int(14) NOT NULL DEFAULT '0',
  `user_lastlogindate` int(14) NOT NULL DEFAULT '0',
  `user_lastactive` int(14) NOT NULL DEFAULT '0',
  `user_ip_signup` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_ip_lastactive` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_status` varchar(190) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_status_date` int(14) NOT NULL DEFAULT '0',
  `user_logins` int(9) NOT NULL DEFAULT '0',
  `user_invitesleft` int(3) NOT NULL DEFAULT '0',
  `user_timezone` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_dateupdated` int(14) NOT NULL DEFAULT '0',
  `user_blocklist` text COLLATE utf8_unicode_ci,
  `user_invisible` int(1) NOT NULL DEFAULT '0',
  `user_saveviews` int(1) NOT NULL DEFAULT '0',
  `user_photo` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_search` int(1) NOT NULL DEFAULT '0',
  `user_privacy` int(2) NOT NULL DEFAULT '0',
  `user_comments` int(2) NOT NULL DEFAULT '0',
  `user_hasnotifys` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_username` (`user_username`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_users`
#

#
# Dumping data for table `se_users`
#

INSERT INTO `se_users` VALUES ('1', '1', '0', '1', 'cyberalpha@gmail.com', 'cyberalpha@gmail.com', 'Celestina', 'Márquez', 'Cyberalphabetizador', 'Celestina', 'b6b995c5d1e69031a61fa8a328f2e656', '1', '8cRcWVlG39l9mCPi', '1', '1', '2', '1357838959', '1357840602', '1357841006', '127.0.0.1', '127.0.0.1', 'Probando', '1357840683', '2', '5', '-3', '1357840868', '', '0', '0', '0_5033.jpg', '1', '63', '63', '0');

#
# Table structure for table `se_usersettings`
#

CREATE TABLE `se_usersettings` (
  `usersetting_id` int(9) NOT NULL AUTO_INCREMENT,
  `usersetting_user_id` int(9) NOT NULL DEFAULT '0',
  `usersetting_lostpassword_code` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `usersetting_lostpassword_time` int(14) NOT NULL DEFAULT '0',
  `usersetting_notify_friendrequest` int(1) NOT NULL DEFAULT '0',
  `usersetting_notify_message` int(1) NOT NULL DEFAULT '0',
  `usersetting_notify_profilecomment` int(1) NOT NULL DEFAULT '0',
  `usersetting_actions_dontpublish` text COLLATE utf8_unicode_ci NOT NULL,
  `usersetting_actions_display` text COLLATE utf8_unicode_ci NOT NULL,
  `usersetting_displayname_method` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`usersetting_id`),
  UNIQUE KEY `usersetting_user_id` (`usersetting_user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_usersettings`
#

#
# Dumping data for table `se_usersettings`
#

INSERT INTO `se_usersettings` VALUES ('1', '1', '', '0', '1', '1', '1', '', '1,2,3,4,5,6,7', '1');

#
# Table structure for table `se_visitors`
#

CREATE TABLE `se_visitors` (
  `visitor_ip` int(11) NOT NULL DEFAULT '0',
  `visitor_browser` char(32) CHARACTER SET ascii COLLATE ascii_bin NOT NULL DEFAULT '',
  `visitor_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `visitor_user_username` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `visitor_user_displayname` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `visitor_lastactive` int(14) NOT NULL DEFAULT '0',
  `visitor_invisible` tinyint(14) NOT NULL DEFAULT '0',
  UNIQUE KEY `UNIQUE` (`visitor_ip`,`visitor_browser`,`visitor_user_id`),
  KEY `LASTACTIVE` (`visitor_lastactive`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# End Structure for table `se_visitors`
#

#
# Dumping data for table `se_visitors`
#

INSERT INTO `se_visitors` VALUES ('2130706433', 'c8a059157432c2b6209213a7da2dd674', '0', '', '', '1357841098', '0');

#
# Finished at: Jan 26, 2013 at 10:10
#