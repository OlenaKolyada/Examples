<?php

declare(strict_types=1);

namespace src;

class BaseRepository
{
    protected \PDO $pdo;

    public function __construct()
    {
        $this->connectToDatabase();
    }

    // L'accès au fichier de configuration pour obtenir les informations de connexion à la base de données
    private function connectToDatabase(): void
    {
        $config = require __DIR__ . '/../config.php';
        $dbConfig = $config['db'];

        $this->pdo = new \PDO(  // La création d'une instance de l'objet PDO
            "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']}",
            $dbConfig['user'],
            $dbConfig['password']
        );
    }
}