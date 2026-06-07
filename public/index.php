<?php
require_once __DIR__ . '/../app/core/Security.php';
require_once __DIR__ . '/../app/controllers/ProdutoController.php';

$produtoController = new ProdutoController();
$produtos = $produtoController->index();

include __DIR__ . '/../app/views/templates/cabecalho.php';
?>
<main class="container my-5">
    <header class="text-center mb-5">
        <h1 class="display-4 font-artesanal">Catálogo Artesanal</h1>
        <p class="text-muted">Produtos feitos à mão com cuidado, identidade e acabamento exclusivo.</p>
    </header>

    <section class="row g-4" aria-label="Lista de produtos">
        <?php if (empty($produtos)): ?>
            <div class="col-12">
                <div class="alert alert-warning text-center">Nenhum produto cadastrado ainda.</div>
            </div>
        <?php endif; ?>

        <?php foreach ($produtos as $produto): ?>
            <article class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm card-hover-efeito">
                    <img src="assets/css/images/<?= e($produto['imagem']) ?>" class="card-img-top img-card-catalogo" alt="<?= e($produto['nome']) ?>">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-light text-dark border"><?= e($produto['categoria']) ?></span>
                            <?php if ((int) $produto['destaque'] === 1): ?>
                                <span class="badge bg-warning text-dark">Destaque</span>
                            <?php endif; ?>
                        </div>
                        <h2 class="h5 card-title"><?= e($produto['nome']) ?></h2>
                        <p class="card-text text-muted small flex-grow-1"><?= e($produto['descricao']) ?></p>
                        <p class="h5 text-success fw-bold">R$ <?= number_format((float) $produto['preco'], 2, ',', '.') ?></p>
                        <a href="detalhes.php?id=<?= (int) $produto['id'] ?>" class="btn btn-primary w-100 mt-auto">Ver detalhes</a>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </section>
</main>
<?php include __DIR__ . '/../app/views/templates/rodape.php'; ?>
