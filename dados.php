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
        "preco"     => 30.00,
        "imagem"    => "sabonete01.png",
        "descricao" => "Uma barra suave e perfumada, com pétalas de rosa e a cor natural e delicada da argila rosa.",
        "categoria" => "Sabonetes"
    ],
    [
        "id"        => 2,
        "nome"      => "Sabonede de Mel e Calêndula",
        "preco"     => 32.99,
        "imagem"    => "sabonete02.png",
        "descricao" => "Uma barra translúcida e dourada, com pétalas de calêndula a doçura do mel.",
        "categoria" => "Sabonetes"
    ],
    [
        "id"        => 3,
        "nome"      => "Swirl de Menta e Eucalipto",
        "preco"     => 33.00,
        "imagem"    => "sabonete03.png",
        "descricao" => "Uma barra refrescante com um padrão em espiral verde e branco, ideal para um banho revigorante.",
        "categoria" => "Sabonetes"
    ],
    [
        "id"        => 4,
        "nome"      => "Sabonete de Carvão Ativado",
        "preco"     => 35.50,
        "imagem"    => "sabonete04.png",
        "descricao" => "Uma barra preta e elegante, com um design moderno e uma textura esfoliante sutil.",
        "categoria" => "Sabonetes"
    ],
    [
        "id"        => 5,
        "nome"      => "Sabonete de Lavanda e Aveia",
        "preco"     => 32.00,
        "imagem"    => "sabonete05.png",
        "descricao" => "Uma barra calmante e suave, com flores de lavanda e flocos de aveia, perfeita para um momento de relaxamento.",
        "categoria" => "Sabonetes"
    ],
    [
        "id"        => 6,
        "nome"      => "Cerâmica Laranja e Canela Especiada",
        "preco"     => 49.99,
        "imagem"    => "ceramica01.png",
        "descricao" => "Glaze âmbar/dourado com speckling coarse, para um visual quente e acolhedor.",
        "categoria" => "Cerâmicas"
    ],
    [
        "id"        => 7,
        "nome"      => "Cerâmica Carvão Ativado",
        "preco"     => 49.99,
        "imagem"    => "ceramica02.png",
        "descricao" => "Glaze preto mate com salpicos cinzas e brancos, limpo e direto.",
        "categoria" => "Cerâmicas"
    ],
    [
        "id"        => 8,
        "nome"      => "Cerâmica Lavanda e Aveia",
        "preco"     => 49.99,
        "imagem"    => "ceramica03.png",
        "descricao" => "Glaze lilás suave com speckling off-white e azul, para uma sensação calmante.",
        "categoria" => "Cerâmicas"
    ],
    [
        "id"        => 9,
        "nome"      => "Cerâmica Café e Canela",
        "preco"     => 49.99,
        "imagem"    => "ceramica04.png",
        "descricao" => "Glaze marrom profundo e texturizado com salpicos 'grão de café', lembrando o aroma robusto.",
        "categoria" => "Cerâmicas"
    ],
    [
        "id"        => 10,
        "nome"      => "Cerâmica Chá de Limão",
        "preco"     => 49.99,
        "imagem"    => "ceramica05.png",
        "descricao" => "Com uma textura granulada e glaze amarelo-limão rústico, evocando o frescor cítrico.",
        "categoria" => "Cerâmicas"
    ],
    [
        "id"        => 11,
        "nome"      => "Mistura Lavanda, Camomila e Melissa",
        "preco"     => 22.99,
        "imagem"    => "LavanCamoMeli.png",
        "descricao" => "Os ingredientes principais se misturam: as flores de lavanda trazem toques sutis de roxo, contrastando com o branco e amarelo das pétalas de camomila e o verde suave das folhas de melissa.",
        "categoria" => "Chás"
    ],
    [
        "id"        => 12,
        "nome"      => "Mistura Menta, Funcho e Coentro",
        "preco"     => 22.99,
        "imagem"    => "MentaFunchoCoen.png",
        "descricao" => "A menta seca domina o visual com suas folhas verdes, misturadas com as sementes de funcho e as sementes de coentro.",
        "categoria" => "Chás"
    ],
    [
        "id"        => 13,
        "nome"      => "Mistura Eucalipto, Malva e Tomilho",
        "preco"     => 22.99,
        "imagem"    => "EucaliptoMelissa.png",
        "descricao" => "As folhas de eucalipto seco misturam-se com as flores de malva, que introduzem pontos de roxo vibrante. O tomilho seco preenche os espaços, criando uma textura complexa e medicinal.",
        "categoria" => "Chás"
    ],
    [
        "id"        => 14,
        "nome"      => "Mistura Urtiga, Dente-de-Leão e Lúcia-Lima",
        "preco"     => 22.99,
        "imagem"    => "UrtigaDDLLucia.png",
        "descricao" => "A urtiga seca mistura-se com pedaços da raiz de dente-de-leão e as folhas de lúcia-lima.",
        "categoria" => "Chás"
    ],
    [
        "id"        => 15,
        "nome"      => "Hibisco, Rosa Mosqueta e Alecrim",
        "preco"     => 22.99,
        "imagem"    => "HibiscoRosaAlecrim.png",
        "descricao" => "As flores de hibisco seco dominam o visual, misturadas com pedaços de casca de rosa mosqueta e as agulhas verdes e finas do alecrim.",
        "categoria" => "Chás"
    ],
];
