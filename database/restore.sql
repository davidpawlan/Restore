-- MySQL dump 10.13  Distrib 5.7.21, for Linux (x86_64)
--
-- Host: localhost    Database: restore
-- ------------------------------------------------------
-- Server version	5.7.21

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `behaviors`
--

DROP TABLE IF EXISTS `behaviors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `behaviors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `behaviors`
--

LOCK TABLES `behaviors` WRITE;
/*!40000 ALTER TABLE `behaviors` DISABLE KEYS */;
INSERT INTO `behaviors` VALUES (1,'Insubordination','IN','2019-07-22 07:20:43',NULL),(2,'Inappropriate Language','IL','2019-07-22 07:20:43',NULL),(3,'Inappropriate Contact','IC','2019-07-22 07:20:43',NULL),(4,'Fighting','FI','2019-07-22 07:20:43',NULL),(5,'Classroom Disruption','CD','2019-07-22 07:20:43',NULL),(6,'Property Infraction','PI','2019-07-22 07:20:43',NULL),(7,'Bullying','BU','2019-07-22 07:20:43',NULL),(8,'Inappropriate Attitude','IA','2019-07-22 07:20:43',NULL),(9,'Tardy/Truant','TT','2019-07-22 07:20:43',NULL),(10,'Other','OT','2019-07-22 07:20:43',NULL);
/*!40000 ALTER TABLE `behaviors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grade_rosters`
--

DROP TABLE IF EXISTS `grade_rosters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grade_rosters` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'Id of users table',
  `grade_id` int(11) NOT NULL COMMENT 'Id of grades table',
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grade_rosters`
--

LOCK TABLES `grade_rosters` WRITE;
/*!40000 ALTER TABLE `grade_rosters` DISABLE KEYS */;
INSERT INTO `grade_rosters` VALUES (3,2,3,'2019_07_22 13_05_321.csv','1','2019-07-22 07:35:32',NULL),(4,2,4,'2019_07_22 13_05_432.csv','1','2019-07-22 07:35:43',NULL);
/*!40000 ALTER TABLE `grade_rosters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grades`
--

DROP TABLE IF EXISTS `grades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grades` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grades`
--

LOCK TABLES `grades` WRITE;
/*!40000 ALTER TABLE `grades` DISABLE KEYS */;
INSERT INTO `grades` VALUES (1,'Kindergarten','2019-07-22 07:20:43',NULL),(2,'1st grade','2019-07-22 07:20:44',NULL),(3,'2nd grade','2019-07-22 07:20:44',NULL),(4,'3rd grade','2019-07-22 07:20:44',NULL),(5,'4th grade','2019-07-22 07:20:44',NULL),(6,'5th grade','2019-07-22 07:20:44',NULL),(7,'6th grade','2019-07-22 07:20:44',NULL),(8,'7th grade','2019-07-22 07:20:44',NULL),(9,'8th grade','2019-07-22 07:20:44',NULL);
/*!40000 ALTER TABLE `grades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `interventions`
--

DROP TABLE IF EXISTS `interventions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `interventions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interventions`
--

LOCK TABLES `interventions` WRITE;
/*!40000 ALTER TABLE `interventions` DISABLE KEYS */;
INSERT INTO `interventions` VALUES (1,'Restorative Practice Only','RPO','2019-07-22 07:20:44',NULL),(2,'Lunch Detention','LD','2019-07-22 07:20:44',NULL),(3,'After School Detention','ASD','2019-07-22 07:20:44',NULL),(4,'Internal Suspension','IS','2019-07-22 07:20:44',NULL),(5,'External Suspension','ES','2019-07-22 07:20:44',NULL),(6,'Other','OT','2019-07-22 07:20:44',NULL);
/*!40000 ALTER TABLE `interventions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (1,'Classroom','CL','2019-07-22 07:20:44',NULL),(2,'Playground','PL','2019-07-22 07:20:44',NULL),(3,'Cafeteria','CA','2019-07-22 07:20:44',NULL),(4,'Gym','GY','2019-07-22 07:20:45',NULL),(5,'Hallway','HA','2019-07-22 07:20:45',NULL),(6,'Common Area','COA','2019-07-22 07:20:45',NULL),(7,'Bathroom','BA','2019-07-22 07:20:45',NULL),(8,'Library','LI','2019-07-22 07:20:45',NULL),(9,'Bus','BU','2019-07-22 07:20:45',NULL),(10,'Other','OT','2019-07-22 07:20:45',NULL);
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_07_04_11320_create_schools_table',1),(4,'2019_07_04_113241_create_grades_table',1),(5,'2019_07_04_113242_create_students_table',1),(6,'2019_07_04_113307_create_grade_rosters_table',1),(7,'2019_07_04_113516_create_behaviors_table',1),(8,'2019_07_04_113530_create_locations_table',1),(9,'2019_07_04_113600_create_interventions_table',1),(10,'2019_07_11_113321_create_reports_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'Id of users table',
  `student_id` int(11) NOT NULL COMMENT 'Id of students table',
  `grade_id` int(11) DEFAULT NULL,
  `gender` enum('M','F') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'M=>Male, F=>Female',
  `behaviour_id` int(11) NOT NULL COMMENT 'Id of behaviour table',
  `location_id` int(11) NOT NULL COMMENT 'Id of locations table',
  `intervention_id` int(11) NOT NULL COMMENT 'Id of interventions table',
  `date` date NOT NULL,
  `time` time NOT NULL,
  `self_awareness` int(11) NOT NULL COMMENT '0=>Poor, 1->Avg 2=>optimal',
  `self_management` int(11) NOT NULL COMMENT '0=>Poor, 1->Avg 2=>optimal',
  `responsible_decision_making` int(11) NOT NULL COMMENT '0=>Poor, 1->Avg 2=>optimal',
  `relationship_skills` int(11) NOT NULL COMMENT '0=>Poor, 1->Avg 2=>optimal',
  `social_awareness` int(11) NOT NULL COMMENT '0=>Poor, 1->Avg 2=>optimal',
  `other_notes` longtext COLLATE utf8mb4_unicode_ci COMMENT '0=>Poor, 1->Avg 2=>optimal',
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=>ACtive, 0=>Archieve',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
INSERT INTO `reports` VALUES (3,2,9,3,'M',1,1,4,'2019-07-22','12:35:00',2,3,2,3,2,NULL,'1','2019-07-22 07:36:05','2019-07-22 07:36:05');
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schools`
--

DROP TABLE IF EXISTS `schools`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schools` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'User''s Table Id',
  `principle_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Princile name for school',
  `plain_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Plain password etxt to show in admin',
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schools`
--

LOCK TABLES `schools` WRITE;
/*!40000 ALTER TABLE `schools` DISABLE KEYS */;
INSERT INTO `schools` VALUES (1,2,'New Principle','12345678','');
/*!40000 ALTER TABLE `schools` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'Id of users table',
  `grade_id` int(11) NOT NULL COMMENT 'Id of grades table',
  `grade_roster_id` int(11) NOT NULL COMMENT 'Id of grade_roster table',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roll_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('M','F') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'M=>Male, F=>Female',
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '0=>Archieve, 1=>Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (8,2,3,3,'Shubham Sharma','21312','M','1','2019-07-22 07:35:32',NULL),(9,2,3,3,'Aarav Sharma','234234','M','1','2019-07-22 07:35:32',NULL),(10,2,3,3,'Dummy Student','23423423','F','1','2019-07-22 07:35:32',NULL),(11,2,4,4,'Raghav','2111111','M','1','2019-07-22 07:35:43',NULL),(12,2,4,4,'arun','2111112','M','1','2019-07-22 07:35:43',NULL),(13,2,4,4,'Varun','2111113','M','1','2019-07-22 07:35:43',NULL),(14,2,4,4,'Akta','2111114','F','1','2019-07-22 07:35:43',NULL);
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('A','S') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'A=>Admin, S=>School',
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=>Active, 0=>Deactivate',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin@gmail.com','$2y$10$mYETbcdoaVg036uYD3rIouEJ9aoBSl84clF.iC7hKkUQBywJRiyyq','A','1',NULL,NULL),(2,'New Scholl','new_school@yopmail.com','$2y$10$N9l0rH.WvOdXJ3Rk4rXQs.G4v.BgkcSyGW839uwQCLvLG70eL63Nu','S','1','2019-07-22 07:22:37',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-07-22 18:39:54
