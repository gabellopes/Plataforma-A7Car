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
    <h1>Adicionar Cliente</h1>
    <form method="Post" action="../../salvar/S_Cliente.php">
        <fieldset><label for="Nome">Nome</label><input type="text" name="Nome" id="Nome"  maxlength="20" required></fieldset>
        <fieldset><label for="Email">Email</label><input type="email" name="Email" id="Email"  required></fieldset>
        <fieldset><label for="Telefone">Telefone</label><input type="text" name="Telefone" id="Telefone" id="Telefone" maxlength="15" required></fieldset>
        <fieldset><label for="Cpf">CPF</label><input type="text" name="Cpf" id="Cpf" maxlength="14" required></fieldset>
        <fieldset><label for="Cnh">CNH</label><input type="text" name="Cnh" id="Cnh" maxlength="11"  required></fieldset>
        <fieldset><input type="submit" value="Salvar"></fieldset>
        <fieldset><button type="button" onclick="window.location.href='../Clientes.php'">Voltar</button></fieldset>
    </form>
    <script src="../../../js/mascaras.js"></script>
</body>
</html>