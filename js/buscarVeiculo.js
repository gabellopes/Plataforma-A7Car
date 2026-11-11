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
    } catch (error) {
        console.error('Erro ao buscar veículos:', error);
    }
}


campoBusca.addEventListener('input', function() {
    btnLimpar.style.display = this.value ? 'block' : 'none';
});


campoBusca.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault(); 
        realizarBusca(this.value); 
    }
});


function cancelarBusca() {
    campoBusca.value = '';
    btnLimpar.style.display = 'none'; 
    realizarBusca(''); 
    campoBusca.focus();
}