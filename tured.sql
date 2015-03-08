/*
SQLyog Ultimate v8.71 
MySQL - 5.0.51b-community-nt-log : Database - tured
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`tured` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci */;

/*Table structure for table `creditos` */

DROP TABLE IF EXISTS `creditos`;

CREATE TABLE `creditos` (
  `id_credito` bigint(255) NOT NULL auto_increment,
  `creditos` longtext collate utf8_spanish2_ci,
  `fecha_in` longtext collate utf8_spanish2_ci,
  `status` longtext collate utf8_spanish2_ci,
  `empresa_id` longtext collate utf8_spanish2_ci,
  `aprobado_por` longtext collate utf8_spanish2_ci,
  PRIMARY KEY  (`id_credito`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

/*Data for the table `creditos` */

/*Table structure for table `empresas` */

DROP TABLE IF EXISTS `empresas`;

CREATE TABLE `empresas` (
  `empresa_id` bigint(255) NOT NULL auto_increment,
  `empresa_nombre` longtext collate utf8_spanish2_ci,
  `empresa_rif` longtext collate utf8_spanish2_ci,
  `empresa_direccion` longtext collate utf8_spanish2_ci,
  `empresa_email` longtext collate utf8_spanish2_ci,
  `empresa_www` longtext collate utf8_spanish2_ci,
  `empresa_tel1` longtext collate utf8_spanish2_ci,
  `empresa_tel2` longtext collate utf8_spanish2_ci,
  `empresa_contacto` longtext collate utf8_spanish2_ci,
  `empresa_status` longtext collate utf8_spanish2_ci,
  `empresa_imagen1` longtext collate utf8_spanish2_ci,
  `empresa_imagen2` longtext collate utf8_spanish2_ci,
  `empresa_sector` longtext collate utf8_spanish2_ci,
  `empresa_estado` longtext collate utf8_spanish2_ci,
  `empresa_pais` longtext collate utf8_spanish2_ci,
  `empresa_twitter` longtext collate utf8_spanish2_ci,
  `empresa_facebook` longtext collate utf8_spanish2_ci,
  PRIMARY KEY  (`empresa_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

/*Data for the table `empresas` */

/*Table structure for table `mensajes_in` */

DROP TABLE IF EXISTS `mensajes_in`;

CREATE TABLE `mensajes_in` (
  `id_mensaje` bigint(255) NOT NULL auto_increment,
  `mensaje` longtext collate utf8_spanish2_ci,
  `numero` longtext collate utf8_spanish2_ci,
  `texto` longtext collate utf8_spanish2_ci,
  `fecha` longtext collate utf8_spanish2_ci,
  PRIMARY KEY  (`id_mensaje`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

/*Data for the table `mensajes_in` */

insert  into `mensajes_in`(`id_mensaje`,`mensaje`,`numero`,`texto`,`fecha`) values (1,'14526931','04166180003',NULL,'02/09/2013 10:15:40');
insert  into `mensajes_in`(`id_mensaje`,`mensaje`,`numero`,`texto`,`fecha`) values (2,'14526931','04166180003',NULL,'02/09/2013 10:17:08');
insert  into `mensajes_in`(`id_mensaje`,`mensaje`,`numero`,`texto`,`fecha`) values (3,'14526931','04166180003',NULL,'02/09/2013 10:19:23');
insert  into `mensajes_in`(`id_mensaje`,`mensaje`,`numero`,`texto`,`fecha`) values (4,'13135909','04166180003',NULL,'06/09/2013 06:58:52');
insert  into `mensajes_in`(`id_mensaje`,`mensaje`,`numero`,`texto`,`fecha`) values (5,'12627891','04166180003',NULL,'06/09/2013 07:03:27');
insert  into `mensajes_in`(`id_mensaje`,`mensaje`,`numero`,`texto`,`fecha`) values (6,'12627890','04166180003',NULL,'06/09/2013 07:07:59');
insert  into `mensajes_in`(`id_mensaje`,`mensaje`,`numero`,`texto`,`fecha`) values (7,'12627890','04166180003',NULL,'06/09/2013 07:09:07');
insert  into `mensajes_in`(`id_mensaje`,`mensaje`,`numero`,`texto`,`fecha`) values (8,'12627890','04166180003',NULL,'06/09/2013 07:09:35');
insert  into `mensajes_in`(`id_mensaje`,`mensaje`,`numero`,`texto`,`fecha`) values (9,'12627890','04166180003',NULL,'06/09/2013 07:25:12');
insert  into `mensajes_in`(`id_mensaje`,`mensaje`,`numero`,`texto`,`fecha`) values (10,'12627890','04166180003',NULL,'06/09/2013 07:26:53');
insert  into `mensajes_in`(`id_mensaje`,`mensaje`,`numero`,`texto`,`fecha`) values (11,'12627890','04166180003',NULL,'06/09/2013 07:34:25');
insert  into `mensajes_in`(`id_mensaje`,`mensaje`,`numero`,`texto`,`fecha`) values (12,'12627890','04166180003',NULL,'06/09/2013 07:36:35');
insert  into `mensajes_in`(`id_mensaje`,`mensaje`,`numero`,`texto`,`fecha`) values (13,'12627890','04166180003',NULL,'06/09/2013 07:38:37');
insert  into `mensajes_in`(`id_mensaje`,`mensaje`,`numero`,`texto`,`fecha`) values (14,'398591','04166180003',NULL,'06/09/2013 07:39:00');
insert  into `mensajes_in`(`id_mensaje`,`mensaje`,`numero`,`texto`,`fecha`) values (15,'3985916','04166180003',NULL,'06/09/2013 07:39:05');
insert  into `mensajes_in`(`id_mensaje`,`mensaje`,`numero`,`texto`,`fecha`) values (16,'13637432','04162141512',NULL,'06/09/2013 08:01:46');
insert  into `mensajes_in`(`id_mensaje`,`mensaje`,`numero`,`texto`,`fecha`) values (17,'15614132','04166183103',NULL,'06/09/2013 08:02:50');
insert  into `mensajes_in`(`id_mensaje`,`mensaje`,`numero`,`texto`,`fecha`) values (18,'14526931','04166180003',NULL,'06/09/2013 08:03:03');
insert  into `mensajes_in`(`id_mensaje`,`mensaje`,`numero`,`texto`,`fecha`) values (19,'14526931','04166180003',NULL,'06/09/2013 10:58:29');

/*Table structure for table `transacciones` */

DROP TABLE IF EXISTS `transacciones`;

CREATE TABLE `transacciones` (
  `id_transaccion` bigint(255) NOT NULL auto_increment,
  `hora` longtext collate utf8_spanish2_ci,
  `fecha` longtext collate utf8_spanish2_ci,
  `empresa_id` longtext collate utf8_spanish2_ci,
  `usuario_id` longtext collate utf8_spanish2_ci,
  `factura` longtext collate utf8_spanish2_ci,
  `monto` longtext collate utf8_spanish2_ci,
  `vendedor_id` longtext collate utf8_spanish2_ci,
  `referido_por` longtext collate utf8_spanish2_ci,
  `status` longtext collate utf8_spanish2_ci,
  `tipo` longtext collate utf8_spanish2_ci,
  `dia` longtext collate utf8_spanish2_ci,
  PRIMARY KEY  (`id_transaccion`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

/*Data for the table `transacciones` */

/*Table structure for table `usuarios` */

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `id_usuario` bigint(255) NOT NULL auto_increment,
  `nombres` longtext collate utf8_spanish2_ci,
  `ci` longtext collate utf8_spanish2_ci,
  `telf` longtext collate utf8_spanish2_ci,
  `status` longtext collate utf8_spanish2_ci,
  `estado` longtext collate utf8_spanish2_ci,
  `fecha_in` longtext collate utf8_spanish2_ci,
  `emPresa_id` longtext collate utf8_spanish2_ci,
  PRIMARY KEY  (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

/*Data for the table `usuarios` */

/*Table structure for table `usuarios_empresas` */

DROP TABLE IF EXISTS `usuarios_empresas`;

CREATE TABLE `usuarios_empresas` (
  `usuario_id` bigint(255) NOT NULL auto_increment,
  `empresa_id` longtext collate utf8_spanish2_ci,
  `usuario_email` longtext collate utf8_spanish2_ci,
  `usuario_email2` longtext collate utf8_spanish2_ci,
  `usuario_telf` longtext collate utf8_spanish2_ci,
  `usuario_login` longtext collate utf8_spanish2_ci,
  `usuario_pass` longtext collate utf8_spanish2_ci,
  `usuario_status` longtext collate utf8_spanish2_ci,
  PRIMARY KEY  (`usuario_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

/*Data for the table `usuarios_empresas` */

/*Table structure for table `variables` */

DROP TABLE IF EXISTS `variables`;

CREATE TABLE `variables` (
  `porcentaje` varchar(255) default NULL,
  `enviamensajes` varchar(255) default NULL,
  `vigencia_credito` varchar(255) default NULL,
  `mensaje_registro` varchar(244) default NULL,
  `mensaje_compra` varchar(255) default NULL,
  `id_usuario` bigint(255) default NULL,
  `empresa_id` bigint(20) NOT NULL,
  PRIMARY KEY  (`empresa_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `variables` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
