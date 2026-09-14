<?php SESSION_START(); ?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo</title>
    <link rel="stylesheet" href="../../css/principal.css">
    <link rel="stylesheet" href="../../css/colaboradores.css">
</head>
<body>

    <header id="cabecalho">
        
        <img src="../../img/logo.png" alt="" class="logo" onclick="window.location.href='../../index.php'">
        <div id="link">
            <a href="catalogo.php">CATÁLOGO</a>
            <a href="colaboradores.php">COLABORADORES</a>
            <a href="contato.php">CONTATO</a>
            <?php if(isset($_SESSION['user_email'])): ?>
                <a href="favoritos.php">FAVORITOS</a>
            <?php endif; ?>
        </div>
        <div id="linksAuth">
            <?php if(!isset($_SESSION['user_email'])): ?>
            <button id="btnEntrar" class="btn" type="button" onclick="window.location.href='Login.php'">ENTRAR</button>
            <button id="btnCadastrar" class="btn" type="button" onclick="window.location.href='Cadastro.php'">CADASTRAR </button>
            <?php else:?>
            <p>Bem-vindo, <?php echo $_SESSION['user_nome']; ?>!</p>
            
            <button class="btn" type="button" onclick="window.location.href='../salvar/Sair.php'">SAIR </button>
            <?php endif; ?>
        </div>

    </header>

    <div id="titulo">
        <h3>Nossa equipe</h3>
        <h1>COLABORADORES</h1>
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
           <a href="../admin/Clientes.php" id="adm">ÁREA ADMINISTRATIVA</a>
        </div>
    </div>
</footer>

    
</body>
</html>
