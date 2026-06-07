<?php
require_once __DIR__ . '/../app/core/Security.php';
require_once __DIR__ . '/../app/controllers/CategoriaController.php';
require_login();

$categoriaController = new CategoriaController();
$erro = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate($_POST['csrf_token'] ?? null)) {
        $erro = 'Token CSRF inválido. Recarregue a página e tente novamente.';
    } else {
        [$ok, $mensagem] = $categoriaController->store($_POST);

        if ($ok) {
            flash_set('sucesso', $mensagem);
            redirect('categorias.php');
        }

        $erro = $mensagem;
    }
}

include __DIR__ . '/../app/views/templates/cabecalho.php';
?>
<main class="container my-5">
    <header class="mb-4">
        <h1 class="display-6 font-artesanal">Cadastrar categoria</h1>
    </header>

    <?php if ($erro): ?><div class="alert alert-danger"><?= e($erro) ?></div><?php endif; ?>

    <section class="card shadow-sm border-0 p-4">
        <form method="POST" action="categoria_cadastrar.php">
            <?= csrf_input() ?>
            <div class="mb-3">
                <label for="nome" class="form-label">Nome da categoria</label>
                <input type="text" name="nome" id="nome" class="form-control" value="<?= e($_POST['nome'] ?? '') ?>" required>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Salvar categoria</button>
                <a href="categorias.php" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </section>
</main>
<?php include __DIR__ . '/../app/views/templates/rodape.php'; ?>
