<?php
require_once __DIR__ . '/../app/core/Security.php';
require_once __DIR__ . '/../app/controllers/UsuarioController.php';

if (is_logged_in()) {
    redirect('dashboard.php');
}

$erro = flash_get('erro');
$sucesso = flash_get('sucesso');
$emailSalvo = $_COOKIE['lembrar_email'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate($_POST['csrf_token'] ?? null)) {
        $erro = 'Token CSRF inválido. Recarregue a página e tente novamente.';
    } else {
        $usuarioController = new UsuarioController();
        [$ok, $mensagem, $usuario] = $usuarioController->authenticate($_POST);

        if ($ok) {
            session_regenerate_id(true);
            $_SESSION['usuario_id'] = (int) $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_email'] = $usuario['email'];
            $_SESSION['usuario_tipo'] = $usuario['tipo_usuario'];

            set_cookie_seguro('ultimo_acesso', date('d/m/Y H:i:s'), 30);

            if (!empty($_POST['lembrar'])) {
                set_cookie_seguro('lembrar_email', $usuario['email'], 30);
            } else {
                setcookie('lembrar_email', '', time() - 3600, '/');
            }

            redirect('dashboard.php');
        }

        $erro = $mensagem;
        $emailSalvo = $_POST['email'] ?? '';
    }
}

include __DIR__ . '/../app/views/templates/cabecalho.php';
?>
<main class="container container-login">
    <section class="card card-login shadow border-0 p-4">
        <h1 class="h3 text-center font-artesanal mb-3">Área do Artesão</h1>
        <p class="text-muted text-center small mb-4">Entre para gerenciar produtos, categorias e usuários.</p>

        <?php if ($erro): ?><div class="alert alert-danger"><?= e($erro) ?></div><?php endif; ?>
        <?php if ($sucesso): ?><div class="alert alert-success"><?= e($sucesso) ?></div><?php endif; ?>

        <form method="POST" action="login.php">
            <?= csrf_input() ?>
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" class="form-control" value="<?= e($emailSalvo) ?>" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" name="senha" id="senha" class="form-control" required>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="lembrar" value="1" id="lembrar" <?= $emailSalvo ? 'checked' : '' ?>>
                <label class="form-check-label" for="lembrar">Lembrar meu e-mail</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>

        <div class="text-center mt-3">
            <a href="cadastro.php" class="small">Criar uma conta de teste</a>
        </div>
    </section>
</main>
<?php include __DIR__ . '/../app/views/templates/rodape.php'; ?>
