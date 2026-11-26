<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../../auth/authadm.php";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Veículo</title>
    <link rel="icon" type="image/svg" href="../../../img/favicon/a7seven_sem_fundo.svg">
    <link rel="stylesheet" href="../../../css/ADMnovoV.css">
    <link rel="stylesheet" href="../../../css/principal.css">
    <link rel="stylesheet" href="../../../css/admcarrosel.css">
</head>
<body>
    <?php
    if (isset($_SESSION['sucesso_cadastro'])) {
        $Mensagem =$_SESSION['sucesso_cadastro'];
        echo "<script>alert('" . htmlspecialchars($Mensagem, ENT_QUOTES, 'UTF-8') . "');</script>";
        $_SESSION['sucesso_cadastro'] = null;
    }
    ?>
    <div id="meio">
        <h1>Adicionar Veículo</h1>
    </div>
    <div class="mei">
        <div id="cadastro">
            <form method="POST" action="../../salvar/S_Veiculo.php" enctype="multipart/form-data">
                <input id="tipoCadastro" type="text" value="cadastroVeiculo" hidden>
                <div>
                    <?php echo $inputCsrf; ?>
                    <div><label for="Marca">Marca</label><input type="text" name="Marca" id="Marca" maxlength="255" required></div>
                    <div><label for="Modelo">Modelo</label><input type="text" name="Modelo" id="Modelo" maxlength="255" required></div>
                    <div><label for="Ano">Ano</label><input type="number" name="Ano" id="Ano" maxlength="4" required></div>
                    <div id="Mensagem_ano"></div>
                    <div><label for="Preco">Preço</label><input type="number" name="Preco" id="Preco" maxlength="255" required></div>
                    <div><label for="Cor">Cor</label><input type="text" name="Cor" id="Cor" maxlength="20" required></div>
                </div>
                <div>
                    <div><label for="Quilometragem">Quilometragem</label><input type="number" name="Quilometragem" id="Quilometragem" maxlength="20" required></div>
                    <div>
                        <label for="Combustivel">Combustível</label>
                        <select name="Combustivel" id="Combustivel" required>
                            <option value="Gasolina" selected>Gasolina</option>
                            <option value="Álcool">Álcool</option>
                            <option value="Diesel">Diesel</option>
                            <option value="Elétrico">Elétrico</option>
                        </select>
                    </div>

                    <div><label for="Descricao">Descrição</label><input type="text" name="Descricao" id="Descricao" maxlength="255" required></div>

                    <div>
                        <label for="Imagem">Imagens do Veículo</label>
                        <input type="file" id="Imagem" name="Imagem[]" accept="image/jpeg, image/png, image/webp" multiple required>

                        <div class="carrossel-preview">
                            <button type="button" id="btn-prev-preview" class="btn-carrossel-preview" aria-label="Anterior">&#8249;</button>
                            <div id="preview-container"></div>
                            <button type="button" id="btn-next-preview" class="btn-carrossel-preview" aria-label="Próxima">&#8250;</button>
                        </div>
                    </div>

                    <div style="color: red;">
                        <?php
                        if (isset($_SESSION['erro_cadastro'])) {
                            echo htmlspecialchars($_SESSION['erro_cadastro'], ENT_QUOTES, 'UTF-8');
                            unset($_SESSION['erro_cadastro']);
                        }
                        ?>
                    </div>
                    <div>
                        <input type="button" id="Cadastrar" class="btn" value="Salvar" onclick="validarVeiculo()">
                        <button type="button" class="btn" onclick="window.location.href='../Veiculos.php'">Voltar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="../../../js/mascaras.js"></script>
    <script src="../../../js/visualizarImagem.js"></script>
    <script src="../../../js/validarformulario.js"></script>
</body>
</html>