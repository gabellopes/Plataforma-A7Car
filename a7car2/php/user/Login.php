<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/principal.css">
    <link rel="stylesheet" href="../../css/login.css">
</head>
<body>


    <header id="cabecalho">
        
        <img src="../../img/logo.png" alt="" class="logo" onclick="window.location.href='../../index.php'">
        <div id="link">
            <a href="catalogo.php">CATÁLOGO</a>
            <a href="colaboradores.php">COLABORADORES</a>
            <a href="contato.php">CONTATO</a>
            <?php if(isset($_SESSION['user_email'])): ?>
                <a href="#">FAVORITOS</a>
            <?php endif; ?>
        </div>
        <div id="linksAuth">
            <?php if(!isset($_SESSION['user_email'])): ?>
            <button id="btnEntrar" class="btn" type="button" onclick="window.location.href='Login.php'">ENTRAR</button>
            <button id="btnCadastrar" class="btn" type="button" onclick="window.location.href='Cadastro.php'">CADASTRAR </button>
            <?php else: ?>
            <p>Bem-vindo, <?php echo $_SESSION['user_nome']; ?>!</p>
            <button class="btn" type="button" onclick="window.location.href='../salvar/Sair.php'">SAIR </button>
            <?php endif; ?>
        </div>

    </header>


    <div id="meio">
        <h3>Entre na sua conta</h3>
        <h1>LOGIN</h1>
    </div>

    <div class="mei">
    <div id="login">
        
    

    <form action="../salvar/Testelogin.php" method="post">
        <label for="email">E-mail</label>
        <input type="email" name="Email" id="Email" maxlength="20" required>

        <label for="senha">Senha</label>
        <input type="password" name="Senha" id="Senha" maxlength="20" required>
        <div style="color: red;"><?php if (isset($_SESSION['erro_login'])){echo $_SESSION['erro_login'];unset($_SESSION['erro_login']);} ?></div>

        <button type="submit" class="btn">ENTRAR</button>
        <input type="button" value="User" onclick="PreencherUser()">
        <input type="button" value="Admin" onclick="PreencherAdmin()">
    </form>
    <a href="Cadastro.php">Não tem cadastro? Cadastrar</a>

    <script>
        const Email = document.getElementById("Email");
        const Senha = document.getElementById("Senha");

        function PreencherUser(){

        Email.value = "gabriel.alves33@gmail.com";
        Senha.value = "G@br13l4lv3s33";
        }

        function PreencherAdmin(){

        Email.value = "admin@gmail.com";
        Senha.value = "Admin123!";
        }

    
    </script>
</body>
</html>
