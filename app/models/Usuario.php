<?php

require_once __DIR__ . '/../../config/Database.php';

class Usuario
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = (new Database())->connect();
    }

    public function all(): array
    {
        $stmt = $this->pdo->query('
            SELECT id, nome, email, tipo_usuario, criado_em
            FROM usuarios
            ORDER BY id DESC
        ');

        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('
            SELECT id, nome, email, tipo_usuario, criado_em
            FROM usuarios
            WHERE id = :id
            LIMIT 1
        ');

        $stmt->execute(['id' => $id]);
        $usuario = $stmt->fetch();

        return $usuario ?: null;
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare('
            SELECT id, nome, email, senha, tipo_usuario, criado_em
            FROM usuarios
            WHERE email = :email
            LIMIT 1
        ');

        $stmt->execute(['email' => $email]);
        $usuario = $stmt->fetch();

        return $usuario ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->pdo->prepare('
            INSERT INTO usuarios (nome, email, senha, tipo_usuario)
            VALUES (:nome, :email, :senha, :tipo_usuario)
        ');

        return $stmt->execute([
            'nome' => $data['nome'],
            'email' => $data['email'],
            'senha' => password_hash($data['senha'], PASSWORD_DEFAULT),
            'tipo_usuario' => $data['tipo_usuario'] ?? 'comum',
        ]);
    }

    public function update(int $id, array $data): bool
    {
        if (!empty($data['senha'])) {
            $stmt = $this->pdo->prepare('
                UPDATE usuarios
                SET nome = :nome,
                    email = :email,
                    senha = :senha,
                    tipo_usuario = :tipo_usuario
                WHERE id = :id
            ');

            return $stmt->execute([
                'id' => $id,
                'nome' => $data['nome'],
                'email' => $data['email'],
                'senha' => password_hash($data['senha'], PASSWORD_DEFAULT),
                'tipo_usuario' => $data['tipo_usuario'],
            ]);
        }

        $stmt = $this->pdo->prepare('
            UPDATE usuarios
            SET nome = :nome,
                email = :email,
                tipo_usuario = :tipo_usuario
            WHERE id = :id
        ');

        return $stmt->execute([
            'id' => $id,
            'nome' => $data['nome'],
            'email' => $data['email'],
            'tipo_usuario' => $data['tipo_usuario'],
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('
            DELETE FROM usuarios
            WHERE id = :id
        ');

        return $stmt->execute(['id' => $id]);
    }

    public function verificarLogin(string $email, string $senha): ?array
    {
        $usuario = $this->findByEmail($email);

        if (!$usuario || !password_verify($senha, $usuario['senha'])) {
            return null;
        }

        return $usuario;
    }
}
