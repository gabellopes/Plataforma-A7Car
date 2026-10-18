document.addEventListener('DOMContentLoaded', () => {
    // 1. MAPEAMENTO DE ELEMENTOS (Essencial para o JS encontrar os IDs no HTML)
    const botaoEnviarDialog = document.getElementById("enviarDialog");
    const Email = document.getElementById("Email");
    const MensagemEmail = document.getElementById("Mensagem_email"); // Certifique-se que o ID no HTML é exato
    const spanMensagem_email_enviado = document.getElementById("Mensagem_email_enviado");
    const dialog = document.getElementById("dialog");
    const dialogEmailEnviado = document.getElementById("dialogEmailEnviado");
    const aLinkRedefinirSenha = document.getElementById("linkRedefinirSenha");

    async function verificarEmail(evento) {
        if (evento) evento.preventDefault();

        // Limpa mensagens anteriores
        if (MensagemEmail) {
            MensagemEmail.textContent = "";
        }

        try {
            // Validação se o campo de e-mail está vazio
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

            // Requisição Fetch para o PHP
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
                // Exibe o erro na div em vez de usar alert
                if (MensagemEmail) {
                    MensagemEmail.style.color = "red";
                    MensagemEmail.textContent = resultado.mensagem || 'E-mail não encontrado.';
                }
            }

        } catch (erro) {
            console.error('Erro na requisição:', erro);
            // Erros de rede ou falhas gerais exibidos na div
            if (MensagemEmail) {
                MensagemEmail.style.color = "red";
                MensagemEmail.textContent = "Erro de conexão com o servidor. Tente novamente.";
            }
        }
    }

    // Garante que o botão existe antes de adicionar o evento
    if (botaoEnviarDialog) {
        botaoEnviarDialog.addEventListener('click', verificarEmail);
    }
});