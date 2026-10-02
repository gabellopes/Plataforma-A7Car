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

$Marca = trim($_POST['Marca'] ?? '');
$Modelo = trim($_POST['Modelo'] ?? '');
$Ano = trim($_POST['Ano'] ?? '');
$Preco = trim($_POST['Preco'] ?? '');
$Cor = trim($_POST['Cor'] ?? '');
$Quilometragem = trim($_POST['Quilometragem'] ?? '');
$Combustivel = trim($_POST['Combustivel'] ?? '');
$Descricao = trim($_POST['Descricao'] ?? '');
$Imagem = $_FILES['Imagem'];
$id = trim($_POST['id'] ?? '');



if (empty($Marca) || empty($Modelo) || empty($Ano) || empty($Preco) || empty($Cor) || empty($Quilometragem) || empty($Combustivel) || empty($Descricao)) {
    $_SESSION['erro_cadastro'] = 'Preencha todos os campos.';
    $_SESSION['erro'] = true;
    header("Location: ../admin/Salvar/Cadastro/NovoVeiculo.php");
    exit;
}

if(!isset($Imagem) || $Imagem['error'] === UPLOAD_ERR_NO_FILE){
//$nomeArquivo = verificarImagem($_FILES['Imagem'], 'veiculos', 'Location: ../Editar/EditarVeiculo.php?id=' . $id, '../../../img/uploads/');

    
$stmt = $sql->prepare("UPDATE carro SET marca_car = ?, modelo_car = ?, ano_car = ?, preco_car = ?, cor_car = ?, quilometragem_car = ?, combustivel_car = ?, descricao_car = ? WHERE id_car = ?");
$stmt->bind_param("ssiisissi", $Marca, $Modelo, $Ano, $Preco, $Cor, $Quilometragem, $Combustivel, $Descricao, $id);
$stmt->execute();

$_SESSION['sucesso_cadastro'] = 'Veiculo atualizado com sucesso!';
$_SESSION['erro'] = false;

header("Location: ../../admin/Veiculos.php");
exit;}else{

$nomeArquivo = verificarImagem($Imagem, 'veiculos', 'Location: ../Editar/EditarVeiculo.php?id=' . $id, '../../../img/uploads/');

    
$stmt = $sql->prepare("UPDATE carro SET marca_car = ?, modelo_car = ?, ano_car = ?, preco_car = ?, cor_car = ?, quilometragem_car = ?, combustivel_car = ?, descricao_car = ?, foto_car = ? WHERE id_car = ?");
$stmt->bind_param("ssiisisssi", $Marca, $Modelo, $Ano, $Preco, $Cor, $Quilometragem, $Combustivel, $Descricao, $nomeArquivo, $id);
$stmt->execute();

$_SESSION['sucesso_cadastro'] = 'Veiculo atualizado com sucesso!';
$_SESSION['erro'] = false;

header("Location: ../../admin/Veiculos.php");
exit;}


?>