DROP DATABASE IF EXISTS handcrafted_items;
CREATE DATABASE handcrafted_items CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE handcrafted_items;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tipo_usuario ENUM('admin', 'comum') NOT NULL DEFAULT 'comum',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    preco DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    imagem VARCHAR(255) NOT NULL,
    estoque INT NOT NULL DEFAULT 0,
    destaque TINYINT(1) NOT NULL DEFAULT 0,
    detalhes TEXT,
    categoria_id INT NOT NULL,
    CONSTRAINT fk_produtos_categorias
        FOREIGN KEY (categoria_id)
        REFERENCES categorias(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

INSERT INTO usuarios (nome, email, senha, tipo_usuario) VALUES
('Administrador', 'admin@admin.com', '$2y$12$bxxmv.YMH3ayaOI9XiFrx.VYYE4osoNhy0prSVwKEv8wPGxDtwik6', 'admin');

INSERT INTO categorias (nome) VALUES
('Sabonetes'),
('Cerâmicas'),
('Chás');

INSERT INTO produtos (nome, descricao, preco, imagem, estoque, destaque, detalhes, categoria_id) VALUES
('Sabonete de Rosas', 'Uma barra suave e perfumada, com pétalas de rosa e argila rosa.', 30.00, 'sabonete01.png', 15, 1, 'Sabonete artesanal enriquecido com pétalas de rosa e argila rosa natural. Ideal para hidratação e cuidados diários.', 1),
('Sabonete de Mel e Calêndula', 'Uma barra translúcida e dourada com pétalas de calêndula e mel.', 32.99, 'sabonete02.jpeg', 10, 1, 'Produzido com mel e flores de calêndula, proporcionando suavidade e hidratação para a pele.', 1),
('Swirl de Menta e Eucalipto', 'Barra refrescante com padrão espiral verde e branco.', 33.00, 'sabonete03.png', 8, 0, 'Combinação refrescante de menta e eucalipto para um banho revigorante.', 1),
('Sabonete de Carvão Ativado', 'Barra preta elegante com textura esfoliante suave.', 35.50, 'sabonete04.png', 12, 1, 'Contém carvão ativado, auxiliando na limpeza profunda da pele.', 1),
('Sabonete de Lavanda e Aveia', 'Barra calmante com flores de lavanda e aveia.', 32.00, 'sabonete05.png', 6, 0, 'Indicado para momentos de relaxamento e cuidados delicados com a pele.', 1),
('Cerâmica Laranja e Canela Especiada', 'Glaze âmbar dourado com visual acolhedor.', 49.99, 'ceramica01.jpeg', 5, 1, 'Peça artesanal com acabamento rústico inspirada em tons de canela e laranja.', 2),
('Cerâmica Carvão Ativado', 'Glaze preto fosco com salpicos cinzas.', 49.99, 'ceramica02.png', 3, 0, 'Design moderno com acabamento minimalista e elegante.', 2),
('Cerâmica Lavanda e Aveia', 'Glaze lilás suave com detalhes off-white.', 49.99, 'ceramica03.png', 7, 1, 'Peça decorativa inspirada em tons suaves e relaxantes.', 2),
('Cerâmica Café e Canela', 'Glaze marrom profundo com textura granulada.', 49.99, 'ceramica04.png', 4, 0, 'Inspirada nos aromas intensos do café e especiarias.', 2),
('Cerâmica Chá de Limão', 'Glaze amarelo-limão com acabamento rústico.', 49.99, 'ceramica05.png', 9, 1, 'Peça artesanal com visual cítrico e acabamento texturizado.', 2),
('Mistura Lavanda, Camomila e Melissa', 'Blend relaxante com flores e ervas aromáticas.', 22.99, 'LavanCamoMeli.png', 20, 1, 'Ideal para relaxamento e momentos de tranquilidade.', 3),
('Mistura Menta, Funcho e Coentro', 'Blend refrescante de ervas secas.', 22.99, 'MentaFunchoCoen.png', 18, 0, 'Combinação aromática de menta, funcho e sementes de coentro.', 3),
('Mistura Eucalipto, Malva e Tomilho', 'Mix herbal com notas medicinais e aromáticas.', 22.99, 'EucaliptoMelissa.png', 11, 0, 'Blend elaborado para proporcionar aroma intenso e agradável.', 3),
('Mistura Urtiga, Dente-de-Leão e Lúcia-Lima', 'Infusão herbal rica em ingredientes naturais.', 22.99, 'UtigaDDLLucia.png', 14, 0, 'Combinação equilibrada de ervas selecionadas artesanalmente.', 3),
('Hibisco, Rosa Mosqueta e Alecrim', 'Blend colorido com hibisco e ervas aromáticas.', 22.99, 'HibiscRosaAlecrim.png', 25, 1, 'Infusão marcante com notas florais e aroma herbal.', 3);
