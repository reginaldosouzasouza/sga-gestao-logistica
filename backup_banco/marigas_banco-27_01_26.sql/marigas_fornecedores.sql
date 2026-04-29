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
-- Table structure for table `fornecedores`
--

DROP TABLE IF EXISTS `fornecedores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fornecedores` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cnpj` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nome` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  `endereco` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cidade` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observacao` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fornecedores_cnpj_unique` (`cnpj`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fornecedores`
--

LOCK TABLES `fornecedores` WRITE;
/*!40000 ALTER TABLE `fornecedores` DISABLE KEYS */;
INSERT INTO `fornecedores` VALUES (1,'24.388.525/0001-24','MARIGÁS COMERCO DE ÁGUA E GÁS - ME',0,'av DAS PALMEIRAS, 820','(44) 3030-1838 / 99999-5767','Maringá',NULL,NULL,'2025-02-06 15:01:43','2025-02-06 15:06:34'),(2,'01.769.471/0001-21','PLENO COMERCIO DE GÁS',1,'Av. Dr. Alexandre Rasgulaeff, 3389','(44) 3263-3211','Maringá',NULL,NULL,'2025-02-06 15:04:38','2025-02-06 15:04:38'),(3,'55.355.877/0001-01','CENTRAL DE REGISTROS LTDA',0,'AV. MANDACARU, 85','(44) 3265-8787','MARINGÁ',NULL,NULL,'2025-02-06 15:49:45','2025-02-06 15:49:45'),(4,'89.545.878/0001-25','C B TECH  INOVAÇÃO',0,'RUA CLEMENTE DE SOUZA, 80','(44) 9 9877-5478','Maringá',NULL,NULL,'2025-02-07 19:57:39','2025-02-07 19:57:39'),(5,'09.500.200.788/0001-45','Teste Manual',0,'Rua Exemplo, 100','(44) 99999-9999','Maringá','teste@teste.com',NULL,'2025-02-07 22:13:34','2025-02-07 22:13:34'),(7,'33.855.877/0001-01','COLCHOES MARILEN',0,'Rua Marechal Deodoro, 820','(44) 9 8745-5578','Maringá','resouza.guizi@gmail.com',NULL,'2025-02-07 22:41:21','2025-02-07 22:41:21'),(8,'69.585.354/0001-09','MARMITAS FATIMA',0,'AV. BARAO 525','4430301838','Maringá','re_souza_souza@hotmail.com',NULL,'2025-02-07 22:43:57','2025-02-07 22:44:14'),(9,'88.388.525/0001-44','FABRICA DE MOTORES',0,'Rua Marechal Deodoro, 820','4430301838','Maringá','re_souza_souza@hotmail.com',NULL,'2025-02-07 22:49:30','2025-02-07 22:49:30'),(10,'25.654.363/0001-24','FABRICA DE ABRAÇADEIRAS LTDA',0,'AV VISCONDE DE NASCAR, 87','(11) 3422-4548','SÃO PAULO',NULL,NULL,'2025-02-17 20:31:19','2025-02-17 20:33:04'),(11,'99.999.999/999-99','DESPESAS DIVERSAS',0,'DIVERSAS','4430301838','Maringá','re_souza_souza@hotmail.com',NULL,'2025-03-04 22:48:52','2025-03-04 22:48:52'),(12,'44.355.306/0001-36','Mineradora de Águas Genebra Ltda',1,'Estrada da Mina, s/n, Gleba Valencia','(44) 3248-1515','IGUARAÇU-PR','atendimento@aguasafira.com.br',NULL,'2026-01-10 22:10:56','2026-01-10 22:10:56'),(13,'99.999.999/0001-99','FORNECEDOR DIVERSOS',1,'AV PALMEIRAS','4430301838','MARINGÁ','re_souza_souza@hotmail.com',NULL,'2026-01-11 17:05:09','2026-01-11 17:05:09');
/*!40000 ALTER TABLE `fornecedores` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-01-27 11:51:10
