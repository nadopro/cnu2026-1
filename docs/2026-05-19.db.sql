-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: cnu
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `fee`
--

DROP TABLE IF EXISTS `fee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fee` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `base_year` year(4) NOT NULL COMMENT '기준연도',
  `province_name` varchar(50) NOT NULL COMMENT '시도명',
  `university_name` varchar(100) NOT NULL COMMENT '대학교명',
  `establishment_type` varchar(20) NOT NULL COMMENT '설립형태구분명',
  `average_tuition` decimal(12,1) NOT NULL COMMENT '평균등록금액',
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fee`
--

LOCK TABLES `fee` WRITE;
/*!40000 ALTER TABLE `fee` DISABLE KEYS */;
/*!40000 ALTER TABLE `fee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `std`
--

DROP TABLE IF EXISTS `std`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `std` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `id` char(9) NOT NULL,
  `birth` date NOT NULL,
  `memo` longtext DEFAULT NULL,
  `time` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`idx`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `std`
--

LOCK TABLES `std` WRITE;
/*!40000 ALTER TABLE `std` DISABLE KEYS */;
INSERT INTO `std` VALUES (2,'세종대왕','202112346','2002-07-21','세종대왕, 202112346, 2002-07-21','2026-05-12 12:35:49'),(3,'정약용','202212347','2003-11-09','정약용, 202212347, 2003-11-09','2026-05-12 12:35:49'),(4,'김홍도','202312348','2004-05-18','김홍도, 202312348, 2004-05-18','2026-05-12 12:35:49'),(5,'신사임당','202412349','2005-09-27','신사임당, 202412349, 2005-09-27','2026-05-12 12:35:49'),(6,'율곡 이이','202512350','2006-01-12','율곡 이이, 202512350, 2006-01-12','2026-05-12 12:35:49'),(7,'퇴계 이황','202612351','2007-04-03','퇴계 이황, 202612351, 2007-04-03','2026-05-12 12:35:49'),(8,'허준','202013452','2008-08-14','허준, 202013452, 2008-08-14','2026-05-12 12:35:49'),(9,'장영실','202114563','2009-12-25','장영실, 202114563, 2009-12-25','2026-05-12 12:35:49'),(10,'황희','202215674','2010-02-07','황희, 202215674, 2010-02-07','2026-05-12 12:35:49'),(11,'맹사성','202316785','2011-06-30','맹사성, 202316785, 2011-06-30','2026-05-12 12:35:49'),(12,'정몽주','202417896','2012-10-11','정몽주, 202417896, 2012-10-11','2026-05-12 12:35:49'),(13,'조광조','202518907','2013-03-22','조광조, 202518907, 2013-03-22','2026-05-12 12:35:49'),(14,'권율','202619018','2014-07-05','권율, 202619018, 2014-07-05','2026-05-12 12:35:49'),(15,'곽재우','202020129','2015-11-16','곽재우, 202020129, 2015-11-16','2026-05-12 12:35:49'),(16,'유성룡','202121230','2016-01-29','유성룡, 202121230, 2016-01-29','2026-05-12 12:35:49'),(17,'송시열','202222341','2017-04-19','송시열, 202222341, 2017-04-19','2026-05-12 12:35:49'),(18,'김만중','202323452','2018-08-08','김만중, 202323452, 2018-08-08','2026-05-12 12:35:49'),(19,'허균','202424563','2019-12-01','허균, 202424563, 2019-12-01','2026-05-12 12:35:49'),(20,'황진이','202525674','2020-05-13','황진이, 202525674, 2020-05-13','2026-05-12 12:35:49'),(21,'논개','202626785','2021-09-24','논개, 202626785, 2021-09-24','2026-05-12 12:35:49'),(22,'김시습','202027896','2022-02-15','김시습, 202027896, 2022-02-15','2026-05-12 12:35:49'),(23,'서경덕','202128907','2023-06-06','서경덕, 202128907, 2023-06-06','2026-05-12 12:35:49'),(24,'남효온','202229018','2024-10-17','남효온, 202229018, 2024-10-17','2026-05-12 12:35:49'),(25,'성삼문','202330129','2025-01-28','성삼문, 202330129, 2025-01-28','2026-05-12 12:35:49'),(26,'박팽년','202431230','2000-04-09','박팽년, 202431230, 2000-04-09','2026-05-12 12:35:49'),(27,'하위지','202532341','2001-08-20','하위지, 202532341, 2001-08-20','2026-05-12 12:35:49'),(28,'이개','202633452','2002-12-31','이개, 202633452, 2002-12-31','2026-05-12 12:35:49'),(29,'유응부','202034563','2003-03-04','유응부, 202034563, 2003-03-04','2026-05-12 12:35:49'),(30,'유성원','202135674','2004-07-15','유성원, 202135674, 2004-07-15','2026-05-12 12:35:49');
/*!40000 ALTER TABLE `std` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(20) DEFAULT NULL,
  `id` char(10) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `birth` date DEFAULT NULL,
  `memo` text DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  PRIMARY KEY (`idx`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES (1,'홍길동','kdhong',12,'2000-01-01','메모1','2026-05-12 12:20:45'),(2,'홍대감','202512345',52,'1952-05-12','메모2','2026-05-12 12:23:53'),(3,'이순신','202612345',34,'1986-05-12','메모3','2026-05-12 12:23:53');
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `idx` int(11) NOT NULL AUTO_INCREMENT,
  `id` char(30) DEFAULT NULL,
  `pass` char(50) DEFAULT NULL,
  `name` char(30) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  PRIMARY KEY (`idx`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'sino','1111','한문',1),(2,'math','1111','수학',1),(3,'trade','1111','무역',1),(4,'admin','1111','관리짱',9);
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

-- Dump completed on 2026-05-19 13:15:09
