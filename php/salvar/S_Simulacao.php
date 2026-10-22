<?php
include "funcoes.php";
include "Conexao.php";

//NECESSARIO - VALIDAÇÃO DE LOGIN USER
$idCar = trim($_POST['id']);
$idUsu = trim($_SESSION['user_id']);
$status = trim($_POST['status_car']);

$Nome = trim($_POST['Nome'] ?? '');
$Telefone = trim($_POST['Telefone'] ?? '');
$Cpf = trim($_POST['Cpf'] ?? '');
$Cnh = trim($_POST['Cnh'] ?? '');
$Data = date('Y-m-d');
$DataNasci = trim($_POST['DataNascimento'] ?? '');


            $stmt = $sql->prepare("INSERT INTO simulacao (data_simu, cpf_simu, cnh_simu, data_nasci_simu, nome_comple_simu, id_usu, id_car) VALUES (?, ?, ?, ?, ?, ?, ?) ");
            $stmt->bind_param("sssssii", $Data, $Cpf, $Cnh, $DataNasci, $Nome, $idUsu, $idCar);
            $stmt->execute();

            
/*
CREATE TABLE IF NOT EXISTS `simulacao` (
  `id_simu` int NOT NULL AUTO_INCREMENT,
  `data_simu` date NOT NULL,
  `email_simu` varchar(255) NOT NULL,
  `cpf_simu` varchar(14) NOT NULL,
  `cnh_simu` varchar(11),
  `data_nasci_simu` date NOT NULL,
  `nome_comple_simu` varchar(255) NOT NULL,
  `id_usu` int NOT NULL,
  `id_car` int NOT NULL,
  PRIMARY KEY (`id_simu`),
  KEY `id_usu` (`id_usu`),
  KEY `id_car` (`id_car`),
  CONSTRAINT `simulacao_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `usuario` (`id_usu`),
  CONSTRAINT `simulacao_ibfk_2` FOREIGN KEY (`id_car`) REFERENCES `carro` (`id_car`)
) 

*/
   
?>