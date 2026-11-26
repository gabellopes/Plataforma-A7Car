<?php 
SESSION_START(); 
require_once "../salvar/Conexao.php";

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo</title>
    <link rel="icon" type="image/svg" href="../../img/favicon/a7seven_sem_fundo.svg">
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
            <p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['user_nome'], ENT_QUOTES, 'UTF-8'); ?>!</p>
            
            <button class="btn" type="button" onclick="window.location.href='../salvar/Sair.php'">SAIR </button>
            <?php endif; ?>
        </div>

    </header>

    <div id="titulo">
        <h3>Nossa equipe</h3>
        <h1>COLABORADORES</h1>
        
    </div>
    <div id="colaboradores">
               
		<?php
                include_once "../salvar/Conexao.php";
                
                
                $stmt = $sql->prepare("SELECT * FROM colaborador ");
                $stmt->execute();
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc()) {

                //Link do whatsapp
                $telefone = preg_replace('/[^0-9]/', '', $row['telefone_col']);
                $mensagemWhatsApp = "Olá! Vim pelo site A7 Car e gostaria de falar com" . " ". $row['nome_col'] . " ". $row['servico_col'];
                $urlWhatsApp = "https://wa.me/" . $telefone . "?text=" . urlencode($mensagemWhatsApp);

                ?>
            <div class="colaborador">
                <img src="<?php echo htmlspecialchars($row['foto_col'], ENT_QUOTES, 'UTF-8'); ?>" alt="Foto do Colaborador" style="width: 150px; border-radius: 200px; height: 150px; object-fit: cover;">
                <span id="nome-colaborador"><?php echo htmlspecialchars($row['nome_col'], ENT_QUOTES, 'UTF-8'); ?></span>
                <span><?php echo htmlspecialchars($row['servico_col'], ENT_QUOTES, 'UTF-8'); ?></span>
                <span><?php echo htmlspecialchars($row['descricao_col'], ENT_QUOTES, 'UTF-8'); ?></span>

                <div class="contato">
                    <span><?php echo htmlspecialchars($row['telefone_col'], ENT_QUOTES, 'UTF-8'); ?></span>
                    <span><?php echo htmlspecialchars($row['email_col'], ENT_QUOTES, 'UTF-8'); ?></span>
                    <button onclick="window.open('<?php echo $urlWhatsApp; ?>', '_blank')" id="btnWhatsApp">💬WHATSAPP</button>
                </div>
            </div>
            <br>
        <?php 
        } // Fim do while
        ?>
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
    <a href="../admin/Clientes.php" id="adm">ÁREA ADMINISTRATIVA</a>    </div>
</div>
</footer>

    
</body>
</html>
