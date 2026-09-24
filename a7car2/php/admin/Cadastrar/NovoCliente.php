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
    <title>Adicionar Cliente</title>
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
    <h1>Adicionar Cliente</h1>
    </div>
    <div class="mei">
    <div id="cadastro">

    <form method="Post" action="../../salvar/S_Cliente.php">
        <label for="Nome">Nome</label><input type="text" name="Nome" id="Nome"  maxlength="20" required><br>
        <label for="Email">Email</label><input type="email" name="Email" id="Email"  required>
        <div id="Mensagem_email"></div>
        <label for="Telefone">Telefone</label><input type="text" name="Telefone" id="Telefone" id="Telefone" maxlength="15" required>
        <div id="Mensagem_telefone"></div>
        <label for="Cpf">CPF</label><input type="text" name="Cpf" id="Cpf" maxlength="14" required>
        <div id="Mensagem_cpf"></div>
        <label for="Cnh">CNH</label><input type="text" name="Cnh" id="Cnh" maxlength="9"  required>
        <div id="Mensagem_cnh"></div>
        <div>
        <input type="button" class="btn" onclick="validarCliente()" value="Salvar">
        <button type="button" class="btn" onclick="window.location.href='../Clientes.php'">Voltar</button>
        </div>
    </form>

    </div>
    </div>
    <script src="../../../js/mascaras.js"></script>
    <script src="../../../js/validarformulario.js"></script>
</body>
</html>