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
    <title>Editar Colaborador</title>
    <link rel="stylesheet" href="../../../css/ADMnovoC.css">
    <link rel="stylesheet" href="../../../css/principal.css">
</head>
<body>
    <div id="meio">
        <h1>Editar Colaborador</h1>
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
        $stmt = $sql->prepare("SELECT * FROM colaborador WHERE id_col = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $colaborador = $result->fetch_assoc();
    ?>
        <div class="mei">
        <div id="cadastro">
    <form method="Post" action="../Atualizar/AtualizarColaborador.php" enctype="multipart/form-data">
        <div>
        <input type="hidden" name="id" value="<?php echo $colaborador['id_col']; ?>">
        <label for="Nome">Nome</label><input type="text" name="Nome" id="Nome"  value="<?php echo $colaborador['nome_col']; ?>" maxlength="20" required>
        <label for="Email">Email</label><input type="email" name="Email" id="Email"  value="<?php echo $colaborador['email_col']; ?>" required>
        <div id="Mensagem_email"></div>
        <label for="Telefone">Telefone</label><input type="text" name="Telefone" id="Telefone"  value="<?php echo $colaborador['telefone_col']; ?>" maxlength="15" required>
        <div id="Mensagem_telefone"></div>
        <label for="Imagem">Foto</label><input type="file" name="Foto" id="Foto"  maxlength="255">
        <div id="Mensagem_imagem"></div>
        <label for="Servico">Serviço</label><input type="text" name="Servico" id="Servico"  value="<?php echo $colaborador['servico_col']; ?>" maxlength="255" required>
        <label for="Descricao">Descrição</label><input type="text" name="Descricao" id="Descricao"  value="<?php echo $colaborador['descricao_col']; ?>" maxlength="255" required>

        <input type="button" class="btn" value="Salvar" id="Cadastrar" onclick="return confirm('Tem certeza que deseja atualizar este colaborador?') ? validarColaborador() :  true;">
        <button type="button" class="btn"onclick="window.location.href='../../admin/Colaboradores.php'">Voltar</button>
        </div>
    </form>
        </div>
        </div>
    <?php }else{ ?>
        <p>Colaborador não encontrado.</p>
    <?php } ?>
    <script src="../../../js/mascaras.js"></script>
    <script src="../../../js/validarformulario.js"></script>
</body>
</html>