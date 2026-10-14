<?php
require_once "../Conexao.php";
require_once "../funcoes.php";

if (session_status() !== PHP_SESSION_ACTIVE) {
    SESSION_START(); 
}



if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['erro_cadastro'] = 'Método inválido.';
    header("Location: ../user/Login.php");
    exit;
}

$id = $_POST['id'] ?? '';

$Senha = $_POST['Senha'] ?? '';
$Confirmar_Senha = $_POST['Confirmar_Senha'] ?? '';
$link1 = "Location: ../../user/RedefinirSenha.php?id =" . $id;


if (empty($Senha) || empty($Confirmar_Senha)) {
    $_SESSION['erro_cadastro'] = 'Preencha todos os campos.';
    $_SESSION['erro'] = true;
    header($link1);
    exit;
}


if ($Senha !== $Confirmar_Senha) {
    $_SESSION['erro_cadastro'] = 'As senhas não conferem.';
    $_SESSION['erro'] = true;
    header($link1);
    exit;
}

if (strlen($Senha) < 8) {
    $_SESSION['erro_cadastro'] = "A senha deve ter pelo menos 8 caracteres.";
    $_SESSION['erro'] = true;
    header($link1);
    exit;
}

if (!preg_match('/[A-Z]/', $Senha)) {
    $_SESSION['erro_cadastro'] = "A senha deve conter pelo menos uma letra maiúscula.";
    $_SESSION['erro'] = true;
    header($link1);
    exit;
}

if (!preg_match('/[a-z]/', $Senha)) {
    $_SESSION['erro_cadastro'] = "A senha deve conter pelo menos uma letra minúscula.";
    $_SESSION['erro'] = true;
    header($link1);
    exit;
}

if (!preg_match('/[0-9]/', $Senha)) {
    $_SESSION['erro_cadastro'] = "A senha deve conter pelo menos um número.";
    $_SESSION['erro'] = true;
    header($link1);
    exit;
}

if (!preg_match('/[\W_]/', $Senha)) {
    $_SESSION['erro_cadastro'] = "A senha deve conter pelo menos um caractere especial (ex: @, #, $, !).";
    $_SESSION['erro'] = true;
    header($link1);
    exit;
}
$senhaHash = password_hash($Senha, PASSWORD_DEFAULT);

try{
$stmt = $sql->prepare("UPDATE usuario SET senha_usu = ? WHERE id_usu = ?");
$stmt->bind_param("si", $senhaHash, $id);
$stmt->execute();

$_SESSION['sucesso_cadastro'] = 'Senha alterada com sucesso!';
$_SESSION['erro'] = false;
header("Location: ../../user/Login.php");

exit;
}catch(Exception $e){
                $_SESSION['erro_cadastro'] = "Erro ao tentar alterar senha" . " " . $e->getMessage() ;
                $_SESSION['erro'] = true;
                header($link1);


                }

?>