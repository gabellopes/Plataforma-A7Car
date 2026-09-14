<?php SESSION_START(); 
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/principal.css">
</head>

<body>
    <header id="cabecalho">
        <img src="img/logo.png" alt="" class="logo" onclick="window.location.href='index.php'">
        <div id="link">
            <a href="php/user/catalogo.php">CATÁLOGO</a>
            <a href="php/user/colaboradores.php">COLABORADORES</a>
            <a href="php/user/contato.php">CONTATO</a>
            <?php if(isset($_SESSION['user_email'])): ?>
                <a href="php/user/favoritos.php">FAVORITOS</a>
            <?php endif; ?>
        </div>
        <div id="linksAuth">
             <?php if(!isset($_SESSION['user_email'])): ?>
            <button id="btnEntrar" class="btn" type="button" onclick="window.location.href='php/user/Login.php'">ENTRAR</button>
            <button id="btnCadastrar" class="btn" type="button" onclick="window.location.href='php/user/Cadastro.php'">CADASTRAR </button>
            <?php else: ?>
            <p>Bem-vindo, <?php echo $_SESSION['user_nome']; ?>!</p>
            <button class="btn" type="button" onclick="window.location.href='php/salvar/Sair.php'">SAIR </button>
            <?php endif; ?>
        </div>

    </header>

    <div class="meio">

        <h1>VEÍCULOS DE AUTO PADRÃO</h1>
        <h2>As melhores marcas do mercado em um só lugar.</h2>
    <div>
        <button class="btn">Buscar </button>
        <input type="text" name="" id="buscar">
    </div>
    </div>

    <div id="faixa">

    </div>

    <div id="cat">
        <div id="textocat">
            <h3>Destaque</h3>
            <h1>ÚLTIMAS ENTRADAS</h1>
        </div>
        <div>
        <button id="btnVender">VER TODOS</button>
        </div>
    </div>

    <div id="atend">

        <h1>ATENDIMENTO PELO WHATSAPP</h1>
        <h2> Nossos consultores estão prontos para atender você. <br>
            Tire dúvidas, negocie e feche negócio sem sair de casa</h2>
        <button class="btn">FAZER UMA PROPOSTA</button>
        <button id="btnVender">VENDER MEU CARRO</button>

    </div>
    <footer>

        <div class="fo">
            <div id="ter">
                <img src="img/logo.png" alt="" id="logo">
                <h3>Multimarcas premium especializada em venda </h3>
                <h3>e compra de veículos.Transparência, qualidade </h3>
                <h3>e atendimento diferenciado.</h3>
            </div>
            <div class="nav">
                <h1>NAVEGAÇÃO</h1>
                <a href="">CATÁLOGO</a>
                <a href="">COLABORADORES</a>
                <a href="">CONTATO</a>
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
                <a href="php/admin/Clientes.php" id="adm">ÁREA ADMINISTRATIVA</a>
            </div>
        </div>
    </footer>

</body>

</html>
