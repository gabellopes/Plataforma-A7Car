<?php
ob_start();
date_default_timezone_set('America/Sao_Paulo');
require('../../../fpdf/fpdf.php'); 
require_once "../Conexao.php"; 
if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
    
   require_once "../../auth/authadm.php";

class PDF extends FPDF {
    function Header() {
        $this->Image('../../../img/logo.png', 10, 8, 33);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(45); 
        
        $titulo = mb_convert_encoding('Relatório da Equipe de Colaboradores', 'ISO-8859-1', 'UTF-8');
        $this->Cell(100, 10, $titulo, 0, 0, 'C');
        
        $this->SetFont('Arial', 'I', 9);
        $dataEmissao = mb_convert_encoding('Emitido em: ' . date('d/m/Y H:i'), 'ISO-8859-1', 'UTF-8');
        $this->Cell(0, 10, $dataEmissao, 0, 1, 'R');
        
        $this->Ln(15);
        
        $this->SetFont('Arial', 'B', 10); 
        $this->SetFillColor(255, 240, 200);
        
        $this->Cell(50, 10, 'Nome', 1, 0, 'C', true);
        $cargo = mb_convert_encoding('Serviço/Cargo', 'ISO-8859-1', 'UTF-8');
        $this->Cell(45, 10, $cargo, 1, 0, 'C', true);
        $this->Cell(35, 10, 'Telefone', 1, 0, 'C', true);
        $this->Cell(60, 10, 'E-mail', 1, 1, 'C', true); 
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
$pdf->SetFont('Arial', '', 9); 

$stmt = $sql->prepare("SELECT nome_col, servico_col, telefone_col, email_col FROM colaborador ORDER BY nome_col ASC");
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $nome = mb_convert_encoding($row['nome_col'], 'ISO-8859-1', 'UTF-8');
        $servico = mb_convert_encoding($row['servico_col'], 'ISO-8859-1', 'UTF-8');
        $email = mb_convert_encoding($row['email_col'], 'ISO-8859-1', 'UTF-8');
        
        $pdf->Cell(50, 10, $nome, 1, 0, 'L');
        $pdf->Cell(45, 10, $servico, 1, 0, 'C');
        $pdf->Cell(35, 10, $row['telefone_col'], 1, 0, 'C');
        $pdf->Cell(60, 10, $email, 1, 1, 'L');
    }
} else {
    $mensagem = mb_convert_encoding('Nenhum colaborador encontrado no banco de dados.', 'ISO-8859-1', 'UTF-8');
    $pdf->Cell(190, 10, $mensagem, 1, 1, 'C');
}

ob_end_clean(); 
$pdf->Output('I', 'Relatorio_Colaboradores.pdf');
?>