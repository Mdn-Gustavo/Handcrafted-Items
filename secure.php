<?php
session_start();

if (!isset($_SESSION["logged_in"])) {
    header("Location: login.php");
    exit();
}

require_once __DIR__ . "/models/Produto.php";
require_once __DIR__ . "/models/Categoria.php";

$categoriaModel = new Categoria();
$produtoModel = new Produto();
$categorias = $categoriaModel->all();

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"] ?? "");
    $categoria_id = trim($_POST["categoria_id"] ?? "");
    $preco = trim($_POST["preco"] ?? "");
    $descricao = trim($_POST["descricao"] ?? "");
    $imagem = trim($_POST["imagem"] ?? "");

    if (
        $nome === "" ||
        $categoria_id === "" ||
        $preco === "" ||
        $descricao === "" ||
        $imagem === ""
    ) {
        $error = "Todos os campos são obrigatórios";
    } elseif (!is_numeric($preco)) {
        $error = "O preço deve ser numérico";
    } elseif (!is_numeric($categoria_id)) {
        $error = "Categoria inválida";
    } else {
        $ok = $produtoModel->create([
            "nome" => $nome,
            "descricao" => $descricao,
            "preco" => $preco,
            "imagem" => $imagem,
            "categoria_id" => $categoria_id,
            "estoque" => 0,
            "destaque" => 0,
            "detalhes" => $descricao,
        ]);

        if ($ok) {
            $success = "Produto cadastrado com sucesso";
        } else {
            $error = "Erro ao cadastrar produto";
        }
    }
}

include "cabecalho.php";
?>

<link rel="stylesheet" href="assets/css/style.css">
<main class="container admin-container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">

            <div class="admin-header d-flex justify-content-between align-items-center mb-4">
                <h1 class="font-artesanal">Painel Administrativo</h1>
                <a href="logout.php" class="btn btn-logout">Sair do Sistema</a>
            </div>

            <div class="card card-admin shadow-sm border-0">
                <div class="card-body p-4">
                    <h4 class="card-title-admin mb-4">Cadastrar Novo Item</h4>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger alert-custom"><?= htmlspecialchars(
                            $error,
                        ) ?></div>
                    <?php endif; ?>

                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success alert-custom"><?= htmlspecialchars(
                            $success,
                        ) ?></div>
                    <?php endif; ?>

                    <form method="POST" class="admin-form">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label label-small">Nome do Produto</label>
                                <input type="text" name="nome" class="form-control" placeholder="Ex: Sabonete de Alecrim">
                            </div>
                            <div class="mb-3">
                                <label class="form-label label-small">Categoria</label>
                                <select name="categoria_id" class="form-control" required>
                                    <option value="">Selecione</option>
                                    <?php foreach ($categorias as $cat): ?>
                                        <option value="<?= $cat[
                                            "id"
                                        ] ?>"><?= htmlspecialchars(
    $cat["nome"],
) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label label-small">Preço (R$)</label>
                            <input type="text" name="preco" class="form-control" placeholder="0.00">
                        </div>

                        <div class="mb-3">
                            <label class="form-label label-small">Descrição Detalhada</label>
                            <textarea name="descricao" class="form-control" rows="3" placeholder="Descreva os materiais..."></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label label-small">Nome do Arquivo de Imagem</label>
                            <input type="text" name="imagem" class="form-control" placeholder="exemplo.png">
                        </div>

                        <button type="submit" class="btn btn-primary btn-save w-100 py-2">
                            Salvar Produto no Catálogo
                        </button>
                    </form>
                </div>
            </div>

            <?php if (!empty($_SESSION["produtos"])): ?>
                <section class="recent-products mt-5">
                    <h5 class="font-artesanal mb-3">Produtos Adicionados Recentemente</h5>
                    <div class="table-responsive">
                        <table class="table table-custom shadow-sm">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Categoria</th>
                                    <th>Preço</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (
                                    $_SESSION["produtos"]
                                    as $prod
                                ): ?>
                                    <tr>
                                        <td><?= htmlspecialchars(
                                            $prod["nome"],
                                        ) ?></td>
                                        <td><?= htmlspecialchars(
                                            $prod["categoria"],
                                        ) ?></td>
                                        <td>R$ <?= number_format(
                                            $prod["preco"],
                                            2,
                                            ",",
                                            ".",
                                        ) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            <?php endif; ?>

        </div>
    </div>
</main>

<?php include "rodape.php"; ?>
