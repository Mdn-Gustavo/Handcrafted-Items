<?php

define('ACESSO_PERMITIDO', true);
require_once 'dados.php';

$filtro_categoria = null;
if (isset($_GET['categoria']) && $_GET['categoria'] !== '') {
    $candidata = trim($_GET['categoria']);
    if (in_array($candidata, $categorias, true)) {
        $filtro_categoria = $candidata;
    }
}

$ordens_validas = ['padrao', 'preco_asc', 'preco_desc', 'nome_az', 'nome_za'];
$filtro_ordem = 'padrao';
if (isset($_GET['ordem']) && in_array($_GET['ordem'], $ordens_validas, true)) {
    $filtro_ordem = $_GET['ordem'];
}
$filtro_destaque = isset($_GET['destaque']) && $_GET['destaque'] === '1';
$produtos_filtrados = [];

foreach ($produtos as $produto) {
    if ($filtro_categoria !== null && $produto['categoria'] !== $filtro_categoria) {
        continue;
    }

    if ($filtro_destaque && $produto['destaque'] !== true) {
        continue;
    }


    $produtos_filtrados[] = $produto;
}

switch ($filtro_ordem) {

    case 'preco_asc':
        usort($produtos_filtrados, function ($a, $b) {
            return $a['preco'] <=> $b['preco'];
        });
        break;

    case 'preco_desc':
        usort($produtos_filtrados, function ($a, $b) {
            return $b['preco'] <=> $a['preco'];
        });
        break;

    case 'nome_az':
        usort($produtos_filtrados, function ($a, $b) {
            return strcmp($a['nome'], $b['nome']);
        });
        break;

    case 'nome_za':
        usort($produtos_filtrados, function ($a, $b) {
            return strcmp($b['nome'], $a['nome']);
        });
        break;

    default:
        break;
}

function url_filtro(string $chave, string $valor): string
{
    $params = $_GET;
    $params[$chave] = $valor;
    return 'filtrar.php?' . http_build_query($params);
}

function url_remover_filtro(string $chave): string
{
    $params = $_GET;
    unset($params[$chave]);
    $query = http_build_query($params);
    return 'filtrar.php' . ($query ? '?' . $query : '');
}

$titulo_pagina = $filtro_categoria
    ? 'Categoria: ' . ucfirst($filtro_categoria) . ' — Handcrafted Items'
    : 'Filtrar Produtos — Handcrafted Items';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($titulo_pagina) ?></title>
</head>
<body>

<?php include 'Handcrafted-Items/cabecalho.php'; ?>

<main>

    <h1>Filtrar Produtos</h1>

    <aside class="painel-filtros">

        <section class="bloco-filtro">
            <h3>Categoria</h3>
            <ul>
                <li>
                    <a
                        href="<?= url_remover_filtro('categoria') ?>"
                        class="<?= $filtro_categoria === null ? 'ativo' : '' ?>"
                    >
                        Todas as categorias
                    </a>
                </li>
                <?php foreach ($categorias as $cat): ?>
                    <li>
                        <a
                            href="<?= url_filtro('categoria', $cat) ?>"
                            class="<?= $filtro_categoria === $cat ? 'ativo' : '' ?>"
                        >
                            <?= htmlspecialchars(ucfirst($cat)) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>

        <section class="bloco-filtro">
            <h3>Destaque</h3>
            <?php if ($filtro_destaque): ?>
                <a href="<?= url_remover_filtro('destaque') ?>">
                     Ver todos (remover filtro)
                </a>
            <?php else: ?>
                <a href="<?= url_filtro('destaque', '1') ?>">
                    ⭐ Apenas destaques
                </a>
            <?php endif; ?>
        </section>

        <section class="bloco-filtro">
            <h3>Ordenar por</h3>
            <ul>
                <?php
                $opcoes_ordem = [
                    'padrao'     => ' Padrão',
                    'preco_asc'  => ' Menor preço',
                    'preco_desc' => ' Maior preço',
                    'nome_az'    => ' Nome A→Z',
                    'nome_za'    => ' Nome Z→A',
                ];
                foreach ($opcoes_ordem as $valor => $label):
                ?>
                    <li>
                        <a
                            href="<?= url_filtro('ordem', $valor) ?>"
                            class="<?= $filtro_ordem === $valor ? 'ativo' : '' ?>"
                        >
                            <?= $label ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>

        <?php if (!empty($_GET)): ?>
            <a href="filtrar.php" class="btn-limpar">
                 Limpar todos os filtros
            </a>
        <?php endif; ?>

    </aside>

    <section class="resultados">

        <div class="filtros-ativos">
            <p>
                <strong><?= count($produtos_filtrados) ?></strong>
                produto(s) encontrado(s)
                <?php if ($filtro_categoria): ?>
                    em <strong><?= htmlspecialchars(ucfirst($filtro_categoria)) ?></strong>
                <?php endif; ?>
                <?php if ($filtro_destaque): ?>
                    · apenas <strong>destaques</strong>
                <?php endif; ?>
            </p>
        </div>

        <?php if (empty($produtos_filtrados)): ?>

            <div class="sem-resultados">
                <p> Nenhum produto encontrado com os filtros selecionados.</p>
                <a href="filtrar.php" class="btn">Ver todos os produtos</a>
            </div>

        <?php else: ?>

            <div class="grade-produtos">
                <?php foreach ($produtos_filtrados as $produto): ?>

                    <article class="card-produto">
                        <img
                            src="<?= htmlspecialchars($produto['imagem']) ?>"
                            alt="<?= htmlspecialchars($produto['nome']) ?>"
                        >

                        <?php if ($produto['destaque']): ?>
                            <span class="badge-destaque">⭐ Destaque</span>
                        <?php endif; ?>

                        <h3><?= htmlspecialchars($produto['nome']) ?></h3>

                        <p class="categoria">
                            <?= htmlspecialchars(ucfirst($produto['categoria'])) ?>
                        </p>

                        <p><?= htmlspecialchars($produto['descricao']) ?></p>

                        <p class="preco">
                            R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                        </p>

                        <?php if ($produto['estoque'] > 0): ?>
                            <span class="disponivel">Em estoque</span>
                        <?php else: ?>
                            <span class="esgotado">Esgotado</span>
                        <?php endif; ?>

                        <a
                            href="detalhes.php?id=<?= $produto['id'] ?>"
                            class="btn-ver"
                        >
                            Ver detalhes →
                        </a>
                    </article>

                <?php endforeach; ?>
            </div>

        <?php endif; ?>

    </section>

</main>

<?php include 'Handcrafted-Items/rodape.php'; ?>

</body>
</html>
