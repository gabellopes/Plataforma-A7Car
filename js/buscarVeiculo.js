const campoBusca = document.getElementById('campoBusca');
const btnLimpar = document.getElementById('btnLimparBusca');
const listaVeiculos = document.getElementById('listaVeiculos');

// 1. Função isolada que faz a consulta no PHP e atualiza a URL
async function realizarBusca(termo) {
    // Atualiza a URL na barra do navegador
    const novaURL = termo ? `catalogo.php?busca=${encodeURIComponent(termo)}` : 'catalogo.php';
    window.history.replaceState(null, '', novaURL);

    try {
        // Pede os dados para o PHP
        const response = await fetch(`buscarCarro.php?busca=${encodeURIComponent(termo)}`);
        const html = await response.text();
        listaVeiculos.innerHTML = html;
    } catch (error) {
        console.error('Erro ao buscar veículos:', error);
    }
}

// 2. Controla APENAS a exibição do botão "X" enquanto o usuário digita
campoBusca.addEventListener('input', function() {
    btnLimpar.style.display = this.value ? 'block' : 'none';
});

// 3. Dispara a busca SOMENTE quando a tecla "Enter" for pressionada
campoBusca.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault(); // Evita recarregar a página caso o input esteja dentro de um form
        realizarBusca(this.value); // Chama a função de busca
    }
});

// 4. Função do botão "X" para limpar tudo
function cancelarBusca() {
    campoBusca.value = '';
    btnLimpar.style.display = 'none'; // Esconde o botão X
    realizarBusca(''); // Passa um texto vazio para buscar todos os carros de volta
    campoBusca.focus();
}