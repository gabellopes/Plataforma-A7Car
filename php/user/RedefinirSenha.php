<?php
SESSION_START(); 
require_once "../salvar/Conexao.php";
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
    <div id="cadastro">


    <form action="#" method="post">
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
   </div>

    <script src="../../js/mascaras.js"></script>
    <script src="../../js/validarformulario.js"></script>
    <script src="../../js/assets.js"></script>


</body>
</html>
