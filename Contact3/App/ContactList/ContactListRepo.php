<?php

declare(strict_types=1);

namespace App\ContactList;

use App\BaseRepo;

class ContactListRepo extends BaseRepo
{
    protected \PDO $pdo;

    public function __construct()
    {
        parent::__construct();
    }

    // Display All Contacts
    public function selectAllContacts(): array
    {
        $sql = "SELECT * FROM `contacts`";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}