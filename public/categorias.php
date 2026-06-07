<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit();
}

require_once __DIR__ . '/../models/Categoria.php';

$categoriaModel = new Categoria();
$categorias = $categoriaModel->all();

$mensagem = $_GET['mensagem'] ?? '';
$erro = $_GET['erro'] ?? '';

function e($valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>CRUD Categorias</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">Handcrafted Items</a>

        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="produtos.php">Produtos</a>
            <a class="nav-link active" href="categorias.php">Categorias</a>
        </div>
    </div>
</nav>

<main class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-1">Categorias</h1>
            <p class="text-muted mb-0">CRUD de categorias.</p>
        </div>

        <a href="categoria_cadastrar.php" class="btn btn-primary">
            Cadastrar categoria
        </a>
    </div>

    <?php if ($mensagem !== ''): ?>
        <div class="alert alert-success">
            <?= e($mensagem) ?>
        </div>
    <?php endif; ?>

    <?php if ($erro !== ''): ?>
        <div class="alert alert-danger">
            <?= e($erro) ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (empty($categorias)): ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    Nenhuma categoria cadastrada.
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($categorias as $categoria): ?>
                            <tr>
                                <td><?= e($categoria['id']) ?></td>
                                <td><?= e($categoria['nome']) ?></td>

                                <td class="text-end">
                                    <a href="categoria_editar.php?id=<?= e($categoria['id']) ?>" class="btn btn-sm btn-warning">
                                        Editar
                                    </a>

                                    <a href="categoria_excluir.php?id=<?= e($categoria['id']) ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Tem certeza que deseja excluir esta categoria?')">
                                        Excluir
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</main>

</body>
</html>