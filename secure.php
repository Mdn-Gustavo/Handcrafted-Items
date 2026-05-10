<?php

session_start();

if (!isset($_SESSION["logged_in"])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION["produtos"])) {
    $_SESSION["produtos"] = [];
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = trim($_POST["nome"]);
    $categoria = trim($_POST["categoria"]);
    $preco = trim($_POST["preco"]);
    $descricao = trim($_POST["descricao"]);
    $imagem = trim($_POST["imagem"]);

    if (
        empty($nome) ||
        empty($categoria) ||
        empty($preco) ||
        empty($descricao) ||
        empty($imagem)
    ) {

        $error = "Todos os campos são obrigatórios";

    } elseif (!is_numeric($preco)) {

        $error = "O preço deve ser numérico";

    } else {

        $novoProduto = [
            "id" => uniqid(),
            "nome" => $nome,
            "categoria" => $categoria,
            "preco" => $preco,
            "descricao" => $descricao,
            "imagem" => $imagem,
        ];

        $_SESSION["produtos"][] = $novoProduto;

        $success = "Produto cadastrado com sucesso";
    }
}

?>

<?php if (!empty($error)) : ?>

    <p><?= htmlspecialchars($error) ?></p>

<?php endif; ?>

<?php if (!empty($success)) : ?>

    <p><?= htmlspecialchars($success) ?></p>

<?php endif; ?>

<h1>Área Protegida</h1>

<form method="POST">

    <input type="text" name="nome" placeholder="Nome do produto">

    <br><br>

    <input type="text" name="categoria" placeholder="Categoria">

    <br><br>

    <input type="text" name="preco" placeholder="Preço">

    <br><br>

    <textarea name="descricao" placeholder="Descrição"></textarea>

    <br><br>

    <input type="text" name="imagem" placeholder="URL da imagem">

    <br><br>

    <button type="submit">Cadastrar Produto</button>

</form>

<br>

<a href="logout.php">Logout</a>