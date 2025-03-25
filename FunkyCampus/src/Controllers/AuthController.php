<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Auth;
use App\Views\AuthView;

class AuthController
{
    protected Auth $auth;
    protected AuthView $authView;

    public function __construct()
    {
        $this->auth = new Auth();
        $this->authView = new AuthView();
    }

    public function getAuthForm(): void
    {
        $action = $_GET['action'] ?? $_POST['action'] ?? '';
        $this->authView->showAuthForm($action, '');
    }
}
