document.addEventListener('DOMContentLoaded', () => {
console.log(Email.value);

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
            /*MODIFICAR QUANDO PUBLICAR*/
            const response = await fetch('/Plataforma-A7Car/php/salvar/temp.php', {
                method: 'POST', 
                headers: { 'Content-Type': 'application/json; charset=utf-8' }, 
                body: JSON.stringify({ email: emailEsqueceuSenha })
            });

            if (!response.ok) {
                throw new Error(`Erro HTTP: ${response.status}`);
            }

            const resultado = await response.json();

            if (resultado.sucesso) {
                if (dialog) dialog.close();
                if (dialogEmailEnviado) dialogEmailEnviado.showModal();
                aLinkRedefinirSenha.textContent = resultado['link'];
                aLinkRedefinirSenha.href = resultado['link'];
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