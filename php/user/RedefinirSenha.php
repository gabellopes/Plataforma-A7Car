<?php
SESSION_START(); 
require_once "../salvar/Conexao.php";

if(isset($_SESSION['erro_cadastro'])){
            $Mensagem = $_SESSION['erro_cadastro'];
            echo "<script>alert('" . htmlspecialchars($Mensagem, ENT_QUOTES, 'UTF-8') . "');</script>"; 
            unset($_SESSION['erro_cadastro']);
        }

$token = $_GET['token'];
$dataAtual =  time();






/*CREATE TABLE IF NOT EXISTS password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usu INT NOT NULL,
    token VARCHAR(255) NOT NULL,
    expira_em DATETIME NOT NULL,
    usado TINYINT(1) NOT NULL DEFAULT 0,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_reset_usuario FOREIGN KEY (id_usu) REFERENCES usuario(id_usu) ON DELETE CASCADE
); */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha</title>
    <link rel="stylesheet" href="../../css/principal.css">
    <link rel="stylesheet" href="../../css/cadastro.css">
    
</head>
<body>


<header id="cabecalho">
        <img src="../../img/logo.png" alt="" class="logo" onclick="window.location.href='../../index.php'">
       

    </header>

    <div id="meio">
        <h3>Crie uma nova senha para sua conta.</h3>
        <h1>Redefinição de Senha</h1>
    </div>
<div class="mei">
<?php
try{$stmt = $sql->prepare("SELECT * FROM password_resets WHERE token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();




if($result->num_rows > 0){
    $password_resets = $result->fetch_assoc();
    $dataExpira = strtotime($password_resets['expira_em']);
    if($password_resets['usado'] === 0){
        if($dataExpira > $dataAtual){
        
 

?>
    
    <div id="cadastro">


    <form action="../salvar/Atualizar/AtualizarSenha.php" method="post">
        <input id="tipoCadastro" type="text" value="redefinirSenha" hidden>
        <label for="senha">Senha</label>
        <div><input type="password" name="Senha" id="Senha" maxlength="20" required><button type="button" data-target="Senha" id="mostrarSenha">👁</button></div>
        
        <label for="confirmar-senha">Confirmar Senha</label>
        <div><input type="password" name="Confirmar_Senha" id="Confirmar-senha" maxlength="20" required><button type="button" data-target="senha" id="mostrarConfirmarSenha">👁</button></div>
        <div id="Mensagem_senha"></div>
        <div style="color: red;"><?php if (isset($_SESSION['erro_cadastro'])){echo htmlspecialchars($_SESSION['erro_cadastro'], ENT_QUOTES, 'UTF-8');unset($_SESSION['erro_cadastro']);} ?></div>
        <br>

        <button type="button" id="Cadastrar">Alterar senha</button>
    </form>

    
<br>
   </div>

<?php
       }
    }
}else{
?>
<h1 >Link Invalido😢🚗</h1>
<?php

}}catch(Exception $e){

?>
<h1>⛔Erro no sistema, tente novamente mais tarde. 🚧🚚</h1>
<?php
}
?>
   </div>

    <script src="../../js/mascaras.js"></script>
    <script src="../../js/validarformulario.js"></script>
    <script src="../../js/assets.js"></script>


</body>
</html>
