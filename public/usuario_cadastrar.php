<?php
require_once __DIR__ . '/../app/core/Security.php';
require_once __DIR__ . '/../app/controllers/UsuarioController.php';
require_login();

$usuarioController = new UsuarioController();
$erro = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate($_POST['csrf_token'] ?? null)) {
        $erro = 'Token CSRF inválido. Recarregue a página e tente novamente.';
    } else {
        [$ok, $mensagem] = $usuarioController->store($_POST);

        if ($ok) {
            flash_set('sucesso', $mensagem);
            redirect('usuarios.php');
        }

        $erro = $mensagem;
    }
}

include __DIR__ . '/../app/views/templates/cabecalho.php';
?>
<main class="container my-5">
    <header class="mb-4">
        <h1 class="display-6 font-artesanal">Cadastrar usuário</h1>
    </header>

    <?php if ($erro): ?><div class="alert alert-danger"><?= e($erro) ?></div><?php endif; ?>

    <section class="card shadow-sm border-0 p-4">
        <form method="POST" action="usuario_cadastrar.php">
            <?= csrf_input() ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" name="nome" id="nome" class="form-control" value="<?= e($_POST['nome'] ?? '') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?= e($_POST['email'] ?? '') ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" name="senha" id="senha" class="form-control" minlength="6" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tipo_usuario" class="form-label">Tipo</label>
                    <select name="tipo_usuario" id="tipo_usuario" class="form-select">
                        <option value="comum" <?= ($_POST['tipo_usuario'] ?? '') === 'comum' ? 'selected' : '' ?>>Comum</option>
                        <option value="admin" <?= ($_POST['tipo_usuario'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Salvar usuário</button>
                <a href="usuarios.php" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </section>
</main>
<?php include __DIR__ . '/../app/views/templates/rodape.php'; ?>
