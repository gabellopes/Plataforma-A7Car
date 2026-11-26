<?php
session_start();
require_once "../salvar/Conexao.php";
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>
    <link rel="icon" type="image/svg" href="../../img/favicon/a7seven_sem_fundo.svg">
    <link rel="stylesheet" href="../../css/principal.css">
    <link rel="stylesheet" href="../../css/veiculo.css">
    <link rel="stylesheet" href="../../css/carrosel.css">
    <link rel="stylesheet" href="../../css/dialog.css">
</head>

<body>
    <?php
    if (isset($_SESSION['erro_cadastro'])) {
        $Mensagem = $_SESSION['erro_cadastro'];
        echo "<script>alert('" . htmlspecialchars($Mensagem, ENT_QUOTES, 'UTF-8') . "');</script>";
        unset($_SESSION['erro_cadastro']);
    }
    ?>

    <header id="cabecalho">
        <img src="../../img/logo.png" alt="" class="logo" onclick="window.location.href='../../index.php'">
        <div id="link">
            <a href="catalogo.php">CATÁLOGO</a>
            <a href="colaboradores.php">COLABORADORES</a>
            <a href="contato.php">CONTATO</a>
            <?php if (isset($_SESSION['user_email'])): ?>
                <a href="favoritos.php">FAVORITOS</a>
            <?php endif; ?>
        </div>
        <div id="linksAuth">
            <?php if (!isset($_SESSION['user_email'])): ?>
                <button id="btnEntrar" class="btn" type="button" onclick="window.location.href='Login.php'">ENTRAR</button>
                <button id="btnCadastrar" class="btn" type="button"
                    onclick="window.location.href='Cadastro.php'">CADASTRAR</button>
            <?php else: ?>
                <p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['user_nome'], ENT_QUOTES, 'UTF-8'); ?>!</p>
                <button class="btn" type="button" onclick="window.location.href='../salvar/Sair.php'">SAIR</button>
            <?php endif; ?>
        </div>
    </header>

    <br><br><br><br>
    <div class="meio">

        <a href="catalogo.php">⬅VOLTAR AO CATÁLOGO</a>
        <?php
        $row = null;
        $fotos = [];

        try {
            $id = (int) ($_GET['id'] ?? 0);

            $stmt = $sql->prepare("SELECT * FROM carro WHERE id_car = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if (!$row) {
                throw new Exception("Veículo não encontrado.");
            }

            $stmtFotos = $sql->prepare("SELECT caminho_img FROM carro_imagem WHERE id_car = ? ORDER BY id_img ASC");
            $stmtFotos->bind_param("i", $id);
            $stmtFotos->execute();
            $resFotos = $stmtFotos->get_result();

            while ($f = $resFotos->fetch_assoc()) {
                if (!empty($f['caminho_img'])) {
                    $fotos[] = $f['caminho_img'];
                }
            }

            if (empty($fotos) && !empty($row['foto_car'])) {
                $fotos[] = $row['foto_car'];
            }

            $fotoPrincipal = $fotos[0] ?? '';
            ?>
            <div>
                <?php
                if (isset($_SESSION['user_id'])) {
                    $verifica = $sql->prepare("SELECT id_fav FROM favorito WHERE id_usu = ? AND id_car = ?");
                    $verifica->bind_param("ii", $_SESSION['user_id'], $row['id_car']);
                    $verifica->execute();
                    $resultado = $verifica->get_result();

                    if ($resultado->num_rows > 0) {
                        echo "<button class='btn-favoritar' data-id='" . (int) $row['id_car'] . "'>❤️</button>";
                    } else {
                        echo "<button class='btn-favoritar' data-id='" . (int) $row['id_car'] . "'>❤</button>";
                    }
                } else {
                    echo "<button class='btn-favoritar' onclick='window.location.href=\"Login.php\"'>❤</button>";
                }
                ?>

                <div class="galeria-veiculo">
                    <div class="foto-principal-wrapper">
                        <img id="foto-principal" src="<?php echo htmlspecialchars($fotoPrincipal, ENT_QUOTES, 'UTF-8'); ?>"
                            alt="Foto do Veículo">
                    </div>

                    <?php if (count($fotos) > 1): ?>
                        <div class="carrossel-miniaturas">
                            <button type="button" class="btn-carrossel" onclick="navegarCarrossel(-1)"
                                aria-label="Anterior">&#8249;</button>

                            <div class="miniaturas-track" id="miniaturas-track">
                                <?php foreach ($fotos as $index => $caminhoFoto): ?>
                                    <img src="<?php echo htmlspecialchars($caminhoFoto, ENT_QUOTES, 'UTF-8'); ?>"
                                        alt="Miniatura <?php echo $index + 1; ?>" class="<?php echo $index === 0 ? 'ativa' : ''; ?>"
                                        onclick="selecionarFoto(<?php echo $index; ?>)">
                                <?php endforeach; ?>
                            </div>

                            <button type="button" class="btn-carrossel" onclick="navegarCarrossel(1)"
                                aria-label="Próxima">&#8250;</button>
                        </div>
                    <?php endif; ?>
                </div>

                <span></span>
                <span>Marca: <?php echo htmlspecialchars($row['marca_car'], ENT_QUOTES, 'UTF-8'); ?></span>
                <span>Modelo: <?php echo htmlspecialchars($row['modelo_car'], ENT_QUOTES, 'UTF-8'); ?></span>
                <span>R$ <?php echo number_format((float) $row['preco_car'], 2, ',', '.'); ?></span>
                <div><img src="../../img/catalogo/calendario.png"
                        alt="📅"><span><?php echo htmlspecialchars($row['ano_car'], ENT_QUOTES, 'UTF-8'); ?></span></div>
                <div><img src="../../img/catalogo/velocimetro.png"
                        alt="📅"><span><?php echo htmlspecialchars($row['quilometragem_car'], ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
                <div><img src="../../img/catalogo/gasolina.png"
                        alt="📅"><span><?php echo htmlspecialchars($row['combustivel_car'], ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
                <div><span><?php echo htmlspecialchars($row['descricao_car'], ENT_QUOTES, 'UTF-8'); ?></span></div>

                <?php
                $mensagemWhatsApp = "Olá! Tenho interesse no " . $row['marca_car'] . " " . $row['modelo_car'] . " " . $row['ano_car'] . " (R$ " . number_format((float) $row['preco_car'], 2, ',', '.') . "). Gostaria de mais informações sobre este veículo!";
                include_once "../salvar/Config/linkWhatsapp.php";
                ?>
                <button onclick="window.open('<?php echo $urlWhatsApp; ?>', '_blank');"><img src='../../img/catalogo/mensagem.png'>NEGOCIAR VIA WHATSAPP</button>

                <?php
                if (!isset($_SESSION['user_email'])) {
                    echo "<button onclick='window.location.href=\"Login.php\"'><img src='../../img/catalogo/grafico.png'>FAZER SIMULAÇÃO</button>";
                } else {
                    echo "<button id='abrirDialog'><img src='../../img/catalogo/grafico.png'>FAZER SIMULAÇÃO</button>";
                }
                ?>
            </div><!-- Fim da div do carro -->

            <dialog id="dialog">


                <div id="dialogTitulo">
                    <h1>SIMULAÇÃO -
                        <?php echo htmlspecialchars($row['marca_car'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($row['modelo_car'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($row['ano_car'], ENT_QUOTES, 'UTF-8'); ?>
                    </h1><button id="fecharDialog">X</button>
                </div>
                <hr>
                <div id="infoCar">
                    <img src="<?php echo htmlspecialchars($fotoPrincipal, ENT_QUOTES, 'UTF-8'); ?>" alt="Foto do Veículo"
                        width="200" height="150" style="object-fit: cover;">
                    <ul>
                        <li><span
                                id="carroMarca"><?php echo htmlspecialchars($row['marca_car'], ENT_QUOTES, 'UTF-8'); ?></span>
                        </li>
                        <li><span
                                id="carroModelo"><?php echo htmlspecialchars($row['modelo_car'], ENT_QUOTES, 'UTF-8'); ?></span>
                        </li>
                        <li><span id="carroPreco">R$
                                <?php echo number_format((float) $row['preco_car'], 2, ',', '.'); ?></span></li>
                    </ul>

                </div>

                <form action="../salvar/S_Simulacao.php" method="post">
                    <input id="tipoCadastro" type="text" value="simulacao" hidden>
                    <input name="id" type="text" hidden
                        value="<?php echo htmlspecialchars($row['id_car'], ENT_QUOTES, 'UTF-8'); ?>">
                    <input name="status_car" type="text" hidden
                        value="<?php echo htmlspecialchars($row['status_car'], ENT_QUOTES, 'UTF-8'); ?>">
                    <div class="campo"><label for="Nome">NOME COMPLETO*</label><input type="text" name="Nome" id="Nome"
                            maxlength="255" required placeholder="Seu nome completo"></div>

                    <div class="linha">
                        <div class="campo"><label for="DataNascimento">DATA DE NASCIMENTO</label><input type="date"
                                name="DataNascimento" id="DataNascimento" required></div>
                        <div class="campo"><label for="Cpf">CPF*</label><input type="text" name="Cpf" id="Cpf"
                                maxlength="14" required placeholder="000.000.000-00"></div>
                    </div>
                    <div id="Mensagem_data" class="Mensagem"></div>
                    <div id="Mensagem_cpf" class="Mensagem"></div>
                    <div class="campo"><label for="Telefone">TELEFONE CELULAR</label><input type="text" name="Telefone"
                            id="Telefone" maxlength="15" required placeholder="(11) 99999-9999"></div>
                    <div id="Mensagem_telefone"></div>

                    <label for="">POSSUI CNH?</label>
                    <div id="divBtnCnh" class="linha">
                        <div class="campo"><button type="button" id="temCnh">SIM</button></div>
                        <div class="campo"><button type="button" id="naoTemCnh">NÃO</button></div>
                    </div>

                    <div id="divCnh" hidden><label for="Cnh" id="labelCnh">CNH</label><input type="text" name="Cnh" id="Cnh"
                            maxlength="9" placeholder="999999999"></div>
                    <div id="Mensagem_cnh" class="Mensagem"></div>
                    <p id="legenda">Seus dados serão usados exclusivamente para contato da nossa equipe de venda.</p>
                    <input type="button" id="enviarDialog" class="btn" value="📊ENVIAR SIMULAÇÃO">
                </form>
            </dialog>

            <dialog id="dialogEmailEnviado">
                <button id="FecharDialogEmailEnviado">X</button>

                <h1>SIMULAÇÃO -
                    <?php echo htmlspecialchars($row['marca_car'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($row['modelo_car'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($row['ano_car'], ENT_QUOTES, 'UTF-8'); ?>
                </h1>
                <hr>

                <p>✔</p>
                <p>Simulação enviada</p>
                <p>Nossa equipe entrará em contato em breve</p>

                <a href="#" style="color: blue;" id="linkRedefinirSenha"></a>
            </dialog>

            <?php
        } catch (Exception $e) {
            echo "<div>Erro ao buscar veículo 🚗</div>";
        }
        ?>
    </div>

    <footer>
        <div class="fo">
            <div id="ter">
                <img src="../../img/logo.png" alt="" id="logo">
                <h3>Multimarcas premium especializada em venda</h3>
                <h3>e compra de veículos. Transparência, qualidade</h3>
                <h3>e atendimento diferenciado.</h3>
            </div>
            <div class="nav">
                <h1>NAVEGAÇÃO</h1>
                <a href="catalogo.php">CATÁLOGO</a>
                <a href="colaboradores.php">COLABORADORES</a>
                <a href="contato.php">CONTATO</a>
                <a href="../../pdf/3DSA_AP_GRUPO6.pdf" target="_blank" rel="noopener noreferrer" class="menu-link-site">MANUAL DE INSTRUÇÕES<img class="menu-icon" src="../../img/admin/ajuda.png" alt="?" style="width: 15px;"></a>
            </div>
            <div>
                <h1>CONTATO</h1>
                <h3>📞 (11) 97332-0504
                    <br>
                    aseven7multimarcas@gmail.com
                    <br>
                    📍 Estr. de Itapecerica, 4660 - Capão Redondo, São Paulo - SP, 05849-440
                </h3>
            </div>
            <div id="divadm">
                <a href="../admin/Clientes.php" id="adm">ÁREA ADMINISTRATIVA</a>
            </div>
        </div>
    </footer>

    <script>
        function trocarFotoPrincipal(miniatura) {
            document.getElementById('foto-principal').src = miniatura.src;

            document.querySelectorAll('.miniaturas-veiculo img').forEach(img => {
                img.style.border = '1px solid #ccc';
            });
            miniatura.style.border = '2px solid #007bff';
        }
    </script>
    <script src="../../js/mascaras.js"></script>
    <script src="../../js/validarformulario.js"></script>
    <script src="../../js/assets.js"></script>
</body>

</html>