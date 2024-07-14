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

/*Table structure for table `registro_secuestro_detalle_objeto` */

DROP TABLE IF EXISTS `registro_secuestro_detalle_objeto`;

CREATE TABLE `registro_secuestro_detalle_objeto` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `registro_secuestro_id` int(12) DEFAULT NULL,
  `secuestro_id` int(12) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*Table structure for table `registro_secuestro_historico` */

DROP TABLE IF EXISTS `registro_secuestro_historico`;

CREATE TABLE `registro_secuestro_historico` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `autos` int(12) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `acta` int(12) DEFAULT NULL,
  `caratula` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reparticion` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `destino` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Donacion-Destruccion-Reparticion',
  `donado_a` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'donado a una institucion',
  `restituido_a` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'restituido a una persona',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

