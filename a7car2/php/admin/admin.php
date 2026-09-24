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

        <label for="email">E-mail</label><input type="email" name="Email" id="email" required>
        <label for="senha">Senha</label> <input type="password" name="Senha" id="senha" required>
        <button type="submit">Entrar</button>

        </form>
        <br>
        <a href="Cadastro.php">Não tem cadastro? Cadastrar</a>

    </div>