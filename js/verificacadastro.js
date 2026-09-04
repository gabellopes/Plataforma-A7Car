const Nome = document.getElementById("Nome");
const Email = document.getElementById("Email");
const Telefone = document.getElementById("Telefone");
const Senha = document.getElementById("Senha");
const ConfirmarSenha = document.getElementById("Confirmar-senha");
const botaoCadastrar = document.getElementById("Cadastrar");
let Mensagem = document.getElementById("Mensagem");
Mensagem.style.color = "red";

Nome.value = " ";
Email.value = " ";
Telefone.value = " ";
Senha.value = " ";
ConfirmarSenha.value = " ";

function preencher(){
Nome.value = "Joana";
Email.value = "joana@example.com";
Telefone.value = "(11) 98765-4321";
Senha.value = "Senha123";
ConfirmarSenha.value = "Senha124";
}
function validarCadastro() {
    validarEmail();
    validarSenha();
}
function validarSenha() {
const regexCaracteresEspeciais = /[@$!%*?&]/;

   if(Senha.value !== ConfirmarSenha.value) {
        Mensagem.textContent = "As senhas não coincidem!";
        return false;

    }else if(Senha.value.length < 8 || ConfirmarSenha.value.length < 8) {
        Mensagem.textContent = "A senha deve ter no mínimo 8 caracteres!";
        return false;

    }else if (!regexCaracteresEspeciais.test(Senha.value)) {
        Mensagem.textContent = "A senha deve conter pelo menos um caractere especial!";
        return false;
    }else if (!/[A-Z]/.test(Senha.value)) {
        Mensagem.textContent = "A senha deve conter pelo menos uma letra maiúscula!";
        return false;
    }else if (!/[a-z]/.test(Senha.value)) {
        Mensagem.textContent = "A senha deve conter pelo menos uma letra minúscula!";
        return false;
        
    }else{
        Mensagem.textContent = "";
        botaoCadastrar.type = "submit"; 
        return true;
    }
}

function validarEmail(){
    if (!Email.value.match(/^[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$/)) {
        Mensagem.textContent = "Formato de e-mail inválido!";
        return false;
    }else{
        Mensagem.textContent = "";
        validarSenha();
    }

}

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

}//Fim do telefone    
/*  
// Elementos da lista de requisitos
const reqLength = document.getElementById('length');
const reqUppercase = document.getElementById('uppercase');
const reqLowercase = document.getElementById('lowercase');
const reqNumber = document.getElementById('number');
const reqSpecial = document.getElementById('special');

// Regras com Expressões Regulares (Regex)
const regras = {
  length: (val) => val.length >= 8,
  uppercase: (val) => /[A-Z]/.test(val),
  lowercase: (val) => /[a-z]/.test(val),
  number: (val) => /[0-9]/.test(val),
  special: (val) => /[@$!%*?&]/.test(val)
};

// Evento escutado a cada tecla digitada
inputSenha.addEventListener('input', function () {
  const senha = this.value;

  // Atualiza a classe 'valido' para cada requisito
  atualizarStatus(reqLength, regras.length(senha));
  atualizarStatus(reqUppercase, regras.uppercase(senha));
  atualizarStatus(reqLowercase, regras.lowercase(senha));
  atualizarStatus(reqNumber, regras.number(senha));
  atualizarStatus(reqSpecial, regras.special(senha));
});

function atualizarStatus(elemento, ehValido) {
  if (ehValido) {
    elemento.classList.add('valido');
  } else {
    elemento.classList.remove('valido');
  }
}

// Função auxiliar caso precise validar antes de submeter o formulário
function validarSenhaCompleta(senha) {
  return Object.values(regras).every(regra => regra(senha));
}       

*/