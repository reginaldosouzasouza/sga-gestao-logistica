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
-- Table structure for table `historico_ordem_servicos`
--

DROP TABLE IF EXISTS `historico_ordem_servicos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `historico_ordem_servicos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ordem_servico_id` bigint unsigned NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `movimentacao` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_alteracao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `historico_ordem_servicos_ordem_servico_id_foreign` (`ordem_servico_id`),
  CONSTRAINT `historico_ordem_servicos_ordem_servico_id_foreign` FOREIGN KEY (`ordem_servico_id`) REFERENCES `ordens_servico` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historico_ordem_servicos`
--

LOCK TABLES `historico_ordem_servicos` WRITE;
/*!40000 ALTER TABLE `historico_ordem_servicos` DISABLE KEYS */;
INSERT INTO `historico_ordem_servicos` VALUES (3,22,'Aberto','Aguard. Aprovação','2025-07-17 20:46:41','2025-07-17 20:46:41','2025-07-17 20:46:41'),(4,22,'Aberto','Aguard. Aprovação','2025-07-17 20:47:12','2025-07-17 20:47:12','2025-07-17 20:47:12'),(5,22,'Aberto','Aguard. Aprovação','2025-07-17 20:47:39','2025-07-17 20:47:39','2025-07-17 20:47:39'),(6,24,'Aberto','Criação da ordem de serviço','2025-07-18 16:34:20','2025-07-18 16:34:20','2025-07-18 16:34:20'),(7,25,'Aberto','Criação da ordem de serviço','2025-07-18 16:59:08','2025-07-18 16:59:08','2025-07-18 16:59:08'),(10,31,'Aberto','Orçamento','2025-07-19 01:11:43','2025-07-19 01:11:43','2025-07-19 01:11:43'),(11,31,'Aberto','esperando peças','2025-07-19 01:12:37','2025-07-19 01:12:37','2025-07-19 01:12:37'),(12,31,'Aberto','cliente pediu para aguardar.','2025-07-19 01:14:28','2025-07-19 01:14:28','2025-07-19 01:14:28'),(13,32,'Aberto','teste carro.','2025-07-19 01:17:38','2025-07-19 01:17:38','2025-07-19 01:17:38'),(23,37,'Aberto','teste após excclusão.','2025-07-20 17:35:36','2025-07-20 17:35:36','2025-07-20 17:35:36'),(24,37,'Aberto','aguardando peças, já pedido','2025-07-20 17:36:28','2025-07-20 17:36:28','2025-07-20 17:36:28'),(25,37,'Concluído','Status alterado para: Concluído','2025-07-20 17:37:55','2025-07-20 17:37:55','2025-07-20 17:37:55'),(26,37,'Concluído','veiculo retirado.','2025-07-20 17:37:55','2025-07-20 17:37:55','2025-07-20 17:37:55'),(27,36,'Aberto','Status alterado para: Aberto','2025-07-20 17:40:43','2025-07-20 17:40:43','2025-07-20 17:40:43'),(28,36,'Aberto','testes','2025-07-20 17:40:43','2025-07-20 17:40:43','2025-07-20 17:40:43'),(29,36,'Concluído','Status alterado para: Concluído','2025-07-20 17:41:52','2025-07-20 17:41:52','2025-07-20 17:41:52'),(30,36,'Concluído','serviço encerrado, aguardndo o acerto.','2025-07-20 17:41:52','2025-07-20 17:41:52','2025-07-20 17:41:52'),(31,32,'Concluído','Status alterado para: Concluído','2025-07-20 17:57:39','2025-07-20 17:57:39','2025-07-20 17:57:39'),(32,32,'Concluído','beleza','2025-07-20 17:57:39','2025-07-20 17:57:39','2025-07-20 17:57:39'),(33,8,'Aberto','Status alterado para: Aberto','2025-07-22 15:58:30','2025-07-22 15:58:30','2025-07-22 15:58:30'),(34,8,'Aberto','tetes aberto','2025-07-22 15:58:54','2025-07-22 15:58:54','2025-07-22 15:58:54'),(35,9,'Aberto','Status alterado para: Aberto','2025-07-22 15:59:24','2025-07-22 15:59:24','2025-07-22 15:59:24'),(36,9,'Aberto','aguardo aprovação','2025-07-22 15:59:24','2025-07-22 15:59:24','2025-07-22 15:59:24'),(37,9,'Aberto','em execução','2025-07-22 16:00:15','2025-07-22 16:00:15','2025-07-22 16:00:15'),(38,26,'Aberto','em execuçãi','2025-07-22 16:00:43','2025-07-22 16:00:43','2025-07-22 16:00:43'),(39,26,'Aberto','aguardandochegar mais peças','2025-07-22 16:01:24','2025-07-22 16:01:24','2025-07-22 16:01:24'),(40,26,'Aberto','aguardandochegar mais peças','2025-07-22 16:01:41','2025-07-22 16:01:41','2025-07-22 16:01:41'),(41,10,'Aberto','Status alterado para: Aberto','2025-07-22 16:07:26','2025-07-22 16:07:26','2025-07-22 16:07:26'),(42,10,'Aberto','aguard. aprovação','2025-07-22 16:07:26','2025-07-22 16:07:26','2025-07-22 16:07:26'),(43,11,'Aberto','Status alterado para: Aberto','2025-07-22 16:07:48','2025-07-22 16:07:48','2025-07-22 16:07:48'),(44,11,'Aberto','em execução','2025-07-22 16:07:48','2025-07-22 16:07:48','2025-07-22 16:07:48'),(45,12,'Aberto','Status alterado para: Aberto','2025-07-22 16:08:28','2025-07-22 16:08:28','2025-07-22 16:08:28'),(46,1,'Aberto','tetes','2025-07-22 18:57:37','2025-07-22 18:57:37','2025-07-22 18:57:37'),(47,1,'Aberto','em execução','2025-07-22 18:59:30','2025-07-22 18:59:30','2025-07-22 18:59:30'),(48,1,'Concluído','Status alterado para: Concluído','2025-07-22 19:00:46','2025-07-22 19:00:46','2025-07-22 19:00:46'),(49,1,'Concluído','pronto.','2025-07-22 19:00:46','2025-07-22 19:00:46','2025-07-22 19:00:46'),(50,38,'Aberto','agurd. aprovação','2025-07-22 22:11:42','2025-07-22 22:11:42','2025-07-22 22:11:42'),(51,38,'Aberto','testes','2025-07-22 22:44:53','2025-07-22 22:44:53','2025-07-22 22:44:53'),(52,39,'Aberto','em execução','2025-07-22 23:10:54','2025-07-22 23:10:54','2025-07-22 23:10:54'),(53,40,'Aberto','teste de data dt emissao 20/07  dt lancamento 22/07','2025-07-23 15:17:28','2025-07-23 15:17:28','2025-07-23 15:17:28'),(54,39,'Concluído','Status alterado para: Concluído','2025-07-23 15:51:22','2025-07-23 15:51:22','2025-07-23 15:51:22'),(55,39,'Concluído','só buscar.','2025-07-23 15:51:22','2025-07-23 15:51:22','2025-07-23 15:51:22'),(56,41,'Aberto','em execução','2025-07-23 16:38:31','2025-07-23 16:38:31','2025-07-23 16:38:31'),(57,42,'Aberto','Orçamento','2025-07-23 17:11:11','2025-07-23 17:11:11','2025-07-23 17:11:11'),(58,43,'Aberto','orçamento','2025-07-23 17:18:43','2025-07-23 17:18:43','2025-07-23 17:18:43'),(59,43,'Aberto','EM EXECUÇÃO','2025-07-23 17:20:35','2025-07-23 17:20:35','2025-07-23 17:20:35'),(60,43,'Aberto','Orçamento refeito aguardando aprovação.','2025-07-23 17:21:48','2025-07-23 17:21:48','2025-07-23 17:21:48'),(61,43,'Aberto','em execução com as peçs que chegaram','2025-07-23 17:23:03','2025-07-23 17:23:03','2025-07-23 17:23:03'),(62,43,'Concluído','Status alterado para: Concluído','2025-07-23 17:23:34','2025-07-23 17:23:34','2025-07-23 17:23:34'),(63,43,'Concluído','pronto.','2025-07-23 17:23:34','2025-07-23 17:23:34','2025-07-23 17:23:34');
/*!40000 ALTER TABLE `historico_ordem_servicos` ENABLE KEYS */;
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
