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
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2024_08_24_123914_create_clientes_table',1),(5,'2024_08_24_212913_create_fornecedores_table',1),(6,'2024_08_27_190653_create_produtos_table',1),(7,'2024_08_29_190226_create_compras_table',1),(8,'2024_08_30_183837_create_formas_de_pagamento_table',1),(9,'2024_08_30_191616_create_formas_de_pagamentos_table',1),(10,'2024_09_04_164230_create_pedido_de_coletas_table',1),(11,'2024_09_13_134133_create_pedidos_de_coleta_table',2),(13,'2024_09_05_141304_add_controle_de_coleta_to_pedidos_de_coleta_table',3),(14,'2024_09_05_215516_alter_telefone_length_in_pedidos_de_coleta',4),(15,'2024_09_06_202817_modify_cpf_column_in_clientes_table',4),(16,'2024_09_07_185511_alter_controle_de_coleta_column_in_pedidos_de_coleta_table',4),(17,'2024_09_07_204354_create_movimentacao_table',4),(18,'2024_09_07_215532_add_pedido_de_coleta_id_to_movimentacao_table',4),(19,'2024_09_07_221624_remove_pedido_id_from_movimentacao_table',4),(20,'2024_09_08_174032_create_movimento_total_table',4),(21,'2024_09_13_202923_add_cpf_to_pedidos_de_coleta_table',4),(22,'2024_09_16_172801_drop_pedidos_de_coleta_table',5),(23,'2024_09_16_174128_create_mov_coletas_table',5),(24,'2024_09_18_181745_create_prazos_table',6),(25,'2024_09_18_182949_add_prazo_id_to_compras_table',6),(26,'2024_09_18_211857_add_nota_fiscal_and_observacao_to_compras_table',6),(27,'2024_09_18_212443_add_data_compra_to_compras_table',6),(28,'2024_09_20_140023_create_estoques_table',7),(29,'2024_09_23_173148_drop_movimentacao_and_movimento_total_tables',7),(30,'2024_09_23_180009_create_movimentacao_table',7),(63,'2024_09_23_181155_create_movimentacaos_table',8),(64,'2024_09_25_215854_create_movimentacao_items_table',8),(65,'2024_10_01_184404_add_forma_pagamento_and_prazo_to_movimentacao_table',8),(66,'2024_10_01_205125_add_valor_total_to_movimentacao_table',8),(67,'2025_02_13_113150_add_data_coleta_to_movimentacao_table',9),(68,'2025_02_13_115144_add_cliente_id_to_movimentacao_table',10),(69,'2025_02_13_125853_add_quantidade_to_movimentacao_table',11),(70,'2024_11_02_164411_create_itens_de_compras_table',12),(71,'2025_02_06_203949_add_data_vencimento_to_compras_table',13),(72,'2025_02_07_180556_add_status_and_data_pagamento_to_compras',14),(73,'2024_10_17_120057_create_contas_a_pagar_table',15),(74,'2025_02_17_114811_add_data_compra_to_contas_a_pagar',16),(75,'2024_10_29_211909_add_prazo_to_contas_a_pagar',17),(76,'2024_11_01_214539_alter_prazo_column_in_contas_a_pagar',18),(77,'2024_10_11_212235_add_estoque_minimo_to_produtos_table',19),(78,'2025_02_06_114924_add_codigo_barras_to_produtos_table',20),(79,'2025_02_07_191007_add_observacao_to_fornecedores',21),(80,'2024_10_17_120231_create_contas_a_receber_table',22),(81,'2024_10_22_150834_add_data_venda_to_contas_a_receber_table',23),(82,'2024_10_22_195506_add_prazo_to_contas_a_receber_table',24),(83,'2025_02_22_145055_add_tipo_to_users_table',25),(84,'2025_02_28_125554_create_caixa_table',26),(85,'2025_03_14_161923_update_users_table',27),(86,'2025_06_03_143849_create_ordens_servico_table',28),(87,'2025_06_03_160302_create_veiculos_table',29),(88,'2024_10_10_172404_modify_quantidade_in_movimentacao_table',30),(89,'2025_06_04_133428_create_mecanicos_table',31),(90,'2025_06_04_212243_add_mecanico_to_ordens_servico_table',32),(91,'2025_06_04_204724_add_km_to_ordens_servico_table',33),(92,'2025_06_08_150437_add_campos_faltantes_to_ordens_servico_table',34),(93,'2025_06_13_160639_add_modulo_to_produtos_table',35),(94,'2025_06_13_201434_create_modulos_table',36),(95,'2025_06_14_154045_remove_modulo_from_produtos_table',37),(96,'2025_06_14_154332_add_foreign_key_modulo_to_produtos_table',38),(97,'2025_06_28_140922_add_data_lancamento_to_ordens_servico_table',39),(98,'2025_07_13_132814_create_movimentacoes_os_table',40),(99,'2025_07_13_134017_add_movimentacao_os_id_to_ordens_servico_table',41),(100,'2025_07_13_160825_create_historico_ordem_servicos_table',42),(101,'2026_01_08_213420_add_ativo_to_fornecedores_table',43),(102,'2026_01_16_155104_create_caixas_table',44),(103,'2026_01_16_155246_create_caixa_movimentacoes_table',45),(104,'2026_01_19_152203_create_banco_movimentacoes_table',46),(105,'2026_01_25_204620_create_caixa_table',47),(106,'2026_01_25_204728_create_caixa_banco_table',48),(107,'2026_01_25_222335_create_fechamentos_caixa_table',49);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-01-27 11:51:11
