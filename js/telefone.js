const Telefone = document.getElementById("Telefone");
if (Telefone) {

Telefone.addEventListener('input', (e) => {
let value = e.target.value.replace(/\D/g, '');

if (value.length > 10) {
    value = value.replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1) $2-$3');
        } else if (value.length > 6) {
                        value = value.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, '($1) $2-$3');
                        
        } else if (value.length > 2) {
                        value = value.replace(/^(\d{2})(\d{0,5})/, '($1) $2');
        } else if (value.length > 0) {
                        value = value.replace(/^(\d*)/, '($1');
        }

        e.target.value = value;
         });//Fim do Telefone.addEventListener

}

