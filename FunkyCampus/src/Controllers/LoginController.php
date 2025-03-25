<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Login;
use App\Views\UserView;

class LoginController extends AuthController
{
    private Login $login;
    private UserView $userView;
    public function __construct()
    {
        parent::__construct();
        $this->login = new Login();
        $this->userView = new UserView();
    }
    public function login(): void
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $status = $this->login->getUserStatus($email, $password);

        if ($status === 'unverified') {
            $this->authView->showAuthFormResult($status);

        } elseif ($status === 'invalid_password') {
            $this->authView->showAuthForm('login','Wrong password');

        } elseif ($status === 'user_not_found') {
            $this->authView->showAuthForm('login','User not found');

        } else {
            $this->userView->showPersonalAccount();
        }
    }
}