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
$Servico = trim($_POST['Servico'] ?? '');
$Descricao = trim($_POST['Descricao'] ?? '');
$Imagem = "semfoto";




if (empty($Nome) || empty($Email) || empty($Telefone) || empty($Servico) || empty($Descricao)) {
    $_SESSION['erro_cadastro'] = 'Preencha todos os campos.';
    $_SESSION['erro'] = true;
    header("Location: ../admin/Salvar/Cadastro/NovoColaborador.php");
    exit;
}

    
$stmt = $sql->prepare("INSERT INTO colaborador (nome_col, email_col, telefone_col, servico_col, descricao_col, foto_col) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $Nome, $Email, $Telefone, $Servico, $Descricao, $Imagem);
$stmt->execute();

$_SESSION['sucesso_cadastro'] = 'Colaborador cadastrado com sucesso!';
$_SESSION['erro'] = false;

header("Location: ../admin/Cadastrar/NovoColaborador.php");
exit;


?>