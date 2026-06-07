<?php
require_once __DIR__ . '/../app/core/Security.php';
require_once __DIR__ . '/../app/controllers/UsuarioController.php';
require_login();

$usuarioController = new UsuarioController();
$usuarios = $usuarioController->index();

include __DIR__ . '/../app/views/templates/cabecalho.php';
?>
<main class="container my-5">
    <header class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="display-6 font-artesanal">Usuários</h1>
            <p class="text-muted mb-0">Terceiro CRUD obrigatório do projeto.</p>
        </div>
        <a href="usuario_cadastrar.php" class="btn btn-primary">Novo usuário</a>
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
                        <th>E-mail</th>
                        <th>Tipo</th>
                        <th>Criado em</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= (int) $usuario['id'] ?></td>
                            <td><?= e($usuario['nome']) ?></td>
                            <td><?= e($usuario['email']) ?></td>
                            <td><?= e($usuario['tipo_usuario']) ?></td>
                            <td><?= e($usuario['criado_em']) ?></td>
                            <td class="text-end">
                                <a href="usuario_editar.php?id=<?= (int) $usuario['id'] ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                                <a href="usuario_excluir.php?id=<?= (int) $usuario['id'] ?>" class="btn btn-sm btn-outline-danger">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($usuarios)): ?>
                        <tr><td colspan="6" class="text-center text-muted py-4">Nenhum usuário cadastrado.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
<?php include __DIR__ . '/../app/views/templates/rodape.php'; ?>
