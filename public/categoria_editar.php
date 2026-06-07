<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit();
}

require_once __DIR__ . '/../app/models/Categoria.php';

$categoriaModel = new Categoria();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: categorias.php?erro=Categoria inválida');
    exit();
}

$categoria = $categoriaModel->findById($id);

if (!$categoria) {
    header('Location: categorias.php?erro=Categoria não encontrada');
    exit();
}

$erro = '';
$nome = $categoria['nome'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');

    if ($nome === '') {
        $erro = 'O nome da categoria é obrigatório.';
    } else {
        $categoriaModel->update($id, [
            'nome' => $nome
        ]);

        header('Location: categorias.php?mensagem=Categoria atualizada com sucesso');
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
    <title>Editar Categoria</title>
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

<a href="../secure.php"
   class="btn btn-secondary mb-3">
   ← Voltar ao Painel
</a>

<main class="container">

    <div class="card shadow-sm border-0 mx-auto" style="max-width: 700px;">
        <div class="card-body p-4">

            <h1 class="h3 mb-3">Editar categoria</h1>

            <?php if ($erro !== ''): ?>
                <div class="alert alert-danger">
                    <?= e($erro) ?>
                </div>
            <?php endif; ?>

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Nome da categoria</label>
                    <input type="text" name="nome" class="form-control" value="<?= e($nome) ?>" required>
                </div>

                <button type="submit" class="btn btn-primary">
                    Atualizar
                </button>

                <a href="categorias.php" class="btn btn-secondary">
                    Cancelar
                </a>

            </form>

        </div>
    </div>

</main>

</body>
</html>