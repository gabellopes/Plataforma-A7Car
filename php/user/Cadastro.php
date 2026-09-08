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
    <link rel="stylesheet" href="../../css/cadastro.css">
    
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
        <h3>Crie uma conta</h3>
        <h1>CADASTRO</h1>
    </div>

    <div class="mei">
    <div id="cadastro">


    <?php if (isset($_SESSION['erro_cadastro'])): ?>
        <p style="color: red;">
            <?php
                echo $_SESSION['erro_cadastro'];
                unset($_SESSION['erro_cadastro']);
            ?>
        </p>
    <?php endif; ?>


    <form action="../salvar/S_User.php" method="post">
        <label for="nome">Nome Completo</label><input type="text" name="Nome" id="nome" required>
        <label for="email">E-mail</label><input type="email" name="Email" id="email" required>
        <label for="telefone">Telefone</label><input type="tel" name="Telefone" id="telefone" required>
        <label for="senha">Senha</label> <input type="password" name="Senha" id="senha" required>
        <label for="confirmar-senha">Confirmar Senha</label> <input type="password" name="Confirmar_Senha" id="confirmar-senha" required>

        <button type="submit">Cadastrar</button>
    </form>
<br>
   <a href="Login.php">Já tem cadastro? Logar</a>

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
