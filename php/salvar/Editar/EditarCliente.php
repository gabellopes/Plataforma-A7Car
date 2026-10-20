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
    <link rel="stylesheet" href="../../../css/ADMnovoC.css">
    <link rel="stylesheet" href="../../../css/principal.css">
</head>
<body>
    <div id="meio">
        <h1>Editar Cliente</h1>
    </div>
    <?php
    if(isset($_SESSION['sucesso_cadastro'])){
        $Mensagem = $_SESSION['sucesso_cadastro'];
        echo "<script>alert('$Mensagem');</script>";
        $_SESSION['sucesso_cadastro'] = null;
    }
    if(isset($_GET['id'])){
        
        require_once "../../salvar/Conexao.php";
        $id = $_GET['id'];
        $stmt = $sql->prepare("SELECT * FROM cliente WHERE id_cli = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $cliente = $result->fetch_assoc();
    ?>
        <div class="mei">
        <div id="cadastro">
    <form method="Post" action="../Atualizar/AtualizarCliente.php">
        <div>
        <input type="hidden" name="id" value="<?php echo $cliente['id_cli']; ?>">
        <label for="Nome">Nome</label><input type="text" name="Nome" id="Nome"  value="<?php echo $cliente['nome_cli']; ?>" maxlength="20" required>
        <label for="Email">Email</label><input type="email" name="Email" id="Email"  value="<?php echo $cliente['email_cli']; ?>" required>
        <div id="Mensagem_email"></div>
        <label for="Telefone">Telefone</label><input type="text" name="Telefone" id="Telefone" id="Telefone" value="<?php echo $cliente['telefone_cli']; ?>" maxlength="15" required>
        <div id="Mensagem_telefone"></div>
        <label for="Cpf">CPF</label><input type="text" name="Cpf" id="Cpf" maxlength="14" value="<?php echo $cliente['cpf_cli']; ?>" required>
        <div id="Mensagem_cpf"></div>
        <label for="Cnh">CNH</label><input type="text" name="Cnh" id="Cnh" maxlength="11"  value="<?php echo $cliente['cnh_cli']; ?>" required>
        <div id="Mensagem_cnh"></div>
        <input type="button" class="btn" id="Cadastrar" value="Salvar" onclick="return confirm('Tem certeza que deseja atualizar este cliente?') ? validarCliente() : true;">
        <button type="button" class="btn" onclick="window.location.href='../../admin/Clientes.php'">Voltar</button>
        </div>
    </form>
        </div>
        </div>
    <?php }else{ ?>
        <p>Cliente não encontrado.</p>
    <?php } ?>
    <script src="../../../js/mascaras.js"></script>
        <script src="../../../js/validarformulario.js"></script>

</body>
</html>