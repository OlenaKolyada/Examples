<?php

declare(strict_types=1);

namespace App\Contact;

use App\BaseRepo;

class ContactRepo extends BaseRepo
{
    protected \PDO $pdo;

    public function __construct()
    {
        parent::__construct();
    }

    // Insert Into Contacts
    public function createContact(array $contactData): bool
    {
        $sql = "INSERT INTO `contacts` (`civility`, `first_name`, `last_name`, `phone`, `email`, `subject`, `message`) 
                                VALUES (:civility, :first_name, :last_name, :phone, :email, :subject, :message)";

        $stmt = $this->pdo->prepare($sql);

        $params = [
            ':civility' => $contactData['civility'] ?? null,
            ':first_name' => $contactData['firstName'] ?? null,
            ':last_name' => $contactData['lastName'] ?? null,
            ':phone' => $contactData['phone'] ?? null,
            ':email' => $contactData['email'] ?? null,
            ':subject' => $contactData['subject'] ?? null,
            ':message' => $contactData['message'] ?? null,
        ];

        foreach ($params as $param => $value) {
            $stmt->bindValue($param, $value, \PDO::PARAM_STR);
        }

        return $stmt->execute();
    }

    // Select Contact
    public function readContact(int $id): array
    {
        $sql = "SELECT * FROM `contacts` WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Update Contact
    public function updateContact(int $id, array $contactData): bool
    {
        $sql = "UPDATE `contacts` 
        SET 
            civility = :civility,
            first_name = :first_name,
            last_name = :last_name,
            phone = :phone,
            email = :email,
            subject = :subject,
            message = :message
        WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        $params = [
            ':civility' => $contactData['civility'] ?? null,
            ':first_name' => $contactData['firstName'] ?? null,
            ':last_name' => $contactData['lastName'] ?? null,
            ':phone' => $contactData['phone'] ?? null,
            ':email' => $contactData['email'] ?? null,
            ':subject' => $contactData['subject'] ?? null,
            ':message' => $contactData['message'] ?? null,
        ];

        foreach ($params as $param => $value) {
            $stmt->bindValue($param, $value, \PDO::PARAM_STR);
        }

        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Delete Contact
    public function deleteContact(int $id): bool
    {
        $sql = "DELETE FROM `contacts` WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}
