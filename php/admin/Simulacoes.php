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
            echo "<script>alert('$Mensagem');</script>"; 
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
                    <td>CNH</td>
                    <td>VEICULO</td>
                    <td>EXCLUIR</td>

                </tr>
                <?php
                include_once "../salvar/Conexao.php";

                $stmt = $sql->prepare("SELECT * FROM simulacao ");
                $stmt->execute();
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc()){
                    
                    echo "
                    <tr>
                        
                    </tr>";
                }
                ?>
                </table>

		 

            </div><!-- Final da tabela--> 
        </div> <!-- Final VT-->
            
</body>