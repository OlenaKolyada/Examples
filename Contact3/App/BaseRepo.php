<?php

declare(strict_types=1);

namespace App;

class BaseRepo
{
    protected \PDO $pdo;

    public function __construct()
    {
        $this->connectToDatabase();
    }

    // Connect to DataBase
    private function connectToDatabase(): void
    {
        $config = require __DIR__ . '/../config.php';
        $dbConfig = $config['database'];

        $this->pdo = new \PDO(
            "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']}",
            $dbConfig['user'],
            $dbConfig['password']
        );
    }
}