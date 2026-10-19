<?php
require_once "funcoes.php";
require_once "Conexao.php";
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['sucesso' => false, 'mensagem' => 'Método inválido. Use POST.']);
    exit;
}

$jsonBruto = file_get_contents('php://input');
$dados = json_decode($jsonBruto, true);

if (json_last_error() !== JSON_ERROR_NONE || empty($dados['email'])) {
    http_response_code(400);
    echo json_encode(['sucesso' => false, 'mensagem' => 'E-mail não fornecido ou JSON inválido.']);
    exit;
}

$email = trim($dados['email']);
$modoDev = $dados['modoDev'];

$emailExiste = verifica("email_usu", "usuario", $email);

if ($emailExiste) {
    try {
        $id = pegarid("id_usu", "usuario", "email_usu", $email);
        $nome = pegarid("nome_usu", "usuario", "email_usu", $email);
        $token = bin2hex(random_bytes(32));
        /*MODIFICAR QUANDO PUBLICAR*/
        $link = "http://localhost/Plataforma-A7Car/php/user/RedefinirSenha.php?token=" . $token; 
        $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $usado = 0; 

        $stmt = $sql->prepare("INSERT INTO password_resets (id_usu, token, expira_em, usado) VALUES (?, ?, ?, ?)");
        
        $stmt->bind_param("issi", $id, $token, $expira, $usado);
        $stmt->execute();
        
        if($modoDev === false){
            require_once "enviar_email.php";
        }
        


        echo json_encode([
            'sucesso' => true,
            'mensagem' => 'E-mail encontrado! Instruções de recuperação foram geradas.',
            'link' => $link,
            'modoDev' => $modoDev
        ]);

    } catch (Exception $e) {
        http_response_code(500);
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