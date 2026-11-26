<?php
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
    
   require_once "../auth/authadm.php";
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Colaboradores</title>
    <link rel="icon" type="image/svg" href="../../img/favicon/a7seven_sem_fundo.svg">
    <link rel="stylesheet" href="../../css/adimin.css">
    <link rel="stylesheet" href="../../css/ADMcolaboradores.css">
</head>
<body>
    <?php 
    include __DIR__ . "/_Aside.php"; 
    
        if(isset($_SESSION['sucesso_cadastro'])){
            $Mensagem = $_SESSION['sucesso_cadastro'];
            echo "<script>alert('" . htmlspecialchars($Mensagem, ENT_QUOTES, 'UTF-8') . "');</script>"; 
            $_SESSION['sucesso_cadastro'] = null;
        }

        
         if(isset($_SESSION['erro_cadastro'])){
            $Mensagem = $_SESSION['erro_cadastro'];
            echo "<script>alert('" . htmlspecialchars($Mensagem, ENT_QUOTES, 'UTF-8') . "');</script>"; 
            unset($_SESSION['erro_cadastro']);
        }
    ?>
        <div id="meio">
            <div id="titulo">
                <h1>COLABORADORES</h1>
                <button class="btn" onclick="window.location.href='Cadastrar/NovoColaborador.php'"> <img src="../../img/admin/novo.png" alt="">  NOVO COLABORADOR</button>
            </div>
            <br>
            <button onclick="window.open('../salvar/Relatorios/relatorio_colaborador.php', '_blank')" class="btn"><img src="../../img/admin/pdf.png" alt=""> GERAR RELATORIO</button>
            <div id="CE">
                <table>
                <tr>
                    <td>FOTO</td>
                    <td>NOME</td>
                    <td>SERVIÇO</td>
                    <td>TELEFONE</td>
                    <td>E-MAIL</td>
                    <td>EDITAR</td>
                    <td>EXCLUIR</td>
                </tr>
		<?php
                include_once "../salvar/Conexao.php";

                $stmt = $sql->prepare("SELECT * FROM colaborador ");
                $stmt->execute();
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc()){
                $caminho = $row['foto_col'];
                    echo "
                    <tr>
                        <td><img src='" . htmlspecialchars($row['foto_col'], ENT_QUOTES, 'UTF-8') . "' alt='Foto do Colaborador' id='foto'></td>
                        <td>".htmlspecialchars($row['nome_col'], ENT_QUOTES, 'UTF-8')."</td>
                        <td>".htmlspecialchars($row['servico_col'], ENT_QUOTES, 'UTF-8')."</td>
                        <td>".htmlspecialchars($row['telefone_col'])."</td>
                        <td>".htmlspecialchars($row['email_col'], ENT_QUOTES, 'UTF-8')."</td>
                        <td>
                            <button onclick=\"location.href='../salvar/Editar/EditarColaborador.php?id=".$row['id_col']."'\"><img src='../../img/admin/edit.png' alt='editar' class='icone-tabela'></button>
                        </td>
                        <td>
                            <button onclick=\"return confirm('Tem certeza que deseja excluir este colaborador?') ? location.href='../salvar/Excluir/ExcluirColaborador.php?id=".$row['id_col']."&caminho=".$caminho."' : false;\"><img src='../../img/admin/lixeira.png' alt='editar' class='icone-tabela'></button>
                        </td>
                    </tr>";
                }
                ?>
                </table>
            </div>

        </div>
</body>
</html>
