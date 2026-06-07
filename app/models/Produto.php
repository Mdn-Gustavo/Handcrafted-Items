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
        $stmt = $this->pdo->query('
            SELECT
                p.id,
                p.nome,
                p.descricao,
                p.preco,
                p.imagem,
                p.estoque,
                p.destaque,
                p.detalhes,
                p.categoria_id,
                c.nome AS categoria
            FROM produtos p
            INNER JOIN categorias c ON c.id = p.categoria_id
            ORDER BY p.id DESC
        ');

        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('
            SELECT
                p.id,
                p.nome,
                p.descricao,
                p.preco,
                p.imagem,
                p.estoque,
                p.destaque,
                p.detalhes,
                p.categoria_id,
                c.nome AS categoria
            FROM produtos p
            INNER JOIN categorias c ON c.id = p.categoria_id
            WHERE p.id = :id
            LIMIT 1
        ');

        $stmt->execute(['id' => $id]);
        $produto = $stmt->fetch();

        return $produto ?: null;
    }

    public function filter(?int $categoriaId, bool $somenteDestaque, string $ordem, string $busca = ''): array
    {
        $sql = '
            SELECT
                p.id,
                p.nome,
                p.descricao,
                p.preco,
                p.imagem,
                p.estoque,
                p.destaque,
                p.detalhes,
                p.categoria_id,
                c.nome AS categoria
            FROM produtos p
            INNER JOIN categorias c ON c.id = p.categoria_id
            WHERE 1 = 1
        ';

        $params = [];

        if ($categoriaId !== null) {
            $sql .= ' AND p.categoria_id = :categoria_id';
            $params['categoria_id'] = $categoriaId;
        }

        if ($somenteDestaque) {
            $sql .= ' AND p.destaque = 1';
        }

        if ($busca !== '') {
            $sql .= ' AND (p.nome LIKE :busca OR p.descricao LIKE :busca OR c.nome LIKE :busca)';
            $params['busca'] = '%' . $busca . '%';
        }

        $ordensPermitidas = [
            'preco_asc' => 'p.preco ASC',
            'preco_desc' => 'p.preco DESC',
            'nome_az' => 'p.nome ASC',
            'nome_za' => 'p.nome DESC',
            'padrao' => 'p.id DESC',
        ];

        $sql .= ' ORDER BY ' . ($ordensPermitidas[$ordem] ?? $ordensPermitidas['padrao']);

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function related(int $produtoId, int $categoriaId, int $limit = 3): array
    {
        $stmt = $this->pdo->prepare('
            SELECT
                id,
                nome,
                descricao,
                preco,
                imagem,
                estoque,
                destaque,
                categoria_id
            FROM produtos
            WHERE categoria_id = :categoria_id
              AND id <> :id
            ORDER BY id DESC
            LIMIT ' . (int) $limit . '
        ');

        $stmt->execute([
            'categoria_id' => $categoriaId,
            'id' => $produtoId,
        ]);

        return $stmt->fetchAll();
    }

    public function create(array $data): bool
    {
        $stmt = $this->pdo->prepare('
            INSERT INTO produtos
                (nome, descricao, preco, imagem, estoque, destaque, detalhes, categoria_id)
            VALUES
                (:nome, :descricao, :preco, :imagem, :estoque, :destaque, :detalhes, :categoria_id)
        ');

        return $stmt->execute([
            'nome' => $data['nome'],
            'descricao' => $data['descricao'],
            'preco' => $data['preco'],
            'imagem' => $data['imagem'],
            'estoque' => $data['estoque'],
            'destaque' => $data['destaque'],
            'detalhes' => $data['detalhes'],
            'categoria_id' => $data['categoria_id'],
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare('
            UPDATE produtos
            SET
                nome = :nome,
                descricao = :descricao,
                preco = :preco,
                imagem = :imagem,
                estoque = :estoque,
                destaque = :destaque,
                detalhes = :detalhes,
                categoria_id = :categoria_id
            WHERE id = :id
        ');

        return $stmt->execute([
            'id' => $id,
            'nome' => $data['nome'],
            'descricao' => $data['descricao'],
            'preco' => $data['preco'],
            'imagem' => $data['imagem'],
            'estoque' => $data['estoque'],
            'destaque' => $data['destaque'],
            'detalhes' => $data['detalhes'],
            'categoria_id' => $data['categoria_id'],
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('
            DELETE FROM produtos
            WHERE id = :id
        ');

        return $stmt->execute(['id' => $id]);
    }
}
