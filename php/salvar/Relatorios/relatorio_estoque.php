<?php
ob_start();
date_default_timezone_set('America/Sao_Paulo'); // Garante o fuso horário correto
require('../../../fpdf/fpdf.php'); 
require_once "../Conexao.php"; 

class PDF extends FPDF {
    function Header() {
        $this->Image('../../../img/logo.png', 10, 8, 33);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(45); 
        
        $titulo = mb_convert_encoding('Relatório de Estoque', 'ISO-8859-1', 'UTF-8');
        $this->Cell(70, 10, $titulo, 0, 0, 'C');
        
        // Data de emissão no topo à direita
        $this->SetFont('Arial', 'I', 9);
        $dataEmissao = mb_convert_encoding('Emitido em: ' . date('d/m/Y H:i'), 'ISO-8859-1', 'UTF-8');
        $this->Cell(0, 10, $dataEmissao, 0, 1, 'R');
        
        $this->Ln(15);
        
        $this->SetFont('Arial', 'B', 11);
        $this->SetFillColor(200, 220, 255); 
        $this->Cell(45, 10, 'Marca', 1, 0, 'C', true);
        $this->Cell(65, 10, 'Modelo', 1, 0, 'C', true);
        $this->Cell(30, 10, 'Ano', 1, 0, 'C', true);
        $preco = mb_convert_encoding('Preço (R$)', 'ISO-8859-1', 'UTF-8');
        $this->Cell(50, 10, $preco, 1, 1, 'C', true);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $pagina = mb_convert_encoding('Página ', 'ISO-8859-1', 'UTF-8');
        $this->Cell(0, 10, $pagina.$this->PageNo().'/{nb}', 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 11);

$stmt = $sql->prepare("SELECT marca_car, modelo_car, ano_car, preco_car FROM carro WHERE status_car = 0");
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $marca = mb_convert_encoding($row['marca_car'], 'ISO-8859-1', 'UTF-8');
        $modelo = mb_convert_encoding($row['modelo_car'], 'ISO-8859-1', 'UTF-8');
        $pdf->Cell(45, 10, $marca, 1, 0, 'C');
        $pdf->Cell(65, 10, $modelo, 1, 0, 'L');
        $pdf->Cell(30, 10, $row['ano_car'], 1, 0, 'C');
        $pdf->Cell(50, 10, number_format($row['preco_car'], 2, ',', '.'), 1, 1, 'R');
    }
} else {
    $mensagem = mb_convert_encoding('Nenhum veículo disponível no estoque no momento.', 'ISO-8859-1', 'UTF-8');
    $pdf->Cell(190, 10, $mensagem, 1, 1, 'C');
}

ob_end_clean(); 
$pdf->Output('I', 'Relatorio_Estoque.pdf');
?>