<?php

define('ACESSO_PERMITIDO', true);
require_once 'dados.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

if (!is_numeric($_GET['id']) || (int)$_GET['id'] <= 0) {
    $erro = 'ID de produto inválido.';
} else {
    $id_buscado = (int)$_GET['id'];
    $produto_encontrado = null;

    foreach ($produtos as $produto) {
        if ($produto['id'] === $id_buscado) {
            $produto_encontrado = $produto;
            break;
        }
    }
    if ($produto_encontrado === null) {
        $erro = "Produto com ID {$id_buscado} não encontrado.";
    }
}
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

<?php include 'Handcrafted-Items/cabecalho.php'; ?>

<main>

    <nav class="breadcrumb">
        <a href="index.php">← Voltar ao catálogo</a>
    </nav>

    <?php if (isset($erro)): ?>

        <div class="mensagem-erro">
            <h2> Ops!</h2>
            <p><?= htmlspecialchars($erro) ?></p>
            <a href="index.php" class="btn">Voltar ao catálogo</a>
        </div>

    <?php else: ?>

        <?php
        $p = $produto_encontrado;
        ?>

        <article class="pagina-produto">
            <div class="produto-imagem">
                <img
                    src="<?= htmlspecialchars($p['imagem']) ?>"
                    alt="<?= htmlspecialchars($p['nome']) ?>"
                >
                <?php if ($p['destaque']): ?>
                    <span class="badge-destaque"> Produto em Destaque</span>
                <?php endif; ?>
            </div>

            <div class="produto-info">

                <p class="categoria">
                    <a href="filtrar.php?categoria=<?= urlencode($p['categoria']) ?>">
                        <?= htmlspecialchars(ucfirst($p['categoria'])) ?>
                    </a>
                </p>

                <h1><?= htmlspecialchars($p['nome']) ?></h1>

                <p class="preco">
                    R$ <?= number_format($p['preco'], 2, ',', '.') ?>
                </p>

                <div class="estoque">
                    <?php if ($p['estoque'] > 5): ?>
                        <span class="disponivel"> Em estoque</span>

                    <?php elseif ($p['estoque'] > 0): ?>
                        <span class="ultimas">
                            Últimas <?= $p['estoque'] ?> unidade(s)!
                        </span>

                    <?php else: ?>
                        <span class="esgotado">❌ Esgotado</span>
                    <?php endif; ?>
                </div>

                <p class="descricao-curta">
                    <?= htmlspecialchars($p['descricao']) ?>
                </p>

                <div class="detalhes-completos">
                    <h3>Sobre o produto</h3>
                    <p><?= htmlspecialchars($p['detalhes']) ?></p>
                </div>

                <?php if ($p['estoque'] > 0): ?>
                    <button
                        class="btn-comprar"
                        data-produto-id="<?= $p['id'] ?>"
                    >
                         Adicionar ao carrinho
                    </button>
                <?php else: ?>
                    <button class="btn-comprar desabilitado" disabled>
                        Produto indisponível
                    </button>
                <?php endif; ?>

            </div>
        </article>
        <?php
        $relacionados = [];
        foreach ($produtos as $item) {
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
                <h2> Você também pode gostar</h2>
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

    <?php endif;?>

</main>

<?php include 'Handcrafted-Items/rodape.php'; ?>

</body>
</html>
