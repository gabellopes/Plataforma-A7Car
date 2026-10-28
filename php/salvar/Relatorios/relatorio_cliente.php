<?php
ob_start();
date_default_timezone_set('America/Sao_Paulo');
require('../../../fpdf/fpdf.php'); 
require_once "../Conexao.php"; 

class PDF extends FPDF {
    function Header() {
        $this->Image('../../../img/logo.png', 10, 8, 33);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(45); 
        
        $titulo = mb_convert_encoding('Relatório de Clientes Cadastrados', 'ISO-8859-1', 'UTF-8');
        $this->Cell(100, 10, $titulo, 0, 0, 'C');
        
        $this->SetFont('Arial', 'I', 9);
        $dataEmissao = mb_convert_encoding('Emitido em: ' . date('d/m/Y H:i'), 'ISO-8859-1', 'UTF-8');
        $this->Cell(0, 10, $dataEmissao, 0, 1, 'R');
        
        $this->Ln(15);
        
        // Cabeçalho da Tabela
        $this->SetFont('Arial', 'B', 10); // Fonte 10 para caber todas as colunas
        $this->SetFillColor(230, 240, 255); 
        
        // As larguras somam exatos 190mm
        $this->Cell(60, 10, 'Nome', 1, 0, 'C', true);
        $this->Cell(55, 10, 'E-mail', 1, 0, 'C', true);
        $this->Cell(30, 10, 'Telefone', 1, 0, 'C', true);
        $this->Cell(25, 10, 'CPF', 1, 0, 'C', true);
        $this->Cell(20, 10, 'CNH', 1, 1, 'C', true); // '1' no final quebra a linha
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
// Fonte 9 para os dados, garantindo que e-mails muito longos não quebrem o layout da tabela
$pdf->SetFont('Arial', '', 9); 

// Consulta atualizada com os nomes corretos das colunas e da tabela
$stmt = $sql->prepare("SELECT nome_cli, email_cli, telefone_cli, cpf_cli, cnh_cli FROM cliente ORDER BY nome_cli ASC");
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $nome = mb_convert_encoding($row['nome_cli'], 'ISO-8859-1', 'UTF-8');
        $email = mb_convert_encoding($row['email_cli'], 'ISO-8859-1', 'UTF-8');
        
        // Preenche as células com os dados exatos do seu banco
        $pdf->Cell(60, 10, $nome, 1, 0, 'L');
        $pdf->Cell(55, 10, $email, 1, 0, 'L');
        $pdf->Cell(30, 10, $row['telefone_cli'], 1, 0, 'C');
        $pdf->Cell(25, 10, $row['cpf_cli'], 1, 0, 'C');
        $pdf->Cell(20, 10, $row['cnh_cli'], 1, 1, 'C');
    }
} else {
    $mensagem = mb_convert_encoding('Nenhum cliente encontrado no banco de dados.', 'ISO-8859-1', 'UTF-8');
    $pdf->Cell(190, 10, $mensagem, 1, 1, 'C');
}

ob_end_clean(); 
$pdf->Output('I', 'Relatorio_Clientes.pdf');
?>