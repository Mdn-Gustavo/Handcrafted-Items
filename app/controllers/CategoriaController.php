<?php

require_once __DIR__ . '/../Handcrafted-Items-main/model/Categoria.php';

class CategoriaController
{
    private $categoriaModel;

    public function __construct()
    {
        $this->categoriaModel = new Categoria();
    }

    public function index()
    {
        return $this->categoriaModel->all();
    }
}