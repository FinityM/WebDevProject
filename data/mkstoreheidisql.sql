-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for mkstore
CREATE DATABASE IF NOT EXISTS `mkstore` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `mkstore`;

-- Dumping structure for table mkstore.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `desc` text NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `rrp` decimal(7,2) NOT NULL DEFAULT '0.00',
  `quantity` int(11) NOT NULL,
  `img` text NOT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table mkstore.products: ~3 rows (approximately)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `name`, `desc`, `price`, `rrp`, `quantity`, `img`, `date_added`) VALUES
	(1, 'Cyberpunk', '<p>Cyberpunk</p>', 59.99, 0.00, 100, 'Cyberbonk.jpg', '2021-04-25 14:11:00'),
	(2, 'Doom Eternal', '<p>Doom Eternal</p>', 59.99, 0.00, 100, 'doooooomeeeeteeernaaaal.jpg', '2021-04-25 14:11:00'),
	(3, 'Halo Infinite', '<p>Halo Infinite</p>', 69.99, 0.00, 100, 'HaloInfinite.jpg', '2021-04-25 14:11:00');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Dumping structure for table mkstore.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `createdate` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

-- Dumping data for table mkstore.users: ~8 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `createdate`) VALUES
	(5, 'youtube@email.com', 'youtube1234567', '2021-04-21 18:18:55'),
	(6, 'theemail@email.com', '123456789', '2021-04-21 18:21:13'),
	(7, 'yahooooooooo@email.com', 'fdsafdgsagdsa', '2021-04-22 16:26:31'),
	(8, 'theeeeeeemail@email.com', 'randompass', '2021-04-24 13:45:50'),
	(9, 'yeeee2@email.com', '123456789', '2021-04-24 13:46:59'),
	(10, 'him@email.com', 'password123456', '2021-04-25 14:53:20'),
	(27, 'test1234@email.com', 'password123456789', '2021-04-26 12:00:14'),
	(28, 'wazowski@email.com', '1234567', '2021-04-26 13:27:51');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
