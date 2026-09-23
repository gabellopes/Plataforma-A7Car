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

//verifica("cpf_cli", "cliente", $Cpf, "Cpf encontrado", "Location: ../admin/Cadastrar/VenderVeiculo.php?id=" . $id);

if (empty($Cpf) || empty($Nome) || empty($Telefone) || empty($Preco)) {
    $_SESSION['erro_cadastro'] = 'Preencha todos os campos.';
    $_SESSION['erro'] = true;
    header("Location: ../admin/Cadastrar/VenderVeiculo.php?id=" . $id);
    exit;
}


$verifica = $sql->prepare("SELECT cpf_cli FROM cliente WHERE cpf_cli = ?");
$verifica->bind_param("s", $Cpf);
$verifica->execute();
$resultado = $verifica->get_result();

if ($resultado->num_rows > 0) {
    echo("Deu certo");

$stmt = $sql->prepare("INSERT INTO vendas (id_ven, valor_ven, data_ven, id_cli, id_carro) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssiisisss", $Marca, $Modelo, $Ano, $Preco, $Cor, $Quilometragem, $Combustivel, $Descricao, $Imagem);
$stmt->execute();

$_SESSION['sucesso_cadastro'] = 'Venda cadastrada com sucesso!';
$_SESSION['erro'] = false;

header("Location: ../admin/Veiculo.php");
exit;
}else{
    $_SESSION['erro_cadastro'] = "Cpf do cliente não cadastrado";
    $_SESSION['erro'] = true;
    header("Location: ../admin/Cadastrar/VenderVeiculo.php?id=" . $id);
    exit;
}


    






?>