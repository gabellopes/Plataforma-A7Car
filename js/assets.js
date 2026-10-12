
const botaoMostrarSenha = document.getElementById("mostrarSenha");
const botaoMostrarConfirmarSenha = document.getElementById("mostrarConfirmarSenha");
const botaoabrirDialog = document.getElementById("abrirDialog");
const botaoFecharDialog = document.getElementById("fecharDialog");
const botaoFecharDialogEmailEnviado = document.getElementById("FecharDialogEmailEnviado");
const botaoEnviarDialog = document.getElementById("enviarDialog");
const botaotemCnh = document.getElementById("temCnh");
const botaonaoTemCnh = document.getElementById("naoTemCnh");
const divCnh = document.getElementById("divCnh");

const inputTipoCadastro = document.getElementById("tipoCadastro");


const spanMensagem_email_enviado = document.getElementById("Mensagem_email_enviado");

const dialog = document.getElementById("dialog");
const dialogEmailEnviado = document.getElementById("dialogEmailEnviado");
const dialogRedefinirSenha = document.getElementById("dialogEmailEnviado");


if(botaoCadastrar){
botaoCadastrar.addEventListener('click', ()=>{
if(inputTipoCadastro.value === 'redefinirSenha'){
        
        if(validarSenha() === true){
            botaoCadastrar.type = "submit";
        }
    } 
    
});}

if(dialog){

botaoFecharDialog.addEventListener('click', ()=>{
    dialog.close();
});
botaoabrirDialog.addEventListener('click', ()=>{
    dialog.showModal();
});

botaoEnviarDialog.addEventListener('click', () =>{

if(inputTipoCadastro.value === 'simulacao'){
    validarCpf()
    validarTelefone();

    if(divCnh.hidden){
        if(validarCpf() === true && validarTelefone() === true){
        botaoEnviarDialog.type = "submit";
        }
    }else{
        validarCnh();
        if(validarCpf() === true && validarTelefone() === true && validarCnh() === true){
        botaoEnviarDialog.type = "submit";
        }

        
    }}else if(inputTipoCadastro.value === 'esqueceuSenha'){
        validarEmail();

        if(validarEmail() === true){
            $emailEsqueceuSenha = Email.value;
            console.log($emailEsqueceuSenha);
            spanMensagem_email_enviado.textContent = $emailEsqueceuSenha ;
            
            dialog.close();
            dialogEmailEnviado.showModal();
             
        }
    }
});

if(inputTipoCadastro.value === 'simulacao'){
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


}

if(dialogEmailEnviado){

botaoFecharDialogEmailEnviado.addEventListener('click', ()=>{
    dialogEmailEnviado.close();
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


