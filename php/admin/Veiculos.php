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
    <link rel="stylesheet" href="../../css/adimin.css">
    <link rel="stylesheet" href="../../css/ADMveiculos.css">
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
                <h1>VEICULOS</h1>
                <button class="btn" onclick="location.href='Cadastrar/NovoVeiculo.php'">NOVO VEICULO</button>
                </div>
            <div id="CE">
                <table>
                <tr>
                    <td>FOTO</td>
                    <td>MARCA</td>
                    <td>NOME</td>
                    <td>ANO</td>
                    <td>KM</td>
                    <td>COMBUSTIVEL</td>
                    <td>VALOR</td>
                    <td>ATUALIZADO</td>
                    <td>EDITAR</td>
                    <td>VENDER</td>
                    <td>EXCLUIR</td>
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
                        <td>".$row['marca_car']."</td>
                        <td>".$row['modelo_car']."</td>
                        <td>".$row['ano_car']."</td>
                        <td>".$row['quilometragem_car']."</td>
                        <td>".$row['combustivel_car']."</td>
                        <td>".$row['preco_car']."</td>
                        <td>"."07/09/26"."</td>
                        <td>
                            <button onclick=\"location.href='../salvar/Editar/EditarVeiculo.php?id=".$row['id_car']."'\">⚙</button>
                        </td>
                                                <td>
                            <button>🟩</button>
                        </td>
                        <td>
                        <button onclick=\"return confirm('Tem certeza que deseja excluir este veículo?') ? location.href='../salvar/Excluir/ExcluirVeiculo.php?id=".$row['id_car']."' : false;\">🧨</button>
                        </td>
                    </tr>";
                     
                }
                ?>
                </table>
            </div><!-- Final da tabela--> 
        </div> <!-- Final VT-->
</body>
</html>