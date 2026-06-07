<?php

require_once __DIR__ . '/../../config/Database.php';

class Categoria
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = (new Database())->connect();
    }

    public function all(): array
    {
        $stmt = $this->pdo->query("
            SELECT id, nome
            FROM categorias
            ORDER BY nome
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT id, nome
            FROM categorias
            WHERE id = :id
            LIMIT 1
        ");

        $stmt->execute([
            'id' => $id
        ]);

        $categoria = $stmt->fetch(PDO::FETCH_ASSOC);

        return $categoria ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO categorias (nome)
            VALUES (:nome)
        ");

        return $stmt->execute([
            'nome' => $data['nome']
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE categorias
            SET nome = :nome
            WHERE id = :id
        ");

        return $stmt->execute([
            'id' => $id,
            'nome' => $data['nome']
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("
            DELETE FROM categorias
            WHERE id = :id
        ");

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function countProdutos(int $id): int
    {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*)
            FROM produtos
            WHERE categoria_id = :id
        ");

        $stmt->execute([
            'id' => $id
        ]);

        return (int) $stmt->fetchColumn();
    }
}