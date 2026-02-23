-- MySQL dump 10.13  Distrib 5.6.32-78.0, for Linux (x86_64)
--
-- Host: 185.129.138.56    Database: b26544
-- ------------------------------------------------------
-- Server version	8.0.34-26

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES binary */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `msg_id` int NOT NULL AUTO_INCREMENT,
  `incoming_msg_id` int NOT NULL,
  `outgoing_msg_id` int NOT NULL,
  `msg` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL,
  `image_name` varchar(400) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`msg_id`),
  KEY `incoming_msg_id` (`incoming_msg_id`),
  KEY `outgoing_msg_id` (`outgoing_msg_id`),
  CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`incoming_msg_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`outgoing_msg_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `post_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `content` text NOT NULL,
  `post_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `destination` varchar(100) COLLATE utf8mb3_hungarian_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb3_hungarian_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb3_hungarian_ci,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `days` int NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `travelusers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_hungarian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservations`
--

LOCK TABLES `reservations` WRITE;
/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
INSERT INTO `reservations` (`id`, `user_id`, `destination`, `image`, `notes`, `start_date`, `end_date`, `days`, `time_stamp`) VALUES (14,2,'Szilveszter Srí Lankán, tengerparti pihenéssel ','lanka01.jpg','https://1000ut.hu/azsia/sri-lanka/colombo/szilveszter-sri-lankan-tengerparti-pihenessel-/c-4247','2024-12-25','2025-01-04',11,'2025-03-22 20:32:21'),(15,2,'Csillagtúra Izlandon Helsinkivel fűszerezve','izland.jpg','https://1000ut.hu/europa/izland/reykjavik/csillagtura-izlandon-helsinkivel-fuszerezve/c-4730','2025-07-04','2025-07-10',7,'2025-03-22 20:26:12'),(16,2,'Nordkapp: Észak-Norvégia az éjféli nap fényében','lofoten.jpeg','https://1000ut.hu/europa/norvegia/bodo/nordkapp:-eszak-norvegia-az-ejfeli-nap-fenyeben/c-11144','2025-07-29','2025-08-05',8,'2025-03-23 09:20:14'),(17,2,'A Balti-tenger kincsei','balti.jpg','https://1000ut.hu/europa/magyarorszag/budapest/a-balti-tenger-kincsei/c-3560','2025-08-19','2025-08-24',6,'2025-03-22 20:25:53'),(18,1,'Írország mesés szigete repülővel','ir02.jpg','https://groszutazas.hu/irorszag-meses-szigete-repulovel','2025-04-19','2025-04-23',5,'2025-03-22 20:26:50'),(19,2,'Vietnám - Kambodzsa - Laosz','viet.jpg','https://1000ut.hu/azsia/vietnam/hanoi/laosz-vietnam-kambodzsa-korutazas-/c-10424','2025-11-04','2025-11-21',18,'2025-03-22 20:32:38'),(20,1,'Karnevál Velencében és Ptujban','venezia.jpg','https://groszutazas.hu/karneval-velenceben-es-ptujban','2025-02-28','2025-03-02',3,'2025-03-22 20:27:28'),(21,1,'Morvaország felfedezése','brno.jpg','https://groszutazas.hu/morvaorszag-felfedezese?fbclid=IwY2xjawIZeAtleHRuA2FlbQIxMAABHbI8xDhj8NmU7rPEi67V-0ZpEw6ymkMi2n_wpJDITVn4St-fP3FcvMk-AA_aem_4TRjS2Vj3YcxEbng69fUTA','2025-06-12','2025-06-17',6,'2025-03-22 20:29:16'),(22,1,'Nápolyi kalandok','napoly.jpg','https://groszutazas.hu/napolyi-kalandok','2025-06-06','2025-06-10',5,'2025-05-04 17:34:50'),(23,2,'Karácsony és Szilveszter Sri Lankán','lanka02.jpg','https://1000ut.hu/azsia/sri-lanka/colombo/karacsony-sri-lankan-es-maldiv-szigetek/c-12962','2025-12-21','2026-01-03',15,'2025-07-14 17:19:51'),(24,2,'Sri Lanka ','lanka03.jpg','https://1000ut.hu/azsia/sri-lanka/colombo/nagykorut-sri-lankan-/c-10463','2025-09-24','2025-10-06',13,'2025-10-07 13:36:48'),(26,1,'Napsütötte Toszkána','toscany.jpg','https://groszutazas.hu/toscana-olaszorszag-ekkove-ferrari-muzeum-maranelloban-2','2025-06-24','2025-06-29',6,'2025-03-22 20:30:46'),(27,1,'Punat- Krk sziget','punat.jpg','https://groszutazas.hu/pihenes-punatban-krk-szigeten','2025-07-20','2025-07-25',6,'2025-03-22 20:31:35'),(28,1,'Krakkó - Wielicka','krakko.jpg','','2025-08-26','2025-08-29',4,'2025-03-22 20:28:54'),(29,1,'Portorozs Szlovénia','piran.jpg','https://groszutazas.hu/rovid-nyaralas-portorozban ','2025-09-01','2025-09-04',4,'2025-03-22 20:31:24'),(31,1,'Írország mesés szigete repülővel','ir01.jpg','Írország tervezet','2025-08-12','2025-08-16',5,'2025-03-22 20:26:34'),(32,1,'New York tanulmány út','ny.jpg','https://groszutazas.hu/new-york','2025-05-22','2025-05-27',6,'2025-03-22 20:30:58'),(33,1,'Barcelona',NULL,'https://groszutazas.hu/barcelona','2025-05-17','2025-05-19',3,'2025-04-30 19:47:35'),(34,1,'Advent New Yorkban',NULL,'https://groszutazas.hu/advent-new-yorkban','2025-12-04','2025-12-10',7,'2025-05-04 17:29:53'),(35,2,'Sri Lanka',NULL,'https://1000ut.hu/azsia/sri-lanka/colombo/sri-lanka-korut-pihenessel-a-maldiv-szigeteken-/c-10472','2026-02-05','2026-02-15',11,'2025-05-09 06:03:41'),(36,2,'Sri Lanka',NULL,'https://1000ut.hu/azsia/sri-lanka/colombo/sri-lanka-korut-pihenessel-a-maldiv-szigeteken-/c-10472','2026-03-12','2026-03-22',11,'2025-05-09 06:04:22'),(37,1,'Horvát rövid pihenés Krk sziget',NULL,'https://groszutazas.hu/horvat-rovid-pihenes-krk-sziget','2025-09-06','2025-09-10',5,'2025-06-18 17:21:50'),(38,1,'Dél-Albánia és Korfu repülővel',NULL,'https://groszutazas.hu/del-albania-es-korfu-repulovel','2025-09-15','2025-09-22',8,'2025-06-18 17:23:39'),(39,2,'Csillagtúra Izlandon',NULL,'','2026-07-03','2026-07-09',7,'2025-08-07 09:45:21'),(41,2,'Lappföld',NULL,'https://1000ut.hu/europa/finnorszag/kittila/teli-kalandok-lappfoldon/c-8249','2026-12-12','2026-12-18',7,'2025-09-05 18:31:43'),(42,1,'Idegenvezetői továbbképzés Grosz Utazás',NULL,'Idegenvezetői továbbképzés Grosz Utazás','2026-01-10','2026-01-10',1,'2025-08-08 06:52:45'),(43,1,'Advent Krakkóban és Zakopánéban',NULL,'https://groszutazas.hu/advent-krakkoban-es-zakopaneban','2025-11-29','2025-11-30',2,'2025-08-08 06:55:17'),(44,2,'Balti Impressziók',NULL,'https://1000ut.hu/europa/baltikum/lettorszag/riga/baltikumi-impressziok-/c-3893','2026-04-02','2026-04-06',5,'2025-08-08 08:34:34'),(45,2,'Balti tenger kincsei',NULL,'https://1000ut.hu/europa/litvania/a-balti-tenger-kincsei/c-3560','2026-05-20','2026-05-25',6,'2025-08-08 08:35:26'),(47,2,'Norvég fjordok',NULL,'https://1000ut.hu/europa/norvegia/oslo/norveg-fjordok-tajak-es-trollok/c-11150','2026-08-04','2026-08-11',8,'2025-09-05 18:30:41'),(48,1,'Gasztro kalandok Toszkánában',NULL,'https://groszutazas.hu/gasztro-kalandok-toszkanaban-es-bolognaban-puenkosdi-hetvege','2025-10-23','2025-10-27',5,'2025-09-26 16:19:09');
/*!40000 ALTER TABLE `reservations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `travelusers`
--

DROP TABLE IF EXISTS `travelusers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `travelusers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) COLLATE utf8mb3_hungarian_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb3_hungarian_ci NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_hungarian_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `travelusers`
--

LOCK TABLES `travelusers` WRITE;
/*!40000 ALTER TABLE `travelusers` DISABLE KEYS */;
INSERT INTO `travelusers` (`id`, `user_name`, `password`, `time_stamp`) VALUES (1,'GroszUtazas','Palma2025','2025-01-21 16:58:18'),(2,'1000ut','Jaroszlav2025','2025-01-21 16:58:18'),(3,'Tensi','Vivien2025','2025-01-21 16:58:59');
/*!40000 ALTER TABLE `travelusers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `fname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `department` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `occupation` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `img` varchar(400) COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mobil` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1661759700 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
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

-- Dump completed on 2025-10-08  1:42:38
