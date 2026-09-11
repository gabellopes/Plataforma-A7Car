const Telefone = document.getElementById("Telefone");
const Cpf = document.getElementById("Cpf");
const Cnh = document.getElementById("Cnh");

if (Telefone) {

  Telefone.addEventListener('input', (e) => {
    let value = e.target.value.replace(/\D/g, '');
    value = value.substring(0, 11);
    if (value.length > 2) {
      value = value.replace(/^(\d{2})(\d{0,5})/, '($1) $2');
    } else if (value.length > 0) {
      value = value.replace(/^(\d*)/, '($1');
    }

    e.target.value = value;
  });

}

if (Cpf) {
    Cpf.addEventListener('input', (e) => {
      let value = e.target.value.replace(/\D/g, '');
  
      value = value.substring(0, 11);
  
      if (value.length > 9) {

        value = value.replace(/^(\d{3})(\d{3})(\d{3})(\d{0,2}).*/, '$1.$2.$3-$4');
      } else if (value.length > 6) {

        value = value.replace(/^(\d{3})(\d{3})(\d{0,3})/, '$1.$2.$3');
      } else if (value.length > 3) {

        value = value.replace(/^(\d{3})(\d{0,3})/, '$1.$2');
      } else if (value.length > 0) {

        value = value.replace(/^(\d*)/, '$1');
      }
  
      e.target.value = value;
    });
  }






