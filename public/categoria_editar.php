<?php
require_once __DIR__ . '/../app/core/Security.php';
require_once __DIR__ . '/../app/controllers/CategoriaController.php';
require_login();

$categoriaController = new CategoriaController();
$id = isset($_GET['id']) && ctype_digit((string) $_GET['id']) ? (int) $_GET['id'] : 0;
$categoria = $id > 0 ? $categoriaController->show($id) : null;
$erro = null;

if (!$categoria) {
    flash_set('erro', 'Categoria não encontrada.');
    redirect('categorias.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate($_POST['csrf_token'] ?? null)) {
        $erro = 'Token CSRF inválido. Recarregue a página e tente novamente.';
    } else {
        [$ok, $mensagem] = $categoriaController->update($id, $_POST);

        if ($ok) {
            flash_set('sucesso', $mensagem);
            redirect('categorias.php');
        }

        $erro = $mensagem;
    }
}

$nome = $_POST['nome'] ?? $categoria['nome'];

include __DIR__ . '/../app/views/templates/cabecalho.php';
?>
<main class="container my-5">
    <header class="mb-4">
        <h1 class="display-6 font-artesanal">Editar categoria</h1>
    </header>

    <?php if ($erro): ?><div class="alert alert-danger"><?= e($erro) ?></div><?php endif; ?>

    <section class="card shadow-sm border-0 p-4">
        <form method="POST" action="categoria_editar.php?id=<?= (int) $id ?>">
            <?= csrf_input() ?>
            <div class="mb-3">
                <label for="nome" class="form-label">Nome da categoria</label>
                <input type="text" name="nome" id="nome" class="form-control" value="<?= e($nome) ?>" required>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Atualizar categoria</button>
                <a href="categorias.php" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </section>
</main>
<?php include __DIR__ . '/../app/views/templates/rodape.php'; ?>
