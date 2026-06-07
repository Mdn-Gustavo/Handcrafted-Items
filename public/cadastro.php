<?php
require_once __DIR__ . '/../app/core/Security.php';
require_once __DIR__ . '/../app/controllers/UsuarioController.php';

$erro = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate($_POST['csrf_token'] ?? null)) {
        $erro = 'Token CSRF inválido. Recarregue a página e tente novamente.';
    } else {
        $_POST['tipo_usuario'] = 'comum';
        $usuarioController = new UsuarioController();
        [$ok, $mensagem] = $usuarioController->store($_POST);

        if ($ok) {
            flash_set('sucesso', 'Conta criada com sucesso. Agora faça login.');
            redirect('login.php');
        }

        $erro = $mensagem;
    }
}

include __DIR__ . '/../app/views/templates/cabecalho.php';
?>
<main class="container container-login">
    <section class="card card-login shadow border-0 p-4">
        <h1 class="h3 text-center font-artesanal mb-3">Cadastro</h1>
        <p class="text-muted text-center small mb-4">Crie um usuário comum para testar o sistema.</p>

        <?php if ($erro): ?><div class="alert alert-danger"><?= e($erro) ?></div><?php endif; ?>

        <form method="POST" action="cadastro.php">
            <?= csrf_input() ?>
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control" value="<?= e($_POST['nome'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" class="form-control" value="<?= e($_POST['email'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" name="senha" id="senha" class="form-control" minlength="6" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
        </form>
        <div class="text-center mt-3"><a href="login.php" class="small">Voltar para login</a></div>
    </section>
</main>
<?php include __DIR__ . '/../app/views/templates/rodape.php'; ?>
