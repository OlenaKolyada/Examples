<?php

declare(strict_types=1);

namespace App\Contact;

class Contact
{
    private ContactRepo $contactRepo;

    public function __construct()
    {
        $this->contactRepo = new ContactRepo();
    }

    // Process Contact Form
    public function processContactForm(array $contactData, int|null $id): bool
    {
        if ($id !== null) {
            return $this->contactRepo->updateContact((int)$id, $contactData);
        } else {
            return $this->contactRepo->createContact($contactData);
        }
    }

    // Fetch Contact
    public function fetchContact(int $id): array
    {
        return $this->contactRepo->readContact((int)$id);
    }

    // Process Contact Delete Request
    public function processContactDeleteRequest(int $id): bool
    {
        return $this->contactRepo->deleteContact($id);
    }
}
