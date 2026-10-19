<?php
require_once "../salvar/Conexao.php";
require_once "../salvar/funcoes.php";
if (session_status() !== PHP_SESSION_ACTIVE) {
    SESSION_START(); 
}

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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/principal.css">
    <link rel="stylesheet" href="../../css/login.css">
</head>
<body>


    <header id="cabecalho">
        
        <img src="../../img/logo.png" alt="" class="logo" onclick="window.location.href='../../index.php'">
        <div id="link">
            <a href="catalogo.php">CATÁLOGO</a>
            <a href="colaboradores.php">COLABORADORES</a>
            <a href="contato.php">CONTATO</a>
            <?php if(isset($_SESSION['user_email'])): ?>
                <a href="#">FAVORITOS</a>
            <?php endif; ?>
        </div>
        <div id="linksAuth">
            <?php if(!isset($_SESSION['user_email'])): ?>
            <button id="btnEntrar" class="btn" type="button" onclick="window.location.href='Login.php'">ENTRAR</button>
            <button id="btnCadastrar" class="btn" type="button" onclick="window.location.href='Cadastro.php'">CADASTRAR </button>
            <?php else: ?>
            <p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['user_nome'], ENT_QUOTES, 'UTF-8'); ?>!</p>
            <button class="btn" type="button" onclick="window.location.href='../salvar/Sair.php'">SAIR </button>
            <?php endif; ?>
        </div>

    </header>


    <div id="meio">
        <h3>Entre na sua conta</h3>
        <h1>LOGIN</h1>
    </div>

    <div class="mei">
    <div id="login">
        
    

    <form action="../salvar/Testelogin.php" method="post">
        <label for="email">E-mail</label>
        <input type="email" name="Email" id="Email2" maxlength="20" required>

        <label for="senha">Senha</label>
        <div><input type="password" name="Senha" id="Senha" maxlength="20" required><button type="button" id="mostrarSenha">👁</button></div>
        <div style="color: red;"><?php if (isset($_SESSION['erro_login'])){echo htmlspecialchars($_SESSION['erro_login'], ENT_QUOTES, 'UTF-8');unset($_SESSION['erro_login']);} ?></div>

        <button type="submit" class="btn">ENTRAR</button>
        <input type="button" value="User" onclick="PreencherUserLo()">
        <input type="button" value="Admin" onclick="PreencherAdmin()">
    </form>
    <button id="abrirDialog">Esqueci minha senha</button>
    <a href="Cadastro.php">Não tem cadastro? Cadastrar</a>

    <dialog id="dialog">
                <button id="fecharDialog">🏃‍♂️💨</button>
                
                    <h1>Redefinir Senha</h1>
                    <hr>

                    <p>Informe o e-mail cadastrado na sua conta. Enviaremos um link para você criar uma nova senha.</p>

                    <div>
                        <input id="tipoCadastro" type="text" value="esqueceuSenha" hidden>
                        <label for="email">E-mail</label>
                        <input type="email" name="Email" id="Email" maxlength="255" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" required>
                        <div id="Mensagem_email"></div>
                        <input type="button" id="enviarDialog" class="btn"  value="✉ENVIAR EMAIL">
                    </div>

            </dialog>

    <dialog id="dialogEmailEnviado">
                <button id="FecharDialogEmailEnviado">🏃‍♂️💨</button>

                    <h1>E-mail Enviado</h1>
                    <hr>
                    
                    <img src="#" alt="✉">
                    <p>Link enviado!</p>
                    <p>Enviamos um e-mail para <span id="Mensagem_email_enviado" style="color: red;"></span> com  as instruções para redefinir sua senha</p>

                    <h1>Simulação do link recebido</h1>
                    <a href="#" style="color: blue;" id="linkRedefinirSenha"></a>
                    
    </dialog>

    <script>
        const Email2 = document.getElementById("Email2");
        function PreencherUserLo(){

        Email2.value = "usuario@gmail.com";
        Senha.value = "Usuario123!";
        }

        function PreencherAdmin(){

        Email2.value = "admin@gmail.com";
        Senha.value = "Admin123!";
        }

    
    </script>
    
<script src="../../js/mascaras.js"></script>
<script src="../../js/validarformulario.js"></script>
<script src="../../js/assets.js"></script>
<script src="../../js/temp.js"></script>
</body>
</html>
