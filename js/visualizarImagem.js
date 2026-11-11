const inputImagem = document.getElementById('Imagem');
const previewImagem = document.getElementById('preview-imagem');

inputImagem.addEventListener('change', function(event) {
    const arquivo = event.target.files[0];

    if (arquivo) {
        const leitor = new FileReader();

        leitor.onload = function(e) {
            previewImagem.src = e.target.result;
            previewImagem.style.display = 'block'; 
        }

        leitor.readAsDataURL(arquivo);
    } else {
        previewImagem.src = '#';
        previewImagem.style.display = 'none'; 
    }
});
