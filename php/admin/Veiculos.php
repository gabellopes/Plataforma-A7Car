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
    <title>Admin Veiculos</title>
</head>
<body>
<?php include __DIR__ . "/_Aside.php"; ?>
    <div id="VM">
        <div id="VSM">
            <div id="VT">
                <h1>VEÍCULOS</h1>
                <button onclick="location.href='Cadastrar/NovoVeiculo.php'">NOVO VEÍCULO</button>
            </div> <!-- Final VT-->

            <div id="VT2"></div>

            <div id="VE">
                <table>
                <tr>
                    <td>NOME</td>
                    <td>CPF</td>
                    <td>TELEFONE</td>
                    <td>E-MAIL</td>
                    <td>CNG</td>
                    <td>FORMA DE PAGAMENTO</td>
                    <td>BUTÕES</td>
                </tr>
                <?php
                include_once "../salvar/Conexao.php";

                $stmt = $sql->prepare("SELECT * FROM carro ");
                $stmt->execute();
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc()){
                    
                    echo "
                    <tr>
                        <td>".$row['foto_car']."</td>
                        <td>".$row['modelo_car']."</td>
                        <td>".$row['ano_car']."</td>
                        <td>".$row['quilometragem_car']."</td>
                        <td>".$row['combustivel_car']."</td>
                        <td>".$row['preco_car']."</td>
                        <td>"."07/09/26"."</td>
                        <td>
                            <button onclick=\"location.href='../salvar/Editar/EditarVeiculo.php?id=".$row['id_car']."'\">⚙</button>
                            <button onclick=\"return confirm('Tem certeza que deseja excluir este veículo?') ? location.href='../salvar/Excluir/ExcluirVeiculo.php?id=".$row['id_car']."' : false;\">🧨</button>
                        </td>
                    </tr>";
                }
                ?>
                </table>
            </div><!-- Final da tabela-->

        </div><!-- Final do SubMain-->

    </div><!-- Final da Main-->
</body>
</html>