-- MariaDB dump 10.19  Distrib 10.4.27-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: molinos
-- ------------------------------------------------------
-- Server version	10.4.27-MariaDB

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
-- Table structure for table `actividad`
--

DROP TABLE IF EXISTS `actividad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actividad` (
  `id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actividad`
--

LOCK TABLES `actividad` WRITE;
/*!40000 ALTER TABLE `actividad` DISABLE KEYS */;
/*!40000 ALTER TABLE `actividad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carritos`
--

DROP TABLE IF EXISTS `carritos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carritos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `total` double NOT NULL,
  `usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `carritos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carritos`
--

LOCK TABLES `carritos` WRITE;
/*!40000 ALTER TABLE `carritos` DISABLE KEYS */;
/*!40000 ALTER TABLE `carritos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carritos_has_productos`
--

DROP TABLE IF EXISTS `carritos_has_productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carritos_has_productos` (
  `Carritos_id` int(11) NOT NULL,
  `Productos_id` int(11) NOT NULL,
  PRIMARY KEY (`Carritos_id`,`Productos_id`),
  KEY `Productos_id` (`Productos_id`),
  CONSTRAINT `carritos_has_productos_ibfk_1` FOREIGN KEY (`Carritos_id`) REFERENCES `carritos` (`id`),
  CONSTRAINT `carritos_has_productos_ibfk_2` FOREIGN KEY (`Productos_id`) REFERENCES `productos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carritos_has_productos`
--

LOCK TABLES `carritos_has_productos` WRITE;
/*!40000 ALTER TABLE `carritos_has_productos` DISABLE KEYS */;
/*!40000 ALTER TABLE `carritos_has_productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imagenes`
--

DROP TABLE IF EXISTS `imagenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imagenes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productos_id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `as` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`id`,`productos_id`),
  KEY `productos_id` (`productos_id`),
  CONSTRAINT `imagenes_ibfk_1` FOREIGN KEY (`productos_id`) REFERENCES `productos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagenes`
--

LOCK TABLES `imagenes` WRITE;
/*!40000 ALTER TABLE `imagenes` DISABLE KEYS */;
INSERT INTO `imagenes` VALUES (1,282,'img/img_20230221030734110d02347280a69c4bede6.jpg','\0'),(2,283,'img/img_20230221031607c702e520fdc143ae5be08e.jpg',''),(3,284,'img/img_20230221042338f931360696bc7213ca567e.jpg',''),(4,284,'img/img_202302210423388737125c92c00869059477.jpg',''),(5,284,'img/img_20230221042338061cc25403ad9a0644c6d8.jpg',''),(6,284,'img/img_2023022104233999a5275278aee81a81842a.jpg',''),(7,284,'img/img_202302210423393f2368bdf23ee712589838.jpg',''),(8,285,'img/img_202302210454055ae15336b25b6bad7f0964.jpg',''),(9,285,'img/img_202302210454057060720c8bf3d5ca6515e6.jpg',''),(10,285,'img/img_20230221045405aa46ed1003a0c771f6b6cc.jpg',''),(11,285,'img/img_202302210454052828565c566cd298c265f6.jpg',''),(12,285,'img/img_20230221045405982c7722e8baa98e7b7e18.jpg',''),(13,286,'img/img_2023022111215193c01cb498f697caa138e8.jpg',''),(14,286,'img/img_20230221112151426b9ba830d66801287899.jpg',''),(15,286,'img/img_20230221112151534a483026b0d5dd7e4653.jpg',''),(16,286,'img/img_202302211121516f7287e4f7dddfe3964866.jpg','');
/*!40000 ALTER TABLE `imagenes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `caracteristicas` varchar(255) NOT NULL,
  `precio` double NOT NULL,
  `stock` int(11) NOT NULL,
  `status` bit(1) NOT NULL,
  `Tipo_Producto_id` int(11) NOT NULL,
  `as` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`id`),
  KEY `Tipo_Producto_id` (`Tipo_Producto_id`),
  CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`Tipo_Producto_id`) REFERENCES `tipo_productos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=287 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,'R-14','Molino eléctrico de uso doméstico utilizado para molienda de nixtamal, elote tierno, granos, chile, cacao, café, queso, etc., con una capacidad de 5 a 15 kg/hr aprox según el producto.','Discos de 3″\nTransmisión de engrane y sinfín\nMotor de 1/3 hp monofásico a 110 volts\nCon aceite para transmisión SN/250',3500,4,'',1,''),(2,'Poleas Cubierto','Molino eléctrico de uso doméstico con protección en la transmisión de bandas y poleas, utilizado para molienda de nixtamal, elote tierno, granos, chile, cacao, café, queso, etc., con una capacidad de 5 a 15 kg/hr aprox según el producto.','Discos de 3″\nTransmisión de poleas\nMotor de 1/3 hp monofásico a 110 volts\nBandas A15\nReja de fierro vaciado',3200,12,'',1,''),(3,'Poleas Descubierto','Molino eléctrico de uso doméstico utilizado para molienda de nixtamal, elote tierno, granos, chile, cacao, café, queso, etc., con una capacidad de 5 a 15 kg/hr aprox según el producto.','Discos de 3″\nTransmisión de poleas y banda\nMotor de 1/3 hp monofásico a 110 volts',3000,3,'',1,''),(4,'Sara 4','Molino eléctrico de uso semi doméstico utilizado para molienda de nixtamal, elote tierno, granos, chile, cacao, café, queso, etc., con una capacidad de 10 a 20 kg/hr aprox. según el producto.','Discos de 4″\nTransmisión de banda y polea\nFabricado en acero\nMotor de 1/2 hp monofásico a 110 volts',5000,4,'',1,''),(5,'Elote tierno','Molino eléctrico para pequeñas industrias, utilizado para molienda de nixtamal, elote tierno, granos, chile, cacao, café, queso, etc., con una capacidad de 10 a 30 kg/hr aprox. según sea el producto.','Discos de 6″\nTransmisión de banda y polea\nFabricado en acero\nMotor de 1 hp monofásico a 110 volts\nCentro de carga con pastilla',6000,3,'',1,''),(6,'R-14','Molino elÃ©ctrico de uso domÃ©stico utilizado para molienda de nixtamal, elote tierno, granos, chile, cacao, cafÃ©, queso, etc., con una capacidad de 5 a 15 kg/hr aprox segÃºn el producto.','Discos de 3â€³\nTransmisiÃ³n de engrane y sinfÃ­n\nMotor de 1/3 hp monofÃ¡sico a 110 volts\nCon aceite para transmisiÃ³n SN/250',3000,4,'',1,''),(7,'Poleas Cubierto','Molino elÃ©ctrico de uso domÃ©stico con protecciÃ³n en la transmisiÃ³n de bandas y poleas, utilizado para molienda de nixtamal, elote tierno, granos, chile, cacao, cafÃ©, queso, etc., con una capacidad de 5 a 15 kg/hr aprox segÃºn el producto.','Discos de 3â€³\nTransmisiÃ³n de poleas\nMotor de 1/3 hp monofÃ¡sico a 110 volts\nBandas A15\nReja de fierro vaciado',3000,12,'',1,''),(8,'Poleas Descubierto','Molino elÃ©ctrico de uso domÃ©stico utilizado para molienda de nixtamal, elote tierno, granos, chile, cacao, cafÃ©, queso, etc., con una capacidad de 5 a 15 kg/hr aprox segÃºn el producto.','Discos de 3â€³\nTransmisiÃ³n de poleas y banda\nMotor de 1/3 hp monofÃ¡sico a 110 volts',3000,3,'',1,''),(9,'Sara 4','Molino elÃ©ctrico de uso semi domÃ©stico utilizado para molienda de nixtamal, elote tierno, granos, chile, cacao, cafÃ©, queso, etc., con una capacidad de 10 a 20 kg/hr aprox. segÃºn el producto.','Discos de 4â€³\nTransmisiÃ³n de banda y polea\nFabricado en acero\nMotor de 1/2 hp monofÃ¡sico a 110 volts',4000,4,'',1,''),(10,'Elote tierno','Molino elÃ©ctrico para pequeÃ±as industrias, utilizado para molienda de nixtamal, elote tierno, granos, chile, cacao, cafÃ©, queso, etc., con una capacidad de 10 a 30 kg/hr aprox. segÃºn sea el producto.','Discos de 6â€³\nTransmisiÃ³n de banda y polea\nFabricado en acero\nMotor de 1 hp monofÃ¡sico a 110 volts\nCentro de carga con pastilla',6000,3,'',1,''),(109,'xdgh','sdfdsf','zxcdsf',45,4576,'',1,''),(133,'redgfv','sdfdsf','zxcdsf',45,4576,'',1,''),(142,'kkkkkkk','sdscxrd','rtryr',567,565,'',2,''),(143,'iiiiii','sdscxrd','rtryr',567,565,'',2,''),(145,'gggggg','sdscxrd','rtryr',567,565,'',2,''),(146,'ttttt','sdscxrd','rtryr',567,565,'',2,''),(148,'zzzzzzzzzzzzzz','sdscxrd','rtryr',567,565,'',2,''),(149,'dsfxcvdf','sdscxrd','rtryr',567,565,'',2,''),(151,'dsfxcvdf','sdscxrd','rtryr',567,565,'',2,''),(152,'weeeeeeee','sdscxrd','rtryr',567,565,'',2,''),(153,'dsfxcvdf','sdscxrd','rtryr',567,565,'',2,''),(154,'rrrrrr','sdscxrd','rtryr',567,565,'',2,''),(157,'dsfxcvdf','sdscxrd','rtryr',567,565,'',2,''),(160,'dsfxcvdf','sdscxrd','rtryr',567,565,'',2,''),(161,'gf','rttryr','wsereyuy',4554,455,'',1,''),(163,'ouuu','rttryr','wsereyuy',4554,455,'',1,''),(164,'gf','rttryr','wsereyuy',4554,455,'',1,''),(166,'gf','rttryr','wsereyuy',4554,455,'',1,''),(170,'gf','rttryr','wsereyuy',4554,455,'',1,''),(171,'gf','rttryr','wsereyuy',4554,455,'',1,''),(172,'gf','rttryr','wsereyuy',4554,455,'',1,''),(174,'gf','rttryr','wsereyuy',4554,455,'',1,'\0'),(175,'gf','rttryr','wsereyuy',4554,455,'',1,'\0'),(176,'gf','rttryr','wsereyuy',4554,455,'',1,'\0'),(177,'gf','rttryr','wsereyuy',4554,455,'',1,'\0'),(178,'gf','rttryr','wsereyuy',4554,455,'',1,'\0'),(179,'gf','rttryr','wsereyuy',4554,455,'',1,'\0'),(180,'gf','rttryr','wsereyuy',4554,455,'',1,''),(181,'gf','rttryr','wsereyuy',4554,455,'',1,'\0'),(182,'gf','rttryr','wsereyuy',4554,455,'',1,''),(183,'gf','rttryr','sd',4554,455,'',1,'\0'),(185,'gf','rttryr','wsereyuy',4554,455,'',1,'\0'),(186,'gf','rttryr','asddfsd',4554,455,'',1,''),(187,'gf','rttryr','wsereyuy',4554,455,'',1,''),(188,'gf','rttryr','wsereyuy',4554,455,'',1,''),(189,'gf','rttryr','wsereyuy',4554,455,'',1,''),(190,'gf','rttryr','wsereyuy',4554,455,'',1,''),(191,'gf','rttryr','wsereyuy',4554,455,'',1,''),(192,'gf','rttryr','wsereyuy',4554,455,'',1,''),(193,'gf','rttryr','wsereyuy',4554,455,'',1,''),(194,'gf','rttryr','wsereyuy',4554,455,'',1,''),(195,'gf','rttryr','wsereyuy',4554,455,'',1,''),(196,'gf','rttryr','wsereyuy',4554,455,'',1,''),(197,'gf','rttryr','wsereyuy',4554,455,'',1,''),(198,'gf','rttryr','wsereyuy',4554,455,'',1,''),(199,'gf','rttryr','wsereyuy',4554,455,'',1,''),(200,'gf','rttryr','wsereyuy',4554,455,'',1,''),(201,'gf','rttryr','wsereyuy',4554,455,'',1,''),(202,'gf','rttryr','wsereyuy',4554,455,'',1,''),(203,'gf','rttryr','wsereyuy',4554,455,'',1,''),(204,'gf','rttryr','wsereyuy',4554,455,'',1,''),(205,'gf','rttryr','wsereyuy',4554,455,'',1,''),(206,'gf','rttryr','wsereyuy',4554,455,'',1,''),(207,'gf','rttryr','wsereyuy',4554,455,'',1,''),(208,'gf','rttryr','wsereyuy',4554,455,'',1,''),(209,'gf','rttryr','wsereyuy',4554,455,'',1,''),(210,'gf','rttryr','wsereyuy',4554,455,'',1,''),(211,'gf','rttryr','wsereyuy',4554,455,'',1,''),(212,'gf','rttryr','wsereyuy',4554,455,'',1,''),(213,'gf','rttryr','wsereyuy',4554,455,'',1,''),(214,'gf','rttryr','wsereyuy',4554,455,'',1,''),(215,'gf','rttryr','wsereyuy',4554,455,'',1,''),(216,'gf','rttryr','wsereyuy',4554,455,'',1,''),(217,'gf','rttryr','wsereyuy',4554,455,'',1,''),(218,'gf','rttryr','wsereyuy',4554,455,'',1,''),(219,'gf','rttryr','wsereyuy',4554,455,'',1,''),(220,'gf','rttryr','wsereyuy',4554,455,'',1,''),(221,'gf','rttryr','wsereyuy',4554,455,'',1,''),(222,'gf','rttryr','wsereyuy',4554,455,'',1,''),(223,'gf','rttryr','wsereyuy',4554,455,'',1,''),(224,'gf','rttryr','wsereyuy',4554,455,'',1,''),(225,'gf','rttryr','wsereyuy',4554,455,'',1,''),(226,'gf','rttryr','wsereyuy',4554,455,'',1,''),(227,'gf','rttryr','wsereyuy',4554,455,'',1,''),(228,'gf','rttryr','wsereyuy',4554,455,'',1,''),(229,'gf','rttryr','wsereyuy',4554,455,'',1,''),(230,'gf','rttryr','wsereyuy',4554,455,'',1,''),(231,'gf','rttryr','wsereyuy',4554,455,'',1,''),(232,'gf','rttryr','wsereyuy',4554,455,'',1,''),(233,'gf','rttryr','wsereyuy',4554,455,'',1,''),(234,'gf','rttryr','wsereyuy',4554,455,'',1,''),(235,'gf','rttryr','wsereyuy',4554,455,'',1,''),(236,'gf','rttryr','wsereyuy',4554,455,'',1,''),(237,'gf','rttryr','wsereyuy',4554,455,'',1,''),(238,'gf','rttryr','wsereyuy',4554,455,'',1,''),(239,'gf','rttryr','wsereyuy',4554,455,'',1,''),(240,'gf','rttryr','wsereyuy',4554,455,'',1,''),(241,'gf','rttryr','wsereyuy',4554,455,'',1,''),(242,'gf','rttryr','wsereyuy',4554,455,'',1,''),(243,'gf','rttryr','wsereyuy',4554,455,'',1,''),(244,'gf','rttryr','wsereyuy',4554,455,'',1,''),(245,'gf','rttryr','wsereyuy',4554,455,'',1,''),(246,'gf','rttryr','wsereyuy',4554,455,'',1,''),(247,'gf','rttryr','wsereyuy',4554,455,'',1,''),(248,'gf','rttryr','wsereyuy',4554,455,'',1,''),(249,'gf','rttryr','wsereyuy',4554,455,'',1,''),(250,'gf','rttryr','wsereyuy',4554,455,'',1,''),(251,'gf','rttryr','wsereyuy',4554,455,'',1,''),(252,'gf','rttryr','wsereyuy',4554,455,'',1,''),(253,'gf','rttryr','wsereyuy',4554,455,'',1,''),(254,'gf','rttryr','wsereyuy',4554,455,'',1,''),(255,'gf','rttryr','wsereyuy',4554,455,'',1,''),(256,'gf','rttryr','wsereyuy',4554,455,'',1,''),(257,'gf','rttryr','wsereyuy',4554,455,'',1,''),(258,'gf','rttryr','wsereyuy',4554,455,'',1,''),(259,'gf','rttryr','wsereyuy',4554,455,'',1,''),(260,'gf','rttryr','wsereyuy',4554,455,'',1,''),(261,'gf','rttryr','wsereyuy',4554,455,'',1,''),(262,'gf','rttryr','wsereyuy',4554,455,'',1,''),(263,'gf','rttryr','wsereyuy',4554,455,'',1,''),(264,'gf','rttryr','wsereyuy',4554,455,'',1,'\0'),(265,'gf','rttryr','wsereyuy',4554,455,'',1,''),(266,'gf','','wsereyuy',4554,455,'',1,''),(267,'gf','rttryr','wsereyuy',4554,455,'',1,''),(272,'sdf','dffd','sfsds',56,676,'',1,''),(273,'34455','refsdfdfs','sdfdsfs',3345,324,'',1,'\0'),(274,'dsghjydfgfv','refsdfdfs','sdfdsfs',3345,324,'',1,''),(275,'Yhg','Hff','Gfhh',35,65,'',2,''),(276,'Yhg','','Gfhh',35,65,'',2,''),(277,'Djs','Ghfkdksxh','JdjJcleknñ',615,2,'',1,'\0'),(278,'Hfg','Yfhh','Yfhhg',985,6,'',3,'\0'),(279,'sdf','dssf','sdfsdf',45,45,'\0',1,''),(280,'dsf','dfdfgdf','dfgd',4,5,'\0',1,''),(281,'45','ads','sdfs',34,4,'\0',1,''),(282,'45','ads','sdfs',34,4,'\0',1,''),(283,'Geh','Bdjdj','Jdjdj',64,6,'',1,''),(284,'ewrwe','dsfssd','asdsad',400,8,'\0',1,''),(285,'dsfsdf','sdsf','dfsf\n',345,4,'\0',1,''),(286,'Hdh','Hdh','Hehwh',9,5,'',2,'');
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger eliminarImagenes before update on productos
for each row
begin
	update imagenes set `as` = 0 where productos_id = (new.id); 
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `tipo_productos`
--

DROP TABLE IF EXISTS `tipo_productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_productos` (
  `id` int(11) NOT NULL,
  `nombre_tipo` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_productos`
--

LOCK TABLES `tipo_productos` WRITE;
/*!40000 ALTER TABLE `tipo_productos` DISABLE KEYS */;
INSERT INTO `tipo_productos` VALUES (1,'Molinos'),(2,'Tortilladora'),(3,'Mezcladora');
/*!40000 ALTER TABLE `tipo_productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipousuarios`
--

DROP TABLE IF EXISTS `tipousuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipousuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_tipo` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipousuarios`
--

LOCK TABLES `tipousuarios` WRITE;
/*!40000 ALTER TABLE `tipousuarios` DISABLE KEYS */;
INSERT INTO `tipousuarios` VALUES (1,'Administrador'),(2,'Usuario');
/*!40000 ALTER TABLE `tipousuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apaterno` varchar(30) DEFAULT NULL,
  `amaterno` varchar(30) DEFAULT NULL,
  `fechaNac` date NOT NULL,
  `mail` varchar(100) NOT NULL,
  `estatus` bit(1) NOT NULL,
  `tipo_usuario_id` int(11) NOT NULL,
  `as` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`id`),
  KEY `tipo_usuario_id` (`tipo_usuario_id`),
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`tipo_usuario_id`) REFERENCES `tipousuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'root','d6ca3fd0c3a3b462ff2b83436dda495e','Silvino','Aguiar',NULL,'2002-01-01','2121100431@soy.utj.edu.mx','',1,'');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios_has_actividad`
--

DROP TABLE IF EXISTS `usuarios_has_actividad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios_has_actividad` (
  `usuarios_id` int(11) NOT NULL,
  `actividad_id` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  PRIMARY KEY (`usuarios_id`,`actividad_id`),
  KEY `actividad_id` (`actividad_id`),
  CONSTRAINT `usuarios_has_actividad_ibfk_1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `usuarios_has_actividad_ibfk_2` FOREIGN KEY (`actividad_id`) REFERENCES `actividad` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios_has_actividad`
--

LOCK TABLES `usuarios_has_actividad` WRITE;
/*!40000 ALTER TABLE `usuarios_has_actividad` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuarios_has_actividad` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-02-21 14:14:38
