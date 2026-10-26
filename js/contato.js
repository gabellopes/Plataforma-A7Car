document.getElementById('contatoForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const nome = document.getElementById('nome').value.trim();
    const atendimento = document.getElementById('Atendimento').value;

    const numeroWhatsApp = document.getElementById('numeroWhatsApp').value;

    if (!numeroWhatsApp) {
        alert('Número do WhatsApp não configurado.');
        return;
    }

    const mensagem = `Olá! Meu nome é ${nome} e gostaria ${atendimento}.`;
    const urlWhatsApp = `https://wa.me/${numeroWhatsApp}?text=${encodeURIComponent(mensagem)}`;
    
    window.location.href = urlWhatsApp;
});