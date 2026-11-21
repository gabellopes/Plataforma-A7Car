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

if (dialog) {
    if (botaoFecharDialog) {
        botaoFecharDialog.addEventListener('click', () => {
            dialog.close();
        });
    }

    if (botaoabrirDialog) {
        botaoabrirDialog.addEventListener('click', () => {
            dialog.showModal();
        });
    }

    if (botaoEnviarDialog) {
        botaoEnviarDialog.addEventListener('click', () => {
            if (inputTipoCadastro && inputTipoCadastro.value === 'simulacao') {
                validarCpf();
                validarTelefone();
                validarData();

                if (divCnh.hidden) {
                    if (validarCpf() === true && validarTelefone() === true && validarData() === true) {
                        botaoEnviarDialog.type = "submit";
                    }
                } else {
                    validarCnh();
                    if (validarCpf() === true && validarTelefone() === true && validarData() === true && validarCnh() === true) {
                        botaoEnviarDialog.type = "submit";
                    }
                }
            }
        });
    }

    if (inputTipoCadastro && inputTipoCadastro.value === 'simulacao') {
        if (botaonaoTemCnh) {
            botaonaoTemCnh.addEventListener('click', () => {
                botaonaoTemCnh.style.backgroundColor = "red";
                botaotemCnh.style.backgroundColor = "white";
                botaonaoTemCnh.style.color = "white";
                botaotemCnh.style.color = "gray";
                MensagemCnh.textContent = "";
                divCnh.hidden = true;
            });
        }

        if (botaotemCnh) {
            botaotemCnh.addEventListener('click', () => {
                botaotemCnh.style.backgroundColor = "red";
                botaonaoTemCnh.style.backgroundColor = "white";
                botaonaoTemCnh.style.color = "gray";
                botaotemCnh.style.color = "white";
                divCnh.hidden = false;
            });
        }
    }
}

if (dialogEmailEnviado && botaoFecharDialogEmailEnviado) {
    botaoFecharDialogEmailEnviado.addEventListener('click', () => {
        dialogEmailEnviado.close();
    });
}

if (botaoMostrarSenha) {
    botaoMostrarSenha.addEventListener('click', () => {
        if (Senha.type === 'password') {
            Senha.type = 'text';
            botaoMostrarSenha.textContent = '🙈';
        } else {
            Senha.type = 'password';
            botaoMostrarSenha.textContent = '👁';
        }
    });
}

if (botaoMostrarConfirmarSenha) {
    botaoMostrarConfirmarSenha.addEventListener('click', () => {
        if (ConfirmarSenha.type === 'password') {
            ConfirmarSenha.type = 'text';
            botaoMostrarConfirmarSenha.textContent = '🙈';
        } else {
            ConfirmarSenha.type = 'password';
            botaoMostrarConfirmarSenha.textContent = '👁';
        }
    });
}

if (botoesFavorito) {
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
                body: `id_veiculo=${encodeURIComponent(veiculoId)}`
            })
            .then(response => response.json())
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
            });
        });
    });

    function toggleElemento(elemento) {
        var conteudo = elemento.nextElementSibling;
        var seta = elemento.querySelector('.seta-icone');

        if (conteudo.style.display === "none" || conteudo.style.display === "") {
            conteudo.style.display = "block";
            if (seta) {
                seta.innerText = "🔽";
            }
        } else {
            conteudo.style.display = "none";
            if (seta) {
                seta.innerText = "🔼";
            }
        }
    }
}

window.addEventListener('DOMContentLoaded', () => {
    // 1. Abertura automática do modal de e-mail/simulação via URL
    const urlParams = new URLSearchParams(window.location.search);
    const dialogEmail = document.getElementById('dialogEmailEnviado');

    if ((urlParams.has('email') || urlParams.has('sucesso')) && dialogEmail) {
        dialogEmail.showModal();
    }

    const btnFechar = document.getElementById('FecharDialogEmailEnviado');
    if (btnFechar && dialogEmail) {
        btnFechar.addEventListener('click', () => {
            dialogEmail.close();
        });
    }

    const fotoPrincipal = document.getElementById('foto-principal');
    const miniaturas = document.querySelectorAll('#miniaturas-track img');

    if (fotoPrincipal && miniaturas.length > 0) {
        let indiceAtual = 0;

        window.selecionarFoto = function (index) {
            if (index < 0) index = miniaturas.length - 1;
            if (index >= miniaturas.length) index = 0;

            indiceAtual = index;
            fotoPrincipal.src = miniaturas[indiceAtual].src;

            miniaturas.forEach(img => img.classList.remove('ativa'));
            miniaturas[indiceAtual].classList.add('ativa');

            miniaturas[indiceAtual].scrollIntoView({
                behavior: 'smooth',
                block: 'nearest',
                inline: 'center'
            });
        };

        window.navegarCarrossel = function (direcao) {
            window.selecionarFoto(indiceAtual + direcao);
        };
    }
});