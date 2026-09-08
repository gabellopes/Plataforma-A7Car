const Nome = document.getElementById("Nome");
const Email = document.getElementById("Email");
const Telefone = document.getElementById("Telefone");
const Senha = document.getElementById("Senha");
const ConfirmarSenha = document.getElementById("Confirmar-senha");
const botaoCadastrar = document.getElementById("Cadastrar");
let Mensagem = document.getElementById("Mensagem");
Mensagem.style.color = "red";


/*function preencher(){
Nome.value = "Joana";
Email.value = "joana@example.com";
Telefone.value = "(11) 98765-4321";
Senha.value = "Senha123";
ConfirmarSenha.value = "Senha124";
}*/
function validarCadastro() {
    validarEmail();
    validarSenha();
}

function validarSenha() {
const regexCaracteresEspeciais = /[@$!%*?&]/;

   if(Senha.value !== ConfirmarSenha.value) {
        Mensagem.textContent = "As senhas não coincidem!";
        return false;

    }else if(Senha.value.length < 8 || ConfirmarSenha.value.length < 8) {
        Mensagem.textContent = "A senha deve ter no mínimo 8 caracteres!";
        return false;

    }else if (!regexCaracteresEspeciais.test(Senha.value)) {
        Mensagem.textContent = "A senha deve conter pelo menos um caractere especial!";
        return false;
    }else if (!/[A-Z]/.test(Senha.value)) {
        Mensagem.textContent = "A senha deve conter pelo menos uma letra maiúscula!";
        return false;
    }else if (!/[a-z]/.test(Senha.value)) {
        Mensagem.textContent = "A senha deve conter pelo menos uma letra minúscula!";
        return false;
        
    }else{
        Mensagem.textContent = "";
        botaoCadastrar.type = "submit"; 
        return true;
    }
}

function validarEmail(){
    if (!Email.value.match(/^[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$/)) {
        Mensagem.textContent = "Formato de e-mail inválido!";
        return false;
    }else{
        Mensagem.textContent = "";
        validarSenha();
    }

}

