<?php
include "funcoes.php";
include "Conexao.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['user_email'])){
    header("Location: ../user/Login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['erro_cadastro'] = 'Método inválido.';
    header("Location: ../user/Login.php");
    exit;
}



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

    if($status == 0){
        try{

            $stmt = $sql->prepare("INSERT INTO simulacao (data_simu, telefone_simu, cpf_simu, cnh_simu, data_nasci_simu, nome_comple_simu, id_usu, id_car) VALUES (?, ?, ?, ?, ?, ?, ?, ?) ");
            $stmt->bind_param("ssssssii", $Data, $Telefone, $Cpf, $Cnh, $DataNasci, $Nome, $idUsu, $idCar);
            $stmt->execute();
            
            header("Location: ../user/Veiculo.php?id=" . $idCar . "&sucesso=". 1);
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
?>