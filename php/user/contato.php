<?php SESSION_START(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato</title>
    <link rel="stylesheet" href="../../css/contato.css">
   <link rel="stylesheet" href="../../css/principal.css">
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
            <?php else: ?>
            <p>Bem-vindo, <?php echo $_SESSION['user_nome']; ?>!</p>
            
            <button class="btn" type="button" onclick="window.location.href='../salvar/Sair.php'">SAIR </button>
            <?php endif; ?>
        </div>

    </header>


    <div id="titulo">
        <h3>Fale conosco</h3>
        <h1>CONTATO</h1>
    </div>

    <div class="mei">


    <div id="info">
    
    <h3>📍 ENDEREÇO</h3>
            <h2>Estr. de Itapecerica, 4660 - Capão Redondo, São Paulo - SP, 05849-440</h2>
            <h3>📞 TELEFONE</h3>
            <h2>(11) 97332-0504</h2>
            <h3>📧 E-MAIL</h3>
            <h2>Rua dos bobos N 0</h2>
            <h3>⏰ HORÁRIO</h3>
            <h2>Seg–Sex: 9h–18h · Sáb: 9h–15h</h2>


        <div id="exclusi"></div>


    </div>

    <div id="atend">

        <h2>Iniciar Atendimento</h2>
        <h5>Preencha os campos abaixo. Você será redirecionado ao WhatsApp com uma mensagem pronta.</h5>
        <br>
        <h3>Nome</h3>

    <form  method="POST">

        <input id="nome" placeholder="Digite o nome completo*" required>
        <br>
        <h3>Tipo de atendimento</h3>
        
    <label>
        <input type="radio"  id="opcao" name="atend" value="proposta">
        Fazer uma proposta
    </label>
    <br>
    <label>
        <input type="radio" id="opcao" name="atend" value="simulacao">
        Solicitar uma simulação
    </label>
    <br>
    <label>
        <input type="radio"  id="opcao" name="atend" value="venda">
        Vender meu carro
    </label>
    <br>
    <br>
    <button id="botao">Enviar pelo WhatsApp</button>


    </form>
        
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
        <a href="">CATÁLOGO</a>
        <a href="">COLABORADORES</a>
        <a href="">CONTATO</a>
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
        <a href="php/admin/Clientes.php" id="adm">ÁREA ADMINISTRATIVA</a>
    </div>
</div>
</footer>

</body>
</html>
