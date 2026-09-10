<?php
session_start();
include __DIR__ . "/Conexao.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['erro_login'] = 'Acesso inválido.';
    header("Location: ../user/Login.php");
    exit;
}

// 1. Recebe os dados do formulário de login
$email = trim($_POST['Email'] ?? '');
$senha = $_POST['Senha'] ?? '';

// 2. Valida se os campos foram preenchidos
if (empty($email) || empty($senha)) {
    $_SESSION['erro_login'] = 'Preencha e-mail e senha.';
    header("Location: ../user/Login.php");
    exit;
}

// 3. Busca o usuário pelo e-mail
$stmt = $sql->prepare("SELECT id_usu, nome_usu, email_usu, senha_usu FROM usuario WHERE email_usu = ?");
if (!$stmt) {
    $_SESSION['erro_login'] = 'Erro ao consultar o banco.';
    header("Location: ../user/Login.php");
    exit;
}

$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();

// 4. Verifica se encontrou algum usuário
if ($resultado->num_rows === 1) {
    $usuario = $resultado->fetch_assoc();

    // 5. Compara a senha digitada com a senha criptografada
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

// 6. Se falhou, volta para a tela de login
$_SESSION['erro_login'] = 'E-mail ou senha inválidos.';
header("Location: ../user/Login.php");
exit;
?>
