-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.12-log - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for nha_sach
CREATE DATABASE IF NOT EXISTS `nha_sach` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `nha_sach`;


-- Dumping structure for table nha_sach.jos_admin_resource
CREATE TABLE IF NOT EXISTS `jos_admin_resource` (
  `resource_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Resource ID',
  `parent_id` int(10) NOT NULL COMMENT 'Resource Parent',
  `resource` varchar(255) NOT NULL COMMENT 'Resource',
  `resource_name` varchar(255) NOT NULL DEFAULT 'Resource New' COMMENT 'Resource Name',
  `resource_type` varchar(20) NOT NULL COMMENT 'Type resource',
  `resource_object` varchar(50) NOT NULL DEFAULT 'ACL' COMMENT 'White list or ACL',
  `is_white_list` int(11) DEFAULT '0',
  `is_hidden` int(11) DEFAULT '0',
  PRIMARY KEY (`resource_id`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8 COMMENT='Admin Resource Table';

-- Dumping data for table nha_sach.jos_admin_resource: ~13 rows (approximately)
/*!40000 ALTER TABLE `jos_admin_resource` DISABLE KEYS */;
INSERT INTO `jos_admin_resource` (`resource_id`, `parent_id`, `resource`, `resource_name`, `resource_type`, `resource_object`, `is_white_list`, `is_hidden`) VALUES
	(118, 0, 'Permission', 'Permission Module', 'Module', 'ACL', 0, 0),
	(119, 118, 'Permission\\Controller\\Permission', 'Permission\\Controller\\Permission Controller', 'Controller', 'ACL', 0, 0),
	(120, 119, 'index', 'index Action', 'Action', 'ACL', 0, 0),
	(121, 119, 'permissionOfUser', 'permissionOfUser Action', 'Action', 'ACL', 0, 0),
	(122, 119, 'edit', 'edit Action', 'Action', 'ACL', 0, 0),
	(123, 119, 'changeWhiteList', 'changeWhiteList Action', 'Action', 'ACL', 0, 0),
	(124, 119, 'update', 'update Action', 'Action', 'ACL', 0, 0),
	(125, 119, 'login', 'login Action', 'Action', 'ACL', 0, 0),
	(126, 119, 'logout', 'logout Action', 'Action', 'ACL', 0, 0),
	(127, 119, 'listUser', 'listUser Action', 'Action', 'ACL', 0, 0),
	(128, 0, 'Application', 'Application Module', 'Module', 'ACL', 0, 0),
	(129, 128, 'Application\\Controller\\Index', 'Application\\Controller\\Index Controller', 'Controller', 'ACL', 0, 0),
	(130, 129, 'index', 'index Action', 'Action', 'ACL', 0, 0);
/*!40000 ALTER TABLE `jos_admin_resource` ENABLE KEYS */;


-- Dumping structure for table nha_sach.jos_admin_role
CREATE TABLE IF NOT EXISTS `jos_admin_role` (
  `role_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Role ID',
  `role_name` varchar(50) DEFAULT NULL COMMENT 'Role Name Is UserType In Jos_Users',
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `role_name` (`role_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Role table';

-- Dumping data for table nha_sach.jos_admin_role: ~2 rows (approximately)
/*!40000 ALTER TABLE `jos_admin_role` DISABLE KEYS */;
INSERT INTO `jos_admin_role` (`role_id`, `role_name`) VALUES
	(1, 'admin'),
	(2, 'user');
/*!40000 ALTER TABLE `jos_admin_role` ENABLE KEYS */;


-- Dumping structure for table nha_sach.jos_admin_rule
CREATE TABLE IF NOT EXISTS `jos_admin_rule` (
  `rule_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Rule ID',
  `role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Role ID',
  `resource_id` int(10) unsigned NOT NULL COMMENT 'Resource ID',
  PRIMARY KEY (`rule_id`),
  KEY `IDX_JOS_RULE_RESOURCE_ID_ROLE_ID` (`resource_id`,`role_id`),
  KEY `IDX_JOS_RULE_ROLE_ID_RESOURCE_ID` (`role_id`,`resource_id`),
  CONSTRAINT `FK_jos_admin_rule_jos_admin_resource` FOREIGN KEY (`resource_id`) REFERENCES `jos_admin_resource` (`resource_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_JOS_RULE_ROLE_ID_JOS_ROLE_ROLE_ID` FOREIGN KEY (`role_id`) REFERENCES `jos_admin_role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8 COMMENT='Admin Rule Table';

-- Dumping data for table nha_sach.jos_admin_rule: ~0 rows (approximately)
/*!40000 ALTER TABLE `jos_admin_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_admin_rule` ENABLE KEYS */;


-- Dumping structure for table nha_sach.kho
CREATE TABLE IF NOT EXISTS `kho` (
  `id_kho` int(10) NOT NULL AUTO_INCREMENT,
  `ten_kho` varchar(255) NOT NULL,
  `dia_chi_kho` varchar(255) NOT NULL,
  PRIMARY KEY (`id_kho`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table nha_sach.kho: ~0 rows (approximately)
/*!40000 ALTER TABLE `kho` DISABLE KEYS */;
/*!40000 ALTER TABLE `kho` ENABLE KEYS */;


-- Dumping structure for table nha_sach.user
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `kho_id` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `display_name` varchar(50) DEFAULT NULL,
  `password` varchar(128) NOT NULL,
  `state` smallint(6) NOT NULL,
  `ho_ten` varchar(100) NOT NULL,
  `dia_chi` varchar(255) DEFAULT NULL,
  `mo_ta` varchar(255) DEFAULT NULL,
  `dien_thoai_co_dinh` varchar(12) DEFAULT NULL,
  `di_dong` varchar(12) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `kho` (`kho_id`),
  KEY `FK_user_jos_admin_role` (`role_id`),
  CONSTRAINT `FK_user_kho` FOREIGN KEY (`kho_id`) REFERENCES `kho` (`id_kho`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_user_jos_admin_role` FOREIGN KEY (`role_id`) REFERENCES `jos_admin_role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table nha_sach.user: ~0 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
