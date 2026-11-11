let offset = 0; 
const limit = 6;
const btnCarregar = document.getElementById('btn-carregar-mais');
const containerVeiculos = document.getElementById('listaVeiculos'); 
const inputBusca = document.getElementById('campoBusca'); 

async function carregarMais() {
    try {
        if (!btnCarregar) return;
        
        btnCarregar.disabled = true;
        btnCarregar.textContent = "Carregando...";

        offset += limit; 
        const termoBusca = inputBusca ? inputBusca.value : '';

        const response = await fetch(`buscarCarro.php?offset=${offset}&busca=${termoBusca}`);
        const htmlRetornado = await response.text();

        if (htmlRetornado.includes("Nenhum veículo encontrado") || htmlRetornado.trim() === "") {
            btnCarregar.style.display = 'none';
        } else {
            containerVeiculos.insertAdjacentHTML('beforeend', htmlRetornado);
        }

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