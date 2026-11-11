<?php
include "funcoes.php";
include "Conexao.php";

//NECESSARIO - VALIDAÇÃO DE LOGIN USER
$idCar = trim($_POST['id']);
$idUsu = trim($_SESSION['user_id']);
$status = trim($_POST['status_car']);

$Nome = trim($_POST['Nome'] ?? '');
$Email = trim($_POST['Email'] ?? '');
$Telefone = trim($_POST['Telefone'] ?? '');
$Cpf = trim($_POST['Cpf'] ?? '');
$Cnh = trim($_POST['Cnh'] ?? '');

    if($status == 0){
        try{

            $stmt = $sql->prepare("INSERT INTO simulacao (id_usu, id_car, data_simu, cpf_simu, cnh_simu) VALUES (?, ?, ?, ?, ?) ");
            $stmt->bind_param("sssss", $idUsu, $idCar);
            $stmt->execute();
            
            }catch(Exception $e){
                $_SESSION['erro_cadastro'] = "Erro ao enviar simulacao";
                $_SESSION['erro'] = true;
                header("Location: ../user/Veiculo.php?id=" . $idCar);
                }
        
    }else{
        $_SESSION['erro_cadastro'] = "Erro ao enviar simulacao";
        $_SESSION['erro'] = true;
        header("Location: ../user/Veiculo.php?id=" . $idCar);
    }
/*CREATE TABLE IF NOT EXISTS `simulacao` (
  `id_simu` int NOT NULL AUTO_INCREMENT,
  `cpf_simu` varchar(14) NOT NULL,
  `cnh_simu` varchar(11) NOT NULL,
  `data_nasci_simu` date NOT NULL,
  `nome_comple_simu` varchar(255) NOT NULL,
  `id_usu` int NOT NULL,
  PRIMARY KEY (`id_simu`),
  KEY `id_usu` (`id_usu`),
  CONSTRAINT `simulacao_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `usuario` (`id_usu`)
)*/
?>