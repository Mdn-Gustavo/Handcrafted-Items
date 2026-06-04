<?php

class Database
{
    private string $host = "localhost";
    private string $dbname = "handcrafted_items";
    private string $user = "rootdasilva";
    private string $password = "123456";
    public function connect(): PDO
    {
        return new PDO(
            "mysql:host={$this->host};dbname={$this->dbname}",
            $this->user,
            $this->password,
        );
    }
}
