# Plataforma-A7Car
link do protótipo:
https://place-pic-60929211.figma.site/

ALTER BD
tabela carro
-> atributo status_car tinyint 1 (valor default 0)
-> atributo data_car DATE
-> CREATE TABLE IF NOT EXISTS password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usu INT NOT NULL,
    token VARCHAR(255) NOT NULL,
    expira_em DATETIME NOT NULL,
    usado TINYINT(1) NOT NULL DEFAULT 0,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_reset_usuario FOREIGN KEY (id_usu) REFERENCES usuario(id_usu) ON DELETE CASCADE
);
tabela usuario
-> status_usu tinyint(1) DEFAULT '0'

PROBLEMAS ENCONTRADOS
-> ADICIONAR FORMA DE PAGAMENTO NA VENDA
-> SE É A VISTA OU PARCELADO, e se sim em quantas vezes
-> Fazer uma tela no admin mostrando os carros que ainda estão sendo pagos
-> Tabela simulação não cadastra o telefone
-> Adicionar Data do cadastro dos *veiculos, colaboradores e clientes e *vendas
-> Data que o carro foi cadastrado


->Corrigir simulacao, não precisa de cpf_simu, etc. Apenas dos ids do funcionario, carro e da propria simulacao
-> Acrescentar uma data para a simulação, quando ela foi feita
-> Cnh não pode ser obrigatorio