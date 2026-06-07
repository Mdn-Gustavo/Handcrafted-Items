<?php
require_once __DIR__ . '/../app/core/Security.php';
require_once __DIR__ . '/../app/controllers/CategoriaController.php';
require_login();

$categoriaController = new CategoriaController();
$categorias = $categoriaController->index();

include __DIR__ . '/../app/views/templates/cabecalho.php';
?>
<main class="container my-5">
    <header class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="display-6 font-artesanal">Categorias</h1>
            <p class="text-muted mb-0">Listagem do CRUD de categorias.</p>
        </div>
        <a href="categoria_cadastrar.php" class="btn btn-primary">Nova categoria</a>
    </header>

    <?php if ($erro = flash_get('erro')): ?><div class="alert alert-danger"><?= e($erro) ?></div><?php endif; ?>
    <?php if ($sucesso = flash_get('sucesso')): ?><div class="alert alert-success"><?= e($sucesso) ?></div><?php endif; ?>

    <section class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categorias as $categoria): ?>
                        <tr>
                            <td><?= (int) $categoria['id'] ?></td>
                            <td><?= e($categoria['nome']) ?></td>
                            <td class="text-end">
                                <a href="categoria_editar.php?id=<?= (int) $categoria['id'] ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                                <a href="categoria_excluir.php?id=<?= (int) $categoria['id'] ?>" class="btn btn-sm btn-outline-danger">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($categorias)): ?>
                        <tr><td colspan="3" class="text-center text-muted py-4">Nenhuma categoria cadastrada.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
<?php include __DIR__ . '/../app/views/templates/rodape.php'; ?>
