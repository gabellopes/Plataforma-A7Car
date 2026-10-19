<?php
// 1. Declarar o uso dos namespaces do PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 2. Importar os arquivos essenciais manualmente
require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';
require '../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// 3. Instanciar a classe
$mail = new PHPMailer(true);

try {
    // ------------------------------------------------------
    // Configurações do Servidor SMTP (Brevo)
    // ------------------------------------------------------
    $mail->isSMTP();
    $mail->Host       = $_ENV['SMTP_HOST'];
    $mail->SMTPAuth   = true;

    // ATENÇÃO: Preencha com os seus dados do Brevo
    $mail->Username   = $_ENV['SMTP_USER'];
    $mail->Password   = $_ENV['SMTP_PASS'];

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = $_ENV['SMTP_PORT'];
    $mail->CharSet    = 'UTF-8';
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    // ------------------------------------------------------
    // Remetente e Destinatário
    // ------------------------------------------------------
    // O email do 'setFrom' DEVE ser o mesmo que você verificou no Brevo
    $mail->setFrom($_ENV['SMTP_FROM_EMAIL'], $_ENV['SMTP_FROM_NAME']);

    // O email que vai receber a mensagem
    $mail->addAddress($email, $nome);

    // ------------------------------------------------------
    // Conteúdo do Email
    // ------------------------------------------------------
    $mail->isHTML(true);
    $mail->Subject = 'ModoDevAtivado';

    $mail->Body    = '
        <div style="background-color: #f4f4f4; padding: 20px; font-family: Arial, sans-serif;">
            <h2 style="color: #333;">Olá! Tudo certo!</h2>

            <a href='.$link.'>clique nesse link para redefinir a senha</a>
            <p>Se você está lendo isso, a instalação <b>manual</b> do PHPMailer funcionou perfeitamente e o SMTP do Brevo fez o disparo.</p>
            
        </div>
    ';

    $mail->AltBody = 'Olá! Se você está lendo isso, a instalação manual do PHPMailer funcionou perfeitamente.';

    // Enviar!
    $mail->send();
    
} catch (Exception $e) {
    
}
?>