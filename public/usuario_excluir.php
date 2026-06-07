<?php
require_once __DIR__ . '/../app/core/Security.php';
require_once __DIR__ . '/../app/controllers/UsuarioController.php';
require_login();

$usuarioController = new UsuarioController();
$id = isset($_GET['id']) && ctype_digit((string) $_GET['id']) ? (int) $_GET['id'] : 0;
$usuario = $id > 0 ? $usuarioController->show($id) : null;

if (!$usuario) {
    flash_set('erro', 'Usuário não encontrado.');
    redirect('usuarios.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate($_POST['csrf_token'] ?? null)) {
        flash_set('erro', 'Token CSRF inválido. Recarregue a página e tente novamente.');
        redirect('usuarios.php');
    }

    [$ok, $mensagem] = $usuarioController->destroy($id, current_user_id());
    flash_set($ok ? 'sucesso' : 'erro', $mensagem);
    redirect('usuarios.php');
}

include __DIR__ . '/../app/views/templates/cabecalho.php';
?>
<main class="container my-5">
    <section class="card shadow-sm border-0 p-4">
        <h1 class="h3 font-artesanal">Excluir usuário</h1>
        <p>Tem certeza que deseja excluir o usuário <strong><?= e($usuario['nome']) ?></strong>?</p>
        <form method="POST" action="usuario_excluir.php?id=<?= (int) $id ?>" class="d-flex gap-2">
            <?= csrf_input() ?>
            <button type="submit" class="btn btn-danger">Sim, excluir</button>
            <a href="usuarios.php" class="btn btn-outline-secondary">Cancelar</a>
        </form>
    </section>
</main>
<?php include __DIR__ . '/../app/views/templates/rodape.php'; ?>
