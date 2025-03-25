<?php

namespace App;

abstract class Repository
{
    protected ?\PDO $pdo;

    public function __construct()
    {
        $this->connectToDatabase();
    }

    private function connectToDatabase(): void
    {
        $config = require __DIR__ . '/../config.php';
        $dbConfig = $config['db'];

        $this->pdo = new \PDO(
            "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']}",
            $dbConfig['user'],
            $dbConfig['password']
        );
    }

    public function execute(string $sql): bool
    {
        if ($this->pdo === null) {
            throw new \RuntimeException("Database connection is not established.");
        }

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute();
    }

    public function query(string $sql, string $class): ?array
    {
        if ($this->pdo === null) {
            throw new \RuntimeException("Database connection is not established.");
        }

        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute();
        if (false !== $result) {
            return $stmt->fetchAll(\PDO::FETCH_CLASS, $class);
        }
        return [];
    }

    public function disconnectFromDatabase(): void
    {
        $this->pdo = null;
    }

    public function __destruct()
    {
        $this->disconnectFromDatabase();
    }

//    public function query(string $sql): array
//    {
//        $stmt = $this->pdo->query($sql);
//        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
//    }

//    public function execute(string $sql, array $params = []): ?array
//    {
//        $stmt = $this->pdo->prepare($sql);
//        $stmt->execute($params);
//        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
//    }


}