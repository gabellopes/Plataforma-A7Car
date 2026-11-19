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
    <title>Editar Veículo</title>
    <link rel="stylesheet" href="../../../css/ADMnovoV.css">
    <link rel="stylesheet" href="../../../css/principal.css">
</head>
<body>
    <div id="meio">
        <h1>Editar Veículo</h1>
    </div>

    <?php
    if (isset($_SESSION['sucesso_cadastro'])) {
        $Mensagem = $_SESSION['sucesso_cadastro'];
        echo "<script>alert('" . htmlspecialchars($Mensagem, ENT_QUOTES, 'UTF-8') . "');</script>";
        $_SESSION['sucesso_cadastro'] = null;
    }

    if (isset($_GET['id'])) {
        require_once "../../salvar/Conexao.php";
        $id = (int)$_GET['id'];

        $stmt = $sql->prepare("SELECT * FROM carro WHERE id_car = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $carro = $result->fetch_assoc();

        // Busca todas as imagens já salvas desse veículo
        $stmtFotos = $sql->prepare("SELECT id_img, caminho_img FROM carro_imagem WHERE id_car = ? ORDER BY id_img ASC");
        $stmtFotos->bind_param("i", $id);
        $stmtFotos->execute();
        $resFotos = $stmtFotos->get_result();
        $fotosAtuais = [];
        while ($f = $resFotos->fetch_assoc()) {
            $fotosAtuais[] = $f;
        }
    ?>
        <div class="mei">
            <div id="cadastro">
                <form method="POST" action="../../salvar/Atualizar/AtualizarVeiculo.php" enctype="multipart/form-data">
                    <input id="tipoCadastro" type="text" value="cadastroVeiculo" hidden>
                    <input type="hidden" name="foto_car" value="<?php echo htmlspecialchars($carro['foto_car'], ENT_QUOTES, 'UTF-8'); ?>">
                    
                    <div>
                        <?php echo $inputCsrf; ?>
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($carro['id_car'], ENT_QUOTES, 'UTF-8'); ?>">
                        
                        <label for="Marca">Marca</label>
                        <input type="text" name="Marca" id="Marca" value="<?php echo htmlspecialchars($carro['marca_car'], ENT_QUOTES, 'UTF-8'); ?>" maxlength="255" required>
                        
                        <label for="Modelo">Modelo</label>
                        <input type="text" name="Modelo" id="Modelo" value="<?php echo htmlspecialchars($carro['modelo_car'], ENT_QUOTES, 'UTF-8'); ?>" maxlength="255" required>
                        
                        <label for="Ano">Ano</label>
                        <input type="text" name="Ano" id="Ano" value="<?php echo htmlspecialchars($carro['ano_car'], ENT_QUOTES, 'UTF-8'); ?>" maxlength="4" required>
                        <div id="Mensagem_ano"></div>
                        
                        <label for="Preco">Preço</label>
                        <input type="text" name="Preco" id="Preco" value="<?php echo htmlspecialchars($carro['preco_car'], ENT_QUOTES, 'UTF-8'); ?>" maxlength="20" required>
                        
                        <label for="Cor">Cor</label>
                        <input type="text" name="Cor" id="Cor" value="<?php echo htmlspecialchars($carro['cor_car'], ENT_QUOTES, 'UTF-8'); ?>" maxlength="20" required>
                    </div>

                    <div>
                        <label for="Quilometragem">Quilometragem</label>
                        <input type="text" name="Quilometragem" id="Quilometragem" value="<?php echo htmlspecialchars($carro['quilometragem_car'], ENT_QUOTES, 'UTF-8'); ?>" maxlength="20" required>
                        
                        <label for="Combustivel">Combustível</label>
                        <select name="Combustivel" id="Combustivel" required>
                            <option value="<?php echo htmlspecialchars($carro['combustivel_car'], ENT_QUOTES, 'UTF-8'); ?>" style="font-weight: bold; color: #ffffff; background-color: #ff0000;">
                                <?php echo htmlspecialchars($carro['combustivel_car'], ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                            <option value="Gasolina">Gasolina</option>
                            <option value="Álcool">Álcool</option>
                            <option value="Diesel">Diesel</option>
                            <option value="Elétrico">Elétrico</option>
                        </select>
                        
                        <label for="Descricao">Descrição</label>
                        <input type="text" name="Descricao" id="Descricao" value="<?php echo htmlspecialchars($carro['descricao_car'], ENT_QUOTES, 'UTF-8'); ?>" maxlength="255" required>
                        
                        <div>
                            <label for="Imagem">Imagens do Veículo (adicione uma por vez — a primeira será a capa)</label>
                            <input type="file" name="Imagem[]" id="Imagem" accept="image/jpeg, image/png, image/webp">

                            <!-- Guarda os IDs das imagens salvas no banco que você clicar no "×" para excluir -->
                            <div id="imagens-removidas-container"></div>

                            <!-- Container unificado: imagens já cadastradas + novas imagens adicionadas -->
                            <div id="preview-container" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 10px;">
                                <?php if (!empty($fotosAtuais)): ?>
                                    <?php foreach ($fotosAtuais as $foto): ?>
                                        <div class="preview-item imagem-existente" data-id="<?php echo (int)$foto['id_img']; ?>" style="position: relative;">
                                            <img src="<?php echo htmlspecialchars($foto['caminho_img'], ENT_QUOTES, 'UTF-8'); ?>"
                                                 alt="Foto atual"
                                                 style="width: 120px; height: 90px; object-fit: cover; border-radius: 6px; border: 1px solid #ccc; display: block;">
                                            <button type="button"
                                                    class="btn-remover-existente"
                                                    title="Remover imagem"
                                                    style="position:absolute; top:4px; right:4px; background:rgba(220,53,69,0.9); color:#fff; border:none; border-radius:50%; width:20px; height:20px; cursor:pointer; font-weight:bold; line-height:18px; padding:0;">×</button>
                                        </div>
                                    <?php endforeach; ?>
                                <?php elseif (!empty($carro['foto_car'])): ?>
                                    <!-- Fallback para carros antigos salvos antes da tabela carro_imagem -->
                                    <div class="preview-item imagem-existente" style="position: relative;">
                                        <img src="<?php echo htmlspecialchars($carro['foto_car'], ENT_QUOTES, 'UTF-8'); ?>"
                                             alt="Foto atual"
                                             style="width: 120px; height: 90px; object-fit: cover; border-radius: 6px; border: 1px solid #ccc; display: block;">
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div style="color: red;">
                                <?php
                                if (isset($_SESSION['erro_cadastro'])) {
                                    echo htmlspecialchars($_SESSION['erro_cadastro'], ENT_QUOTES, 'UTF-8');
                                    unset($_SESSION['erro_cadastro']);
                                }
                                ?>
                            </div>
                        </div>

                        <input type="button" id="Cadastrar" class="btn" value="Salvar" onclick="return confirm('Tem certeza que deseja salvar as alterações?') ? validarVeiculo() : false;">
                        <button type="button" class="btn" onclick="window.location.href='../../admin/Veiculos.php'">Voltar</button>
                    </div>
                </form>
            </div>
        </div>
    <?php } else { ?>
        <p>Veículo não encontrado.</p>
    <?php } ?>

    <script src="../../../js/mascaras.js"></script>
    <script src="../../../js/visualizarImagem.js"></script>
    <script src="../../../js/validarformulario.js"></script>
</body>
</html>