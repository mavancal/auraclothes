
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
DROP TABLE IF EXISTS `categoria_producto_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria_producto_producto` (
  `producto_id` bigint unsigned NOT NULL,
  `categoria_producto_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`producto_id`,`categoria_producto_id`),
  KEY `categoria_producto_producto_categoria_producto_id_foreign` (`categoria_producto_id`),
  CONSTRAINT `categoria_producto_producto_categoria_producto_id_foreign` FOREIGN KEY (`categoria_producto_id`) REFERENCES `categorias_producto` (`id`),
  CONSTRAINT `categoria_producto_producto_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `categoria_producto_producto` WRITE;
/*!40000 ALTER TABLE `categoria_producto_producto` DISABLE KEYS */;
INSERT INTO `categoria_producto_producto` VALUES (1,1),(4,1),(2,2),(3,4);
/*!40000 ALTER TABLE `categoria_producto_producto` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `categoria_us_contacto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria_us_contacto` (
  `categoria_us_id` bigint unsigned NOT NULL,
  `contacto_id` bigint unsigned NOT NULL,
  `fecha_asig` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`categoria_us_id`,`contacto_id`),
  KEY `categoria_us_contacto_contacto_id_foreign` (`contacto_id`),
  CONSTRAINT `categoria_us_contacto_categoria_us_id_foreign` FOREIGN KEY (`categoria_us_id`) REFERENCES `categorias_us` (`id`),
  CONSTRAINT `categoria_us_contacto_contacto_id_foreign` FOREIGN KEY (`contacto_id`) REFERENCES `contactos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `categoria_us_contacto` WRITE;
/*!40000 ALTER TABLE `categoria_us_contacto` DISABLE KEYS */;
/*!40000 ALTER TABLE `categoria_us_contacto` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `categorias_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias_producto` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre_categoria` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `categorias_producto` WRITE;
/*!40000 ALTER TABLE `categorias_producto` DISABLE KEYS */;
INSERT INTO `categorias_producto` VALUES (1,'Remeras','2026-11-18 20:21:44','2026-11-18 20:21:44'),(2,'Pantalones','2026-11-18 20:21:44','2026-11-18 20:21:44'),(3,'Buzos','2026-11-18 20:21:44','2026-11-18 20:21:44'),(4,'HeadWear','2026-11-18 20:21:44','2026-11-18 20:21:44'),(5,'Accesorios','2026-11-18 20:21:44','2026-11-18 20:21:44'),(6,'Mochilas','2026-11-18 20:21:44','2026-11-18 20:21:44');
/*!40000 ALTER TABLE `categorias_producto` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `categorias_us`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias_us` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre_categoria` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `categorias_us` WRITE;
/*!40000 ALTER TABLE `categorias_us` DISABLE KEYS */;
INSERT INTO `categorias_us` VALUES (1,'Minorista','Cliente final','2026-11-18 20:21:44','2026-11-18 20:21:44'),(2,'Mayorista','Compra por volumen','2026-11-18 20:21:44','2026-11-18 20:21:44');
/*!40000 ALTER TABLE `categorias_us` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `colecciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `colecciones` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre_coleccion` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `colecciones` WRITE;
/*!40000 ALTER TABLE `colecciones` DISABLE KEYS */;
INSERT INTO `colecciones` VALUES (1,'Otoño 2026','2026-11-18 20:21:44','2026-11-18 20:21:44'),(2,'Invierno 2025','2026-11-18 20:21:44','2026-11-18 20:21:44'),(3,'Verano 2025','2026-11-18 20:21:44','2026-11-18 20:21:44'),(4,'Basicos','2026-11-18 20:21:44','2026-11-18 20:21:44');
/*!40000 ALTER TABLE `colecciones` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `contactos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contactos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre2` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apellido` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_documento` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cuit` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_contacto` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_documento_id` bigint unsigned NOT NULL,
  `tipo_persona_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `contactos_tipo_documento_id_numero_documento_unique` (`tipo_documento_id`,`numero_documento`),
  UNIQUE KEY `contactos_cuit_unique` (`cuit`),
  KEY `contactos_tipo_persona_id_foreign` (`tipo_persona_id`),
  CONSTRAINT `contactos_tipo_documento_id_foreign` FOREIGN KEY (`tipo_documento_id`) REFERENCES `tipos_documento` (`id`),
  CONSTRAINT `contactos_tipo_persona_id_foreign` FOREIGN KEY (`tipo_persona_id`) REFERENCES `tipos_persona` (`id`),
  CONSTRAINT `chk_contactos_cuit` CHECK (((`cuit` is null) or regexp_like(`cuit`,_utf8mb4'^[0-9]{11}$')))
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `contactos` WRITE;
/*!40000 ALTER TABLE `contactos` DISABLE KEYS */;
INSERT INTO `contactos` VALUES (1,'Juan',NULL,'Pérez','30111222',NULL,NULL,NULL,'juan@mail.com',1,1,'2026-11-18 20:21:45','2026-11-18 20:21:45'),(2,'Admin',NULL,'Aura','20000000',NULL,NULL,NULL,'admin@auraclothes.com',1,1,'2026-11-18 20:21:45','2026-11-18 20:21:45');
/*!40000 ALTER TABLE `contactos` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `detalle_pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_pedidos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pedido_id` bigint unsigned NOT NULL,
  `producto_id` bigint unsigned NOT NULL,
  `cantidad` int unsigned NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `detalle_pedidos_pedido_id_producto_id_unique` (`pedido_id`,`producto_id`),
  KEY `detalle_pedidos_producto_id_foreign` (`producto_id`),
  CONSTRAINT `detalle_pedidos_pedido_id_foreign` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `detalle_pedidos_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  CONSTRAINT `chk_detalle_cantidad` CHECK ((`cantidad` > 0)),
  CONSTRAINT `chk_detalle_precio` CHECK ((`precio_unitario` >= 0))
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `detalle_pedidos` WRITE;
/*!40000 ALTER TABLE `detalle_pedidos` DISABLE KEYS */;
INSERT INTO `detalle_pedidos` VALUES (1,1,1,2,23100.00,'2026-11-18 20:21:45','2026-11-18 20:21:45'),(2,1,3,1,43050.00,'2026-11-18 20:21:45','2026-11-18 20:21:45');
/*!40000 ALTER TABLE `detalle_pedidos` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `direcciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `direcciones` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `calle` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `piso` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `departamento` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cod_postal` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_principal` tinyint(1) NOT NULL DEFAULT '0',
  `referencia` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `localidad_id` bigint unsigned NOT NULL,
  `contacto_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `direcciones_localidad_id_foreign` (`localidad_id`),
  KEY `direcciones_contacto_id_foreign` (`contacto_id`),
  CONSTRAINT `direcciones_contacto_id_foreign` FOREIGN KEY (`contacto_id`) REFERENCES `contactos` (`id`),
  CONSTRAINT `direcciones_localidad_id_foreign` FOREIGN KEY (`localidad_id`) REFERENCES `localidades` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `direcciones` WRITE;
/*!40000 ALTER TABLE `direcciones` DISABLE KEYS */;
INSERT INTO `direcciones` VALUES (1,'Av. Mitre','1234',NULL,NULL,NULL,1,NULL,1,1,'2026-11-18 20:21:45','2026-11-18 20:21:45');
/*!40000 ALTER TABLE `direcciones` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `estados_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estados_pedido` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `estados_pedido` WRITE;
/*!40000 ALTER TABLE `estados_pedido` DISABLE KEYS */;
INSERT INTO `estados_pedido` VALUES (1,'Pendiente','2026-11-18 20:21:44','2026-11-18 20:21:44'),(2,'Pagado','2026-11-18 20:21:44','2026-11-18 20:21:44'),(3,'En preparación','2026-11-18 20:21:44','2026-11-18 20:21:44'),(4,'Enviado','2026-11-18 20:21:44','2026-11-18 20:21:44'),(5,'Entregado','2026-11-18 20:21:44','2026-11-18 20:21:44'),(6,'Cancelado','2026-11-18 20:21:44','2026-11-18 20:21:44');
/*!40000 ALTER TABLE `estados_pedido` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `localidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `localidades` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provincia_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `localidades_provincia_id_foreign` (`provincia_id`),
  CONSTRAINT `localidades_provincia_id_foreign` FOREIGN KEY (`provincia_id`) REFERENCES `provincias` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `localidades` WRITE;
/*!40000 ALTER TABLE `localidades` DISABLE KEYS */;
INSERT INTO `localidades` VALUES (1,'Posadas',14,'2026-11-18 20:21:44','2026-11-18 20:21:44'),(2,'Oberá',14,'2026-11-18 20:21:44','2026-11-18 20:21:44'),(3,'Eldorado',14,'2026-11-18 20:21:44','2026-11-18 20:21:44'),(4,'Garupá',14,'2026-11-18 20:21:44','2026-11-18 20:21:44');
/*!40000 ALTER TABLE `localidades` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `metodos_pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `metodos_pago` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `metodo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `metodos_pago` WRITE;
/*!40000 ALTER TABLE `metodos_pago` DISABLE KEYS */;
INSERT INTO `metodos_pago` VALUES (1,'Efectivo','2026-11-18 20:21:44','2026-11-18 20:21:44'),(2,'Transferencia','2026-11-18 20:21:44','2026-11-18 20:21:44'),(3,'Tarjeta de débito','2026-11-18 20:21:44','2026-11-18 20:21:44'),(4,'Tarjeta de crédito','2026-11-18 20:21:44','2026-11-18 20:21:44'),(5,'Mercado Pago','2026-11-18 20:21:44','2026-11-18 20:21:44');
/*!40000 ALTER TABLE `metodos_pago` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_10_19_132258_create_provincias_table',1),(5,'2026_10_19_132904_create_localidades_table',1),(6,'2026_10_19_134129_create_tipos_documento_table',1),(7,'2026_10_19_134312_create_tipos_persona_table',1),(8,'2026_10_19_134518_create_estados_pedido_table',1),(9,'2026_10_19_134705_create_metodos_pago_table',1),(10,'2026_10_19_134858_create_roles_table',1),(11,'2026_10_19_135237_create_categorias_us_table',1),(12,'2026_10_19_135537_create_categorias_producto_table',1),(13,'2026_10_19_135732_create_colecciones_table',1),(14,'2026_10_19_174347_create_contactos_table',1),(15,'2026_10_19_175526_create_direcciones_table',1),(16,'2026_10_19_180326_add_campos_to_users_table',1),(17,'2026_10_19_180933_create_rol_user_table',1),(18,'2026_10_19_181512_create_categoria_us_contacto_table',1),(19,'2026_10_19_221530_create_productos_table',1),(20,'2026_10_19_222212_create_categoria_producto_producto_table',1),(21,'2026_10_19_222448_create_pedidos_table',1),(22,'2026_10_19_222740_create_detalle_pedidos_table',1),(23,'2026_10_20_194954_add_checks_a_las_tablas',1),(24,'2026_10_20_223328_add_precio_oferta_to_productos_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `estado_pedido_id` bigint unsigned NOT NULL,
  `fecha_ped` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `descuento` decimal(10,2) NOT NULL DEFAULT '0.00',
  `costo_envio` decimal(10,2) NOT NULL DEFAULT '0.00',
  `metodo_pago_id` bigint unsigned NOT NULL,
  `direccion_envio_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pedidos_user_id_foreign` (`user_id`),
  KEY `pedidos_estado_pedido_id_foreign` (`estado_pedido_id`),
  KEY `pedidos_metodo_pago_id_foreign` (`metodo_pago_id`),
  KEY `pedidos_direccion_envio_id_foreign` (`direccion_envio_id`),
  CONSTRAINT `pedidos_direccion_envio_id_foreign` FOREIGN KEY (`direccion_envio_id`) REFERENCES `direcciones` (`id`),
  CONSTRAINT `pedidos_estado_pedido_id_foreign` FOREIGN KEY (`estado_pedido_id`) REFERENCES `estados_pedido` (`id`),
  CONSTRAINT `pedidos_metodo_pago_id_foreign` FOREIGN KEY (`metodo_pago_id`) REFERENCES `metodos_pago` (`id`),
  CONSTRAINT `pedidos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `chk_pedidos_descuento` CHECK ((`descuento` >= 0)),
  CONSTRAINT `chk_pedidos_envio` CHECK ((`costo_envio` >= 0))
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
INSERT INTO `pedidos` VALUES (1,1,1,'2026-11-18 17:21:45',0.00,1500.00,2,1,'2026-11-18 20:21:45','2026-11-18 20:21:45');
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sku` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `imagen_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `precio` decimal(10,2) NOT NULL,
  `precio_oferta` decimal(10,2) DEFAULT NULL,
  `stock` int unsigned NOT NULL DEFAULT '0',
  `coleccion_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `productos_sku_unique` (`sku`),
  KEY `productos_coleccion_id_foreign` (`coleccion_id`),
  CONSTRAINT `productos_coleccion_id_foreign` FOREIGN KEY (`coleccion_id`) REFERENCES `colecciones` (`id`) ON DELETE SET NULL,
  CONSTRAINT `chk_productos_oferta` CHECK (((`precio_oferta` is null) or (`precio_oferta` <= `precio`))),
  CONSTRAINT `chk_productos_precio` CHECK ((`precio` >= 0))
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,'REM-001','Remera Oversize AURA - Overflow','Remera oversize de algodón.',NULL,1,28900.00,23100.00,25,1,'2026-11-18 20:21:44','2026-11-18 20:21:44'),(2,'PAN-001','Pantalón Baggy AURA - Class Division','Pantalón baggy de corte amplio.',NULL,1,42000.00,35700.00,15,1,'2026-11-18 20:21:45','2026-11-18 20:21:45'),(3,'HW-001','Gorro de lana Y2K - Century War','Gorro de lana de estilo Y2K.',NULL,1,61500.00,43050.00,10,2,'2026-11-18 20:21:45','2026-11-18 20:21:45'),(4,'REM-002','Remera Oversize TripleZ - Colorful','Remera oversize estampada.',NULL,1,19800.00,17820.00,30,4,'2026-11-18 20:21:45','2026-11-18 20:21:45');
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `provincias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `provincias` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `provincias` WRITE;
/*!40000 ALTER TABLE `provincias` DISABLE KEYS */;
INSERT INTO `provincias` VALUES (1,'Buenos Aires','2026-11-18 20:21:44','2026-11-18 20:21:44'),(2,'Ciudad Autónoma de Buenos Aires','2026-11-18 20:21:44','2026-11-18 20:21:44'),(3,'Catamarca','2026-11-18 20:21:44','2026-11-18 20:21:44'),(4,'Chaco','2026-11-18 20:21:44','2026-11-18 20:21:44'),(5,'Chubut','2026-11-18 20:21:44','2026-11-18 20:21:44'),(6,'Córdoba','2026-11-18 20:21:44','2026-11-18 20:21:44'),(7,'Corrientes','2026-11-18 20:21:44','2026-11-18 20:21:44'),(8,'Entre Ríos','2026-11-18 20:21:44','2026-11-18 20:21:44'),(9,'Formosa','2026-11-18 20:21:44','2026-11-18 20:21:44'),(10,'Jujuy','2026-11-18 20:21:44','2026-11-18 20:21:44'),(11,'La Pampa','2026-11-18 20:21:44','2026-11-18 20:21:44'),(12,'La Rioja','2026-11-18 20:21:44','2026-11-18 20:21:44'),(13,'Mendoza','2026-11-18 20:21:44','2026-11-18 20:21:44'),(14,'Misiones','2026-11-18 20:21:44','2026-11-18 20:21:44'),(15,'Neuquén','2026-11-18 20:21:44','2026-11-18 20:21:44'),(16,'Río Negro','2026-11-18 20:21:44','2026-11-18 20:21:44'),(17,'Salta','2026-11-18 20:21:44','2026-11-18 20:21:44'),(18,'San Juan','2026-11-18 20:21:44','2026-11-18 20:21:44'),(19,'San Luis','2026-11-18 20:21:44','2026-11-18 20:21:44'),(20,'Santa Cruz','2026-11-18 20:21:44','2026-11-18 20:21:44'),(21,'Santa Fe','2026-11-18 20:21:44','2026-11-18 20:21:44'),(22,'Santiago del Estero','2026-11-18 20:21:44','2026-11-18 20:21:44'),(23,'Tierra del Fuego','2026-11-18 20:21:44','2026-11-18 20:21:44'),(24,'Tucumán','2026-11-18 20:21:44','2026-11-18 20:21:44');
/*!40000 ALTER TABLE `provincias` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `rol_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rol_user` (
  `user_id` bigint unsigned NOT NULL,
  `rol_id` bigint unsigned NOT NULL,
  `fecha_asig` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`,`rol_id`),
  KEY `rol_user_rol_id_foreign` (`rol_id`),
  CONSTRAINT `rol_user_rol_id_foreign` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`),
  CONSTRAINT `rol_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `rol_user` WRITE;
/*!40000 ALTER TABLE `rol_user` DISABLE KEYS */;
INSERT INTO `rol_user` VALUES (1,3,'2026-11-18 20:21:45'),(2,1,'2026-11-18 20:21:46');
/*!40000 ALTER TABLE `rol_user` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nivel_permiso` int NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Administrador',100,'Acceso total al sistema','2026-11-18 20:21:44','2026-11-18 20:21:44'),(2,'Empleado',50,'Gestión de productos y pedidos','2026-11-18 20:21:44','2026-11-18 20:21:44'),(3,'Cliente',10,'Usuario comprador','2026-11-18 20:21:44','2026-11-18 20:21:44');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `tipos_documento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipos_documento` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `tipos_documento` WRITE;
/*!40000 ALTER TABLE `tipos_documento` DISABLE KEYS */;
INSERT INTO `tipos_documento` VALUES (1,'DNI','2026-11-18 20:21:43','2026-11-18 20:21:43'),(2,'Pasaporte','2026-11-18 20:21:44','2026-11-18 20:21:44'),(3,'LC','2026-11-18 20:21:44','2026-11-18 20:21:44'),(4,'LE','2026-11-18 20:21:44','2026-11-18 20:21:44'),(5,'CI','2026-11-18 20:21:44','2026-11-18 20:21:44');
/*!40000 ALTER TABLE `tipos_documento` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `tipos_persona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipos_persona` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `tipos_persona` WRITE;
/*!40000 ALTER TABLE `tipos_persona` DISABLE KEYS */;
INSERT INTO `tipos_persona` VALUES (1,'Física','2026-11-18 20:21:44','2026-11-18 20:21:44'),(2,'Jurídica','2026-11-18 20:21:44','2026-11-18 20:21:44');
/*!40000 ALTER TABLE `tipos_persona` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ultimo_acceso` timestamp NULL DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `contacto_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_name_unique` (`name`),
  UNIQUE KEY `users_contacto_id_unique` (`contacto_id`),
  CONSTRAINT `users_contacto_id_foreign` FOREIGN KEY (`contacto_id`) REFERENCES `contactos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'juanperez','juan@mail.com',NULL,'$2y$12$A8GTN55AFtMI2yhhE7wVneIvlN2MDADfrL5NkEQ1YR8CvQl4/6mtm',NULL,'2026-11-18 20:21:45','2026-11-18 20:21:45',NULL,1,1),(2,'admin','admin@auraclothes.com',NULL,'$2y$12$qnVihZqXteBWjNn4akokYumEqEUKTCmDR604CvQqJ0bygrn8hffN2',NULL,'2026-11-18 20:21:46','2026-11-18 20:21:46',NULL,1,2);
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

