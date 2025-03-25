<?php

namespace App\Models;

use App\Repository;

class Verify extends Repository
{
    public function verifyUserByToken(string $token): bool
    {
        $sql = "
            UPDATE `users`
            SET `status` = 'verified'
            WHERE `confirmation_token` = :token
            AND `token_expires_at` > NOW()
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':token', $token);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}