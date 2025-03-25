<?php

declare(strict_types=1);

namespace App\Contact;

use App\View;

class ContactController extends View
{
    private Contact $contact;
    private ContactView $contactView;

    public function __construct()
    {
        $this->contact = new Contact();
        $this->contactView = new ContactView();
    }

    // Render Contact Form
    public function renderContactForm(): void
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        if ($id !== null) {
            $contactData = $this->getContactDataFromDb((int)$id);
        } else {
            $contactData = [];
        }
        $this->contactView->displayContactForm($contactData);
    }

    // Submit Contact Form
    public function submitContactForm(): void
    {
    $id = isset($_POST['id']) && $_POST['id'] !== '' ? (int)$_POST['id'] : null;
    $contactData = $this->getContactDataFromPost();
    $result = $this->contact->processContactForm($contactData, $id);
    $this->renderResult($result);
    }

    // Render Result Message
    private function renderResult(bool $result): void
    {
        if($result) {
            $this->contactView->displayResult(true);
        } else {
            $this->contactView->displayResult(false);
        }
    }

    // Handle Contact Delete Request
    public function handleContactDeleteRequest(): void
    {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $result = $this->contact->processContactDeleteRequest((int)$id);
        $this->renderResult($result);
    }

    // Get Contact Data From Database
    private function getContactDataFromDb(?int $id): array
    {
        $contactDataFromDb = $this->contact->fetchContact((int)$id);

        return [
            'id' => $contactDataFromDb[0]['id'] ?? '',
            'civility' => $contactDataFromDb[0]['civility'] ?? '',
            'firstName' => $contactDataFromDb[0]['first_name'] ?? '',
            'lastName' => $contactDataFromDb[0]['last_name'] ?? '',
            'phone' => $contactDataFromDb[0]['phone'] ?? '',
            'email' => $contactDataFromDb[0]['email'] ?? '',
            'subject' => $contactDataFromDb[0]['subject'] ?? '',
            'message' => $contactDataFromDb[0]['message'] ?? '',
        ];
    }

    // Get Contact Data From User Input
    private function getContactDataFromPost(): array
    {
        return [
            'id' => $_POST['id'] ?? '',
            'civility' => $_POST['civility'] ?? '',
            'firstName' => $_POST['firstName'] ?? '',
            'lastName' => $_POST['lastName'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'email' => $_POST['email'] ?? '',
            'subject' => $_POST['subject'] ?? '',
            'message' => $_POST['message'] ?? ''
        ];
    }
}