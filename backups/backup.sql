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
  `total` double DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `carritos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carritos`
--

LOCK TABLES `carritos` WRITE;
/*!40000 ALTER TABLE `carritos` DISABLE KEYS */;
INSERT INTO `carritos` VALUES (1,3200,1);
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
  `cantidad` int(11) NOT NULL,
  `as` bit(1) NOT NULL,
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
INSERT INTO `carritos_has_productos` VALUES (1,1,1,'\0'),(1,2,1,''),(1,4,1,'\0'),(1,5,1,'\0');
/*!40000 ALTER TABLE `carritos_has_productos` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER total
AFTER insert ON carritos_has_productos
FOR EACH ROW
BEGIN
    DECLARE totalCarrito int;
    declare precioProducto double;
-- Código para ejecutar cuando se activa el trigger
	SELECT total INTO totalCarrito FROM carritos WHERE id = new.Carritos_id;
	SELECT precio INTO precioProducto FROM productos WHERE id = new.Productos_id;
	UPDATE carritos SET total = ((precioProducto*new.cantidad)+totalCarrito) WHERE id = NEW.Carritos_id;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER total_Update
AFTER update ON carritos_has_productos
FOR EACH ROW
BEGIN
    DECLARE totalCarrito int;
    declare precioProducto double;
-- Código para ejecutar cuando se activa el trigger
	IF new.as = 1 then
        SELECT SUM(p.precio * cp.cantidad) into totalcarrito
			FROM carritos_has_productos as cp
			INNER JOIN productos as p ON cp.productos_id = p.id
			WHERE cp.carritos_id = new.Carritos_id and cp.`as` = 1;
        
		UPDATE carritos SET total = totalCarrito WHERE id = NEW.Carritos_id;
    ELSE
		SELECT total INTO totalCarrito FROM carritos WHERE id = new.Carritos_id;
        SELECT precio INTO precioProducto FROM productos WHERE id = new.Productos_id;
        
        UPDATE carritos SET total = (totalCarrito-(precioProducto*new.cantidad)) WHERE id = NEW.Carritos_id;
    end if  ;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagenes`
--

LOCK TABLES `imagenes` WRITE;
/*!40000 ALTER TABLE `imagenes` DISABLE KEYS */;
INSERT INTO `imagenes` VALUES (1,1,'img/img_20230303012451ca61d7beb1cfa933991955.jpg','\0'),(2,2,'img/img_202303030125138166116a071d31037e22ea.png',''),(3,4,'img/img_202303030126088993c5e159eb58a3feb195.jpg',''),(4,5,'img/img_2023030301262218566c5125483605447368.jpg',''),(5,5,'img/img_202303030126221dcdca7fb90546f26c3ddd.jpg',''),(6,6,'img/img_20230303012842c9bf8a59878270e606cd13.jpg','\0');
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,'R-14','Molino eléctrico de uso doméstico utilizado para molienda de nixtamal, elote tierno, granos, chile, cacao, café, queso, etc., con una capacidad de 5 a 15 kg/hr aprox según el producto.','Discos de 3″\nTransmisión de engrane y sinfín\nMotor de 1/3 hp monofásico a 110 volts\nCon aceite para transmisión SN/250',3500,4,'',1,''),(2,'Poleas Cubierto','Molino eléctrico de uso doméstico con protección en la transmisión de bandas y poleas, utilizado para molienda de nixtamal, elote tierno, granos, chile, cacao, café, queso, etc., con una capacidad de 5 a 15 kg/hr aprox según el producto.','Discos de 3″\nTransmisión de poleas\nMotor de 1/3 hp monofásico a 110 volts\nBandas A15\nReja de fierro vaciado',3200,12,'',1,''),(3,'Poleas Descubierto','Molino eléctrico de uso doméstico utilizado para molienda de nixtamal, elote tierno, granos, chile, cacao, café, queso, etc., con una capacidad de 5 a 15 kg/hr aprox según el producto.','Discos de 3″\nTransmisión de poleas y banda\nMotor de 1/3 hp monofásico a 110 volts',3000,3,'',1,''),(4,'Sara 4','Molino eléctrico de uso semi doméstico utilizado para molienda de nixtamal, elote tierno, granos, chile, cacao, café, queso, etc., con una capacidad de 10 a 20 kg/hr aprox. según el producto.','Discos de 4″\nTransmisión de banda y polea\nFabricado en acero\nMotor de 1/2 hp monofásico a 110 volts',5000,4,'',1,''),(5,'Elote tierno','Molino eléctrico para pequeñas industrias, utilizado para molienda de nixtamal, elote tierno, granos, chile, cacao, café, queso, etc., con una capacidad de 10 a 30 kg/hr aprox. según sea el producto.','Discos de 6″\nTransmisión de banda y polea\nFabricado en acero\nMotor de 1 hp monofásico a 110 volts\nCentro de carga con pastilla',6000,3,'',1,''),(6,'AMASDORA','poiuy','oiuyt',15000,1,'',3,'\0');
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

-- Dump completed on 2023-03-04  0:07:44
