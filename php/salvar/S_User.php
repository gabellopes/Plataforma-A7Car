<?php
session_start();
include __DIR__ . "/Conexao.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['erro_cadastro'] = 'Método inválido.';
    header("Location: ../user/Cadastro.php");
    exit;
}

// 1. Recebe os dados do formulário
$Nome = trim($_POST['Nome'] ?? '');
$Email = trim($_POST['Email'] ?? '');
$Telefone = trim($_POST['Telefone'] ?? '');
$Senha = $_POST['Senha'] ?? '';
$Confirmar_Senha = $_POST['Confirmar_Senha'] ?? '';



// 2. Valida campos vazios e confirmação da senha
if (empty($Nome) || empty($Email) || empty($Telefone) || empty($Senha) || empty($Confirmar_Senha)) {
    $_SESSION['erro_cadastro'] = 'Preencha todos os campos.';
    $_SESSION['erro'] = true;
    header("Location: ../user/Cadastro.php");
    exit;
}


if ($Senha !== $Confirmar_Senha) {
    $_SESSION['erro_cadastro'] = 'As senhas não conferem.';
    $_SESSION['erro'] = true;
    header("Location: ../user/Cadastro.php");
    exit;
}

if (strlen($Senha) < 8) {
    $_SESSION['erro_cadastro'] = "A senha deve ter pelo menos 8 caracteres.";
    $_SESSION['erro'] = true;
    header("Location: ../user/Cadastro.php");
    exit;
}

// 2. Verifica se tem letra maiúscula
if (!preg_match('/[A-Z]/', $Senha)) {
    $_SESSION['erro_cadastro'] = "A senha deve conter pelo menos uma letra maiúscula.";
    $_SESSION['erro'] = true;
    header("Location: ../user/Cadastro.php");
    exit;
}

// 3. Verifica se tem letra minúscula
if (!preg_match('/[a-z]/', $Senha)) {
    $_SESSION['erro_cadastro'] = "A senha deve conter pelo menos uma letra minúscula.";
    $_SESSION['erro'] = true;
    header("Location: ../user/Cadastro.php");
    exit;
}

// 4. Verifica se tem número
if (!preg_match('/[0-9]/', $Senha)) {
    $_SESSION['erro_cadastro'] = "A senha deve conter pelo menos um número.";
    $_SESSION['erro'] = true;
    header("Location: ../user/Cadastro.php");
    exit;
}

// 5. Verifica se tem caractere especial (@, #, $, etc.)
if (!preg_match('/[\W_]/', $Senha)) {
    $_SESSION['erro_cadastro'] = "A senha deve conter pelo menos um caractere especial (ex: @, #, $, !).";
    $_SESSION['erro'] = true;
    header("Location: ../user/Cadastro.php");
    exit;
}
$dominio = substr(strrchr($Email, "@"), 1);

if (!checkdnsrr($dominio, "MX")) {
    header("O domínio do e-mail não existe.");
    $_SESSION['erro'] = true;
    exit;
}
$verificaEmail = $sql->prepare("SELECT id_usu FROM usuario WHERE email_usu = ?");
$verificaEmail->bind_param("s", $Email);
$verificaEmail->execute();
$resultadoEmail = $verificaEmail->get_result();

if ($resultadoEmail->num_rows > 0) {
    $_SESSION['erro_cadastro'] = 'Este e-mail já está cadastrado.';
    $_SESSION['erro'] = true;
    header("Location: ../user/Cadastro.php");
    exit;
}

// 3. Criptografa a senha antes de salvar no banco
$senhaHash = password_hash($Senha, PASSWORD_DEFAULT);

// 4. Insere o usuário no banco
$stmt = $sql->prepare("INSERT INTO usuario (nome_usu, email_usu, telefone_usu, senha_usu) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $Nome, $Email, $Telefone, $senhaHash);
$stmt->execute();

$_SESSION['sucesso_cadastro'] = 'Cadastro realizado com sucesso!';
$_SESSION['erro'] = false;
header("Location: ../user/Login.php");
exit;

/* 
function responderJson(array $dados, int $statusCode = 200): void
{
    // Define o código HTTP da resposta
    http_response_code($statusCode);

    // Converte o array PHP para JSON
    echo json_encode(
        $dados,
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );

    // Encerra o script para evitar qualquer conteúdo depois do JSON
    exit;
}
function Formulario(){
    responderJson([
        'sucesso' => true,
    

        'Nome' => trim($_POST['Nome'] ?? ''),
        'Email' => trim($_POST['Email'] ?? ''),
        'Telefone' => trim($_POST['Telefone'] ?? ''),
        'Senha' => $_POST['Senha'] ?? '',
        'Confirmar_Senha' => $_POST['Confirmar_Senha'] ?? '',
        'Erro' => $_SESSION['erro'],

    ]);
}
*/
?>