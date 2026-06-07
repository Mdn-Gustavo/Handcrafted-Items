<?php

require_once __DIR__ . '/../../config/Database.php';

class Produto
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = (new Database())->connect();
    }

    public function all(): array
    {
        $stmt = $this->pdo->query("
            SELECT
                p.id,
                p.nome,
                p.descricao,
                p.preco,
                p.imagem,
                p.estoque,
                p.destaque,
                p.detalhes,
                c.nome AS categoria
            FROM produtos p
            INNER JOIN categorias c ON c.id = p.categoria_id
            ORDER BY p.id DESC
        ");
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT
                p.id,
                p.nome,
                p.descricao,
                p.preco,
                p.imagem,
                p.estoque,
                p.destaque,
                p.detalhes,
                c.nome AS categoria
            FROM produtos p
            INNER JOIN categorias c ON c.id = p.categoria_id
            WHERE p.id = :id
            LIMIT 1
        ");

        $stmt->execute(['id' => $id]);
        $produto = $stmt->fetch();

        return $produto ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO produtos
            (nome, descricao, preco, imagem, estoque, destaque, detalhes, categoria_id)
            VALUES
            (:nome, :descricao, :preco, :imagem, :estoque, :destaque, :detalhes, :categoria_id)
        ");

        return $stmt->execute([
            'nome' => $data['nome'],
            'descricao' => $data['descricao'],
            'preco' => $data['preco'],
            'imagem' => $data['imagem'],
            'estoque' => $data['estoque'] ?? 0,
            'destaque' => $data['destaque'] ?? 0,
            'detalhes' => $data['detalhes'] ?? $data['descricao'],
            'categoria_id' => $data['categoria_id'],
        ]);
    }
}