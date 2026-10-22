<?php
    SESSION_START();
    
    if($_SESSION['user_email'] !== 'admin@gmail.com'){
             header("Location: ../user/Login.php");
            exit;
        }
    include_once "../salvar/Conexao.php";

                    $stmt = $sql->prepare("SELECT COUNT(id_car) FROM carro WHERE status_car = 0");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $numcar = $result->fetch_assoc();

                    $stmt = $sql->prepare("SELECT COUNT(id_cli) FROM cliente");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $numcli = $result->fetch_assoc();

                    $stmt = $sql->prepare("SELECT COUNT(id_col) FROM colaborador");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $numcol = $result->fetch_assoc();

                    $stmt = $sql->prepare("SELECT COUNT(id_ven) FROM vendas");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $numven = $result->fetch_assoc();

                    $stmt = $sql->prepare("SELECT COUNT(id_simu) FROM simulacao");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $numsimu = $result->fetch_assoc();

$stmt = $sql->prepare("SELECT 
            v.*, 
            c.*, 
            cl.*,
            YEAR(v.data_ven) AS ano,
            MONTH(v.data_ven) AS mes
        FROM vendas v 
        INNER JOIN carro c ON v.id_car = c.id_car 
        INNER JOIN cliente cl ON v.id_cli = cl.id_cli
        ORDER BY ano desc, mes ASC, v.data_ven ASC");
$stmt->execute();
$resultvendas = $stmt->get_result();
$vendas = $resultvendas->fetch_all(MYSQLI_ASSOC);
$mesesExtenso = [
    1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
    5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
    9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
];

$dadosAgrupados = [];
$totaisAnuais = [];
$totaisMensais = [];

$mesesExtenso = [
    1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
    5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
    9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
];

$dadosAgrupados = [];
$totaisAnuais = [];
$totaisMensais = [];

foreach ($vendas as $venda) {
    $ano = $venda['ano'];
    $mes = $venda['mes'];
    $valorVenda = $venda['valor_ven']; 

    if (!isset($totaisAnuais[$ano])) $totaisAnuais[$ano] = 0;
    if (!isset($totaisMensais[$ano][$mes])) $totaisMensais[$ano][$mes] = 0;

    $totaisAnuais[$ano] += $valorVenda;
    $totaisMensais[$ano][$mes] += $valorVenda;

    $dadosAgrupados[$ano][$mes][] = [
        'carro_foto' => $venda['foto_car'],  
        'carro_modelo' => $venda['modelo_car'],  
        'carro_marca'  => $venda['marca_car'],   
        'carro_ano'  => $venda['ano_car'],   
        'cliente_nome' => $venda['nome_cli'],
        'data' => $venda['data_ven'],
        'valor'        => $valorVenda
    ];
}

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../css/adimin.css">
    <script src="../../js/assets.js"></script>
</head>
<body>
<?php include __DIR__ . "/_Aside.php"; ?>
    <div id="DM1">
        <div id="DSM">
            <div id="DT"><h1>Dashboard</h1></div>
            <?php
            echo"
            <div class='DI'>
                <br><br><br>
                <div class='DIE'>
                    <img src='' alt=''>
                    <h1>Veículos</h1>
                    <p>".$numcar['COUNT(id_car)']."</p>
                </div>
                <div class='DIE'>
                    <img src='' alt=''>
                    <h1>Clientes</h1>
                    <p>".$numcli['COUNT(id_cli)']."</p>
                </div>
                <div class='DIE'>
                    <img src='' alt=''>
                    <h1>Colaboradores</h1>
                    <p>".$numcol['COUNT(id_col)']."</p>
                </div>
                 <div class='DIE'>
                    <img src='' alt=''>
                    <h1>Vendidos</h1>
                    <p>".$numven['COUNT(id_ven)']."</p>
                </div>
                 <div class='DIE'>
                    <img src='' alt=''>
                    <h1>Simuações</h1>
                    <p>".$numsimu['COUNT(id_simu)']."</p>
                </div>
             ";?>   
            </div><!-- final dos elementos-->

             <div id="DM1">
        <div id="DSM">



<div> 
    <h2>📊RELATORIO MENSAL</h2>
    <?php 
        if($resultvendas->num_rows > 0){
            foreach ($dadosAgrupados as $ano => $meses) {
                echo "
                <div onclick='toggleElemento(this)'>
                    <div>
                        <img src='#' alt='📅'>
                        <h1>".$ano."</h1>
                    </div>
                    <div>
                        <span>".number_format($totaisAnuais[$ano], 2, ',', '.')."</span>
                        <span>RECEITA</span>
                    </div>
                    <div>
                        <span class='seta-icone'>🔼</span>
                    </div>
                </div>
                ";

                echo "<div class='conteudo-ano' style='display: none;'>";

                foreach ($meses as $numMes => $listaVendas) {
                    echo "
                    <div onclick='toggleElemento(this)'>
                        <div>
                            <img src='#' alt='📅'>
                            <h1>".$mesesExtenso[$numMes]."</h1>
                        </div>
                        <div>
                            <span>".number_format($totaisMensais[$ano][$numMes], 2, ',', '.')."</span>
                            <span>RECEITA</span>
                        </div>
                        <div>
                            <span class='seta-icone'>🔼</span>
                        </div>
                    </div>
                    ";
                    
                    echo "<div class='conteudo-mes' style='display: none;'>";

                    echo "<ul>";
                    foreach ($listaVendas as $item) {
                        echo "
                        <li>
                            <img src='".$item['carro_foto']."' alt='Foto carro' width='200' height='150'>
                            <div>
                                <span>".$item['carro_marca']." ".$item['carro_modelo']." ".$item['carro_ano']."</span>
                                <span>".$item['cliente_nome']."</span>
                            </div>
                            <div>
                                <span>".number_format($item['valor'], 2, ',', '.')."</span>
                                <span>".$item['data']."</span>
                            </div>
                        </li>
                        ";
                    }
                    echo "</ul>";

                    echo "</div>";
                }

                echo "</div>";
            }
        }else{
            echo "<img src='#' alt='↗'> <h3>Nenhuma venda registrada ainda.</h3>";
        }
    ?>
</div>   


            </div><!-- final dos elementos-->

            

            <div id="DI2">
                <div class="DIE2">
                    <p></p>
                </div>
                <div class="DIE2">
                    <p></p>
                </div>
            </div>

        </div>
    </div>

    <div>
        <div>
            <img src="#" alt="💬">
            <h1>ATENDIMENTO</h1>
        </div>
        <div>
            <img src="#" alt="💬">
            <h3>Todas as negociações e venda de veículos são realizadas exclusivamente pelo WhatsApp. Os clientes são direcionados diretamente para o atendimento ao clicar nos botões do site.</h3>
        </div>
    </div>

        
</body>
</html>