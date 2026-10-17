<?php
require_once "../Conexao.php";
require_once "../funcoes.php";
/*MODIFICAR QUANDO PUBLICAR - Não tem a validação do link, apenas na tela redefinirSenha*/
if (session_status() !== PHP_SESSION_ACTIVE) {
    SESSION_START(); 
}



if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['erro_cadastro'] = 'Método inválido.';
    header("Location: ../user/Login.php");
    exit;
}

$token = $_POST['token'] ?? '';
$dataAtual =  time();

try{
$stmt = $sql->prepare("SELECT * FROM password_resets WHERE token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    $password_resets = $result->fetch_assoc();
    $dataExpira = strtotime($password_resets['expira_em']);
    if($password_resets['usado'] === 0){
        if($dataExpira > $dataAtual){


            $Senha = $_POST['Senha'] ?? '';
            $Confirmar_Senha = $_POST['Confirmar_Senha'] ?? '';
            $link1 = "Location: ../../user/RedefinirSenha.php?id =" . $id;


            if (empty($Senha) || empty($Confirmar_Senha)) {
                $_SESSION['erro_cadastro'] = 'Preencha todos os campos.';
                $_SESSION['erro'] = true;
                header($link1);
                exit;
            }


            if ($Senha !== $Confirmar_Senha) {
                $_SESSION['erro_cadastro'] = 'As senhas não conferem.';
                $_SESSION['erro'] = true;
                header($link1);
                exit;
            }

            if (strlen($Senha) < 8) {
                $_SESSION['erro_cadastro'] = "A senha deve ter pelo menos 8 caracteres.";
                $_SESSION['erro'] = true;
                header($link1);
                exit;
            }

            if (!preg_match('/[A-Z]/', $Senha)) {
                $_SESSION['erro_cadastro'] = "A senha deve conter pelo menos uma letra maiúscula.";
                $_SESSION['erro'] = true;
                header($link1);
                exit;
            }

            if (!preg_match('/[a-z]/', $Senha)) {
                $_SESSION['erro_cadastro'] = "A senha deve conter pelo menos uma letra minúscula.";
                $_SESSION['erro'] = true;
                header($link1);
                exit;
            }

            if (!preg_match('/[0-9]/', $Senha)) {
                $_SESSION['erro_cadastro'] = "A senha deve conter pelo menos um número.";
                $_SESSION['erro'] = true;
                header($link1);
                exit;
            }

            if (!preg_match('/[\W_]/', $Senha)) {
                $_SESSION['erro_cadastro'] = "A senha deve conter pelo menos um caractere especial (ex: @, #, $, !).";
                $_SESSION['erro'] = true;
                header($link1);
                exit;
            }
            $senhaHash = password_hash($Senha, PASSWORD_DEFAULT);

            try{
            $id = pegarid("id_usu", "password_resets", "token", $token);
            $stmt = $sql->prepare("UPDATE usuario SET senha_usu = ? WHERE id_usu = ?");
            $stmt->bind_param("si", $senhaHash, $id);
            $stmt->execute();

            $stmt = $sql->prepare("UPDATE password_resets SET usado = 1 WHERE id_usu = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $_SESSION['sucesso_cadastro'] = 'Senha alterada com sucesso!';
            $_SESSION['erro'] = false;
            header("Location: ../../user/Login.php");

            exit;
            }catch(Exception $e){
                            $_SESSION['erro_cadastro'] = "Erro ao tentar alterar senha" . " " . $e->getMessage() ;
                            $_SESSION['erro'] = true;
                            header($link1);
            }
}else{
            $_SESSION['erro_cadastro'] = "Link Expirado⏰";
            $_SESSION['erro'] = true;
            header("Location: ../../user/Login.php");
       }
    }else{
        $_SESSION['erro_cadastro'] = "Este link já foi Usado👀";
        $_SESSION['erro'] = true;
        header("Location: ../../user/Login.php");
    }
}else{
    $_SESSION['erro_cadastro'] = "Link Invalido😢🚗";
    $_SESSION['erro'] = true;
    header("Location: ../../user/Login.php");
    }
}catch(Exception $e){
    $_SESSION['erro_cadastro'] = "⛔Erro no sistema, tente novamente mais tarde. 🚧🚚";
    $_SESSION['erro'] = true;
    header("Location: ../../user/Login.php");
}
?>