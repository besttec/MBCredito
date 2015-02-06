CREATE DATABASE  IF NOT EXISTS `mbcredito` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `mbcredito`;
-- MySQL dump 10.13  Distrib 5.5.40, for debian-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: mbcredito
-- ------------------------------------------------------
-- Server version	5.5.40-0ubuntu0.14.04.1

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
-- Table structure for table `Documento`
--

DROP TABLE IF EXISTS `Documento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Documento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Documento`
--

LOCK TABLES `Documento` WRITE;
/*!40000 ALTER TABLE `Documento` DISABLE KEYS */;
INSERT INTO `Documento` VALUES (1,'03aaa134329dc9312110d0a844381163c30c3dd2','Av Livramento 541 a 585.csv','2015-01-23 10:09:53');
/*!40000 ALTER TABLE `Documento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ag`
--

DROP TABLE IF EXISTS `ag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ag` (
  `id_ag` int(11) NOT NULL AUTO_INCREMENT,
  `prefixo_ag` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `nome_ag` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cc_ag` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_ag`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ag`
--

LOCK TABLES `ag` WRITE;
/*!40000 ALTER TABLE `ag` DISABLE KEYS */;
INSERT INTO `ag` VALUES (1,'1600','RUA DO LIVRAMENTO','31840'),(2,'1600','RUA DO LIVRAMENTO','32853'),(3,'1600','RUA DO LIVRAMENTO','38567'),(4,'1600','RUA DO LIVRAMENTO','35234'),(5,'1600','RUA DO LIVRAMENTO','61967'),(6,'1600','RUA DO LIVRAMENTO','36117'),(7,'1600','RUA DO LIVRAMENTO','36262'),(8,'1600','RUA DO LIVRAMENTO','53430'),(9,'1600','RUA DO LIVRAMENTO','46660'),(10,'1600','RUA DO LIVRAMENTO','36788'),(11,'1600','RUA DO LIVRAMENTO','42775'),(12,'1600','RUA DO LIVRAMENTO','49679'),(13,'1600','RUA DO LIVRAMENTO','38876'),(14,'1600','RUA DO LIVRAMENTO','65539'),(15,'1600','RUA DO LIVRAMENTO','39213'),(16,'1600','RUA DO LIVRAMENTO','39693'),(17,'1600','RUA DO LIVRAMENTO','41783'),(18,'1600','RUA DO LIVRAMENTO','50788'),(19,'1600','RUA DO LIVRAMENTO','62042'),(20,'1600','RUA DO LIVRAMENTO','40662'),(21,'1600','RUA DO LIVRAMENTO','40745'),(22,'1600','RUA DO LIVRAMENTO','61978'),(23,'1600','RUA DO LIVRAMENTO','42358'),(24,'1600','RUA DO LIVRAMENTO','58026'),(25,'1600','RUA DO LIVRAMENTO','43313'),(26,'1600','RUA DO LIVRAMENTO','43352'),(27,'1600','RUA DO LIVRAMENTO','67920'),(28,'1600','RUA DO LIVRAMENTO','43558'),(29,'1600','RUA DO LIVRAMENTO','41833'),(30,'1600','RUA DO LIVRAMENTO','45518'),(31,'1600','RUA DO LIVRAMENTO','58164'),(32,'1600','RUA DO LIVRAMENTO','62055'),(33,'1600','RUA DO LIVRAMENTO','62113'),(34,'1600','RUA DO LIVRAMENTO','49461'),(35,'1600','RUA DO LIVRAMENTO','61904'),(36,'1600','RUA DO LIVRAMENTO','59972'),(37,'1600','RUA DO LIVRAMENTO','47031'),(38,'1600','RUA DO LIVRAMENTO','62238'),(39,'1600','RUA DO LIVRAMENTO','61885'),(40,'1600','RUA DO LIVRAMENTO','49015'),(41,'1600','RUA DO LIVRAMENTO','49214'),(42,'1600','RUA DO LIVRAMENTO','49613'),(43,'1600','RUA DO LIVRAMENTO','49659'),(44,'1600','RUA DO LIVRAMENTO','50224'),(45,'1600','RUA DO LIVRAMENTO','56514');
/*!40000 ALTER TABLE `ag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chamada_cliente`
--

DROP TABLE IF EXISTS `chamada_cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chamada_cliente` (
  `id_chamada_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `status_id_status` int(11) DEFAULT NULL,
  `user_id_user` int(11) DEFAULT NULL,
  `id_onsulta_cliente` int(11) DEFAULT NULL,
  `subrotinas_id_subrotina` int(11) DEFAULT NULL,
  `status_pendencia` tinyint(1) DEFAULT NULL,
  `status_chamada` tinyint(1) DEFAULT NULL,
  `data_chamada` datetime DEFAULT NULL,
  `data_pendencia` datetime NOT NULL,
  `observacao` text COLLATE utf8_unicode_ci,
  `novo_ddd` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `novo_fone` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_chamada_cliente`),
  KEY `IDX_B9B40E7BD5A250B0` (`status_id_status`),
  KEY `IDX_B9B40E7B5EBED441` (`user_id_user`),
  KEY `IDX_B9B40E7B91620471` (`subrotinas_id_subrotina`),
  KEY `IDX_B9B40E7BDFA86BDD` (`id_onsulta_cliente`),
  CONSTRAINT `FK_B9B40E7BDFA86BDD` FOREIGN KEY (`id_onsulta_cliente`) REFERENCES `consulta_cliente` (`id`),
  CONSTRAINT `FK_B9B40E7B5EBED441` FOREIGN KEY (`user_id_user`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_B9B40E7B91620471` FOREIGN KEY (`subrotinas_id_subrotina`) REFERENCES `subrotinas` (`id_subrotina`),
  CONSTRAINT `FK_B9B40E7BD5A250B0` FOREIGN KEY (`status_id_status`) REFERENCES `status` (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chamada_cliente`
--

LOCK TABLES `chamada_cliente` WRITE;
/*!40000 ALTER TABLE `chamada_cliente` DISABLE KEYS */;
INSERT INTO `chamada_cliente` VALUES (1,2,2,1,2,0,0,'2015-02-03 10:06:00','2015-02-03 10:06:09','TESTE','81','12345678'),(2,1,2,1,6,0,0,NULL,'2015-02-03 10:08:04','Finalizado','','');
/*!40000 ALTER TABLE `chamada_cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `super_estadual_id_super_estadual` int(11) DEFAULT NULL,
  `ag_id_ag` int(11) DEFAULT NULL,
  `super_regional_id_super_regional` int(11) DEFAULT NULL,
  `sexos_id_sexo` int(11) DEFAULT NULL,
  `convenio_id` int(11) DEFAULT NULL,
  `nome_cliente` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cpf_cliente` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `limite_credito_cliente` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ddd_fone_resid_cliente` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fone_resid_cliente` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ddd_fone_comer_cliente` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fone_comer_cliente` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ddd_fone_cel_cliente` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fone_cel_cliente` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ddd_fone_pref_cliente` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fone_pref_cliente` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cod_cliente` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data_nasc_cliente` date DEFAULT NULL,
  `num_beneficio_cliente` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dv_cliente` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `num_beneficio_comp_cliente` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status_emChamada` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_cliente`),
  KEY `IDX_50FE07D7A892A8ED` (`super_estadual_id_super_estadual`),
  KEY `IDX_50FE07D7221C05FD` (`ag_id_ag`),
  KEY `IDX_50FE07D75B0025D3` (`super_regional_id_super_regional`),
  KEY `IDX_50FE07D7A3EB2A0F` (`sexos_id_sexo`),
  KEY `IDX_50FE07D7F9D43F2A` (`convenio_id`),
  CONSTRAINT `FK_50FE07D7221C05FD` FOREIGN KEY (`ag_id_ag`) REFERENCES `ag` (`id_ag`),
  CONSTRAINT `FK_50FE07D75B0025D3` FOREIGN KEY (`super_regional_id_super_regional`) REFERENCES `super_regional` (`id_super_regional`),
  CONSTRAINT `FK_50FE07D7A3EB2A0F` FOREIGN KEY (`sexos_id_sexo`) REFERENCES `sexos` (`id_sexo`),
  CONSTRAINT `FK_50FE07D7A892A8ED` FOREIGN KEY (`super_estadual_id_super_estadual`) REFERENCES `super_estadual` (`id_super_estadual`),
  CONSTRAINT `FK_50FE07D7F9D43F2A` FOREIGN KEY (`convenio_id`) REFERENCES `convenio` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (1,1,1,1,2,1,'MARIA DE LOURDES ARAUJO DE CARVALHO','25952617468','BB CREDITO CONSIGNACAO','','','','','82','91130079','82','91130079','917744186','1949-12-14','77540054','8','0775400548',0),(2,1,2,1,2,1,'EULINA LOPES DE SANTANNA','18505600487','BB CREDITO CONSIGNACAO','82','33281766','','','82','88812860','82','33281766','918598418','1940-05-04','73782249','0','0737822490',0),(3,1,3,1,1,1,'ELIAS JOSE DOS SANTOS','19714297400','BB CREDITO CONSIGNACAO','82','33281177','','','82','88266972','82','33281177','919727912','1957-11-07','543260794','4','5432607944',0),(4,1,4,1,2,1,'MARIA DE FATIMA REGO','20876050410','BB CREDITO CONSIGNACAO','','','','','82','88765194','82','88384147','920749158','1957-03-08','144587848','5','1445878485',0),(5,1,5,1,2,1,'TANIA NUBIA DE ARAUJO SILVA','2064378464','BB CREDITO CONSIGNACAO','','','','','82','88117570','82','99158013','921064293','1956-03-20','136075474','9','1360754749',0),(6,1,6,1,2,1,'MARIA TEREZA DOS SANTOS','89457439449','BB CREDITO CONSIGNACAO','82','91997022','','','82','93089290','82','91997022','921731797','1943-11-22','102590973','6','1025909736',0),(7,1,7,1,1,1,'MAGNO ALEXANDRE CAVALCANTI CERQUEIRA','13995073468','BB CREDITO CONSIGNACAO','','','','','82','91163783','','','922080580','1951-08-07','77540045','9','0775400459',0),(8,1,8,1,2,1,'JOSINETE DE BARROS LIMA','50539680478','BB CREDITO BENEFICIO','82','33160981','82','30335993','82','99275537','82','33160981','922089014','1950-08-04','152635224','6','1526352246',0),(9,1,9,1,2,1,'BENEDITA VALDIVINO DE ANDRADE','912637439','BB CREDITO CONSIGNACAO','82','33221132','','','82','88640040','82','33221132','922297691','1939-07-22','129855150','9','1298551509',0),(10,1,10,1,2,1,'JULIETA MOURA DOS SANTOS','4373343411','BB CREDITO CONSIGNACAO','','','','','82','96659316','82','96659316','922530841','1949-05-18','169300165','6','1693001656',0),(11,1,11,1,2,1,'MONICA MEDEIROS GOMES SILVA','30860034801','BB CREDITO CONSIGNACAO','82','33544542','','','82','99587873','82','88463412','923483104','1977-10-14','107137613','3','1071376133',0),(12,1,12,1,2,1,'MARIA IZABEL SANTOS VIEIRA','21028540434','BB CREDITO CONSIGNACAO','82','32319089','','','82','87538409','82','87538409','923802714','1945-07-04','','0','0000000000',0),(13,1,13,1,1,1,'JOAO HERCULANO BATISTA','2485768447','BB CREDITO CONSIGNACAO','82','32411549','','','82','99772182','82','99772182','924142272','1974-04-18','536269808','3','5362698083',0),(14,1,14,1,2,1,'MARIA JOSE DOS SANTOS','20810717468','BB CREDITO CONSIGNACAO','82','33422937','82','33587059','','','82','33422937','924308575','1950-04-06','28332221','7','0283322217',0),(15,1,15,1,1,1,'AILTON DA SILVA','56803710815','BB CREDITO CONSIGNACAO','82','33224551','','','','','82','33224551','924508495','1948-07-03','68102842','4','0681028424',0),(16,1,16,1,2,1,'MARIA JOSE DE OMENA BENTO','98641948449','BB CREDITO CONSIGNACAO','82','32315048','','','82','88013183','82','32315048','924929451','1953-03-12','126926797','0','1269267970',0),(17,1,17,1,2,1,'MARIA DA SOLIDADE BARBOSA DE OLIVEIRA','5943395458','BB CREDITO CONSIGNACAO','82','33361268','','','82','93526737','82','93526737','925855745','1962-07-30','128726357','4','1287263574',0),(18,1,18,1,2,1,'MARIA VERA LUCIA SILVA DELFINO','64798011487','BB CREDITO CONSIGNACAO','82','32417499','','','82','91853246','82','32417499','926077740','1968-12-25','126835789','5','1268357895',0),(19,1,19,1,2,1,'ESTER MARIA PEIXOTO DE MELO','2752161441','BB CREDITO BENEFICIO','','','','','82','99772814','82','99772814','926640517','1945-11-19','514726909','2','5147269092',0),(20,1,20,1,1,1,'JOSE FREIRE DE LIMA','11148632468','BB CREDITO CONSIGNACAO','82','30336864','','','','','82','30336864','926649909','1949-09-03','127299096','3','1272990963',0),(21,1,21,1,2,1,'CREUSA ROBERTO DE OLIVEIRA','38375354449','BB CREDITO CONSIGNACAO','82','32342619','','','82','88114513','82','88114513','926774441','1943-08-15','122291174','1','1222911741',0),(22,1,22,1,2,1,'ALAIDE ALEXANDRE DA SILVA','3798034885','BB CREDITO CONSIGNACAO','','','','','82','88131638','82','88279055','927573810','1949-01-01','506925522','0','5069255220',0),(23,1,23,1,1,1,'JOSE RONALDO GOMES DE ARAUJO','341673404','BB CREDITO CONSIGNACAO','82','32606510','','','82','88063076','82','32606510','927806094','1945-06-04','28305593','6','0283055936',0),(24,1,24,1,2,1,'MARIA JOSE ALVES DA SILVA','1443505480','BB CREDITO CONSIGNACAO','82','32233654','','','82','88932163','82','32233654','928574756','1950-06-09','56494420','3','0564944203',0),(25,1,25,1,2,1,'ANTONIA MARIA DA CONCEICAO','31864902434','BB CREDITO CONSIGNACAO','82','33769132','','','82','88904087','82','33769132','928844386','1940-05-10','506067936','1','5060679361',0),(26,1,26,1,2,1,'MARIA JANE DE AZEVEDO VALENCA','13394991420','BB CREDITO CONSIGNACAO','82','32415420','','','82','93230312','82','32415420','928888577','1942-01-30','92847323','6','0928473236',0),(27,1,27,1,2,1,'CICERA CORREIA DA SILVA','51686694415','BB CREDITO CONSIGNACAO','','','','','82','99302035','82','99302035','928938125','1950-06-18','530944330','0','5309443300',0),(28,1,28,1,2,1,'LUZIA MARIA DA CONCEICAO','48413941415','BB CREDITO CONSIGNACAO','82','33786486','','','82','99760767','82','33267155','929027511','1944-10-20','119570199','0','1195701990',0),(29,1,29,1,2,1,'ERONITA MARIA DOS SANTOS','20884435415','BB CREDITO CONSIGNACAO','82','99191415','','','','','82','99191415','929948572','1942-07-10','71758153','5','0717581535',0),(30,1,30,1,2,1,'MARIA SONIA DA SILVA VENANCIO','78795478434','BB CREDITO CONSIGNACAO','82','33512435','82','88312662','82','99259097','82','33512435','930742009','1958-11-16','84661121','0','0846611210',0),(31,1,31,1,2,1,'DULCILENE ARAUJO DOS SANTOS','16380819487','BB CREDITO CONSIGNACAO','82','99512930','82','88415387','82','81355442','82','88037896','931230392','1955-03-21','84576127','7','0845761277',0),(32,1,32,1,2,1,'GERUSA ALVES DA SILVA ARAUJO','92619525420','BB CREDITO CONSIGNACAO','','','','','82','88291114','82','88291114','931829407','1964-12-15','132236591','9','1322365919',0),(33,1,33,1,1,1,'MANOEL RIBEIRO DA SILVA','66412897887','BB CREDITO CONSIGNACAO','82','33266915','','','82','88235939','82','88235939','931850364','1948-08-22','515300262','0','5153002620',0),(34,1,34,1,2,1,'MARIA JOSE DA SILVA LUCENA','42599342449','BB CREDITO CONSIGNACAO','82','33586052','','','','','82','33586052','932325851','1943-09-02','131549201','3','1315492013',0),(35,1,35,1,2,1,'MARIA MADALENA FERREIRA DOS SANTOS','38304511487','BB CREDITO CONSIGNACAO','','','','','82','88569446','82','88569446','932892425','1957-12-17','134003983','1','1340039831',0),(36,1,36,1,2,1,'MARIA SALETE FLORENTINO CORREIA','66156467491','BB CREDITO CONSIGNACAO','82','30340186','','','82','88516112','82','88516112','932924071','1942-03-21','520402481','2','5204024812',0),(37,1,37,1,2,1,'MARIA DAS GRACAS DOS SANTOS','14812479487','BB CREDITO CONSIGNACAO','82','33151820','82','99502425','82','99717129','82','33151820','932944413','1957-02-22','147429447','0','1474294470',0),(38,1,38,1,2,1,'ANTONIA LEANDRO SILVA','11259795420','BB CREDITO CONSIGNACAO','82','30352775','','','82','88025654','82','30352775','934871669','1942-04-21','119157035','2','1191570352',0),(39,1,39,1,1,1,'JOSE FRANCISCO DA ROCHA','11293055468','BB CREDITO CONSIGNACAO','','','','','82','88593334','82','99008860','934891282','1949-08-21','119948372','6','1199483726',0),(40,1,40,1,2,1,'IZABEL TEIXEIRA MARQUES','21048606449','BB CREDITO CONSIGNACAO','','','','','82','88448747','82','88448747','935091108','1956-11-16','544107199','7','5441071997',0),(41,1,41,1,1,1,'CICERO JOSE DOS SANTOS','14432846453','BB CREDITO CONSIGNACAO','','','','','82','81591255','','','935305683','1950-03-10','124522020','6','1245220206',0),(42,1,42,1,2,1,'MARIA JOSE PAULA DOS SANTOS','38255707468','BB CREDITO CONSIGNACAO','82','57014510','','','82','88789624','82','30338985','935747150','1954-04-06','126622791','9','1266227919',0),(43,1,43,1,2,1,'NILZA DOS SANTOS NASCIMENTO','26740460400','BB CREDITO CONSIGNACAO','82','33286598','','','82','88617189','82','88617189','935769880','1942-04-24','134627337','2','1346273372',0),(44,1,44,1,2,1,'JOSEFA QUITERIA DOS SANTOS','24062332434','BB CREDITO CONSIGNACAO','82','30340094','','','82','88363574','82','88363574','936371338','1948-10-22','47474067','6','0474740676',0),(45,1,45,1,2,1,'MARIA EDILEUZA SANTOS DA SILVA','1670755193','BB CREDITO CONSIGNACAO','82','30343466','','','82','88760725','82','30343466','936956300','1976-09-27','136521562','5','1365215625',0);
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consulta_cliente`
--

DROP TABLE IF EXISTS `consulta_cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consulta_cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clientes_id_cliente` int(11) DEFAULT NULL,
  `valor_bruto` decimal(10,2) DEFAULT NULL,
  `valor_descontos` decimal(10,2) DEFAULT NULL,
  `valor_liquido` decimal(10,2) DEFAULT NULL,
  `qtd_emprestimos` int(11) DEFAULT NULL,
  `nome_segurado` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `competencia` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pagto_atravez` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `periodo_ini` date DEFAULT NULL,
  `periodo_fin` date DEFAULT NULL,
  `especie` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `banco` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `agencia` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `codigo_agencia` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `endereco_banco` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `disponibilidade_ini` date DEFAULT NULL,
  `disponibilidade_fin` date DEFAULT NULL,
  `obs_cliente` text COLLATE utf8_unicode_ci,
  `margem_cliente` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `valor_disponivel_cliente` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipo_credito_cliente` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status_ligacao_cliente` tinyint(1) DEFAULT NULL COMMENT 'Define o status em caso de disponível',
  `status_consulta` tinyint(1) DEFAULT NULL,
  `status_erro_consulta` tinyint(1) DEFAULT NULL COMMENT 'Define o status em caso de erro ao consultar o cliente',
  `obs_erro_consulta` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_1D17D9928660CFA2` (`clientes_id_cliente`),
  CONSTRAINT `FK_1D17D9928660CFA2` FOREIGN KEY (`clientes_id_cliente`) REFERENCES `clientes` (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consulta_cliente`
--

LOCK TABLES `consulta_cliente` WRITE;
/*!40000 ALTER TABLE `consulta_cliente` DISABLE KEYS */;
INSERT INTO `consulta_cliente` VALUES (1,38,788.00,144.79,643.21,2,'ANTONIA LEANDRO SILVA','01/2015','CONTA CORRENTE','2015-01-01','2015-01-31','42 APOSENTADORIA POR TEMPO DE CONTRIBUICAO','BRASIL','RUA DO LIVRAMENTO-MACEIO','408135','RUA DO LIVRAMENTO, 120 - DO SUBSOLO AO 3 ANDAR','2015-01-30','2015-03-31','TESTE','123','1234','2',0,1,0,NULL);
/*!40000 ALTER TABLE `consulta_cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `convenio`
--

DROP TABLE IF EXISTS `convenio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `convenio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mci_emp_cliente` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nome_convenio` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `convenio`
--

LOCK TABLES `convenio` WRITE;
/*!40000 ALTER TABLE `convenio` DISABLE KEYS */;
INSERT INTO `convenio` VALUES (1,'103824079','INSS');
/*!40000 ALTER TABLE `convenio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `convenio_pa`
--

DROP TABLE IF EXISTS `convenio_pa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `convenio_pa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `convenio_id` int(11) DEFAULT NULL,
  `user_id_user` int(11) DEFAULT NULL,
  `data` datetime NOT NULL,
  `estado` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_12BE62BDF9D43F2A` (`convenio_id`),
  KEY `IDX_12BE62BD5EBED441` (`user_id_user`),
  CONSTRAINT `FK_12BE62BD5EBED441` FOREIGN KEY (`user_id_user`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_12BE62BDF9D43F2A` FOREIGN KEY (`convenio_id`) REFERENCES `convenio` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `convenio_pa`
--

LOCK TABLES `convenio_pa` WRITE;
/*!40000 ALTER TABLE `convenio_pa` DISABLE KEYS */;
INSERT INTO `convenio_pa` VALUES (1,1,2,'2015-01-23 12:49:49','AL');
/*!40000 ALTER TABLE `convenio_pa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `emprestimos`
--

DROP TABLE IF EXISTS `emprestimos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `emprestimos` (
  `id_emprestimo` int(11) NOT NULL AUTO_INCREMENT,
  `emprestimo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `status_bb_emprestimo` tinyint(1) DEFAULT NULL,
  `consulta_cliente_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_emprestimo`),
  KEY `IDX_5E9BC584BFF5222` (`consulta_cliente_id`),
  CONSTRAINT `FK_5E9BC584BFF5222` FOREIGN KEY (`consulta_cliente_id`) REFERENCES `consulta_cliente` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emprestimos`
--

LOCK TABLES `emprestimos` WRITE;
/*!40000 ALTER TABLE `emprestimos` DISABLE KEYS */;
INSERT INTO `emprestimos` VALUES (1,'Consig. Emprest.',109.00,1,1),(2,'Consig. Emprest.',35.79,NULL,1);
/*!40000 ALTER TABLE `emprestimos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B63E2EC757698A6A` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'ADMIN','ROLE_ADMIN'),(2,'PA','ROLE_PA');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sexos`
--

DROP TABLE IF EXISTS `sexos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sexos` (
  `id_sexo` int(11) NOT NULL AUTO_INCREMENT,
  `nome_abreviatura_sexo` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nome_extenso_sexo` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_sexo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sexos`
--

LOCK TABLES `sexos` WRITE;
/*!40000 ALTER TABLE `sexos` DISABLE KEYS */;
INSERT INTO `sexos` VALUES (1,'M','Masculino'),(2,'F','Feminino');
/*!40000 ALTER TABLE `sexos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status` (
  `id_status` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `codigo` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` VALUES (1,'FINALIZADO','01'),(2,'NÃO CONTATADO','02');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subrotinas`
--

DROP TABLE IF EXISTS `subrotinas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subrotinas` (
  `id_subrotina` int(11) NOT NULL AUTO_INCREMENT,
  `status_id_status` int(11) DEFAULT NULL,
  `subrotina` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `codigo_subrotina` int(11) NOT NULL,
  PRIMARY KEY (`id_subrotina`),
  KEY `IDX_E98469F0D5A250B0` (`status_id_status`),
  CONSTRAINT `FK_E98469F0D5A250B0` FOREIGN KEY (`status_id_status`) REFERENCES `status` (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subrotinas`
--

LOCK TABLES `subrotinas` WRITE;
/*!40000 ALTER TABLE `subrotinas` DISABLE KEYS */;
INSERT INTO `subrotinas` VALUES (1,2,'Telefone inválido/desatualizado',13),(2,2,'Ligação atendida, mas Cliente Ausente',18),(3,2,'Ligação Não Atendida',19),(4,2,'Dados Divergentes na Identificação Positiva',20),(5,2,'Cliente Falecido',21),(6,1,'Produto Vendido ou Serviço Contratado',1),(7,1,'Demostrou Interesse, Mas Não Atende Requisito',12),(8,1,'Demostrou interesse e iá analizar a proposta',55),(9,1,'Não Demostrou Interesse',16),(10,1,'Não Quer Tratar Deste Assunto po Telefone',19),(11,1,'Não Quer Receber Nenhum Contato Telefônico',20);
/*!40000 ALTER TABLE `subrotinas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `super_estadual`
--

DROP TABLE IF EXISTS `super_estadual`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `super_estadual` (
  `id_super_estadual` int(11) NOT NULL AUTO_INCREMENT,
  `cod_super_estadual` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `nome_super_estadual` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `uf` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_super_estadual`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `super_estadual`
--

LOCK TABLES `super_estadual` WRITE;
/*!40000 ALTER TABLE `super_estadual` DISABLE KEYS */;
INSERT INTO `super_estadual` VALUES (1,'8493','SUPER VAR E GOV AL','AL');
/*!40000 ALTER TABLE `super_estadual` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `super_regional`
--

DROP TABLE IF EXISTS `super_regional`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `super_regional` (
  `id_super_regional` int(11) NOT NULL AUTO_INCREMENT,
  `cod_super_regional` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `nome_super_regional` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_super_regional`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `super_regional`
--

LOCK TABLES `super_regional` WRITE;
/*!40000 ALTER TABLE `super_regional` DISABLE KEYS */;
INSERT INTO `super_regional` VALUES (1,'8393','GEREV MACEIO AL');
/*!40000 ALTER TABLE `super_regional` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `IDX_2DE8C6A3A76ED395` (`user_id`),
  KEY `IDX_2DE8C6A3D60322AC` (`role_id`),
  CONSTRAINT `FK_2DE8C6A3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_2DE8C6A3D60322AC` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role`
--

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` VALUES (1,1),(2,2),(3,2);
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E9F85E0677` (`username`),
  UNIQUE KEY `UNIQ_1483A5E9E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'fabio','$2y$13$8c141f37200659a0c245fuhdSB2NYBErYsHMFICB/2NLyDV45EG.a','fabio@gmail.com',1,'8c141f37200659a0c245f8e8e978227d'),(2,'andrey','$2y$13$fa38f85286bd0b958c3eaORop0ifSzTjbBxHGHeyTbuB1AGPM4Ysq','andrey@gmail.com',1,'fa38f85286bd0b958c3eaa19ee5125a2'),(3,'paulete','$2y$13$64a9947c8c27bf1eacd08u/5jw7jqHOYNOUbQWc94FX8tZNxGikAi','paulete@email.com',1,'64a9947c8c27bf1eacd08220fa1206a5');
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

-- Dump completed on 2015-02-03 10:20:56
