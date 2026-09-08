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
    <title>Document</title>
</head>
<body>
    <form method="Post" action="../../salvar/S_Colaborador.php">
        <fieldset><label for="Nome">Nome</label><input type="text" name="Nome" id="Nome"  maxlength="20" required></fieldset>
        <fieldset><label for="Email">Email</label><input type="email" name="Email" id="Email"  required></fieldset>
        <fieldset><label for="Telefone">Telefone</label><input type="text" name="Telefone" id="Telefone"  maxlength="20" required></fieldset>
        <fieldset><label for="Imagem">Foto</label><input type="file" name="Foto" id="Foto"  maxlength="255" required></fieldset>
        <fieldset><label for="Servico">Serviço</label><input type="text" name="Servico" id="Servico"  maxlength="255" required></fieldset>
        <fieldset><label for="Descricao">Descrição</label><input type="text" name="Descricao" id="Descricao"  maxlength="255" required></fieldset>

        <fieldset><input type="submit" value="Salvar"></fieldset>
        <fieldset><button type="button" onclick="window.location.href='../Colaboradores.php'">Voltar</button></fieldset>
    </form>
    <script src="../../../js/telefone.js"></script>
</body>
</html>