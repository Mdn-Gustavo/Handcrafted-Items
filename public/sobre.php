<?php
require_once __DIR__ . '/../app/core/Security.php';
include __DIR__ . '/../app/views/templates/cabecalho.php';
?>
<main class="container my-5">
    <header class="mb-4 text-center">
        <h1 class="display-5 font-artesanal">Sobre o projeto</h1>
        <p class="text-muted">Sistema de catálogo e gerenciamento de produtos artesanais.</p>
    </header>

    <section class="card shadow-sm border-0 p-4 mb-4">
        <h2 class="h4">O que o sistema faz?</h2>
        <p>O Handcrafted Items permite listar produtos artesanais para visitantes e gerenciar produtos, categorias e usuários na área restrita.</p>
    </section>

    <section class="row g-4">
        <article class="col-md-4">
            <div class="card h-100 p-4 shadow-sm border-0">
                <h3 class="h5">Catálogo público</h3>
                <p class="mb-0">Visitantes conseguem ver produtos, detalhes e filtros sem precisar fazer login.</p>
            </div>
        </article>
        <article class="col-md-4">
            <div class="card h-100 p-4 shadow-sm border-0">
                <h3 class="h5">Área administrativa</h3>
                <p class="mb-0">Usuários autenticados conseguem cadastrar, editar, listar e excluir dados.</p>
            </div>
        </article>
        <article class="col-md-4">
            <div class="card h-100 p-4 shadow-sm border-0">
                <h3 class="h5">Segurança básica</h3>
                <p class="mb-0">O projeto usa sessões, cookies, password_hash, password_verify e token CSRF.</p>
            </div>
        </article>
    </section>
</main>
<?php include __DIR__ . '/../app/views/templates/rodape.php'; ?>
