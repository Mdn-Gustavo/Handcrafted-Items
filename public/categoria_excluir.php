<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit();
}

require_once __DIR__ . '/../models/Categoria.php';

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

$totalProdutos = $categoriaModel->countProdutos($id);

if ($totalProdutos > 0) {
    header('Location: categorias.php?erro=Não é possível excluir uma categoria que possui produtos cadastrados');
    exit();
}

$categoriaModel->delete($id);

header('Location: categorias.php?mensagem=Categoria excluída com sucesso');
exit();