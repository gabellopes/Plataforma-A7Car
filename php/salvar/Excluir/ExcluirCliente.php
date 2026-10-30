<?php
if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
    
   require_once "../../auth/authadm.php";

include __DIR__ . "../../Conexao.php";




$id = trim($_GET['id'] ?? '');

try{
$stmt = $sql->prepare("DELETE FROM cliente WHERE id_cli = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: ../../admin/Clientes.php");
exit;}catch(Exception $e){
                $_SESSION['erro_cadastro'] = "Erro ao tentar excluir cliente";
                $_SESSION['erro'] = true;
                header("Location: ../../admin/Clientes.php");
                }


?>