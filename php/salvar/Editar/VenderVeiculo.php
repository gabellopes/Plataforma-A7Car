<?php
    SESSION_START();
    
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
    <h1>Vender Veiculo</h1>
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
        $cliente = $result->fetch_assoc();
     ?>
    <form method="Post" action="../Atualizar/VenderVeiculo.php">
        <input type="hidden" name="id" value="<?php echo $cliente['id_car']; ?>">
        
        <fieldset><label for="Cpf">CPF</label><input type="text" name="Cpf" id="Cpf" maxlength="14"  required><button>Buscar</button></fieldset>
        <div id="Mensagem_cpf"></div>
        <fieldset><label for="Nome">Nome do Comprador</label><input type="text" name="Nome" id="Nome"  maxlength="20" required></fieldset>
        <fieldset><label for="Telefone">Telefone</label><input type="text" name="Telefone" id="Telefone" maxlength="15" required></fieldset>
        <div id="Mensagem_telefone"></div>
        <fieldset><label for="Preco">Valor da venda</label><input type="number" name="Preco" id="Preco"  maxlength="20" required></fieldset>
        <fieldset><input type="button" id="Cadastrar" value="Salvar" onclick="return confirm('Tem certeza que deseja vender este veiculo?') ? validarCliente() : true;"></fieldset>
        <fieldset><button type="button" onclick="window.location.href='../../admin/Clientes.php'">Voltar</button></fieldset>
    </form>
    <?php }else{ ?>
        <p>Cliente não encontrado.</p>
    <?php } ?>
    <script src="../../../js/mascaras.js"></script>
        <script src="../../../js/validarformulario.js"></script>

</body>
</html>