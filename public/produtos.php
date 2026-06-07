<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit();
}

require_once __DIR__ . '/../models/Produto.php';

$produtoModel = new Produto();
$produtos = $produtoModel->all();

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
    <title>CRUD Produtos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">Handcrafted Items</a>

        <div class="navbar-nav ms-auto">
            <a class="nav-link active" href="produtos.php">Produtos</a>
            <a class="nav-link" href="categorias.php">Categorias</a>
        </div>
    </div>
</nav>

<main class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-1">Produtos</h1>
            <p class="text-muted mb-0">CRUD de produtos.</p>
        </div>

        <a href="produto_cadastrar.php" class="btn btn-primary">
            Cadastrar produto
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
                            <th>Imagem</th>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th>Preço</th>
                            <th>Estoque</th>
                            <th>Destaque</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (empty($produtos)): ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    Nenhum produto cadastrado.
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($produtos as $produto): ?>
                            <tr>
                                <td><?= e($produto['id']) ?></td>

                                <td>
                                    <?php if (!empty($produto['imagem'])): ?>
                                        <img src="assets/css/images/<?= e($produto['imagem']) ?>"
                                             alt="<?= e($produto['nome']) ?>"
                                             style="width: 60px; height: 60px; object-fit: cover;"
                                             class="rounded border">
                                    <?php else: ?>
                                        <span class="text-muted">Sem imagem</span>
                                    <?php endif; ?>
                                </td>

                                <td><?= e($produto['nome']) ?></td>
                                <td><?= e($produto['categoria']) ?></td>

                                <td>
                                    R$ <?= number_format((float) $produto['preco'], 2, ',', '.') ?>
                                </td>

                                <td><?= e($produto['estoque']) ?></td>

                                <td>
                                    <?= ((int) $produto['destaque'] === 1) ? 'Sim' : 'Não' ?>
                                </td>

                                <td class="text-end">
                                    <a href="produto_editar.php?id=<?= e($produto['id']) ?>" class="btn btn-sm btn-warning">
                                        Editar
                                    </a>

                                    <a href="produto_excluir.php?id=<?= e($produto['id']) ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Tem certeza que deseja excluir este produto?')">
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