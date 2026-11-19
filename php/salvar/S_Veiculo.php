<?php
include __DIR__ . "/Conexao.php";
include __DIR__ . "/funcoes.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../auth/authadm.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['erro_cadastro'] = 'Método inválido.';
    header("Location: ../user/Login.php");
    exit;
}

if (!validarTokenCsrf($_POST['csrf_token'] ?? '')) {
    die("Erro de segurança: Token CSRF inválido ou expirado.");
}

$Marca         = trim($_POST['Marca'] ?? '');
$Modelo        = trim($_POST['Modelo'] ?? '');
$Ano           = trim($_POST['Ano'] ?? '');
$Preco         = trim($_POST['Preco'] ?? '');
$Cor           = trim($_POST['Cor'] ?? '');
$Quilometragem = trim($_POST['Quilometragem'] ?? '');
$Combustivel   = trim($_POST['Combustivel'] ?? '');
$Descricao     = trim($_POST['Descricao'] ?? '');
$Data          = date('Y-m-d');

if (
    empty($Marca) || empty($Modelo) || empty($Ano) || empty($Preco) ||
    empty($Cor) || empty($Combustivel) || empty($Descricao) ||
    empty($_FILES['Imagem']['name'][0])
) {
    $_SESSION['erro_cadastro'] = 'Preencha todos os campos e envie pelo menos uma imagem.';
    $_SESSION['erro'] = true;
    header("Location: ../admin/Cadastrar/NovoVeiculo.php");
    exit;
}

// Processa todas as imagens enviadas usando a sua função verificarImagem()
$caminhosSalvos = [];
$totalArquivos = count($_FILES['Imagem']['name']);

for ($i = 0; $i < $totalArquivos; $i++) {
    if ($_FILES['Imagem']['error'][$i] === UPLOAD_ERR_NO_FILE) {
        continue;
    }

    // Reorganiza os dados no formato de arquivo único que a verificarImagem() espera
    $arquivoAtual = [
        'name'     => $_FILES['Imagem']['name'][$i],
        'type'     => $_FILES['Imagem']['type'][$i],
        'tmp_name' => $_FILES['Imagem']['tmp_name'][$i],
        'error'    => $_FILES['Imagem']['error'][$i],
        'size'     => $_FILES['Imagem']['size'][$i]
    ];

    $nomeArquivo = verificarImagem(
        $arquivoAtual,
        'veiculos',
        'Location: ../admin/Cadastrar/NovoVeiculo.php',
        '../../img/uploads/'
    );

    if (!empty($nomeArquivo)) {
        $caminhosSalvos[] = $nomeArquivo;
    }
}

if (empty($caminhosSalvos)) {
    $_SESSION['erro_cadastro'] = 'Nenhuma imagem válida foi enviada.';
    $_SESSION['erro'] = true;
    header("Location: ../admin/Cadastrar/NovoVeiculo.php");
    exit;
}

// A primeira imagem continua sendo a capa na tabela 'carro'
$fotoCapa = $caminhosSalvos[0];

try {
    $sql->begin_transaction();

    // 1. Insere o veículo
    $stmt = $sql->prepare("INSERT INTO carro (marca_car, modelo_car, ano_car, preco_car, cor_car, quilometragem_car, combustivel_car, descricao_car, foto_car, data_car) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiisissss", $Marca, $Modelo, $Ano, $Preco, $Cor, $Quilometragem, $Combustivel, $Descricao, $fotoCapa, $Data);
    $stmt->execute();

    // Captura o ID gerado para vincular as fotos
    $idCarro = $sql->insert_id;

    // 2. Insere todas as fotos na tabela 'carro_imagem'
    $stmtImg = $sql->prepare("INSERT INTO carro_imagem (id_car, caminho_img) VALUES (?, ?)");
    foreach ($caminhosSalvos as $caminho) {
        $stmtImg->bind_param("is", $idCarro, $caminho);
        $stmtImg->execute();
    }

    $sql->commit();

    $_SESSION['sucesso_cadastro'] = 'Veículo cadastrado com sucesso!';
    $_SESSION['erro'] = false;
    header("Location: ../admin/Cadastrar/NovoVeiculo.php");
    exit;

} catch (Exception $e) {
    $sql->rollback();
    $_SESSION['erro_cadastro'] = "Erro ao cadastrar veículo." . " " . $e->getMessage();
    $_SESSION['erro'] = true;
    header("Location: ../admin/Cadastrar/NovoVeiculo.php");
    exit;
}
?>