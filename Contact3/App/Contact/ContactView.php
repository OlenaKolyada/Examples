<?php

declare(strict_types=1);

namespace App\Contact;

class ContactView
{
    // Display Form
    public function displayContactForm(array $contactData = []): void
    {
        $content = 'App/Contact/templates/contact_form.html';
        $pageTitle = 'Contact Form';
        include 'templates/layout.html';
    }

    // Display Result Message
    public function displayResult(bool $result): void
    {
        $content = 'App/Contact/templates/result_message.html';
        if ($result) {
            $pageTitle = 'Success';
        } else {
            $pageTitle = 'Action failed';
        }
        include 'templates/layout.html';
    }
}
