-- MySQL dump 10.13  Distrib 5.5.24, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: hebtrain
-- ------------------------------------------------------
-- Server version	5.5.24-0ubuntu0.12.04.1

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
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group` tinyint(4) NOT NULL,
  `hebrew` varchar(63) COLLATE utf8_bin NOT NULL,
  `hebrew_bare` varchar(63) COLLATE utf8_bin NOT NULL,
  `hebrew_comment` varchar(255) COLLATE utf8_bin NOT NULL,
  `russian` varchar(63) COLLATE utf8_bin NOT NULL,
  `russian_comment` varchar(255) COLLATE utf8_bin NOT NULL,
  `next_test` datetime NOT NULL,
  `root` varchar(10) COLLATE utf8_bin NOT NULL,
  `gender` tinyint(4) NOT NULL,
  `feminine` varchar(63) COLLATE utf8_bin NOT NULL,
  `plural` varchar(63) COLLATE utf8_bin NOT NULL,
  `smihut` varchar(63) COLLATE utf8_bin NOT NULL,
  `abbrev` varchar(63) COLLATE utf8_bin NOT NULL,
  `hard` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group` (`group`),
  KEY `hebrew_bare` (`hebrew_bare`),
  KEY `russian` (`russian`),
  KEY `next_test` (`next_test`),
  KEY `root` (`root`)
) ENGINE=MyISAM AUTO_INCREMENT=618 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions` (
  `item_id` int(11) NOT NULL,
  `question` tinyint(4) NOT NULL,
  `stage` tinyint(4) NOT NULL,
  `step` tinyint(4) NOT NULL,
  `priority` tinyint(4) NOT NULL,
  `next_test` datetime NOT NULL,
  `active` tinyint(4) NOT NULL,
  PRIMARY KEY (`item_id`,`question`),
  KEY `next_test` (`next_test`),
  KEY `active` (`active`),
  KEY `priority` (`priority`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `versions`
--

DROP TABLE IF EXISTS `versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `versions` (
  `version` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-06-18 14:44:02
