const Nome = document.getElementById("Nome");
const Email = document.getElementById("Email");
const Senha = document.getElementById("Senha");

const ConfirmarSenha = document.getElementById("Confirmar-senha");
const botaoCadastrar = document.getElementById("Cadastrar");




let MensagemEmail = document.getElementById("Mensagem_email");
let MensagemSenha = document.getElementById("Mensagem_senha");
let MensagemTelefone = document.getElementById("Mensagem_telefone");
let MensagemCpf = document.getElementById("Mensagem_cpf");
let MensagemCnh = document.getElementById("Mensagem_cnh");
let MensagemAno = document.getElementById("Mensagem_ano");




function PreencherUserCad(){
    Nome.value = "Fulano";
    Email.value ="fulano@email.com"
    Senha.value = "Senha123@"
    ConfirmarSenha.value = "Senha123@"
}
function validarUser() {
    validarCadastro();
    validarEmail();
    validarSenha();
    validarTelefone();
   
}

if(botaoCadastrar){
botaoCadastrar.addEventListener('click', ()=>{
if(inputTipoCadastro.value === 'redefinirSenha'){
        
        if(validarSenha() === true){
            botaoCadastrar.type = "submit";
        }
    }else if(inputTipoCadastro.value === 'cadastroVeiculo'){
        validarVeiculo();
    }
    
});}
function validarVeiculo(){
    if(validarAno() === true){
        botaoCadastrar.type = "submit";
    }
}

function validarCadastro(){
    if(validarEmail() === true && validarSenha() === true && validarTelefone() === true ){
    botaoCadastrar.type = "submit";
    }
}

function validarColaborador(){
    validarTelefone();
    validarEmail()
    if(validarEmail() === true && validarTelefone() === true ){
    botaoCadastrar.type = "submit";
    }
}
function validarCliente(){
    validarCpf();
    validarCnh();
    validarTelefone();
    validarEmail();
    if(validarEmail() === true && validarTelefone() === true && validarCpf() === true && validarCnh() === true){
    botaoCadastrar.type = "submit";
    }
}



function validarVenda(){
     validarCpf();
     validarTelefone();
if(validarCpf() === true && validarTelefone() === true){
    botaoCadastrar.type = "submit";
    }
}
function validarSenha() {
    MensagemSenha.style.color = "red";
    const regexCaracteresEspeciais = /[@$!%*?&]/;
    
    let erros = [];

    if (Senha.value !== ConfirmarSenha.value) {
        erros.push("As senhas não coincidem!");
    }
    if (Senha.value.length < 8) {
        erros.push("A senha deve ter no mínimo 8 caracteres!");
    }
    if (!regexCaracteresEspeciais.test(Senha.value)) {
        erros.push("A senha deve conter pelo menos um caractere especial!");
    }
    if (!/[A-Z]/.test(Senha.value)) {
        erros.push("A senha deve conter pelo menos uma letra maiúscula!");
    }
    if (!/[a-z]/.test(Senha.value)) {
        erros.push("A senha deve conter pelo menos uma letra minúscula!");
    }
    if (!/[0-9]/.test(Senha.value)) {
        erros.push("A senha deve conter pelo menos um número!");
    }

    if (erros.length > 0) {
        // Junta os erros usando quebra de linha (\n) em vez de <br>
        MensagemSenha.textContent = erros.join("\n");
        return false;
    } else {
        MensagemSenha.textContent = "";
        return true;
    }
}

function validarEmail(){
MensagemEmail.style.color = "red";
    if (!Email.value.match(/^[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$/)) {
        MensagemEmail.textContent = "Formato de e-mail inválido!";
        return false;
    }else{
        MensagemEmail.textContent = "";
        return true;
    }

}
function validarTelefone(){
    MensagemTelefone.style.color = "red";
    if(Telefone.value.length <= 13 || Telefone.value.length > 15) {
        MensagemTelefone.textContent = "Formato de telefone inválido!";
        return false;
    }else{
        MensagemTelefone.textContent = "";
        return true;
    }
}

function validarCpf(){
    MensagemCpf.style.color = "red";
    if(Cpf.value.length != 14){
        MensagemCpf.textContent = "Formato de cpf inválido!"
        return false;
    }else{
        MensagemCpf.textContent = "";
        return true;
    }
}
function validarCnh(){
    MensagemCnh.style.color = "red";
    if(Cnh.value.length != 9){
        MensagemCnh.textContent = "Formato de cnh inválido!"
        return false;
    }else{
        MensagemCnh.textContent = ""
        return true;
    }
}

function validarAno(){
const anoAtual = new Date().getFullYear();

MensagemAno.style.color = "red";

if(Ano.value.length != 4){
    MensagemAno.textContent = "Digite um ano valido";
    return false;

}else if(Ano.value > anoAtual){
    MensagemAno.textContent = "Digite um ano valido";
    return false;

}else if(Ano.value < 1901){
    MensagemAno.textContent = "Digite um ano valido";
    return false;
    
}else{
    MensagemAno.textContent = ""
    return true;
}
}
