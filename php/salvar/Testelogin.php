<?php
session_start();
include __DIR__ . "/Conexao.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['erro_login'] = 'Acesso inválido.';
    header("Location: ../user/Login.php");
    exit;
}

$email = trim($_POST['Email'] ?? '');
$senha = $_POST['Senha'] ?? '';

if (empty($email) || empty($senha)) {
    $_SESSION['erro_login'] = 'Preencha e-mail e senha.';
    header("Location: ../user/Login.php");
    exit;
}

$stmt = $sql->prepare("SELECT id_usu, nome_usu, email_usu, senha_usu FROM usuario WHERE email_usu = ?");
if (!$stmt) {
    $_SESSION['erro_login'] = 'Erro ao consultar o banco.';
    header("Location: ../user/Login.php");
    exit;
}

$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $usuario = $resultado->fetch_assoc();

    if (password_verify($senha, $usuario['senha_usu'])) {
        $_SESSION['user_id'] = $usuario['id_usu'];
        $_SESSION['user_nome'] = $usuario['nome_usu'];
        $_SESSION['user_email'] = $usuario['email_usu'];
        

        if($_SESSION['user_email'] === 'admin@gmail.com'){
            header("Location: ../admin/Clientes.php");
            exit;
        }else{
            header("Location: ../user/catalogo.php");
            exit;
        }
        

        
    }
}

$_SESSION['erro_login'] = 'E-mail ou senha inválidos.';
header("Location: ../user/Login.php");
exit;
?>
