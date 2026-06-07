<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["logged_in"])) {
    header("Location: login.php");
    exit();
}

require_once "app/models/Produto.php";
require_once "app/models/Categoria.php";

$produtoModel = new Produto();
$categoriaModel = new Categoria();

$totalProdutos = count($produtoModel->all());
$totalCategorias = count($categoriaModel->all());

include "app/views/templates/cabecalho.php";
?>

<link rel="stylesheet" href="assets/css/style.css">

<main class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="font-artesanal">Painel Administrativo</h1>

        <a href="sair.php" class="btn btn-danger">
            Sair
        </a>
    </div>

    <div class="row mb-4">

        <div class="col-md-6">
            <div class="alert alert-info">
                <strong>Total de Produtos:</strong>
                <?= $totalProdutos ?>
            </div>
        </div>

        <div class="col-md-6">
            <div class="alert alert-success">
                <strong>Total de Categorias:</strong>
                <?= $totalCategorias ?>
            </div>
        </div>

    </div>

    <div class="row g-4">

        <div class="col-md-4">

            <div class="card shadow-sm h-100">
                <div class="card-body">

                    <h3>Produtos</h3>

                    <p>
                        Gerenciar produtos cadastrados.
                    </p>

                    <a href="public/produtos.php"
                       class="btn btn-primary">
                        Abrir CRUD
                    </a>

                </div>
            </div>

        </div>

        <div class="col-md-4">

            <div class="card shadow-sm h-100">
                <div class="card-body">

                    <h3>Categorias</h3>

                    <p>
                        Gerenciar categorias cadastradas.
                    </p>

                    <a href="public/categorias.php"
                       class="btn btn-success">
                        Abrir CRUD
                    </a>

                </div>
            </div>

        </div>

        <div class="col-md-4">

            <div class="card shadow-sm h-100">
                <div class="card-body">

                    <h3>Usuários</h3>

                    <p>
                        Gerenciar usuários do sistema.
                    </p>

                    <a href="public/usuarios.php"
                       class="btn btn-warning">
                        Abrir CRUD
                    </a>

                </div>
            </div>

        </div>

    </div>

</main>

<?php include "app/views/templates/rodape.php"; ?>
