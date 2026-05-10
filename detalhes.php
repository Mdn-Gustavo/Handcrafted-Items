<?php
/**
 * detalhes.php
 *
 * Exibe os detalhes completos de um produto.
 * Recebe o ID via GET: detalhes.php?id=1
 */

define('ACESSO_PERMITIDO', true);
require_once 'dados.php';

// ─────────────────────────────────────────────
// CAMADA 1: O parâmetro 'id' foi enviado?
// ─────────────────────────────────────────────
if (!isset($_GET['id'])) {
    // ID não informado — redireciona para o catálogo
    header('Location: index.php');
    exit;
}

// ─────────────────────────────────────────────
// CAMADA 2: O valor é numérico e positivo?
// ─────────────────────────────────────────────
if (!is_numeric($_GET['id']) || (int)$_GET['id'] <= 0) {
    // ID inválido
    $erro = 'ID de produto inválido.';
} else {
    // Converte para inteiro seguro
    $id_buscado = (int)$_GET['id'];

    // ─────────────────────────────────────────
    // CAMADA 3: Busca o produto no array
    // ─────────────────────────────────────────
    $produto_encontrado = null; // começa como nulo

    foreach ($produtos as $produto) {
        if ($produto['id'] === $id_buscado) {
            $produto_encontrado = $produto; // guarda o produto
            break; // para o loop — já encontrou!
        }
    }

    // ─────────────────────────────────────────
    // CAMADA 4: O produto existe?
    // ─────────────────────────────────────────
    if ($produto_encontrado === null) {
        $erro = "Produto com ID {$id_buscado} não encontrado.";
    }
}

// ─────────────────────────────────────────────
// Define o título da página
// ─────────────────────────────────────────────
$titulo_pagina = isset($produto_encontrado)
    ? htmlspecialchars($produto_encontrado['nome']) . ' — Handcrafted Items'
    : 'Produto não encontrado — Handcrafted Items';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= $titulo_pagina ?></title>
</head>
<body>

<?php // include 'includes/header.php'; ?>

<main>

    <!-- Navegação de volta -->
    <nav class="breadcrumb">
        <a href="index.php">← Voltar ao catálogo</a>
    </nav>

    <!-- ── CASO DE ERRO ──────────────────────────── -->
    <?php if (isset($erro)): ?>

        <div class="mensagem-erro">
            <h2>⚠️ Ops!</h2>
            <p><?= htmlspecialchars($erro) ?></p>
            <a href="index.php" class="btn">Voltar ao catálogo</a>
        </div>

    <!-- ── PRODUTO ENCONTRADO ────────────────────── -->
    <?php else: ?>

        <?php
        // Atalho para não repetir $produto_encontrado['campo'] o tempo todo
        $p = $produto_encontrado;
        ?>

        <article class="pagina-produto">

            <!-- Coluna da imagem -->
            <div class="produto-imagem">
                <img
                    src="<?= htmlspecialchars($p['imagem']) ?>"
                    alt="<?= htmlspecialchars($p['nome']) ?>"
                >
                <?php if ($p['destaque']): ?>
                    <span class="badge-destaque">⭐ Produto em Destaque</span>
                <?php endif; ?>
            </div>

            <!-- Coluna das informações -->
            <div class="produto-info">

                <!-- Categoria clicável -->
                <p class="categoria">
                    <a href="filtrar.php?categoria=<?= urlencode($p['categoria']) ?>">
                        <?= htmlspecialchars(ucfirst($p['categoria'])) ?>
                    </a>
                </p>

                <h1><?= htmlspecialchars($p['nome']) ?></h1>

                <!-- Artesão -->
                <p class="artesao">
                    🧑‍🎨 Feito por <strong><?= htmlspecialchars($p['artesao']) ?></strong>
                </p>

                <!-- Preço formatado em BRL -->
                <p class="preco">
                    R$ <?= number_format($p['preco'], 2, ',', '.') ?>
                </p>

                <!-- Disponibilidade -->
                <div class="estoque">
                    <?php if ($p['estoque'] > 5): ?>
                        <span class="disponivel">✅ Em estoque</span>

                    <?php elseif ($p['estoque'] > 0): ?>
                        <span class="ultimas">
                            ⚠️ Últimas <?= $p['estoque'] ?> unidade(s)!
                        </span>

                    <?php else: ?>
                        <span class="esgotado">❌ Esgotado</span>
                    <?php endif; ?>
                </div>

                <!-- Descrição curta -->
                <p class="descricao-curta">
                    <?= htmlspecialchars($p['descricao']) ?>
                </p>

                <!-- Detalhes completos -->
                <div class="detalhes-completos">
                    <h3>Sobre o produto</h3>
                    <p><?= htmlspecialchars($p['detalhes']) ?></p>
                </div>

                <!-- Ações -->
                <?php if ($p['estoque'] > 0): ?>
                    <!--
                        O integrante de sessão/carrinho vai implementar esta ação.
                        Deixamos o botão preparado:
                    -->
                    <button
                        class="btn-comprar"
                        data-produto-id="<?= $p['id'] ?>"
                    >
                        🛒 Adicionar ao carrinho
                    </button>
                <?php else: ?>
                    <button class="btn-comprar desabilitado" disabled>
                        Produto indisponível
                    </button>
                <?php endif; ?>

            </div>
        </article>

        <!-- ── PRODUTOS RELACIONADOS (mesma categoria) ── -->
        <?php
        $relacionados = [];
        foreach ($produtos as $item) {
            // Mesma categoria, produto diferente, máx. 3 itens
            if (
                $item['categoria'] === $p['categoria'] &&
                $item['id'] !== $p['id']
            ) {
                $relacionados[] = $item;
                if (count($relacionados) >= 3) {
                    break;
                }
            }
        }
        ?>

        <?php if (!empty($relacionados)): ?>
            <section class="produtos-relacionados">
                <h2>🔗 Você também pode gostar</h2>
                <div class="grade-produtos">
                    <?php foreach ($relacionados as $rel): ?>
                        <article class="card-produto">
                            <img
                                src="<?= htmlspecialchars($rel['imagem']) ?>"
                                alt="<?= htmlspecialchars($rel['nome']) ?>"
                            >
                            <h3><?= htmlspecialchars($rel['nome']) ?></h3>
                            <p class="preco">
                                R$ <?= number_format($rel['preco'], 2, ',', '.') ?>
                            </p>
                            <a
                                href="detalhes.php?id=<?= $rel['id'] ?>"
                                class="btn-ver"
                            >
                                Ver detalhes →
                            </a>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

    <?php endif; // fim do if/else de erro ?>

</main>

<?php // include 'includes/footer.php'; ?>

</body>
</html>
