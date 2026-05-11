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

include 'cabecalho.php';
?>

<main class="container my-5">

    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php" class="text-decoration-none">← Voltar ao catálogo</a>
            </li>
            <?php if (isset($produto_encontrado)): ?>
                <li class="breadcrumb-item active" aria-current="page">
                    <?= htmlspecialchars($produto_encontrado['nome']) ?>
                </li>
            <?php endif; ?>
        </ol>
    </nav>

    <?php if (isset($erro)): ?>
        <div class="text-center py-5">
            <div class="alert alert-danger shadow-sm" role="alert">
                <h2 class="alert-heading">😕 Ops!</h2>
                <p class="mb-3"><?= htmlspecialchars($erro) ?></p>
                <hr>
                <a href="index.php" class="btn btn-dark">Voltar ao catálogo</a>
            </div>
        </div>

    <?php else: ?>

        <?php $p = $produto_encontrado; ?>
        <div class="row g-4 mb-5">
            <div class="col-lg-6">
                <div class="card shadow border-0 position-relative">
                    <img src="assets/css/images/<?= htmlspecialchars($p['imagem']) ?>"
                         class="card-img-top rounded"
                         alt="<?= htmlspecialchars($p['nome']) ?>"
                         style="object-fit: cover; max-height: 500px;">

                    <?php if ($p['destaque']): ?>
                        <span class="position-absolute top-0 start-0 m-3 badge bg-warning text-dark fs-6">
                            ⭐ Produto em Destaque
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="mb-3">
                    <a href="filtrar.php?categoria=<?= urlencode($p['categoria']) ?>"
                       class="badge bg-light text-dark border text-decoration-none">
                        <?= htmlspecialchars(ucfirst($p['categoria'])) ?>
                    </a>
                </div>

                <h1 class="display-5 fw-bold mb-3"><?= htmlspecialchars($p['nome']) ?></h1>

                <p class="h3 text-success fw-bold mb-4">
                    R$ <?= number_format($p['preco'], 2, ',', '.') ?>
                </p>

                <div class="mb-4">
                    <?php if ($p['estoque'] > 5): ?>
                        <span class="badge bg-success fs-6">✓ Em estoque</span>

                    <?php elseif ($p['estoque'] > 0): ?>
                        <span class="badge bg-warning text-dark fs-6">
                            ⚠️ Últimas <?= $p['estoque'] ?> unidade(s)!
                        </span>

                    <?php else: ?>
                        <span class="badge bg-danger fs-6">❌ Esgotado</span>
                    <?php endif; ?>
                </div>

                <p class="lead text-muted mb-4">
                    <?= htmlspecialchars($p['descricao']) ?>
                </p>

                <div class="card bg-light border-0 p-4 mb-4">
                    <h5 class="fw-bold mb-3"> Sobre o produto</h5>
                    <p class="mb-0"><?= htmlspecialchars($p['detalhes']) ?></p>
                </div>

                <?php if ($p['estoque'] > 0): ?>
                    <button class="btn btn-dark btn-lg w-100 py-3"
                            data-produto-id="<?= $p['id'] ?>">
                        🛒 Adicionar ao carrinho
                    </button>
                <?php else: ?>
                    <button class="btn btn-secondary btn-lg w-100 py-3" disabled>
                        Produto indisponível
                    </button>
                <?php endif; ?>
            </div>
        </div>

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
            <section class="mt-5 pt-5 border-top">
                <h2 class="text-center mb-4 font-artesanal"> Você também pode gostar</h2>

                <div class="row g-4">
                    <?php foreach ($relacionados as $rel): ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm border-0 card-hover-efeito">
                                <img src="assets/css/images/<?= htmlspecialchars($rel['imagem']) ?>"
                                     class="card-img-top img-card-catalogo"
                                     alt="<?= htmlspecialchars($rel['nome']) ?>">

                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?= htmlspecialchars($rel['nome']) ?></h5>

                                    <p class="h5 text-success fw-bold mt-auto mb-3">
                                        R$ <?= number_format($rel['preco'], 2, ',', '.') ?>
                                    </p>

                                    <a href="detalhes.php?id=<?= $rel['id'] ?>"
                                       class="btn btn-dark w-100">
                                        Ver detalhes →
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

    <?php endif; ?>

</main>

<?php include 'rodape.php'; ?>
