function buscarcpf(){
const botaobuscar = documentos.getElementById("BuscarCpf");
validarCpf();

botaobuscar.addEventListener('click', async () => {

    try {

        const response = await fetch(`../php/salvar/BuscarCpf.php?Cpf=${Cpf.value}`);
        const dados = await response.json();

        if (dados.sucesso) {
            // Preenche os inputs com os dados que vieram do PHP
            Nome.value = dados.nome;
            document.getElementById('Telefone').value = dados.telefone;
        } else {
            alert(dados.mensagem);
            // Limpa os campos se não encontrar
            Nome.value = '';
            document.getElementById('Telefone').value = '';
        }

    } catch (error) {
        console.error('Erro na requisição:', error);
        alert('Erro ao buscar os dados.');
    }
});

}