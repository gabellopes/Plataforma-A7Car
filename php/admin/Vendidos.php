<?php
    SESSION_START();
    
    if($_SESSION['user_email'] !== 'admin@gmail.com'){
             header("Location: ../user/Login.php");
            exit;
        }
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veículos Vendidos</title>
    <link rel="stylesheet" href="../../css/adimin.css">
</head>
<body>
<?php include __DIR__ . "/_Aside.php"; ?>
      <div id="VVM">
        <div id="VVSM">
            <div id="VVT">
                <h1>VEÍCULOS VENDIDOS</h1>
                <p>Histórico de todas as vendas realizadas</p>
                <div>R$0,00</div>
                <div>Total em vendas</div>
            </div> <!-- Final VT-->

            <div id="VVElementos">
                <!--<div id="VVEItens">
                    <img src="" alt="">
                    <p>Nenhum veículo vendido ainda.</p>
                    <p>Ao aceitar uma proposta ou marcar um veículo como vendido, ele aparecerá aqui.</p>
                </div>-->

                <div id="VVEItens2">
                    <?php 
                    include_once "../salvar/Conexao.php";

                    $stmt = $sql->prepare("SELECT * FROM vendas v INNER JOIN carro c ON v.id_car = c.id_car INNER JOIN cliente cl ON v.id_cli = cl.id_cli;");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while($row = $result->fetch_assoc()){
                    if($row['status_car'] === 1){
                    echo"
                    <img >
                    <div>
                        <div>".$row['marca_car']."</div>
                        <div>Vendido</div>
                        <div class='VEEItem2'><span> ".$row['modelo_car']."</span><span> ".$row['ano_car']."</span></div>
                        <span><img src='' alt=''>".$row['quilometragem_car']."km</span>
                        <span><img src='' alt=''>".$row['cor_car']."</span>
                        <span><img src='' alt=''>".$row['combustivel_car']."</span>

                        <div>Valor da venda</div>
                        <div>R$".$row['preco_car']."</div>
                        <div><img src='' alt=''>".$row['data_ven']."</div>
                        <hr><button><img src='' alt=''>CONTATAR</button>
                        <div>Comprador</div>
                        <div>".$row['nome_cli']."</div>
                        <div><img src='' alt=''>".$row['telefone_cli']."</div>
                    </div>
                    ";}}?>
                </div>
            </div><!-- Final dos elementos-->
            
        </div><!-- Final do SubMain-->

    </div><!-- Final da Main-->
</body>
</html>