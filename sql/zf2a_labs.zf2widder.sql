-- MySQL dump 10.13  Distrib 5.5.31, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: zf2widder
-- ------------------------------------------------------
-- Server version	5.5.31-0ubuntu0.12.10.1

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
-- Table structure for table `guestbook_entry`
--

DROP TABLE IF EXISTS `guestbook_entry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `guestbook_entry` (
  `entry_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_name` varchar(255) NOT NULL,
  `entry_email` varchar(255) NOT NULL,
  `entry_website` varchar(255) NOT NULL,
  `entry_message` text NOT NULL,
  PRIMARY KEY (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guestbook_entry`
--

LOCK TABLES `guestbook_entry` WRITE;
/*!40000 ALTER TABLE `guestbook_entry` DISABLE KEYS */;
INSERT INTO `guestbook_entry` VALUES (1,'Clark','clark@zend.com','http://www.clark.com/','Test');
/*!40000 ALTER TABLE `guestbook_entry` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_email` char(128) NOT NULL COMMENT 'sender',
  `recipient_email` char(128) DEFAULT NULL COMMENT 'if present message = "hoot" otherwise = "holler',
  `message` varchar(128) NOT NULL COMMENT 'contents',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (7,'doug@unlikelysource.com',NULL,'Test message from Doug','2012-06-29 12:36:25'),(8,'clark.e@zend.com','doug@unlikelysource.com','This is a test from Clark to Doug','2012-07-03 12:01:17'),(9,'doug@unlikelysource.com','clark.e@zend.com','Cloud test','2012-07-04 13:19:23'),(10,'admin@zend.com',NULL,'Looks like it\'s working ... still some problems with view partials!','2012-07-04 13:41:27'),(11,'doug@unlikelysource.com',NULL,'Modified the app for ZF2 Beta 5','2012-07-11 14:00:57'),(12,'doug@unlikelysource.com','clark.e@zend.com','How goes the war?','2012-07-11 14:01:17'),(13,'clark.e@zend.com',NULL,'Looks good','2012-07-11 14:02:18'),(14,'clark.e@zend.com','doug@unlikelysource.com','Won the battle but lost the war :-O','2012-07-11 14:02:39'),(15,'admin@zend.com',NULL,'Container Test 2012-07-24','2012-07-24 12:01:58'),(16,'guest@zend.com','doug@unlikelysource.com','2012-08-04','2012-08-04 11:38:34'),(17,'guest@zend.com','doug@unlikelysource.com','2012-08-04','2012-08-04 11:39:27'),(18,'guest@zend.com','doug@unlikelysource.com','Monday 6 Aug Test 1','2012-08-06 11:43:26'),(19,'guest@zend.com','doug@unlikelysource.com','Monday 6 Aug Test 1','2012-08-06 11:46:30'),(20,'guest@zend.com',NULL,'Test 1-2-3','2012-08-06 21:32:27'),(21,'doug@unlikelysource.com','clark.e@zend.com','Test Hoot','2012-08-09 11:28:20'),(22,'admin@zend.com',NULL,'Admin Post','2012-08-11 09:11:02'),(23,'doug@unlikelysource.com',NULL,'Testing w/ ZF 2.1.5','2013-05-07 12:53:18'),(24,'doug@unlikelysource.com','clark.e@zend.com','Test 2013-06-05','2013-06-05 11:43:15');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages-test`
--

DROP TABLE IF EXISTS `messages-test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages-test` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_email` char(128) NOT NULL COMMENT 'sender',
  `recipient_email` char(128) DEFAULT NULL COMMENT 'if present message = "hoot" otherwise = "holler',
  `message` varchar(128) NOT NULL COMMENT 'contents',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages-test`
--

LOCK TABLES `messages-test` WRITE;
/*!40000 ALTER TABLE `messages-test` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages-test` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `email` char(128) NOT NULL COMMENT 'email address',
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '0 = unconfirmed, 1 = normal, 2 = admin',
  `real_name` varchar(128) DEFAULT NULL,
  `password` char(32) DEFAULT NULL,
  `preferences` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='zf2widder users';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('doug@unlikelysource.com',1,'Doug','5f4dcc3b5aa765d61d8327deb882cf99','Paris'),('clark.e@zend.com',1,'Clark','5f4dcc3b5aa765d61d8327deb882cf99','Blue Ridge Mountains'),('admin@zend.com',2,'admin','5f4dcc3b5aa765d61d8327deb882cf99','a5fd98ce6e591c6621b57bdf443cd2d0'),('guest',0,'guest',NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users-test`
--

DROP TABLE IF EXISTS `users-test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users-test` (
  `email` char(128) NOT NULL COMMENT 'email address',
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '0 = unconfirmed, 1 = normal, 2 = admin',
  `real_name` varchar(128) DEFAULT NULL,
  `password` char(32) DEFAULT NULL,
  `preferences` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='zf2widder users';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users-test`
--

LOCK TABLES `users-test` WRITE;
/*!40000 ALTER TABLE `users-test` DISABLE KEYS */;
/*!40000 ALTER TABLE `users-test` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'zf2widder'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-06-05 14:50:48
