<?php
require_once "../salvar/Conexao.php";
try{
if(SESSION_STATUS() === PHP_SESSION_NONE){
    session_start();
}


$busca = isset($_GET['busca']) ? $_GET['busca'] : '';
$limit = 6; 
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
if (!empty($busca)) {
    $stmt = $sql->prepare("SELECT * FROM carro WHERE (marca_car LIKE ? OR modelo_car LIKE ?) AND status_car = 0 LIMIT ? OFFSET ? ");
    $termo = "%" . $busca . "%";
    $stmt->bind_param("ssii", $termo, $termo, $limit, $offset);
} else {
    $stmt = $sql->prepare("SELECT * FROM carro WHERE status_car = 0 LIMIT ? OFFSET ?");
    $stmt->bind_param("ii", $limit, $offset);
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
                    <div>
                        <span></span>
                        <span>Marca: ".htmlspecialchars($row['marca_car'], ENT_QUOTES, 'UTF-8')."</span>
                        <span>Modelo: ".htmlspecialchars($row['modelo_car'], ENT_QUOTES, 'UTF-8')."</span>
                        <span><img src='../../img/catalogo/calendario.png' alt='📅'>".htmlspecialchars($row['ano_car'])."</span><span><img src='../../img/catalogo/velocimetro.png' alt='📅'>".htmlspecialchars($row['quilometragem_car'])."</span><span><img src='../../img/catalogo/cor.png' alt='📅'>".htmlspecialchars($row['combustivel_car'], ENT_QUOTES, 'UTF-8')."</span>

                        <hr>

                        <div>
                            <p>Valor</p>
                            <span>R$".number_format(htmlspecialchars($row['preco_car']), 2, ',', '.')."</span>
                            <button onclick=\"location.href='Veiculo.php?id=".$row['id_car']."'\"><img src='../../img/catalogo/olho.png' alt='📅'>VER</button>
                        </div>
                    </div>
                    
                </div>
                <br>

                
                    ";}}
}catch(Exception $e){
            //echo"Erro tente novamente mais tarde" . " " . $e->getMessage();
            echo"Erro tente novamente mais tarde" ;
        }

if ($result->num_rows < $limit) {
    
} else {
    
    echo "<style>#btn-carregar-mais { display: block !important; }</style>";
}
?>