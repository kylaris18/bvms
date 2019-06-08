/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.1.38-MariaDB : Database - db_bvms
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_bvms` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `db_bvms`;

/*Table structure for table `accounts` */

DROP TABLE IF EXISTS `accounts`;

CREATE TABLE `accounts` (
  `account_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `account_uname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_type` int(11) NOT NULL,
  `account_suspend` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `accounts` */

insert  into `accounts`(`account_id`,`account_uname`,`account_password`,`account_type`,`account_suspend`,`created_at`,`updated_at`) values (1,'ecruz','e64dfbc42b4939ad984e4fc398cdd4d826873e51',0,0,NULL,NULL),(22,'bellachan','e64dfbc42b4939ad984e4fc398cdd4d826873e51',1,0,NULL,NULL);

/*Table structure for table `brgies` */

DROP TABLE IF EXISTS `brgies`;

CREATE TABLE `brgies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `brgy_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brgy_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brgy_captain` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brgy_sk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `brgies` */

insert  into `brgies`(`id`,`brgy_name`,`brgy_address`,`brgy_captain`,`brgy_sk`,`created_at`,`updated_at`) values (1,'Baranggay Langgam','San Pedro City, Laguna, PH','Edgar San Luis','Bryan Higa',NULL,NULL);

/*Table structure for table `councilors` */

DROP TABLE IF EXISTS `councilors`;

CREATE TABLE `councilors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `councilor_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `councilors` */

insert  into `councilors`(`id`,`councilor_name`,`created_at`,`updated_at`) values (1,'Neslie Magtanggol',NULL,NULL),(2,'Robert Cruz',NULL,NULL),(3,'Pamela Remoquilo',NULL,NULL),(4,'John Marvin Bien',NULL,NULL),(5,'Christian Felipe',NULL,NULL),(6,'Kenneth Piezas',NULL,NULL),(7,'Jasmin Alora',NULL,NULL);

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (5,'2019_06_01_174914_create_violators_table',3),(6,'2019_06_01_173231_create_types_table',4),(16,'2019_06_01_173244_create_violations_table',5),(17,'2019_06_01_080247_create_accounts_table',6),(20,'2019_06_01_080231_create_users_table',7),(21,'2019_06_08_181325_create_brgies_table',8),(22,'2019_06_08_181817_create_councilors_table',8);

/*Table structure for table `types` */

DROP TABLE IF EXISTS `types`;

CREATE TABLE `types` (
  `type_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `types` */

insert  into `types`(`type_id`,`type_name`,`created_at`,`updated_at`) values (1,'Loitering',NULL,NULL),(2,'No Entry',NULL,NULL),(3,'No Parking',NULL,NULL),(4,'No Loading/Unloading',NULL,NULL),(5,'Illegal Vending',NULL,NULL),(6,'Jaywalking',NULL,NULL),(7,'test violation',NULL,NULL),(8,'test violation',NULL,NULL),(9,'test',NULL,NULL);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `user_fname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_lname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_contactno` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`user_id`,`account_id`,`user_fname`,`user_lname`,`user_contactno`,`user_photo`,`created_at`,`updated_at`) values (1,1,'Emmanuel','Cruz','9476025547','/storage/profile/1560028962.jpg',NULL,NULL),(2,22,'Jonabelle ','Labao','9476085541','/storage/profile/1559989856.png',NULL,NULL);

/*Table structure for table `violations` */

DROP TABLE IF EXISTS `violations`;

CREATE TABLE `violations` (
  `violation_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `violation_violator` int(11) NOT NULL,
  `violation_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `violation_status` int(11) NOT NULL,
  `violation_report` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `violation_resolution` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `violation_notes` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `violation_photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`violation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `violations` */

insert  into `violations`(`violation_id`,`type_id`,`account_id`,`violation_violator`,`violation_date`,`violation_status`,`violation_report`,`violation_resolution`,`violation_notes`,`violation_photo`,`created_at`,`updated_at`) values (1,3,1,1,'1559952000',1,'1559715776','asdfasdf','sfasdf','N/A',NULL,NULL),(2,3,1,1,'1562284800',2,'1559715792',NULL,'park again','N/A',NULL,NULL),(3,3,1,1,'1562112000',3,'1559715965',NULL,'fbzcvzs','N/A',NULL,NULL),(4,3,1,1,'1560124800',4,'1559981878',NULL,'this sht','/storage/uploads/1559981878.png',NULL,NULL),(5,3,1,1,'1559865600',5,'1559982649',NULL,'did again','N/A',NULL,NULL),(6,3,1,1,'1560297600',6,'1559983678',NULL,'sfgsdfg','/storage/uploads/1559983678.png',NULL,NULL),(7,3,1,5,'1560988800',1,'1559983730','test resolution','asdfasdf','/storage/uploads/1559983730.png',NULL,NULL),(8,1,1,1,'1559779200',1,'1559983765',NULL,'asdfasdfasdfasdfasd','/storage/uploads/1559987668.png',NULL,NULL),(9,3,22,5,'1559260800',2,'1559991562',NULL,'asdfasdfasdfasdfasdfas','/storage/uploads/1559991562.png',NULL,NULL),(10,3,22,1,'1560297600',7,'1560004548',NULL,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer pulvinar cursus mattis. Morbi a auctor ligula, non semper libero. Etiam vel laoreet ligula. Phasellus egestas lectus id pretium lacinia. Nunc id nibh nec ligula','/storage/uploads/1560004547.jpg',NULL,NULL),(13,8,22,1,'1561766400',3,'1560006033',NULL,'asdfasdfasdf','/storage/uploads/1560006033.jpg',NULL,NULL),(14,9,22,1,'1561161600',1,'1560012318',NULL,'awfasdfasdf','/storage/uploads/1560012318.png',NULL,NULL);

/*Table structure for table `violators` */

DROP TABLE IF EXISTS `violators`;

CREATE TABLE `violators` (
  `violator_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `violator_lname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `violator_fname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `violator_mname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `violator_count` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`violator_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `violators` */

insert  into `violators`(`violator_id`,`violator_lname`,`violator_fname`,`violator_mname`,`violator_count`,`created_at`,`updated_at`) values (1,'Labao','Christian Jay','Mendoza',1,NULL,NULL),(2,'Dominguez','Rodel','N/A',0,NULL,NULL),(3,'Delarosa','Rosito','N/A',0,NULL,NULL),(4,'Delarosa','Sherwin','Mendoza',0,NULL,NULL),(5,'Labao','casey','Mendoza',0,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
