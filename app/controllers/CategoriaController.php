<?php

require_once __DIR__ . '/../models/Categoria.php';

class CategoriaController
{
    private Categoria $categoriaModel;

    public function __construct()
    {
        $this->categoriaModel = new Categoria();
    }

    public function index(): array
    {
        return $this->categoriaModel->all();
    }

    public function show(int $id): ?array
    {
        return $this->categoriaModel->findById($id);
    }

    public function store(array $dados): array
    {
        $nome = trim($dados['nome'] ?? '');

        if ($nome === '') {
            return [false, 'Informe o nome da categoria.'];
        }

        $ok = $this->categoriaModel->create(['nome' => $nome]);

        return [$ok, $ok ? 'Categoria cadastrada com sucesso.' : 'Não foi possível cadastrar a categoria.'];
    }

    public function update(int $id, array $dados): array
    {
        $nome = trim($dados['nome'] ?? '');

        if ($nome === '') {
            return [false, 'Informe o nome da categoria.'];
        }

        $ok = $this->categoriaModel->update($id, ['nome' => $nome]);

        return [$ok, $ok ? 'Categoria atualizada com sucesso.' : 'Não foi possível atualizar a categoria.'];
    }

    public function destroy(int $id): array
    {
        if ($this->categoriaModel->countProdutos($id) > 0) {
            return [false, 'Essa categoria possui produtos vinculados. Exclua ou mova os produtos antes.'];
        }

        try {
            $ok = $this->categoriaModel->delete($id);
        } catch (PDOException $erro) {
            return [false, 'Não foi possível excluir a categoria.'];
        }

        return [$ok, $ok ? 'Categoria excluída com sucesso.' : 'Não foi possível excluir a categoria.'];
    }
}
