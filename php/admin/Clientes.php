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

<style>
    #modal{
        margin-top: 15vw;
        margin-left: 29vw;
        width: 30vw;
        background-color: blue;
 

    }
</style>
    <?php include __DIR__ . "/_Aside.php"; 
        if(isset($_SESSION['sucesso_cadastro'])){
            $Mensagem = $_SESSION['sucesso_cadastro'];
            echo "<script>alert('$Mensagem');</script>"; 
            $_SESSION['sucesso_cadastro'] = null;
        }
    
    ?>
            <div id="meio">
                <div id="titulo">
                <h1>CLIENTE</h1>
                <button class="btn" id="btnabrir"> + NOVO CLIENTE</button>
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
                        <td>".$row['nome_cli']."</td>
                        <td>".$row['cpf_cli']."</td>
                        <td>".$row['telefone_cli']."</td>
                        <td>".$row['email_cli']."</td>
                        <td>".$row['cnh_cli']."</td>
                        <td>
                            <button onclick=\"location.href='../salvar/Editar/EditarCliente.php?id=".$row['id_cli']."'\">⚙</button>
                        </td>
                        <td>
                            <button onclick=\"return confirm('Tem certeza que deseja excluir este cliente?') ? location.href='../salvar/Excluir/ExcluirCliente.php?id=".$row['id_cli']."' : false;\">🧨</button>
                        </td>
                    </tr>";
                }
                ?>
                </table>
                <dialog id="modal">
                    
                    <form method="Post" action="../salvar/S_Cliente.php">
        <div>
        <div><label for="Nome">Nome</label><input type="text" name="Nome" id="Nome"  maxlength="20" required></div>
        <div><label for="Email">Email</label><input type="email" name="Email" id="Email"  required></div>
        <div id="Mensagem_email"></div>
        <div><label for="Telefone">Telefone</label><input type="text" name="Telefone" id="Telefone" id="Telefone" maxlength="15" required></div>
        <div id="Mensagem_telefone"></div>
        <div><label for="Cpf">CPF</label><input type="text" name="Cpf" id="Cpf" maxlength="14" required></div>
        <div id="Mensagem_cpf"></div>
        <div><label for="Cnh">CNH</label><input type="text" name="Cnh" id="Cnh" maxlength="9"  required></div>
        <div id="Mensagem_cnh"></div>
        <div>
        <div style="color: red;"><?php if (isset($_SESSION['erro_cadastro'])){echo $_SESSION['erro_cadastro'];unset($_SESSION['erro_cadastro']);} ?></div>
        <input type="button" id="Cadastrar"  onclick="validarCliente()" value="Salvar">
        <button type="button" id="btnfechar">Voltar</button>
        </div>
        </div>
    </form> 
                </dialog>
		 

            </div><!-- Final da tabela--> 
        </div> <!-- Final VT-->
          <script src="../../js/mascaras.js"></script>
    <script src="../../js/validarformulario.js">

       
    </script>  
    <script> 
        const abrir = document.getElementById("btnabrir");
        const fechar = document.getElementById("btnfechar")
        const modal = document.getElementById("modal");
       

        abrir.addEventListener("click", () => {
        modal.showModal();
        });

        fechar.addEventListener("click", () => {
        modal.close();
        });
        
        </script>
</body>
