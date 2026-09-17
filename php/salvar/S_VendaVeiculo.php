<?php
include __DIR__ . "/funcoes.php";
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

$Cpf = trim($_POST['Cpf']) ?? '';
$Nome = trim($_POST['Nome'] ?? '');
$Telefone = trim($_POST['Telefone'] ?? '');
$Preco = trim($_POST['Preco'] ?? '');
$id = $_POST['id'];

$resultado = verifica("cpf_cli", "cliente", $Cpf, "Cpf encontrado", "");

echo $resultado['id_cli'];






?>