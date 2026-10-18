<?php 
SESSION_START(); 
require_once "../salvar/Conexao.php";


if(!isset($_SESSION['user_email']) and !isset($_SESSION['user_senha'])){
    header("Location: Login.php");
}

$stmt = $sql->prepare("SELECT * FROM carro");
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo</title>
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

    <div>                
		<?php
                //onclick=\"location.href='../salvar/S_Favorito.php?id=".$row['id_car']."&status=".$row['status_car']."'\"
                $temFavorito = false;
                while($row = $result->fetch_assoc()){
                   
                if($row['status_car'] === 0){

                    if(isset($_SESSION['user_id'])){
                        $verifica = $sql->prepare("SELECT id_fav FROM favorito WHERE id_usu = ? AND id_car = ?");
                        $verifica->bind_param("ii", $_SESSION['user_id'], $row['id_car']);
                        $verifica->execute();
                        $resultado = $verifica->get_result();

                        if($resultado->num_rows > 0){
                        $temFavorito = true;
                        echo "
                        <div>
                                <button class='btn-favoritar' data-id=".$row['id_car'].">❤️</button>
                            <img src='" . htmlspecialchars($row['foto_car'], ENT_QUOTES, 'UTF-8') . "' alt='Foto do Veículo' width='200' height='150'>
                            <span></span>
                            <span>".htmlspecialchars($row['marca_car'], ENT_QUOTES, 'UTF-8')."</span>
                            <span>".htmlspecialchars($row['modelo_car'], ENT_QUOTES, 'UTF-8')."</span>
                            <span>".htmlspecialchars($row['ano_car'])."</span><span>".htmlspecialchars($row['quilometragem_car'])."</span><span>".htmlspecialchars($row['combustivel_car'], ENT_QUOTES, 'UTF-8')."</span>

                            <hr>

                            <div>
                                <p>Valor</p>
                                <span>R$".htmlspecialchars($row['preco_car'])."</span>
                                <button onclick=\"location.href='php/user/Veiculo.php?id=".$row['id_car']."'\">👁VER</button>
                            </div>
                        </div>
                        <br>
                        ";
                        }
                    }
                    }
                    
                    }
                    
                    if($temFavorito === false):?>

                    <div>
                        <img src="#" alt="ftcoracao">🖤🚗
                        <h1>Você ainda não tem favoritos</h1>
                        <a href="catalogo.php">EXPLORAR CATÁLOGO🚘</a>
                    </div>
            <?php endif;?>       
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

<script src="../../js/assets.js"></script>

</body>
</html>
