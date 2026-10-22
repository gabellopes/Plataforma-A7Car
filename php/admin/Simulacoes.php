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
    <title>Admin Simulações</title>
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
            <div id="meio">
                <div id="titulo">
                <h1>SIMULAÇÕES</h1>
                </div>
            <div id="CE">
                <table>
                <tr>
                    <td>DATA</td>
                    <td>CLIENTE</td>
                    <td>CPF</td>
                    <td>NASCIMENTO</td>
                    <td>E-MAIL</td>
                    <td>TELEFONE</td>
                    <td>CNH</td>
                    <td>VEICULO</td>
                    <!--<td>EXCLUIR</td>-->

                </tr>
                <?php
                include_once "../salvar/Conexao.php";

                $stmt = $sql->prepare("SELECT * FROM simulacao s INNER JOIN usuario u ON s.id_usu = u.id_usu INNER JOIN carro c ON s.id_car = c.id_car ORDER BY data_simu DESC");
                $stmt->execute();
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc()){
                    
                    echo "
                    <tr>
                        <td>".htmlspecialchars($row['data_simu'], ENT_QUOTES, 'UTF-8')."</td>
                        <td>".htmlspecialchars($row['nome_comple_simu'], ENT_QUOTES, 'UTF-8')."</td>
                        <td>".htmlspecialchars($row['cpf_simu'], ENT_QUOTES, 'UTF-8')."</td>
                        <td>".htmlspecialchars($row['data_nasci_simu'])."</td>
                        <td>".htmlspecialchars($row['email_usu'])."</td>
                        <td>".htmlspecialchars($row['telefone_simu'])."</td>
                        <td>".htmlspecialchars($row['cnh_simu'], ENT_QUOTES, 'UTF-8')."</td>
                        <td>".htmlspecialchars($row['marca_car'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($row['modelo_car'], ENT_QUOTES, 'UTF-8') . " " . htmlspecialchars($row['ano_car'], ENT_QUOTES, 'UTF-8')."</td>
                    </tr>";
                }
                ?>
                </table>

		 

            </div><!-- Final da tabela--> 
        </div> <!-- Final VT-->
            
</body>