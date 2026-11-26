<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../salvar/Conexao.php";

if (!isset($_SESSION['user_email']) and !isset($_SESSION['user_senha'])) {
    header("Location: Login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favoritos</title>
    <link rel="icon" type="image/svg" href="../../img/favicon/a7seven_sem_fundo.svg">
    <link rel="stylesheet" href="../../css/principal.css">
    <link rel="stylesheet" href="../../css/favoritos.css">
</head>
<body>

    <header id="cabecalho">
        <img src="../../img/logo.png" alt="" class="logo" onclick="window.location.href='../../index.php'">
        <div id="link">
            <a href="catalogo.php">CATÁLOGO</a>
            <a href="colaboradores.php">COLABORADORES</a>
            <a href="contato.php">CONTATO</a>
            <?php if(isset($_SESSION['user_email'])): ?>
                <a href="#">FAVORITOS</a>
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
        <h3>Minha lista</h3>
        <h1>FAVORITOS</h1>
    </div>
    
    <div class="catalogo">
        <div id="listaFavoritos">
            <?php include "buscarFavoritos.php"; ?>
        </div>
    </div>
    
    <button id="btn-carregar-mais-fav" style="<?php echo !$temMaisCarros ? 'display: none;' : ''; ?>">Carregar mais veículos</button>

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
                <a href="../../pdf/3DSA_AP_GRUPO6.pdf" target="_blank" rel="noopener noreferrer" class="menu-link-site">MANUAL DE INSTRUÇÕES<img class="menu-icon" src="../../img/admin/ajuda.png" alt="?" style="width: 15px;"></a>
            </div>
            <div>
                <h1>CONTATO</h1>
                <h3>📞 (11) 97332-0504
                    <br>
                    aseven7multimarcas@gmail.com
                    <br>
                    📍 Estr. de Itapecerica, 4660 - Capão Redondo, São Paulo - SP, 05849-440
                </h3>
            </div>
            <div id="divadm">
                <a href="../admin/Clientes.php" id="adm">ÁREA ADMINISTRATIVA</a>
            </div>
        </div>
    </footer>

    <script src="../../js/assets.js"></script>
    <script src="../../js/carregarMaisFavoritos.js"></script>

</body>
</html>