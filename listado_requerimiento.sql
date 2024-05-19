/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 8.0.17 : Database - juzgado
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`juzgado` /*!40100 DEFAULT CHARACTER SET utf8 */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `juzgado`;

/*Table structure for table `listado_requerimiento` */

DROP TABLE IF EXISTS `listado_requerimiento`;

CREATE TABLE `listado_requerimiento` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `expediente_id` int(6) DEFAULT NULL,
  `actuaciones_id` int(6) DEFAULT NULL,
  `persona_id` int(6) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `requerimiento` varchar(135) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
