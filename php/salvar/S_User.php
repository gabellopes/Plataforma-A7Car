<?php
session_start();
include __DIR__ . "/Conexao.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['erro_cadastro'] = 'Método inválido.';
    header("Location: ../user/Cadastro.php");
    exit;
}

// 1. Recebe os dados do formulário
$Nome = trim($_POST['Nome'] ?? '');
$Email = trim($_POST['Email'] ?? '');
$Telefone = trim($_POST['Telefone'] ?? '');
$Senha = $_POST['Senha'] ?? '';
$Confirmar_Senha = $_POST['Confirmar_Senha'] ?? '';

// 2. Valida campos vazios e confirmação da senha
if (empty($Nome) || empty($Email) || empty($Telefone) || empty($Senha) || empty($Confirmar_Senha)) {
    $_SESSION['erro_cadastro'] = 'Preencha todos os campos.';
    header("Location: ../user/Cadastro.php");
    exit;
}

if ($Senha !== $Confirmar_Senha) {
    $_SESSION['erro_cadastro'] = 'As senhas não conferem.';
    header("Location: ../user/Cadastro.php");
    exit;
}

$verificaEmail = $sql->prepare("SELECT id_usu FROM usuario WHERE email_usu = ?");
$verificaEmail->bind_param("s", $Email);
$verificaEmail->execute();
$resultadoEmail = $verificaEmail->get_result();

if ($resultadoEmail->num_rows > 0) {
    $_SESSION['erro_cadastro'] = 'Este e-mail já está cadastrado.';
    header("Location: ../user/Cadastro.php");
    exit;
}

// 3. Criptografa a senha antes de salvar no banco
$senhaHash = password_hash($Senha, PASSWORD_DEFAULT);

// 4. Insere o usuário no banco
$stmt = $sql->prepare("INSERT INTO usuario (nome_usu, email_usu, telefone_usu, senha_usu) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $Nome, $Email, $Telefone, $senhaHash);
$stmt->execute();

$_SESSION['sucesso_cadastro'] = 'Cadastro realizado com sucesso!';
header("Location: ../user/Login.php");
exit;
?>