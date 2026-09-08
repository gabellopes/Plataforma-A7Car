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
        <fieldset><label for="email">E-mail</label><input type="email" name="Email" id="email" required></fieldset>
        <fieldset><label for="senha">Senha</label> <input type="password" name="Senha" id="senha" required></fieldset>
        <fieldset><button type="submit">Entrar</button></fieldset>
    </form>
    <a href="Cadastro.php">Não tem cadastro? Cadastrar</a>

    </div>
    </div>



        <footer>

        <div class="fo">
            <div id="ter">
                <img src="../../img/logo.png" alt="" id="logo">
                <h3>Multimarcas premium especializada em venda </h3>
                <h3>e compra de veículos.Transparência, qualidade </h3>
                <h3>e atendimento diferenciado.</h3>
            </div>
            <div class="nav">
                <h1>NAVEGAÇÃO</h1>
                <a href="catalogo.php">CATÁLOGO</a>
                <a href="colaboradores.php">COLABORADORES</a>
                <a href="contato.php">CONTATO</a>
            </div>
            <div>
                <h1>CONTATO</h1>
                <h3>numero telefone
                    <br>
                    email
                    <br>
                    endereço
                </h3>
            </div>
            <div id="divadm">
               <a href="../admin/admin.php" id="adm">ÁREA ADMINISTRATIVA</a>
            </div>
        </div>
    </footer>




































</body>
</html>
