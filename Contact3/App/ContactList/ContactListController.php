<?php

declare(strict_types=1);

namespace App\ContactList;

use App\View;

class ContactListController extends View
{
    private ContactList $contactList;
    private ContactListView $contactListView;

    public function __construct()
    {
        $this->contactList = new ContactList();
        $this->contactListView = new ContactListView();
    }

    // Get All Contacts
    public function getAllContacts(): void
    {
        $contacts = $this->contactList->fetchAllContacts();
        $this->renderAllContacts($contacts);
    }

    // Render Contact List
    private function renderAllContacts(array $contacts): void {
        $this->contactListView->displayAllContacts($contacts);
    }

    // Get Contact Stats
    public function getContactStats(): void
    {
        $contacts = $this->contactList->fetchAllContacts();
        $stats = $this->contactList->countContactGenders($contacts);
        $this->renderContactStats($stats);
    }

    // Render Contact Stats
    private function renderContactStats(array $stats): void
    {
        $this->contactListView->displayContactStats($stats);
    }

    // Export Contact List
    public function exportContactsCsv(): void
    {
        $contacts = $this->contactList->fetchAllContacts();

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=contacts_list.csv');

        $output = fopen('php://output', 'w');

        fputcsv($output, ['#', 'Civility', 'First Name', 'Last Name', 'Phone', 'Email']);

        $i = 1;
        foreach ($contacts as $contact) {
            fputcsv($output, [
                $i,
                $contact['civility'],
                $contact['first_name'],
                $contact['last_name'],
                $contact['phone'],
                $contact['email']
            ]);
            $i++;
        }

        fclose($output);
        exit();
    }
}