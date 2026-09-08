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
    <title>Admin Colaboradores</title>
</head>
<body>
    <?php include __DIR__ . "/_Aside.php"; ?>
    <div id="CM">
        <div id="CSM">
            <div id="CT">
                <h1>COLABORADORES</h1>
                <button onclick="window.location.href='Cadastrar/NovoColaborador.php'">NOVO COLABORADOR</button>
            </div>

            <div id="CE">
                <table>
                <tr>
                    <td>NOME</td>
                    <td>SERVIÇO</td>
                    <td>TELEFONE</td>
                    <td>E-MAIL</td>
                    <td></td>
                    <td></td>
                </tr>

                 <?php
                include_once "../salvar/Conexao.php";

                $stmt = $sql->prepare("SELECT * FROM colaborador ");
                $stmt->execute();
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc()){
                    
                    echo "
                    <tr>
                        <td>".$row['nome_col']."</td>
                        <td>".$row['servico_col']."</td>
                        <td>".$row['telefone_col']."</td>
                        <td>".$row['email_col']."</td>
                        <td>
                            <button onclick=\"location.href='Editar/EditarCliente.php?id=".$row['id_col']."'\">⚙</button>
                            <button onclick=\"location.href='Excluir/ExcluirCliente.php?id=".$row['id_col']."'\">🧨</button>
                        </td>
                    </tr>";
                }
                ?>
                </table>
            </div>

        </div>

    </div>
</body>
</html>
