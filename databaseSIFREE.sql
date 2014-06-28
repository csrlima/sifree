CREATE DATABASE  IF NOT EXISTS `dbsifreev1` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `dbsifreev1`;
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: xmpp.radiomarketbeat.com    Database: dbsifreev1
-- ------------------------------------------------------
-- Server version	5.5.28-0ubuntu0.12.04.3

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
-- Table structure for table `categorias_equipos`
--

DROP TABLE IF EXISTS `categorias_equipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorias_equipos` (
  `id_categoria_equipo` int(11) NOT NULL AUTO_INCREMENT COMMENT 'LLave principal que contiene el id único de cada categoria de tipo de equipo.',
  `nombre_categoria_equipo` varchar(45) NOT NULL COMMENT 'Campo que almacena el nombre de la categoria de equipo.',
  `descrip_categoria_equipo` varchar(300) DEFAULT NULL COMMENT 'Campo que almacena la descripcion completa de la categoria de equipo.',
  `prefijo_id_categoria_equipo` varchar(4) NOT NULL COMMENT 'Campo que contiene el prefijo que se le concatena al id de cada equipo.',
  `componente_agente` int(11) DEFAULT '0',
  PRIMARY KEY (`id_categoria_equipo`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='Tabla que contiene los datos de las categorias o tipos de equipos que se tienen.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias_equipos`
--

LOCK TABLES `categorias_equipos` WRITE;
/*!40000 ALTER TABLE `categorias_equipos` DISABLE KEYS */;
INSERT INTO `categorias_equipos` VALUES (1,'Radio Internet','Radio wifi por showcast','RAI',0),(2,'Amplificador','Amplificador de audio','AMP',0),(4,'Router 3G','Router de Internet para modem 3G','R3G',0),(10,'Memoria SD','Memoria SD CARD','MSD',1),(11,'Adaptador USB Wireless','Targeta WIFI vÃ­a USB','AUW',1),(12,'Cargador de Agente','Brinda la alimentaciÃ³n elÃ©ctrica al agente.','CAG',1),(13,'Agente MB','Equipo multifuncional compuesto por varias partes','MB',0),(14,'Router WIFI','Dispositivo que emite seÃ±al wifi','RWF',0),(15,'Modem 3G','Model USB 3G','M3G',0);
/*!40000 ALTER TABLE `categorias_equipos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT COMMENT 'LLave principal que contiene el id único de cada cliente.',
  `nombre_cliente` varchar(45) NOT NULL COMMENT 'Campo que contiene el nombre del cliente.',
  `descrip_cliente` varchar(150) DEFAULT NULL,
  `id_pais` int(11) DEFAULT NULL COMMENT 'Llave foránea que vincula al cliente con un país.',
  PRIMARY KEY (`id_cliente`),
  KEY `fk_clientes_paises_idx` (`id_pais`),
  CONSTRAINT `fk_clientes_paises` FOREIGN KEY (`id_pais`) REFERENCES `paises` (`id_pais`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='Tabla donde se almacena la información de los clientes.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (2,'Super Shoes GT','Zapateria en Guatemala',2),(6,'Super Shoes SV','Zapaterias en El Salvador',1),(7,'La Pasta','Restaurante italiano.',1),(9,'Pizza Nica','Restaurante de comida rÃ¡pida.',4),(12,'Hyper Tienda Catracho','Tiendas de artÃ­culos de consumo.',6),(13,'Tiendas CC','Tiendas de artÃ­culos de consumo',7),(21,'Despensas La Oferta','Venta de articulos',1),(22,'Pizzeria Alfredo','Pizzeria',1);
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `componentes_agentes`
--

DROP TABLE IF EXISTS `componentes_agentes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `componentes_agentes` (
  `id_com_agente` varchar(15) NOT NULL,
  `fecha_ingreso_com_agente` date DEFAULT NULL,
  `estado_com_agente` varchar(45) DEFAULT NULL,
  `actividad_com_agente` varchar(45) DEFAULT NULL,
  `costo_com_agente` double(8,2) DEFAULT NULL,
  `id_modelo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_com_agente`),
  KEY `fk_componentes_agentes_modelos_idx` (`id_modelo`),
  CONSTRAINT `fk_componentes_agentes_a_modelos` FOREIGN KEY (`id_modelo`) REFERENCES `modelos` (`id_modelo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `componentes_agentes`
--

LOCK TABLES `componentes_agentes` WRITE;
/*!40000 ALTER TABLE `componentes_agentes` DISABLE KEYS */;
INSERT INTO `componentes_agentes` VALUES ('AUW-0001','2014-06-28','Correcto','Activo',11.50,17),('AUW-0002','2014-06-28','Correcto','Stock',13.00,16),('AUW-0003','2014-06-28','Correcto','Stock',12.00,17),('CAG-0001','2014-04-24','Correcto','Inactivo',6.30,7),('CAG-0002','2014-04-24','Correcto','Activo',6.30,7),('MSD-0001','2014-04-24','Correcto','Activo',14.20,8),('MSD-0002','2014-04-24','Inservible','Inactivo',14.20,8),('MSD-0003','2014-06-28','Correcto','Inactivo',22.10,8);
/*!40000 ALTER TABLE `componentes_agentes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `det_componentes_agentes`
--

DROP TABLE IF EXISTS `det_componentes_agentes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `det_componentes_agentes` (
  `id_det_com_agente` int(11) NOT NULL AUTO_INCREMENT,
  `id_equipo` varchar(15) DEFAULT NULL,
  `id_com_agente` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id_det_com_agente`),
  KEY `fk_det_componentes_agentes_a_equipos_idx` (`id_equipo`),
  KEY `fk_det_componentes_agentes_a_comp_agentes_idx` (`id_com_agente`),
  CONSTRAINT `fk_det_componentes_agentes_a_comp_agentes` FOREIGN KEY (`id_com_agente`) REFERENCES `componentes_agentes` (`id_com_agente`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_det_componentes_agentes_a_equipos` FOREIGN KEY (`id_equipo`) REFERENCES `equipos` (`id_equipo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `det_componentes_agentes`
--

LOCK TABLES `det_componentes_agentes` WRITE;
/*!40000 ALTER TABLE `det_componentes_agentes` DISABLE KEYS */;
INSERT INTO `det_componentes_agentes` VALUES (10,'MB-0001','MSD-0001'),(15,'MB-0001','AUW-0001'),(17,'MB-0001','CAG-0002');
/*!40000 ALTER TABLE `det_componentes_agentes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `det_equipos_sucursales`
--

DROP TABLE IF EXISTS `det_equipos_sucursales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `det_equipos_sucursales` (
  `id_det_equipo_sucursal` int(11) NOT NULL AUTO_INCREMENT COMMENT 'LLave principal que contiene el id único de cada detalle de equipo por sucursal.',
  `id_equipo` varchar(45) DEFAULT NULL COMMENT 'LLave foránea que vincula al equipo con la sucursal.',
  `id_sucursal` int(11) DEFAULT NULL COMMENT 'LLave foránea que vincula a la sucursal con el equipo.',
  PRIMARY KEY (`id_det_equipo_sucursal`),
  KEY `fk_det_equipos_sucursales_equipos_idx` (`id_equipo`),
  KEY `fk_det_equipos_sucursales_sucursales_idx` (`id_sucursal`),
  CONSTRAINT `fk_det_equipos_sucursales_equipos` FOREIGN KEY (`id_equipo`) REFERENCES `equipos` (`id_equipo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_det_equipos_sucursales_sucursales` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursales` (`id_sucursal`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8 COMMENT='Tabla que contiene la información del detalle de la ubicacion de los equipos en las sucursales en la actualidad.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `det_equipos_sucursales`
--

LOCK TABLES `det_equipos_sucursales` WRITE;
/*!40000 ALTER TABLE `det_equipos_sucursales` DISABLE KEYS */;
INSERT INTO `det_equipos_sucursales` VALUES (52,'RAI-0011',7),(54,'RAI-0012',6),(55,'RAI-0013',2),(56,'RTG-0002',2),(57,'RAI-0003',8),(59,'RAI-0007',13),(66,'AMP-0001',7),(68,'RWF-0001',7),(69,'AMP-0002',6),(70,'RWF-0002',6),(71,'AMP-0003',2),(72,'RWF-0003',2),(73,'RWF-0004',8),(74,'RWF-0008',9),(75,'RWF-0009',10),(78,'RAI-0019',9),(79,'RAI-0018',10),(80,'RAI-0016',11),(81,'RAI-0015',12),(82,'RAI-0014',14),(83,'RAI-0008',16);
/*!40000 ALTER TABLE `det_equipos_sucursales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `det_paises_usuarios`
--

DROP TABLE IF EXISTS `det_paises_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `det_paises_usuarios` (
  `id_det_pais_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `id_pais` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_det_pais_usuario`),
  KEY `fk_det_paises_usuarios_paises_idx` (`id_pais`),
  KEY `fk_det_paises_usuarios_usuarios_idx` (`id_usuario`),
  CONSTRAINT `fk_det_paises_usuarios_paises` FOREIGN KEY (`id_pais`) REFERENCES `paises` (`id_pais`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_det_paises_usuarios_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `det_paises_usuarios`
--

LOCK TABLES `det_paises_usuarios` WRITE;
/*!40000 ALTER TABLE `det_paises_usuarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `det_paises_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `det_recomendaciones_problemas`
--

DROP TABLE IF EXISTS `det_recomendaciones_problemas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `det_recomendaciones_problemas` (
  `id_det_recomendaciones_problemas` int(11) NOT NULL AUTO_INCREMENT,
  `id_problema` int(11) NOT NULL,
  `id_rec_accion_soporte` int(11) NOT NULL,
  PRIMARY KEY (`id_det_recomendaciones_problemas`),
  KEY `fk_det_recomendaciones_problemas_problemas_idx` (`id_problema`),
  KEY `fk_det_recomendaciones_problemas_recomendaciones_idx` (`id_rec_accion_soporte`),
  CONSTRAINT `fk_det_recomendaciones_problemas_recomendaciones` FOREIGN KEY (`id_rec_accion_soporte`) REFERENCES `recomendaciones_acciones_soportes` (`id_rec_accion_soporte`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_det_recomendaciones_problemas_problemas` FOREIGN KEY (`id_problema`) REFERENCES `problemas` (`id_problema`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `det_recomendaciones_problemas`
--

LOCK TABLES `det_recomendaciones_problemas` WRITE;
/*!40000 ALTER TABLE `det_recomendaciones_problemas` DISABLE KEYS */;
INSERT INTO `det_recomendaciones_problemas` VALUES (14,1,1),(15,1,2),(16,1,4),(17,3,1),(18,3,4),(19,4,4),(20,6,1),(21,6,2),(22,6,4),(23,7,1),(24,7,4);
/*!40000 ALTER TABLE `det_recomendaciones_problemas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `det_reingreso_inventario_equipo`
--

DROP TABLE IF EXISTS `det_reingreso_inventario_equipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `det_reingreso_inventario_equipo` (
  `id_det_reingreso_inv_equipo` int(11) NOT NULL AUTO_INCREMENT COMMENT 'LLave principal que contiene el id único de cada detalle de reingreso al inventario de los equipos.',
  `descrip_reingreso_inv_equipo` varchar(300) NOT NULL COMMENT 'Campo que brinda una descripcion o motivo de reingreso de un equipo al inventario.',
  `id_equipo` varchar(45) DEFAULT NULL COMMENT 'Llave foránea que relaciona un detalle de reingreso de equipo a un equipo en especifico.',
  PRIMARY KEY (`id_det_reingreso_inv_equipo`),
  KEY `fk_det_reingreso_inventario_equipo_equipos_idx` (`id_equipo`),
  CONSTRAINT `fk_det_reingreso_inventario_equipo_equipos` FOREIGN KEY (`id_equipo`) REFERENCES `equipos` (`id_equipo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla que almacena el detalle del motivo del reingreso de un equipo al inventario.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `det_reingreso_inventario_equipo`
--

LOCK TABLES `det_reingreso_inventario_equipo` WRITE;
/*!40000 ALTER TABLE `det_reingreso_inventario_equipo` DISABLE KEYS */;
/*!40000 ALTER TABLE `det_reingreso_inventario_equipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diagnostico_danios`
--

DROP TABLE IF EXISTS `diagnostico_danios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `diagnostico_danios` (
  `id_diagnostico_danio` int(11) NOT NULL AUTO_INCREMENT COMMENT 'LLave principal que contiene el id único de cada diagnostico de danos que se le realiza a los equipos danados.',
  `descrip_diagnostico_danio` varchar(300) NOT NULL COMMENT 'Campo que muestra la información detallada del dano del equipo.',
  `fecha_diagnostio_danio` date NOT NULL,
  `id_tipo_danio` int(11) DEFAULT NULL,
  `id_equipo` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id_diagnostico_danio`),
  KEY `fk_diagnostico_danios_tipos_danios_idx` (`id_tipo_danio`),
  KEY `fk_diagnostico_danios_equipos_idx` (`id_equipo`),
  CONSTRAINT `fk_diagnostico_danios_equipos` FOREIGN KEY (`id_equipo`) REFERENCES `equipos` (`id_equipo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_diagnostico_danios_tipos_danios` FOREIGN KEY (`id_tipo_danio`) REFERENCES `tipos_danios` (`id_tipo_danio`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='Tabla con los datos detallados del diagnostico del dano del equipo.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diagnostico_danios`
--

LOCK TABLES `diagnostico_danios` WRITE;
/*!40000 ALTER TABLE `diagnostico_danios` DISABLE KEYS */;
INSERT INTO `diagnostico_danios` VALUES (1,'Pantalla del radio se queda en azul, y el mismo no responde.','2014-04-28',1,'RAI-0002'),(4,'No emite seÃ±al WIFI','2014-04-28',1,'RTG-0001'),(6,'No inicia el sistema correctamente.','2014-06-28',1,'RAI-0019');
/*!40000 ALTER TABLE `diagnostico_danios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipos`
--

DROP TABLE IF EXISTS `equipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipos` (
  `id_equipo` varchar(15) NOT NULL COMMENT 'LLave principal que contiene el id único de cada equipo. Este id lleva prefijo.',
  `fecha_ingreso_equipo` date NOT NULL COMMENT 'Campo que contiene la fecha en que el equipo ingresó al inventario.',
  `estado_equipo` enum('Correcto','Defectuoso','Inservible') NOT NULL COMMENT 'Campo de valor restringido que indica el estado físico del equipo.',
  `actividad_equipo` enum('Activo','Inactivo','Instalado','Stock') NOT NULL COMMENT 'Campo de valor restringido que muestra el estado del equipo, si esta activo en una sucursal o inactivo en las oficinas centrales.',
  `costo_equipo` double(8,2) NOT NULL COMMENT 'Campo en el que se almacena el costo de cada equipo.',
  `id_modelo` int(11) DEFAULT NULL COMMENT 'LLave foránea que relaciona el equipo con un modelo de equipo.',
  PRIMARY KEY (`id_equipo`),
  KEY `fk_equipos_tipos_equipo_idx` (`id_modelo`),
  CONSTRAINT `fk_equipos_modelos` FOREIGN KEY (`id_modelo`) REFERENCES `modelos` (`id_modelo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla con la información de los equipos de servicio que se brindan en comodatos a las sucursales de los clientes.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipos`
--

LOCK TABLES `equipos` WRITE;
/*!40000 ALTER TABLE `equipos` DISABLE KEYS */;
INSERT INTO `equipos` VALUES ('AMP-0001','2014-06-26','Correcto','Instalado',80.56,14),('AMP-0002','2014-06-26','Correcto','Instalado',80.56,14),('AMP-0003','2014-06-26','Correcto','Instalado',80.56,14),('AMP-0004','2014-06-26','Correcto','Stock',99.00,15),('AMP-0005','2014-06-26','Correcto','Stock',99.99,15),('MB-0001','2014-04-24','Correcto','Stock',0.00,9),('MG-0001','2014-06-26','Correcto','Stock',14.00,18),('MG-0002','2014-06-26','Correcto','Stock',14.00,19),('MG-0003','2014-06-26','Correcto','Stock',14.00,19),('MG-0004','2014-06-26','Correcto','Stock',14.00,18),('MG-0005','2014-06-26','Correcto','Stock',14.00,18),('MG-0006','2014-06-26','Correcto','Stock',15.00,19),('RAI-0001','2014-04-23','Defectuoso','Stock',73.10,1),('RAI-0002','2014-04-14','Inservible','Stock',70.11,1),('RAI-0003','2014-04-23','Correcto','Instalado',70.10,1),('RAI-0005','2014-04-14','Correcto','Stock',70.10,1),('RAI-0006','2014-04-29','Correcto','Stock',70.00,1),('RAI-0007','2014-04-29','Correcto','Instalado',60.00,12),('RAI-0008','2014-04-29','Correcto','Instalado',60.00,12),('RAI-0009','2014-04-29','Correcto','Stock',60.00,12),('RAI-0010','2014-04-29','Correcto','Stock',60.00,12),('RAI-0011','2014-04-29','Correcto','Instalado',55.00,13),('RAI-0012','2014-04-29','Correcto','Instalado',55.00,13),('RAI-0013','2014-04-29','Correcto','Instalado',55.00,13),('RAI-0014','2014-04-29','Correcto','Instalado',55.00,13),('RAI-0015','2014-04-29','Correcto','Instalado',55.00,13),('RAI-0016','2014-04-29','Correcto','Instalado',55.00,13),('RAI-0018','2014-04-29','Correcto','Instalado',55.00,13),('RAI-0019','2014-04-29','Correcto','Instalado',55.00,13),('RTG-0001','2014-04-23','Correcto','Stock',37.00,4),('RTG-0002','2014-06-26','Correcto','Stock',25.00,5),('RWF-0001','2014-04-29','Correcto','Instalado',20.00,10),('RWF-0002','2014-04-29','Correcto','Instalado',20.00,10),('RWF-0003','2014-04-29','Correcto','Instalado',20.00,10),('RWF-0004','2014-04-29','Correcto','Instalado',20.00,10),('RWF-0005','2014-04-29','Correcto','Stock',20.00,10),('RWF-0006','2014-04-29','Correcto','Stock',20.00,10),('RWF-0007','2014-06-26','Correcto','Stock',21.00,10),('RWF-0008','2014-06-26','Correcto','Instalado',21.00,11),('RWF-0009','2014-06-26','Correcto','Instalado',21.00,11),('RWF-0010','2014-06-26','Correcto','Stock',21.00,11),('RWF-0011','2014-06-28','Correcto','Stock',30.00,10);
/*!40000 ALTER TABLE `equipos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historial_equipos_sucursales`
--

DROP TABLE IF EXISTS `historial_equipos_sucursales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `historial_equipos_sucursales` (
  `id_historial_equipo_sucursal` int(11) NOT NULL AUTO_INCREMENT COMMENT 'LLave principal que contiene el id único de cada detalle del historiald de ubicación del equipo.',
  `id_equipo` varchar(45) NOT NULL COMMENT 'LLave foránea que vincula al equipo con la sucursal.',
  `id_sucursal` int(11) NOT NULL COMMENT 'LLave foránea que vincula la sucursal con el equipo.',
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date DEFAULT NULL,
  PRIMARY KEY (`id_historial_equipo_sucursal`),
  KEY `fk_historial_equipos_sucursales_equipos_idx` (`id_equipo`),
  KEY `fk_historial_equipos_sucursales_sucursales_idx` (`id_sucursal`),
  CONSTRAINT `fk_historial_equipos_sucursales_equipos` FOREIGN KEY (`id_equipo`) REFERENCES `equipos` (`id_equipo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_historial_equipos_sucursales_sucursales` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursales` (`id_sucursal`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COMMENT='Tabla que contiene el detalle del historial de las ubicaciones de los equipos en las sucursales.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial_equipos_sucursales`
--

LOCK TABLES `historial_equipos_sucursales` WRITE;
/*!40000 ALTER TABLE `historial_equipos_sucursales` DISABLE KEYS */;
INSERT INTO `historial_equipos_sucursales` VALUES (1,'RAI-0002',6,'2013-01-01','2013-10-25'),(2,'RAI-0002',7,'2013-11-01','2013-12-31'),(4,'RWF-0003',8,'2014-05-18','2014-05-18'),(5,'RAI-0011',8,'2014-05-18','0000-00-00'),(6,'RWF-0003',8,'2014-05-18','0000-00-00'),(7,'RAI-0003',9,'2014-05-18','0000-00-00'),(8,'RWF-0004',9,'2014-05-18','0000-00-00'),(9,'RWF-0005',7,'2014-05-18','0000-00-00'),(10,'RAI-0007',7,'2014-05-18','0000-00-00'),(11,'RAI-0012',2,'2014-05-18','0000-00-00'),(12,'RAI-0010',9,'2014-05-25','2014-05-25'),(13,'RWF-0006',2,'2014-06-18','2014-06-18'),(14,'RAI-0013',6,'2014-06-21','0000-00-00'),(15,'AMP-0001',7,'2014-06-26','2014-06-26'),(16,'AMP-0001',7,'2014-06-26','0000-00-00'),(17,'RWF-0001',7,'2014-06-26','2014-06-26'),(18,'RWF-0001',7,'2014-06-26','0000-00-00'),(19,'AMP-0002',6,'2014-06-26','0000-00-00'),(20,'RWF-0002',6,'2014-06-26','0000-00-00'),(21,'AMP-0003',2,'2014-06-26','0000-00-00'),(24,'RWF-0008',9,'2014-06-26','0000-00-00'),(25,'RWF-0009',10,'2014-06-26','0000-00-00'),(26,'RTG-0001',7,'2014-06-26','2014-06-26'),(27,'MG-0001',7,'2014-06-26','2014-06-26'),(28,'RAI-0019',9,'2014-06-26','0000-00-00'),(29,'RAI-0018',10,'2014-06-26','0000-00-00'),(30,'RAI-0016',11,'2014-06-26','0000-00-00'),(31,'RAI-0015',12,'2014-06-26','0000-00-00'),(32,'RAI-0014',14,'2014-06-26','0000-00-00'),(33,'RAI-0008',16,'2014-06-28','0000-00-00');
/*!40000 ALTER TABLE `historial_equipos_sucursales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marcas`
--

DROP TABLE IF EXISTS `marcas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `marcas` (
  `id_marca` int(11) NOT NULL AUTO_INCREMENT COMMENT 'LLave principal que contiene el id único de cada marca de los equipos.',
  `nombre_marca` varchar(45) NOT NULL COMMENT 'Campo que contiene el nombre de la marca de los que puede pertenecer el equipo.',
  PRIMARY KEY (`id_marca`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='Tabla que contiene la informacion de las marcas de los equipos.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marcas`
--

LOCK TABLES `marcas` WRITE;
/*!40000 ALTER TABLE `marcas` DISABLE KEYS */;
INSERT INTO `marcas` VALUES (1,'Sony'),(2,'Sandisk'),(3,'Grace'),(5,'Nexxt'),(7,'TP-Link'),(8,'Motorola'),(9,'Transcend'),(10,'Agente Market Beat'),(11,'Huawei'),(12,'ZTE');
/*!40000 ALTER TABLE `marcas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modelos`
--

DROP TABLE IF EXISTS `modelos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modelos` (
  `id_modelo` int(11) NOT NULL AUTO_INCREMENT COMMENT 'LLave principal que contiene el id único de cada modelo de equipo.',
  `nombre_modelo` varchar(45) NOT NULL COMMENT 'Campo que almacena el nombre o serie del modelo de equipo.',
  `id_marca` int(11) DEFAULT NULL COMMENT 'Llave foránea que relaciona el modelo con una marca.',
  `id_categoria_equipo` int(11) DEFAULT NULL COMMENT 'LLave foránea que vincula al modelo con una categoria de equipo.',
  PRIMARY KEY (`id_modelo`),
  KEY `fk_modelos_marcas_idx` (`id_marca`),
  KEY `fk_modelos_categorias_equipos1_idx` (`id_categoria_equipo`),
  CONSTRAINT `fk_modelos_categorias_equipos` FOREIGN KEY (`id_categoria_equipo`) REFERENCES `categorias_equipos` (`id_categoria_equipo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_modelos_marcas` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id_marca`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='Tabla que contiene la información de los modelos de las marcas de los equipos.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modelos`
--

LOCK TABLES `modelos` WRITE;
/*!40000 ALTER TABLE `modelos` DISABLE KEYS */;
INSERT INTO `modelos` VALUES (1,'GDI-IRA500',3,1),(4,'Viking 150 3g/4g InalÃ¡mbrico',5,4),(5,'Polaris 150 NW230NXT90',5,4),(7,'MC8080',8,12),(8,'SDHC10 16GB',9,10),(9,'VersiÃ³n 1',10,13),(10,'TL-WR340G',7,14),(11,'ARN00154UA',5,14),(12,'GDI-IR2500',3,1),(13,'GDI-IR2000',3,1),(14,'XZ300',1,2),(15,'XPLOD9600',1,2),(16,'UHG',11,11),(17,'HDE-455',5,11),(18,'DR3G88120',12,15),(19,'EWS34FG',11,15);
/*!40000 ALTER TABLE `modelos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paises`
--

DROP TABLE IF EXISTS `paises`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paises` (
  `id_pais` int(11) NOT NULL AUTO_INCREMENT COMMENT 'LLave principal que contiene el id único de cada país.',
  `nombre_pais` varchar(45) NOT NULL COMMENT 'Campo que contiene el nombre de país.',
  PRIMARY KEY (`id_pais`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='Tabla donde se almacenan los paises.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paises`
--

LOCK TABLES `paises` WRITE;
/*!40000 ALTER TABLE `paises` DISABLE KEYS */;
INSERT INTO `paises` VALUES (1,'El Salvador'),(2,'Guatemala'),(4,'Nicaragua'),(6,'Honduras'),(7,'Costa Rica'),(8,'PanamÃ¡');
/*!40000 ALTER TABLE `paises` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `problemas`
--

DROP TABLE IF EXISTS `problemas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `problemas` (
  `id_problema` int(11) NOT NULL AUTO_INCREMENT COMMENT 'LLave principal que contiene el id único de cada problema.',
  `nombre_problema` varchar(45) NOT NULL COMMENT 'Campo que indica el nombre del problema.',
  `descrip_problema` varchar(300) DEFAULT NULL COMMENT 'Campo que detalla y describe ampliamente el problema.',
  PRIMARY KEY (`id_problema`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='Tabla donde se almacenan los tipos de probremas que pueden generarse en un soporte.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `problemas`
--

LOCK TABLES `problemas` WRITE;
/*!40000 ALTER TABLE `problemas` DISABLE KEYS */;
INSERT INTO `problemas` VALUES (1,'SeÃ±al de internet','No se recibe seÃ±al de internet'),(3,'Radio no enciende','La radio no enciende, ni muestra seÃ±ales de actividad'),(4,'Cargador daÃ±ado','Los cargadores de alimentaciÃ³n elÃ©ctrica estÃ¡n daÃ±ados.'),(5,'Radio Desconfigurada','La radio no esta configurada correctamente en la radio correspondiente'),(6,'No hay seÃ±al WIFI','La red WIFI para la radio no se encuentra'),(7,'Amplificador de Audio','El amplificador de audio no funciona correctamente'),(8,'Cables de audio defectuosos','Los cables de audio estÃ¡n daÃ±ados'),(9,'InstalaciÃ³n de equipos','Se realiza cuando la sucursal necesita la instaciÃ³n de un nuevo equipo.'),(10,'Cambio de equipo','Se realiza cuando se necesita hacer un cambio de equipo.'),(11,'DesinstaciÃ³n de equipo','Se realiza cuando los equipos de la tienda deben ser retirados.');
/*!40000 ALTER TABLE `problemas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedores_internet`
--

DROP TABLE IF EXISTS `proveedores_internet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proveedores_internet` (
  `id_proveedor_internet` int(11) NOT NULL AUTO_INCREMENT COMMENT 'LLave principal que contiene el id único de cada proveedor de internet.',
  `nombre_proveedor_internet` varchar(45) NOT NULL COMMENT 'Campo que contiene el nombre del proveedor de internet.',
  `telefono_proveedor_internet` varchar(14) DEFAULT NULL COMMENT 'Campo que contiene el numero telefonico de contacto del proveedor de internet.',
  `id_pais` int(11) DEFAULT NULL COMMENT 'LLave foránea que vincula al proveedor de internet con un pais.',
  PRIMARY KEY (`id_proveedor_internet`),
  KEY `fk_proveedores_internet_paises_idx` (`id_pais`),
  CONSTRAINT `fk_proveedores_internet_paises` FOREIGN KEY (`id_pais`) REFERENCES `paises` (`id_pais`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='Tabla que contiene los datos básicos de los proveedores de internet en las sucursales.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedores_internet`
--

LOCK TABLES `proveedores_internet` WRITE;
/*!40000 ALTER TABLE `proveedores_internet` DISABLE KEYS */;
INSERT INTO `proveedores_internet` VALUES (1,'Rigo','2',2),(5,'Charo','2',2),(6,'Rigo','1',1),(12,'Charo','1',1),(13,'MIBW','4',4),(14,'Charo','7',7),(15,'WIPA','8',8),(16,'Rigo','6',6);
/*!40000 ALTER TABLE `proveedores_internet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recomendaciones_acciones_soportes`
--

DROP TABLE IF EXISTS `recomendaciones_acciones_soportes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recomendaciones_acciones_soportes` (
  `id_rec_accion_soporte` int(11) NOT NULL AUTO_INCREMENT COMMENT 'LLave principal que contiene el id único de cada categoria de acción de soporte.',
  `nombre_rec_accion_soporte` varchar(45) NOT NULL COMMENT 'Campo que contiene el nombre de la categoria de acción de soporte.',
  `descripcion_rec_accion_soporte` varchar(600) DEFAULT NULL COMMENT 'Campo que describe y detalla ampliamente la categoria de acción de soporte.',
  PRIMARY KEY (`id_rec_accion_soporte`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='Tabla donde se almacenan las categorias o tipos de acciones que se realizan comúnmente en un soporte. Servira como guia y factor estadístico.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recomendaciones_acciones_soportes`
--

LOCK TABLES `recomendaciones_acciones_soportes` WRITE;
/*!40000 ALTER TABLE `recomendaciones_acciones_soportes` DISABLE KEYS */;
INSERT INTO `recomendaciones_acciones_soportes` VALUES (1,'Reiniciar los equipos','Consiste en desconectar los equipos de toma electrico'),(2,'Revisar el cable que va del modem al router.','Verificar si el cable RJ45 que sale del cable modem esta conectado en el puerto correcto del router.'),(4,'Revisar el cableado','Detectar si el cableado esta conectado en los puertos correctos o si algÃºn cable tiene un defecto.');
/*!40000 ALTER TABLE `recomendaciones_acciones_soportes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reparaciones_equipos`
--

DROP TABLE IF EXISTS `reparaciones_equipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reparaciones_equipos` (
  `id_reparacion_equipo` int(11) NOT NULL AUTO_INCREMENT COMMENT 'LLave principal que contiene el id único de cada reparación hecha a los equipos.',
  `descrip_reparacion_equipo` varchar(300) NOT NULL COMMENT 'Contiene la descripción de la reparación que se realizó al equipo.',
  `estado_reparacion` enum('Exitosa','Pendiente','Inutil') DEFAULT NULL,
  `id_diagnostico_danio` int(11) DEFAULT NULL COMMENT 'Llave foránea que vincula a la reparación del equipo con un equipo.',
  PRIMARY KEY (`id_reparacion_equipo`),
  KEY `fk_reparaciones_equipos_equipos_idx` (`id_diagnostico_danio`),
  CONSTRAINT `fk_reparaciones_equipos_diagnosticos` FOREIGN KEY (`id_diagnostico_danio`) REFERENCES `diagnostico_danios` (`id_diagnostico_danio`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='Tabla que contiene el detalle de la reparación de un equipo.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reparaciones_equipos`
--

LOCK TABLES `reparaciones_equipos` WRITE;
/*!40000 ALTER TABLE `reparaciones_equipos` DISABLE KEYS */;
INSERT INTO `reparaciones_equipos` VALUES (6,'Se actualizÃ³ el firmware del equipo','Exitosa',4),(7,'Se restauro el firmware.','Exitosa',6);
/*!40000 ALTER TABLE `reparaciones_equipos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT COMMENT 'LLave principal que contiene el id único de cada rol del sistema.',
  `nombre_rol` varchar(45) NOT NULL COMMENT 'Campo que contiene el nombre del rol del sistema.',
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Tabla que contiene la información de los roles del sistema.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Super Administrador'),(2,'Administrador'),(3,'Agente de Soporte');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `soportes`
--

DROP TABLE IF EXISTS `soportes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `soportes` (
  `id_soporte` int(11) NOT NULL AUTO_INCREMENT COMMENT 'LLave principal que contiene el id único de cada caso de soporte.',
  `fecha_inicio_soporte` date NOT NULL COMMENT 'Campo que contiene la fecha de inicio del caso de soporte.',
  `hora_inicio_soporte` time NOT NULL COMMENT 'Campo que contiene la hora de incio del caso de soporte.',
  `fecha_fin_soporte` date DEFAULT NULL COMMENT 'Campo que contiene la fecha de finalización del caso de soporte.',
  `hora_fin_soporte` time DEFAULT NULL COMMENT 'Campo que contiene la hora de finalización del caso de soporte.',
  `diagnostico_soporte` varchar(600) DEFAULT NULL COMMENT 'Campo que describe cual es la causa del problema.',
  `descrip_accion_soporte` varchar(600) DEFAULT NULL COMMENT 'Campo donde se detallan los procesos que se realizan en el soporte para solucionar el problema.',
  `estado_soporte` enum('Terminado','Pendiente','Observacion') NOT NULL COMMENT 'Campo de valor restringido que indica el estado del caso de soporte.',
  `prioridad_soporte` enum('Alto','Moderado','Bajo') DEFAULT NULL COMMENT 'Campo de valor restringido que detalla la prioridad que tiene el caso de soporte.',
  `tipo_soporte` enum('Visita','Llamada') NOT NULL COMMENT 'Campo de valor restringido que indica el tipo de soporte.',
  `id_sucursal` int(11) DEFAULT NULL COMMENT 'LLave foránea que vincula a un caso de soporte con una sucursal.',
  `id_problema` int(11) DEFAULT NULL COMMENT 'LLave foránea que vincula el caso de soporte con un tipo de problema.',
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_soporte`),
  KEY `fk_soportes_sucursales_idx` (`id_sucursal`),
  KEY `fk_soportes_problemas_idx` (`id_problema`),
  KEY `fk_soportes_usuarios_idx` (`id_usuario`),
  KEY `fk_soportes_problemas_idx1` (`id_problema`,`id_usuario`),
  CONSTRAINT `fk_soportes_problemas` FOREIGN KEY (`id_problema`) REFERENCES `problemas` (`id_problema`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_soportes_sucursales` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursales` (`id_sucursal`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_soportes_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COMMENT='Tabla donde se almacena los datos de los soportes que se brindan a las sucursales de los clientes.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `soportes`
--

LOCK TABLES `soportes` WRITE;
/*!40000 ALTER TABLE `soportes` DISABLE KEYS */;
INSERT INTO `soportes` VALUES (5,'2014-04-26','23:46:19','2014-06-28','16:12:35','No se puede conectar la radio al internet','Se reinicio el router wifi','Terminado','','Visita',6,1,1),(6,'2014-04-27','00:01:40','2014-04-27','00:02:13','La radio estaba apagada','Se procedio a encencer la radio','Terminado','','Llamada',7,5,1),(7,'2014-04-27','00:26:21','2014-04-27','00:27:08','El router no brindaba seÃ±al de wifi','Se reiniciaron los equipos','Terminado','','Llamada',6,6,1),(12,'2014-04-29','14:56:14','2014-04-29','14:56:26','','','Terminado','','Llamada',6,8,1),(13,'2014-04-29','14:56:45','2014-04-29','14:57:19','','','Terminado','','Llamada',6,8,1),(14,'2014-04-30','09:04:16','0000-00-00','00:00:00','El router no emite seÃ±al','Se reiniciaron los equipos','Observacion','Moderado','Llamada',9,6,1),(15,'2014-05-02','09:11:27','0000-00-00','00:00:00','El ASDL no recibe seÃ±al de internet','Reinicio de equipos, revisiÃ³n de cables','Pendiente','Alto','Llamada',8,1,1),(16,'2014-05-02','09:15:45','0000-00-00','00:00:00','Amplificador sin funcionar','Se probÃ³ el amplificador con otro equipo y el problema persiste. Se gestionarÃ¡ cambio de amplificador','Pendiente','Bajo','Visita',9,7,1),(17,'2014-05-11','16:59:29','2014-05-17','13:42:54','algo','algo','Terminado','','Llamada',2,8,1),(18,'2014-05-18','14:56:00','2014-05-18','14:56:53','Ninguno','Ninguno','Terminado','','Visita',9,9,1),(19,'2014-05-18','14:57:47','2014-05-18','14:58:24','Ninguno','Ninguno','Terminado','','Llamada',7,9,1),(20,'2014-05-18','14:58:30','2014-05-18','14:58:51','Ninguno','Ninguno','Terminado','','Llamada',2,9,1),(21,'2014-05-18','15:28:05','2014-05-18','15:30:14','Cable roto','Remplazo de cable','Terminado','','Llamada',9,8,1),(24,'2014-05-25','11:00:27','2014-05-25','11:01:14','Se habÃ­a desconectado la fuente de alimentaciÃ³n de la radio','Se conecto nuevamente','Terminado','','Llamada',8,5,1),(25,'2014-05-25','11:53:50','2014-05-25','11:54:31','Radio no conectada al la fuente de energia','Se conecto al cargador','Terminado','','Llamada',8,5,1),(26,'2014-05-31','17:29:11','0000-00-00','00:00:00','Fallo en el servicio del proveedor de internet','Se llamo al proveedor de Internet, en unas horas se restablecerÃ¡ el servicio.','Observacion','Alto','Llamada',8,1,1),(27,'2014-06-06','09:35:18','2014-06-06','09:37:11','No carga la radio, se queda en conectando','Reinicio de equipos y configuraciÃ³n de clave de Internet, se dejo la clave de fabrica.','Terminado','','Llamada',10,1,1),(28,'2014-06-06','15:33:11','2014-06-09','09:30:37','Problema de audio no se escucha bien en las bocinas del restaurante','se visito y se revisaron  las bocinas solo se reinicio el agente y ya la musica se escucha. a un volument normal','Terminado','','Visita',11,8,1),(29,'2014-06-18','14:18:22','0000-00-00','00:00:00','El router no funciona','Se reiniciaron los equipos.','Pendiente','Alto','Llamada',2,6,1),(32,'2014-06-28','15:54:10','2014-06-28','16:33:35','malo','Se instalaron los equipos','Terminado','','Llamada',16,9,2);
/*!40000 ALTER TABLE `soportes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `soportes_programados`
--

DROP TABLE IF EXISTS `soportes_programados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `soportes_programados` (
  `id_soporte_programado` int(11) NOT NULL AUTO_INCREMENT COMMENT 'LLave principal que contiene el id único de cada soporte programado.',
  `fecha_soporte_programado` date NOT NULL COMMENT 'Campo que contiene la fecha en que se realizará el soporte programado.',
  `prioridad_soporte_programado` enum('Alto','Moderado','Bajo') NOT NULL COMMENT 'Campo con valor restringido que indica el nivel de prioridad de soporte programado.',
  `tipo_soporte_programado` enum('Visita','Llamada') NOT NULL COMMENT 'Campo con valor restringido que indica el tipo de soporte programado.',
  `id_sucursal` int(11) DEFAULT NULL COMMENT 'LLave foránea que vincula al soporte programado con una sucursal de un cliente.',
  `id_usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_soporte_programado`),
  KEY `fk_soportes_programados_sucursales_idx` (`id_sucursal`),
  KEY `fk_soportes_programados_usuarios_idx` (`id_usuario`),
  CONSTRAINT `fk_soportes_programados_sucursales` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursales` (`id_sucursal`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_soportes_programados_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='Tabla que contiene la información de los soportes programados para fecha posteriores.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `soportes_programados`
--

LOCK TABLES `soportes_programados` WRITE;
/*!40000 ALTER TABLE `soportes_programados` DISABLE KEYS */;
INSERT INTO `soportes_programados` VALUES (1,'2014-05-10','Alto','Visita',6,1),(5,'2014-05-01','Moderado','Llamada',6,1),(7,'2014-05-31','Alto','Llamada',2,2),(8,'2014-05-31','Bajo','Visita',8,3),(10,'2014-07-31','Bajo','Visita',9,2);
/*!40000 ALTER TABLE `soportes_programados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sucursales`
--

DROP TABLE IF EXISTS `sucursales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sucursales` (
  `id_sucursal` int(11) NOT NULL AUTO_INCREMENT COMMENT 'LLave principal que contiene el id único de cada sucursal de los clientes.',
  `codigo_sucursal` varchar(10) DEFAULT NULL,
  `nombre_sucursal` varchar(45) NOT NULL COMMENT 'Campo que contiene el nombre por el que se identifica la sucursal.',
  `encargado_sucursal` varchar(45) DEFAULT NULL COMMENT 'Campo que contiene el nombre del responsable de la sucursal.',
  `direccion_sucursal` varchar(600) DEFAULT NULL COMMENT 'Campo que contiene la direccion exacta de la sucursal.',
  `telefono_sucursal` varchar(45) DEFAULT NULL COMMENT 'Campo que contiene el telefono de la sucursal.',
  `celular_sucursal` varchar(45) DEFAULT NULL COMMENT 'Campo opcional que contiene el celular de la sucursal.',
  `estado_sucursal` enum('Activa','Inactiva') NOT NULL COMMENT 'Campo con valor restringido que almacena el estado de la sucursal.',
  `mac_hfc_codigo_t` varchar(45) DEFAULT NULL COMMENT 'Campo que contiene el codigo t o la mac hfc del servicio de internet contratado para la tienda.',
  `id_cliente` int(11) DEFAULT NULL COMMENT 'LLave foránea que vincula a la sucursal con un cliente.',
  `id_proveedor_internet` int(11) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  PRIMARY KEY (`id_sucursal`),
  KEY `fk_sucursales_clientes_idx` (`id_cliente`),
  KEY `fk_sucursales_proveedores_internet_idx` (`id_proveedor_internet`),
  CONSTRAINT `fk_sucursales_clientes` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_sucursales_proveedores_internet` FOREIGN KEY (`id_proveedor_internet`) REFERENCES `proveedores_internet` (`id_proveedor_internet`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='Tabla donde se almacena la información de las sucursales o puntos de ventas de nuestros clientes.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sucursales`
--

LOCK TABLES `sucursales` WRITE;
/*!40000 ALTER TABLE `sucursales` DISABLE KEYS */;
INSERT INTO `sucursales` VALUES (2,'SSG01','Ciudad Capital','Juan PerÃ©z','Ciudad de Guatemala','50244558899','50244558899','Activa','5985',2,1,'2014-04-29'),(6,'SSV01','Z30 Centro San Salvador','Jaime Lopez','San Salvador','77889966','77889966','Activa','2255',6,6,'2014-04-29'),(7,'SSV02','Ahuachapan','Mario Gomez','Ahuachapan','24459966','24459966','Activa','3399',6,6,'2014-04-29'),(8,'PN01','Managua 1','HernÃ¡n Gutierrez','Calle al Pacifico sobre redondel La Libertad','24458987','79850361','Activa','5987236',9,6,'2014-04-29'),(9,'LPSV01','La Pasta AhuachapÃ¡n','Carlos Gonzales','Frente al mercado numero 2 AhuachapÃ¡n','24139780','792396410','Activa','72693',7,6,'2014-04-30'),(10,'DLO577','La Oferta Usulutan','Mariano Gochez','Calle el litoral, Salida a Usulutan','26623085','70399541','Activa','T02589',21,12,'2014-06-06'),(11,'PASV001','EscalÃ³n','Stephanie Gomez','81 Avenida Norte #619, Colonia Escalon, San Salvador','22636444','','Activa','589669',22,12,'2014-06-06'),(12,'PASV002','Azaleas','Pablo Antonio Aguilar','Plaza Las Azaleas, Local 15 Segundo Nivel','22639666','112','Activa','',22,12,'2014-06-06'),(13,'PASv003','Merliot','Humberto Salinas','Blvd. Merliot y Calle L-7. Esquina Frente a V','22780505','','Activa','',22,12,'2014-06-06'),(14,'PASV004','Santa Elena','Ana Solano','Plaza Santa Elena Local A-2, entre Blvd Santa','22460606','222','Activa','2015895',22,12,'2014-06-06'),(16,'HTC01','San Lorenzo','Maria Campos','Centro, San Lorenzo','24418596','','Activa','',12,16,'2014-06-28'),(17,'TCC001','San Jose','Adriana Batres Guzman','Carretera hacia el atlÃ¡ntico, km 44.','48963259','78956980','Activa','',13,14,'2014-06-28');
/*!40000 ALTER TABLE `sucursales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipos_danios`
--

DROP TABLE IF EXISTS `tipos_danios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipos_danios` (
  `id_tipo_danio` int(11) NOT NULL AUTO_INCREMENT COMMENT 'LLave principal que contiene el id único de cada tipo de daño en los equipos.',
  `nombre_tipo_danio` varchar(45) NOT NULL COMMENT 'Campo que almacena el nombre del tipo de daño que puede tener el equipo.',
  PRIMARY KEY (`id_tipo_danio`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='Tabla que almacena los tipos de daños que un equipo puede presentar.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipos_danios`
--

LOCK TABLES `tipos_danios` WRITE;
/*!40000 ALTER TABLE `tipos_danios` DISABLE KEYS */;
INSERT INTO `tipos_danios` VALUES (1,'Falla de FÃ¡brica'),(4,'DaÃ±o por agua'),(5,'Mala manipulaciÃ³n'),(6,'NingÃºn problema'),(7,'Falla electrica'),(8,'DaÃ±o fÃ­sico');
/*!40000 ALTER TABLE `tipos_danios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT COMMENT 'LLave principal que contiene el id único de cada usuario del sistema.',
  `nick_usuario` varchar(45) DEFAULT NULL COMMENT 'Campo que contiene el nick de acceso del usuario del sistema.',
  `contrasenia_usuario` varchar(45) DEFAULT NULL COMMENT 'Campo que contiene la contraseña del usuario del sistema.',
  `nombre_usuario` varchar(45) DEFAULT NULL COMMENT 'Campo que almacena el nombre real del usuario del sistema.',
  `cargo_usuario` varchar(45) DEFAULT NULL COMMENT 'Campo que muestra el cargo que posee el usuario del sistema.',
  `telefono_usuario` varchar(45) DEFAULT NULL COMMENT 'Campo que almacena el número telefónico del contacto del usuario del sistema.',
  `correo_usuario` varchar(45) DEFAULT NULL COMMENT 'Campo que almacena el correo electronico del usuario del sistema.',
  `id_rol` int(11) NOT NULL COMMENT 'Llave foránea que vincula al usuario del sistema con los roles.',
  `id_pais` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `fk_usuarios_roles_idx` (`id_rol`),
  KEY `fk_usuarios_paises_idx` (`id_pais`),
  CONSTRAINT `fk_usuarios_paises` FOREIGN KEY (`id_pais`) REFERENCES `paises` (`id_pais`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_usuarios_roles` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='Tabla que contiene la información de los usuarios del sistema.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'superadmin','superadmin','Super Administrador','Administrador','226558966','info@micorreo.com',1,1),(2,'admin','admin','Ever IvÃ¡n Jimenez','Developer','70005896','ever_jl@hotmail.com',2,1),(3,'soporte','soporte','DarÃ­o AlarcÃ³n','Developer','70705897','dario@gmail.com',3,4);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-06-28 17:08:55
