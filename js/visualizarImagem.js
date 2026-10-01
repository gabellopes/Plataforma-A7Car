const inputImagem = document.getElementById('Imagem');
console.log(inputImagem);
console.log(inputImagem.file);
const previewImagem = document.getElementById('preview-imagem');
console.log(previewImagem);

inputImagem.addEventListener('change', function(event) {
    const arquivo = event.target.files[0];

    if (arquivo) {
        const leitor = new FileReader();

        leitor.onload = function(e) {
            previewImagem.src = e.target.result;
            previewImagem.style.display = 'block'; // Mostra a imagem
        }

        leitor.readAsDataURL(arquivo);
    } else {
        previewImagem.src = '#';
        previewImagem.style.display = 'none'; // Esconde se cancelar
    }
});
