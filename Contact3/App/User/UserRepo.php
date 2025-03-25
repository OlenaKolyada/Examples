<?php

declare(strict_types=1);

namespace App\User;

use App\BaseRepo;

class UserRepo extends BaseRepo
{
    protected \PDO $pdo;

    public function __construct() {
        parent::__construct();
    }

    public function createUser(array $formData): bool
    {
        $hashedPassword = password_hash($formData['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO `users` (`login`, `password`, `role`) 
                VALUES (:login, :password, :role)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':login', $formData['login']);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role', $formData['role']);

        return $stmt->execute();
    }
}
