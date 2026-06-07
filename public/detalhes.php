<?php
require_once __DIR__ . '/../app/core/Security.php';
require_once __DIR__ . '/../app/controllers/ProdutoController.php';

$produtoController = new ProdutoController();
$id = isset($_GET['id']) && ctype_digit((string) $_GET['id']) ? (int) $_GET['id'] : 0;
$produto = $id > 0 ? $produtoController->show($id) : null;
$relacionados = $produto ? $produtoController->relacionados((int) $produto['id'], (int) $produto['categoria_id']) : [];

include __DIR__ . '/../app/views/templates/cabecalho.php';
?>
<main class="container my-5">
    <?php if (!$produto): ?>
        <section class="alert alert-warning text-center">
            <h1 class="h4">Produto não encontrado</h1>
            <a href="index.php" class="btn btn-dark mt-2">Voltar ao catálogo</a>
        </section>
    <?php else: ?>
        <section class="row g-5 align-items-start">
            <div class="col-lg-6">
                <img src="assets/css/images/<?= e($produto['imagem']) ?>" class="img-fluid rounded shadow-sm detalhe-img" alt="<?= e($produto['nome']) ?>">
            </div>
            <article class="col-lg-6">
                <span class="badge bg-light text-dark border mb-3"><?= e($produto['categoria']) ?></span>
                <h1 class="display-6 font-artesanal"><?= e($produto['nome']) ?></h1>
                <p class="lead text-muted"><?= e($produto['descricao']) ?></p>
                <p class="fs-3 fw-bold text-success">R$ <?= number_format((float) $produto['preco'], 2, ',', '.') ?></p>
                <p>
                    <?php if ((int) $produto['estoque'] > 0): ?>
                        <span class="badge bg-success">Em estoque: <?= (int) $produto['estoque'] ?> unidade(s)</span>
                    <?php else: ?>
                        <span class="badge bg-danger">Produto esgotado</span>
                    <?php endif; ?>
                </p>
                <section class="mt-4">
                    <h2 class="h5">Detalhes do produto</h2>
                    <p><?= nl2br(e($produto['detalhes'] ?: $produto['descricao'])) ?></p>
                </section>
                <a href="index.php" class="btn btn-outline-dark mt-3">Voltar ao catálogo</a>
            </article>
        </section>

        <?php if (!empty($relacionados)): ?>
            <section class="mt-5">
                <h2 class="h4 font-artesanal mb-4">Produtos relacionados</h2>
                <div class="row g-4">
                    <?php foreach ($relacionados as $item): ?>
                        <article class="col-md-4">
                            <div class="card h-100 shadow-sm">
                                <img src="assets/css/images/<?= e($item['imagem']) ?>" class="card-img-top img-card-catalogo" alt="<?= e($item['nome']) ?>">
                                <div class="card-body">
                                    <h3 class="h5 card-title"><?= e($item['nome']) ?></h3>
                                    <p class="text-success fw-bold">R$ <?= number_format((float) $item['preco'], 2, ',', '.') ?></p>
                                    <a href="detalhes.php?id=<?= (int) $item['id'] ?>" class="btn btn-sm btn-dark">Ver</a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
    <?php endif; ?>
</main>
<?php include __DIR__ . '/../app/views/templates/rodape.php'; ?>
