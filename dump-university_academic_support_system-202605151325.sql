-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: university_academic_support_system
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `answer`
--

DROP TABLE IF EXISTS `answer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `answer` (
  `answer_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`answer_id`),
  KEY `question_id` (`question_id`),
  KEY `instructor_id` (`instructor_id`),
  CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `answer_ibfk_2` FOREIGN KEY (`instructor_id`) REFERENCES `instructor` (`instructor_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answer`
--

LOCK TABLES `answer` WRITE;
/*!40000 ALTER TABLE `answer` DISABLE KEYS */;
INSERT INTO `answer` VALUES (1,1,3,'A for loop is useful when the number of iterations is known, while while is better when the condition controls repetition.','2026-04-12 13:00:00'),(3,3,3,'Routing is mainly at the network layer, and reliable transport is handled by the transport layer.','2026-04-13 11:00:00'),(5,5,4,'Common instruments include elevators and extraction forceps depending on the tooth and case.','2026-04-14 10:00:00'),(9,7,2,'Database normalization is the process of organizing data in a relational database to reduce redundancy and improve data integrity.\r\n\r\nIt is important because it:\r\n\r\nEliminates duplicate data\r\nPrevents update, insert, and delete anomalies\r\nImproves data consistency\r\nMakes the database more efficient and easier to maintain\r\n\r\nNormalization is typically done in stages called normal forms (1NF, 2NF, 3NF, etc.).','2026-05-08 22:17:18'),(10,6,2,'Gaussian filtering reduces noise by smoothing the image using average pixel values, but it may blur edges.\r\n\r\nMedian filtering removes noise by replacing each pixel with the median value of neighboring pixels, which preserves edges better than Gaussian filtering.','2026-05-08 22:21:07'),(11,5,7,'Forceps and elevators are commonly used for simple extraction.\r\n','2026-05-12 00:35:47'),(12,9,8,'11\r\n','2026-05-12 00:37:09'),(13,5,7,'Forceps and elevators are commonly used for simple extraction.\r\n','2026-05-12 00:39:03'),(14,5,7,'Forceps and elevators are commonly used for simple extraction.\r\n','2026-05-12 00:39:37'),(15,5,7,'Forceps and elevators are commonly used for simple extraction.\r\n','2026-05-12 00:42:26'),(16,10,7,'Forceps and elevators are commonly used for simple extraction.','2026-05-12 00:48:47'),(17,8,2,'11','2026-05-12 08:24:19');
/*!40000 ALTER TABLE `answer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course` (
  `course_id` int(11) NOT NULL AUTO_INCREMENT,
  `credit_hours` int(11) NOT NULL CHECK (`credit_hours` > 0),
  `course_name` varchar(100) NOT NULL,
  `dep_id` int(11) DEFAULT NULL,
  `instructor_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`course_id`),
  KEY `dep_id` (`dep_id`),
  KEY `instructor_id` (`instructor_id`),
  CONSTRAINT `course_ibfk_1` FOREIGN KEY (`dep_id`) REFERENCES `department` (`dep_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `course_ibfk_2` FOREIGN KEY (`instructor_id`) REFERENCES `instructor` (`instructor_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course`
--

LOCK TABLES `course` WRITE;
/*!40000 ALTER TABLE `course` DISABLE KEYS */;
INSERT INTO `course` VALUES (1,3,'Image Processing',NULL,6),(2,4,'Database Systems',2,2),(3,3,'Electronic Circuits Lab',3,3),(4,3,'Discrete Mathematics',3,4),(5,3,'Microprocessors',2,5),(6,3,'Oral Surgery Basics',NULL,7),(7,3,'Human Anatomy',NULL,8),(8,3,'Pharmacology I',5,9);
/*!40000 ALTER TABLE `course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `department` (
  `dep_id` int(11) NOT NULL AUTO_INCREMENT,
  `dep_name` varchar(100) NOT NULL,
  PRIMARY KEY (`dep_id`),
  UNIQUE KEY `dep_name` (`dep_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES (2,'Computer Engineering1'),(3,'Dentistry'),(5,'Pharmacy');
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enrollment`
--

DROP TABLE IF EXISTS `enrollment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `enrollment` (
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  PRIMARY KEY (`student_id`,`course_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `enrollment_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `enrollment_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enrollment`
--

LOCK TABLES `enrollment` WRITE;
/*!40000 ALTER TABLE `enrollment` DISABLE KEYS */;
INSERT INTO `enrollment` VALUES (12323333,1,5,'Excellent'),(12323333,2,5,'Excellent'),(12323333,3,5,'Excellent'),(12323333,4,5,'Excellent'),(12323333,5,5,'Excellent'),(12323906,1,4,'Very good'),(12323906,2,4,'Very good'),(12323906,3,4,'Very good'),(12323906,4,4,'Very good'),(12323906,5,4,'Very good'),(12340133,6,4,'Very useful'),(12340133,7,4,'Very useful'),(12340133,8,4,'Very useful'),(12340269,6,5,'Excellent'),(12340269,7,5,'Excellent'),(12340269,8,5,'Excellent'),(12340845,1,5,'Great'),(12340845,2,5,'Great'),(12340845,3,5,'Great'),(12340845,4,5,'Great'),(12340845,5,5,'Great'),(12441453,6,4,'Good'),(12441453,7,4,'Good'),(12441453,8,4,'Good');
/*!40000 ALTER TABLE `enrollment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exam`
--

DROP TABLE IF EXISTS `exam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exam` (
  `exam_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `exam_date` date DEFAULT NULL,
  `total_marks` int(11) NOT NULL,
  `exam_type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`exam_id`),
  KEY `fk_exam_topic` (`course_id`,`topic_id`),
  CONSTRAINT `fk_exam_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_exam_topic` FOREIGN KEY (`course_id`, `topic_id`) REFERENCES `topic` (`course_id`, `topic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `chk_exam_total_marks` CHECK (`total_marks` > 0)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam`
--

LOCK TABLES `exam` WRITE;
/*!40000 ALTER TABLE `exam` DISABLE KEYS */;
INSERT INTO `exam` VALUES (1,1,NULL,'Image Processing Midterm','2026-05-10',100,'mid'),(2,2,NULL,'Database SQL Quiz','2026-05-12',20,'quiz'),(3,3,NULL,'Electronic Circuits Lab Exam','2026-05-14',50,'lab'),(4,4,NULL,'Discrete Mathematics Midterm','2026-05-16',100,'mid'),(5,5,NULL,'Microprocessors Quiz','2026-05-18',25,'quiz'),(6,6,1,'oral quiz1','2026-04-27',10,'Quiz'),(7,2,1,'final','2026-05-21',50,'Final');
/*!40000 ALTER TABLE `exam` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `favourite`
--

DROP TABLE IF EXISTS `favourite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `favourite` (
  `favorite_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `saved_date` date DEFAULT NULL,
  `support_material_id` int(11) NOT NULL,
  PRIMARY KEY (`favorite_id`),
  UNIQUE KEY `uq_favorite` (`student_id`,`support_material_id`),
  KEY `fk_favorite_support_material` (`support_material_id`),
  CONSTRAINT `fk_favorite_student` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_favorite_support_material` FOREIGN KEY (`support_material_id`) REFERENCES `support_material` (`support_material_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favourite`
--

LOCK TABLES `favourite` WRITE;
/*!40000 ALTER TABLE `favourite` DISABLE KEYS */;
INSERT INTO `favourite` VALUES (23,12323906,'2026-05-08',15);
/*!40000 ALTER TABLE `favourite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instructor`
--

DROP TABLE IF EXISTS `instructor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `instructor` (
  `instructor_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `login_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`instructor_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `phone_number` (`phone_number`),
  UNIQUE KEY `login_id` (`login_id`),
  CONSTRAINT `fk_instructor_login` FOREIGN KEY (`login_id`) REFERENCES `login` (`login_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instructor`
--

LOCK TABLES `instructor` WRITE;
/*!40000 ALTER TABLE `instructor` DISABLE KEYS */;
INSERT INTO `instructor` VALUES (2,'Firas Shakaa','firas.shakaa@univ.edu','1982-07-14','Nablus','0561000002',8),(3,'Falah Hasan','falah.hasan@univ.edu','1980-11-22','Tulkarm','0561000003',9),(4,'Muhannad Aljabi','muhannad.aljabi@univ.edu','1979-01-05','Ramallah','0561000004',10),(5,'Manar Qamhieh','manar.qamhiehh@univ.edu','1988-09-18','Hebron','0561000005',11),(6,'Bashar Tahaina','bashar.tahaina@univ.edu','1985-05-10','Nablus','0561000006',12),(7,'Ahmad Salem','ahmad.salem@univ.edu','1975-08-20','Nablus','0561000013',13),(8,'Lina Khalil','lina.khalil@univ.edu','1982-03-15','Ramallah','0561000014',14),(9,'Samer Odeh','samer.odeh@univ.edu','1978-11-10','Jenin','0561000015',15);
/*!40000 ALTER TABLE `instructor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `login` (
  `login_id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` varchar(20) NOT NULL,
  PRIMARY KEY (`login_id`),
  UNIQUE KEY `phone` (`phone`),
  CONSTRAINT `chk_login_role` CHECK (`role` in ('student','instructor','admin'))
) ENGINE=InnoDB AUTO_INCREMENT=12340134 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login`
--

LOCK TABLES `login` WRITE;
/*!40000 ALTER TABLE `login` DISABLE KEYS */;
INSERT INTO `login` VALUES (1,'yomna@144','0590000001','student'),(2,'pass2','0590000002','student'),(3,'pass3','0590000003','student'),(4,'Mayar@123','0590000004','student'),(5,'pass5','0590000005','student'),(6,'pass6','0590000006','student'),(7,'pass7','0590000007','instructor'),(8,'pass8','0590000008','instructor'),(9,'pass9','0590000009','instructor'),(10,'pass10','0590000010','instructor'),(11,'pass11','0590000011','instructor'),(12,'122','0561000006','instructor'),(13,'1233','0561000013','instructor'),(14,'124','0561000014','instructor'),(15,'aaaa@111','0561000015','instructor'),(20,'admin123','0599999999','admin'),(12323333,'disabled_account',NULL,'student'),(12323906,'disabled_account',NULL,'student'),(12340133,'disabled_account','0594444444','student');
/*!40000 ALTER TABLE `login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marks`
--

DROP TABLE IF EXISTS `marks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `marks` (
  `student_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `score` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marks`
--

LOCK TABLES `marks` WRITE;
/*!40000 ALTER TABLE `marks` DISABLE KEYS */;
INSERT INTO `marks` VALUES (12323333,1,95.00),(12323906,2,88.00),(12323333,1,95.00),(12323906,2,88.00),(12340133,6,91.00),(12340133,7,91.00);
/*!40000 ALTER TABLE `marks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `material`
--

DROP TABLE IF EXISTS `material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `material` (
  `material_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `upload_date` date DEFAULT NULL,
  `file_link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`material_id`),
  KEY `fk_material_topic` (`course_id`,`topic_id`),
  CONSTRAINT `fk_material_topic` FOREIGN KEY (`course_id`, `topic_id`) REFERENCES `topic` (`course_id`, `topic_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `material`
--

LOCK TABLES `material` WRITE;
/*!40000 ALTER TABLE `material` DISABLE KEYS */;
INSERT INTO `material` VALUES (25,'Image Processing Slides','Image enhancement and filtering lectures',1,1,'2026-05-08','files/image_processing.pdf'),(26,'Database Notes','SQL and database systems notes',2,1,'2026-05-08','files/database.pdf'),(27,'Electronic Circuits Lab','Lab manual for electronic circuits',3,1,'2026-05-08','files/circuits.pdf'),(28,'Discrete Mathematics Notes','Chapter 4: Divisibility and Modular Arithmetic',4,1,'2026-05-08','files/discrete_chapter4.pdf'),(29,'Microprocessors PDF','8086 assembly and microprocessors',5,1,'2026-05-08','files/microprocessors.pdf'),(30,'ch3','micro',NULL,NULL,'2026-05-08',NULL);
/*!40000 ALTER TABLE `material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `question` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `status` enum('open','answered','closed') NOT NULL,
  PRIMARY KEY (`question_id`),
  KEY `student_id` (`student_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `question_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `question_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question`
--

LOCK TABLES `question` WRITE;
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
INSERT INTO `question` VALUES (1,12323333,2,'Question about loops','Can you explain the difference between while and for loops?','2026-04-12 11:00:00','open'),(3,12340845,5,'OSI layers','Which layers are responsible for routing and transport?','2026-04-13 09:30:00','answered'),(5,12441453,6,'Extraction instruments','What instruments are commonly used for simple extraction?','2026-04-14 08:45:00','open'),(6,12323333,1,'Image Noise Reduction','What is the difference between Gaussian filtering and Median filtering in image processing?','2026-05-08 18:18:42','open'),(7,12323333,2,'Database Normalization','What is database normalization, and why is it important in relational database design?','2026-05-08 18:44:43','open'),(8,12323333,2,'m','mm','2026-05-11 23:07:59','answered'),(9,12340133,7,'nn','nnn','2026-05-11 23:09:25','open'),(10,12340133,6,'Extraction instruments','What instruments are commonly used for simple extraction?','2026-05-12 00:38:05','answered');
/*!40000 ALTER TABLE `question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student` (
  `student_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `batch_number` int(11) DEFAULT NULL,
  `dep_id` int(11) DEFAULT NULL,
  `login_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`student_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `phone_number` (`phone_number`),
  UNIQUE KEY `login_id` (`login_id`),
  KEY `dep_id` (`dep_id`),
  CONSTRAINT `student_ibfk_1` FOREIGN KEY (`dep_id`) REFERENCES `department` (`dep_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `student_ibfk_2` FOREIGN KEY (`login_id`) REFERENCES `login` (`login_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12441454 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES (12323333,'Yomna','yomna@mail.com','0591111111','2006-03-23','Nablus',2024,2,1),(12323906,'Masa','masa@mail.com','0592222222','2005-08-19','Nablus',2023,2,2),(12340133,'Mayar','mayar@mail.com','0594444444','2005-06-11','Ramallah',2022,3,4),(12340269,'Lara','lara@mail.com','0596666666','2005-12-03','Jenin',2022,3,6),(12340845,'Zain','zain@mail.com','0593333333','2005-09-20','Tulkarm',2022,2,3),(12441453,'Sama','sama@mail.com','0595555555','2006-10-09','Qalqilya',2022,3,5);
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `support_material`
--

DROP TABLE IF EXISTS `support_material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `support_material` (
  `support_material_id` int(11) NOT NULL AUTO_INCREMENT,
  `material_id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `upload_date` date DEFAULT NULL,
  `file_link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`support_material_id`),
  KEY `fk_support_material_material` (`material_id`),
  KEY `fk_support_material_topic` (`course_id`,`topic_id`),
  CONSTRAINT `fk_support_material_material` FOREIGN KEY (`material_id`) REFERENCES `material` (`material_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_support_material_topic` FOREIGN KEY (`course_id`, `topic_id`) REFERENCES `topic` (`course_id`, `topic_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `support_material`
--

LOCK TABLES `support_material` WRITE;
/*!40000 ALTER TABLE `support_material` DISABLE KEYS */;
INSERT INTO `support_material` VALUES (13,29,5,1,'Microprocessors Chapter Summary','Quick summary for 8086 registers and instructions',NULL,'files/micro_summary.pdf'),(14,26,2,1,'Database SQL Questions','Practice questions for SELECT, JOIN and GROUP BY',NULL,'files/database_questions.pdf'),(15,28,4,1,'Discrete Mathematics Exercises','Extra problems on modular arithmetic and divisibility',NULL,'files/discrete_exercises.pdf');
/*!40000 ALTER TABLE `support_material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task`
--

DROP TABLE IF EXISTS `task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `task` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  PRIMARY KEY (`task_id`),
  KEY `fk_task_topic` (`course_id`,`topic_id`),
  CONSTRAINT `fk_task_topic` FOREIGN KEY (`course_id`, `topic_id`) REFERENCES `topic` (`course_id`, `topic_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task`
--

LOCK TABLES `task` WRITE;
/*!40000 ALTER TABLE `task` DISABLE KEYS */;
INSERT INTO `task` VALUES (1,1,1,'Image Processing Assignment','Apply edge detection on a grayscale image','2026-04-15'),(2,2,1,'Database SQL Task','Write SQL queries using JOIN and GROUP BY','2026-04-16'),(3,3,1,'Electronic Circuits Lab Report','Analyze the circuit and calculate voltage values','2026-04-17'),(4,4,1,'Discrete Math Problems','Solve logic and graph theory questions','2026-04-18'),(5,5,1,'Microprocessors Assembly Task','Write an 8086 assembly program using loops','2026-04-19'),(6,6,1,'Extraction Case','Prepare a short extraction case discussion','2026-04-20'),(7,7,1,'Upper Limb Labeling','Label bones of the upper limb','2026-04-21'),(8,8,1,'Absorption Report','Write a brief report on drug absorption','2026-04-22');
/*!40000 ALTER TABLE `task` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `topic`
--

DROP TABLE IF EXISTS `topic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `topic` (
  `topic_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `instructor_id` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`course_id`,`topic_id`),
  KEY `fk_topic_instructor` (`instructor_id`),
  CONSTRAINT `fk_topic_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_topic_instructor` FOREIGN KEY (`instructor_id`) REFERENCES `instructor` (`instructor_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topic`
--

LOCK TABLES `topic` WRITE;
/*!40000 ALTER TABLE `topic` DISABLE KEYS */;
INSERT INTO `topic` VALUES (1,1,4,'Image Filtering','Basics of image enhancement','2026-04-01 09:00:00'),(1,2,3,'SQL Fundamentals','Introduction to SQL and databases','2026-04-01 10:00:00'),(1,3,NULL,'Electronic Components','Basics of electronic circuits','2026-04-02 09:00:00'),(1,4,2,'Discrete Logic','Introduction to discrete mathematics','2026-04-02 10:00:00'),(1,5,3,'CPU Architecture','Introduction to microprocessors','2026-04-03 09:00:00'),(1,6,4,'Oral Surgery Introduction','Basic concepts in oral surgery','2026-04-03 10:00:00'),(1,7,5,'Human Anatomy Basics','Introduction to human body anatomy','2026-04-04 09:00:00'),(1,8,5,'Pharmacology Introduction','Basic principles of pharmacology','2026-04-04 10:00:00');
/*!40000 ALTER TABLE `topic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'university_academic_support_system'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-15 13:25:37
