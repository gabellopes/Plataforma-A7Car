const Nome = document.getElementById("Nome");
const Email = document.getElementById("Email");
const Senha = document.getElementById("Senha");
const ConfirmarSenha = document.getElementById("Confirmar-senha");
const botaoCadastrar = document.getElementById("Cadastrar");
let MensagemEmail = document.getElementById("Mensagem_email");
let MensagemSenha = document.getElementById("Mensagem_senha");
let MensagemTelefone = document.getElementById("Mensagem_telefone");
MensagemEmail.style.color = "red";
MensagemSenha.style.color = "red";
MensagemTelefone.style.color = "red";


function PreencherUser(){
    Nome.value = "Fulano";
    Email.value ="fulano@email.com"
    Senha.value = "Senha123@"
    ConfirmarSenha.value = "Senha123@"

}
function validarCadastro() {
    validarEmail();
    validarSenha();
    validarTelefone();
}

function validarSenha() {
const regexCaracteresEspeciais = /[@$!%*?&]/;

   if(Senha.value !== ConfirmarSenha.value) {
        MensagemSenha.textContent = "As senhas não coincidem!";
        return false;

    }else if(Senha.value.length < 8 || ConfirmarSenha.value.length < 8) {
        MensagemSenha.textContent = "A senha deve ter no mínimo 8 caracteres!";
        return false;

    }else if (!regexCaracteresEspeciais.test(Senha.value)) {
        MensagemSenha.textContent = "A senha deve conter pelo menos um caractere especial!";
        return false;
    }else if (!/[A-Z]/.test(Senha.value)) {
        MensagemSenha.textContent = "A senha deve conter pelo menos uma letra maiúscula!";
        return false;
    }else if (!/[a-z]/.test(Senha.value)) {
        MensagemSenha.textContent = "A senha deve conter pelo menos uma letra minúscula!";
        return false;
        
    }else if (!/[1-9]/.test(Senha.value)) {
        MensagemSenha.textContent = "A senha deve conter pelo menos uma letra minúscula!";
        return false;
        
    }else{
        MensagemSenha.textContent = "";
        botaoCadastrar.type = "submit"; 
        return true;
    }
}

function validarEmail(){
    if (!Email.value.match(/^[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$/)) {
        MensagemEmail.textContent = "Formato de e-mail inválido!";
        return false;
    }else{
        MensagemEmail.textContent = "";
        return true;
    }

}
function validarTelefone(){
    if(Telefone.value.length <= 13 || Telefone.value.length > 15) {
        MensagemTelefone.textContent = "Formato de telefone inválido!";
        return false;
    }else{
        MensagemTelefone.textContent = "";
        return true;
    }
}
