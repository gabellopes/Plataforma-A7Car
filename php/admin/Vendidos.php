<?php
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
    
   require_once "../auth/authadm.php";
    
    include_once "../salvar/Conexao.php";

    // Pega o total geral em vendas
    $stmt = $sql->prepare("SELECT SUM(valor_ven) AS total FROM vendas;");
    $stmt->execute();
    $result = $stmt->get_result();
    $total = $result->fetch_assoc();
    $total_vendas = $total['total'] ?? 0;

    // 1. Busca os ANOS que possuem vendas na tabela 'vendas'
$sqlAnos = "SELECT DISTINCT YEAR(data_ven) AS ano FROM vendas ORDER BY ano DESC";
$resultAnos = $sql->query($sqlAnos);

// 2. Busca os MESES e ANOS que possuem vendas na tabela 'vendas'
$sqlMeses = "SELECT DISTINCT MONTH(data_ven) AS mes, YEAR(data_ven) AS ano FROM vendas ORDER BY ano DESC, mes DESC";
$resultMeses = $sql->query($sqlMeses);

$nomeMeses = [
    1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril', 5 => 'Maio', 6 => 'Junho',
    7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
];
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

                        //Link do whatsapp
                            $telefone = preg_replace('/[^0-9]/', '', $row['telefone_cli']);
                            $mensagemWhatsApp = "";
                            $urlWhatsApp = "https://wa.me/" . $telefone . "?text=" . urlencode($mensagemWhatsApp);

                            if ($row['status_car'] == 1) {
                                $preco_formatado = number_format($row['preco_car'], 2, ',', '.');
                                ?>
                             
                                <div id='VVEItens2'>
                                     <td><img src="<?php echo htmlspecialchars($row['foto_car'], ENT_QUOTES, 'UTF-8');?>" alt='Foto do Veículo' width='200' height='150'></td>
                                    <div>
                                        <div><?php echo htmlspecialchars($row['marca_car'], ENT_QUOTES, 'UTF-8'); ?></div>
                                        <div>Vendido</div>
                                        <div class="VEEItem2">
                                            <span><?php echo htmlspecialchars($row['modelo_car'], ENT_QUOTES, 'UTF-8'); ?></span>
                                            <span><?php echo htmlspecialchars($row['ano_car']); ?></span>
                                        </div>
                                        <span><img src="" alt=""><?php echo htmlspecialchars($row['quilometragem_car']); ?>km</span>
                                        <span><img src="" alt=""><?php echo htmlspecialchars($row['cor_car'], ENT_QUOTES, 'UTF-8'); ?></span>
                                        <span><img src="" alt=""><?php echo htmlspecialchars($row['combustivel_car'], ENT_QUOTES, 'UTF-8'); ?></span>

                                        <div>Valor da venda</div>
                                        <div>R$ <?php echo htmlspecialchars($row['preco_car']); ?></div>
                                        <div><img src="" alt=""><?php echo htmlspecialchars($row['data_ven'], ENT_QUOTES, 'UTF-8'); ?></div>
                                        <hr>
                                        
                                        <button onclick="window.open('<?php echo $urlWhatsApp; ?>', '_blank')">CONTATAR</button>
                                        
                                        <div>Comprador</div>
                                        <div><?php echo htmlspecialchars($row['nome_cli'], ENT_QUOTES, 'UTF-8'); ?></div>
                                        <div><img src="" alt=""><?php echo htmlspecialchars($row['telefone_cli']); ?></div>
                                    </div>
                                </div>
                <?php  
                            }
                        }
                    }
                ?>
                </div>
            </div> <!-- Final dos elementos 1-->
        </div><!-- Final do SubMain-->
        <div style="display: flex; gap: 20px;">
    <!-- Formulário Mensal -->
    <div class="card-relatorio">
        <h3>Relatório Mensal</h3>
        <form action="../salvar/Relatorios/relatorio_vendasMensal.php" method="POST" target="_blank">
            <label>Selecione o Mês:</label><br>
            <select name="mes_ano" required style="padding: 5px;">
                <option value="">Escolha um período...</option>
                <?php while($row = $resultMeses->fetch_assoc()): ?>
                    <option value="<?php echo $row['mes'] . '-' . $row['ano']; ?>">
                        <?php echo $nomeMeses[$row['mes']] . ' de ' . $row['ano']; ?>
                    </option>
                <?php endwhile; ?>
            </select><br><br>
            <button type="submit" class="btn">Gerar PDF Mensal</button>
        </form>
    </div>

    <!-- Formulário Anual -->
    <div class="card-relatorio">
        <h3>Relatório Anual</h3>
        <form action="../salvar/Relatorios/relatorio_vendasAnual.php" method="POST" target="_blank">
            <label>Selecione o Ano:</label><br>
            <select name="ano" required style="padding: 5px;">
                <option value="">Escolha um ano...</option>
                <?php while($row = $resultAnos->fetch_assoc()): ?>
                    <option value="<?php echo $row['ano']; ?>">
                        <?php echo $row['ano']; ?>
                    </option>
                <?php endwhile; ?>
            </select><br><br>
            <button type="submit" class="btn">Gerar PDF Anual</button>
        </form>
    </div>
</div>
    </div><!-- Final da Main-->
</body>
</html>