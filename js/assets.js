
const botaoMostrarSenha = document.getElementById("mostrarSenha");
const botaoMostrarConfirmarSenha = document.getElementById("mostrarConfirmarSenha");

const botaoabrirSimulacao = document.getElementById("abrirSimulacao");
const botaoFecharSimulacao = document.getElementById("fecharSimulacao");
const botaoEnviarSimulacao = document.getElementById("enviarSimulacao");
const botaotemCnh = document.getElementById("temCnh");
const botaonaoTemCnh = document.getElementById("naoTemCnh");
const divCnh = document.getElementById("divCnh");

const dialogSimulacao = document.getElementById("simulacao");



if(dialogSimulacao){

botaoFecharSimulacao.addEventListener('click', ()=>{
    dialogSimulacao.close();
});
botaoabrirSimulacao.addEventListener('click', ()=>{
    dialogSimulacao.showModal();
});

botaoEnviarSimulacao.addEventListener('click', () =>{

    validarCpf()
    validarTelefone();

    if(divCnh.hidden){
        if(validarCpf() === true && validarTelefone() === true){
        botaoEnviarSimulacao.type = "submit";
        }
    }else{
        validarCnh();
        if(validarCpf() === true && validarTelefone() === true && validarCnh() === true){
        botaoEnviarSimulacao.type = "submit";
        }

        
    }
});
botaonaoTemCnh.addEventListener('click', ()=>{
    botaonaoTemCnh.style.backgroundColor = "red";
    botaotemCnh.style.backgroundColor = "white";
    MensagemCnh.textContent = "";
    
    divCnh.hidden = true;

});
botaotemCnh.addEventListener('click', ()=>{
    botaotemCnh.style.backgroundColor = "red";
    botaonaoTemCnh.style.backgroundColor = "white";

    divCnh.hidden = false;

});



}


if(botaoMostrarSenha){
botaoMostrarSenha.addEventListener('click', () =>{

    if (Senha.type === 'password') {
        Senha.type = 'text';
        botaoMostrarSenha.textContent = '🙈';
    } else {
        Senha.type = 'password';
        botaoMostrarSenha.textContent = '👁';
    }
});}

if(botaoMostrarConfirmarSenha){
botaoMostrarConfirmarSenha.addEventListener('click', ()=>{
    if (ConfirmarSenha.type === 'password') {
        ConfirmarSenha.type = 'text';
        botaoMostrarConfirmarSenha.textContent = '🙈';
    } else {
        ConfirmarSenha.type = 'password';
        botaoMostrarConfirmarSenha.textContent = '👁';
    }
});}


