/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.5.5-10.1.24-MariaDB : Database - ace_system
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`ace_system` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `ace_system`;

/*Table structure for table `acc_status` */

DROP TABLE IF EXISTS `acc_status`;

CREATE TABLE `acc_status` (
  `status_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `acc_status` */

insert  into `acc_status`(`status_id`,`status_name`) values (1,'Activated'),(2,'Deactivated'),(3,'For Approval');

/*Table structure for table `account_reservations` */

DROP TABLE IF EXISTS `account_reservations`;

CREATE TABLE `account_reservations` (
  `reservation_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `checkin` date DEFAULT NULL,
  `checkout` date DEFAULT NULL,
  `pax` int(2) DEFAULT NULL,
  `room_type` int(2) DEFAULT NULL,
  `mop` int(2) DEFAULT NULL,
  `reservation_status` bigint(20) DEFAULT '1',
  `assigned_room` bigint(20) DEFAULT NULL,
  `reservation_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `is_deleted` int(1) DEFAULT '0',
  PRIMARY KEY (`reservation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `account_reservations` */

insert  into `account_reservations`(`reservation_id`,`user_id`,`checkin`,`checkout`,`pax`,`room_type`,`mop`,`reservation_status`,`assigned_room`,`reservation_date`,`is_deleted`) values (2,8,'2018-08-28','2018-08-30',4,5,1,2,2,'2018-08-18 01:16:34',0),(3,8,'2018-09-04','2018-09-07',2,1,1,2,1,'2018-08-18 15:07:48',0),(4,8,'2018-08-31','2018-09-08',3,1,1,2,1,'2018-08-18 20:42:04',0),(5,8,'2018-08-23','2018-08-24',2,6,1,2,3,'2018-08-18 21:05:29',0),(6,8,'2018-08-27','2019-08-01',3,1,1,2,5,'2018-08-27 14:05:42',0);

/*Table structure for table `food_service` */

DROP TABLE IF EXISTS `food_service`;

CREATE TABLE `food_service` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `food_type` varchar(255) DEFAULT NULL,
  `service_duration` varchar(255) DEFAULT NULL,
  `is_deleted` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `food_service` */

insert  into `food_service`(`id`,`food_type`,`service_duration`,`is_deleted`) values (1,'Spicy Adobo','Lunch & Dinner',0),(2,'Pakbet','Dinner',0),(3,'Adobo','Lunch & Dinner',0),(4,'Longsilog','Morning',0),(5,'Chicaron Bulaklak','Lunch & Dinner',0),(6,'Bulalong Baka','Lunch & Dinner',0);

/*Table structure for table `mop` */

DROP TABLE IF EXISTS `mop`;

CREATE TABLE `mop` (
  `mop_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `mop_name` varchar(255) DEFAULT NULL,
  `mop_subtext` varchar(255) DEFAULT NULL,
  `is_deleted` bigint(1) DEFAULT '0',
  PRIMARY KEY (`mop_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `mop` */

insert  into `mop`(`mop_id`,`mop_name`,`mop_subtext`,`is_deleted`) values (1,'Installment','with Downpayment',0);

/*Table structure for table `payment_records` */

DROP TABLE IF EXISTS `payment_records`;

CREATE TABLE `payment_records` (
  `payment_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `payee_id` bigint(20) DEFAULT NULL,
  `transaction_id` bigint(20) DEFAULT NULL,
  `reservation_id` bigint(20) DEFAULT NULL,
  `fee` decimal(10,2) DEFAULT NULL,
  `balance_total` decimal(10,2) DEFAULT NULL,
  `payment_total` decimal(10,2) DEFAULT NULL,
  `change_total` decimal(10,2) DEFAULT NULL,
  `payment_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `payment_recipient` bigint(20) DEFAULT NULL,
  `is_deleted` int(1) DEFAULT '0',
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

/*Data for the table `payment_records` */

insert  into `payment_records`(`payment_id`,`payee_id`,`transaction_id`,`reservation_id`,`fee`,`balance_total`,`payment_total`,`change_total`,`payment_date`,`payment_recipient`,`is_deleted`) values (40,8,7,6,'3389996.61','389996.61','3000000.00','0.00','2018-08-27 14:30:21',2,0),(41,8,7,6,'3389996.61','6000.00','383996.61','0.00','2018-08-27 14:30:51',2,0),(42,8,7,6,'3389996.61','0.00','6000.00','0.00','2018-08-27 14:30:58',2,0),(43,8,2,5,'500.00','0.00','500.00','0.00','2018-08-27 14:34:45',2,0),(44,8,1,3,'29999.97','0.00','30000.00','0.03','2018-08-27 14:41:55',2,0);

/*Table structure for table `promos` */

DROP TABLE IF EXISTS `promos`;

CREATE TABLE `promos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `promo_name` varchar(255) DEFAULT NULL,
  `food_service` text,
  `room_type` text,
  `pax` int(2) DEFAULT NULL,
  `cost` bigint(20) DEFAULT NULL,
  `due` date DEFAULT NULL,
  `is_deleted` int(1) DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `promos` */

insert  into `promos`(`ID`,`promo_name`,`food_service`,`room_type`,`pax`,`cost`,`due`,`is_deleted`) values (1,'2 Days 1 Night (4 Pax)','2,4,5','1',4,15500,'2018-10-31',0);

/*Table structure for table `reservation_status` */

DROP TABLE IF EXISTS `reservation_status`;

CREATE TABLE `reservation_status` (
  `status_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(255) DEFAULT NULL,
  `is_deleted` int(1) DEFAULT '0',
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `reservation_status` */

insert  into `reservation_status`(`status_id`,`status_name`,`is_deleted`) values (1,'Pending',0),(2,'Approved',0),(3,'Declined',0);

/*Table structure for table `room_availability` */

DROP TABLE IF EXISTS `room_availability`;

CREATE TABLE `room_availability` (
  `avail_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `reservation_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `checkin` date DEFAULT NULL,
  `checkout` date DEFAULT NULL,
  `room_number` bigint(20) DEFAULT NULL,
  `room_type` bigint(20) DEFAULT NULL,
  `is_deleted` int(1) DEFAULT '0',
  PRIMARY KEY (`avail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `room_availability` */

insert  into `room_availability`(`avail_id`,`reservation_id`,`user_id`,`checkin`,`checkout`,`room_number`,`room_type`,`is_deleted`) values (3,2,8,'2018-08-28','2018-08-30',2,5,0),(4,3,8,'2018-09-04','2018-09-07',1,1,0),(7,4,8,'2018-08-31','2018-09-08',1,1,1),(8,5,8,'2018-08-23','2018-08-24',3,6,1),(9,6,8,'2018-08-27','2019-08-01',5,1,1);

/*Table structure for table `room_type` */

DROP TABLE IF EXISTS `room_type`;

CREATE TABLE `room_type` (
  `room_type_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `room_name` varchar(255) DEFAULT NULL,
  `room_capacity` bigint(20) DEFAULT NULL,
  `room_cost` decimal(10,2) DEFAULT NULL,
  `is_deleted` bigint(1) DEFAULT '0',
  PRIMARY KEY (`room_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `room_type` */

insert  into `room_type`(`room_type_id`,`room_name`,`room_capacity`,`room_cost`,`is_deleted`) values (1,'Dhalia',10,'9999.99',0),(5,'Bungalow',20,'15000.00',0),(6,'Rosas',2,'500.00',0),(7,'Macopa',3,'899.99',0),(8,'Test',50,'213213.00',1);

/*Table structure for table `rooms` */

DROP TABLE IF EXISTS `rooms`;

CREATE TABLE `rooms` (
  `room_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `room_number` bigint(5) DEFAULT NULL,
  `room_type` bigint(20) DEFAULT NULL,
  `is_deleted` int(1) DEFAULT '0',
  PRIMARY KEY (`room_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `rooms` */

insert  into `rooms`(`room_id`,`room_number`,`room_type`,`is_deleted`) values (1,101,1,0),(2,201,5,0),(3,401,6,0),(4,110,7,0),(5,202,1,0),(6,223,5,0);

/*Table structure for table `transaction` */

DROP TABLE IF EXISTS `transaction`;

CREATE TABLE `transaction` (
  `transaction_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `reservation_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `checkin` date DEFAULT NULL,
  `checkout` date DEFAULT NULL,
  `stay_duration` time DEFAULT NULL,
  `room_number` bigint(20) DEFAULT NULL,
  `room_type` bigint(20) DEFAULT NULL,
  `mop` bigint(20) DEFAULT NULL,
  `fee` decimal(10,2) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT NULL,
  `date_paid` datetime DEFAULT NULL,
  `received_id` bigint(20) DEFAULT NULL,
  `is_deleted` int(1) DEFAULT '0',
  PRIMARY KEY (`transaction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `transaction` */

insert  into `transaction`(`transaction_id`,`reservation_id`,`user_id`,`checkin`,`checkout`,`stay_duration`,`room_number`,`room_type`,`mop`,`fee`,`balance`,`date_paid`,`received_id`,`is_deleted`) values (1,3,8,'2018-09-04','2018-09-07','72:00:00',1,1,1,'29999.97','0.00','2018-08-27 14:41:55',2,0),(2,5,8,'2018-08-23','2018-08-24','24:00:00',3,6,1,'500.00','0.00','2018-08-27 14:34:45',2,0),(7,6,8,'2018-08-27','2019-08-01','838:59:59',5,1,1,'3389996.61','0.00','2018-08-27 14:30:58',2,0);

/*Table structure for table `user_role` */

DROP TABLE IF EXISTS `user_role`;

CREATE TABLE `user_role` (
  `role_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) DEFAULT NULL,
  `is_deleted` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `user_role` */

insert  into `user_role`(`role_id`,`role_name`,`is_deleted`) values (1,'Admin',0),(2,'Member',0);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `f_name` varchar(255) DEFAULT NULL,
  `l_name` varchar(255) DEFAULT NULL,
  `m_name` varchar(255) DEFAULT NULL,
  `b_day` date DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile_no` bigint(20) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_role_id` bigint(20) DEFAULT '2',
  `is_newpass` int(1) DEFAULT '0',
  `is_activated` int(1) DEFAULT '3',
  `is_deleted` bigint(20) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`password`,`f_name`,`l_name`,`m_name`,`b_day`,`email`,`mobile_no`,`sex`,`date_created`,`user_role_id`,`is_newpass`,`is_activated`,`is_deleted`) values (1,'CarlDennis','$2y$12$4mrFQDpx5lN9nUFo67SsHOMmscECqznJUZ69nZurdx/f55HKEYFbm','Carl Dennis','Alingalan','Matias','1997-09-16','carl.alingalan@gmail.com',9321412312,'male','2018-07-26 22:05:54',2,0,2,0),(2,'CarlDennisa','$2y$12$XtvJmPdbly2burjDjru.Fu.3A15mtZErFg9ONrpX3312vqm2ehGWu','Carl Dennis','Alingalan','Matias','1997-09-16','acarl.alingalan@gmail.com',9292062632,'male','2018-07-26 22:20:27',1,0,1,0),(4,'Aila17','$2y$12$8e/SqC/8MDxre.Sl8eGHa.5sZN1hB7J9ip6NgC3JvtOvih7a5I32q','Aila Mae','Espinas','Marfil','1997-05-17','aila.marfil@gmail.com',9292062632,'female','2018-07-26 22:56:26',2,0,2,0),(7,'JoelSenpai','$2y$12$OuuVgq2Uv1Zs2i/5X34a2OM2lZte95TcPdd5nrMMf8uRrNCbL243.','Joel Jude','Castillo','Borha','1997-08-05','joel@gmail.com',9292062632,'male','2018-08-05 14:09:05',2,0,1,0),(8,'RicaMae','$2y$12$BmHW1fB2p9ooTbTQhZIEpeUoD0w.dut/ReQkrr9xjx7n9vX5VKy2.','Rica Mae','Manalo','','1997-08-15','ricamae@gmail.com',9231231231,'female','2018-08-11 14:35:20',2,0,1,0),(9,'AilaEspinas','$2y$12$/.YvNSVvIYTyXX7F0ZxRJ.vu3u12d0WjOd2jxDZ1J5hZK/7c9marW','Aila','Espinas','M.','2018-09-28','ailamarfil69@gmail.com',9952162844,'female','2018-09-01 00:12:30',2,0,1,0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
