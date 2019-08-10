/*
SQLyog Ultimate v12.4.3 (64 bit)
MySQL - 5.7.27-0ubuntu0.18.04.1 : Database - wakuliner
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`wakuliner` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `wakuliner`;

/*Table structure for table `banner` */

DROP TABLE IF EXISTS `banner`;

CREATE TABLE `banner` (
  `banner_id` int(4) NOT NULL AUTO_INCREMENT,
  `baner_name` varchar(50) DEFAULT NULL,
  `baner_desc` varchar(255) DEFAULT NULL,
  `baner_link` varchar(255) DEFAULT NULL,
  `meta_title` varchar(150) DEFAULT NULL,
  `meta_desc` varchar(150) DEFAULT NULL,
  `meta_tag` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`banner_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `banner` */

insert  into `banner`(`banner_id`,`baner_name`,`baner_desc`,`baner_link`,`meta_title`,`meta_desc`,`meta_tag`) values 
(1,'WAHWAH','Wahwah Catring',NULL,NULL,NULL,NULL);

/*Table structure for table `kategori` */

DROP TABLE IF EXISTS `kategori`;

CREATE TABLE `kategori` (
  `kategori_id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(50) NOT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  PRIMARY KEY (`kategori_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `kategori` */

insert  into `kategori`(`kategori_id`,`nama_kategori`,`create_at`,`update_at`) values 
(2,'Bakso','2019-08-09 20:11:55','2019-08-09 20:11:58'),
(3,'Sate','2019-08-09 20:12:37','2019-08-09 20:12:40'),
(4,'Soto','2019-08-09 20:12:53','2019-08-09 20:12:55'),
(5,'Thaitea','2019-08-09 20:14:27','2019-08-09 20:14:29'),
(6,'Olahan Ayam','2019-08-10 13:38:43','2019-08-10 14:06:52'),
(7,'Olahan Singkong','2019-08-10 13:59:54','2019-08-10 13:59:54');

/*Table structure for table `produk` */

DROP TABLE IF EXISTS `produk`;

CREATE TABLE `produk` (
  `produk_id` int(11) NOT NULL AUTO_INCREMENT,
  `kategori_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `harga` float NOT NULL,
  `deskripsi` text,
  `foto` varchar(100) DEFAULT NULL,
  `berat` int(11) NOT NULL,
  `halal` tinyint(1) DEFAULT '0' COMMENT '0 = halal, 1 = non halal',
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  PRIMARY KEY (`produk_id`),
  KEY `kategori_id` (`kategori_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`kategori_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `produk_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `produk` */

insert  into `produk`(`produk_id`,`kategori_id`,`user_id`,`nama_produk`,`harga`,`deskripsi`,`foto`,`berat`,`halal`,`create_at`,`update_at`) values 
(10,3,6,'Sate Ayam Pak Nono',10000,'sate ayam pak nono',NULL,100,0,'2019-08-10 04:39:30','2019-08-10 04:39:31'),
(11,2,7,'Bakso Pangsit',9000,'Bakso Pangsit ',NULL,100,0,'2019-08-10 04:39:30','2019-08-10 04:39:31');

/*Table structure for table `token` */

DROP TABLE IF EXISTS `token`;

CREATE TABLE `token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `is_private_key` tinyint(1) NOT NULL DEFAULT '0',
  `ip_addresses` text,
  `date_created` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `token_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `token` */

insert  into `token`(`id`,`user_id`,`token`,`level`,`ignore_limits`,`is_private_key`,`ip_addresses`,`date_created`) values 
(1,5,'1234567890',1,0,0,NULL,1),
(2,6,'0987654321',0,0,0,NULL,1);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'static/dist/img/avatar5.png',
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `birthday` date DEFAULT NULL,
  `role` enum('admin','member') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`user_id`,`name`,`photo`,`username`,`email`,`password`,`address`,`phone`,`gender`,`status`,`birthday`,`role`,`created_at`,`updated_at`) values 
(5,'Saya Admin','static/dist/img/avatar5.png','admin','admin@admin.com','21232f297a57a5a743894a0e4a801fc3','Yogyakarta','0823','L','0','2019-08-10','admin','2019-08-10 04:20:40','2019-08-10 04:20:42'),
(6,'Saya User','static/dist/img/avatar5.png','user','user@user.com','ee11cbb19052e40b07aac0ca060c23ee','Jakarta','0735','P','0','2019-08-10','member','2019-08-10 04:21:51','2019-08-10 04:21:54'),
(7,'saya User 2','static/dist/img/avatar5.png','user2','user2@gmail.com','7e58d63b60197ceb55a1c487989a3720','Bandung','0987','L','0','2019-08-10','member','2019-08-10 04:41:58','2019-08-10 04:42:00');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
