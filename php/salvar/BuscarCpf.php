<?php
include __DIR__ . "/Conexao.php";

header('Content-Type: application/json; charset=utf-8');

$cpf = isset($_GET['Cpf']) ? $_GET['Cpf'] : '';


try {
   
    $stmt = $sql->prepare("SELECT nome_cli, telefone_cli FROM cliente WHERE cpf_cli = ?");
    $stmt->bind_param("s", $cpf);
    $stmt->execute();
    $result = $stmt->get_result();
    $cliente = $result->fetch_assoc();

    if ($cliente) {
        echo json_encode([
            'sucesso' => true,
            'nome' => $cliente['nome_cli'],
            'telefone' => $cliente['telefone_cli']
        ]);
    } else {
        echo json_encode([
            'sucesso' => false,
            'mensagem' => 'CPF não encontrado no banco de dados.'
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Erro no servidor: ' . $e->getMessage()
    ]);
}
?>