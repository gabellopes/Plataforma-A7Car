<?php
ob_start();
date_default_timezone_set('America/Sao_Paulo');

// CAMINHOS
require('../../../fpdf/fpdf.php'); 
require_once "../Conexao.php";
if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
    
   require_once "../../auth/authadm.php"; 

// ==============================================================================
// 1. CLASSE PDF COM FUNÇÕES MATEMÁTICAS PARA DESENHAR GRÁFICOS (PIZZA E COLUNAS)
// ==============================================================================
class PDF extends FPDF {
    public $tituloCabecalho = 'Relatório Geral Consolidado - A7Car';

    function Header() {
        $this->Image('../../../img/logo.png', 10, 8, 33);
        
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(45); 
        $titulo = mb_convert_encoding($this->tituloCabecalho, 'ISO-8859-1', 'UTF-8');
        $this->Cell(100, 10, $titulo, 0, 0, 'C');
        
        $this->SetFont('Arial', 'I', 9);
        $dataEmissao = mb_convert_encoding('Emitido: ' . date('d/m/Y H:i'), 'ISO-8859-1', 'UTF-8');
        $this->Cell(0, 10, $dataEmissao, 0, 1, 'R');
        $this->Ln(15);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $pagina = mb_convert_encoding('Página ', 'ISO-8859-1', 'UTF-8');
        $this->Cell(0, 10, $pagina.$this->PageNo().'/{nb}', 0, 0, 'C');
    }

    // --- FUNÇÕES NATIVAS PARA DESENHAR O GRÁFICO DE PIZZA (Sector) ---
    function Sector($xc, $yc, $r, $a, $b, $style='FD', $cw=true, $o=90) {
        $d0 = $a - $b;
        if($cw){
            $d = $b; $b = $o - $a; $a = $o - $d;
        }else{
            $b += $o; $a += $o;
        }
        while($a<0) $a += 360;
        while($a>360) $a -= 360;
        while($b<0) $b += 360;
        while($b>360) $b -= 360;
        if ($a > $b) $b += 360;
        $b = $b/360*2*M_PI;
        $a = $a/360*2*M_PI;
        $d = $b - $a;
        if ($d == 0 && $d0 != 0) $d = 2*M_PI;
        $k = $this->k;
        $hp = $this->h;
        if (sin($d/2)) $MyArc = 4/3*(1-cos($d/2))/sin($d/2)*$r;
        else $MyArc = 0;
        $this->_out(sprintf('%.2F %.2F m',($xc)*$k,($hp-$yc)*$k));
        $this->_out(sprintf('%.2F %.2F l',($xc+$r*cos($a))*$k,($hp-($yc-$r*sin($a)))*$k));
        if ($d < M_PI/2){
            $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a), $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a), $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2), $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2), $xc+$r*cos($b), $yc-$r*sin($b));
        }else{
            $b = $a + $d/4; $MyArc = 4/3*(1-cos($d/8))/sin($d/8)*$r;
            $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a), $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a), $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2), $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2), $xc+$r*cos($b), $yc-$r*sin($b));
            $a = $b; $b = $a + $d/4;
            $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a), $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a), $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2), $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2), $xc+$r*cos($b), $yc-$r*sin($b));
            $a = $b; $b = $a + $d/4;
            $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a), $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a), $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2), $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2), $xc+$r*cos($b), $yc-$r*sin($b));
            $a = $b; $b = $a + $d/4;
            $this->_Arc($xc+$r*cos($a)+$MyArc*cos(M_PI/2+$a), $yc-$r*sin($a)-$MyArc*sin(M_PI/2+$a), $xc+$r*cos($b)+$MyArc*cos($b-M_PI/2), $yc-$r*sin($b)-$MyArc*sin($b-M_PI/2), $xc+$r*cos($b), $yc-$r*sin($b));
        }
        if($style=='F') $op='f'; elseif($style=='FD' || $style=='DF') $op='b'; else $op='s';
        $this->_out($op);
    }
    function _Arc($x1, $y1, $x2, $y2, $x3, $y3) {
        $h = $this->h;
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c', $x1*$this->k, ($h-$y1)*$this->k, $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();

// Arrays de tradução de meses para usar no título mensal
$nomeMeses = [
    1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
    5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
    9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
];
$mesAtualNome = $nomeMeses[(int)date('m')];

// ==============================================================================
// 2. PÁGINA 1: GRÁFICOS DE DESEMPENHO
// ==============================================================================
$pdf->tituloCabecalho = 'Relatório Geral Consolidado - A7Car'; 
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, mb_convert_encoding('1. GRÁFICOS DE DESEMPENHO', 'ISO-8859-1', 'UTF-8'), 0, 1, 'L');
$pdf->Ln(5);

