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
                    <img src="" alt="">
                    <div>
                        <div>Marca</div>
                        <div>Vendido</div>
                        <div class="VEEItem2">Modelo<span> Ano do modelo</span></div>
                        <span><img src="" alt="">Quilometragem</span>
                        <span><img src="" alt="">Cor</span>
                        <span><img src="" alt="">Combustível</span>

                        <div>Valor da venda</div>
                        <div>R$00000,00</div>
                        <div><img src="" alt="">data da venda</div>
                        <hr><button><img src="" alt="">CONTATAR</button>
                        <div>Comprador</div>
                        <div>Nome do comprador</div>
                        <div><img src="" alt="">551199999-9999</div>
                    </div>
                </div>
            </div><!-- Final dos elementos-->
            
        </div><!-- Final do SubMain-->

    </div><!-- Final da Main-->
</body>
</html>