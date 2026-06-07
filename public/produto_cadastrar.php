<?php
require_once __DIR__ . '/../app/core/Security.php';
require_once __DIR__ . '/../app/controllers/ProdutoController.php';
require_once __DIR__ . '/../app/controllers/CategoriaController.php';
require_login();

$produtoController = new ProdutoController();
$categoriaController = new CategoriaController();
$categorias = $categoriaController->index();
$erro = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate($_POST['csrf_token'] ?? null)) {
        $erro = 'Token CSRF inválido. Recarregue a página e tente novamente.';
    } else {
        [$ok, $mensagem] = $produtoController->store($_POST);

        if ($ok) {
            flash_set('sucesso', $mensagem);
            redirect('produtos.php');
        }

        $erro = $mensagem;
    }
}

include __DIR__ . '/../app/views/templates/cabecalho.php';
?>
<main class="container my-5">
    <header class="mb-4">
        <h1 class="display-6 font-artesanal">Cadastrar produto</h1>
        <p class="text-muted">Preencha os dados do novo item artesanal.</p>
    </header>

    <?php if ($erro): ?><div class="alert alert-danger"><?= e($erro) ?></div><?php endif; ?>

    <section class="card shadow-sm border-0 p-4">
        <form method="POST" action="produto_cadastrar.php">
            <?= csrf_input() ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" class="form-control" value="<?= e($_POST['nome'] ?? '') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="categoria_id">Categoria</label>
                    <select name="categoria_id" id="categoria_id" class="form-select" required>
                        <option value="">Selecione</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?= (int) $categoria['id'] ?>" <?= (string) ($_POST['categoria_id'] ?? '') === (string) $categoria['id'] ? 'selected' : '' ?>><?= e($categoria['nome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="preco">Preço</label>
                    <input type="text" name="preco" id="preco" class="form-control" value="<?= e($_POST['preco'] ?? '') ?>" placeholder="Ex: 30.00" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="estoque">Estoque</label>
                    <input type="number" name="estoque" id="estoque" class="form-control" value="<?= e($_POST['estoque'] ?? '0') ?>" min="0" required>
                </div>
                <div class="col-md-4 mb-3 d-flex align-items-end">
                    <div class="form-check">
                        <input type="checkbox" name="destaque" value="1" id="destaque" class="form-check-input" <?= !empty($_POST['destaque']) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="destaque">Produto em destaque</label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" for="imagem">Arquivo da imagem</label>
                <input type="text" name="imagem" id="imagem" class="form-control" value="<?= e($_POST['imagem'] ?? '') ?>" placeholder="exemplo.png" required>
                <small class="text-muted">As imagens atuais ficam em public/assets/css/images.</small>
            </div>

            <div class="mb-3">
                <label class="form-label" for="descricao">Descrição curta</label>
                <textarea name="descricao" id="descricao" class="form-control" rows="3" required><?= e($_POST['descricao'] ?? '') ?></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label" for="detalhes">Detalhes</label>
                <textarea name="detalhes" id="detalhes" class="form-control" rows="4"><?= e($_POST['detalhes'] ?? '') ?></textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Salvar produto</button>
                <a href="produtos.php" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </section>
</main>
<?php include __DIR__ . '/../app/views/templates/rodape.php'; ?>
