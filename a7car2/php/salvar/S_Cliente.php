<?php
SESSION_START();
    if($_SESSION['user_email'] !== 'admin@gmail.com'){
            header("Location: ../../user/Login.php");
            exit;
        }

include __DIR__ . "/Conexao.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['erro_cadastro'] = 'Método inválido.';
    header("Location: ../user/Login.php");
    exit;
}

$Nome = trim($_POST['Nome'] ?? '');
$Email = trim($_POST['Email'] ?? '');
$Telefone = trim($_POST['Telefone'] ?? '');
$Cpf = trim($_POST['Cpf'] ?? '');
$Cnh = trim($_POST['Cnh'] ?? '');



if (empty($Nome) || empty($Email) || empty($Telefone) || empty($Cpf) || empty($Cnh)) {
    $_SESSION['erro_cadastro'] = 'Preencha todos os campos.';
    $_SESSION['erro'] = true;
    header("Location: ../admin/Salvar/Cadastro/NovoCliente.php");
    exit;
}

    
$stmt = $sql->prepare("INSERT INTO cliente (nome_cli, email_cli, telefone_cli, cpf_cli, cnh_cli) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssii", $Nome, $Email, $Telefone, $Cpf, $Cnh);
$stmt->execute();

$_SESSION['sucesso_cadastro'] = 'Cliente cadastrado com sucesso!';
$_SESSION['erro'] = false;

header("Location: ../admin/Cadastrar/NovoCliente.php");
exit;


?>