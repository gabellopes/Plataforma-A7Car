<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuario</title>
    <link rel="icon" type="image/svg" href="../../img/teste.svg">
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
      
        <fieldset><label for="nome">Nome Completo</label><input type="text" name="Nome" id="Nome" maxlength="255" required></fieldset>
        <fieldset><label for="email">E-mail</label><input type="email" name="Email" id="Email" maxlength="255" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" required></fieldset>
        <fieldset><label for="telefone">Telefone</label><input type="tel" name="Telefone" id="Telefone" maxlength="15" pattern="\([0-9]{2}\)\s?[0-9]{4,5}-[0-9]{4}"  required></fieldset>
        <fieldset><label for="senha">Senha</label> <input type="password" name="Senha" id="Senha" maxlength="20" required></fieldset>
        <fieldset><label for="confirmar-senha">Confirmar Senha</label> <input type="password" name="Confirmar_Senha" id="Confirmar-senha" maxlength="20" required></fieldset>
        <div id="Mensagem"></div>
        <fieldset><input  onclick="validarCadastro()" type="button" value="Cadastrar" id="Cadastrar"></fieldset>
        <!--<fieldset><input type="button" value="Preencher" onclick="preencher()"></fieldset>-->
    </form>
   <a href="Login.php">Já tem cadastro? Logar</a>
   <script src="../../js/verificacadastro.js"></script>
<script src="../../js/telefone.js"></script>
</body>

   
</html>