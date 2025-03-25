<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Auth;
use App\Services\EmailSender;
use App\Services\TokenGenerator;

class RestoreController extends AuthController
{
    protected Auth $auth;
    private TokenGenerator $tokenGenerator;
    private EmailSender $emailSender;

    public function __construct()
    {
        parent::__construct();
        $this->auth = new Auth();
        $this->tokenGenerator = new TokenGenerator();
        $this->emailSender = new EmailSender();
    }
    public function requestPasswordUpdate(): void
    {
        $email = $_POST['email'];
        $result = $this->auth->isEmailExists($email);

        if($result) {
            $token = $this->tokenGenerator->generateToken();
            $tokenExpiresAt = (new \DateTime())->modify('+24 hours')->format('Y-m-d H:i:s');
            $this->auth->updateToken($email, $token, $tokenExpiresAt);
            $this->emailSender->sendPasswordRestoreEmail($email, $token);

            $this->authView->showAuthFormResult('confirmationNeeded');

        } else {
            $this->authView->showAuthForm('restore','User not found');
        }
    }

    public function updatePassword(): void
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $status = ($this->auth->updatePassword($email, $password)) ? 'passUpdated' : 'passUpdateFailure';
        $this->authView->showAuthFormResult($status);
    }
}