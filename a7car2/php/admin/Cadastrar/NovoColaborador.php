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
    <title>Adicionar Colaborador</title>
    <link rel="stylesheet" href="../../../css/ADMnovo.css">
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
    <h1>Adicionar Colaborador</h1>
    </div>
    <div class="mei">
    <div id="cadastro">
    
    <form method="Post" action="../../salvar/S_Colaborador.php">
        <label for="Nome">Nome</label><input type="text" name="Nome" id="Nome"  maxlength="20" required>
        <label for="Email">Email</label><input type="email" name="Email" id="Email"  required>
        <div id="Mensagem_email"></div>
        <label for="Telefone">Telefone</label><input type="text" name="Telefone" id="Telefone"  maxlength="15" required>
        <div id="Mensagem_telefone"></div>
        <label for="Imagem">Foto</label><input type="file" name="Foto" id="Foto"  maxlength="255">
        <label for="Servico">Serviço</label><input type="text" name="Servico" id="Servico"  maxlength="255" required>
        <label for="Descricao">Descrição</label><input type="text" name="Descricao" id="Descricao"  maxlength="255" required>
        <div>
        <input type="button" class="btn" onclick="validarColaborador()" value="Salvar">
        <button type="button" class="btn" onclick="window.location.href='../Colaboradores.php'">Voltar</button>
        </div>
    </form>
    </div>
    </div>

    <script src="../../../js/mascaras.js"></script>
    <script src="../../../js/validarformulario.js"></script>
    </body>
</body>
</html>