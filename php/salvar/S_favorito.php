<?php

include "funcoes.php";
require_once "Conexao.php";
header('Content-Type: application/json');



if (isset($_POST['id_veiculo'])) {
    $usuarioId = $_SESSION['user_id'];
    $veiculoId = intval($_POST['id_veiculo']);


    $verifica = $sql->prepare("SELECT id_fav FROM favorito WHERE id_usu = ? AND id_car = ?");
    $verifica->bind_param("ii", $usuarioId, $veiculoId);
    $verifica->execute();
    $resultado = $verifica->get_result();

    /*
CREATE TABLE IF NOT EXISTS `favorito` (
  `id_fav` int NOT NULL AUTO_INCREMENT,
  `id_usu` int NOT NULL,
  `id_car` int NOT NULL,
  PRIMARY KEY (`id_fav`),
  KEY `id_usu` (`id_usu`),
  KEY `id_car` (`id_car`),
  CONSTRAINT `favorito_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `usuario` (`id_usu`),
  CONSTRAINT `favorito_ibfk_2` FOREIGN KEY (`id_car`) REFERENCES `carro` (`id_car`)
)
    */

$resposta = ['sucesso' => false, 'mensagem' => 'Erro desconhecido.'];

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    $resposta['mensagem'] = 'Usuário não autenticado.';
    echo json_encode($resposta);
    exit;
}

    if (mysqli_num_rows($resultado) > 0) {
        // Se já existe, remove (desfavorita)
        $sqlDeleta = "DELETE FROM  favorito WHERE id_usu = ? AND id_car = ?";
        $stmtDel = mysqli_prepare($sql, $sqlDeleta);
        mysqli_stmt_bind_param($stmtDel, "ii", $usuarioId, $veiculoId);
        
        if (mysqli_stmt_execute($stmtDel)) {
            $resposta = ['sucesso' => true, 'acao' => 'removido'];
        } else {
            $resposta['mensagem'] = 'Erro ao remover dos favoritos.';
        }
    } else {
        // Se não existe, insere (favorita)
        $sqlInsere = "INSERT INTO favorito (id_usu, id_car) VALUES (?, ?)";
        $stmtIns = mysqli_prepare($sql, $sqlInsere);
        mysqli_stmt_bind_param($stmtIns, "ii", $usuarioId, $veiculoId);
        
        if (mysqli_stmt_execute($stmtIns)) {
            $resposta = ['sucesso' => true, 'acao' => 'adicionado'];
        } else {
            $resposta['mensagem'] = 'Erro ao adicionar aos favoritos.';
        }
    }
} else {
    $resposta['mensagem'] = 'ID do veículo não recebido.';
}

// Retorna a resposta em formato JSON para o JavaScript
echo json_encode($resposta);
?>