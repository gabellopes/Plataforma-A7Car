document.addEventListener('DOMContentLoaded', () => {
    const botaoEnviarDialog = document.getElementById("enviarDialog");
    const Email = document.getElementById("Email");
    const MensagemEmail = document.getElementById("Mensagem_email"); 
    const spanMensagem_email_enviado = document.getElementById("Mensagem_email_enviado");
    const dialog = document.getElementById("dialog");
    const dialogEmailEnviado = document.getElementById("dialogEmailEnviado");
    const aLinkRedefinirSenha = document.getElementById("linkRedefinirSenha");

    async function verificarEmail(evento) {
        if (evento) evento.preventDefault();

        if (MensagemEmail) {
            MensagemEmail.textContent = "";
        }

        try {
            if (!Email || !Email.value.trim()) {
                if (MensagemEmail) {
                    MensagemEmail.style.color = "red";
                    MensagemEmail.textContent = "Por favor, digite um e-mail.";
                }
                return;
            }

            let emailEsqueceuSenha = Email.value.trim();

            if (spanMensagem_email_enviado) {
                spanMensagem_email_enviado.textContent = emailEsqueceuSenha;
            }
            let modoDev = 1;
            const response = await fetch('/Plataforma-A7Car/php/salvar/temp.php', {
                method: 'POST', 
                headers: { 'Content-Type': 'application/json; charset=utf-8' }, 
                body: JSON.stringify({ email: emailEsqueceuSenha, modoDev: false })
            });

            if (!response.ok) {
                throw new Error(`Erro HTTP: ${response.status}`);
            }

            const resultado = await response.json();

            if (resultado.sucesso) {
                
                if (dialog) dialog.close();
                if (dialogEmailEnviado) dialogEmailEnviado.showModal();
                if(resultado.modoDev === true){
                    aLinkRedefinirSenha.textContent = resultado['link'];
                    aLinkRedefinirSenha.href = resultado['link'];
                }
            } else {
                if (MensagemEmail) {
                    MensagemEmail.style.color = "red";
                    MensagemEmail.textContent = resultado.mensagem || 'E-mail não encontrado.';
                }
            }

        } catch (erro) {
            console.error('Erro na requisição:', erro);
            if (MensagemEmail) {
                MensagemEmail.style.color = "red";
                MensagemEmail.textContent = "Erro de conexão com o servidor. Tente novamente.";
            }
        }
    }

    if (botaoEnviarDialog) {
        botaoEnviarDialog.addEventListener('click', verificarEmail);
    }
});