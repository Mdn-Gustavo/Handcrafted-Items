<?php

class Database
{
    private string $host = 'localhost';
    private string $dbname = 'handcrafted_items';
    private string $user = 'root';
    private string $password = '';

    private static ?PDO $connection = null;

    public function connect(): PDO
    {
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }

        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";

        self::$connection = new PDO($dsn, $this->user, $this->password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);

        return self::$connection;
    }
}
