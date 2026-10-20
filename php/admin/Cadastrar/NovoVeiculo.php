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
    <link rel="stylesheet" href="../../../css/ADMnovoV.css">
    <link rel="stylesheet" href="../../../css/principal.css">
</head>
<body>
    <?php
         if(isset($_SESSION['sucesso_cadastro'])){
            $Mensagem = $_SESSION['sucesso_cadastro'];
            echo "<script>alert('$Mensagem');</script>"; 
            $_SESSION['sucesso_cadastro'] = null;
        }
    ?>
    <div id="meio">
    <h1>Adicionar Veículo</h1>
    </div>
    <div class="mei">
    <div id="cadastro">
      
    <form method="POST" action="../../salvar/S_Veiculo.php">
        <div>
        <div><label for="Marca">Marca</label><input type="text" name="Marca" id="Marca"  maxlength="20" required></div>
        <div><label for="Modelo">Modelo</label><input type="text" name="Modelo" id="Modelo"  maxlength="20" required></div>
        <div><label for="Ano">Ano</label><input type="number" name="Ano" id="Ano"  maxlength="4" required></div>
        <div><label for="Preco">Preço</label><input type="number" name="Preco" id="Preco"  maxlength="20" required></div>
        <div><label for="Cor">Cor</label><input type="text" name="Cor" id="Cor"  maxlength="20" required></div>
        </div>
        <div>
        <div><label for="Quilometragem">Quilometragem</label><input type="number" name="Quilometragem" id="Quilometragem"  maxlength="20" required></div>
        <div><label for="Combustivel">Combustível</label>
            <select name="Combustivel" id="Combustivel" required>
            <option value="Gasolina" selected>Gasolina</option>
            <option value="Álcool">Álcool</option>
            <option value="Diesel">Diesel</option>
            <option value="Elétrico">Elétrico</option>
            </select>
        </div>
        <div><label for="Descricao">Descrição</label><input type="text" name="Descricao" id="Descricao"  maxlength="20" required></div>
        <div><label for="Imagem">Imagem</label><input type="file" name="Imagem" id="Imagem"  maxlength="20"></div>
        <div>
        <input type="submit" class="btn" value="Salvar">
        <button type="button" class="btn" onclick="window.location.href='../Veiculos.php'">Voltar</button>
        </div>
        </div>

    </form>
    <script src="../../../js/mascaras.js"></script>


    </div>
    </div>
</body>
</html>