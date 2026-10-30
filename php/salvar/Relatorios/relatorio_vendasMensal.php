<?php
ob_start();
date_default_timezone_set('America/Sao_Paulo');
require('../../../fpdf/fpdf.php'); 
require_once "../Conexao.php";
if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
    
require_once "../../auth/authadm.php";

if (empty($_POST['mes_ano'])) { die("Selecione um mês válido."); }
$partes = explode('-',$_POST['mes_ano']);
$mes =$partes[0];
$ano =$partes[1];

class PDF extends FPDF {
    public $tituloCabecalho;
    function Header() {
        $this->Image('../../../img/logo.png', 10, 8, 33);
        $this->SetFont('Arial', 'B', 15);$this->Cell(45); 
        $titulo = mb_convert_encoding($this->tituloCabecalho, 'ISO-8859-1', 'UTF-8');
        $this->Cell(90, 10,$titulo, 0, 0, 'C');
        
        $this->SetFont('Arial', 'I', 9);$dataEmissao = mb_convert_encoding('Emitido em: ' . date('d/m/Y H:i'), 'ISO-8859-1', 'UTF-8');
        $this->Cell(0, 10, $dataEmissao, 0, 1, 'R');$this->Ln(15);
        
        // Cabeçalho da Tabela - Total: 190mm (65 + 60 + 35 + 30)
        $this->SetFont('Arial', 'B', 10); 
        $this->SetFillColor(200, 255, 200);$veiculo = mb_convert_encoding('Veículo (Marca/Modelo)', 'ISO-8859-1', 'UTF-8');
        $this->Cell(65, 10, $veiculo, 1, 0, 'C', true);$this->Cell(60, 10, 'Cliente', 1, 0, 'C', true);
        $this->Cell(35, 10, 'CPF', 1, 0, 'C', true);$preco = mb_convert_encoding('Valor (R$)', 'ISO-8859-1', 'UTF-8');
        $this->Cell(30, 10,$preco, 1, 1, 'C', true);
    }
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);$pagina = mb_convert_encoding('Página ', 'ISO-8859-1', 'UTF-8');
        $this->Cell(0, 10, $pagina.$this->PageNo().'/{nb}', 0, 0, 'C');
    }
}

$pdf = new PDF();$pdf->tituloCabecalho = 'Relatório Mensal de Vendas - ' . str_pad($mes, 2, '0', STR_PAD_LEFT) . '/' .$ano;
$pdf->AliasNbPages();$pdf->AddPage();
// Aumentamos a fonte dos dados para 9, já que temos mais espaço
$pdf->SetFont('Arial', '', 9);

// Consulta trazendo apenas o CPF do cliente
$sqlBusca = "SELECT c.marca_car, c.modelo_car, cli.nome_cli, cli.cpf_cli, v.valor_ven 
             FROM vendas v
             INNER JOIN carro c ON v.id_car = c.id_car
             INNER JOIN cliente cli ON v.id_cli = cli.id_cli
             WHERE MONTH(v.data_ven) = ? AND YEAR(v.data_ven) = ?";
             
$stmt = $sql->prepare($sqlBusca);
$stmt->bind_param("ii", $mes, $ano);$stmt->execute();
$result =$stmt->get_result();

$totalVendas = 0;
$qtdCarros = 0; 

while ($row =$result->fetch_assoc()) {
    $veiculoInfo = mb_convert_encoding($row['marca_car'] . ' ' . $row['modelo_car'], 'ISO-8859-1', 'UTF-8');$clienteNome = mb_convert_encoding($row['nome_cli'], 'ISO-8859-1', 'UTF-8');$pdf->Cell(65, 10, $veiculoInfo, 1, 0, 'L');$pdf->Cell(60, 10, $clienteNome, 1, 0, 'L');$pdf->Cell(35, 10, $row['cpf_cli'], 1, 0, 'C');$pdf->Cell(30, 10, number_format($row['valor_ven'], 2, ',', '.'), 1, 1, 'R');$totalVendas += $row['valor_ven'];$qtdCarros++;
}

$pdf->SetFont('Arial', 'B', 10);$pdf->SetFillColor(230, 230, 230);

$textoTotal = 'TOTAL DO MÊS (' . $qtdCarros . ' veículos):';
// A largura somada das 3 primeiras colunas é 160 (65 + 60 + 35)
$pdf->Cell(160, 10, mb_convert_encoding($textoTotal, 'ISO-8859-1', 'UTF-8'), 1, 0, 'R', true);
$pdf->Cell(30, 10, number_format($totalVendas, 2, ',', '.'), 1, 1, 'R', true);

ob_end_clean(); 
$pdf->Output('I', 'Relatorio_Mensal.pdf');
?>