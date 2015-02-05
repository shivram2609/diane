-- MySQL dump 10.13  Distrib 5.5.29, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: 1337IOT
-- ------------------------------------------------------
-- Server version	5.5.29-0ubuntu0.12.04.1

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
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `passwordstatus` tinyint(1) NOT NULL,
  `remembertoken` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'admin@admin.com','9a2ce73bde64af02061df81ec8b6c0cb',1,0,'db6269382b517db72e72bc0e16f1aba4','2013-04-26 00:00:00','2013-07-02 13:24:07'),(2,'shivamsharma@zapbuild.com','9a2ce73bde64af02061df81ec8b6c0cb',1,0,'',NULL,NULL),(3,'vijayetaduggal@zapbuild.com','9a2ce73bde64af02061df81ec8b6c0cb',1,0,'',NULL,NULL);
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backupdbs`
--

DROP TABLE IF EXISTS `backupdbs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backupdbs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backupdbs`
--

LOCK TABLES `backupdbs` WRITE;
/*!40000 ALTER TABLE `backupdbs` DISABLE KEYS */;
INSERT INTO `backupdbs` VALUES (4,'qwerty','0000-00-00 00:00:00'),(6,'<p>dsghdfghdsgf</p>','0000-00-00 00:00:00'),(7,'<p>shdgjdhs</p>','0000-00-00 00:00:00'),(8,'kgkdgfdskfgjdsf','0000-00-00 00:00:00'),(9,'.sql','0000-00-00 00:00:00'),(10,'.sql','0000-00-00 00:00:00'),(11,'.sql','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `backupdbs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `breadcrumbs`
--

DROP TABLE IF EXISTS `breadcrumbs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `breadcrumbs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `controller` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `keyval` varchar(255) DEFAULT NULL,
  `keycontroller` varchar(255) DEFAULT NULL,
  `keyaction` varchar(255) DEFAULT NULL,
  `keylink` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `breadcrumbs`
--

