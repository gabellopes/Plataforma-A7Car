<?php 
if(SESSION_STATUS() === PHP_SESSION_NONE){
    session_start();
}
require_once "../salvar/Conexao.php";









             
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo</title>
    <link rel="stylesheet" href="../../css/principal.css">
    <link rel="stylesheet" href="../../css/catalogo.css">
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
            <p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['user_nome'], ENT_QUOTES, 'UTF-8'); ?>!</p>
            <button class="btn" type="button" onclick="window.location.href='../salvar/Sair.php'">SAIR </button>
            <?php endif; ?>
        </div>

    </header>

    <div id="titulo">
        <h3>Estoque Completo</h3>
        <h1>CATÁLOGO DE VEÍCULOS</h1>
        <div><input type="text" id="campoBusca" placeholder="Buscar por Marca ou modelo..." value="<?php echo isset($_GET['busca']) ? htmlspecialchars($_GET['busca'], ENT_QUOTES, 'UTF-8') : ''; ?>"><button style="width: 20px" onclick="cancelarBusca()">X</button></div>
    </div>



    <div class="catalogo">
    <div  id="listaVeiculos">
        
        <?php 
        
            include "buscarCarro.php";

        
        ?>
    </div>
<button id="btn-carregar-mais">Carregar mais veículos</button>
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
    <a href="../admin/Clientes.php" id="adm">ÁREA ADMINISTRATIVA</a>    </div>
</div>
</footer>

<script src="../../js/assets.js"></script>
<script src="../../js/validarformulario.js"></script>
<script src="../../js/buscarVeiculo.js"></script>
<script src="../../js/carregarMaisVeiculos.js"></script>

</body>
</html>