// Busca o total vendido por ano para a Pizza
$sqlAnos = "SELECT YEAR(data_ven) as ano, SUM(valor_ven) as total FROM vendas GROUP BY YEAR(data_ven)";
$resultAnos = $sql->query($sqlAnos);

$dadosPizza = [];
$totalGeral = 0;
while ($row = $resultAnos->fetch_assoc()) {
    $dadosPizza[$row['ano']] = $row['total'];
    $totalGeral += $row['total'];
}

// Desenhando o Gráfico de Pizza
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, mb_convert_encoding('Comparativo de Vendas por Ano', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
$xc = 60; $yc = 85; $r = 30; // Posicionamento ajustado para cima
$anguloAtual = 0;
$cores = [[50,150,250], [250,100,100], [100,200,100], [250,200,50], [150,50,200]];
$i = 0;

$legendaY = 65;
if ($totalGeral > 0) {
    foreach ($dadosPizza as $ano => $valor) {
        $anguloFatia = ($valor / $totalGeral) * 360;
        $pdf->SetFillColor($cores[$i][0], $cores[$i][1], $cores[$i][2]);
        
        $pdf->Sector($xc, $yc, $r, $anguloAtual, $anguloAtual + $anguloFatia);
        $anguloAtual += $anguloFatia;
        
        $pdf->Rect(110, $legendaY, 5, 5, 'F');
        $pdf->SetXY(118, $legendaY - 2);
        $textoFatia = $ano . ' - R$ ' . number_format($valor, 2, ',', '.');
        $pdf->Cell(0, 10, mb_convert_encoding($textoFatia, 'ISO-8859-1', 'UTF-8'), 0, 1);
        
        $legendaY += 8;
        $i++;
        if($i >= count($cores)) $i = 0;
    }
} else {
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 10, 'Nenhum dado de venda disponivel para o grafico.', 0, 1, 'C');
}

