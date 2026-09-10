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
    <title>Editar Veículo</title>
</head>
<body>
      <h1>Editar Veículo</h1>
       <?php 
    if(isset($_GET['id'])){
        
        require_once "../../salvar/Conexao.php";
        $id = $_GET['id'];
        $stmt = $sql->prepare("SELECT * FROM carro WHERE id_car = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $carro = $result->fetch_assoc();
     ?>
    <form method="POST" action="../../salvar/Atualizar/AtualizarVeiculo.php">
        <input type="hidden" name="id" value="<?php echo $carro['id_car']; ?>">
        <fieldset><label for="Marca">Marca</label><input type="text" name="Marca" id="Marca"  value="<?php echo $carro['marca_car']; ?>" maxlength="20" required></fieldset>
        <fieldset><label for="Modelo">Modelo</label><input type="text" name="Modelo" id="Modelo"  value="<?php echo $carro['modelo_car']; ?>" maxlength="20" required></fieldset>
        <fieldset><label for="Ano">Ano</label><input type="number" name="Ano" id="Ano"  value="<?php echo $carro['ano_car']; ?>" maxlength="4" required></fieldset>
        <fieldset><label for="Preco">Preço</label><input type="number" name="Preco" id="Preco"  value="<?php echo $carro['preco_car']; ?>" maxlength="20" required></fieldset>
        <fieldset><label for="Cor">Cor</label><input type="text" name="Cor" id="Cor"  value="<?php echo $carro['cor_car']; ?>" maxlength="20" required></fieldset>
        <fieldset><label for="Quilometragem">Quilometragem</label><input type="number" name="Quilometragem" id="Quilometragem"  value="<?php echo $carro['quilometragem_car']; ?>" maxlength="20" required></fieldset>
        <fieldset><label for="Combustivel">Combustível</label><select name="Combustivel" id="Combustivel" value="<?php echo $carro['combustivel_car']; ?>" required>
            <option value="<?php echo $carro['combustivel_car']; ?>" style="font-weight: bold; color: #ffffff; background-color: #ff0000;"><?php echo $carro['combustivel_car']; ?></option>
            <option value="Gasolina">Gasolina</option>
            <option value="Álcool">Álcool</option>
            <option value="Diesel">Diesel</option>
            <option value="Elétrico">Elétrico</option>
        </select></fieldset>
        <fieldset><label for="Descricao">Descrição</label><input type="text" name="Descricao" id="Descricao"  value="<?php echo $carro['descricao_car']; ?>" maxlength="20" required></fieldset>
        <fieldset><label for="Imagem">Imagem</label><input type="file" name="Imagem" id="Imagem"  maxlength="20"></fieldset>
        <fieldset><input type="button" value="Salvar" onclick="return confirm('Tem certeza que deseja salvar as alterações?') ? document.forms[0].submit() : false;"></fieldset>
        <fieldset><button type="button" onclick="window.location.href='../../admin/Veiculos.php'">Voltar</button></fieldset>
    </form>
    <?php }else{ ?>
        <p>Veículo não encontrado.</p>
    <?php } ?>
</body>
</html>