/*
SQLyog Ultimate v12.5.0 (64 bit)
MySQL - 10.4.28-MariaDB : Database - hospital_management_system
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`hospital_management_system` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;

USE `hospital_management_system`;

/*Table structure for table `appointments` */

DROP TABLE IF EXISTS `appointments`;

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(11) DEFAULT NULL,
  `stripe_invoice_id` varchar(255) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `start_time` varchar(255) DEFAULT NULL,
  `end_time` varchar(255) DEFAULT NULL,
  `day` varchar(255) DEFAULT NULL,
  `amount_due` varchar(255) DEFAULT NULL,
  `amount_paid` varchar(255) DEFAULT NULL,
  `invoice_status` varchar(255) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `appointments` */

insert  into `appointments`(`id`,`patient_id`,`stripe_invoice_id`,`doctor_id`,`start_time`,`end_time`,`day`,`amount_due`,`amount_paid`,`invoice_status`,`status`,`created_at`,`updated_at`,`deleted_at`) values 
(1,3,'cs_test_a1xYzdAmDhZBXoITkhAUDsURVy3XK6eD0eWKEvOEUYjSZhugev9jiMnv5j',2,'16:00','18:00','Monday','700','0',NULL,'booked','2024-12-18 01:02:50','2024-12-21 01:52:36',NULL);

/*Table structure for table `blog_attachments` */

DROP TABLE IF EXISTS `blog_attachments`;

CREATE TABLE `blog_attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) unsigned NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `blog_id` (`blog_id`),
  CONSTRAINT `blog_attachments_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `blog_attachments` */

insert  into `blog_attachments`(`id`,`blog_id`,`file`,`created_at`,`updated_at`,`deleted_at`) values 
(1,8,'blog_attachments/pPwySo9oceuj11PHWzuzzy3yB0ADuF5PG6SNXzNI.jpg','2024-12-18 00:56:59','2024-12-18 00:56:59',NULL),
(2,8,'blog_attachments/GIWK3RFbOVKUOikUEG44YJhCzv3iqH4vpIJ5G2oO.jpg','2024-12-18 00:56:59','2024-12-18 00:56:59',NULL);

/*Table structure for table `blog_tags` */

DROP TABLE IF EXISTS `blog_tags`;

CREATE TABLE `blog_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) unsigned NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `blog_id` (`blog_id`),
  CONSTRAINT `blog_tags_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `blog_tags` */

insert  into `blog_tags`(`id`,`blog_id`,`name`,`created_at`,`updated_at`,`deleted_at`) values 
(1,8,'Urology','2024-12-18 05:59:31','2024-12-18 00:59:31','2024-12-18 00:59:31'),
(2,8,'Neuromodulation ','2024-12-18 05:59:31','2024-12-18 00:59:31','2024-12-18 00:59:31'),
(3,8,'OAB phenotypes','2024-12-18 05:59:31','2024-12-18 00:59:31','2024-12-18 00:59:31'),
(4,8,'stimulation ','2024-12-18 05:59:31','2024-12-18 00:59:31','2024-12-18 00:59:31'),
(5,8,'Chronic animal','2024-12-18 05:59:31','2024-12-18 00:59:31','2024-12-18 00:59:31'),
(6,8,'Urology','2024-12-18 00:59:31','2024-12-18 00:59:31',NULL),
(7,8,'Neuromodulation','2024-12-18 00:59:31','2024-12-18 00:59:31',NULL),
(8,8,'OAB phenotypes','2024-12-18 00:59:31','2024-12-18 00:59:31',NULL),
(9,8,'stimulation','2024-12-18 00:59:31','2024-12-18 00:59:31',NULL),
(10,8,'Chronic animal','2024-12-18 00:59:31','2024-12-18 00:59:31',NULL);

/*Table structure for table `blogs` */

DROP TABLE IF EXISTS `blogs`;

