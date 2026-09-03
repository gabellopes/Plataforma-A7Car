<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php if (isset($_SESSION['erro_login'])): ?>
        <p style="color: red;">
            <?php
                echo $_SESSION['erro_login'];
                unset($_SESSION['erro_login']);
            ?>
        </p>
    <?php endif; ?>

    <form action="../salvar/Testelogin.php" method="post">
        <fieldset><label for="email">E-mail</label><input type="email" name="Email" id="email"  maxlength="20" required></fieldset>
        <fieldset><label for="senha">Senha</label> <input type="password" name="Senha" id="senha"  maxlength="20" required></fieldset>
        <fieldset><input type="submit" value="Entrar"></fieldset>
    </form>
    <a href="Cadastro.php">Não tem cadastro? Cadastrar</a>

</body>
</html>
