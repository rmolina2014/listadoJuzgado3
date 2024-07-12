/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 8.0.17 : Database - tercero2024
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`tercero2024` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `tercero2024`;

/*Table structure for table `registro_secuestro_historico` */

DROP TABLE IF EXISTS `registro_secuestro_historico`;

CREATE TABLE `registro_secuestro_historico` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `autos` int(12) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `acta` int(12) DEFAULT NULL,
  `caratula` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reparticion` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `objeto` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `destino` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Donacion-Destruccion-Reparticion',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `registro_secuestro_historico` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
