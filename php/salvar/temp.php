<?php
require_once "funcoes.php";
require_once "Conexao.php";
header('Content-Type: application/json; charset=utf-8');

// 1. Valida se o método é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['sucesso' => false, 'mensagem' => 'Método inválido. Use POST.']);
    exit;
}

// 2. Lê corretamente o corpo da requisição enviada pelo Fetch API
$jsonBruto = file_get_contents('php://input');
$dados = json_decode($jsonBruto, true);

// 3. Valida se o JSON é válido e se o campo email foi enviado
if (json_last_error() !== JSON_ERROR_NONE || empty($dados['email'])) {
    http_response_code(400);
    echo json_encode(['sucesso' => false, 'mensagem' => 'E-mail não fornecido ou JSON inválido.']);
    exit;
}

$email = trim($dados['email']);

// Verifica se o e-mail existe na base de dados
$emailExiste = verifica("email_usu", "usuario", $email);

if ($emailExiste) {
    try {
        // CORRIGIDO: Usando $email (minúsculo) conforme recebido
        $id = pegarid("id_usu", "usuario", "email_usu", $email);
        $token = bin2hex(random_bytes(32));
        
        $link = "RedefinirSenha.php?token=" . $token; 
        $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $usado = 0; // Valor padrão para a coluna usado

        // CORRIGIDO: Adicionado o quarto parâmetro (?) para a coluna 'usado'
        $stmt = $sql->prepare("INSERT INTO password_resets (id_usu, token, expira_em, usado) VALUES (?, ?, ?, ?)");
        
        // CORRIGIDO: Tipos dos dados: i = inteiro (id, usado), s = string (token, expira) -> "issi"
        $stmt->bind_param("issi", $id, $token, $expira, $usado);
        $stmt->execute();

        // (Opcional para o TCC): Aqui você dispararia a função de envio de e-mail (ex: PHPMailer) enviando o $link

        echo json_encode([
            'sucesso' => true,
            'mensagem' => 'E-mail encontrado! Instruções de recuperação foram geradas.',
            'link' => $link
        ]);

    } catch (Exception $e) {
        http_response_code(500);
        // CORRIGIDO: 'sucesso' alterado para false no tratamento de erro
        echo json_encode([
            'sucesso' => false,
            'mensagem' => 'Erro interno ao gerar o token de recuperação.'
        ]);
    }

} else {
    echo json_encode([
        'sucesso' => false,
        'mensagem' => 'Este e-mail não está cadastrado.'
    ]);
}
exit;
?>