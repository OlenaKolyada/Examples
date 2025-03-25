<?php

declare(strict_types=1);

namespace App\ContactList;

class ContactList
{
    private $contactListRepo;

    public function __construct()
    {
        $this->contactListRepo = new ContactListRepo();
    }

    // Fetch All Contacts
    public function fetchAllContacts(): array
    {
        return $this->contactListRepo->selectAllContacts();
    }

    // Count Contact Genders
    public function countContactGenders(array $contacts): array
    {
        $women = 0;
        $men = 0;
        $nonbinary = 0;

        foreach ($contacts as $contact) {
            if ($contact['civility'] === 'Mr.') {
                $men++;
            } elseif ($contact['civility'] === 'Ms.') {
                $women++;
            } elseif ($contact['civility'] === 'Mx.') {
                $nonbinary++;
            }
        }

        return [
            'women' => $women,
            'men' => $men,
            'nonbinary' => $nonbinary
        ];
    }
}