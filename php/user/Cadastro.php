<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php if (isset($_SESSION['erro_cadastro'])): ?>
        <p style="color: red;">
            <?php
                echo $_SESSION['erro_cadastro'];
                unset($_SESSION['erro_cadastro']);
            ?>
        </p>
    <?php endif; ?>

    <form action="../salvar/S_User.php" method="post">
        <fieldset><label for="nome">Nome Completo</label><input type="text" name="Nome" id="Nome" maxlength="255" required><div id="Mensagem"></div></fieldset>
        <fieldset><label for="email">E-mail</label><input type="email" name="Email" id="Email" maxlength="255" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" required></fieldset>
        <fieldset><label for="telefone">Telefone</label><input type="tel" name="Telefone" id="Telefone" maxlength="15" pattern="\([0-9]{2}\)\s?[0-9]{4,5}-[0-9]{4}"  required></fieldset>
        <fieldset><label for="senha">Senha</label> <input type="password" name="Senha" id="Senha" maxlength="20" required></fieldset>
        <fieldset><label for="confirmar-senha">Confirmar Senha</label> <input type="password" name="Confirmar_Senha" id="Confirmar-senha" maxlength="20" required></fieldset>
        <fieldset><input type="submit" value="Cadastrar"></fieldset>
    </form>
   <a href="Login.php">Já tem cadastro? Logar</a>
</body>
<script>
const Nome = document.getElementById("Nome");
const Email = document.getElementById("Email");
const Telefone = document.getElementById("Telefone");
const Senha = document.getElementById("Senha");
const Confirmar = document.getElementById("Confirmar-senha");

let Mensagem = document.getElementById("Mensagem");

document.addEventListener('DOMContentLoaded', () => {


if (Telefone) {

Telefone.addEventListener('input', (e) => {
let value = e.target.value.replace(/\D/g, '');

if (value.length > 10) {
    value = value.replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1) $2-$3');
        } else if (value.length > 6) {
                        value = value.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, '($1) $2-$3');
        } else if (value.length > 2) {
                        value = value.replace(/^(\d{2})(\d{0,5})/, '($1) $2');
        } else if (value.length > 0) {
                        value = value.replace(/^(\d*)/, '($1');
        }

        e.target.value = value;
         });//Fim do Telefone.addEventListener

}//Fim do telefone      
// Elementos da lista de requisitos
const reqLength = document.getElementById('length');
const reqUppercase = document.getElementById('uppercase');
const reqLowercase = document.getElementById('lowercase');
const reqNumber = document.getElementById('number');
const reqSpecial = document.getElementById('special');

// Regras com Expressões Regulares (Regex)
const regras = {
  length: (val) => val.length >= 8,
  uppercase: (val) => /[A-Z]/.test(val),
  lowercase: (val) => /[a-z]/.test(val),
  number: (val) => /[0-9]/.test(val),
  special: (val) => /[@$!%*?&]/.test(val)
};

// Evento escutado a cada tecla digitada
inputSenha.addEventListener('input', function () {
  const senha = this.value;

  // Atualiza a classe 'valido' para cada requisito
  atualizarStatus(reqLength, regras.length(senha));
  atualizarStatus(reqUppercase, regras.uppercase(senha));
  atualizarStatus(reqLowercase, regras.lowercase(senha));
  atualizarStatus(reqNumber, regras.number(senha));
  atualizarStatus(reqSpecial, regras.special(senha));
});

function atualizarStatus(elemento, ehValido) {
  if (ehValido) {
    elemento.classList.add('valido');
  } else {
    elemento.classList.remove('valido');
  }
}

// Função auxiliar caso precise validar antes de submeter o formulário
function validarSenhaCompleta(senha) {
  return Object.values(regras).every(regra => regra(senha));
}       
///////////////////////////////////////////////q

if (data.sucesso === true) {
    // Acessa cada chave do JSON retornado pelo PHP
    Nome.value = data.Nome || "";
    Email.value     = data.Email || "";
    Telefone.value     = data.Telefone || "";
    Senha.value     = data.Senha || "";
    Confirmar_Senha.value     = data.Confirmar_Senha || "";
    
    
} 
        });                    
    </script>
</html>