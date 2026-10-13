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
    echo "<script>alert('" . htmlspecialchars($Mensagem, ENT_QUOTES, 'UTF-8') . "');</script>";
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
    <form method="POST" action="../../salvar/Atualizar/AtualizarVeiculo.php" enctype="multipart/form-data">
        <input id="tipoCadastro" type="text" value="cadastroVeiculo" hidden>
        <div>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($carro['id_car'], ENT_QUOTES, 'UTF-8'); ?>">
        <label for="Marca">Marca</label><input type="text" name="Marca" id="Marca"  value="<?php echo htmlspecialchars($carro['marca_car'], ENT_QUOTES, 'UTF-8'); ?>" maxlength="255" required>
        <label for="Modelo">Modelo</label><input type="text" name="Modelo" id="Modelo"  value="<?php echo htmlspecialchars($carro['modelo_car'], ENT_QUOTES, 'UTF-8'); ?>" maxlength="255" required>
        <label for="Ano">Ano</label><input type="text" name="Ano" id="Ano"  value="<?php echo htmlspecialchars($carro['ano_car'], ENT_QUOTES, 'UTF-8'); ?>" maxlength="4" required>
        <div id="Mensagem_ano"></div>
        <label for="Preco">Preço</label><input type="text" name="Preco" id="Preco"  value="<?php echo htmlspecialchars($carro['preco_car'], ENT_QUOTES, 'UTF-8'); ?>" maxlength="20" required>
        <label for="Cor">Cor</label><input type="text" name="Cor" id="Cor"  value="<?php echo htmlspecialchars($carro['cor_car'], ENT_QUOTES, 'UTF-8'); ?>" maxlength="20" required>
        </div>
        <div>
        <label for="Quilometragem">Quilometragem</label><input type="text" name="Quilometragem" id="Quilometragem"  value="<?php echo htmlspecialchars($carro['quilometragem_car'], ENT_QUOTES, 'UTF-8'); ?>" maxlength="20" required>
        <label for="Combustivel">Combustível</label><select name="Combustivel" id="Combustivel" value="<?php echo htmlspecialchars($carro['combustivel_car'], ENT_QUOTES, 'UTF-8'); ?>" required>
            <option value="<?php echo htmlspecialchars($carro['combustivel_car'], ENT_QUOTES, 'UTF-8'); ?>" style="font-weight: bold; color: #ffffff; background-color: #ff0000;"><?php echo htmlspecialchars($carro['combustivel_car'], ENT_QUOTES, 'UTF-8'); ?></option>
            <option value="Gasolina">Gasolina</option>
            <option value="Álcool">Álcool</option>
            <option value="Diesel">Diesel</option>
            <option value="Elétrico">Elétrico</option>
        </select>
        <label for="Descricao">Descrição</label><input type="text" name="Descricao" id="Descricao"  value="<?php echo htmlspecialchars($carro['descricao_car'], ENT_QUOTES, 'UTF-8'); ?>" maxlength="20" required>
        <div>
            <label for="Imagem">Imagem</label>
            <img id="preview-imagem" src="<?php echo !empty($carro['foto_car']) ? htmlspecialchars($carro['foto_car'], ENT_QUOTES, 'UTF-8') : '#'; ?>" alt="Pré-visualização da imagem" style="max-width: 200px; <?php echo empty($carro['foto_car']) ? 'display: none;' : 'display: block;'; ?> border-radius: 5px; border: 1px solid #ccc;" />
            <input type="file" name="Imagem" id="Imagem"  maxlength="20">

            <div style="color: red;"><?php if (isset($_SESSION['erro_cadastro'])){echo htmlspecialchars($_SESSION['erro_cadastro'], ENT_QUOTES, 'UTF-8');unset($_SESSION['erro_cadastro']);} ?></div>
        </div>
        <input type="button" id="Cadastrar" class="btn" value="Salvar" onclick="return confirm('Tem certeza que deseja salvar as alterações?') ? validarVeiculo() : false;">
        <button type="button" class="btn" onclick="window.location.href='../../admin/Veiculos.php'">Voltar</button>
        </div>
    </form>
        </div>
        </div>
    <?php }else{ ?>
        <p>Veículo não encontrado.</p>
    <?php } ?>
    <script src="../../../js/mascaras.js"></script>
    <script src="../../../js/visualizarImagem.js"></script>
    <script src="../../../js/validarformulario.js"></script>

</body>
</html>