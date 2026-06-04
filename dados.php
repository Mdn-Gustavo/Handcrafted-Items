<?php

if (!defined('ACESSO_PERMITIDO')) {
    http_response_code(403);
    exit('Acesso negado.');
}

$categorias = [
    'Sabonetes',
    'Cerâmicas',
    'Chás',
];

$produtos = [
    [
        "id"        => 1,
        "nome"      => "Sabonete de Rosas",
        "categoria" => "Sabonetes",
        "preco"     => 30.00,
        "descricao" => "Uma barra suave e perfumada, com pétalas de rosa e a cor natural e delicada da argila rosa.",
        "imagem"    => "sabonete01.png"
    ],
    [
        "id"        => 2,
        "nome"      => "Sabonede de Mel e Calêndula",
        "categoria" => "Sabonetes",
        "preco"     => 32.99,
        "descricao" => "Uma barra translúcida e dourada, com pétalas de calêndula a doçura do mel.",
        "imagem"    => "sabonete02.jpeg"
    ],
    [
        "id"        => 3,
        "nome"      => "Swirl de Menta e Eucalipto",
        "categoria" => "Sabonetes",
        "preco"     => 33.00,
        "descricao" => "Uma barra refrescante com um padrão em espiral verde e branco, ideal para um banho revigorante.",
        "imagem"    => "sabonete03.png"
    ],
    [
        "id"        => 4,
        "nome"      => "Sabonete de Carvão Ativado",
        "categoria" => "Sabonetes",
        "preco"     => 35.50,
        "descricao" => "Uma barra preta e elegante, com um design moderno e uma textura esfoliante sutil.",
        "imagem"    => "sabonete04.png"
    ],
    [
        "id"        => 5,
        "nome"      => "Sabonete de Lavanda e Aveia",
        "categoria" => "Sabonetes",
        "preco"     => 32.00,
        "descricao" => "Uma barra calmante e suave, com flores de lavanda e flocos de aveia, perfeita para um momento de relaxamento.",
        "imagem"    => "sabonete05.png"
    ],
    [
        "id"        => 6,
        "nome"      => "Cerâmica Laranja e Canela Especiada",
        "categoria" => "Cerâmicas",
        "preco"     => 49.99,
        "descricao" => "Glaze âmbar/dourado com speckling coarse, para um visual quente e acolhedor.",
        "imagem"    => "ceramica01.jpeg"
    ],
    [
        "id"        => 7,
        "nome"      => "Cerâmica Carvão Ativado",
        "categoria" => "Cerâmicas",
        "preco"     => 49.99,
        "descricao" => "Glaze preto mate com salpicos cinzas e brancos, limpo e direto.",
        "imagem"    => "ceramica02.png"
    ],
    [
        "id"        => 8,
        "nome"      => "Cerâmica Lavanda e Aveia",
        "categoria" => "Cerâmicas",
        "preco"     => 49.99,
        "descricao" => "Glaze lilás suave com speckling off-white e azul, para uma sensação calmante.",
        "imagem"    => "ceramica03.png"
    ],
    [
        "id"        => 9,
        "nome"      => "Cerâmica Café e Canela",
        "categoria" => "Cerâmicas",
        "preco"     => 49.99,
        "descricao" => "Glaze marrom profundo e texturizado com salpicos 'grão de café', lembrando o aroma robusto.",
        "imagem"    => "ceramica04.png"
    ],
    [
        "id"        => 10,
        "nome"      => "Cerâmica Chá de Limão",
        "categoria" => "Cerâmicas",
        "preco"     => 49.99,
        "descricao" => "Com uma textura granulada e glaze amarelo-limão rústico, evocando o frescor cítrico.",
        "imagem"    => "ceramica05.png"
    ],
    [
        "id"        => 11,
        "nome"      => "Mistura Lavanda, Camomila e Melissa",
        "categoria" => "Chás",
        "preco"     => 22.99,
        "descricao" => "Os ingredientes principais se misturam: as flores de lavanda trazem toques sutis de roxo, contrastando com o branco e amarelo das pétalas de camomila e o verde suave das folhas de melissa.",
        "imagem"    => "LavanCamoMeli.png"
    ],
    [
        "id"        => 12,
        "nome"      => "Mistura Menta, Funcho e Coentro",
        "categoria" => "Chás",
        "preco"     => 22.99,
        "descricao" => "A menta seca domina o visual com suas folhas verdes, misturadas com as sementes de funcho e as sementes de coentro.",
        "imagem"    => "MentaFunchoCoen.png"
    ],
    [
        "id"        => 13,
        "nome"      => "Mistura Eucalipto, Malva e Tomilho",
        "categoria" => "Chás",
        "preco"     => 22.99,
        "descricao" => "As folhas de eucalipto seco misturam-se com as flores de malva, que introduzem pontos de roxo vibrante. O tomilho seco preenche os espaços, criando uma textura complexa e medicinal.",
        "imagem"    => "EucaliptoMelissa.png"
    ],
    [
        "id"        => 14,
        "nome"      => "Mistura Urtiga, Dente-de-Leão e Lúcia-Lima",
        "categoria" => "Chás",
        "preco"     => 22.99,
        "descricao" => "A urtiga seca mistura-se com pedaços da raiz de dente-de-leão e as folhas de lúcia-lima.",
        "imagem"    => "UtigaDDLLucia.png"
    ],
    [
        "id"        => 15,
        "nome"      => "Hibisco, Rosa Mosqueta e Alecrim",
        "categoria" => "Chás",
        "preco"     => 22.99,
        "descricao" => "As flores de hibisco seco dominam o visual, misturadas com pedaços de casca de rosa mosqueta e as agulhas verdes e finas do alecrim.",
        "imagem"    => "HibiscRosaAlecrim.png"
    ],
];
