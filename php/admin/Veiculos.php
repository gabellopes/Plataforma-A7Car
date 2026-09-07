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

            <div id="VT2"><h1>CLIENTES CADASTRADOS</h1></div>

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
                </table>
            </div><!-- Final da tabela-->

        </div><!-- Final do SubMain-->

    </div><!-- Final da Main-->
</body>
</html>