CREATE TABLE `blogs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `doctor_id` int(11) DEFAULT NULL,
  `speciality_id` varchar(255) DEFAULT NULL,
  `title` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `blogs` */

insert  into `blogs`(`id`,`doctor_id`,`speciality_id`,`title`,`description`,`status`,`created_at`,`updated_at`,`deleted_at`) values 
(8,2,'1','The mechanism of action of neuromodulation in the treatment of overactive bladder','<section aria-labelledby=\"Abs1\" data-title=\"Abstract\" lang=\"en\" style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: Harding, Palatino, serif; font-size: 18px; background-color: rgb(255, 255, 255);\"><div class=\"c-article-section\" id=\"Abs1-section\" style=\"box-sizing: inherit; clear: both;\"><h2 class=\"c-article-section__title js-section-title js-c-reading-companion-sections-item\" id=\"Abs1\" style=\"-webkit-font-smoothing: antialiased; font-family: Harding, Palatino, serif; font-weight: 700; letter-spacing: -0.0117156rem; font-size: 1.5rem; line-height: 1.24; box-sizing: inherit; border-bottom: 2px solid rgb(213, 213, 213); margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding-bottom: 8px;\">Abstract</h2><div class=\"c-article-section__content\" id=\"Abs1-content\" style=\"box-sizing: inherit; margin-bottom: 40px; padding-top: 8px;\"><p style=\"overflow-wrap: break-word; word-break: break-word; box-sizing: inherit; margin-bottom: 24px;\">Neuromodulation has been used in the treatment of various pelvic organ dysfunctions for almost 40 years and several placebo-controlled studies have confirmed its clinical effect. Many neuromodulation methods using different devices and stimulation parameters, targeting different neural structures have been introduced, but only a limited number have been adopted into routine clinical use. A substantial volume of basic research and clinical studies addressing specific effects of neuromodulation in the treatment of overactive bladder (OAB) have been published to date; however, their mechanistic implications have not been comprehensively summarized. Thus, our understanding of the mechanism of action of neuromodulation in OAB treatment is mainly based on postulated theories. Results from animal experiments suggest that different neuromodulation methods used to treat OAB share the same basic principles. The most likely explanation for the effect of neuromodulation in OAB therapy is the suppression of bladder afferent signalling, promotion of spinal guarding reflexes and modulation of non-specific supraspinal regulatory circuits.</p></div></div></section><section aria-labelledby=\"Abs3\" data-title=\"Key points\" lang=\"en\" style=\"box-sizing: inherit; color: rgb(34, 34, 34); font-family: Harding, Palatino, serif; font-size: 18px; background-color: rgb(255, 255, 255);\"><div class=\"c-article-section\" id=\"Abs3-section\" style=\"box-sizing: inherit; clear: both;\"><h2 class=\"c-article-section__title js-section-title js-c-reading-companion-sections-item\" id=\"Abs3\" style=\"-webkit-font-smoothing: antialiased; font-family: Harding, Palatino, serif; font-weight: 700; letter-spacing: -0.0117156rem; font-size: 1.5rem; line-height: 1.24; box-sizing: inherit; border-bottom: 2px solid rgb(213, 213, 213); margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding-bottom: 8px;\">Key points</h2><div class=\"c-article-section__content\" id=\"Abs3-content\" style=\"box-sizing: inherit; margin-bottom: 40px; padding-top: 8px;\"><ul class=\"u-list-style-bullet\" style=\"box-sizing: inherit; margin-bottom: 24px;\"><li style=\"box-sizing: inherit;\"><p style=\"overflow-wrap: break-word; word-break: break-word; box-sizing: inherit; margin-bottom: 24px;\">The substantial clinical (non-placebo-related) effect of neuromodulation in the treatment of overactive bladder (OAB) has been clearly demonstrated.</p></li><li style=\"box-sizing: inherit;\"><p style=\"overflow-wrap: break-word; word-break: break-word; box-sizing: inherit; margin-bottom: 24px;\">New modalities of neuromodulation are being developed with the aim of improving efficacy and accessibility.</p></li><li style=\"box-sizing: inherit;\"><p style=\"overflow-wrap: break-word; word-break: break-word; box-sizing: inherit; margin-bottom: 24px;\">Clinical and experimental evidence addressing the mechanism of action of neuromodulation in the treatment of OAB exists.</p></li><li style=\"box-sizing: inherit;\"><p style=\"overflow-wrap: break-word; word-break: break-word; box-sizing: inherit; margin-bottom: 24px;\">Different neuromodulation methods used to treat OAB share basic principles and most probably lead to the suppression of bladder afferent signalling, promotion of spinal guarding reflexes and modulation of non-specific supraspinal regulatory circuits.</p></li><li style=\"box-sizing: inherit;\"><p style=\"overflow-wrap: break-word; word-break: break-word; box-sizing: inherit; margin-bottom: 24px;\">Chronic animal and mechanistic clinical studies comparing different OAB phenotypes, treatment parameters, stimulation sites and protocols are warranted.</p></li></ul></div></div></section>','0','2024-12-18 06:34:50','2024-12-18 01:34:50',NULL);

/*Table structure for table `comments` */

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) unsigned NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `blog_id` (`blog_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `comments` */

