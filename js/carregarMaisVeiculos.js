const limit = 3;
const btnCarregar = document.getElementById('btn-carregar-mais');
const containerVeiculos = document.getElementById('listaVeiculos');
const inputBusca = document.getElementById('campoBusca');

function obterTotalInicial() {
    const marcador = containerVeiculos.querySelector('.controle-paginacao');
    return marcador ? parseInt(marcador.dataset.carregados, 10) : limit;
}

window.offsetCatalogo = obterTotalInicial();

window.atualizarBotaoCarregarMais = function () {
    if (!btnCarregar) return;
    const marcadores = containerVeiculos.querySelectorAll('.controle-paginacao');
    const ultimoMarcador = marcadores[marcadores.length - 1];

    if (!ultimoMarcador || ultimoMarcador.dataset.temMais === "0") {
        btnCarregar.style.display = 'none';
    } else {
        btnCarregar.style.display = 'block';
    }
};

async function carregarMais() {
    try {
        if (!btnCarregar) return;

        btnCarregar.disabled = true;
        btnCarregar.textContent = "Carregando...";

        const termoBusca = inputBusca ? inputBusca.value : '';
        const response = await fetch(`buscarCarro.php?offset=${window.offsetCatalogo}&busca=${encodeURIComponent(termoBusca)}`);
        const htmlRetornado = await response.text();

        containerVeiculos.insertAdjacentHTML('beforeend', htmlRetornado);

        const marcadores = containerVeiculos.querySelectorAll('.controle-paginacao');
        const ultimoMarcador = marcadores[marcadores.length - 1];
        const novosCarregados = ultimoMarcador ? parseInt(ultimoMarcador.dataset.carregados, 10) : 0;

        window.offsetCatalogo += novosCarregados;

        window.atualizarBotaoCarregarMais();

    } catch (error) {
        console.error("Erro ao carregar:", error);
    } finally {
        if (btnCarregar) {
            btnCarregar.disabled = false;
            btnCarregar.textContent = "Carregar mais veículos";
        }
    }
}

if (btnCarregar) {
    btnCarregar.addEventListener('click', carregarMais);
}

window.atualizarBotaoCarregarMais();