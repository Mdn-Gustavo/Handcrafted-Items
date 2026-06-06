<?php

require_once __DIR__ . '/../config/Database.php';

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
}