/*Table structure for table `contacts` */

DROP TABLE IF EXISTS `contacts`;

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `subject` text DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `contacts` */

/*Table structure for table `doctor_attachments` */

DROP TABLE IF EXISTS `doctor_attachments`;

CREATE TABLE `doctor_attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doctor_id` int(11) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `doctor_attachments` */

insert  into `doctor_attachments`(`id`,`doctor_id`,`file`,`created_at`,`updated_at`,`deleted_at`) values 
(1,2,'doctor_attachments/1OQzp9KbLvegB98Ff7Jyv8WMpadHFUMAWgkUtylL.jpg','2024-12-18 00:51:54','2024-12-18 00:51:54',NULL),
(2,2,'doctor_attachments/yov69mCBoXmnNisve03BxcSH92p1LbX35YBxWkcL.jpg','2024-12-18 00:51:54','2024-12-18 00:51:54',NULL),
(3,2,'doctor_attachments/WUmRC8hgCannmXy2TiPiBOK2l9d8cGbTJbT2BRsQ.jpg','2024-12-18 00:51:54','2024-12-18 00:51:54',NULL);

/*Table structure for table `educations` */

DROP TABLE IF EXISTS `educations`;

CREATE TABLE `educations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doctor_id` int(11) DEFAULT NULL,
  `university` varchar(255) DEFAULT NULL,
  `field` varchar(255) DEFAULT NULL,
  `certificate_1` varchar(255) DEFAULT NULL,
  `certificate_2` varchar(255) DEFAULT NULL,
  `certificate_3` varchar(255) DEFAULT NULL,
  `university_start_date` varchar(255) NOT NULL DEFAULT 'current_timestamp()',
  `university_end_date` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `educations` */

insert  into `educations`(`id`,`doctor_id`,`university`,`field`,`certificate_1`,`certificate_2`,`certificate_3`,`university_start_date`,`university_end_date`,`created_at`,`updated_at`,`deleted_at`) values 
(1,2,NULL,NULL,NULL,NULL,NULL,'current_timestamp()',NULL,'2024-12-18 00:44:05','2024-12-18 00:44:05',NULL),
(2,2,'University of Florida College of Medicine','MBBS',NULL,NULL,NULL,'2014-02-05','2024-12-18','2024-12-18 00:51:54','2024-12-18 00:51:54',NULL);

/*Table structure for table `experiences` */

DROP TABLE IF EXISTS `experiences`;

CREATE TABLE `experiences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doctor_id` int(11) DEFAULT NULL,
  `hospital_name` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `start_date` varchar(255) DEFAULT NULL,
  `end_date` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `experiences` */

insert  into `experiences`(`id`,`doctor_id`,`hospital_name`,`position`,`start_date`,`end_date`,`created_at`,`updated_at`,`deleted_at`) values 
(1,2,NULL,NULL,NULL,NULL,'2024-12-18 00:44:05','2024-12-18 00:44:05',NULL),
(2,2,'Kindrad Hospital','Urology Specialist','2014-02-05','2024-12-18','2024-12-18 00:51:54','2024-12-18 00:51:54',NULL);

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2014_10_12_000000_create_users_table',1),
(2,'2014_10_12_100000_create_password_reset_tokens_table',1),
(3,'2019_08_19_000000_create_failed_jobs_table',1),
(4,'2019_12_14_000001_create_personal_access_tokens_table',1);

