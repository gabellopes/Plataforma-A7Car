<?php
    session_start();
    
    if ($_SESSION['user_email'] !== 'admin@gmail.com') {
        header("Location: ../user/Login.php");
        exit;
    }
    
    include_once "../salvar/Conexao.php";

    // Pega o total geral em vendas
    $stmt = $sql->prepare("SELECT SUM(valor_ven) AS total FROM vendas;");
    $stmt->execute();
    $result = $stmt->get_result();
    $total = $result->fetch_assoc();
    $total_vendas = $total['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veículos Vendidos</title>
    <link rel="stylesheet" href="../../css/adimin.css">
    <link rel="stylesheet" href="../../css/ADMvendidos.css">
</head>
<body>
<?php include __DIR__ . "/_Aside.php"; ?>

    <div id="VVM">
        <div id="VVSM">
            <div id="VVT">
                <div>
                    <h1>VEÍCULOS VENDIDOS</h1>
                    <p id="cinza">Histórico de todas as vendas realizadas</p>
                </div>
                <div id="total">
                    <p id="verde">R$ <?php echo number_format($total_vendas, 2, ',', '.'); ?></p>
                    <p id="cinza">Total em vendas</p>
                </div>
                
                <div id="VVElementos">
                <?php 
                    $stmt = $sql->prepare("SELECT * FROM vendas v INNER JOIN carro c ON v.id_car = c.id_car INNER JOIN cliente cl ON v.id_cli = cl.id_cli");
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Verifica se existem registros
                    if ($result->num_rows === 0) {
                ?>
                    <div id="VVEItens">
                        <img src="" alt="">
                        <p>Nenhum veículo vendido ainda.</p>
                        <p>Ao aceitar uma proposta ou marcar um veículo como vendido, ele aparecerá aqui.</p>
                    </div>
                <?php 
                    } else {
                        while ($row = $result->fetch_assoc()) {
                            if ($row['status_car'] == 1) {
                                $preco_formatado = number_format($row['preco_car'], 2, ',', '.');
                                echo "
                                <div id='VVEItens2'>
                                     <td><img src='" . htmlspecialchars($row['foto_car'], ENT_QUOTES, 'UTF-8') . "' alt='Foto do Veículo' width='200' height='150'></td>
                                        <div>
                                            <div>".htmlspecialchars($row['marca_car'], ENT_QUOTES, 'UTF-8')."</div>
                                            <div>Vendido</div>
                                            <div class='VEEItem2'><span> ".htmlspecialchars($row['modelo_car'], ENT_QUOTES, 'UTF-8')."</span><span> ".htmlspecialchars($row['ano_car'])."</span></div>
                                            <span><img src='' alt=''>".htmlspecialchars($row['quilometragem_car'])."km</span>
                                            <span><img src='' alt=''>".htmlspecialchars($row['cor_car'], ENT_QUOTES, 'UTF-8')."</span>
                                            <span><img src='' alt=''>".htmlspecialchars($row['combustivel_car'], ENT_QUOTES, 'UTF-8')."</span>

                                            <div>Valor da venda</div>
                                            <div>R$".htmlspecialchars($row['preco_car'])."</div>
                                            <div><img src='' alt=''>".htmlspecialchars($row['data_ven'], ENT_QUOTES, 'UTF-8')."</div>
                                            <hr><button><img src='' alt=''>CONTATAR</button>
                                            <div>Comprador</div>
                                            <div>".htmlspecialchars($row['nome_cli'], ENT_QUOTES, 'UTF-8')."</div>
                                            <div><img src='' alt=''>".htmlspecialchars($row['telefone_cli'])."</div>
                                        </div>
                                </div>";
                            }
                        }
                    }
                ?>
                </div>
            </div> <!-- Final dos elementos 1-->
        </div><!-- Final do SubMain-->
    </div><!-- Final da Main-->
</body>
</html>