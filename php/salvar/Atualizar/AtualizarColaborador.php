<?php
include "../funcoes.php";
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

$Nome = trim($_POST['Nome'] ?? '');
$Email = trim($_POST['Email'] ?? '');
$Telefone = trim($_POST['Telefone'] ?? '');
$Servico = trim($_POST['Servico'] ?? '');
$Descricao = trim($_POST['Descricao'] ?? '');
$Imagem = $_FILES['Imagem'];
$id = trim($_POST['id'] ?? '');

if (empty($Nome) || empty($Email) || empty($Telefone) || empty($Servico) || empty($Descricao)) {
    $_SESSION['erro_cadastro'] = 'Preencha todos os campos.';
    $_SESSION['erro'] = true;
    header("Location: ../Editar/EditarColaborador.php?id=" . $id);
    exit;
}

/*if(!isset($Imagem) || $Imagem['error'] === UPLOAD_ERR_NO_FILE){
$nomeArquivo = verificarImagem($_FILES['Imagem'], 'colaboradores', 'Location: ../Editar/EditarColaborador.php?id=' . $id);

$stmt = $sql->prepare("UPDATE colaborador SET nome_col = ?, email_col = ?, telefone_col = ?, servico_col = ?, descricao_col = ?, foto_col = ? WHERE id_col = ?");
$stmt->bind_param("ssssssi", $Nome, $Email, $Telefone, $Servico, $Descricao, $nomeArquivo, $id);
$stmt->execute();

$_SESSION['sucesso_cadastro'] = 'Colaborador atualizado com sucesso!';
$_SESSION['erro'] = false;

header("Location: ../../admin/Colaboradores.php");
exit;
}*/

$stmt = $sql->prepare("UPDATE colaborador SET nome_col = ?, email_col = ?, telefone_col = ?, servico_col = ?, descricao_col = ? WHERE id_col = ?");
$stmt->bind_param("sssssi", $Nome, $Email, $Telefone, $Servico, $Descricao, $id);
$stmt->execute();

$_SESSION['sucesso_cadastro'] = 'Colaborador atualizado com sucesso!';
$_SESSION['erro'] = false;

header("Location: ../../admin/Colaboradores.php");
exit;


?>