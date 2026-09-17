function buscarcpf(){
const Nome = document.getElementById("Nome");
const Telefone = document.getElementById("Telefone");
const Cpf = document.getElementById("Cpf");
const botaobuscar = document.getElementById("BuscarCpf");


validarCpf();

botaobuscar.addEventListener('click', async () => {

    try {

        const response = await fetch(`/a7car2/php/salvar/BuscarCpf.php?Cpf=${Cpf.value}`);
        const dados = await response.json();

        if (dados.sucesso) {
            // Preenche os inputs com os dados que vieram do PHP
            Nome.value = dados.nome;
            Telefone.value = dados.telefone;
        } else {
            alert(dados.mensagem);
            // Limpa os campos se não encontrar
            Nome.value = '';
            Telefone.value = '';
        }

    } catch (error) {
        console.error('Erro na requisição:', error);
        alert('Erro ao buscar os dados.');
    }
});

}