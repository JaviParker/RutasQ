/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 8.3.0 : Database - rutas
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`rutas` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `rutas`;

/*Table structure for table `cliente` */

DROP TABLE IF EXISTS `cliente`;

CREATE TABLE `cliente` (
  `clienteid` int unsigned NOT NULL AUTO_INCREMENT,
  `clientenombre` varchar(100) DEFAULT NULL,
  `clientenumero` int DEFAULT NULL,
  `clientefecha` date DEFAULT NULL,
  `clienteestatus` int DEFAULT NULL,
  `sucursalid` int DEFAULT NULL,
  `usuarioid` int DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  PRIMARY KEY (`clienteid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `cliente` */

insert  into `cliente`(`clienteid`,`clientenombre`,`clientenumero`,`clientefecha`,`clienteestatus`,`sucursalid`,`usuarioid`,`updated_at`,`created_at`) values (1,'JUAN PABLO MARTINEZ PEREZ',1001,'2024-09-06',1,2,NULL,'2024-09-08','2024-09-06'),(2,'PEDRO',200,'2024-09-06',1,1,NULL,'2024-09-06','2024-09-06'),(3,'PEDRO',1234,'2024-09-08',1,1,NULL,'2024-09-08','2024-09-08'),(4,'maria',1,'2024-09-08',1,2,NULL,'2024-09-08','2024-09-08'),(5,'maria',1,'2024-09-08',1,3,NULL,'2024-09-08','2024-09-08'),(6,'qwqwqw',1,'2024-09-08',1,1,NULL,'2024-09-08','2024-09-08'),(7,'JUAN PABLO MORENO REYES',144,'2024-09-08',1,1,NULL,'2024-09-08','2024-09-08');

/*Table structure for table `parametro` */

DROP TABLE IF EXISTS `parametro`;

CREATE TABLE `parametro` (
  `parametroid` int NOT NULL AUTO_INCREMENT,
  `parametronombre` varchar(200) DEFAULT NULL,
  `parametrodescripcion` varchar(200) DEFAULT NULL,
  `parametrovalor` decimal(10,2) DEFAULT NULL,
  `parametrofecha` date DEFAULT NULL,
  `parametroestatus` int DEFAULT NULL,
  `usuarioid` int DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  PRIMARY KEY (`parametroid`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Data for the table `parametro` */

insert  into `parametro`(`parametroid`,`parametronombre`,`parametrodescripcion`,`parametrovalor`,`parametrofecha`,`parametroestatus`,`usuarioid`,`updated_at`,`created_at`) values (1,'qwqwqw','qwqwqw',45.00,'2024-09-02',1,1,'2024-09-09','2023-08-31'),(2,'DOLARES',NULL,17.10,'2024-06-16',2,1,'2024-09-09','2024-04-18'),(3,'casa',NULL,NULL,'2024-01-12',1,1,'2024-08-06','2024-08-06'),(4,'NOMBRE','NOMBRE',0.00,'2024-07-20',1,NULL,'2024-09-01','2024-09-01'),(5,'weweqw','qweqwe',0.00,'2024-07-20',1,NULL,'2024-09-01','2024-09-01'),(6,'hhhh','hhhhh',1.00,'2024-07-20',1,4,'2024-09-01','2024-09-01'),(7,'1111','111',0.00,'2024-07-20',1,4,'2024-09-01','2024-09-01'),(8,'asdasasasas','asasasas',1.00,'2024-07-20',1,4,'2024-09-01','2024-09-01'),(9,'FECHA','FECHA DEL SISTEMA',1.00,'2024-09-02',1,4,'2024-09-01','2024-09-01'),(10,'qwqw','qwqw',1.00,'2024-07-20',1,4,'2024-09-01','2024-09-01'),(11,'wqwe','wewe',1.00,'2024-07-20',1,4,'2024-09-02','2024-09-01'),(12,'tttt','ttttt',3.00,'2024-07-20',1,4,'2024-09-02','2024-09-01'),(13,'CALLE','CALLE',1.00,'2024-09-06',1,4,'2024-09-02','2024-09-02'),(14,'DOLARES','TOTAL DE DOLARES',18.20,'2024-09-02',1,4,'2024-09-03','2024-09-02'),(15,'EDITAR','EDITA',4.00,'2024-10-01',1,4,'2024-09-02','2024-09-02'),(16,'OTRO','OTRO',0.00,'2024-09-02',1,27,'2024-09-08','2024-09-08');

/*Table structure for table `rol` */

DROP TABLE IF EXISTS `rol`;

CREATE TABLE `rol` (
  `rolid` int unsigned NOT NULL AUTO_INCREMENT,
  `rolnombre` varchar(100) DEFAULT NULL,
  `rolfecha` date DEFAULT NULL,
  `rolestatus` int DEFAULT NULL,
  `usuarioid` int DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`rolid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `rol` */

insert  into `rol`(`rolid`,`rolnombre`,`rolfecha`,`rolestatus`,`usuarioid`,`created_at`,`updated_at`) values (1,'ADMINISTRADOR','2024-09-03',1,4,'2024-09-03','2024-09-03'),(2,'LIQUIDACION','2024-09-03',1,4,'2024-09-03','2024-09-03'),(3,'SUPERVISOR','2024-09-03',1,4,'2024-09-03','2024-09-03');

/*Table structure for table `sucursal` */

DROP TABLE IF EXISTS `sucursal`;

CREATE TABLE `sucursal` (
  `sucursalid` int unsigned NOT NULL AUTO_INCREMENT,
  `sucursalnombre` varchar(100) DEFAULT NULL,
  `sucursalfecha` date DEFAULT NULL,
  `sucursalestatus` int DEFAULT NULL,
  `usuarioid` int DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`sucursalid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `sucursal` */

insert  into `sucursal`(`sucursalid`,`sucursalnombre`,`sucursalfecha`,`sucursalestatus`,`usuarioid`,`created_at`,`updated_at`) values (1,'SERVICIO BENITO S.A. DE C.V.','2024-09-04',1,4,'2024-09-04','2024-09-04'),(2,'GASOLINERIA Y SERVICIOS LA VILLA S.A. DE C.V.','2024-09-04',1,4,'2024-09-04','2024-09-04'),(3,'AUTOTRANSPORTES DE COMBUSTIBLES BENITO S.A. DE C.V.','2024-09-04',1,4,'2024-09-04','2024-09-04');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `usuarioid` int NOT NULL AUTO_INCREMENT,
  `usuarionombre` varchar(100) DEFAULT NULL,
  `usuariomail` varchar(100) DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `usuariopassword` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `usuarioestatus` int DEFAULT NULL,
  `rolid` int DEFAULT NULL,
  `sucursalid` int DEFAULT NULL,
  PRIMARY KEY (`usuarioid`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`usuarioid`,`usuarionombre`,`usuariomail`,`usuario`,`usuariopassword`,`created_at`,`updated_at`,`remember_token`,`usuarioestatus`,`rolid`,`sucursalid`) values (4,'aaaa','aaa','aaa','9834876dcfb05cb167a5c24953eba58c4ac89b1adf57f28f2f9d09af107ee8f0','2021-09-13 01:17:00','2024-09-05 21:10:53',NULL,1,1,1),(13,'5','aaa5','aaa5','25b34c9a695e80827663ed3659e99df5c0b160e3ba3456643602b04e44d28fc9','2022-11-27 17:49:10','2024-09-05 21:13:41',NULL,1,15,15),(14,'ANTONIO','CARLOS@HOTMAIL.COM','ANTONIO','5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5','2022-11-27 17:49:44','2024-05-25 12:33:40',NULL,1,1,1),(15,'ENRIQUE','KIKE@hotmail.com','KIKE','5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5','2023-08-11 15:04:19','2023-08-11 15:07:26',NULL,1,1,1),(16,'ALEJANDRO','alex@hotmail.com','ALEX','5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5','2023-08-11 15:05:00','2023-08-11 15:07:42',NULL,1,1,1),(17,'MANUEL','antonio@hotmail.com','MANUEL','5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5','2023-08-11 15:07:06','2024-03-21 14:19:14',NULL,1,1,1),(18,'JAVIER','JAVIS@HOTMAIL.COM','JAVIER','5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5','2023-09-05 15:54:49','2023-09-05 15:54:49',NULL,1,1,1),(19,'ERICK','ERICK@HOTMAIL.COM','ERICK','5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5','2023-09-05 15:55:11','2023-09-05 15:55:11',NULL,1,1,1),(20,'CHAVO','CHAVO@HOTMAIL.COM','CHAVO','5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5','2023-09-05 15:55:33','2023-09-05 15:55:33',NULL,1,1,1),(21,'GERARDO','refugio@hotmail.com','GERARDO','5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5','2023-09-06 11:49:10','2023-10-15 16:17:20',NULL,1,1,1),(22,'MARCELINO','marcelino@hotmail.com','MARCELINO','5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5','2023-09-06 11:56:48','2023-09-06 11:56:48',NULL,1,1,1),(23,'REYNALDO','reynaldo@hotmail.com','REYNALDO','5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5','2023-09-07 16:33:55','2023-09-07 16:33:55',NULL,1,1,1),(24,'POLLITO','pollito@hotmail.com','POLLITO','5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5','2023-09-07 16:38:06','2023-09-07 16:38:06',NULL,1,1,1),(25,'CESAR MALDONADO','maldonado@hotmail.com','maldonado','5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5','2024-03-25 20:29:45','2024-05-01 13:01:37',NULL,1,1,1),(26,'ALBERTO MAGALLANES','magallanes@hotmail.com','magallanes','5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5','2024-03-25 20:30:48','2024-06-02 18:34:26',NULL,1,1,1),(27,'1111','paez@hotmail.com','1111','5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5','2024-05-29 16:13:50','2024-05-29 16:13:50',NULL,1,3,1),(28,'pedro','pedro@hotmail.com','pedro','5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5','2024-08-06 00:16:22','2024-08-06 00:16:22',NULL,1,1,NULL),(29,'pedro','pedro@hotmail.com','pedro','5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5','2024-08-06 00:19:58','2024-08-06 00:19:58',NULL,1,1,NULL),(30,'pedro','pedro@hotmail.com','pedro','5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5','2024-08-06 00:20:49','2024-08-06 00:20:49',NULL,1,1,NULL),(31,'juan','pedro@hotmail.com','pedro','5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5','2024-08-06 00:21:23','2024-08-06 00:21:23',NULL,1,1,NULL),(32,'JUAN PEREZ','juanperez@hotmail.com','JUAN','5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5','2024-09-04 04:18:12','2024-09-05 21:19:43',NULL,1,2,2),(33,'JORGE ANTONIO PAEZ','PAEZ@HOTMAIL.COM','PAEZ','5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5','2024-09-05 17:03:29','2024-09-05 21:18:21',NULL,1,2,2);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
