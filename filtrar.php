<?php
/**
 * filtrar.php
 *
 * Filtra produtos por categoria, ordenação e destaque.
 * Todos os filtros chegam via GET.
 *
 * Parâmetros aceitos:
 *   ?categoria=ceramica
 *   ?ordem=preco_asc | preco_desc | nome_az | nome_za
 *   ?destaque=1
 *   (combinações: ?categoria=ceramica&ordem=preco_asc)
 */

define('ACESSO_PERMITIDO', true);
require_once 'dados.php';

// ─────────────────────────────────────────────
// RECEBIMENTO E SANITIZAÇÃO DOS FILTROS
// ─────────────────────────────────────────────

// Categoria: aceita apenas valores da lista $categorias
$filtro_categoria = null;
if (isset($_GET['categoria']) && $_GET['categoria'] !== '') {
    $candidata = trim($_GET['categoria']);
    // Só aceita se existir na lista oficial de categorias
    if (in_array($candidata, $categorias, true)) {
        $filtro_categoria = $candidata;
    }
    // Se não existir, ignora (evita injeção de valores inválidos)
}

// Ordenação: aceita apenas valores predefinidos
$ordens_validas = ['padrao', 'preco_asc', 'preco_desc', 'nome_az', 'nome_za'];
$filtro_ordem = 'padrao';
if (isset($_GET['ordem']) && in_array($_GET['ordem'], $ordens_validas, true)) {
    $filtro_ordem = $_GET['ordem'];
}

// Destaque: só filtra por destaque se ?destaque=1
$filtro_destaque = isset($_GET['destaque']) && $_GET['destaque'] === '1';

// ─────────────────────────────────────────────
// APLICAÇÃO DOS FILTROS
// ─────────────────────────────────────────────
$produtos_filtrados = [];

foreach ($produtos as $produto) {
    // Filtro 1: Categoria
    if ($filtro_categoria !== null && $produto['categoria'] !== $filtro_categoria) {
        continue; // pula este produto
    }

    // Filtro 2: Destaque
    if ($filtro_destaque && $produto['destaque'] !== true) {
        continue; // pula este produto
    }

    // Passou em todos os filtros — adiciona
    $produtos_filtrados[] = $produto;
}

// ─────────────────────────────────────────────
// APLICAÇÃO DA ORDENAÇÃO
// usort() ordena um array com uma função de comparação
// ─────────────────────────────────────────────
switch ($filtro_ordem) {

    case 'preco_asc':
        usort($produtos_filtrados, function ($a, $b) {
            return $a['preco'] <=> $b['preco']; // menor para maior
        });
        break;

    case 'preco_desc':
        usort($produtos_filtrados, function ($a, $b) {
            return $b['preco'] <=> $a['preco']; // maior para menor
        });
        break;

    case 'nome_az':
        usort($produtos_filtrados, function ($a, $b) {
            return strcmp($a['nome'], $b['nome']); // A → Z
        });
        break;

    case 'nome_za':
        usort($produtos_filtrados, function ($a, $b) {
            return strcmp($b['nome'], $a['nome']); // Z → A
        });
        break;

    // 'padrao': mantém a ordem original do array dados.php
    default:
        break;
}

// ─────────────────────────────────────────────
// FUNÇÃO AUXILIAR: gera URL preservando filtros ativos
// ─────────────────────────────────────────────
/**
 * Gera uma URL para filtrar.php mantendo os filtros ativos
 * e substituindo apenas o parâmetro informado.
 *
 * Exemplo:
 *   URL atual: ?categoria=ceramica&ordem=preco_asc
 *   url_filtro('destaque', '1')
 *   Resultado: ?categoria=ceramica&ordem=preco_asc&destaque=1
 */
function url_filtro(string $chave, string $valor): string
{
    // Pega os parâmetros GET atuais
    $params = $_GET;
    // Substitui ou adiciona o novo parâmetro
    $params[$chave] = $valor;
    // Monta a URL
    return 'filtrar.php?' . http_build_query($params);
}

/**
 * Gera a URL para REMOVER um filtro específico.
 */
function url_remover_filtro(string $chave): string
{
    $params = $_GET;
    unset($params[$chave]); // remove o filtro
    $query = http_build_query($params);
    return 'filtrar.php' . ($query ? '?' . $query : '');
}

// ─────────────────────────────────────────────
// Título da página
// ─────────────────────────────────────────────
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

<?php // include 'includes/header.php'; ?>

<main>

    <h1>🔍 Filtrar Produtos</h1>

    <!-- ── PAINEL DE FILTROS ──────────────────────── -->
    <aside class="painel-filtros">

        <!-- FILTRO POR CATEGORIA -->
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

        <!-- FILTRO POR DESTAQUE -->
        <section class="bloco-filtro">
            <h3>Destaque</h3>
            <?php if ($filtro_destaque): ?>
                <a href="<?= url_remover_filtro('destaque') ?>">
                    ✅ Ver todos (remover filtro)
                </a>
            <?php else: ?>
                <a href="<?= url_filtro('destaque', '1') ?>">
                    ⭐ Apenas destaques
                </a>
            <?php endif; ?>
        </section>

        <!-- ORDENAÇÃO -->
        <section class="bloco-filtro">
            <h3>Ordenar por</h3>
            <ul>
                <?php
                $opcoes_ordem = [
                    'padrao'     => '📋 Padrão',
                    'preco_asc'  => '💰 Menor preço',
                    'preco_desc' => '💎 Maior preço',
                    'nome_az'    => '🔤 Nome A→Z',
                    'nome_za'    => '🔤 Nome Z→A',
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

        <!-- LIMPAR TODOS OS FILTROS -->
        <?php if (!empty($_GET)): ?>
            <a href="filtrar.php" class="btn-limpar">
                🗑️ Limpar todos os filtros
            </a>
        <?php endif; ?>

    </aside>

    <!-- ── RESULTADOS ────────────────────────────── -->
    <section class="resultados">

        <!-- Resumo dos filtros ativos -->
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

        <!-- Lista de produtos filtrados -->
        <?php if (empty($produtos_filtrados)): ?>

            <div class="sem-resultados">
                <p>😕 Nenhum produto encontrado com os filtros selecionados.</p>
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

                        <!-- Estoque -->
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

<?php // include 'includes/footer.php'; ?>

</body>
</html>
