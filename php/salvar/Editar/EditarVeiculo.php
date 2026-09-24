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
    <link rel="stylesheet" href="../../../css/ADMnovoV.css">
    <link rel="stylesheet" href="../../../css/principal.css">
</head>
<body>
    <div id="meio">
        <h1>Editar Veiculo</h1>
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
        $stmt = $sql->prepare("SELECT * FROM carro WHERE id_car = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $carro = $result->fetch_assoc();
    ?>
        <div class="mei">
        <div id="cadastro">
    <form method="POST" action="../../salvar/Atualizar/AtualizarVeiculo.php">
        <div>
        <input type="hidden" name="id" value="<?php echo $carro['id_car']; ?>">
        <label for="Marca">Marca</label><input type="text" name="Marca" id="Marca"  value="<?php echo $carro['marca_car']; ?>" maxlength="20" required>
        <label for="Modelo">Modelo</label><input type="text" name="Modelo" id="Modelo"  value="<?php echo $carro['modelo_car']; ?>" maxlength="20" required>
        <label for="Ano">Ano</label><input type="text" name="Ano" id="Ano"  value="<?php echo $carro['ano_car']; ?>" maxlength="4" required>
        <label for="Preco">Preço</label><input type="text" name="Preco" id="Preco"  value="<?php echo $carro['preco_car']; ?>" maxlength="20" required>
        <label for="Cor">Cor</label><input type="text" name="Cor" id="Cor"  value="<?php echo $carro['cor_car']; ?>" maxlength="20" required>
        </div>
        <div>
        <label for="Quilometragem">Quilometragem</label><input type="text" name="Quilometragem" id="Quilometragem"  value="<?php echo $carro['quilometragem_car']; ?>" maxlength="20" required>
        <label for="Combustivel">Combustível</label><select name="Combustivel" id="Combustivel" value="<?php echo $carro['combustivel_car']; ?>" required>
            <option value="<?php echo $carro['combustivel_car']; ?>" style="font-weight: bold; color: #ffffff; background-color: #ff0000;"><?php echo $carro['combustivel_car']; ?></option>
            <option value="Gasolina">Gasolina</option>
            <option value="Álcool">Álcool</option>
            <option value="Diesel">Diesel</option>
            <option value="Elétrico">Elétrico</option>
        </select>
        <label for="Descricao">Descrição</label><input type="text" name="Descricao" id="Descricao"  value="<?php echo $carro['descricao_car']; ?>" maxlength="20" required>
        <label for="Imagem">Imagem</label><input type="file" name="Imagem" id="Imagem"  maxlength="20">
        <input type="button" class="btn" value="Salvar" onclick="return confirm('Tem certeza que deseja salvar as alterações?') ? document.forms[0].submit() : false;">
        <button type="button" class="btn" onclick="window.location.href='../../admin/Veiculos.php'">Voltar</button>
        </div>
    </form>
        </div>
        </div>
    <?php }else{ ?>
        <p>Veículo não encontrado.</p>
    <?php } ?>
</body>
</html>