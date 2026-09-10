<?php
SESSION_START();
    if($_SESSION['user_email'] !== 'admin@gmail.com'){
            header("Location: ../../user/Login.php");
            exit;
        }

include __DIR__ . "../../Conexao.php";



// 1. Recebe os dados do formulário
$Nome = trim($_POST['Nome'] ?? '');
$Email = trim($_POST['Email'] ?? '');
$Telefone = trim($_POST['Telefone'] ?? '');
$Cpf = trim($_POST['Cpf'] ?? '');
$Cnh = trim($_POST['Cnh'] ?? '');
$id = trim($_GET['id'] ?? '');


$stmt = $sql->prepare("DELETE FROM cliente WHERE id_cli = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: ../../admin/Clientes.php");
exit;


?>