<?php

declare(strict_types=1);

namespace App\User;

class UserView
{
    public function displayLoginForm(): void
    {
        $content = 'App/User/templates/login_form.html';
        $pageTitle = 'Sign Up';
        include 'templates/layout.html';
    }

    public function displayResult(bool $result): void
    {
        $content = 'App/User/templates/result.html';
        if ($result) {
            $pageTitle = 'Success';
        } else {
            $pageTitle = 'Action failed';
        }
        include 'templates/layout.html';
    }
}