<?php
    SESSION_START();
    
    if($_SESSION['user_email'] !== 'admin@gmail.com'){
            header("Location: ../user/Login.php");
            exit;
        }
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Clientes</title>
    <link rel="stylesheet" href="../../css/adimin.css">
    <link rel="stylesheet" href="../../css/ADMclientes.css">
</head>
<body>
    <?php include __DIR__ . "/_Aside.php"; 
        if(isset($_SESSION['sucesso_cadastro'])){
            $Mensagem = $_SESSION['sucesso_cadastro'];
            echo "<script>alert('" . htmlspecialchars($Mensagem, ENT_QUOTES, 'UTF-8') . "');</script>"; 
            $_SESSION['sucesso_cadastro'] = null;
        }
    
    ?>
     <?php
         if(isset($_SESSION['erro_cadastro'])){
            $Mensagem = $_SESSION['erro_cadastro'];
            echo "<script>alert('" . htmlspecialchars($Mensagem, ENT_QUOTES, 'UTF-8') . "');</script>"; 
            unset($_SESSION['erro_cadastro']);
        }
    ?>
            <div id="meio">
                <div id="titulo">
                <h1>CLIENTE</h1>
                <button class="btn" onclick="window.location.href='Cadastrar/NovoCliente.php'"> + NOVO CLIENTE</button>
                </div>
            <div id="CE">
                <table>
                <tr>
                    <td>NOME</td>
                    <td>CPF</td>
                    <td>TELEFONE</td>
                    <td>E-MAIL</td>
                    <td>CNH</td>
                    <td>EDITAR</td>
                    <td>EXCLUIR</td>

                </tr>
                <?php
                include_once "../salvar/Conexao.php";

                $stmt = $sql->prepare("SELECT * FROM cliente ");
                $stmt->execute();
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc()){
                    
                    echo "
                    <tr>
                        <td>".htmlspecialchars($row['nome_cli'], ENT_QUOTES, 'UTF-8')."</td>
                        <td>".htmlspecialchars($row['cpf_cli'])."</td>
                        <td>".htmlspecialchars($row['telefone_cli'])."</td>
                        <td>".htmlspecialchars($row['email_cli'], ENT_QUOTES, 'UTF-8')."</td>
                        <td>".htmlspecialchars($row['cnh_cli'])."</td>
                        <td>
                            <button onclick=\"location.href='../salvar/Editar/EditarCliente.php?id=".htmlspecialchars($row['id_cli'])."'\">⚙</button>
                        </td>
                        <td>
                            <button onclick=\"return confirm('Tem certeza que deseja excluir este cliente?') ? location.href='../salvar/Excluir/ExcluirCliente.php?id=".$row['id_cli']."' : false;\">🧨</button>
                        </td>
                    </tr>";
                }
                ?>
                </table>

		 

            </div><!-- Final da tabela--> 
        </div> <!-- Final VT-->
            
</body>