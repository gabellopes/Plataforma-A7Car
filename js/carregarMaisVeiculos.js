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

function restaurarScroll() {
    const scrollSalvo = sessionStorage.getItem('catalogo_scroll');
    sessionStorage.removeItem('catalogo_scroll');
    if (scrollSalvo !== null) {
        requestAnimationFrame(() => {
            window.scrollTo(0, parseInt(scrollSalvo, 10));
        });
    }
}

async function restaurarCarrosSalvos() {
    const voltouDeVeiculo = sessionStorage.getItem('voltou_de_veiculo') === '1';
    sessionStorage.removeItem('voltou_de_veiculo');

    if (!voltouDeVeiculo) {
        sessionStorage.removeItem('catalogo_qtd');
        sessionStorage.removeItem('catalogo_scroll');
        return;
    }

    const qtdSalva = parseInt(sessionStorage.getItem('catalogo_qtd'), 10);

    if (!qtdSalva || qtdSalva <= window.offsetCatalogo) {
        restaurarScroll();
        return;
    }

    const faltantes = qtdSalva - window.offsetCatalogo;

    try {
        const termoBusca = inputBusca ? inputBusca.value : '';
        const response = await fetch(`buscarCarro.php?offset=${window.offsetCatalogo}&limit=${faltantes}&busca=${encodeURIComponent(termoBusca)}`);
        const htmlRetornado = await response.text();

        containerVeiculos.insertAdjacentHTML('beforeend', htmlRetornado);

        const marcadores = containerVeiculos.querySelectorAll('.controle-paginacao');
        const ultimoMarcador = marcadores[marcadores.length - 1];
        const novosCarregados = ultimoMarcador ? parseInt(ultimoMarcador.dataset.carregados, 10) : 0;

        window.offsetCatalogo += novosCarregados;
        window.atualizarBotaoCarregarMais();
        restaurarScroll();
    } catch (error) {
        console.error("Erro ao restaurar veículos:", error);
    }
}

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
        sessionStorage.setItem('catalogo_qtd', window.offsetCatalogo);

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

if (containerVeiculos) {
    containerVeiculos.addEventListener('click', (e) => {
        const btn = e.target.closest('button');
        if (btn && btn.getAttribute('onclick') && btn.getAttribute('onclick').includes('Veiculo.php')) {
            sessionStorage.setItem('voltou_de_veiculo', '1');
            sessionStorage.setItem('catalogo_qtd', window.offsetCatalogo);
            sessionStorage.setItem('catalogo_scroll', window.scrollY);
        }
    });
}

if (btnCarregar) {
    btnCarregar.addEventListener('click', carregarMais);
}

window.atualizarBotaoCarregarMais();
restaurarCarrosSalvos();