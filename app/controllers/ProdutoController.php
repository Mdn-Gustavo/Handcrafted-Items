<?php

require_once __DIR__ . '/../models/Produto.php';
require_once __DIR__ . '/../models/Categoria.php';

class ProdutoController
{
    private Produto $produtoModel;
    private Categoria $categoriaModel;

    public function __construct()
    {
        $this->produtoModel = new Produto();
        $this->categoriaModel = new Categoria();
    }

    public function index(): array
    {
        return $this->produtoModel->all();
    }

    public function show(int $id): ?array
    {
        return $this->produtoModel->findById($id);
    }

    public function filtrar(?int $categoriaId, bool $somenteDestaque, string $ordem, string $busca = ''): array
    {
        return $this->produtoModel->filter($categoriaId, $somenteDestaque, $ordem, trim($busca));
    }

    public function relacionados(int $produtoId, int $categoriaId): array
    {
        return $this->produtoModel->related($produtoId, $categoriaId);
    }

    public function store(array $dados): array
    {
        [$valido, $mensagem, $produto] = $this->validar($dados);

        if (!$valido) {
            return [false, $mensagem];
        }

        $ok = $this->produtoModel->create($produto);

        return [$ok, $ok ? 'Produto cadastrado com sucesso.' : 'Não foi possível cadastrar o produto.'];
    }

    public function update(int $id, array $dados): array
    {
        [$valido, $mensagem, $produto] = $this->validar($dados);

        if (!$valido) {
            return [false, $mensagem];
        }

        $ok = $this->produtoModel->update($id, $produto);

        return [$ok, $ok ? 'Produto atualizado com sucesso.' : 'Não foi possível atualizar o produto.'];
    }

    public function destroy(int $id): array
    {
        $ok = $this->produtoModel->delete($id);

        return [$ok, $ok ? 'Produto excluído com sucesso.' : 'Não foi possível excluir o produto.'];
    }

    private function validar(array $dados): array
    {
        $nome = trim($dados['nome'] ?? '');
        $descricao = trim($dados['descricao'] ?? '');
        $preco = str_replace(',', '.', trim($dados['preco'] ?? ''));
        $imagem = trim($dados['imagem'] ?? '');
        $estoque = trim($dados['estoque'] ?? '0');
        $detalhes = trim($dados['detalhes'] ?? '');
        $categoriaId = (int) ($dados['categoria_id'] ?? 0);
        $destaque = isset($dados['destaque']) ? 1 : 0;

        if ($nome === '' || $descricao === '' || $preco === '' || $imagem === '' || $categoriaId <= 0) {
            return [false, 'Preencha nome, descrição, preço, imagem e categoria.', []];
        }

        if (!is_numeric($preco) || (float) $preco < 0) {
            return [false, 'O preço precisa ser um número válido.', []];
        }

        if (!ctype_digit((string) $estoque)) {
            return [false, 'O estoque precisa ser um número inteiro igual ou maior que zero.', []];
        }

        if (!$this->categoriaModel->findById($categoriaId)) {
            return [false, 'Categoria inválida.', []];
        }

        return [true, '', [
            'nome' => $nome,
            'descricao' => $descricao,
            'preco' => (float) $preco,
            'imagem' => $imagem,
            'estoque' => (int) $estoque,
            'destaque' => $destaque,
            'detalhes' => $detalhes !== '' ? $detalhes : $descricao,
            'categoria_id' => $categoriaId,
        ]];
    }
}