// Gráfico de Colunas (Vendas do Ano Atual por Mês)
$pdf->SetXY(10, 130);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, mb_convert_encoding('Vendas Mensais do Ano Atual', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

$anoAtual = date('Y');
$sqlMeses = "SELECT MONTH(data_ven) as mes, SUM(valor_ven) as total FROM vendas WHERE YEAR(data_ven) = ? GROUP BY MONTH(data_ven)";
$stmtMes = $sql->prepare($sqlMeses);
$stmtMes->bind_param("i", $anoAtual);
$stmtMes->execute();
$resultMeses = $stmtMes->get_result();

$vendasMes = array_fill(1, 12, 0); 
$maxVenda = 1000; 
while ($row = $resultMeses->fetch_assoc()) {
    $vendasMes[$row['mes']] = $row['total'];
    if ($row['total'] > $maxVenda) $maxVenda = $row['total'];
}

$posX = 20;
$posYBase = 250;
$larguraColuna = 10;
$alturaMax = 100;

foreach ($vendasMes as $mes => $valor) {
    // Coluna Real
    $alturaReal = ($valor / $maxVenda) * $alturaMax;
    $pdf->SetFillColor(50,150,250);
    $pdf->Rect($posX, $posYBase - $alturaReal, $larguraColuna, $alturaReal, 'F');
    
    // Texto do mês
    $pdf->SetXY($posX, $posYBase + 2);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell($larguraColuna, 5, str_pad($mes, 2, '0', STR_PAD_LEFT), 0, 0, 'C');
    
    $posX += 14; 
}

// Legenda do Gráfico de Colunas
$pdf->SetFillColor(50,150,250);
$pdf->Rect(20, 265, 5, 5, 'F');
$pdf->SetXY(28, 263);
$pdf->Cell(40, 10, 'Total Vendido no Mes (Real)', 0, 0);


// ==============================================================================
// 3. PÁGINA 2: HISTÓRICO DE VENDAS (ANTES ERA "VENDAS ANUAIS")
// ==============================================================================
$pdf->tituloCabecalho = 'Relatório Geral - Histórico de Vendas'; 
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(255, 230, 200); 
$pdf->Cell(25, 10, 'Data', 1, 0, 'C', true);
$pdf->Cell(70, 10, mb_convert_encoding('Veículo (Marca/Modelo)', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
$pdf->Cell(60, 10, 'Cliente (CPF)', 1, 0, 'C', true);
$pdf->Cell(35, 10, 'Valor (R$)', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 9);
$sqlBusca = "SELECT c.marca_car, c.modelo_car, cli.cpf_cli, v.valor_ven, v.data_ven 
             FROM vendas v
             INNER JOIN carro c ON v.id_car = c.id_car
             INNER JOIN cliente cli ON v.id_cli = cli.id_cli
             ORDER BY v.data_ven DESC";
$result = $sql->query($sqlBusca);
$totalAnual = 0; 
$qtdAnual = 0;

if($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $veiculoInfo = mb_convert_encoding($row['marca_car'] . ' ' . $row['modelo_car'], 'ISO-8859-1', 'UTF-8');
        $dataBr = date('d/m/Y', strtotime($row['data_ven']));
        
        $pdf->Cell(25, 10, $dataBr, 1, 0, 'C');
        $pdf->Cell(70, 10, $veiculoInfo, 1, 0, 'L');
        $pdf->Cell(60, 10, $row['cpf_cli'], 1, 0, 'C');
        $pdf->Cell(35, 10, number_format($row['valor_ven'], 2, ',', '.'), 1, 1, 'R');
        
        $totalAnual += $row['valor_ven'];
        $qtdAnual++;
    }
} else {
    $pdf->Cell(190, 10, 'Nenhuma venda registrada no banco de dados.', 1, 1, 'C');
}

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(230, 230, 230);
$textoAnual = mb_convert_encoding('TOTAL HISTÓRICO (' . $qtdAnual . ' carros):', 'ISO-8859-1', 'UTF-8');
$pdf->Cell(155, 10, $textoAnual, 1, 0, 'R', true);
$pdf->Cell(35, 10, number_format($totalAnual, 2, ',', '.'), 1, 1, 'R', true);


// ==============================================================================
// 4. PÁGINA 3: VENDAS DO MÊS (EX: "Vendas de Outubro")
// ==============================================================================
$pdf->tituloCabecalho = 'Relatório Geral - Vendas de ' . $mesAtualNome; 
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(200, 255, 200); 
$pdf->Cell(25, 10, 'Data', 1, 0, 'C', true);
$pdf->Cell(65, 10, mb_convert_encoding('Veículo (Marca/Modelo)', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
$pdf->Cell(70, 10, 'Cliente', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Valor (R$)', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 9);
$sqlBuscaMes = "SELECT c.marca_car, c.modelo_car, cli.nome_cli, v.valor_ven, v.data_ven 
                FROM vendas v
                INNER JOIN carro c ON v.id_car = c.id_car
                INNER JOIN cliente cli ON v.id_cli = cli.id_cli
                WHERE MONTH(v.data_ven) = MONTH(CURRENT_DATE()) AND YEAR(v.data_ven) = YEAR(CURRENT_DATE())
                ORDER BY v.data_ven DESC";
$resultMes = $sql->query($sqlBuscaMes);
$totalMes = 0; $qtdMes = 0;

if($resultMes->num_rows > 0) {
    while ($row = $resultMes->fetch_assoc()) {
        $veiculoInfo = mb_convert_encoding($row['marca_car'] . ' ' . $row['modelo_car'], 'ISO-8859-1', 'UTF-8');
        $clienteNome = mb_convert_encoding($row['nome_cli'], 'ISO-8859-1', 'UTF-8');
        
        $pdf->Cell(25, 10, date('d/m/Y', strtotime($row['data_ven'])), 1, 0, 'C');
        $pdf->Cell(65, 10, $veiculoInfo, 1, 0, 'L');
        $pdf->Cell(70, 10, $clienteNome, 1, 0, 'L');
        $pdf->Cell(30, 10, number_format($row['valor_ven'], 2, ',', '.'), 1, 1, 'R');
        $totalMes += $row['valor_ven'];
        $qtdMes++;
    }
} else {
    $pdf->Cell(190, 10, 'Nenhuma venda registrada neste mes.', 1, 1, 'C');
}
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(230, 230, 230);
$pdf->Cell(160, 10, mb_convert_encoding('TOTAL MENSAL (' . $qtdMes . ' carros):', 'ISO-8859-1', 'UTF-8'), 1, 0, 'R', true);
$pdf->Cell(30, 10, number_format($totalMes, 2, ',', '.'), 1, 1, 'R', true);


// ==============================================================================
// 5. PÁGINA 4: ESTOQUE ATIVO
// ==============================================================================
$pdf->tituloCabecalho = 'Relatório Geral - Veículos em Estoque'; 
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 11);
$pdf->SetFillColor(200, 220, 255); 
$pdf->Cell(45, 10, 'Marca', 1, 0, 'C', true);
$pdf->Cell(65, 10, 'Modelo', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Ano', 1, 0, 'C', true);
$pdf->Cell(50, 10, mb_convert_encoding('Preço (R$)', 'ISO-8859-1', 'UTF-8'), 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 11);
$stmtEst = $sql->prepare("SELECT marca_car, modelo_car, ano_car, preco_car FROM carro WHERE status_car = 0");
$stmtEst->execute();
$resEstoque = $stmtEst->get_result();

if ($resEstoque->num_rows > 0) {
    while ($row = $resEstoque->fetch_assoc()) {
        $pdf->Cell(45, 10, mb_convert_encoding($row['marca_car'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        $pdf->Cell(65, 10, mb_convert_encoding($row['modelo_car'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'L');
        $pdf->Cell(30, 10, $row['ano_car'], 1, 0, 'C');
        $pdf->Cell(50, 10, number_format($row['preco_car'], 2, ',', '.'), 1, 1, 'R');
    }
} else {
    $pdf->Cell(190, 10, 'Nenhum veiculo no estoque.', 1, 1, 'C');
}


// ==============================================================================
// 6. PÁGINA 5: COLABORADORES
// ==============================================================================
$pdf->tituloCabecalho = 'Relatório Geral - Equipe de Colaboradores';
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(255, 240, 200); 
$pdf->Cell(50, 10, 'Nome', 1, 0, 'C', true);
$pdf->Cell(45, 10, mb_convert_encoding('Serviço/Cargo', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
$pdf->Cell(35, 10, 'Telefone', 1, 0, 'C', true);
$pdf->Cell(60, 10, 'E-mail', 1, 1, 'C', true); 

$pdf->SetFont('Arial', '', 9); 
$stmtCol = $sql->prepare("SELECT nome_col, servico_col, telefone_col, email_col FROM colaborador ORDER BY nome_col ASC");
$stmtCol->execute();
$resCol = $stmtCol->get_result();

if ($resCol->num_rows > 0) {
    while ($row = $resCol->fetch_assoc()) {
        $pdf->Cell(50, 10, mb_convert_encoding($row['nome_col'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'L');
        $pdf->Cell(45, 10, mb_convert_encoding($row['servico_col'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        $pdf->Cell(35, 10, $row['telefone_col'], 1, 0, 'C');
        $pdf->Cell(60, 10, mb_convert_encoding($row['email_col'], 'ISO-8859-1', 'UTF-8'), 1, 1, 'L');
    }
} else {
    $pdf->Cell(190, 10, 'Nenhum colaborador encontrado.', 1, 1, 'C');
}


// ==============================================================================
// 7. PÁGINA 6: CLIENTES
// ==============================================================================
$pdf->tituloCabecalho = 'Relatório Geral - Clientes Cadastrados';
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(230, 240, 255); 
$pdf->Cell(60, 10, 'Nome', 1, 0, 'C', true);
$pdf->Cell(55, 10, 'E-mail', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Telefone', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'CPF', 1, 0, 'C', true);
$pdf->Cell(20, 10, 'CNH', 1, 1, 'C', true); 

$pdf->SetFont('Arial', '', 9); 
$stmtCli = $sql->prepare("SELECT nome_cli, email_cli, telefone_cli, cpf_cli, cnh_cli FROM cliente ORDER BY nome_cli ASC");
$stmtCli->execute();
$resCli = $stmtCli->get_result();

if ($resCli->num_rows > 0) {
    while ($row = $resCli->fetch_assoc()) {
        $pdf->Cell(60, 10, mb_convert_encoding($row['nome_cli'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'L');
        $pdf->Cell(55, 10, mb_convert_encoding($row['email_cli'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'L');
        $pdf->Cell(30, 10, $row['telefone_cli'], 1, 0, 'C');
        $pdf->Cell(25, 10, $row['cpf_cli'], 1, 0, 'C');
        $pdf->Cell(20, 10, $row['cnh_cli'], 1, 1, 'C');
    }
} else {
    $pdf->Cell(190, 10, 'Nenhum cliente cadastrado.', 1, 1, 'C');
}

// ==============================================================================
// 8. GERAÇÃO FINAL DO ARQUIVO
// ==============================================================================
ob_end_clean(); 
$pdf->Output('I', 'Relatorio_Completo_A7Car.pdf');
?>