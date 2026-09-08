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
        </div>
        <div id="linksAuth">
            <button id="btnEntrar" class="btn" type="button" onclick="window.location.href='Login.php'">ENTRAR</button>
            <button class="btn" type="button" onclick="window.location.href='Cadastro.php'">CADASTRAR </button>
        </div>

    </header>


    <div id="meio">
        <h3>Entre na sua conta</h3>
        <h1>LOGIN</h1>
    </div>

    <div class="mei">
    <div id="login">
        
    <?php if (isset($_SESSION['erro_login'])): ?>
        <p style="color: red;">
            <?php
                echo $_SESSION['erro_login'];
                unset($_SESSION['erro_login']);
            ?>
        </p>
    <?php endif; ?>

    <form action="../salvar/Testelogin.php" method="post">
        <fieldset><label for="email">E-mail</label><input type="email" name="Email" id="Email"  maxlength="20" required></fieldset>
        <fieldset><label for="senha">Senha</label> <input type="password" name="Senha" id="Senha"  maxlength="20" required></fieldset>
        <fieldset><input type="submit" value="Entrar"></fieldset>
        <fieldset><input type="button" value="User" onclick="PreencherUser()"><input type="button" value="Admin" onclick="PreencherAdmin()"></fieldset>
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
