document.getElementById('campoBusca').addEventListener('input', async function() {
    const termo = this.value;
    const listaVeiculos = document.getElementById('listaVeiculos');

    // MÁGICA AQUI: Atualiza a URL na barra do navegador em tempo real
    // Se tiver texto, coloca o ?busca=termo. Se estiver vazio, limpa a URL deixando só catalogo.php
    const novaURL = termo ? `catalogo.php?busca=${encodeURIComponent(termo)}` : 'catalogo.php';
    window.history.replaceState(null, '', novaURL);

    try {
        // Faz a requisição para o PHP
        const response = await fetch(`buscarCarro.php?busca=${encodeURIComponent(termo)}`);
        
        // Injeta os novos carros na tela
        const html = await response.text();
        listaVeiculos.innerHTML = html;
    } catch (error) {
        console.error('Erro ao buscar veículos:', error);
    }
});
const campoBusca = document.getElementById("campoBusca");
function cancelarBusca(){
    campoBusca.value = '';
    
    campoBusca.focus();
    
    const evento = new Event('input');
    campoBusca.dispatchEvent(evento);
}