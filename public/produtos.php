<?php
require_once __DIR__ . '/../app/core/Security.php';
require_once __DIR__ . '/../app/controllers/ProdutoController.php';
require_login();

$produtoController = new ProdutoController();
$produtos = $produtoController->index();

include __DIR__ . '/../app/views/templates/cabecalho.php';
?>
<main class="container my-5">
    <header class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="display-6 font-artesanal">Produtos</h1>
            <p class="text-muted mb-0">Listagem do CRUD de produtos.</p>
        </div>
        <a href="produto_cadastrar.php" class="btn btn-primary">Novo produto</a>
    </header>

    <?php if ($erro = flash_get('erro')): ?><div class="alert alert-danger"><?= e($erro) ?></div><?php endif; ?>
    <?php if ($sucesso = flash_get('sucesso')): ?><div class="alert alert-success"><?= e($sucesso) ?></div><?php endif; ?>

    <section class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Produto</th>
                        <th>Categoria</th>
                        <th>Preço</th>
                        <th>Estoque</th>
                        <th>Destaque</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produtos as $produto): ?>
                        <tr>
                            <td><?= (int) $produto['id'] ?></td>
                            <td><?= e($produto['nome']) ?></td>
                            <td><?= e($produto['categoria']) ?></td>
                            <td>R$ <?= number_format((float) $produto['preco'], 2, ',', '.') ?></td>
                            <td><?= (int) $produto['estoque'] ?></td>
                            <td><?= (int) $produto['destaque'] === 1 ? 'Sim' : 'Não' ?></td>
                            <td class="text-end">
                                <a href="produto_editar.php?id=<?= (int) $produto['id'] ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                                <a href="produto_excluir.php?id=<?= (int) $produto['id'] ?>" class="btn btn-sm btn-outline-danger">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($produtos)): ?>
                        <tr><td colspan="7" class="text-center text-muted py-4">Nenhum produto cadastrado.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
<?php include __DIR__ . '/../app/views/templates/rodape.php'; ?>
