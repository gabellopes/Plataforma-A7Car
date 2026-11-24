<?php
require_once "../salvar/Conexao.php";
$temMaisCarros = false;
$contador = 0;

try {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user_id'])) {
        exit;
    }

    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 3;
    if ($limit < 1) {
        $limit = 3;
    }
    $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
    $limiteQuery = $limit + 1;

    $stmt = $sql->prepare("SELECT c.* FROM carro c INNER JOIN favorito f ON c.id_car = f.id_car WHERE f.id_usu = ? AND c.status_car = 0 LIMIT ? OFFSET ?");
    $stmt->bind_param("iii", $_SESSION['user_id'], $limiteQuery, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0 && $offset === 0) {
        echo "
        <div>
            <img src='#' alt='ftcoracao'>🖤🚗
            <h1>Você ainda não tem favoritos</h1>
            <a href='catalogo.php'>EXPLORAR CATÁLOGO🚘</a>
        </div>
        ";
    }

    $temMaisCarros = ($result->num_rows > $limit);

    while ($row = $result->fetch_assoc()) {
        if ($contador >= $limit) {
            break;
        }

        echo "
        <div>
            <button class='btn-favoritar' data-id=" . $row['id_car'] . ">❤️</button>
            <img src='" . htmlspecialchars($row['foto_car'], ENT_QUOTES, 'UTF-8') . "' alt='Foto do Veículo' width='200' height='150'>
            <span></span>
            <span>" . htmlspecialchars($row['marca_car'], ENT_QUOTES, 'UTF-8') . "</span>
            <span>" . htmlspecialchars($row['modelo_car'], ENT_QUOTES, 'UTF-8') . "</span>
            <span>" . htmlspecialchars($row['ano_car']) . "</span><span>" . htmlspecialchars($row['quilometragem_car']) . "</span><span>" . htmlspecialchars($row['combustivel_car'], ENT_QUOTES, 'UTF-8') . "</span>

            <hr>

            <div>
                <p>Valor</p>
                <span>R$" . htmlspecialchars($row['preco_car']) . "</span>
                <button onclick=\"location.href='Veiculo.php?id=" . $row['id_car'] . "'\">👁VER</button>
            </div>
        </div>
        <br>
        ";

        $contador++;
    }
} catch (Exception $e) {
    echo "Erro tente novamente mais tarde";
}

echo "<span class='controle-paginacao' data-tem-mais='" . ($temMaisCarros ? "1" : "0") . "' data-carregados='" . $contador . "' style='display:none;'></span>";
?>