<?php
SESSION_START();
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

$Marca = trim($_POST['Marca'] ?? '');
$Modelo = trim($_POST['Modelo'] ?? '');
$Ano = trim($_POST['Ano'] ?? '');
$Preco = trim($_POST['Preco'] ?? '');
$Cor = trim($_POST['Cor'] ?? '');
$Quilometragem = trim($_POST['Quilometragem'] ?? '');
$Combustivel = trim($_POST['Combustivel'] ?? '');
$Descricao = trim($_POST['Descricao'] ?? '');
$Imagem = "semfoto";



if (empty($Marca) || empty($Modelo) || empty($Ano) || empty($Preco) || empty($Cor) || empty($Quilometragem) || empty($Combustivel) || empty($Descricao)) {
    $_SESSION['erro_cadastro'] = 'Preencha todos os campos.';
    $_SESSION['erro'] = true;
    header("Location: ../admin/Salvar/Cadastro/NovoVeiculo.php");
    exit;
}

    
$stmt = $sql->prepare("INSERT INTO carro (marca_car, modelo_car, ano_car, preco_car, cor_car, quilometragem_car, combustivel_car, descricao_car, foto_car) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssiisisss", $Marca, $Modelo, $Ano, $Preco, $Cor, $Quilometragem, $Combustivel, $Descricao, $Imagem);
$stmt->execute();

$_SESSION['sucesso_cadastro'] = 'Veículo cadastrado com sucesso!';
$_SESSION['erro'] = false;

header("Location: ../admin/Cadastrar/NovoVeiculo.php");
exit;


?>