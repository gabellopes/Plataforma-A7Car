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
  PRIMARY KEY (`id_car`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela concessionaria.carro: ~1 rows (aproximadamente)
REPLACE INTO `carro` (`id_car`, `marca_car`, `modelo_car`, `ano_car`, `cor_car`, `preco_car`, `quilometragem_car`, `combustivel_car`, `descricao_car`, `foto_car`) VALUES
	(12, 'Rosa', 'Rosa', '2019', '22', 22.00, 22, 'Gasolina', 'sssss', 'semfoto');

-- Copiando estrutura para tabela concessionaria.cliente
CREATE TABLE IF NOT EXISTS `cliente` (
  `id_cli` int NOT NULL AUTO_INCREMENT,
  `nome_cli` varchar(255) NOT NULL,
  `email_cli` varchar(255) NOT NULL,
  `telefone_cli` varchar(15) NOT NULL,
  `cpf_cli` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `cnh_cli` varchar(9) NOT NULL,
  PRIMARY KEY (`id_cli`) USING BTREE,
  UNIQUE KEY `cpf_cli` (`cpf_cli`),
  UNIQUE KEY `cnh_cli` (`cnh_cli`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela concessionaria.cliente: ~1 rows (aproximadamente)
REPLACE INTO `cliente` (`id_cli`, `nome_cli`, `email_cli`, `telefone_cli`, `cpf_cli`, `cnh_cli`) VALUES
	(21, 'Gabriel Lopes Alves', 'gabriellopesalves900@gmail.com', '(11) 987654321', '111.111.111-11', '222222222');

-- Copiando estrutura para tabela concessionaria.colaborador
CREATE TABLE IF NOT EXISTS `colaborador` (
  `id_col` int NOT NULL AUTO_INCREMENT,
  `nome_col` varchar(255) NOT NULL,
  `foto_col` varchar(255) NOT NULL,
  `descricao_col` varchar(700) NOT NULL,
  `telefone_col` varchar(15) NOT NULL,
  `email_col` varchar(255) NOT NULL,
  `servico_col` varchar(255) NOT NULL,
  PRIMARY KEY (`id_col`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela concessionaria.colaborador: ~3 rows (aproximadamente)
REPLACE INTO `colaborador` (`id_col`, `nome_col`, `foto_col`, `descricao_col`, `telefone_col`, `email_col`, `servico_col`) VALUES
	(17, 'Ana julia', 'semfoto', 'sssss', '(11) 98765-4321', 'gabriellopesalves900@gmail.com', 'ssssssss'),
	(31, 'Gabriel Lopes Alves', 'semfoto', 'asdasd', '(11) 987654321', 'gabriellopesalves900@gmail.com', 'ssssssss'),
	(32, 'João', 'semfoto', '1111111111', '(23) 123123123', 'gabriellopesalves900@gmail.com', '11111111111'),
	(33, 'sdasdasd', 'semfoto', '23123', '(22) 222222222', 'asdasd@gmail.com', '23123');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela concessionaria.favorito: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela concessionaria.simulacao
CREATE TABLE IF NOT EXISTS `simulacao` (
  `id_simu` int NOT NULL AUTO_INCREMENT,
  `cpf_simu` varchar(11) NOT NULL,
  `cnh_simu` varchar(9) NOT NULL,
  `data_nasci_simu` date NOT NULL,
  `nome_comple_simu` varchar(255) NOT NULL,
  `id_usu` int NOT NULL,
  PRIMARY KEY (`id_simu`),
  UNIQUE KEY `cpf_simu` (`cpf_simu`),
  UNIQUE KEY `cnh_simu` (`cnh_simu`),
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
  PRIMARY KEY (`id_usu`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Copiando dados para a tabela concessionaria.usuario: ~1 rows (aproximadamente)
REPLACE INTO `usuario` (`id_usu`, `nome_usu`, `email_usu`, `telefone_usu`, `senha_usu`) VALUES
	(0, 'admin', 'admin@gmail.com', '(11)98229-9155', '$2y$10$IStkVoe8X6t5PeNkhhj/P.vKMyNWIxlP9YW/KvevCKAUUHQJQtCx2');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
