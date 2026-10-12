-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           8.4.3 - MySQL Community Server - GPL
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para concessionaria
CREATE DATABASE IF NOT EXISTS `concessionaria` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `concessionaria`;

-- Copiando estrutura para tabela concessionaria.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `nome_usuario_adm` varchar(255) NOT NULL,
  `senha_adm` varchar(100) NOT NULL,
  PRIMARY KEY (`nome_usuario_adm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela concessionaria.admin: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela concessionaria.carro
CREATE TABLE IF NOT EXISTS `carro` (
  `id_car` int NOT NULL AUTO_INCREMENT,
  `marca_car` varchar(100) NOT NULL,
  `modelo_car` varchar(100) NOT NULL,
  `ano_car` year NOT NULL,
  `cor_car` varchar(50) NOT NULL,
  `preco_car` decimal(10,2) NOT NULL,
  `quilometragem_car` int NOT NULL,
  `combustivel_car` varchar(30) NOT NULL,
  `descricao_car` varchar(700) NOT NULL,
  `foto_car` varchar(255) NOT NULL,
  `status_car` tinyint(1) DEFAULT '0',
  `data_car` date DEFAULT NULL,
  PRIMARY KEY (`id_car`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela concessionaria.carro: ~7 rows (aproximadamente)
REPLACE INTO `carro` (`id_car`, `marca_car`, `modelo_car`, `ano_car`, `cor_car`, `preco_car`, `quilometragem_car`, `combustivel_car`, `descricao_car`, `foto_car`, `status_car`, `data_car`) VALUES
	(1, 'Ferrari', 'H66', '2026', 'Azul', 2000000.00, 200000, 'Gasolina', 'Última geração', '/Plataforma-A7car/img/uploads/veiculos/img_6acd397e1549e.webp', 0, '2026-10-12'),
	(2, 'Volkswagen', 'LP44', '2001', 'Vermelho', 45023.00, 10000, 'Gasolina', 'Reformado', '/Plataforma-A7car/img/uploads/veiculos/img_6acd39b9e8fb6.webp', 0, '2026-10-12'),
	(3, 'Volkswagen', 'OV95', '2015', 'Azul bebê', 140000.00, 9000, 'Gasolina', 'Reformado', '/Plataforma-A7car/img/uploads/veiculos/img_6acd39d7e6ddd.jpg', 0, '2026-10-12'),
	(4, 'Jaguar', 'Type-1', '2026', 'Prateado', 3000000.00, 10, 'Gasolina', 'Última geração', '/Plataforma-A7car/img/uploads/veiculos/img_6acd3b7137db0.jpg', 1, '2026-10-12');

-- Copiando estrutura para tabela concessionaria.cliente
CREATE TABLE IF NOT EXISTS `cliente` (
  `id_cli` int NOT NULL AUTO_INCREMENT,
  `nome_cli` varchar(255) NOT NULL,
  `email_cli` varchar(255) NOT NULL,
  `telefone_cli` varchar(15) NOT NULL,
  `cpf_cli` varchar(14) NOT NULL,
  `cnh_cli` varchar(11) NOT NULL,
  PRIMARY KEY (`id_cli`),
  UNIQUE KEY `email_cli` (`email_cli`),
  UNIQUE KEY `cpf_cli` (`cpf_cli`),
  UNIQUE KEY `cnh_cli` (`cnh_cli`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela concessionaria.cliente: ~1 rows (aproximadamente)
REPLACE INTO `cliente` (`id_cli`, `nome_cli`, `email_cli`, `telefone_cli`, `cpf_cli`, `cnh_cli`) VALUES
	(1, 'Giovanna', 'giovanna@gmail.com', '(11) 994848243', '123.354.534-53', '345234234'),
	(2, 'Luca', 'luca@gmail.com', '(11) 123123123', '243.242.342-34', '123123123'),
	(3, 'Rayssa@gmail.com', 'rayssa@gmail.com', '(11) 923123123', '123.124.354-45', '231466743'),
	(4, 'Gabriel', 'gabriel@gmail.com', '(11) 986456456', '546.343.242-34', '656334523'),
	(5, 'Júlia', 'julia@gmail.com', '(11) 982312312', '956.743.413-41', '342342342');

-- Copiando estrutura para tabela concessionaria.colaborador
CREATE TABLE IF NOT EXISTS `colaborador` (
  `id_col` int NOT NULL AUTO_INCREMENT,
  `nome_col` varchar(255) NOT NULL,
  `foto_col` varchar(255) NOT NULL,
  `descricao_col` varchar(700) NOT NULL,
  `telefone_col` varchar(15) NOT NULL,
  `email_col` varchar(255) NOT NULL,
  `servico_col` varchar(255) NOT NULL,
  PRIMARY KEY (`id_col`),
  UNIQUE KEY `email_col` (`email_col`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela concessionaria.colaborador: ~1 rows (aproximadamente)
REPLACE INTO `colaborador` (`id_col`, `nome_col`, `foto_col`, `descricao_col`, `telefone_col`, `email_col`, `servico_col`) VALUES
	(1, 'Renato', '/Plataforma-A7car/img/uploads/colaboradores/img_6ac1442baf2ec.jpg', 'Limpinho', '(11) 987654321', 'renatoalves@gmail.com', 'Lava rapido'),
	(2, 'Cesar', '/Plataforma-A7car/img/uploads/colaboradores/img_6acd3c548a1d3.webp', 'Conserto de carros em geral', '(11) 983123123', 'cesar@gmail.com', 'Mêcanico'),
	(3, 'Julia Lima', '/Plataforma-A7car/img/uploads/colaboradores/img_6acd3cdc69670.jpg', 'Serviços de ótima qualidade. Depois de 14h, porque de manhã eu tenho escola', '(11) 982283123', 'julialima@gmail.com', 'Embelezamento de veículos');

-- Copiando estrutura para tabela concessionaria.favorito
CREATE TABLE IF NOT EXISTS `favorito` (
  `id_fav` int NOT NULL AUTO_INCREMENT,
  `id_usu` int NOT NULL,
  `id_car` int NOT NULL,
  PRIMARY KEY (`id_fav`),
  KEY `id_usu` (`id_usu`),
  KEY `id_car` (`id_car`),
  CONSTRAINT `favorito_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `usuario` (`id_usu`),
  CONSTRAINT `favorito_ibfk_2` FOREIGN KEY (`id_car`) REFERENCES `carro` (`id_car`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela concessionaria.favorito: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela concessionaria.simulacao
CREATE TABLE IF NOT EXISTS `simulacao` (
  `id_simu` int NOT NULL AUTO_INCREMENT,
  `cpf_simu` varchar(14) NOT NULL,
  `cnh_simu` varchar(11) NOT NULL,
  `data_nasci_simu` date NOT NULL,
  `nome_comple_simu` varchar(255) NOT NULL,
  `id_usu` int NOT NULL,
  PRIMARY KEY (`id_simu`),
  KEY `id_usu` (`id_usu`),
  CONSTRAINT `simulacao_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `usuario` (`id_usu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela concessionaria.simulacao: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela concessionaria.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usu` int NOT NULL AUTO_INCREMENT,
  `nome_usu` varchar(255) NOT NULL,
  `email_usu` varchar(255) NOT NULL,
  `telefone_usu` varchar(15) NOT NULL,
  `senha_usu` varchar(255) NOT NULL,
  PRIMARY KEY (`id_usu`),
  UNIQUE KEY `email_usu` (`email_usu`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela concessionaria.usuario: ~3 rows (aproximadamente)
REPLACE INTO `usuario` (`id_usu`, `nome_usu`, `email_usu`, `telefone_usu`, `senha_usu`) VALUES
	(0, 'admin', 'admin@gmail.com', '(11)98229-9155', '$2y$10$IStkVoe8X6t5PeNkhhj/P.vKMyNWIxlP9YW/KvevCKAUUHQJQtCx2'),
	(1, 'Usuario', 'usuario@gmail.com', '(11) 973123123', '$2y$10$7BUmDUaMXmOvGVEiDwWuzewmPjVvpSe505Z.SVti6Ixc.nY3HcVj2');

-- Copiando estrutura para tabela concessionaria.vendas
CREATE TABLE IF NOT EXISTS `vendas` (
  `id_ven` int NOT NULL AUTO_INCREMENT,
  `valor_ven` decimal(10,2) NOT NULL,
  `data_ven` date NOT NULL,
  `id_cli` int NOT NULL,
  `id_car` int NOT NULL,
  PRIMARY KEY (`id_ven`),
  KEY `id_cli` (`id_cli`),
  KEY `id_car` (`id_car`),
  CONSTRAINT `vendas_ibfk_1` FOREIGN KEY (`id_cli`) REFERENCES `cliente` (`id_cli`),
  CONSTRAINT `vendas_ibfk_2` FOREIGN KEY (`id_car`) REFERENCES `carro` (`id_car`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela concessionaria.vendas: ~0 rows (aproximadamente)
REPLACE INTO `vendas` (`id_ven`, `valor_ven`, `data_ven`, `id_cli`, `id_car`) VALUES
	(1, 3000000.00, '2026-10-12', 3, 4);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
