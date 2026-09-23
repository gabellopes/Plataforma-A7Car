document.addEventListener('DOMContentLoaded', () => {
    const Nome = document.getElementById("Nome");
    const Telefone = document.getElementById("Telefone");
    const Cpf = document.getElementById("Cpf");
    const botaobuscar = document.getElementById("BuscarCpf");

    async function buscarcpf(evento) {
        // Evita comportamento padrão de formulário (recarregar a página)
        if (evento) evento.preventDefault();

        try {
            validarCpf();
            const response = await fetch(`/a7car2/php/salvar/BuscarCpf.php?Cpf=${Cpf.value}`);
            const dados = await response.json();
            
            if (dados.sucesso) {
                Nome.value = dados.nome;
                Telefone.value = dados.telefone;
            } else {
                alert(dados.mensagem);
                Nome.value = '';
                Telefone.value = '';
            }
        } catch (error) {
            console.error('Erro na requisição:', error);
            alert('Erro ao buscar os dados.');
        }
    }

    // Garante que o botão existe antes de adicionar o evento
    if (botaobuscar) {
        botaobuscar.addEventListener('click', buscarcpf);
    }
});