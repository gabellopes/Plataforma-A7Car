<?php
if(SESSION_STATUS() === PHP_SESSION_NONE){
    session_start();
}
require_once "../salvar/Conexao.php";

$busca = isset($_GET['busca']) ? $_GET['busca'] : '';

if (!empty($busca)) {
    $stmt = $sql->prepare("SELECT * FROM carro WHERE (marca_car LIKE ? OR modelo_car LIKE ?) AND status_car = 0");
    $termo = "%" . $busca . "%";
    $stmt->bind_param("ss", $termo, $termo);
} else {
    $stmt = $sql->prepare("SELECT * FROM carro WHERE status_car = 0");
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p>Nenhum veículo encontrado.</p>";

}

while($row = $result->fetch_assoc()){
                if($row['status_car'] === 0){

                    if(isset($_SESSION['user_id'])){
                        $verifica = $sql->prepare("SELECT id_fav FROM favorito WHERE id_usu = ? AND id_car = ?");
                        $verifica->bind_param("ii", $_SESSION['user_id'], $row['id_car']);
                        $verifica->execute();
                        $resultado = $verifica->get_result();

                        if($resultado->num_rows > 0){
                            echo"
                        <div>
                        <button class='btn-favoritar' data-id=".$row['id_car'].">❤️</button>
                        ";
                        }else{
                        echo"
                        <div>
                        <button class='btn-favoritar' data-id=".$row['id_car'].">❤</button>
                        ";
                        }
                    }else{
                        echo"
                        <div>
                        <button onclick='window.location.href=\"Login.php\"'>❤</button>
                        ";
                    }

                    echo "
                   
                    <img src='" . htmlspecialchars($row['foto_car'], ENT_QUOTES, 'UTF-8') . "' alt='Foto do Veículo' width='200' height='150'>
                    <span></span>
                    <span>".htmlspecialchars($row['marca_car'], ENT_QUOTES, 'UTF-8')."</span>
                    <span>".htmlspecialchars($row['modelo_car'], ENT_QUOTES, 'UTF-8')."</span>
                    <span>".htmlspecialchars($row['ano_car'])."</span><span>".htmlspecialchars($row['quilometragem_car'])."</span><span>".htmlspecialchars($row['combustivel_car'], ENT_QUOTES, 'UTF-8')."</span>

                    <hr>

                    <div>
                        <p>Valor</p>
                        <span>R$".number_format(htmlspecialchars($row['preco_car']), 2, ',', '.')."</span>
                        <button onclick=\"location.href='Veiculo.php?id=".$row['id_car']."'\">👁VER</button>
                    </div>
                </div>
                <br>

                
                    ";}}
?>