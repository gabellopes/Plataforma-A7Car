<?php
include __DIR__ . "/Conexao.php";
$cpf = isset($_GET['cpf']) ? $_GET['cpf'] : '';

if (empty($cpf)) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'CPF não informado.']);
    exit;
}

try {
   
    $stmt = $sql->prepare("SELECT nome_cli, telefone_cli FROM cliente WHERE cpf_cli = ?");
    $stmt->bind_param("i", $cpf);
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

} catch (PDOException $e) {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Erro no servidor: ' . $e->getMessage()
    ]);
}
?>