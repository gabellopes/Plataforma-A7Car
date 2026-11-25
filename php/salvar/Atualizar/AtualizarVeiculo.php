<?php
include "../funcoes.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../../auth/authadm.php";
include __DIR__ . "/../Conexao.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['erro_cadastro'] = 'Método inválido.';
    header("Location: ../user/Login.php");
    exit;
}

if (!validarTokenCsrf($_POST['csrf_token'] ?? '')) {
    die("Erro de segurança: Token CSRF inválido ou expirado.");
}

$Marca = trim($_POST['Marca'] ?? '');
$Modelo = trim($_POST['Modelo'] ?? '');
$Ano = trim($_POST['Ano'] ?? '');
$Preco = trim($_POST['Preco'] ?? '');
$Cor = trim($_POST['Cor'] ?? '');
$Quilometragem = trim($_POST['Quilometragem'] ?? '');
$Combustivel = trim($_POST['Combustivel'] ?? '');
$Descricao = trim($_POST['Descricao'] ?? '');
$id = (int)($_POST['id'] ?? 0);
$fotoAtual = trim($_POST['foto_car'] ?? '');
$Data = date('Y-m-d');

if (
    $id <= 0 || empty($Marca) || empty($Modelo) || empty($Ano) || empty($Preco) ||
    empty($Cor) || empty($Quilometragem) || empty($Combustivel) || empty($Descricao)
) {
    $_SESSION['erro_cadastro'] = 'Preencha todos os campos.';
    $_SESSION['erro'] = true;
    header("Location: ../Editar/EditarVeiculo.php?id=" . $id);
    exit;
}

try {
    $sql->begin_transaction();

    if (!empty($_POST['imagens_remover']) && is_array($_POST['imagens_remover'])) {
        $stmtBuscaImg = $sql->prepare("SELECT caminho_img FROM carro_imagem WHERE id_img = ? AND id_car = ?");
        $stmtDelImg   = $sql->prepare("DELETE FROM carro_imagem WHERE id_img = ? AND id_car = ?");

        foreach ($_POST['imagens_remover'] as $idImg) {
            $idImg = (int)$idImg;

            $stmtBuscaImg->bind_param("ii", $idImg, $id);
            $stmtBuscaImg->execute();
            $resImg = $stmtBuscaImg->get_result();

            if ($rowImg = $resImg->fetch_assoc()) {
                $caminhoFisico = "../../.." . $rowImg['caminho_img'];

                if (!empty($rowImg['caminho_img']) && file_exists($caminhoFisico)) {
                    unlink($caminhoFisico);
                }

                $stmtDelImg->bind_param("ii", $idImg, $id);
                $stmtDelImg->execute();
            }
        }
    }

    if (isset($_FILES['Imagem']) && !empty($_FILES['Imagem']['name'][0])) {
        $totalArquivos = count($_FILES['Imagem']['name']);
        $stmtAddImg = $sql->prepare("INSERT INTO carro_imagem (id_car, caminho_img) VALUES (?, ?)");

        for ($i = 0; $i < $totalArquivos; $i++) {
            if ($_FILES['Imagem']['error'][$i] === UPLOAD_ERR_NO_FILE) {
                continue;
            }

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
                'Location: ../Editar/EditarVeiculo.php?id=' . $id,
                '../../../img/uploads/'
            );

            if (!empty($nomeArquivo)) {
                $stmtAddImg->bind_param("is", $id, $nomeArquivo);
                $stmtAddImg->execute();
            }
        }
    }

    $stmtCapa = $sql->prepare("SELECT caminho_img FROM carro_imagem WHERE id_car = ? ORDER BY id_img ASC LIMIT 1");
    $stmtCapa->bind_param("i", $id);
    $stmtCapa->execute();
    $resCapa = $stmtCapa->get_result();

    if ($rowCapa = $resCapa->fetch_assoc()) {
        $fotoCapa = $rowCapa['caminho_img'];
    } else {
        $fotoCapa = (!empty($fotoAtual) && file_exists("../../../.." . $fotoAtual)) ? $fotoAtual : '';
    }

    $stmt = $sql->prepare("UPDATE carro SET marca_car = ?, modelo_car = ?, ano_car = ?, preco_car = ?, cor_car = ?, quilometragem_car = ?, combustivel_car = ?, descricao_car = ?, foto_car = ?, data_car = ? WHERE id_car = ?");
    $stmt->bind_param("ssiisissssi", $Marca, $Modelo, $Ano, $Preco, $Cor, $Quilometragem, $Combustivel, $Descricao, $fotoCapa, $Data, $id);
    $stmt->execute();

    $sql->commit();

    $_SESSION['sucesso_cadastro'] = 'Veículo atualizado com sucesso!';
    $_SESSION['erro'] = false;

    header("Location: ../../admin/Veiculos.php");
    exit;

} catch (Exception $e) {
    $sql->rollback();
    $_SESSION['erro_cadastro'] = "Erro ao editar veiculo";
    $_SESSION['erro'] = true;
    header("Location: ../Editar/EditarVeiculo.php?id=" . $id);
    exit;
}
?>