<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';
require '../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$mail = new PHPMailer(true);

try {

    $mail->isSMTP();
    $mail->Host       = $_ENV['SMTP_HOST'];
    $mail->SMTPAuth   = true;

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

    $mail->setFrom($_ENV['SMTP_FROM_EMAIL'], $_ENV['SMTP_FROM_NAME']);

    $mail->addAddress($email, $emailNome);


    $mail->isHTML(true);
    $mail->addEmbeddedImage('../../img/logo.png', 'logo_a7car');
    $logoSrc = 'cid:logo_a7car';
    $mail->Subject = $emailAssunto;
    
    $mail->Body    = '
<div style="margin: 0; padding: 0; background-color: #050505; font-family: Arial, Helvetica, sans-serif;">
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #050505; padding: 24px 12px;">
    <tr>
      <td align="center">
        
        
        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width: 600px; background-color: #0e0e0e; border: 1px solid #222222; border-radius: 6px; overflow: hidden;">
          
          
          <tr>
            <td align="center" style="background-color: #000000; padding: 28px 24px; border-bottom: 3px solid #e10600;">
              <img src="'.$logoSrc.'" alt="A7 CAR Multimarcas" width="220" style="display: block; max-width: 220px; width: 100%; height: auto; border: 0;">
            </td>
          </tr>

          
          <tr>
            <td style="padding: 36px 32px 28px 32px; color: #e5e5e5; text-align: left;">
              
              
              <div style="width: 56px; height: 4px; background-color: #e10600; margin-bottom: 18px;"></div>

              
              <h1 style="margin: 0 0 8px 0; font-size: 32px; font-weight: 800; color: #ffffff; line-height: 1.2;">
                Olá!
              </h1>
              <h2 style="margin: 0 0 24px 0; font-size: 22px; font-weight: 700; font-style: italic; color: #ffffff; line-height: 1.3;">
                '.$emailTitulo.' <span style="color: #e10600; font-style: normal;">Plataforma A7Car</span>
              </h2>

              
            
              
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin: 30px 0;">
                <tr>
                  <td align="center">
                    <a href="'.$emaiLink.'" style="display: inline-block; background-color: #c40812; border: 2px solid #ff2a2a; color: #ffffff; text-decoration: none; font-size: 15px; font-weight: bold; letter-spacing: 0.6px; text-transform: uppercase; padding: 15px 30px; border-radius: 8px; box-shadow: 0 0 18px rgba(225, 6, 0, 0.45);">
                      &#9993; &nbsp;|&nbsp; '.$emailTextoLink.'
                    </a>
                  </td>
                </tr>
              </table>

              
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin: 24px 0 20px 0;">
                <tr>
                  <td style="border-top: 1px solid #262626; font-size: 0; line-height: 0;">&nbsp;</td>
                </tr>
              </table>

              
              <p style="margin: 0 0 12px 0; font-size: 13px; color: #d4d4d8; text-align: center;">
                Ou copie e cole o link abaixo no seu navegador:
              </p>
              <div style="background-color: #161616; border: 1px solid #333333; border-radius: 8px; padding: 12px 16px; text-align: center; margin-bottom: 26px;">
                <a href="'.$emaiLink.'" style="color: #9ca3af; font-size: 13px; text-decoration: none; word-break: break-all;">
                  '.$emaiLink.'
                </a>
              </div>

              
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                  <td width="34" valign="top" style="padding-top: 2px;">
                    <div style="width: 22px; height: 22px; border: 2px solid #e10600; border-radius: 50%; color: #e10600; font-size: 14px; font-weight: bold; text-align: center; line-height: 22px;">
                      !
                    </div>
                  </td>
                  <td valign="middle" style="font-size: 13px; color: #a1a1aa; line-height: 1.5;">
                    Caso você não tenha realizado essa solicitação, pode ignorar este e-mail.
                  </td>
                </tr>
              </table>

            </td>
          </tr>

          
          <tr>
            <td align="center" style="background-color: #000000; padding: 26px 24px; border-top: 3px solid #e10600;">
              <img src="'.$logoSrc.'" alt="A7 CAR Multimarcas" width="130" style="display: block; max-width: 130px; width: 100%; height: auto; border: 0; margin-bottom: 12px;">
              
              <p style="margin: 0 0 14px 0; font-size: 11px; letter-spacing: 2px; color: #9ca3af; text-transform: uppercase;">
                SUA PRÓXIMA CONQUISTA SOBRE RODAS.
              </p>

              <p style="margin: 0; font-size: 12px; color: #71717a;">
                <a href="#" style="color: #a1a1aa; text-decoration: none; margin: 0 8px;">Instagram</a> |
                <a href="#" style="color: #a1a1aa; text-decoration: none; margin: 0 8px;">Facebook</a> |
                <a href="#" style="color: #a1a1aa; text-decoration: none; margin: 0 8px;">YouTube</a>
              </p>
            </td>
          </tr>

        </table>

      </td>
    </tr>
  </table>
</div>';

    $mail->AltBody = $emailAssunto . ' ' . $emaiLink;

    $mail->send();
    
} catch (Exception $e) {

}
/*
$email
$emailNome
$emailAssunto
$emailTitulo
$emailTextoLink
$emaiLink
*/
?>