LOCK TABLES `breadcrumbs` WRITE;
/*!40000 ALTER TABLE `breadcrumbs` DISABLE KEYS */;
INSERT INTO `breadcrumbs` VALUES (1,'admins','dashboard','Home','admins','dashboard',0,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(2,'admins','changepassword','Home','admins','dashboard',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(3,'admins','changepassword','Change Password','admins','changepassword',0,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(4,'admins','index','Home','admins','dashboard',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(5,'admins','index','Admins','admins','index',0,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(6,'admins','add','Home','admins','dashboard',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(7,'admins','add','Admins','admins','index',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(8,'admins','add','Add Admin','admins','index',0,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(9,'admins','edit','Home','admins','dashboard',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(10,'admins','edit','Admins','admins','index',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(11,'admins','edit','Edit Admin','admins','index',0,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(12,'admins','editprofile','Home','admins','dashboard',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(13,'admins','editprofile','Edit Profile','admins','index',0,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(14,'countries','admin_index','Home','admins','dashboard',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(15,'countries','admin_index','Countries','countries','admin_index',0,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(16,'countries','admin_add','Home','admins','dashboard',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(17,'countries','admin_add','Countries','countries','admin_index',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(18,'countries','admin_add','Add Country','countries','admin_add',0,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(19,'countries','admin_edit','Home','admins','dashboard',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(20,'countries','admin_edit','Countries','countries','admin_index',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(21,'countries','admin_edit','Edit Country','countries','admin_edit',0,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(22,'states','admin_index','Home','admins','dashboard',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(23,'states','admin_index','States','states','admin_index',0,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(24,'states','admin_add','Home','admins','dashboard',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(25,'states','admin_add','States','states','admin_index',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(26,'states','admin_add','Add State','states','admin_add',0,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(27,'states','admin_edit','Home','admins','dashboard',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(28,'states','admin_edit','States','states','admin_index',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(29,'states','admin_edit','Edit State','states','admin_edit',0,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(30,'cities','admin_index','Home','admins','dashboard',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(31,'cities','admin_index','Cities','cities','admin_index',0,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(32,'cities','admin_add','Home','admins','dashboard',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(33,'cities','admin_add','Cities','cities','admin_index',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(34,'cities','admin_add','Add City','cities','admin_add',0,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(35,'cities','admin_edit','Home','admins','dashboard',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(36,'cities','admin_edit','Cities','cities','admin_index',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(37,'cities','admin_edit','Edit city','cities','admin_edit',0,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(38,'cmspages','admin_index','Home','admins','dashboard',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(39,'cmspages','admin_index','Pages','cmspages','admin_index',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(40,'cmspages','admin_index','Listing','cmspages','admin_index',0,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(41,'cmspages','admin_add','Home','admins','dashboard',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(42,'cmspages','admin_add','Pages','cmspages','admin_index',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(43,'cmspages','admin_add','Add Page','cmspages','admin_add',0,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(44,'cmspages','admin_edit','Home','admins','dashboard',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(45,'cmspages','admin_edit','Pages','cmspages','admin_index',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(46,'cmspages','admin_edit','Edit Page','cmspages','admin_edit',0,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(47,'cmsemails','admin_index','Home','admins','dashboard',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(48,'cmsemails','admin_index','Email Templates','cmsemails','admin_index',0,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(49,'cmsemails','admin_add','Home','admins','dashboard',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(50,'cmsemails','admin_add','Email Templates','cmsemails','admin_index',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(51,'cmsemails','admin_add','Add Template','cmsemails','admin_add',0,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(52,'cmsemails','admin_edit','Home','admins','dashboard',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(53,'cmsemails','admin_edit','Email Templates','cmsemails','admin_index',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(54,'cmsemails','admin_edit','Edit Template','cmsemails','admin_edit',0,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(55,'users','admin_index','Home','admins','dashboard',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(56,'users','admin_index','Users','cmsemails','admin_index',0,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(57,'users','admin_add','Home','admins','dashboard',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(58,'users','admin_add','Users','users','admin_index',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(59,'users','admin_add','Add User','users','admin_add',0,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(60,'users','admin_edit','Home','admins','dashboard',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(61,'users','admin_edit','Users','users','admin_index',1,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(62,'users','admin_edit','Edit User','users','admin_edit',0,1,'2013-04-29 12:26:17','2013-04-29 12:26:17'),(63,'packages','admin_index','Home','admins','dashboard',1,1,'2013-04-29 00:00:00','2013-04-29 00:00:00'),(64,'packages','admin_index','Packages','packages','admin_index',0,1,'2013-04-29 00:00:00','2013-04-29 00:00:00'),(65,'packages','admin_add','Home','admins','dashboard',1,1,'2013-04-30 00:00:00','2013-04-30 00:00:00'),(66,'packages','admin_add','Add Package','packages','admin_add',0,1,'2013-04-30 00:00:00','2013-04-30 00:00:00'),(67,'packages','admin_edit','Home','admins','dashboard',1,1,'2013-04-29 00:00:00','2013-04-29 00:00:00'),(68,'packages','admin_edit','Edit Package','packages','admin_edit',0,1,'2013-04-29 00:00:00','2013-04-29 00:00:00'),(69,'industries','admin_index','Home','admins','dashboard',1,1,'2013-04-29 00:00:00','2013-04-29 00:00:00'),(70,'industries','admin_index','Industry','industries','admin_index',0,1,'2013-04-29 00:00:00','2013-04-29 00:00:00'),(71,'industries','admin_add','Home','admins','dashboard',1,1,'2013-04-30 00:00:00','2013-04-30 00:00:00'),(72,'industries','admin_add','Add Industry','industries','admin_add',0,1,'2013-04-30 00:00:00','2013-04-30 00:00:00'),(73,'industries','admin_edit','Home','admins','dashboard',1,1,'2013-04-29 00:00:00','2013-04-29 00:00:00'),(74,'industries','admin_edit','Edit Industry','industries','admin_edit',0,1,'2013-04-29 00:00:00','2013-04-29 00:00:00');
/*!40000 ALTER TABLE `breadcrumbs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Technology',1,NULL,'2013-08-02 11:31:08'),(2,'Business',1,NULL,'2013-08-02 11:31:08'),(3,'testing1',0,'2013-08-02 10:45:05','2013-08-02 13:02:18'),(7,'rtest11212',0,'2013-08-02 11:30:41','2013-08-02 13:02:35');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmsemails`
--

DROP TABLE IF EXISTS `cmsemails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmsemails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mailfrom` varchar(255) DEFAULT NULL,
  `mailsubject` varchar(255) DEFAULT NULL,
  `mailcontent` longtext,
  `status` tinyint(1) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmsemails`
--

LOCK TABLES `cmsemails` WRITE;
/*!40000 ALTER TABLE `cmsemails` DISABLE KEYS */;
INSERT INTO `cmsemails` VALUES (1,'noreply@iot.com','Registeration Confirmation','<p>\r\n	Dear {USER},</p>\r\n<p>\r\n	Your registration with 1337 Institute of Technology has been successfull.</p>\r\n<p>\r\n	Please {LINK} to activate your account.</p>\r\n<p>\r\n	Thanks &amp; Regards,</p>\r\n<p>\r\n	Team 1337 Institute of Technology..</p>\r\n',1,'2013-04-29 10:54:50','2013-07-22 12:20:19'),(2,'noreply@iot.com','Forgot Password','<p>\r\n	Dear {USER},</p>\r\n<p>\r\n	Your new password is : {PASSWORD}.</p>\r\n<p>\r\n	Thanks &amp; Regards,</p>\r\n<p>\r\n	Team Institute of Technology..</p>\r\n',1,'2013-05-06 11:31:14','2013-05-06 11:31:36'),(3,'noreply@iot.com','Hiring for Campaign','<p>\r\n	Dear {USER},</p>\r\n<p>\r\n	{BUSINESS} has hired you for campaign {CAMPAIGN}.</p>\r\n<p>\r\n	Thanks &amp; Regards,</p>\r\n<p>\r\n	Team Institute of Technology..</p>\r\n',0,'2013-05-23 19:31:58','2013-05-23 19:32:23'),(4,'noreply@iot.com','Hiring Confirmation','<p>\r\n	Dear {USER},</p>\r\n<p>\r\n	This is to inform you that you have hired {PUBLISHER} for campaign {CAMPAIGN}.</p>\r\n<p>\r\n	Thanks &amp; Regards,</p>\r\n<p>\r\n	Team Institute of Technology..</p>\r\n',0,'2013-05-23 19:34:57','2013-05-23 19:34:57'),(5,'shivamsharma@zapbuild.com','HypeFly Message','<p>\r\n	{SENDER} has sent a message via HypeFly :</p>\r\n<p>\r\n	&nbsp;</p>\r\n<p>\r\n	{MESSAGE}</p>\r\n',0,'2013-05-24 15:13:58','2013-05-27 12:43:23'),(6,'noreply@iot.com','Contract Update','<p>\r\n	Dear {PUBLISHER},</p>\r\n<p>\r\n	The status of your contract with id #{CONTRACTID} has been changed to {CONTRACTSTATUS}.</p>\r\n<p>\r\n	Regards,</p>\r\n<p>\r\n	Team Institute of Technology..</p>\r\n',0,'2013-06-06 16:41:57','2013-06-06 17:07:11'),(7,'noreply@iot.com','Contract Dispute','<p>\r\n	Dear {USER},</p>\r\n<p>\r\n	{SENDER} has raised a dispute for contract #{CONTRACTID}.</p>\r\n<p>\r\n	The reason for raising dispute:</p>\r\n<p>\r\n	{REASON}</p>\r\n<p>\r\n	Please note if you will not respond this notification within 72 hours, the dispute will be approved by HypeFly automatically. Please login to {HYPEFLY} to respond.</p>\r\n<p>\r\n	Thanks &amp; Regards,</p>\r\n<p>\r\n	Team Institute of Technology..</p>\r\n',0,'2013-06-10 11:01:53','2013-06-10 11:01:53'),(8,'noreply@iot.com','HypeFly Notification','<p>\r\n	Dear {USER},</p>\r\n<p>\r\n	{SENDER} has added a new note to disputed contract #{CONTRACTID} :</p>\r\n<p>\r\n	{NOTE}</p>\r\n<p>\r\n	Thanks &amp; Regards,</p>\r\n<p>\r\n	Team Institute of Technology..</p>\r\n',0,'2013-06-10 13:20:53','2013-06-10 13:35:14'),(10,'noreply@iot.com','HypeFly Notification','<p>\r\n	Dear {USER},</p>\r\n<p>\r\n	This mail is to notify you that Dispute related to contract #{CONTRACTID} has been {STATUS} by HypeFly.</p>\r\n<p>\r\n	Now the status of your Contract is {CONTRACTSTATUS}.</p>\r\n<p>\r\n	Thanks &amp; Regards,</p>\r\n<p>\r\n	Team Institute of Technology..</p>\r\n',0,'2013-06-11 15:34:54','2013-06-11 15:39:07');
/*!40000 ALTER TABLE `cmsemails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cmspages`
--

DROP TABLE IF EXISTS `cmspages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmspages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `content` longtext NOT NULL,
  `metatitle` varchar(255) DEFAULT NULL,
  `seourl` varchar(255) DEFAULT NULL,
  `metadesc` text,
  `metakeyword` text,
  `status` tinyint(1) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cmspages`
--

LOCK TABLES `cmspages` WRITE;
/*!40000 ALTER TABLE `cmspages` DISABLE KEYS */;
/*!40000 ALTER TABLE `cmspages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configurations`
--

DROP TABLE IF EXISTS `configurations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configurations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `heading` varchar(255) DEFAULT NULL,
  `default_header` varchar(100) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configurations`
--

LOCK TABLES `configurations` WRITE;
/*!40000 ALTER TABLE `configurations` DISABLE KEYS */;
INSERT INTO `configurations` VALUES (1,'Commission(%)','SITE_COMMISSION','10','2013-04-29 00:00:00','2013-06-28 12:34:49'),(2,'Instructor Default Commission','INSTRUCTOR_COMMISSION','5','2013-04-26 00:00:00','2013-06-28 12:34:49'),(3,'Dispute Management Email','','shivamsharma@zapbuild.com','2013-06-10 00:00:00','2013-06-28 12:34:49');
/*!40000 ALTER TABLE `configurations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_audience`
--

DROP TABLE IF EXISTS `course_audience`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_audience` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `title` longtext,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_audience`
--

LOCK TABLES `course_audience` WRITE;
/*!40000 ALTER TABLE `course_audience` DISABLE KEYS */;
INSERT INTO `course_audience` VALUES (1,7,'a:2:{i:1;s:6:\"sfsdaf\";i:2;s:8:\"asfdsdaf\";}','2013-07-19 16:18:22','2013-07-19 16:18:22'),(2,12,'a:1:{i:1;s:0:\"\";}','2013-07-22 16:56:48','2013-07-22 16:59:36'),(3,15,'a:1:{i:1;s:0:\"\";}','2013-07-22 18:14:30','2013-07-22 18:14:30');
/*!40000 ALTER TABLE `course_audience` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_content_types`
--

DROP TABLE IF EXISTS `course_content_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_content_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `primary_image` varchar(200) DEFAULT NULL,
  `secondary_image` varchar(200) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_content_types`
--

LOCK TABLES `course_content_types` WRITE;
/*!40000 ALTER TABLE `course_content_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `course_content_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_contents`
--

DROP TABLE IF EXISTS `course_contents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_contents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_content_type_id` int(11) DEFAULT NULL,
  `section` int(11) DEFAULT NULL,
  `lecture` int(11) DEFAULT NULL,
  `content` longtext,
  `content_link` varchar(200) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_contents`
--

LOCK TABLES `course_contents` WRITE;
/*!40000 ALTER TABLE `course_contents` DISABLE KEYS */;
/*!40000 ALTER TABLE `course_contents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_goals`
--

DROP TABLE IF EXISTS `course_goals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_goals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `title` longtext,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_goals`
--

LOCK TABLES `course_goals` WRITE;
/*!40000 ALTER TABLE `course_goals` DISABLE KEYS */;
INSERT INTO `course_goals` VALUES (1,7,'a:2:{i:1;s:6:\"xzvxcv\";i:2;s:5:\"xcvcx\";}','2013-07-19 16:18:22','2013-07-19 16:18:22'),(2,12,'a:1:{i:1;s:6:\"xzvxcv\";}','2013-07-22 16:56:48','2013-07-22 16:59:36'),(3,15,'a:1:{i:1;s:0:\"\";}','2013-07-22 18:14:30','2013-07-22 18:14:30');
/*!40000 ALTER TABLE `course_goals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_instructors`
--

DROP TABLE IF EXISTS `course_instructors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_instructors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `editpermission` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 for not giving instructor permission to edit course and 1 is for giving permission to edit course',
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `commission` float NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_instructors`
--

LOCK TABLES `course_instructors` WRITE;
/*!40000 ALTER TABLE `course_instructors` DISABLE KEYS */;
INSERT INTO `course_instructors` VALUES (17,7,8,1,1,0,'2013-07-19 16:17:35','2013-07-19 16:17:35'),(19,8,10,1,1,0,'2013-07-19 21:27:32','2013-07-19 21:27:32'),(21,10,8,1,1,0,'2013-07-19 22:27:30','2013-07-19 22:27:30'),(24,12,8,1,1,0,'2013-07-22 12:22:58','2013-07-22 12:22:58'),(25,13,13,1,1,0,'2013-07-22 12:43:32','2013-07-22 12:43:32'),(26,14,13,1,1,0,'2013-07-22 14:35:18','2013-07-22 14:35:18'),(27,15,13,1,1,0,'2013-07-22 17:08:44','2013-07-22 17:08:44'),(28,16,13,1,1,0,'2013-07-23 14:20:04','2013-07-23 14:20:04'),(29,16,13,0,1,5,'2013-07-23 14:21:19','2013-07-23 14:21:19'),(30,16,8,0,1,5,'2013-07-23 14:21:50','2013-07-23 14:21:50'),(31,22,8,1,1,0,'2013-07-24 14:53:58','2013-07-24 14:53:58'),(32,23,8,1,1,0,'2013-07-24 14:55:46','2013-07-24 14:55:46'),(33,24,14,1,1,0,'2013-07-25 17:19:19','2013-07-25 17:19:19'),(35,26,14,1,1,0,'2013-07-25 18:22:42','2013-07-25 18:22:42'),(36,27,14,1,1,0,'2013-07-26 12:58:41','2013-07-26 12:58:41');
/*!40000 ALTER TABLE `course_instructors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_invitees`
--

DROP TABLE IF EXISTS `course_invitees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_invitees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `invitee` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_invitees`
--

LOCK TABLES `course_invitees` WRITE;
/*!40000 ALTER TABLE `course_invitees` DISABLE KEYS */;
/*!40000 ALTER TABLE `course_invitees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_lectures`
--

DROP TABLE IF EXISTS `course_lectures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_lectures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `course_section_id` int(11) DEFAULT NULL,
  `heading` varchar(100) DEFAULT NULL,
  `content` longtext,
  `content_type` enum('D','T','A','V','P') DEFAULT NULL COMMENT 'D for Documents it can be pdf or ppt etc, T for text only, A for Audio files, V for Video files,P for presentation',
  `content_source` varchar(100) DEFAULT NULL,
  `supplimentary_material` varchar(100) NOT NULL,
  `lecture_index` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_lectures`
--

LOCK TABLES `course_lectures` WRITE;
/*!40000 ALTER TABLE `course_lectures` DISABLE KEYS */;
INSERT INTO `course_lectures` VALUES (36,7,13,'My First Lecture',NULL,'V','img/8/Course7/Section13/Lecture36/lecturevideo.mp4','',1,'2013-07-19 16:17:36','2013-07-22 12:51:26'),(37,8,14,'My First Lecture',NULL,NULL,NULL,'',1,'2013-07-19 21:27:32','2013-07-19 21:27:32'),(39,10,16,'My First Lecture',NULL,NULL,NULL,'',1,'2013-07-19 22:27:30','2013-07-19 22:27:30'),(40,7,13,'hhhh',NULL,'P','img/8/Course7/Section13/Lecture40/lecturedocs.pdf','',2,'2013-07-22 10:29:28','2013-07-22 12:52:17'),(42,12,18,'My First Lecture',NULL,'D','img/8/Course12/Section18/Lecture42/lecturedocs.pdf','',1,'2013-07-22 12:22:58','2013-07-22 14:13:11'),(43,7,13,'A new one',NULL,'P','img/8/Course7/Section13/Lecture43/lecturedocs.pdf','',3,'2013-07-22 12:43:15','2013-07-22 12:43:42'),(44,13,19,'My First Lecture',NULL,NULL,NULL,'',1,'2013-07-22 12:43:32','2013-07-22 12:43:32'),(45,14,20,'This is my First Lecture',NULL,'V','img/13/Course14/Section20/Lecture45/lecturevideo.mp4','',1,'2013-07-22 14:35:19','2013-07-22 15:02:44'),(46,14,20,'This is my second lecture',NULL,'A','img/13/Course14/Section20/Lecture46/lectureaudio.mp3','',2,'2013-07-22 15:09:08','2013-07-22 15:10:47'),(47,14,20,'this is my third lecture',NULL,NULL,NULL,'',3,'2013-07-22 15:11:10','2013-07-22 15:11:10'),(48,14,20,'this is my fourth lecture','<p>\r\n	this is nice</p>\r\n','D','img/13/Course14/Section20/Lecture48/lecturedocs.pdf','',4,'2013-07-22 15:15:30','2013-07-22 15:17:09'),(49,14,20,'this is my fifth lecture',NULL,'P','img/13/Course14/Section20/Lecture49/lecturedocs.pdf','',5,'2013-07-22 16:45:25','2013-07-22 16:45:49'),(50,14,21,'My is First Lecture','<p>\r\n	dsdsad</p>\r\n','A','img/13/Course14/Section21/Lecture50/lectureaudio.mp3','',1,'2013-07-22 16:46:12','2013-07-22 16:47:37'),(51,12,18,'dcxgvfgb',NULL,NULL,NULL,'',2,'2013-07-22 16:51:24','2013-07-22 16:51:24'),(52,12,18,'zdcgxfdg',NULL,NULL,NULL,'',3,'2013-07-22 16:51:47','2013-07-22 16:51:47'),(53,12,18,'xfgdfg',NULL,NULL,NULL,'',4,'2013-07-22 16:51:52','2013-07-22 16:51:52'),(54,12,18,'dfgfd sdfg',NULL,NULL,NULL,'',5,'2013-07-22 16:51:59','2013-07-22 16:51:59'),(55,12,18,'xgfdgf',NULL,NULL,NULL,'',6,'2013-07-22 16:52:04','2013-07-22 16:52:04'),(56,15,22,'First Lecture of mine',NULL,'A','img/13/Course15/Section22/Lecture56/lectureaudio.mp3','',1,'2013-07-22 17:08:44','2013-07-22 17:09:39'),(57,16,23,'My First Lecture',NULL,NULL,NULL,'',1,'2013-07-23 14:20:05','2013-07-23 14:20:05'),(58,22,24,'My First Lecture',NULL,NULL,NULL,'',1,'2013-07-24 14:53:58','2013-07-24 14:53:58'),(59,23,25,'My First Lecture',NULL,NULL,NULL,'',1,'2013-07-24 14:55:47','2013-07-24 14:55:47'),(60,24,26,'My First Lecture',NULL,NULL,NULL,'',1,'2013-07-25 17:19:19','2013-07-25 17:19:19'),(62,26,28,'My First Lecture',NULL,NULL,NULL,'',1,'2013-07-25 18:22:42','2013-07-25 18:22:42'),(63,27,29,'My First Lecture',NULL,NULL,NULL,'',1,'2013-07-26 12:58:42','2013-07-26 12:58:42');
/*!40000 ALTER TABLE `course_lectures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_passwords`
--

DROP TABLE IF EXISTS `course_passwords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_passwords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_passwords`
--

LOCK TABLES `course_passwords` WRITE;
/*!40000 ALTER TABLE `course_passwords` DISABLE KEYS */;
INSERT INTO `course_passwords` VALUES (1,7,'','2013-07-19 16:19:02','2013-07-19 16:19:02');
/*!40000 ALTER TABLE `course_passwords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_quiz_question_options`
--

DROP TABLE IF EXISTS `course_quiz_question_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_quiz_question_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_quiz_question_id` int(11) NOT NULL,
  `options` varchar(200) DEFAULT NULL,
  `answer` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_quiz_question_options`
--

LOCK TABLES `course_quiz_question_options` WRITE;
/*!40000 ALTER TABLE `course_quiz_question_options` DISABLE KEYS */;
INSERT INTO `course_quiz_question_options` VALUES (1,0,NULL,NULL,'2013-07-19 15:14:30','2013-07-19 15:14:30'),(2,0,NULL,NULL,'2013-07-19 15:15:10','2013-07-19 15:15:10'),(3,0,NULL,NULL,'2013-07-19 15:15:37','2013-07-19 15:15:37'),(4,11,'dgdfs',0,'2013-07-19 15:16:04','2013-07-19 15:16:04'),(5,11,'sdfgfdsg',1,'2013-07-19 15:16:04','2013-07-19 15:16:04'),(6,11,'sdfgdsfg',0,'2013-07-19 15:16:04','2013-07-19 15:16:04'),(7,11,'sdfgdfsg',0,'2013-07-19 15:16:04','2013-07-19 15:16:04'),(8,0,NULL,NULL,'2013-07-19 15:54:29','2013-07-19 15:54:29'),(9,13,'1',NULL,'2013-07-19 15:56:57','2013-07-19 15:56:57'),(10,13,'0',NULL,'2013-07-19 15:56:57','2013-07-19 15:56:57'),(11,14,'1',NULL,'2013-07-19 15:57:42','2013-07-19 15:57:42'),(12,14,'0',NULL,'2013-07-19 15:57:42','2013-07-19 15:57:42'),(13,15,'1',NULL,'2013-07-19 15:58:18','2013-07-19 15:58:18'),(14,15,'0',NULL,'2013-07-19 15:58:18','2013-07-19 15:58:18'),(15,16,'1',1,'2013-07-19 15:59:36','2013-07-19 15:59:36'),(16,16,'0',1,'2013-07-19 15:59:36','2013-07-19 15:59:36'),(17,17,'0',1,'2013-07-19 16:00:33','2013-07-19 16:00:33'),(18,17,'1',1,'2013-07-19 16:00:33','2013-07-19 16:00:33'),(19,18,'0',1,'2013-07-19 16:01:07','2013-07-19 16:01:07'),(20,18,'1',1,'2013-07-19 16:01:07','2013-07-19 16:01:07'),(21,19,'0',1,'2013-07-19 16:02:14','2013-07-19 16:02:14'),(22,19,'1',1,'2013-07-19 16:02:14','2013-07-19 16:02:14'),(23,20,'True',0,'2013-07-19 16:03:12','2013-07-19 16:03:12'),(24,20,'False',1,'2013-07-19 16:03:12','2013-07-19 16:03:12'),(25,21,NULL,1,'2013-07-19 16:07:02','2013-07-19 16:07:02'),(26,21,NULL,0,'2013-07-19 16:07:02','2013-07-19 16:07:02'),(27,21,NULL,0,'2013-07-19 16:07:02','2013-07-19 16:07:02'),(28,21,NULL,0,'2013-07-19 16:07:02','2013-07-19 16:07:02'),(29,22,NULL,1,'2013-07-19 16:07:23','2013-07-19 16:07:23'),(30,22,NULL,0,'2013-07-19 16:07:23','2013-07-19 16:07:23'),(31,22,NULL,0,'2013-07-19 16:07:23','2013-07-19 16:07:23'),(32,22,NULL,0,'2013-07-19 16:07:23','2013-07-19 16:07:23'),(33,23,'How,You',1,'2013-07-19 16:08:31','2013-07-19 16:08:31'),(34,23,'How,me',0,'2013-07-19 16:08:31','2013-07-19 16:08:31'),(35,23,'Who,You',0,'2013-07-19 16:08:31','2013-07-19 16:08:31'),(36,23,'How,I',0,'2013-07-19 16:08:31','2013-07-19 16:08:31'),(37,24,'Answer1',0,'2013-07-19 16:49:39','2013-07-19 16:49:39'),(38,24,'Answer1',0,'2013-07-19 16:49:39','2013-07-19 16:49:39'),(39,24,'Answer1',1,'2013-07-19 16:49:39','2013-07-19 16:49:39'),(40,24,'Answer1',0,'2013-07-19 16:49:39','2013-07-19 16:49:39'),(41,25,'True',1,'2013-07-22 17:06:53','2013-07-22 17:06:53'),(42,25,'False',0,'2013-07-22 17:06:53','2013-07-22 17:06:53'),(43,26,'True',1,'2013-07-22 17:06:57','2013-07-22 17:06:57'),(44,26,'False',0,'2013-07-22 17:06:57','2013-07-22 17:06:57'),(45,27,'True',1,'2013-07-22 17:07:00','2013-07-22 17:07:00'),(46,27,'False',0,'2013-07-22 17:07:00','2013-07-22 17:07:00'),(47,28,'True',1,'2013-07-22 17:07:01','2013-07-22 17:07:01'),(48,28,'False',0,'2013-07-22 17:07:01','2013-07-22 17:07:01'),(49,29,'True',1,'2013-07-22 17:07:01','2013-07-22 17:07:01'),(50,29,'False',0,'2013-07-22 17:07:01','2013-07-22 17:07:01'),(51,30,'True',1,'2013-07-22 17:07:01','2013-07-22 17:07:01'),(52,30,'False',0,'2013-07-22 17:07:01','2013-07-22 17:07:01'),(53,31,'True',1,'2013-07-22 17:07:02','2013-07-22 17:07:02'),(54,31,'False',0,'2013-07-22 17:07:02','2013-07-22 17:07:02'),(55,32,'True',1,'2013-07-22 17:07:02','2013-07-22 17:07:02'),(56,32,'False',0,'2013-07-22 17:07:02','2013-07-22 17:07:02'),(57,33,'True',1,'2013-07-22 17:07:02','2013-07-22 17:07:02'),(58,33,'False',0,'2013-07-22 17:07:02','2013-07-22 17:07:02'),(59,34,'True',1,'2013-07-22 17:07:02','2013-07-22 17:07:02'),(60,34,'False',0,'2013-07-22 17:07:02','2013-07-22 17:07:02'),(61,35,'True',1,'2013-07-22 17:07:03','2013-07-22 17:07:03'),(62,35,'False',0,'2013-07-22 17:07:03','2013-07-22 17:07:03'),(63,36,'True',1,'2013-07-22 17:07:04','2013-07-22 17:07:04'),(64,36,'False',0,'2013-07-22 17:07:04','2013-07-22 17:07:04'),(65,37,'True',1,'2013-07-22 17:07:04','2013-07-22 17:07:04'),(66,37,'False',0,'2013-07-22 17:07:04','2013-07-22 17:07:04'),(67,38,'True',1,'2013-07-22 17:07:06','2013-07-22 17:07:06'),(68,38,'False',0,'2013-07-22 17:07:06','2013-07-22 17:07:06');
/*!40000 ALTER TABLE `course_quiz_question_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_quiz_questions`
--

DROP TABLE IF EXISTS `course_quiz_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_quiz_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_quiz_id` int(11) DEFAULT NULL,
  `question` varchar(100) DEFAULT NULL,
  `type` enum('B','M','F') DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_quiz_questions`
--

LOCK TABLES `course_quiz_questions` WRITE;
/*!40000 ALTER TABLE `course_quiz_questions` DISABLE KEYS */;
INSERT INTO `course_quiz_questions` VALUES (1,2,'<p>\n	sdfg dsfg sdf gsdfg</p>\n',NULL,'2013-07-19 14:46:12','2013-07-19 14:46:12'),(2,2,'<p>\n	sdfg dsfg sdf gsdfg</p>\n',NULL,'2013-07-19 14:48:24','2013-07-19 14:48:24'),(3,2,'<p>\n	xbgvbgdfb</p>\n','M','2013-07-19 14:48:59','2013-07-19 14:48:59'),(4,2,'<p>\n	xbgvbgdfb</p>\n','M','2013-07-19 14:49:33','2013-07-19 14:49:33'),(5,2,'<p>\n	xbgvbgdfb</p>\n','M','2013-07-19 14:49:57','2013-07-19 14:49:57'),(6,2,'<p>\n	dsfgfsdgfsdgsdf</p>\n','M','2013-07-19 15:13:33','2013-07-19 15:13:33'),(7,2,'<p>\n	dsfgfsdgfsdgsdf</p>\n','M','2013-07-19 15:14:06','2013-07-19 15:14:06'),(8,2,'<p>\n	dsfgfsdgfsdgsdf</p>\n','M','2013-07-19 15:14:30','2013-07-19 15:14:30'),(9,2,'<p>\n	dsfgfsdgfsdgsdf</p>\n','M','2013-07-19 15:15:10','2013-07-19 15:15:10'),(10,2,'<p>\n	dsfgfsdgfsdgsdf</p>\n','M','2013-07-19 15:15:36','2013-07-19 15:15:36'),(11,2,'<p>\n	dsfgfsdgfsdgsdf</p>\n','M','2013-07-19 15:16:04','2013-07-19 15:16:04'),(12,2,'<p>\n	vs ddwsaf&nbsp; asdf sa sadf a fasdf</p>\n','M','2013-07-19 15:54:29','2013-07-19 15:54:29'),(13,2,'<p>\n	sdgfds sdfgsda</p>\n','M','2013-07-19 15:56:57','2013-07-19 15:56:57'),(14,2,'<p>\n	sdgfds sdfgsda</p>\n','M','2013-07-19 15:57:42','2013-07-19 15:57:42'),(15,2,'<p>\n	sdgfds sdfgsda</p>\n','M','2013-07-19 15:58:18','2013-07-19 15:58:18'),(16,2,'<p>\n	xcbvxcb dbvgd</p>\n','B','2013-07-19 15:59:36','2013-07-19 15:59:36'),(17,2,'<p>\n	zxcvxzcv</p>\n','B','2013-07-19 16:00:33','2013-07-19 16:00:33'),(18,2,'<p>\n	zxcvxzcv</p>\n','B','2013-07-19 16:01:07','2013-07-19 16:01:07'),(19,2,'<p>\n	zxcvxzcv</p>\n','B','2013-07-19 16:02:14','2013-07-19 16:02:14'),(20,2,'<p>\n	zxcvxzcv</p>\n','B','2013-07-19 16:03:12','2013-07-19 16:03:12'),(21,2,'<p>\n	Hello_,are_?</p>\n','F','2013-07-19 16:07:01','2013-07-19 16:07:01'),(22,2,'<p>\n	Hello_,are_?</p>\n','F','2013-07-19 16:07:23','2013-07-19 16:07:23'),(23,2,'<p>\n	Hello_,are_?</p>\n','F','2013-07-19 16:08:31','2013-07-19 16:08:31'),(24,8,'<p>\n	Hello Give me answer?</p>\n','M','2013-07-19 16:49:39','2013-07-19 16:49:39'),(25,9,'<p>\n	I am the Queen.</p>\n','B','2013-07-22 17:06:53','2013-07-22 17:06:53'),(26,9,'<p>\n	I am the Queen.</p>\n','B','2013-07-22 17:06:57','2013-07-22 17:06:57'),(27,9,'<p>\n	I am the Queen.</p>\n','B','2013-07-22 17:07:00','2013-07-22 17:07:00'),(28,9,'<p>\n	I am the Queen.</p>\n','B','2013-07-22 17:07:01','2013-07-22 17:07:01'),(29,9,'<p>\n	I am the Queen.</p>\n','B','2013-07-22 17:07:01','2013-07-22 17:07:01'),(30,9,'<p>\n	I am the Queen.</p>\n','B','2013-07-22 17:07:01','2013-07-22 17:07:01'),(31,9,'<p>\n	I am the Queen.</p>\n','B','2013-07-22 17:07:01','2013-07-22 17:07:01'),(32,9,'<p>\n	I am the Queen.</p>\n','B','2013-07-22 17:07:02','2013-07-22 17:07:02'),(33,9,'<p>\n	I am the Queen.</p>\n','B','2013-07-22 17:07:02','2013-07-22 17:07:02'),(34,9,'<p>\n	I am the Queen.</p>\n','B','2013-07-22 17:07:02','2013-07-22 17:07:02'),(35,9,'<p>\n	I am the Queen.</p>\n','B','2013-07-22 17:07:03','2013-07-22 17:07:03'),(36,9,'<p>\n	I am the Queen.</p>\n','B','2013-07-22 17:07:04','2013-07-22 17:07:04'),(37,9,'<p>\n	I am the Queen.</p>\n','B','2013-07-22 17:07:04','2013-07-22 17:07:04'),(38,9,'<p>\n	I am the Queen.</p>\n','B','2013-07-22 17:07:06','2013-07-22 17:07:06');
/*!40000 ALTER TABLE `course_quiz_questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_quizzes`
--

DROP TABLE IF EXISTS `course_quizzes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_quizzes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_section_id` int(11) NOT NULL,
  `course_lecture_id` int(11) NOT NULL,
  `heading` varchar(100) DEFAULT NULL,
  `content` text NOT NULL,
  `publish` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_section_id` (`course_section_id`),
  KEY `course_lecture_id` (`course_lecture_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_quizzes`
--

LOCK TABLES `course_quizzes` WRITE;
/*!40000 ALTER TABLE `course_quizzes` DISABLE KEYS */;
INSERT INTO `course_quizzes` VALUES (8,13,36,'First Quiz','<p>\n	Hello it is just a simple quiz to initiate the new lecture.</p>\n',NULL,'2013-07-19 16:36:30','2013-07-19 17:30:08'),(9,21,50,'Quiz 1','<p>\n	who is the queen</p>\n',NULL,'2013-07-22 16:48:01','2013-07-22 17:07:05'),(10,22,56,'Quiz 1 of mine','',NULL,'2013-07-22 17:09:56','2013-07-22 17:09:56'),(11,22,56,'Quiz 2','',NULL,'2013-07-22 17:35:36','2013-07-22 17:35:36');
/*!40000 ALTER TABLE `course_quizzes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_requirements`
--

DROP TABLE IF EXISTS `course_requirements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_requirements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `title` longtext,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_requirements`
--

LOCK TABLES `course_requirements` WRITE;
/*!40000 ALTER TABLE `course_requirements` DISABLE KEYS */;
INSERT INTO `course_requirements` VALUES (1,7,'a:2:{i:1;s:6:\"sdfsad\";i:3;s:7:\"asfsadf\";}','2013-07-19 16:18:22','2013-07-19 16:18:22'),(2,12,'a:1:{i:1;s:0:\"\";}','2013-07-22 16:56:48','2013-07-22 16:59:36'),(3,15,'a:1:{i:1;s:0:\"\";}','2013-07-22 18:14:30','2013-07-22 18:14:30');
/*!40000 ALTER TABLE `course_requirements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_sections`
--

DROP TABLE IF EXISTS `course_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `heading` varchar(100) DEFAULT NULL,
  `section_index` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_sections`
--

LOCK TABLES `course_sections` WRITE;
/*!40000 ALTER TABLE `course_sections` DISABLE KEYS */;
INSERT INTO `course_sections` VALUES (13,7,'Start of learning c',1,'2013-07-19 16:17:35','2013-07-19 16:24:57'),(14,8,'My First Section',1,'2013-07-19 21:27:32','2013-07-19 21:27:32'),(16,10,'My First Section',1,'2013-07-19 22:27:30','2013-07-19 22:27:30'),(18,12,'My First Section',1,'2013-07-22 12:22:58','2013-07-22 12:22:58'),(19,13,'My First Section',1,'2013-07-22 12:43:32','2013-07-22 12:43:32'),(20,14,'This is my frst session',1,'2013-07-22 14:35:19','2013-07-22 14:59:41'),(21,14,'thisis my secong session',2,'2013-07-22 16:46:12','2013-07-22 16:46:12'),(22,15,'My First Section',1,'2013-07-22 17:08:44','2013-07-22 17:08:44'),(23,16,'My First Section',1,'2013-07-23 14:20:05','2013-07-23 14:20:05'),(24,22,'My First Section',1,'2013-07-24 14:53:58','2013-07-24 14:53:58'),(25,23,'My First Section',1,'2013-07-24 14:55:46','2013-07-24 14:55:46'),(26,24,'My First Section',1,'2013-07-25 17:19:19','2013-07-25 17:19:19'),(28,26,'My First Section',1,'2013-07-25 18:22:42','2013-07-25 18:22:42'),(29,27,'My First Section',1,'2013-07-26 12:58:41','2013-07-26 12:58:41');
/*!40000 ALTER TABLE `course_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `instruction_level_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `subtitle` varchar(100) DEFAULT NULL,
  `keywords` varchar(200) DEFAULT NULL,
  `summary` text,
  `coverimage` varchar(150) DEFAULT NULL,
  `promovideo` varchar(150) DEFAULT NULL,
  `visibility` enum('Private','Public') DEFAULT 'Public',
  `pricetype` enum('Free','Paid') NOT NULL DEFAULT 'Free',
  `price` float NOT NULL,
  `privacy_type` enum('1','2') DEFAULT NULL COMMENT '1 for adding invitees and 2 for making course password protected, will be dependent on visibility type of course will be used only visibility type be selected as private',
  `publishstatus` enum('Publish','Unpublish') DEFAULT 'Unpublish' COMMENT 'User can mark its course as publish or unpublish',
  `status` tinyint(1) DEFAULT '1' COMMENT 'field to manage site admin right on course site admin can mark and course inactive at any time',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (7,8,1,2,4,'aaaa','aaaa','aaaa','zxvcsd sadfsadf ','/img/8/Course/7/coverimage/coverimage.gif','img/8/Course/7/coverimage/1374194974.flv','Public','Free',100,'1','Unpublish',1,'2013-07-19 16:17:35','2013-08-02 13:01:38'),(8,10,NULL,NULL,NULL,'new',NULL,NULL,NULL,NULL,NULL,'Public','Free',0,NULL,'Unpublish',1,'2013-07-19 21:27:32','2013-08-02 13:01:38'),(10,8,NULL,NULL,NULL,'zsfcsd',NULL,NULL,NULL,NULL,NULL,'Public','Free',0,NULL,'Unpublish',1,'2013-07-19 22:27:30','2013-08-02 12:59:08'),(12,8,2,2,4,'My Sciences','zxcbvxcb vcxb','xcvbvxcbx','','/img/8/Course/12/coverimage/coverimage.gif',NULL,'Public','Free',0,NULL,'Unpublish',1,'2013-07-22 12:22:58','2013-08-02 12:58:32'),(13,13,NULL,NULL,NULL,'Maths VJ',NULL,NULL,NULL,NULL,NULL,'Public','Free',0,NULL,'Unpublish',1,'2013-07-22 12:43:32','2013-08-02 12:58:32'),(14,13,NULL,NULL,NULL,'Sciences1 VJ',NULL,NULL,NULL,'',NULL,'Public','Free',0,NULL,'Publish',1,'2013-07-22 14:35:18','2013-08-02 12:58:32'),(15,13,1,1,4,'Technology VJ','','','',NULL,NULL,'Public','Free',0,NULL,'Unpublish',1,'2013-07-22 17:08:44','2013-08-02 12:58:32'),(16,13,NULL,NULL,NULL,'Techno World',NULL,NULL,NULL,NULL,NULL,'Public','Free',0,NULL,'Publish',1,'2013-07-23 14:20:04','2013-08-02 12:58:32'),(18,13,1,2,4,'test1','aaaa','aaaa','zxvcsd sadfsadf ','/img/8/Course/7/coverimage/coverimage.gif','img/8/Course/7/coverimage/1374194974.flv','Public','Free',100,'1','Publish',1,'2013-07-19 16:17:35','2013-08-02 12:58:32'),(19,13,1,2,4,'test12','aaaa','aaaa','zxvcsd sadfsadf ','/img/8/Course/7/coverimage/coverimage.gif','img/8/Course/7/coverimage/1374194974.flv','Public','Free',100,'1','Publish',1,'2013-07-19 16:17:35','2013-08-02 12:58:32'),(20,13,1,2,4,'test121','aaaa','aaaa','zxvcsd sadfsadf ','/img/8/Course/7/coverimage/coverimage.gif','img/8/Course/7/coverimage/1374194974.flv','Public','Free',100,'1','Publish',1,'2013-07-19 16:17:35','2013-08-02 12:58:32'),(21,13,1,2,4,'123232','aaaa','aaaa','zxvcsd sadfsadf ','/img/8/Course/7/coverimage/coverimage.gif','img/8/Course/7/coverimage/1374194974.flv','Public','Free',100,'1','Publish',1,'2013-07-19 16:17:35','2013-08-02 12:58:32'),(22,8,NULL,NULL,NULL,'ffgf',NULL,NULL,NULL,NULL,NULL,'Public','Free',0,NULL,'Unpublish',1,'2013-07-24 14:53:58','2013-08-02 12:58:32'),(23,8,NULL,NULL,NULL,'gthfg',NULL,NULL,NULL,NULL,NULL,'Public','Free',0,NULL,'Unpublish',1,'2013-07-24 14:55:46','2013-08-02 12:58:32'),(24,14,NULL,NULL,NULL,'testiyk',NULL,NULL,NULL,NULL,NULL,'Public','Free',0,NULL,'Unpublish',1,'2013-07-25 17:19:19','2013-08-02 12:58:32'),(26,14,NULL,NULL,NULL,'dfds',NULL,NULL,NULL,NULL,NULL,'Public','Free',0,NULL,'Unpublish',1,'2013-07-25 18:22:42','2013-08-02 12:58:32'),(27,14,NULL,NULL,NULL,'dsfdsf',NULL,NULL,NULL,NULL,NULL,'Public','Free',0,NULL,'Publish',1,'2013-07-26 12:58:41','2013-08-02 12:58:32'),(29,17,1,2,2,'fsdf','this is subtitle','dfs dsf sdfdsf','','/img/17/Course/28/coverimage/coverimage.jpg','img/17/Course/28/coverimage/1375331918.flv','Private','Free',0,NULL,'Publish',1,'2013-07-31 10:13:00','2013-08-02 12:58:32'),(30,17,1,2,2,'fsdf','this is subtitle','dfs dsf sdfdsf','','/img/17/Course/28/coverimage/coverimage.jpg','img/17/Course/28/coverimage/1375331918.flv','Private','Free',0,NULL,'Publish',1,'2013-07-31 10:33:00','2013-08-02 12:58:32'),(32,17,1,2,2,'2323fsdf','232this is subtitle','d232fs dsf sdfdsf','','/img/17/Course/28/coverimage/coverimage.jpg','img/17/Course/28/coverimage/1375331918.flv','Private','Free',0,NULL,'Publish',1,'2013-07-31 10:33:00','2013-08-01 10:40:20'),(33,17,1,2,2,'1123fsdf','232this is subtitle','d232fs dsf sdfdsf','','/img/17/Course/28/coverimage/coverimage.jpg','img/17/Course/28/coverimage/1375331918.flv','Private','Free',0,NULL,'Publish',1,'2013-07-31 10:33:00','2013-08-01 10:40:20'),(34,17,1,2,2,'3333fsdf','232this is subtitle','d232fs dsf sdfdsf','','/img/17/Course/28/coverimage/coverimage.jpg','img/17/Course/28/coverimage/1375331918.flv','Private','Free',0,NULL,'Publish',1,'2013-07-31 10:33:00','2013-08-01 10:40:20'),(35,17,1,2,2,'443fsdf','232this is subtitle','d232fs dsf sdfdsf','','/img/17/Course/28/coverimage/coverimage.jpg','img/17/Course/28/coverimage/1375331918.flv','Private','Free',0,NULL,'Publish',1,'2013-07-31 10:36:00','2013-08-01 10:40:20'),(36,17,1,2,2,'553fsdf','232this is subtitle','d232fs dsf sdfdsf','','/img/17/Course/28/coverimage/coverimage.jpg','img/17/Course/28/coverimage/1375331918.flv','Private','Free',0,NULL,'Publish',1,'2013-07-31 10:37:00','2013-08-01 10:40:20');
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instruction_levels`
--

DROP TABLE IF EXISTS `instruction_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instruction_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instruction_levels`
--

LOCK TABLES `instruction_levels` WRITE;
/*!40000 ALTER TABLE `instruction_levels` DISABLE KEYS */;
INSERT INTO `instruction_levels` VALUES (1,'Introductory','2013-07-08 11:23:58','2013-07-08 11:23:58'),(2,'Intermediate','2013-07-08 11:23:58','2013-07-08 11:23:58'),(3,'Advanced','2013-07-08 11:23:58','2013-07-08 11:23:58'),(4,'All Levels (Comprehensive)','2013-07-08 11:23:58','2013-07-08 11:23:58');
/*!40000 ALTER TABLE `instruction_levels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `languages`
--

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES (1,'English (India)',1,NULL,'2013-08-02 11:52:03'),(2,'English (UK)',1,NULL,'2013-08-02 11:52:03'),(3,'Punjabi',1,'2013-08-02 11:51:41','2013-08-02 11:52:03');
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `application_id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `reciever_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text,
  `remarkflag` tinyint(1) DEFAULT '0',
  `messagestatus` enum('Unread','Read','Trash') NOT NULL DEFAULT 'Unread',
  `userdelstatus` enum('View','Delete') NOT NULL DEFAULT 'View',
  `recvdelstatus` enum('View','Delete') NOT NULL DEFAULT 'View',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `application_id` (`application_id`),
  KEY `user_id` (`user_id`),
  KEY `reciever_id` (`reciever_id`),
  KEY `campaign_id` (`campaign_id`),
  KEY `messagestatus` (`messagestatus`),
  KEY `recvdelstatus` (`recvdelstatus`),
  KEY `userdelstatus` (`userdelstatus`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notification` varchar(255) NOT NULL,
  `enable` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,'1337 Institute of Technology makes an announcement. ',1),(2,'1337 Institute of Technology chooses a Course of the Week. ',1),(3,'1337 Institute of Technology asks for a review of a course. ',0),(4,'1337 Institute of Technology recommends courses for you every week. ',1);
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `states`
--

LOCK TABLES `states` WRITE;
/*!40000 ALTER TABLE `states` DISABLE KEYS */;
/*!40000 ALTER TABLE `states` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userdetails`
--

DROP TABLE IF EXISTS `userdetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `designation` varchar(100) NOT NULL,
  `language` int(11) NOT NULL,
  `paypalaccount` varchar(150) NOT NULL,
  `about` text NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `state_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `newsletter` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `privacy` varchar(255) NOT NULL,
  `notification` varchar(255) DEFAULT NULL,
  `reference` varchar(255) NOT NULL,
  `heading` varchar(255) NOT NULL,
  `biography` text NOT NULL,
  `webLink` varchar(255) NOT NULL,
  `fbLink` varchar(255) NOT NULL,
  `gplusLink` varchar(255) NOT NULL,
  `twitterLink` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `state_id` (`state_id`),
  KEY `country_id` (`country_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userdetails`
--

LOCK TABLES `userdetails` WRITE;
/*!40000 ALTER TABLE `userdetails` DISABLE KEYS */;
INSERT INTO `userdetails` VALUES (1,1,'Shivam',NULL,'',0,'','',NULL,'',NULL,NULL,NULL,0,0,'','','','','','','','','','2013-06-27 17:20:51','2013-06-27 17:20:51'),(2,2,'Shivam',NULL,'',0,'','',NULL,'',NULL,NULL,NULL,0,0,'','','','','','','','','','2013-06-27 17:21:31','2013-06-27 17:21:31'),(3,3,'Shivam',NULL,'',0,'','',NULL,'',NULL,NULL,NULL,0,0,'','','','','','','','','','2013-06-27 17:24:27','2013-06-27 17:24:27'),(4,4,'Shivam',NULL,'',0,'','',NULL,'',NULL,NULL,NULL,0,0,'','','','','','','','','','2013-06-27 17:27:39','2013-06-27 17:27:39'),(5,5,'Shivam',NULL,'',0,'','',NULL,'',NULL,NULL,NULL,0,0,'','','','','','','','','','2013-06-27 17:28:38','2013-06-27 17:28:38'),(8,8,'Shivam','Sharma','',0,'','safdsa hello me safdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello mesafdsa hello me yo yo\r\n',NULL,'',NULL,NULL,'',0,0,'','','','','','','','','','2013-07-01 18:13:39','2013-07-24 17:14:29'),(9,9,'Shivam',NULL,'',0,'','',NULL,'',NULL,NULL,NULL,0,0,'','','','','','','','','','2013-07-10 18:04:55','2013-07-10 18:04:55'),(10,10,'Shivam',NULL,'',0,'','',NULL,'',NULL,NULL,NULL,0,0,'','','','','','','','','','2013-07-10 18:06:57','2013-07-10 18:06:57'),(11,11,'Zara','Joe','',0,'','',NULL,'',NULL,NULL,NULL,0,0,'','','','','','','','','','2013-07-19 22:16:16','2013-07-19 22:16:16'),(12,12,'Varun',NULL,'',0,'','',NULL,'',NULL,NULL,NULL,0,0,'','','','','','','','','','2013-07-22 12:14:21','2013-07-22 12:14:21'),(13,13,'vijayeta',NULL,'',0,'','',NULL,'',NULL,NULL,NULL,0,0,'','','','','','','','','','2013-07-22 12:26:26','2013-07-22 12:26:26'),(23,20,'sandeep','kaur','',1,'','',NULL,'',NULL,NULL,'/img/20/profileimg/profile.jpg',0,0,'a:3:{s:30:\"Show Profile in Search Engines\";s:1:\"1\";s:23:\"Show Courses in Profile\";s:1:\"1\";s:20:\"Use Transaction info\";s:1:\"0\";}','','','','<p>\r\n	dsfsdfsdfsdfsdf</p>\r\n','','','','','2013-08-02 16:52:56','2013-08-02 17:31:08'),(15,NULL,NULL,NULL,'',0,'','',NULL,'',NULL,NULL,NULL,0,0,'','','','','','','','','','2013-07-29 11:34:24','2013-07-29 11:34:24'),(16,NULL,NULL,NULL,'',0,'','',NULL,'',NULL,NULL,NULL,0,0,'','','','','','','','','','2013-07-29 12:12:32','2013-07-29 12:12:32'),(17,NULL,NULL,NULL,'',0,'','',NULL,'',NULL,NULL,NULL,0,0,'',NULL,'','','','','','','','2013-07-30 11:03:27','2013-07-30 11:03:27');
/*!40000 ALTER TABLE `userdetails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usernotifications`
--

DROP TABLE IF EXISTS `usernotifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usernotifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `notification_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usernotifications`
--

LOCK TABLES `usernotifications` WRITE;
/*!40000 ALTER TABLE `usernotifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `usernotifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fbid` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remembertoken` varchar(255) NOT NULL,
  `profileid` varchar(255) NOT NULL,
  `businessname` varchar(255) NOT NULL,
  `paymentprofileid` varchar(255) NOT NULL,
  `shippingprofileid` varchar(255) NOT NULL,
  `cardnum` int(11) NOT NULL,
  `type` enum('Business','Publisher','New User') NOT NULL,
  `status` tinyint(1) NOT NULL,
  `passwordstatus` varchar(255) NOT NULL,
  `newsletter` tinyint(1) DEFAULT NULL,
  `profiletype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 for private and 0 for public ',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'','hiteshchopra@zapbuild.com','123456','','','','','',0,'Business',1,'',NULL,0,'2013-06-27 17:20:50','2013-07-09 13:03:32'),(2,'','hiteshchopra1@zapbuild.com','123456','','','','','',0,'Business',1,'',NULL,0,'2013-06-27 17:21:31','2013-07-09 13:03:32'),(3,'','hiteshchopra21@zapbuild.com','7c4a8d09ca3762af61e59520943dc26494f8941b','','','','','',0,'Business',1,'',NULL,0,'2013-06-27 17:24:27','2013-07-09 13:03:32'),(4,'','hiteshchopra221@zapbuild.com','7c4a8d09ca3762af61e59520943dc26494f8941b','','','','','',0,'Business',1,'',NULL,0,'2013-06-27 17:27:39','2013-07-09 13:03:32'),(5,'','shivam@zapbuild.com','7c4a8d09ca3762af61e59520943dc26494f8941b','','','','','',0,'Business',1,'0',NULL,0,'2013-06-27 17:28:38','2013-07-09 13:03:32'),(8,'','shivamsharma@zapbuild.com','3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d','','','','','',0,'Business',1,'89036d5348a948e5cf0ffd921769c73e',0,0,'2013-07-01 18:13:39','2013-07-24 17:11:20'),(9,'','zap@zapbuild.com','7c4a8d09ca3762af61e59520943dc26494f8941b','','','','','',0,'Business',0,'eb8344c5b653f1d3068fc1467a3e2314',NULL,0,'2013-07-10 18:04:55','2013-07-10 18:04:55'),(10,'','raju@mailmetrash.com','7c4a8d09ca3762af61e59520943dc26494f8941b','','','','','',0,'Business',1,'0',NULL,0,'2013-07-10 18:06:57','2013-07-10 18:07:21'),(11,'100004346048262','zarajoe11@gmail.com','618deb94b43ef4a81398779343442af231ffb70d','','','','','',0,'Business',1,'',NULL,0,'2013-07-19 22:16:16','2013-07-19 22:16:16'),(12,'','varunjeetsodhi@zapbuild.com','c0b137fe2d792459f26ff763cce44574a5b5ab03','','','','','',0,'Business',1,'0',NULL,0,'2013-07-22 12:14:21','2013-07-22 12:17:12'),(13,'','vijayetaduggal@zapbuild.com','7c4a8d09ca3762af61e59520943dc26494f8941b','','','','','',0,'Business',1,'5511430e5965877b113a7897e1a2dfd0',NULL,0,'2013-07-22 12:26:26','2013-07-22 12:39:48'),(20,'','sandeepkaur@zapbuild.com','7c4a8d09ca3762af61e59520943dc26494f8941b','','','','','',1,'Business',1,'3b76c4534b156fbd32abe64de28ef334',NULL,0,'2013-08-02 16:52:56','2013-08-02 17:07:49');
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

-- Dump completed on 2013-08-03 13:35:33
