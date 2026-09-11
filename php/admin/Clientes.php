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
    <?php include __DIR__ . "/_Aside.php"; ?>
            <div id="meio">
                <div id="titulo">
                <h1>CLIENTE</h1>
                <button class="btn" onclick="window.location.href='Cadastrar/NovoCliente.php'">NOVO CLIENTE</button>
                </div>
            <div id="CE">
                <table>
                <tr>
                    <td>NOME</td>
                    <td>CPF</td>
                    <td>TELEFONE</td>
                    <td>E-MAIL</td>
                    <td>CNH</td>
                    <td>FORMA DE PAGAMENTO</td>
                    <td>BUTÕES</td>
                </tr>
                </table>

		 <?php
                include_once "../salvar/Conexao.php";

                $stmt = $sql->prepare("SELECT * FROM cliente ");
                $stmt->execute();
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc()){
                    
                    echo "
                    <tr>
                        <td>".$row['nome_cli']."</td>
                        <td>".$row['cpf_cli']."</td>
                        <td>".$row['telefone_cli']."</td>
                        <td>".$row['email_cli']."</td>
                        <td>".$row['cnh_cli']."</td>
                        <td>
                            <button onclick=\"location.href='Editar/EditarCliente.php?id=".$row['id_cli']."'\">⚙</button>
                            <button onclick=\"location.href='Excluir/ExcluirCliente.php?id=".$row['id_cli']."'\">🧨</button>
                        </td>
                    </tr>";
                }
                ?>

            </div><!-- Final da tabela--> 
        </div> <!-- Final VT-->
            
</body>