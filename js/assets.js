
const botaoMostrarSenha = document.getElementById("mostrarSenha");
const botaoMostrarConfirmarSenha = document.getElementById("mostrarConfirmarSenha");
const botaoabrirDialog = document.getElementById("abrirDialog");
const botaoFecharDialog = document.getElementById("fecharDialog");
const botaoFecharDialogEmailEnviado = document.getElementById("FecharDialogEmailEnviado");
const botaoEnviarDialog = document.getElementById("enviarDialog");
const botaotemCnh = document.getElementById("temCnh");
const botaonaoTemCnh = document.getElementById("naoTemCnh");
const botoesFavorito = document.querySelectorAll('.btn-favoritar');
const divCnh = document.getElementById("divCnh");


const inputTipoCadastro = document.getElementById("tipoCadastro");


const spanMensagem_email_enviado = document.getElementById("Mensagem_email_enviado");

const dialog = document.getElementById("dialog");
const dialogEmailEnviado = document.getElementById("dialogEmailEnviado");
const dialogRedefinirSenha = document.getElementById("dialogEmailEnviado");



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

        
    }}/*else if(inputTipoCadastro.value === 'esqueceuSenha'){
        validarEmail();

        if(validarEmail() === true){
            $emailEsqueceuSenha = Email.value;
            spanMensagem_email_enviado.textContent = $emailEsqueceuSenha ;
            
            dialog.close();
            dialogEmailEnviado.showModal();
             
        }
    }*/
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


if(botoesFavorito){
botoesFavorito.forEach(botao => {
    botao.addEventListener('click', (e) => {
        const veiculoId = e.currentTarget.getAttribute('data-id');
        const botaoAtual = e.currentTarget;

        /*MODIFICAR QUANDO PUBLICAR*/
        fetch('/Plataforma-A7Car/php/salvar/S_favorito.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            // Enviamos o ID do veículo para o PHP
            body: `id_veiculo=${encodeURIComponent(veiculoId)}`
        })
        .then(response => response.json()) // Converte a resposta do PHP para JSON
        .then(data => {
            if (data.sucesso) {
                
                if (botaoAtual.textContent === '❤') {
                    botaoAtual.textContent = '❤️';
                } else {
                    botaoAtual.textContent = '❤';
                }
            } else {
                alert('Erro ao favoritar: ' + data.mensagem);
            }
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
            console.log('error')
        });
    });
});
}


