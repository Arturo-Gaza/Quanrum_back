-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: quantum2
-- ------------------------------------------------------
-- Server version	8.1.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tab_actividad_bitacora`
--

DROP TABLE IF EXISTS `tab_actividad_bitacora`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tab_actividad_bitacora` (
  `id_bitacora` int NOT NULL AUTO_INCREMENT,
  `id_usuario_interno` int DEFAULT NULL,
  `fecha_hora` datetime NOT NULL,
  `actividad_realizada` varchar(50) NOT NULL,
  `descripcion_actividad` text NOT NULL,
  PRIMARY KEY (`id_bitacora`),
  KEY `fk_actividad_bitacora_usuario` (`id_usuario_interno`),
  CONSTRAINT `fk_actividad_bitacora_usuario` FOREIGN KEY (`id_usuario_interno`) REFERENCES `tab_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tab_categoria`
--

DROP TABLE IF EXISTS `tab_categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tab_categoria` (
  `id_categoria` int NOT NULL AUTO_INCREMENT,
  `nombre_categoria` varchar(50) NOT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tab_colonia`
--

DROP TABLE IF EXISTS `tab_colonia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tab_colonia` (
  `id_colonia` int NOT NULL,
  `nombre_colonia` varchar(50) NOT NULL,
  `id_municipio` int DEFAULT NULL,
  PRIMARY KEY (`id_colonia`),
  KEY `fk_colonia_municipio` (`id_municipio`),
  CONSTRAINT `fk_colonia_municipio` FOREIGN KEY (`id_municipio`) REFERENCES `tab_municipio` (`id_municipio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tab_compania`
--

DROP TABLE IF EXISTS `tab_compania`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tab_compania` (
  `id_compania` int NOT NULL AUTO_INCREMENT,
  `nombre_compania` varchar(50) NOT NULL,
  `rfc_compania` varchar(13) NOT NULL,
  `id_direccion_compania` int DEFAULT NULL,
  `telefono_compania` varchar(20) NOT NULL,
  `email_compania` varchar(50) DEFAULT NULL,
  `paginaweb_compania` varchar(50) DEFAULT NULL,
  `activo_compania` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_compania`),
  KEY `fk_compania_direccion` (`id_direccion_compania`),
  CONSTRAINT `fk_compania_direccion` FOREIGN KEY (`id_direccion_compania`) REFERENCES `tab_direccion_compania` (`id_direccion_compania`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tab_detalle_pedido`
--

DROP TABLE IF EXISTS `tab_detalle_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tab_detalle_pedido` (
  `id_detalle_pedido` int NOT NULL AUTO_INCREMENT,
  `id_pedido` int DEFAULT NULL,
  `id_producto` int DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `descuento` decimal(10,2) DEFAULT NULL,
  `subtotal_producto` decimal(10,2) NOT NULL,
  `iva_producto` decimal(10,2) NOT NULL,
  `total_producto` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_detalle_pedido`),
  KEY `fk_detalle_pedido_pedido` (`id_pedido`),
  KEY `fk_detalle_pedido_producto` (`id_producto`),
  CONSTRAINT `fk_detalle_pedido_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `tab_pedido` (`id_pedido`),
  CONSTRAINT `fk_detalle_pedido_producto` FOREIGN KEY (`id_producto`) REFERENCES `tab_producto` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tab_direccion_compania`
--

DROP TABLE IF EXISTS `tab_direccion_compania`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tab_direccion_compania` (
  `id_direccion_compania` int NOT NULL,
  `id_compania` int DEFAULT NULL,
  `calle_compania` varchar(50) NOT NULL,
  `numero_ext` int DEFAULT NULL,
  `numero_int` int DEFAULT NULL,
  `cp_compania` int NOT NULL,
  `id_colonia` int DEFAULT NULL,
  `id_municipio` int DEFAULT NULL,
  `id_estado` int DEFAULT NULL,
  PRIMARY KEY (`id_direccion_compania`),
  KEY `fk_direccion_compania_colonia` (`id_colonia`),
  KEY `fk_direccion_compania_municipio` (`id_municipio`),
  KEY `fk_direccion_compania_estado` (`id_estado`),
  KEY `fk_direccion_compania_compania` (`id_compania`),
  CONSTRAINT `fk_direccion_compania_colonia` FOREIGN KEY (`id_colonia`) REFERENCES `tab_colonia` (`id_colonia`),
  CONSTRAINT `fk_direccion_compania_compania` FOREIGN KEY (`id_compania`) REFERENCES `tab_compania` (`id_compania`),
  CONSTRAINT `fk_direccion_compania_estado` FOREIGN KEY (`id_estado`) REFERENCES `tab_estado` (`id_estado`),
  CONSTRAINT `fk_direccion_compania_municipio` FOREIGN KEY (`id_municipio`) REFERENCES `tab_municipio` (`id_municipio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tab_direccion_distribuidor`
--

DROP TABLE IF EXISTS `tab_direccion_distribuidor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tab_direccion_distribuidor` (
  `id_direccion_distribuidor` int NOT NULL,
  `id_distribuidor` int DEFAULT NULL,
  `calle_sucursal` varchar(50) NOT NULL,
  `numero_ext` int DEFAULT NULL,
  `numero_int` int DEFAULT NULL,
  `cp_sucursal` int NOT NULL,
  `id_colonia` int DEFAULT NULL,
  `id_municipio` int DEFAULT NULL,
  `id_estado` int DEFAULT NULL,
  PRIMARY KEY (`id_direccion_distribuidor`),
  KEY `fk_direccion_distribuidor_colonia` (`id_colonia`),
  KEY `fk_direccion_distribuidor_municipio` (`id_municipio`),
  KEY `fk_direccion_distribuidor_estado` (`id_estado`),
  KEY `fk_direccion_distribuidor_distribuidor` (`id_distribuidor`),
  CONSTRAINT `fk_direccion_distribuidor_colonia` FOREIGN KEY (`id_colonia`) REFERENCES `tab_colonia` (`id_colonia`),
  CONSTRAINT `fk_direccion_distribuidor_distribuidor` FOREIGN KEY (`id_distribuidor`) REFERENCES `tab_distribuidor` (`id_distribuidor`),
  CONSTRAINT `fk_direccion_distribuidor_estado` FOREIGN KEY (`id_estado`) REFERENCES `tab_estado` (`id_estado`),
  CONSTRAINT `fk_direccion_distribuidor_municipio` FOREIGN KEY (`id_municipio`) REFERENCES `tab_municipio` (`id_municipio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tab_direccion_empleado`
--

DROP TABLE IF EXISTS `tab_direccion_empleado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tab_direccion_empleado` (
  `id_direccion` int NOT NULL,
  `id_empleado` int DEFAULT NULL,
  `calle_empleado` varchar(50) NOT NULL,
  `numero_ext` int DEFAULT NULL,
  `numero_int` int DEFAULT NULL,
  `cp_empleado` int NOT NULL,
  `id_colonia` int DEFAULT NULL,
  `id_municipio` int DEFAULT NULL,
  `id_estado` int DEFAULT NULL,
  PRIMARY KEY (`id_direccion`),
  KEY `fk_direccion_empleado_empleado` (`id_empleado`),
  KEY `fk_direccion_empleado_colonia` (`id_colonia`),
  KEY `fk_direccion_empleado_municipio` (`id_municipio`),
  KEY `fk_direccion_empleado_estado` (`id_estado`),
  CONSTRAINT `fk_direccion_empleado_colonia` FOREIGN KEY (`id_colonia`) REFERENCES `tab_colonia` (`id_colonia`),
  CONSTRAINT `fk_direccion_empleado_empleado` FOREIGN KEY (`id_empleado`) REFERENCES `tab_empleados` (`id_empleado`),
  CONSTRAINT `fk_direccion_empleado_estado` FOREIGN KEY (`id_estado`) REFERENCES `tab_estado` (`id_estado`),
  CONSTRAINT `fk_direccion_empleado_municipio` FOREIGN KEY (`id_municipio`) REFERENCES `tab_municipio` (`id_municipio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tab_direccion_sucursal`
--

DROP TABLE IF EXISTS `tab_direccion_sucursal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tab_direccion_sucursal` (
  `id_direccion_sucursal` int NOT NULL,
  `id_sucuarsal` int DEFAULT NULL,
  `calle_sucursal` varchar(50) NOT NULL,
  `numero_ext` int DEFAULT NULL,
  `numero_int` int DEFAULT NULL,
  `cp_sucursal` int NOT NULL,
  `id_colonia` int DEFAULT NULL,
  `id_municipio` int DEFAULT NULL,
  `id_estado` int DEFAULT NULL,
  PRIMARY KEY (`id_direccion_sucursal`),
  KEY `fk_direccion_sucursal_colonia` (`id_colonia`),
  KEY `fk_direccion_sucursal_municipio` (`id_municipio`),
  KEY `fk_direccion_sucursal_estado` (`id_estado`),
  CONSTRAINT `fk_direccion_sucursal_colonia` FOREIGN KEY (`id_colonia`) REFERENCES `tab_colonia` (`id_colonia`),
  CONSTRAINT `fk_direccion_sucursal_estado` FOREIGN KEY (`id_estado`) REFERENCES `tab_estado` (`id_estado`),
  CONSTRAINT `fk_direccion_sucursal_municipio` FOREIGN KEY (`id_municipio`) REFERENCES `tab_municipio` (`id_municipio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tab_distribuidor`
--

DROP TABLE IF EXISTS `tab_distribuidor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tab_distribuidor` (
  `id_distribuidor` int NOT NULL AUTO_INCREMENT,
  `nombre_distribuidor` varchar(50) NOT NULL,
  `a_paterno_distribuidor` varchar(50) NOT NULL,
  `a_materno_distribuidor` varchar(50) NOT NULL,
  `rfc_distribuidor` varchar(13) NOT NULL,
  `id_direccion_distribuidor` int DEFAULT NULL,
  `telefono_distribuidor` varchar(50) NOT NULL,
  `email_distribuidor` varchar(50) DEFAULT NULL,
  `regimen_distribuidor` tinyint(1) NOT NULL,
  `id_compania` int DEFAULT NULL,
  `activo_distribuidor` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_distribuidor`),
  KEY `fk_distribuidor_compania` (`id_compania`),
  KEY `fk_distribuidor_direccion_distribuidor` (`id_direccion_distribuidor`),
  CONSTRAINT `fk_distribuidor_compania` FOREIGN KEY (`id_compania`) REFERENCES `tab_compania` (`id_compania`),
  CONSTRAINT `fk_distribuidor_direccion` FOREIGN KEY (`id_direccion_distribuidor`) REFERENCES `tab_direccion_distribuidor` (`id_direccion_distribuidor`),
  CONSTRAINT `fk_distribuidor_direccion_distribuidor` FOREIGN KEY (`id_direccion_distribuidor`) REFERENCES `tab_direccion_distribuidor` (`id_direccion_distribuidor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tab_empleados`
--

DROP TABLE IF EXISTS `tab_empleados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tab_empleados` (
  `id_empleado` int NOT NULL AUTO_INCREMENT,
  `nombre_empleado` varchar(50) NOT NULL,
  `a_paterno_empleado` varchar(50) NOT NULL,
  `a_materno_empleado` varchar(50) NOT NULL,
  `telefono_empleado` varchar(20) NOT NULL,
  `id_direccion_empleado` int DEFAULT NULL,
  `email_empleado` varchar(50) NOT NULL,
  `fecha_alta` date NOT NULL,
  `fecha_baja` date DEFAULT NULL,
  `activo_empleado` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_empleado`),
  KEY `fk_empleados_direccion` (`id_direccion_empleado`),
  CONSTRAINT `fk_empleados_direccion` FOREIGN KEY (`id_direccion_empleado`) REFERENCES `tab_direccion_empleado` (`id_direccion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tab_estado`
--

DROP TABLE IF EXISTS `tab_estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tab_estado` (
  `id_estado` int NOT NULL,
  `nombre_estado` varchar(50) NOT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tab_municipio`
--

DROP TABLE IF EXISTS `tab_municipio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tab_municipio` (
  `id_municipio` int NOT NULL,
  `nombre_municipio` varchar(50) NOT NULL,
  `id_estado` int DEFAULT NULL,
  PRIMARY KEY (`id_municipio`),
  KEY `fk_municipio_estado` (`id_estado`),
  CONSTRAINT `fk_municipio_estado` FOREIGN KEY (`id_estado`) REFERENCES `tab_estado` (`id_estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tab_pedido`
--

DROP TABLE IF EXISTS `tab_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tab_pedido` (
  `id_pedido` int NOT NULL AUTO_INCREMENT,
  `id_usuario_distribuidor` int DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL,
  `id_sucursal` int DEFAULT NULL,
  `activo_pedido` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_pedido`),
  KEY `fk_pedido_usuario_distribuidor` (`id_usuario_distribuidor`),
  KEY `fk_pedido_sucursal` (`id_sucursal`),
  CONSTRAINT `fk_pedido_sucursal` FOREIGN KEY (`id_sucursal`) REFERENCES `tab_sucursal` (`id_sucursal`),
  CONSTRAINT `fk_pedido_usuario_distribuidor` FOREIGN KEY (`id_usuario_distribuidor`) REFERENCES `tab_usuario_distribuidor` (`id_usuario_distribuidor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tab_permisos`
--

DROP TABLE IF EXISTS `tab_permisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tab_permisos` (
  `id_permiso` int NOT NULL AUTO_INCREMENT,
  `nombre_permiso` varchar(50) NOT NULL,
  `activo_permiso` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_permiso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tab_producto`
--

DROP TABLE IF EXISTS `tab_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tab_producto` (
  `id_producto` int NOT NULL AUTO_INCREMENT,
  `nombre_producto` varchar(50) NOT NULL,
  `precio_producto` decimal(10,2) NOT NULL,
  `id_categoria` int DEFAULT NULL,
  `descripcion_producto` text,
  `caracteristicas_producto` text,
  `imagen_ruta` varchar(255) DEFAULT NULL,
  `activo_producto` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_producto`),
  KEY `fk_producto_categoria` (`id_categoria`),
  CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `tab_categoria` (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tab_rol_permiso`
--

DROP TABLE IF EXISTS `tab_rol_permiso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tab_rol_permiso` (
  `id_rol` int NOT NULL,
  `id_permiso` int NOT NULL,
  `acceso_permiso` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_rol`,`id_permiso`),
  KEY `fk_rol_permiso_permiso` (`id_permiso`),
  CONSTRAINT `fk_rol_permiso_permiso` FOREIGN KEY (`id_permiso`) REFERENCES `tab_permisos` (`id_permiso`),
  CONSTRAINT `fk_rol_permiso_rol` FOREIGN KEY (`id_rol`) REFERENCES `tab_roles` (`id_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tab_rol_usuario`
--

DROP TABLE IF EXISTS `tab_rol_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tab_rol_usuario` (
  `id_rol` int NOT NULL,
  `id_usuario` int NOT NULL,
  PRIMARY KEY (`id_rol`,`id_usuario`),
  KEY `fk_rol_usuario_usuario` (`id_usuario`),
  CONSTRAINT `fk_rol_usuario_rol` FOREIGN KEY (`id_rol`) REFERENCES `tab_roles` (`id_rol`),
  CONSTRAINT `fk_rol_usuario_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `tab_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tab_roles`
--

DROP TABLE IF EXISTS `tab_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tab_roles` (
  `id_rol` int NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(50) NOT NULL,
  `activo_rol` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tab_sucursal`
--

DROP TABLE IF EXISTS `tab_sucursal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tab_sucursal` (
  `id_sucursal` int NOT NULL AUTO_INCREMENT,
  `id_distribuidor` int DEFAULT NULL,
  `nombre_sucursal` varchar(50) DEFAULT NULL,
  `id_direccion_sucursal` int DEFAULT NULL,
  `telefono_sucursal` varchar(10) DEFAULT NULL,
  `email_sucursal` varchar(50) DEFAULT NULL,
  `activo_sucursal` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_sucursal`),
  KEY `fk_sucursal_distribuidor` (`id_distribuidor`),
  KEY `fk_sucursal_direccion` (`id_direccion_sucursal`),
  CONSTRAINT `fk_sucursal_direccion` FOREIGN KEY (`id_direccion_sucursal`) REFERENCES `tab_direccion_sucursal` (`id_direccion_sucursal`),
  CONSTRAINT `fk_sucursal_distribuidor` FOREIGN KEY (`id_distribuidor`) REFERENCES `tab_distribuidor` (`id_distribuidor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tab_usuario`
--

DROP TABLE IF EXISTS `tab_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tab_usuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `id_empleado` int DEFAULT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `contrasena_usuario` varchar(50) NOT NULL,
  `activo_usuario` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  KEY `fk_usuario_empleado` (`id_empleado`),
  CONSTRAINT `fk_usuario_empleado` FOREIGN KEY (`id_empleado`) REFERENCES `tab_empleados` (`id_empleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tab_usuario_distribuidor`
--

DROP TABLE IF EXISTS `tab_usuario_distribuidor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tab_usuario_distribuidor` (
  `id_usuario_distribuidor` int NOT NULL AUTO_INCREMENT,
  `nom_udistribuidor` varchar(50) NOT NULL,
  `a_paterno_udistribuidor` varchar(50) DEFAULT NULL,
  `a_materno_udistribuidor` varchar(50) DEFAULT NULL,
  `id_sucursal` int DEFAULT NULL,
  `telefono_udistribuidor` varchar(10) NOT NULL,
  `email_udistribuidor` varchar(50) NOT NULL,
  `usuario_distribuidor` varchar(50) NOT NULL,
  `contrasena_distribuidor` varchar(15) NOT NULL,
  `activo_udistribuidor` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_usuario_distribuidor`),
  KEY `fk_usuario_distribuidor_sucursal` (`id_sucursal`),
  CONSTRAINT `fk_usuario_distribuidor_sucursal` FOREIGN KEY (`id_sucursal`) REFERENCES `tab_sucursal` (`id_sucursal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-18 15:21:25
