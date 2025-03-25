<?php

declare(strict_types=1);

namespace App\Views;

class UserView
{
    public function showPersonalAccount(): void
    {
        $content = dirname(__DIR__) . '/../templates/personal_account.html';
        $pageTitle = 'Personal Account';
        include dirname(__DIR__) . '/../templates/layout.html';
    }

}
