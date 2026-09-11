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
</head>
<body>
<?php
         if(isset($_SESSION['sucesso_cadastro'])){
            $Mensagem = $_SESSION['sucesso_cadastro'];
            echo "<script>alert('$Mensagem');</script>"; 
            $_SESSION['sucesso_cadastro'] = null;
        }
    ?>
      <h1>Adicionar Colaborador</h1>
    <form method="Post" action="../../salvar/S_Colaborador.php">
        <fieldset><label for="Nome">Nome</label><input type="text" name="Nome" id="Nome"  maxlength="20" required></fieldset>
        <fieldset><label for="Email">Email</label><input type="email" name="Email" id="Email"  required></fieldset>
        <div id="Mensagem_email"></div>
        <fieldset><label for="Telefone">Telefone</label><input type="text" name="Telefone" id="Telefone"  maxlength="15" required></fieldset>
        <div id="Mensagem_telefone"></div>
        <fieldset><label for="Imagem">Foto</label><input type="file" name="Foto" id="Foto"  maxlength="255"></fieldset>
        <fieldset><label for="Servico">Serviço</label><input type="text" name="Servico" id="Servico"  maxlength="255" required></fieldset>
        <fieldset><label for="Descricao">Descrição</label><input type="text" name="Descricao" id="Descricao"  maxlength="255" required></fieldset>

        <fieldset><input type="button" id="Cadastrar" onclick="validarColaborador()" value="Salvar"></fieldset>
        <fieldset><button type="button" onclick="window.location.href='../Colaboradores.php'">Voltar</button></fieldset>
    </form>
    <script src="../../../js/mascaras.js"></script>
    <script src="../../../js/validarformulario.js"></script>
    </body>
</body>
</html>