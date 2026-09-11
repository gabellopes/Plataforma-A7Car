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
    <title>Adicionar Cliente</title>
</head>
<body>
    <?php
         if(isset($_SESSION['sucesso_cadastro'])){
            $Mensagem = $_SESSION['sucesso_cadastro'];
            echo "<script>alert('$Mensagem');</script>"; 
            $_SESSION['sucesso_cadastro'] = null;
        }
    ?>
    <h1>Adicionar Cliente</h1>
    <form method="Post" action="../../salvar/S_Cliente.php">
        <fieldset><label for="Nome">Nome</label><input type="text" name="Nome" id="Nome"  maxlength="20" required></fieldset>
        <fieldset><label for="Email">Email</label><input type="email" name="Email" id="Email"  required></fieldset>
        <div id="Mensagem_email"></div>
        <fieldset><label for="Telefone">Telefone</label><input type="text" name="Telefone" id="Telefone" id="Telefone" maxlength="15" required></fieldset>
        <div id="Mensagem_telefone"></div>
        <fieldset><label for="Cpf">CPF</label><input type="text" name="Cpf" id="Cpf" maxlength="14" required></fieldset>
        <div id="Mensagem_cpf"></div>
        <fieldset><label for="Cnh">CNH</label><input type="text" name="Cnh" id="Cnh" maxlength="9"  required></fieldset>
        <div id="Mensagem_cnh"></div>
        <fieldset><input type="button" id="Cadastrar" onclick="validarCliente()" value="Salvar"></fieldset>
        <fieldset><button type="button" onclick="window.location.href='../Clientes.php'">Voltar</button></fieldset>
    </form>
    <script src="../../../js/mascaras.js"></script>
    <script src="../../../js/validarformulario.js"></script>
</body>
</html>