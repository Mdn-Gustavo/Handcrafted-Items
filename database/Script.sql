CREATE TABLE IF NOT EXISTS usuarios(
	id INT AUTO_INCREMENT PRIMARY KEY,
	nome VARCHAR(100) NOT NULL,
	email VARCHAR(150) UNIQUE NOT NULL,
	senha VARCHAR(255) NOT NULL,
	criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS categorias (
	id INT AUTO_INCREMENT PRIMARY KEY,
	nome VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS produtos (
	id INT AUTO_INCREMENT PRIMARY KEY,
	nome VARCHAR(100) NOT NULL,
	descricao TEXT,
	preco DECIMAL(10,2),
	imagem VARCHAR(255),
	categoria_id INT,
	FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

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

ALTER TABLE produtos
ADD COLUMN estoque INT DEFAULT 0,
ADD COLUMN destaque BOOLEAN DEFAULT FALSE,
ADD COLUMN detalhes TEXT;


INSERT INTO categorias (nome)
VALUES
('Sabonetes'),
('Cerâmicas'),
('Chás');


-- sabonete
INSERT INTO produtos
(nome, descricao, preco, imagem, estoque, destaque, detalhes, categoria_id)
VALUES
(
'Sabonete de Rosas',
'Uma barra suave e perfumada, com pétalas de rosa e argila rosa.',
30.00,
'sabonete01.png',
15,
TRUE,
'Sabonete artesanal enriquecido com pétalas de rosa e argila rosa natural. Ideal para hidratação e cuidados diários.',
1
);

INSERT INTO produtos
(nome, descricao, preco, imagem, estoque, destaque, detalhes, categoria_id)
VALUES
(
'Sabonete de Mel e Calêndula',
'Uma barra translúcida e dourada com pétalas de calêndula e mel.',
32.99,
'sabonete02.jpeg',
10,
TRUE,
'Produzido com mel e flores de calêndula, proporcionando suavidade e hidratação para a pele.',
1
);

INSERT INTO produtos
(nome, descricao, preco, imagem, estoque, destaque, detalhes, categoria_id)
VALUES
(
'Swirl de Menta e Eucalipto',
'Barra refrescante com padrão espiral verde e branco.',
33.00,
'sabonete03.png',
8,
FALSE,
'Combinação refrescante de menta e eucalipto para um banho revigorante.',
1
);

INSERT INTO produtos
(nome, descricao, preco, imagem, estoque, destaque, detalhes, categoria_id)
VALUES
(
'Sabonete de Carvão Ativado',
'Barra preta elegante com textura esfoliante suave.',
35.50,
'sabonete04.png',
12,
TRUE,
'Contém carvão ativado, auxiliando na limpeza profunda da pele.',
1
);

INSERT INTO produtos
(nome, descricao, preco, imagem, estoque, destaque, detalhes, categoria_id)
VALUES
(
'Sabonete de Lavanda e Aveia',
'Barra calmante com flores de lavanda e aveia.',
32.00,
'sabonete05.png',
6,
FALSE,
'Indicado para momentos de relaxamento e cuidados delicados com a pele.',
1
);

-- ceramica 
INSERT INTO produtos
(nome, descricao, preco, imagem, estoque, destaque, detalhes, categoria_id)
VALUES
(
'Cerâmica Laranja e Canela Especiada',
'Glaze âmbar dourado com visual acolhedor.',
49.99,
'ceramica01.jpeg',
5,
TRUE,
'Peça artesanal com acabamento rústico inspirada em tons de canela e laranja.',
2
);

INSERT INTO produtos
(nome, descricao, preco, imagem, estoque, destaque, detalhes, categoria_id)
VALUES
(
'Cerâmica Carvão Ativado',
'Glaze preto fosco com salpicos cinzas.',
49.99,
'ceramica02.png',
3,
FALSE,
'Design moderno com acabamento minimalista e elegante.',
2
);

INSERT INTO produtos
(nome, descricao, preco, imagem, estoque, destaque, detalhes, categoria_id)
VALUES
(
'Cerâmica Lavanda e Aveia',
'Glaze lilás suave com detalhes off-white.',
49.99,
'ceramica03.png',
7,
TRUE,
'Peça decorativa inspirada em tons suaves e relaxantes.',
2
);

INSERT INTO produtos
(nome, descricao, preco, imagem, estoque, destaque, detalhes, categoria_id)
VALUES
(
'Cerâmica Café e Canela',
'Glaze marrom profundo com textura granulada.',
49.99,
'ceramica04.png',
4,
FALSE,
'Inspirada nos aromas intensos do café e especiarias.',
2
);

INSERT INTO produtos
(nome, descricao, preco, imagem, estoque, destaque, detalhes, categoria_id)
VALUES
(
'Cerâmica Chá de Limão',
'Glaze amarelo-limão com acabamento rústico.',
49.99,
'ceramica05.png',
9,
TRUE,
'Peça artesanal com visual cítrico e acabamento texturizado.',
2
);

-- chazinho

INSERT INTO produtos
(nome, descricao, preco, imagem, estoque, destaque, detalhes, categoria_id)
VALUES
(
'Mistura Lavanda, Camomila e Melissa',
'Blend relaxante com flores e ervas aromáticas.',
22.99,
'LavanCamoMeli.png',
20,
TRUE,
'Ideal para relaxamento e momentos de tranquilidade.',
3
);

INSERT INTO produtos
(nome, descricao, preco, imagem, estoque, destaque, detalhes, categoria_id)
VALUES
(
'Mistura Menta, Funcho e Coentro',
'Blend refrescante de ervas secas.',
22.99,
'MentaFunchoCoen.png',
18,
FALSE,
'Combinação aromática de menta, funcho e sementes de coentro.',
3
);

INSERT INTO produtos
(nome, descricao, preco, imagem, estoque, destaque, detalhes, categoria_id)
VALUES
(
'Mistura Eucalipto, Malva e Tomilho',
'Mix herbal com notas medicinais e aromáticas.',
22.99,
'EucaliptoMelissa.png',
11,
FALSE,
'Blend elaborado para proporcionar aroma intenso e agradável.',
3
);

INSERT INTO produtos
(nome, descricao, preco, imagem, estoque, destaque, detalhes, categoria_id)
VALUES
(
'Mistura Urtiga, Dente-de-Leão e Lúcia-Lima',
'Infusão herbal rica em ingredientes naturais.',
22.99,
'UtigaDDLLucia.png',
14,
FALSE,
'Combinação equilibrada de ervas selecionadas artesanalmente.',
3
);

INSERT INTO produtos
(nome, descricao, preco, imagem, estoque, destaque, detalhes, categoria_id)
VALUES
(
'Hibisco, Rosa Mosqueta e Alecrim',
'Blend colorido com hibisco e ervas aromáticas.',
22.99,
'HibiscRosaAlecrim.png',
25,
TRUE,
'Infusão marcante com notas florais e aroma herbal.',
3
);

-- conferindo

SELECT
    p.id,
    p.nome,
    c.nome AS categoria,
    p.preco,
    p.estoque,
    p.destaque
FROM produtos p
INNER JOIN categorias c
ON c.id = p.categoria_id
ORDER BY p.id;

SELECT COUNT(*) FROM produtos;


