<?php
require_once __DIR__ . '/../app/core/Security.php';
require_login();

include __DIR__ . '/../app/views/templates/cabecalho.php';
?>
<main class="container my-5">
    <header class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div>
            <h1 class="display-6 font-artesanal">Painel Administrativo</h1>
            <p class="text-muted mb-0">Olá, <?= e(current_user_name()) ?>. Escolha qual área deseja gerenciar.</p>
            <?php if (!empty($_COOKIE['ultimo_acesso'])): ?>
                <small class="text-muted">Último acesso registrado: <?= e($_COOKIE['ultimo_acesso']) ?></small>
            <?php endif; ?>
        </div>
        <a href="sair.php" class="btn btn-outline-danger mt-3 mt-md-0">Sair</a>
    </header>

    <?php if ($erro = flash_get('erro')): ?><div class="alert alert-danger"><?= e($erro) ?></div><?php endif; ?>
    <?php if ($sucesso = flash_get('sucesso')): ?><div class="alert alert-success"><?= e($sucesso) ?></div><?php endif; ?>

    <section class="row g-4">
        <article class="col-md-4">
            <div class="card h-100 shadow-sm border-0 p-4">
                <h2 class="h4">Produtos</h2>
                <p class="text-muted">Cadastrar, listar, editar e excluir produtos do catálogo.</p>
                <a href="produtos.php" class="btn btn-primary mt-auto">Abrir CRUD de Produtos</a>
            </div>
        </article>
        <article class="col-md-4">
            <div class="card h-100 shadow-sm border-0 p-4">
                <h2 class="h4">Categorias</h2>
                <p class="text-muted">Organizar os produtos em categorias de artesanato.</p>
                <a href="categorias.php" class="btn btn-primary mt-auto">Abrir CRUD de Categorias</a>
            </div>
        </article>
        <article class="col-md-4">
            <div class="card h-100 shadow-sm border-0 p-4">
                <h2 class="h4">Usuários</h2>
                <p class="text-muted">Gerenciar usuários que acessam a área restrita.</p>
                <a href="usuarios.php" class="btn btn-primary mt-auto">Abrir CRUD de Usuários</a>
            </div>
        </article>
    </section>
</main>
<?php include __DIR__ . '/../app/views/templates/rodape.php'; ?>
