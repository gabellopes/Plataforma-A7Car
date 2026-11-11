<?php
if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
    
require_once "../../auth/authadm.php";

include __DIR__ . "../../Conexao.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['erro_cadastro'] = 'Método inválido.';
    header("Location: ../user/Login.php");
    exit;
}
if (!validarTokenCsrf($_POST['csrf_token'] ?? '')) {
        die("Erro de segurança: Token CSRF inválido ou expirado.");
    }


$Nome = trim($_POST['Nome'] ?? '');
$Email = trim($_POST['Email'] ?? '');
$Telefone = trim($_POST['Telefone'] ?? '');
$Cpf = trim($_POST['Cpf'] ?? '');
$Cnh = trim($_POST['Cnh'] ?? '');
$id = trim($_POST['id'] ?? '');




if (empty($Nome) || empty($Email) || empty($Telefone) || empty($Cpf) || empty($Cnh)) {
    $_SESSION['erro_cadastro'] = 'Preencha todos os campos.';
    $_SESSION['erro'] = true;
    header("Location: ../Editar/EditarCliente.php?id=" . $id);

    exit;
}

try{
$stmt = $sql->prepare("UPDATE cliente SET nome_cli = ?, email_cli = ?, telefone_cli = ?, cpf_cli = ?, cnh_cli = ? WHERE id_cli = ?");
$stmt->bind_param("ssssii", $Nome, $Email, $Telefone, $Cpf, $Cnh, $id);
$stmt->execute();

$_SESSION['sucesso_cadastro'] = 'Cliente atualizado com sucesso!';
$_SESSION['erro'] = false;

header("Location: ../../admin/Clientes.php");
exit;

}catch(Exception $e){
                //$_SESSION['erro_cadastro'] = "Erro ao editar cliente" . " " . $e->getMessage() ;
                $_SESSION['erro_cadastro'] = "Erro ao editar cliente";
                $_SESSION['erro'] = true;
                header("Location: ../Editar/EditarCliente.php?id=" . $id);
                }


?>