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
    <title>Editar Cliente</title>
</head>
<body>
    <h1>Editar Cliente</h1>
    <?php 
    if(isset($_GET['id'])){
        
        require_once "../../salvar/Conexao.php";
        $id = $_GET['id'];
        $stmt = $sql->prepare("SELECT * FROM cliente WHERE id_cli = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $cliente = $result->fetch_assoc();
     ?>
    <form method="Post" action="../Atualizar/AtualizarCliente.php">
        <input type="hidden" name="id" value="<?php echo $cliente['id_cli']; ?>">
        <fieldset><label for="Nome">Nome</label><input type="text" name="Nome" id="Nome"  value="<?php echo $cliente['nome_cli']; ?>" maxlength="20" required></fieldset>
        <fieldset><label for="Email">Email</label><input type="email" name="Email" id="Email"  value="<?php echo $cliente['email_cli']; ?>" required></fieldset>
        <div id="Mensagem_email"></div>
        <fieldset><label for="Telefone">Telefone</label><input type="text" name="Telefone" id="Telefone" id="Telefone" value="<?php echo $cliente['telefone_cli']; ?>" maxlength="15" required></fieldset>
        <div id="Mensagem_telefone"></div>
        <fieldset><label for="Cpf">CPF</label><input type="text" name="Cpf" id="Cpf" maxlength="14" value="<?php echo $cliente['cpf_cli']; ?>" required></fieldset>
        <fieldset><label for="Cnh">CNH</label><input type="text" name="Cnh" id="Cnh" maxlength="11"  value="<?php echo $cliente['cnh_cli']; ?>" required></fieldset>
        <fieldset><input type="button" id="Cadastrar" value="Salvar" onclick="return confirm('Tem certeza que deseja atualizar este cliente?') ? validarCliente() : true;"></fieldset>
        <fieldset><button type="button" onclick="window.location.href='../../admin/Clientes.php'">Voltar</button></fieldset>
    </form>
    <?php }else{ ?>
        <p>Cliente não encontrado.</p>
    <?php } ?>
    <script src="../../../js/mascaras.js"></script>
        <script src="../../../js/validarformulario.js"></script>

</body>
</html>