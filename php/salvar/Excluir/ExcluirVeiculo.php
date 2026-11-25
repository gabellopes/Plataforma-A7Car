<?php
require_once "../Conexao.php";
require_once "../funcoes.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../../auth/authadm.php";

$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    $_SESSION['erro_cadastro'] = "ID de veículo inválido.";
    $_SESSION['erro'] = true;
    header("Location: ../../admin/Veiculos.php");
    exit;
}

try {
    $caminhosParaExcluir = [];

    $stmtImgs = $sql->prepare("SELECT caminho_img FROM carro_imagem WHERE id_car = ?");
    $stmtImgs->bind_param("i", $id);
    $stmtImgs->execute();
    $resImgs = $stmtImgs->get_result();

    while ($row = $resImgs->fetch_assoc()) {
        if (!empty($row['caminho_img'])) {
            $caminhosParaExcluir[] = $row['caminho_img'];
        }
    }

    $stmtCarro = $sql->prepare("SELECT foto_car FROM carro WHERE id_car = ?");
    $stmtCarro->bind_param("i", $id);
    $stmtCarro->execute();
    $resCarro = $stmtCarro->get_result();

    if ($rowCarro = $resCarro->fetch_assoc()) {
        if (!empty($rowCarro['foto_car'])) {
            $caminhosParaExcluir[] = $rowCarro['foto_car'];
        }
    }

    $caminhosParaExcluir = array_unique($caminhosParaExcluir);

    $stmtDel = $sql->prepare("DELETE FROM carro WHERE id_car = ?");
    $stmtDel->bind_param("i", $id);
    $stmtDel->execute();

    foreach ($caminhosParaExcluir as $caminhoImg) {
        $caminhoRelativo = "../../.." . $caminhoImg;

        if (file_exists($caminhoRelativo) && is_file($caminhoRelativo)) {
            unlink($caminhoRelativo);
        }
    }

    $_SESSION['sucesso_cadastro'] = "Veículo excluído com sucesso!";
    $_SESSION['erro'] = false;
    header("Location: ../../admin/Veiculos.php");
    exit;

} catch (Exception $e) {
    $_SESSION['erro_cadastro'] = "Erro ao tentar excluir veículo.";
    $_SESSION['erro'] = true;
    header("Location: ../../admin/Veiculos.php");
    exit;
}
?>