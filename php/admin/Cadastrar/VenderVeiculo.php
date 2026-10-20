<?php
    include __DIR__ . "/../../salvar/funcoes.php";


    if($_SESSION['user_email'] !== 'admin@gmail.com'){
            header("Location: ../admin/Login.php");
            exit;
        }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vender Veiculo</title>
</head>
<body>
  
    <?php 
     if(isset($_SESSION['sucesso_cadastro'])){
        $Mensagem = $_SESSION['sucesso_cadastro'];
        echo "<script>alert('$Mensagem');</script>"; 
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
       <h1>Registrar Venda - <?php echo $carro['marca_car'] , " ", $carro['modelo_car']; ?></h1>

       <div>

        <img src="../../../img/logo.png" alt="" style=" width: 100px;">
       <p><?php echo $carro['marca_car']?></p>
       <h1><?php echo $carro['modelo_car']?></h1>
       <p><?php echo $carro['preco_car']?></p>
    
    </div>

    <form method="Post" action="../../salvar/S_VendaVeiculo.php">
        <input type="hidden" name="id_car"  value="<?php echo intval($carro['id_car']); ?>">
        
        <fieldset><label for="Cpf">CPF</label><input type="text" name="Cpf" id="Cpf" maxlength="14"  required><button type="button" value="BuscarCpf" name="BuscarCpf" id="BuscarCpf">Buscar</button></fieldset>
        <div id="Mensagem_cpf"></div>
        <fieldset><label for="Nome">Nome do Comprador</label><input type="text" name="Nome" id="Nome"  maxlength="20" required></fieldset>
        <fieldset><label for="Telefone">Telefone</label><input type="text" name="Telefone" id="Telefone" maxlength="15" required></fieldset>
        <div id="Mensagem_telefone"></div>
        <fieldset><label for="Preco">Valor da venda</label><input type="text" name="Preco" id="Preco" value="<?php echo intval($carro['preco_car']); ?>" required></fieldset>
        <div style="color: red;"><?php if (isset($_SESSION['erro_cadastro'])){echo $_SESSION['erro_cadastro'];unset($_SESSION['erro_cadastro']);} ?></div>
        <fieldset><input type="button" id="Cadastrar" value="Salvar" onclick="return confirm('Tem certeza que deseja vender este veiculo?') ? validarVenda() : true;"></fieldset>
        <fieldset><button type="button" onclick="window.location.href='../../admin/Veiculos.php'">Voltar</button></fieldset>
    </form>
    <?php }else{ ?>
        <p>Cliente não encontrado.</p>
    <?php } ?>
    <script src="../../../js/mascaras.js"></script>
    <script src="../../../js/validarformulario.js"></script>
    <script src="../../../js/BuscarCpf.js"></script>

</body>
</html>