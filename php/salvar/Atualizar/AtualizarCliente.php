<?php
SESSION_START();
    if($_SESSION['user_email'] !== 'admin@gmail.com'){
            header("Location: ../../user/Login.php");
            exit;
        }

include __DIR__ . "../../Conexao.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['erro_cadastro'] = 'Método inválido.';
    header("Location: ../user/Login.php");
    exit;
}

// 1. Recebe os dados do formulário
$Nome = trim($_POST['Nome'] ?? '');
$Email = trim($_POST['Email'] ?? '');
$Telefone = trim($_POST['Telefone'] ?? '');
$Cpf = trim($_POST['Cpf'] ?? '');
$Cnh = trim($_POST['Cnh'] ?? '');
$id = trim($_POST['id'] ?? '');



// 2. Valida campos vazios e confirmação da senha
if (empty($Nome) || empty($Email) || empty($Telefone) || empty($Cpf) || empty($Cnh)) {
    $_SESSION['erro_cadastro'] = 'Preencha todos os campos.';
    $_SESSION['erro'] = true;
    header("Location: ../admin/Salvar/Cadastro/NovoCliente.php");
    exit;
}


$stmt = $sql->prepare("UPDATE cliente SET nome_cli = ?, email_cli = ?, telefone_cli = ?, cpf_cli = ?, cnh_cli = ? WHERE id_cli = ?");
$stmt->bind_param("sssiii", $Nome, $Email, $Telefone, $Cpf, $Cnh, $id);
$stmt->execute();

$_SESSION['sucesso_cadastro'] = 'Cliente atualizado com sucesso!';
$_SESSION['erro'] = false;

header("Location: ../../admin/Clientes.php");
exit;


?>