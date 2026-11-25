const limitFav = 3;
const btnCarregarFav = document.getElementById('btn-carregar-mais-fav');
const containerFavoritos = document.getElementById('listaFavoritos');

function obterTotalInicialFav() {
    const marcador = containerFavoritos.querySelector('.controle-paginacao');
    return marcador ? parseInt(marcador.dataset.carregados, 10) : limitFav;
}

let offsetFavoritos = obterTotalInicialFav();

function atualizarBotaoFav() {
    if (!btnCarregarFav) return;
    const marcadores = containerFavoritos.querySelectorAll('.controle-paginacao');
    const ultimoMarcador = marcadores[marcadores.length - 1];

    if (!ultimoMarcador || ultimoMarcador.dataset.temMais === "0") {
        btnCarregarFav.style.display = 'none';
    } else {
        btnCarregarFav.style.display = 'block';
    }
}

function restaurarScrollFav() {
    const scrollSalvo = sessionStorage.getItem('favoritos_scroll');
    sessionStorage.removeItem('favoritos_scroll');
    if (scrollSalvo !== null) {
        requestAnimationFrame(() => {
            window.scrollTo(0, parseInt(scrollSalvo, 10));
        });
    }
}

async function restaurarFavoritosSalvos() {
    const voltouDeVeiculo = sessionStorage.getItem('voltou_de_veiculo_fav') === '1';
    sessionStorage.removeItem('voltou_de_veiculo_fav');

    if (!voltouDeVeiculo) {
        sessionStorage.removeItem('favoritos_qtd');
        sessionStorage.removeItem('favoritos_scroll');
        return;
    }

    const qtdSalva = parseInt(sessionStorage.getItem('favoritos_qtd'), 10);

    if (!qtdSalva || qtdSalva <= offsetFavoritos) {
        restaurarScrollFav();
        return;
    }

    const faltantes = qtdSalva - offsetFavoritos;

    try {
        const response = await fetch(`buscarFavoritos.php?offset=${offsetFavoritos}&limit=${faltantes}`);
        const htmlRetornado = await response.text();

        containerFavoritos.insertAdjacentHTML('beforeend', htmlRetornado);

        const marcadores = containerFavoritos.querySelectorAll('.controle-paginacao');
        const ultimoMarcador = marcadores[marcadores.length - 1];
        const novosCarregados = ultimoMarcador ? parseInt(ultimoMarcador.dataset.carregados, 10) : 0;

        offsetFavoritos += novosCarregados;
        atualizarBotaoFav();
        restaurarScrollFav();
    } catch (error) {
        console.error("Erro ao restaurar favoritos:", error);
    }
}

async function carregarMaisFav() {
    try {
        if (!btnCarregarFav) return;

        btnCarregarFav.disabled = true;
        btnCarregarFav.textContent = "Carregando...";

        const response = await fetch(`buscarFavoritos.php?offset=${offsetFavoritos}`);
        const htmlRetornado = await response.text();

        containerFavoritos.insertAdjacentHTML('beforeend', htmlRetornado);

        const marcadores = containerFavoritos.querySelectorAll('.controle-paginacao');
        const ultimoMarcador = marcadores[marcadores.length - 1];
        const novosCarregados = ultimoMarcador ? parseInt(ultimoMarcador.dataset.carregados, 10) : 0;

        offsetFavoritos += novosCarregados;
        sessionStorage.setItem('favoritos_qtd', offsetFavoritos);

        atualizarBotaoFav();

    } catch (error) {
        console.error("Erro ao carregar favoritos:", error);
    } finally {
        if (btnCarregarFav) {
            btnCarregarFav.disabled = false;
            btnCarregarFav.textContent = "Carregar mais veículos";
        }
    }
}

if (containerFavoritos) {
    containerFavoritos.addEventListener('click', (e) => {
        const btn = e.target.closest('button');
        if (btn && btn.getAttribute('onclick') && btn.getAttribute('onclick').includes('Veiculo.php')) {
            sessionStorage.setItem('voltou_de_veiculo_fav', '1');
            sessionStorage.setItem('favoritos_qtd', offsetFavoritos);
            sessionStorage.setItem('favoritos_scroll', window.scrollY);
        }
    });
}

if (btnCarregarFav) {
    btnCarregarFav.addEventListener('click', carregarMaisFav);
}

atualizarBotaoFav();
restaurarFavoritosSalvos();