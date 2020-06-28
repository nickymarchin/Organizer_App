-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.33-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for import_example
CREATE DATABASE IF NOT EXISTS `import_example` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `import_example`;

-- Dumping structure for table import_example.departments
CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;

-- Dumping data for table import_example.departments: ~6 rows (approximately)
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` (`id`, `name`) VALUES
	(26, '<--- No Department ---> '),
	(30, 'Databases'),
	(63, 'Design'),
	(69, 'AI'),
	(70, 'Finances'),
	(71, 'Web Development');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;

-- Dumping structure for table import_example.emails
CREATE TABLE IF NOT EXISTS `emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sender_id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`),
  KEY `recipient_id` (`recipient_id`),
  CONSTRAINT `emails_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `emails_ibfk_2` FOREIGN KEY (`recipient_id`) REFERENCES `import` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table import_example.emails: ~0 rows (approximately)
/*!40000 ALTER TABLE `emails` DISABLE KEYS */;
/*!40000 ALTER TABLE `emails` ENABLE KEYS */;

-- Dumping structure for table import_example.import
CREATE TABLE IF NOT EXISTS `import` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `contact_no` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `department_id` (`department_id`),
  CONSTRAINT `import_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2230 DEFAULT CHARSET=latin1;

-- Dumping data for table import_example.import: ~10 rows (approximately)
/*!40000 ALTER TABLE `import` DISABLE KEYS */;
INSERT INTO `import` (`id`, `first_name`, `last_name`, `email`, `department_id`, `contact_no`) VALUES
	(2204, 'Ivan', 'Ivanov', 'ivan@a.bg', 30, '900000005'),
	(2205, 'Nikolay', 'Marchin', 'niki.marchin@gmail.com', 63, '9000000001'),
	(2208, 'Test', 'Test', 'nickolay_marchin@abv.bg', NULL, '9000000001'),
	(2209, 'Team', 'Tech Arise', 'info@techarise.com', 71, '9000000001'),
	(2214, 'Test', 'Test2', 'test@test.bg', 70, '90000000004'),
	(2217, 'Example', 'Example', 'example@example.com', 70, '90000000004'),
	(2220, 'User', '4rth', 'user@techarise.com', 26, '9000000003'),
	(2225, 'Admin', 'Admin', 'admin@techarise.com', 69, '9000000002'),
	(2228, 'Test', 'Techarise', 'venatalss@gmail.com', 30, '900000005'),
	(2229, 'Pesho', 'Ivanov', 'p@p.bg', 63, '9000000009');
/*!40000 ALTER TABLE `import` ENABLE KEYS */;

-- Dumping structure for table import_example.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `register_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Dumping data for table import_example.users: ~0 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `zipcode`, `email`, `username`, `password`, `register_date`) VALUES
	(12, 'Nikolay', '2650', 'niki.marchin@gmail.com', 'niki', '30c04cbad71a234a295ef6445ce18fbf2e39b83e054b93e6030e305c', '2020-04-08 13:06:49');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
