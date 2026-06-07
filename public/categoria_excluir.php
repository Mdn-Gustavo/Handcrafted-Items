<?php
require_once __DIR__ . '/../app/core/Security.php';
require_once __DIR__ . '/../app/controllers/CategoriaController.php';
require_login();

$categoriaController = new CategoriaController();
$id = isset($_GET['id']) && ctype_digit((string) $_GET['id']) ? (int) $_GET['id'] : 0;
$categoria = $id > 0 ? $categoriaController->show($id) : null;

if (!$categoria) {
    flash_set('erro', 'Categoria não encontrada.');
    redirect('categorias.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate($_POST['csrf_token'] ?? null)) {
        flash_set('erro', 'Token CSRF inválido. Recarregue a página e tente novamente.');
        redirect('categorias.php');
    }

    [$ok, $mensagem] = $categoriaController->destroy($id);
    flash_set($ok ? 'sucesso' : 'erro', $mensagem);
    redirect('categorias.php');
}

include __DIR__ . '/../app/views/templates/cabecalho.php';
?>
<main class="container my-5">
    <section class="card shadow-sm border-0 p-4">
        <h1 class="h3 font-artesanal">Excluir categoria</h1>
        <p>Tem certeza que deseja excluir a categoria <strong><?= e($categoria['nome']) ?></strong>?</p>
        <p class="text-muted small">Categorias com produtos vinculados não serão excluídas.</p>
        <form method="POST" action="categoria_excluir.php?id=<?= (int) $id ?>" class="d-flex gap-2">
            <?= csrf_input() ?>
            <button type="submit" class="btn btn-danger">Sim, excluir</button>
            <a href="categorias.php" class="btn btn-outline-secondary">Cancelar</a>
        </form>
    </section>
</main>
<?php include __DIR__ . '/../app/views/templates/rodape.php'; ?>
