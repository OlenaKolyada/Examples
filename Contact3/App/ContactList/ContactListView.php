<?php

declare(strict_types=1);

namespace App\ContactList;

class ContactListView
{
    // Display All Contacts
    public function displayAllContacts(array $contacts): void
    {
        $content = 'App/ContactList/templates/contact_list.html';
        $pageTitle = 'Contact List';
        include 'templates/layout.html';
    }

    // Display Contact Stats
    public function displayContactStats(array $stats): void
    {
        $content = 'App/ContactList/templates/contact_stats.html';
        $pageTitle = 'Contact Stats';
        include 'templates/layout.html';
    }
}