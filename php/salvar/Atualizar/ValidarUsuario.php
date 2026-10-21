<?php
require_once "../funcoes.php";
require_once "../Conexao.php";

if(SESSION_STATUS() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$Email = $_GET ['email'] ?? '';

if (empty($Email)){
    header("Location: ../../user/Cadastro.php");
    exit;
}
try{
$stmt = $sql->prepare("UPDATE usuario SET status_usu = 1 WHERE email_usu = ?");
$stmt->bind_param("s", $Email);
$stmt->execute();

$_SESSION['sucesso_cadastro'] = 'Cadastro de usuario confirmado com sucesso!';
$_SESSION['erro'] = false;

header("Location: ../../user/Login.php");
exit;

}catch(Exception $e){
                //$_SESSION['erro_cadastro'] = "Erro ao editar cliente" . " " . $e->getMessage() ;
                $_SESSION['erro_cadastro'] = "Erro ao confirmar usuario, tente novamente mais tarde";
                $_SESSION['erro'] = true;
                header("Location: ../../user/Cadastro.php");
                }
?>