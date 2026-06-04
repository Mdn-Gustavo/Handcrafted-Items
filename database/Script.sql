CREATE TABLE usuarios(
	id INT AUTO_INCREMENT PRIMARY KEY,
	nome VARCHAR(100) NOT NULL,
	email VARCHAR(150) UNIQUE NOT NULL,
	senha VARCHAR(255) NOT NULL,
	criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categorias (
	id INT AUTO_INCREMENT PRIMARY KEY,
	nome VARCHAR(100) NOT NULL
);

CREATE TABLE produtos (
	id INT AUTO_INCREMENT PRIMARY KEY,
	nome VARCHAR(100) NOT NULL,
	descricao TEXT,
	preco DECIMAL(10,2),
	imagem VARCHAR(255),
	categoria_id INT,
	FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

INSERT INTO  categorias(nome)
VALUES ('Madeira'), ('Crochê'), ('Cerâmica');

INSERT INTO produtos
(
    nome,
    descricao,
    preco,
    categoria_id
)
VALUES
(
    'Vaso Artesanal',
    'Feito à mão',
    49.90,
    3
);

SELECT * FROM produtos;
SELECT * FROM categorias;

1
