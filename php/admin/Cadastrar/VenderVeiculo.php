<?php
    include __DIR__ . "/../../salvar/funcoes.php";


    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
    
   require_once "../../auth/authadm.php";
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vender Veiculo</title>
    <link rel="icon" type="image/svg" href="../../../img/favicon/a7seven_sem_fundo.svg">
    <link rel="stylesheet" href="../../../css/adimin.css">
    <link rel="stylesheet" href="../../../css/ADMvender.css">

    
</head>
<body>
  
    <?php 
     if(isset($_SESSION['sucesso_cadastro'])){
        $Mensagem = $_SESSION['sucesso_cadastro'];
        echo "<script>alert('" . htmlspecialchars($Mensagem, ENT_QUOTES, 'UTF-8') . "');</script>"; 
        $_SESSION['sucesso_cadastro'] = null;
    }
    if(isset($_GET['id'])){
        
        require_once "../../salvar/Conexao.php";
        $id = $_GET['id'];
        $stmt = $sql->prepare("SELECT * FROM carro WHERE id_car = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $carro = $result->fetch_assoc();
     ?>
     <div id="meio">
       <h1>Registrar Venda - <?php echo htmlspecialchars($carro['marca_car'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($carro['modelo_car'], ENT_QUOTES, 'UTF-8'); ?></h1>
    
<div class="mei">
    <div id="infoCarro">
       <div id="foto">
       <img id="preview-imagem" src="<?php echo !empty($carro['foto_car']) ? htmlspecialchars($carro['foto_car']) : '#'; ?>" alt="Pré-visualização da imagem" style="max-width: 30vw; max-height: 40vh; <?php echo empty($carro['foto_car']) ? 'display: none;' : 'display: block;'; ?> border-radius: 5px; border: 1px solid #ccc;" />
       </div>
       <div id="nomeV">
       <h1><?php echo htmlspecialchars($carro['marca_car'])?></h1>
       <h1><?php echo htmlspecialchars( $carro['modelo_car'])?></h1>
       </div>
       <p id="precoCarro"><?php echo "R$ ". number_format(htmlspecialchars($carro['preco_car']), 2, ',', '.')?></p>
        
     </div>
    
<div id="cadastro">
    <form method="Post" action="../../salvar/S_VendaVeiculo.php">
        <input type="hidden" name="id_car"  value="<?php echo htmlspecialchars(intval($carro['id_car'])); ?>">
        <?php echo $inputCsrf;?>
        <label for="Cpf">CPF</label><input type="text" name="Cpf" id="Cpf" maxlength="14"  required><button type="button" value="BuscarCpf" name="BuscarCpf" id="BuscarCpf">Buscar</button> 
        <div id="Mensagem_cpf"></div>
        <label for="Nome">Nome do Comprador</label><input type="text" name="Nome" id="Nome"  maxlength="255" required>
        <label for="Telefone">Telefone</label><input type="text" name="Telefone" id="Telefone" maxlength="15" required>
        <div id="Mensagem_telefone"></div>
        <label for="Preco">Valor da venda</label><input type="text" name="Preco" id="Preco" value="<?php echo intval($carro['preco_car']); ?>" required>
        <div style="color: red;"><?php if (isset($_SESSION['erro_cadastro'])){echo htmlspecialchars($_SESSION['erro_cadastro'], ENT_QUOTES, 'UTF-8');unset($_SESSION['erro_cadastro']);} ?></div>
        <div>
        <input type="button" class="btn" id="Cadastrar" value="Vender" onclick="return confirm('Tem certeza que deseja vender este veiculo?') ? validarVenda() : true;">
            <button type="button"  onclick="window.location.href='../../admin/Veiculos.php'">Voltar</button>
        </div>
    </form>
</div>

    <?php }else{ ?>
        <p>Cliente não encontrado.</p>
    <?php } ?>
    <script src="../../../js/mascaras.js"></script>
    <script src="../../../js/validarformulario.js"></script>
    <script src="../../../js/BuscarCpf.js"></script>
</div>
</div>
</body>
</html>