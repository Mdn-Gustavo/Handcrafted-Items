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
                p.categoria_id,
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
                p.categoria_id,
                c.nome AS categoria
            FROM produtos p
            INNER JOIN categorias c ON c.id = p.categoria_id
            WHERE p.id = :id
            LIMIT 1
        ");

        $stmt->execute([
            'id' => $id
        ]);

        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        return $produto ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO produtos
            (nome, descricao, preco, imagem, estoque, destaque, categoria_id)
            VALUES
            (:nome, :descricao, :preco, :imagem, :estoque, :destaque, :categoria_id)
        ");

        return $stmt->execute([
            'nome' => $data['nome'],
            'descricao' => $data['descricao'],
            'preco' => $data['preco'],
            'imagem' => $data['imagem'],
            'estoque' => $data['estoque'],
            'destaque' => $data['destaque'],
            'categoria_id' => $data['categoria_id']
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE produtos
            SET
                nome = :nome,
                descricao = :descricao,
                preco = :preco,
                imagem = :imagem,
                estoque = :estoque,
                destaque = :destaque,
                categoria_id = :categoria_id
            WHERE id = :id
        ");

        return $stmt->execute([
            'id' => $id,
            'nome' => $data['nome'],
            'descricao' => $data['descricao'],
            'preco' => $data['preco'],
            'imagem' => $data['imagem'],
            'estoque' => $data['estoque'],
            'destaque' => $data['destaque'],
            'categoria_id' => $data['categoria_id']
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("
            DELETE FROM produtos
            WHERE id = :id
        ");

        return $stmt->execute([
            'id' => $id
        ]);
    }
}