<?php
SESSION_START();
    if($_SESSION['user_email'] !== 'admin@gmail.com'){
            header("Location: ../../user/Login.php");
            exit;
        }

include __DIR__ . "../../Conexao.php";




$id = trim($_GET['id'] ?? '');


$stmt = $sql->prepare("DELETE FROM cliente WHERE id_cli = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: ../../admin/Clientes.php");
exit;


?>