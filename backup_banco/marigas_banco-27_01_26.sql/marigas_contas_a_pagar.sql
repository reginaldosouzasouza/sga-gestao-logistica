-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: marigas
-- ------------------------------------------------------
-- Server version	8.4.7

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
-- Table structure for table `contas_a_pagar`
--

DROP TABLE IF EXISTS `contas_a_pagar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contas_a_pagar` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `fornecedor_id` bigint unsigned NOT NULL,
  `descricao` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `data_compra` date DEFAULT NULL,
  `data_vencimento` date NOT NULL,
  `data_pagamento` date DEFAULT NULL,
  `status` enum('pendente','pago','atrasado') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendente',
  `forma_pagamento_id` bigint unsigned DEFAULT NULL,
  `observacao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `prazo` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contas_a_pagar_fornecedor_id_foreign` (`fornecedor_id`),
  KEY `contas_a_pagar_forma_pagamento_id_foreign` (`forma_pagamento_id`),
  CONSTRAINT `contas_a_pagar_forma_pagamento_id_foreign` FOREIGN KEY (`forma_pagamento_id`) REFERENCES `formas_de_pagamento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `contas_a_pagar_fornecedor_id_foreign` FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contas_a_pagar`
--

LOCK TABLES `contas_a_pagar` WRITE;
/*!40000 ALTER TABLE `contas_a_pagar` DISABLE KEYS */;
INSERT INTO `contas_a_pagar` VALUES (2,2,'Compra de produtos',3240.00,'2026-01-07','2026-01-17','2026-01-11','pago',5,NULL,'2026-01-10 20:06:26','2026-01-12 20:52:11',10),(3,12,'Compra de produtos',1187.50,'2026-01-01','2026-01-02','2026-01-01','pago',1,NULL,'2026-01-10 22:12:55','2026-01-10 22:12:55',1),(4,2,'Compra de produtos',720.00,'2026-01-10','2026-01-11','2026-01-10','pago',1,NULL,'2026-01-11 00:19:15','2026-01-11 00:19:15',1),(6,13,'Compra de produtos',500.00,'2026-01-11','2026-01-21','2026-01-17','pago',2,NULL,'2026-01-11 19:00:31','2026-01-17 23:23:41',10),(8,2,'Compra de produtos',3600.00,'2026-01-12','2026-01-22','2026-01-17','pago',1,NULL,'2026-01-12 20:44:28','2026-01-17 23:21:29',10),(10,8,'MARMITA',25.00,'2026-01-12','2026-01-13','2026-01-12','pago',1,NULL,'2026-01-12 23:24:48','2026-01-12 23:26:02',1),(11,13,'Compra de produtos',100.00,'2026-01-12','2026-01-13','2026-01-12','pago',1,NULL,'2026-01-12 23:27:31','2026-01-12 23:27:31',1),(12,13,'Compra de produtos',1.00,'2026-01-11','2026-01-12','2026-01-11','pago',1,NULL,'2026-01-13 17:49:52','2026-01-13 17:49:52',1),(13,13,'Compra de produtos',0.30,'2026-01-12','2026-01-13','2026-01-12','pago',1,NULL,'2026-01-13 17:53:23','2026-01-13 17:53:23',1),(14,12,'Compra de produtos',1424.70,'2026-01-17','2026-01-19','2026-01-17','pago',1,NULL,'2026-01-17 23:07:22','2026-01-17 23:07:22',2),(15,13,'Compra de produtos',95.00,'2026-01-17','2026-01-20','2026-01-17','pago',1,NULL,'2026-01-17 23:12:23','2026-01-17 23:20:52',3),(16,12,'Compra de produtos',136.50,'2026-01-17','2026-01-19','2026-01-17','pago',3,NULL,'2026-01-17 23:19:21','2026-01-17 23:19:46',2),(17,12,'Compra de produtos',180.00,'2026-01-17','2026-01-19','2026-01-17','pago',1,NULL,'2026-01-17 23:21:54','2026-01-17 23:21:54',2),(18,13,'Compra de produtos',1402.20,'2026-01-17','2026-01-19','2026-01-17','pago',1,NULL,'2026-01-17 23:36:25','2026-01-17 23:36:52',2),(19,2,'Compra de produtos',270.00,'2026-01-17','2026-01-19','2026-01-17','pago',1,NULL,'2026-01-17 23:38:09','2026-01-17 23:38:09',2),(20,12,'Compra de produtos',90.00,'2026-01-17','2026-01-19','2026-01-17','pago',2,NULL,'2026-01-17 23:39:44','2026-01-17 23:40:09',2),(21,2,'Compra de produtos',1350.00,'2026-01-17','2026-01-19','2026-01-17','pago',1,NULL,'2026-01-17 23:48:27','2026-01-17 23:48:45',2),(22,12,'Compra de produtos',475.00,'2026-01-17','2026-01-19','2026-01-17','pago',1,NULL,'2026-01-17 23:49:06','2026-01-17 23:49:06',2),(25,12,'Compra de produtos',450.00,'2026-01-17','2026-01-19','2026-01-17','pago',1,NULL,'2026-01-17 23:56:09','2026-01-17 23:56:09',2),(26,13,'Compra de produtos',285.00,'2026-01-17','2026-01-19','2026-01-17','pago',2,NULL,'2026-01-17 23:57:11','2026-01-17 23:57:11',2),(27,2,'Compra de produtos',900.00,'2026-01-17','2026-01-20','2026-01-17','pago',1,NULL,'2026-01-17 23:58:20','2026-01-17 23:59:01',3),(28,13,'Compra de produtos',450.00,'2026-01-19','2026-01-21','2026-01-19','pago',1,NULL,'2026-01-19 20:15:04','2026-01-19 20:15:04',2);
/*!40000 ALTER TABLE `contas_a_pagar` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-01-27 11:51:09
