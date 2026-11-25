const campoBusca = document.getElementById('campoBusca');
const btnLimpar = document.getElementById('btnLimparBusca');
const listaVeiculos = document.getElementById('listaVeiculos');

async function realizarBusca(termo) {
    const novaURL = termo ? `catalogo.php?busca=${encodeURIComponent(termo)}` : 'catalogo.php';
    window.history.replaceState(null, '', novaURL);

    try {
        const response = await fetch(`buscarCarro.php?busca=${encodeURIComponent(termo)}`);
        const html = await response.text();
        listaVeiculos.innerHTML = html;

        const marcador = listaVeiculos.querySelector('.controle-paginacao');
        window.offsetCatalogo = marcador ? parseInt(marcador.dataset.carregados, 10) : 0;
        if (typeof window.atualizarBotaoCarregarMais === 'function') {
            window.atualizarBotaoCarregarMais();
        }
    } catch (error) {
        console.error('Erro ao buscar veículos:', error);
    }
}

campoBusca.addEventListener('input', function () {
    if (btnLimpar) btnLimpar.style.display = this.value ? 'block' : 'none';
});

campoBusca.addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        realizarBusca(this.value);
    }
});

function cancelarBusca() {
    campoBusca.value = '';
    if (btnLimpar) btnLimpar.style.display = 'none';
    realizarBusca('');
    campoBusca.focus();
}