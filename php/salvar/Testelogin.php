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

$stmt = $sql->prepare("SELECT * FROM usuario WHERE email_usu = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $usuario = $resultado->fetch_assoc();

    if($usuario['status_usu'] === 1){
        if (password_verify($senha, $usuario['senha_usu'])) {
            $_SESSION['user_id'] = $usuario['id_usu'];
            $_SESSION['user_nome'] = $usuario['nome_usu'];
            $_SESSION['user_email'] = $usuario['email_usu'];
            
    
            if($usuario['role'] === 1){
                $_SESSION['user_role'] = 1;
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                header("Location: ../admin/Clientes.php");
                exit;
            }else{
                $_SESSION['user_role'] = 0;
                header("Location: ../user/catalogo.php");
                exit;
            } 
        }else{
            $_SESSION['erro_login'] = 'E-mail ou senha inválidos.';
            header("Location: ../user/Login.php");
            exit;
            }
    }else{
        $_SESSION['erro_login'] = 'Usuario não validado.';
        header("Location: ../user/Login.php");
        exit;
    }
}else{
    $_SESSION['erro_login'] = 'Usuario não cadastrado';
    header("Location: ../user/Login.php");
    exit;
}


?>
