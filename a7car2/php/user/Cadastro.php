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


    


    <form action="../salvar/S_User.php" method="post">
        <label for="nome">Nome Completo</label>
        <input type="text" name="Nome" id="Nome" maxlength="255" required>
        

        <label for="email">E-mail</label>
        <input type="email" name="Email" id="Email" maxlength="255" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" required>
        <div id="Mensagem_email"></div>

        <label for="telefone">Telefone</label>
        <input type="tel" name="Telefone" id="Telefone" maxlength="15"  required>
        <div id="Mensagem_telefone"></div>
         <div ><h1 id="teste"></h1></div>

        <label for="senha">Senha</label>
        <input type="password" name="Senha" id="Senha" maxlength="20" required>

        <label for="confirmar-senha">Confirmar Senha</label>
        <input type="password" name="Confirmar_Senha" id="Confirmar-senha" maxlength="20" required>
        <div id="Mensagem_senha"></div>
        <div style="color: red;"><?php if (isset($_SESSION['erro_cadastro'])){echo $_SESSION['erro_cadastro'];unset($_SESSION['erro_cadastro']);} ?></div>


        <button type="button" id="Cadastrar" onclick="validarUser()">Cadastrar</button>
        <input type="button" value="User" onclick="PreencherUser()">
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
                <h3>📞 (11) 97332-0504
                    <br>
                    email
                    <br>
                    📍 Estr. de Itapecerica, 4660 - Capão Redondo, São Paulo - SP, 05849-440
                </h3>
            </div>
            <div id="divadm">
                <a href="../admin/Clientes.php" id="adm">ÁREA ADMINISTRATIVA</a>
            </div>
        </div>
    </footer>
    <script src="../../js/mascaras.js"></script>
    <script src="../../js/validarformulario.js"></script>

</body>
</html>
