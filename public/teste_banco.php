<?php
require_once __DIR__ . '/../config/Database.php';

header('Content-Type: text/plain; charset=utf-8');

try {
    $pdo = (new Database())->connect();

    echo "Conexão com o banco OK.\n\n";

    $tabelas = ['usuarios', 'categorias', 'produtos'];

    foreach ($tabelas as $tabela) {
        $stmt = $pdo->query("SHOW COLUMNS FROM {$tabela}");
        $colunas = $stmt->fetchAll(PDO::FETCH_COLUMN);

        echo "Tabela {$tabela}: " . implode(', ', $colunas) . "\n";
    }

    echo "\nUsuários cadastrados:\n";
    $stmt = $pdo->query('SELECT id, nome, email, tipo_usuario FROM usuarios ORDER BY id ASC');
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($usuarios as $usuario) {
        echo "#{$usuario['id']} - {$usuario['nome']} - {$usuario['email']} - {$usuario['tipo_usuario']}\n";
    }
} catch (Throwable $erro) {
    http_response_code(500);
    echo "ERRO NO BANCO:\n";
    echo $erro->getMessage() . "\n";
    echo "\nConfira o nome do banco em config/Database.php e importe database/Script.sql no phpMyAdmin.\n";
}