/*Table structure for table `password_reset_tokens` */

DROP TABLE IF EXISTS `password_reset_tokens`;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_reset_tokens` */

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_access_tokens` */

/*Table structure for table `profiles` */

DROP TABLE IF EXISTS `profiles`;

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `speciality_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `address` longtext DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `age` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `emergency_contact` varchar(255) DEFAULT NULL,
  `about` longtext DEFAULT NULL,
  `fees` varchar(255) DEFAULT NULL,
  `start_date` time DEFAULT NULL,
  `end_date` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `profiles` */

insert  into `profiles`(`id`,`user_id`,`speciality_id`,`image`,`address`,`date_of_birth`,`gender`,`age`,`phone_number`,`emergency_contact`,`about`,`fees`,`start_date`,`end_date`,`created_at`,`updated_at`,`deleted_at`) values 
(1,1,NULL,'patients/y2P3dHnGQ5mD8ATXoWMDccQI4OFE0oe6qQcYtxLY.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2024-12-18 00:41:00','2024-12-18 00:41:00',NULL),
(2,2,1,'profiles/kgLZNFA5syuvWrxbkP5CfQ40y8PD10Gtq5Ya6OED.jpg','Perth, Australia','1992-03-05','male','32','+1 (134) 783-6898','+1 (134) 783-6898','Board-Certified Urologist | Specializing in Men’s Health, Kidney Stones, and Prostate Cancer','700','16:00:00','18:00:00','2024-12-18 00:44:05','2024-12-18 00:51:54',NULL),
(3,3,NULL,'patients/CuOoFpzhEw4ut2hsqtURP6qESa8BSUrpkkE0TCF7.jpg','Inder Pardes, India','1991-12-11','female','33','+1 (928) 719-5186','+1 (928) 719-5186',NULL,NULL,NULL,NULL,'2024-12-18 01:00:28','2024-12-18 01:01:50',NULL);

/*Table structure for table `reviews` */

DROP TABLE IF EXISTS `reviews`;

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doctor_id` int(11) DEFAULT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `rating` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `terms_accept` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `reviews` */

/*Table structure for table `specialities` */

DROP TABLE IF EXISTS `specialities`;

CREATE TABLE `specialities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `specialities` */

insert  into `specialities`(`id`,`name`,`image`,`status`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'Urology','specialities/wQpN2vCWOTQhv1XgCGgCqJ9GgOlEoYNY5TuouBQW.png','1','2024-12-18 00:43:36','2024-12-18 00:43:36',NULL);

/*Table structure for table `subscribes` */

DROP TABLE IF EXISTS `subscribes`;

CREATE TABLE `subscribes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `subscribes` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`first_name`,`last_name`,`email`,`role`,`status`,`password`,`email_verified_at`,`remember_token`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'Supper',NULL,'admin@yopmail.com','admin','1','$2y$12$MVzHplfXjI/zEHiCIv/QE.T7VtS9F/MS8oeNPQahf1PYCCHDeDpr2',NULL,NULL,'2024-12-18 00:41:00','2024-12-18 00:41:00',NULL),
(2,'Adam','Fischer','pevalihuju@mailinator.com','doctor','1','$2y$12$fiEltqClv3tVj42tozutZugSHyzyz0bnTAL4Bi9toojleRby2k1wa',NULL,NULL,'2024-12-18 00:44:05','2024-12-18 01:35:10',NULL),
(3,'Meera','Khan','suta@mailinator.com','patient','1','$2y$12$rq5SNa/SuSnIp0/cCCXwpOeywu9PlHIbAZDKZvdR1HZAFRjjP0LWy',NULL,NULL,'2024-12-18 01:00:28','2024-12-18 01:01:50',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
