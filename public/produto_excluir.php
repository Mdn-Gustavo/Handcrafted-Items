<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit();
}

require_once __DIR__ . '/../models/Produto.php';

$produtoModel = new Produto();

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

$produtoModel->delete($id);

header('Location: produtos.php?mensagem=Produto excluído com sucesso');
exit();