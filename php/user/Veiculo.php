<?php 
SESSION_START(); 
require_once "../salvar/Conexao.php";


$id = $_GET['id'];
$stmt = $sql->prepare("SELECT * FROM carro WHERE id_car = $id ");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
             
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
    <?php
         if(isset($_SESSION['erro_cadastro'])){
            $Mensagem = $_SESSION['erro_cadastro'];
            echo "<script>alert('" . htmlspecialchars($Mensagem, ENT_QUOTES, 'UTF-8') . "');</script>"; 
            unset($_SESSION['erro_cadastro']);
        }
    ?>

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



<br><br><br><br><br><br><br>
    <div class="catalogo">
                
                <a href="catalogo.php">⬅VOLTAR AO CATALOGO</a>

                <div>
                <?php
                if(isset($_SESSION['user_id'])){
                        $verifica = $sql->prepare("SELECT id_fav FROM favorito WHERE id_usu = ? AND id_car = ?");
                        $verifica->bind_param("ii", $_SESSION['user_id'], $row['id_car']);
                        $verifica->execute();
                        $resultado = $verifica->get_result();

                        if($resultado->num_rows > 0){
                            echo"
                        
                        <button class='btn-favoritar' data-id=".$row['id_car'].">❤️</button>
                        ";
                        }else{
                        echo"
                        
                        <button class='btn-favoritar' data-id=".$row['id_car'].">❤</button>
                        ";
                        }
                    }else{
                        echo"
                        
                        <button onclick='window.location.href=\"Login.php\"'>❤</button>
                        ";
                    }
                
                ?>
                
                <img <?php echo "src='" . htmlspecialchars($row['foto_car'], ENT_QUOTES, 'UTF-8') . "'"?> alt='Foto do Veículo' width='200' height='150'>
                <span></span>
                 <span><?php echo htmlspecialchars($row['marca_car'], ENT_QUOTES, 'UTF-8')?></span>
                 <span><?php echo htmlspecialchars($row['modelo_car'], ENT_QUOTES, 'UTF-8')?></span>
                 <span>R$ <?php echo htmlspecialchars($row['preco_car'])?></span>
                 <div><span><?php echo htmlspecialchars($row['ano_car'])?></span></div>
                 <div><span><?php echo htmlspecialchars($row['quilometragem_car'])?></span></div>
                 <div><span><?php echo htmlspecialchars($row['combustivel_car'], ENT_QUOTES, 'UTF-8')?></span></div>
                 <div><span><?php echo htmlspecialchars($row['descricao_car'])?></span></div>
                 <button>💬NEGOCIAR VIA WHATSAPP</button>
                 <button id="abrirDialog">✈FAZER SIMULAÇAO</button>
             </div><!-- Fim da div do carro-->
            
            <dialog id="dialog">
                <button id="fecharDialog">🏃‍♂️💨</button>

                    <h1>SIMULAÇÃO - <?php echo htmlspecialchars($row['marca_car'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($row['modelo_car'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($row['ano_car'], ENT_QUOTES, 'UTF-8') ?></h1>
                    <hr>
                    <div>
                    <img <?php echo "src='" . htmlspecialchars($row['foto_car'], ENT_QUOTES, 'UTF-8') . "'"?> alt='Foto do Veículo' width='200' height='150'>
                    <span></span>
                    <span><?php echo htmlspecialchars($row['marca_car'], ENT_QUOTES, 'UTF-8')?></span>
                    <span><?php echo htmlspecialchars($row['modelo_car'], ENT_QUOTES, 'UTF-8')?></span>
                    <span>R$ <?php echo htmlspecialchars($row['preco_car'])?></span>
                    </div>

                    <form action="../salvar/S_Simulacao.php" method="post">
                        <input id="tipoCadastro" type="text" value="simulacao" hidden>
                        <input name="id" type="text" hidden value="<?php echo htmlspecialchars($row['id_car'], ENT_QUOTES, 'UTF-8')?>">
                        <input name="status_car" type="text" hidden value="<?php echo htmlspecialchars($row['status_car'], ENT_QUOTES, 'UTF-8')?>">
                        <div><label for="Nome">Nome</label><input type="text" name="Nome" id="Nome"  maxlength="255" required></div>
                        <div><label for="Cpf">CPF</label><input type="text" name="Cpf" id="Cpf" maxlength="14" required></div>
                        <div id="Mensagem_cpf"></div>
                        <div><label for="DataNascimento">Data de Nascimento</label><input type="date" name="DataNascimento" id="DataNascimento" required></div>
                        <div><label for="Telefone">Telefone</label><input type="text" name="Telefone" id="Telefone" id="Telefone" maxlength="15" required></div>
                        <div id="Mensagem_telefone"></div>
                        
                        <div>
                            <label for="">POSSUI CNH?</label>
                            <button type="button" id="temCnh" >SIM</button>
                            <button type="button" id="naoTemCnh">NÃO</button>
                        </div>
                        <div  id="divCnh"hidden><label for="Cnh" id="labelCnh">CNH</label><input type="text" name="Cnh" id="Cnh" maxlength="9"></div>
                        <div id="Mensagem_cnh"></div>
                        <input type="button" id="enviarDialog" class="btn"  value="📊ENVIAR SIMULAÇÃO">
                    </form>

            </dialog>
             
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
<script src="../../js/mascaras.js"></script>
<script src="../../js/validarformulario.js"></script>
<script src="../../js/assets.js"></script>

    
</body>
</html>
