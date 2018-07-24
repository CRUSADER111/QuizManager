-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.34-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for quizdb
CREATE DATABASE IF NOT EXISTS `quizdb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci */;
USE `quizdb`;

-- Dumping structure for table quizdb.answers
DROP TABLE IF EXISTS `answers`;
CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `answerID` char(1) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `quiz` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `answer` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `questionID` int(11) NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `lasteditby` varchar(50) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Dumping data for table quizdb.answers: ~12 rows (approximately)
/*!40000 ALTER TABLE `answers` DISABLE KEYS */;
REPLACE INTO `answers` (`id`, `answerID`, `quiz`, `answer`, `questionID`, `createdby`, `lasteditby`) VALUES
	(1, 'A', 'RPA', 'Robot Process Advancement', 1, NULL, NULL),
	(2, 'B', 'RPA', 'Robotic Presentation Awareness', 1, NULL, NULL),
	(3, 'C', 'RPA', 'Robotic Process Automation', 1, NULL, NULL),
	(4, 'D', 'RPA', 'Robotic Processing Advancement', 1, NULL, NULL),
	(5, 'A', 'RPA', 'Robotic Transfer Process Optimization', 2, NULL, NULL),
	(6, 'B', 'RPA', 'Real Time Process Optimization', 2, NULL, NULL),
	(7, 'C', 'RPA', 'Real Time Practical Occurrence', 2, NULL, NULL),
	(8, 'D', 'RPA', 'Real Time Protocol Occurrence', 2, NULL, NULL),
	(9, 'A', 'Math', '10', 3, NULL, NULL),
	(10, 'B', 'Math', '20', 3, NULL, NULL),
	(11, 'C', 'Math', '30', 3, NULL, NULL),
	(12, 'D', 'Math', '25', 3, NULL, NULL);
/*!40000 ALTER TABLE `answers` ENABLE KEYS */;

-- Dumping structure for table quizdb.questions
DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `questionID` int(11) NOT NULL,
  `quiz` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `answerID` char(1) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `createdby` varchar(50) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `lasteditby` varchar(50) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Dumping data for table quizdb.questions: ~3 rows (approximately)
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
REPLACE INTO `questions` (`id`, `questionID`, `quiz`, `question`, `answerID`, `createdby`, `lasteditby`) VALUES
	(1, 1, 'RPA', 'What does RPA stand for?', 'C', NULL, NULL),
	(2, 2, 'RPA', 'What does RTPO stand for?', 'B', NULL, NULL),
	(3, 1, 'Math', 'What is 5 x 5?', 'D', NULL, NULL);
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;

-- Dumping structure for table quizdb.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `permissionlevel` varchar(10) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'Restricted',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Dumping data for table quizdb.users: ~1 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
REPLACE INTO `users` (`id`, `username`, `password`, `permissionlevel`, `created_at`) VALUES
	(1, 'Test', '$2y$10$bYvEo2siVP4JdkbXZjI9t.moRMZ0HQPdICIiBNXmYKw/FxWYwAxRO', 'Restricted', '2018-07-23 16:00:49'),
	(2, 'Edit', '$2y$10$2hoeyjTG5tVyWck3C93TBeowYD0ovc5jhP62svqymJw7LdAMNXFia', 'Edit', '2018-07-24 17:03:32'),
	(3, 'View', '$2y$10$.7uT/7p7KH/cY9pm3S8ZuerQoScOapPZnSmxWw3dth2.Mb8fKFnyi', 'View', '2018-07-24 17:03:46'),
	(4, 'Restricted', '$2y$10$mvsefMdTV44x05xLetwyLeMvOVb0MMuX62QyUcYN3EKltBbksu3iq', 'Restricted', '2018-07-24 17:04:06');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
