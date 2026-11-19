document.addEventListener('DOMContentLoaded', function () {
    const inputFotos = document.getElementById('Imagem');
    const previewContainer = document.getElementById('preview-container');
    const removidasContainer = document.getElementById('imagens-removidas-container');
    const previewUnico = document.getElementById('preview-imagem');

    if (!inputFotos) return;

    if (previewContainer) {
        let listaArquivos = [];

        function atualizarCapa() {
            const itens = previewContainer.querySelectorAll('.preview-item');

            itens.forEach((item, index) => {
                const img = item.querySelector('img');
                const badgeAntigo = item.querySelector('.badge-capa');
                if (badgeAntigo) badgeAntigo.remove();

                if (index === 0) {
                    if (img) img.style.border = '3px solid #007bff';

                    const badge = document.createElement('span');
                    badge.className = 'badge-capa';
                    badge.textContent = 'Capa';
                    badge.style.cssText =
                        'position:absolute; top:4px; left:4px; background:#007bff; color:#fff; font-size:11px; padding:2px 6px; border-radius:4px;';
                    item.appendChild(badge);
                } else {
                    if (img) img.style.border = '1px solid #ccc';
                }
            });
        }

        previewContainer.querySelectorAll('.btn-remover-existente').forEach(btn => {
            btn.addEventListener('click', function () {
                const item = this.closest('.preview-item');
                const idImg = item.dataset.id;

                if (idImg && removidasContainer) {
                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'imagens_remover[]';
                    hidden.value = idImg;
                    removidasContainer.appendChild(hidden);
                }

                item.remove();
                atualizarCapa();
            });
        });

        atualizarCapa();

        inputFotos.addEventListener('change', function () {
            const novosArquivos = Array.from(this.files);

            novosArquivos.forEach(arquivo => {
                if (!arquivo.type.startsWith('image/')) {
                    alert('Selecione apenas arquivos de imagem (JPG, PNG ou WEBP).');
                    return;
                }

                const jaExiste = listaArquivos.some(
                    item => item.name === arquivo.name && item.size === arquivo.size
                );

                if (!jaExiste) {
                    listaArquivos.push(arquivo);
                }
            });

            atualizarInputEPreview();
        });

        function atualizarInputEPreview() {
            const dataTransfer = new DataTransfer();
            listaArquivos.forEach(arquivo => dataTransfer.items.add(arquivo));
            inputFotos.files = dataTransfer.files;

            previewContainer.querySelectorAll('.imagem-nova').forEach(el => el.remove());

            listaArquivos.forEach((arquivo, index) => {
                const wrapper = document.createElement('div');
                wrapper.className = 'preview-item imagem-nova';
                wrapper.style.position = 'relative';

                const img = document.createElement('img');
                img.alt = 'Pré-visualização ' + (index + 1);
                img.style.width = '120px';
                img.style.height = '90px';
                img.style.objectFit = 'cover';
                img.style.borderRadius = '6px';
                img.style.border = '1px solid #ccc';
                img.style.display = 'block';

                const btnRemover = document.createElement('button');
                btnRemover.type = 'button';
                btnRemover.textContent = '×';
                btnRemover.title = 'Remover imagem';
                btnRemover.style.cssText =
                    'position:absolute; top:4px; right:4px; background:rgba(220,53,69,0.9); color:#fff; border:none; border-radius:50%; width:20px; height:20px; cursor:pointer; font-weight:bold; line-height:18px; padding:0;';
                btnRemover.addEventListener('click', function () {
                    listaArquivos.splice(index, 1);
                    atualizarInputEPreview();
                });

                wrapper.appendChild(img);
                wrapper.appendChild(btnRemover);
                previewContainer.appendChild(wrapper);

                const reader = new FileReader();
                reader.onload = function (e) {
                    img.src = e.target.result;
                };
                reader.readAsDataURL(arquivo);
            });

            atualizarCapa();
        }

        return;
    }

    if (previewUnico) {
        inputFotos.addEventListener('change', function () {
            const arquivo = this.files[0];
            if (!arquivo || !arquivo.type.startsWith('image/')) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                previewUnico.src = e.target.result;
                previewUnico.style.display = 'block';
            };
            reader.readAsDataURL(arquivo);
        });
    }
});