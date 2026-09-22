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
    <title>Adicionar Veículo</title>
</head>
<body>
    <?php
         if(isset($_SESSION['sucesso_cadastro'])){
            $Mensagem = $_SESSION['sucesso_cadastro'];
            echo "<script>alert('$Mensagem');</script>"; 
            $_SESSION['sucesso_cadastro'] = null;
        }
    ?>
      <h1>Adicionar Veículo</h1>
    <form method="POST" action="../../salvar/S_Veiculo.php">
        <fieldset><label for="Marca">Marca</label><input type="text" name="Marca" id="Marca"  maxlength="20" required></fieldset>
        <fieldset><label for="Modelo">Modelo</label><input type="text" name="Modelo" id="Modelo"  maxlength="20" required></fieldset>
        <fieldset><label for="Ano">Ano</label><input type="text" name="Ano" id="Ano"  maxlength="4" minlength="4" required></fieldset>
        <fieldset><label for="Preco">Preço</label><input type="text" name="Preco" id="Preco"  maxlength="20" required></fieldset>
        <fieldset><label for="Cor">Cor</label><input type="text" name="Cor" id="Cor"  maxlength="20" required></fieldset>
        <fieldset><label for="Quilometragem">Quilometragem</label><input type="text" name="Quilometragem" id="Quilometragem"  maxlength="20" required></fieldset>
        <fieldset><label for="Combustivel">Combustível</label><select name="Combustivel" id="Combustivel" required>
            <option value="Gasolina" selected>Gasolina</option>
            <option value="Álcool">Álcool</option>
            <option value="Diesel">Diesel</option>
            <option value="Elétrico">Elétrico</option>
        </select></fieldset>
        <fieldset><label for="Descricao">Descrição</label><input type="text" name="Descricao" id="Descricao"  maxlength="20" required></fieldset>
        <fieldset><label for="Imagem">Imagem</label><input type="file" name="Imagem" id="Imagem"  maxlength="20"></fieldset>
        <fieldset><input type="submit" value="Salvar"></fieldset>
        <fieldset><button type="button" onclick="window.location.href='../Veiculos.php'">Voltar</button></fieldset>
    </form>
    <script src="../../../js/mascaras.js"></script>
</body>
</html>