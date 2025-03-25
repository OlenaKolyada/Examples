<?php

declare(strict_types=1);

namespace App\Models;

use App\Repository;

class Auth extends Repository
{
    protected int $id;
    protected string $firstName;
    protected string $lastName;
    protected string $email;
    protected string $password;
    protected string $role;
    protected string $phone;
    protected \DateTime $dateOfBirth;
    protected string $gender;
    protected \DateTime $createdAt;

    public function __construct()
    {
        parent::__construct();
    }

    public function insertIntoUsers(array $formData): bool
    {
        $hashedPassword = password_hash($formData['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO `users`(`email`, `password`, `registration_date`, `confirmation_token`, `token_expires_at`, `status`)
                VALUES (:email, :password, :registration_date, :confirmation_token, :token_expires_at, :status)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':email', $formData['email']);
        $stmt->bindValue(':password', $hashedPassword);
        $stmt->bindValue(':registration_date', $formData['registration_date']);
        $stmt->bindValue(':confirmation_token', $formData['confirmation_token']);
        $stmt->bindValue(':token_expires_at', $formData['token_expires_at']);
        $stmt->bindValue(':status', $formData['status']);

        return $stmt->execute();
    }

    public function updateToken(string $email, string $token, string $tokenExpiresAt): bool
    {
        $sql = "UPDATE `users`
            SET `confirmation_token` = :confirmation_token, `token_expires_at` = :token_expires_at
            WHERE `email` = :email";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
        $stmt->bindValue(':confirmation_token', $token, \PDO::PARAM_STR);
        $stmt->bindValue(':token_expires_at', $tokenExpiresAt);

        return $stmt->execute();
    }


    public function updatePassword(string $email, string $password): bool
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE `users`
            SET `password` = :password
            WHERE `email` = :email";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
        $stmt->bindValue(':password', $hashedPassword);

        return $stmt->execute();
    }


    public function isEmailExists(string $email): bool
    {
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetchColumn() > 0;
    }

    public function fetchUserStatus(string $email, string $password): ?string
    {
        $sql = "SELECT password, status FROM `users` WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Если пользователь найден
        if ($user) {
            // Проверяем, совпадает ли введённый пароль с хэшированным паролем
            if (password_verify($password, $user['password'])) {
                // Возвращаем статус пользователя
                return $user['status'];
            } else {
                // Пароль неверный
                return 'invalid_password';
            }
        } else {
            // Пользователь не найден
            return 'user_not_found';
        }
    }

//    public function isEmailExists(string $email): bool
//    {
//        return $this->authRepository->isEmailExists($email);
//    }
//
//    public function updatePassword(string $email, string $password): bool
//    {
//        return $this->authRepository->updatePassword($email, $password);
//    }


}
