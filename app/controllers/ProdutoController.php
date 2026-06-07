<?php

require_once __DIR__ . "/../Handcrafted-Items-main/model/Produto.php";

class ProdutoController
{
    private $produtoModel;

    public function __construct()
    {
        $this->produtoModel = new Produto();
    }

    public function index()
    {
        return $this->produtoModel->all();
    }

    public function show($id)
    {
        return $this->produtoModel->findById($id);
    }

    public function store($dados)
    {
        return $this->produtoModel->create($dados);
    }

    public function filtrar($categoria = null)
    {
        $produtos = $this->produtoModel->all();

        if (!$categoria) {
            return $produtos;
        }

        return array_filter($produtos, function ($produto) use ($categoria) {
            return $produto["categoria_id"] == $categoria;
        });
    }
}
