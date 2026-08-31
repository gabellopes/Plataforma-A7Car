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
    <?php if (isset($_SESSION['erro_cadastro'])): ?>
        <p style="color: red;">
            <?php
                echo $_SESSION['erro_cadastro'];
                unset($_SESSION['erro_cadastro']);
            ?>
        </p>
    <?php endif; ?>

    <form action="../salvar/S_User.php" method="post">
        <fieldset><label for="nome">Nome Completo</label><input type="text" name="Nome" id="nome" required></fieldset>
        <fieldset><label for="email">E-mail</label><input type="email" name="Email" id="email" required></fieldset>
        <fieldset><label for="telefone">Telefone</label><input type="tel" name="Telefone" id="telefone" required></fieldset>
        <fieldset><label for="senha">Senha</label> <input type="password" name="Senha" id="senha" required></fieldset>
        <fieldset><label for="confirmar-senha">Confirmar Senha</label> <input type="password" name="Confirmar_Senha" id="confirmar-senha" required></fieldset>
        <fieldset><input type="submit" value="Cadastrar"></fieldset>
    </form>
   <a href="Login.php">Já tem cadastro? Logar</a>
</body>
</html>