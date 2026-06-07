<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit();
}

require_once __DIR__ . '/../models/Produto.php';
require_once __DIR__ . '/../models/Categoria.php';

$produtoModel = new Produto();
$categoriaModel = new Categoria();

$categorias = $categoriaModel->all();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: produtos.php?erro=Produto inválido');
    exit();
}

$produto = $produtoModel->findById($id);

if (!$produto) {
    header('Location: produtos.php?erro=Produto não encontrado');
    exit();
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto['nome'] = trim($_POST['nome'] ?? '');
    $produto['descricao'] = trim($_POST['descricao'] ?? '');
    $produto['preco'] = trim($_POST['preco'] ?? '');
    $produto['imagem'] = trim($_POST['imagem'] ?? '');
    $produto['estoque'] = trim($_POST['estoque'] ?? 0);
    $produto['destaque'] = isset($_POST['destaque']) ? 1 : 0;
    $produto['categoria_id'] = trim($_POST['categoria_id'] ?? '');

    if ($produto['nome'] === '') {
        $erro = 'O nome do produto é obrigatório.';
    } elseif ($produto['descricao'] === '') {
        $erro = 'A descrição do produto é obrigatória.';
    } elseif ($produto['preco'] === '' || !is_numeric($produto['preco'])) {
        $erro = 'O preço precisa ser um número válido.';
    } elseif ($produto['estoque'] === '' || !is_numeric($produto['estoque'])) {
        $erro = 'O estoque precisa ser um número válido.';
    } elseif ($produto['categoria_id'] === '' || !is_numeric($produto['categoria_id'])) {
        $erro = 'Selecione uma categoria válida.';
    } else {
        $produtoModel->update($id, [
            'nome' => $produto['nome'],
            'descricao' => $produto['descricao'],
            'preco' => (float) $produto['preco'],
            'imagem' => $produto['imagem'],
            'estoque' => (int) $produto['estoque'],
            'destaque' => (int) $produto['destaque'],
            'categoria_id' => (int) $produto['categoria_id']
        ]);

        header('Location: produtos.php?mensagem=Produto atualizado com sucesso');
        exit();
    }
}

function e($valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
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

    <div class="card shadow-sm border-0 mx-auto" style="max-width: 900px;">
        <div class="card-body p-4">

            <h1 class="h3 mb-3">Editar produto</h1>

            <?php if ($erro !== ''): ?>
                <div class="alert alert-danger">
                    <?= e($erro) ?>
                </div>
            <?php endif; ?>

            <form method="POST">

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" name="nome" class="form-control" value="<?= e($produto['nome']) ?>" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Categoria</label>
                        <select name="categoria_id" class="form-select" required>
                            <option value="">Selecione</option>

                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= e($categoria['id']) ?>" <?= ((string) $produto['categoria_id'] === (string) $categoria['id']) ? 'selected' : '' ?>>
                                    <?= e($categoria['nome']) ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descrição</label>
                    <textarea name="descricao" class="form-control" rows="3" required><?= e($produto['descricao']) ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Preço</label>
                        <input type="number" name="preco" class="form-control" step="0.01" min="0" value="<?= e($produto['preco']) ?>" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Estoque</label>
                        <input type="number" name="estoque" class="form-control" min="0" value="<?= e($produto['estoque']) ?>" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Imagem</label>
                        <input type="text" name="imagem" class="form-control" value="<?= e($produto['imagem']) ?>">
                    </div>
                </div>

                <div class="form-check mb-4">
                    <input type="checkbox" name="destaque" value="1" class="form-check-input" id="destaque" <?= ((int) $produto['destaque'] === 1) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="destaque">
                        Produto em destaque
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">
                    Atualizar
                </button>

                <a href="produtos.php" class="btn btn-secondary">
                    Cancelar
                </a>

            </form>

        </div>
    </div>

</main>

</body>
</html>