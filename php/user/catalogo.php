<?php 
SESSION_START(); 
require_once "../salvar/Conexao.php";






$stmt = $sql->prepare("SELECT * FROM carro");
$stmt->execute();
$result = $stmt->get_result();

$stmt = $sql->prepare("SELECT * FROM favorito");
$stmt->execute();
$result2 = $stmt->get_result();
             
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
        <input type="text" Placeholder="Buscar por Marca ou modelo...">
    </div>



    <div class="catalogo">
    <div>                
		<?php
                //onclick=\"location.href='../salvar/S_Favorito.php?id=".$row['id_car']."&status=".$row['status_car']."'\"
                    
                while($row = $result->fetch_assoc()){
                   
                if($row['status_car'] === 0){
                    echo "
                   <div>
                   <button class='btn-favoritar' data-id=".$row['id_car'].">❤</button>
                    <img src='" . htmlspecialchars($row['foto_car'], ENT_QUOTES, 'UTF-8') . "' alt='Foto do Veículo' width='200' height='150'>
                    <span></span>
                    <span>".htmlspecialchars($row['marca_car'], ENT_QUOTES, 'UTF-8')."</span>
                    <span>".htmlspecialchars($row['modelo_car'], ENT_QUOTES, 'UTF-8')."</span>
                    <span>".htmlspecialchars($row['ano_car'])."</span><span>".htmlspecialchars($row['quilometragem_car'])."</span><span>".htmlspecialchars($row['combustivel_car'], ENT_QUOTES, 'UTF-8')."</span>

                    <hr>

                    <div>
                        <p>Valor</p>
                        <span>R$".htmlspecialchars($row['preco_car'])."</span>
                        <button onclick=\"location.href='Veiculo.php?id=".$row['id_car']."'\">👁VER</button>
                    </div>
                </div>
                <br>

                
                    ";}}?>
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
    <a href="../admin/Clientes.php" id="adm">ÁREA ADMINISTRATIVA</a>    </div>
</div>
</footer>

<script src="../../js/assets.js"></script>
<script src="../../js/validarformulario.js"></script>

</body>
</html>
