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
$id_car = $_POST['id_car'];
$Data = date('Y-m-d');

//verifica("cpf_cli", "cliente", $Cpf, "Cpf encontrado", "Location: ../admin/Cadastrar/VenderVeiculo.php?id=" . $id);

if (empty($Cpf) || empty($Nome) || empty($Telefone) || empty($Preco)) {
    $_SESSION['erro_cadastro'] = 'Preencha todos os campos.';
    $_SESSION['erro'] = true;
    header("Location: ../admin/Cadastrar/VenderVeiculo.php?id=" . $id_car);
    exit;
}


$verifica = $sql->prepare("SELECT cpf_cli FROM cliente WHERE cpf_cli = ?");
$verifica->bind_param("s", $Cpf);
$verifica->execute();
$resultado = $verifica->get_result();

$stmt = $sql->prepare("SELECT id_cli FROM cliente WHERE cpf_cli = ?");
$stmt->bind_param("s", $Cpf);
$stmt->execute();
$result = $stmt->get_result();
$cliente = $result->fetch_assoc();
$id_cli = $cliente['id_cli'];

if ($resultado->num_rows > 0) {

$stmt = $sql->prepare("INSERT INTO vendas (valor_ven, data_ven, id_cli, id_car) VALUES (?, ?, ?, ?)");
$stmt->bind_param("dsii", $Preco, $Data, $id_cli, $id_car);
$stmt->execute();

$_SESSION['sucesso_cadastro'] = 'Venda cadastrada com sucesso!';
$_SESSION['erro'] = false;

header("Location: ../admin/Veiculos.php");
exit;
}else{
    $_SESSION['erro_cadastro'] = "Cpf do cliente não encontrado";
    $_SESSION['erro'] = true;
    header("Location: ../admin/Cadastrar/VenderVeiculo.php?id=" . $id_car);
    exit;
}


    






?>