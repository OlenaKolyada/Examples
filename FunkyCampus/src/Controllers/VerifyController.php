<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Verify;
use App\Views\AuthView;

class VerifyController
{
    private Verify $verify;
    private AuthView $authView;

    public function __construct()
    {
        $this->verify = new Verify();
        $this->authView = new AuthView();
    }
    public function verifyEmail(): void
    {
        $token = $_GET['token'] ?? '';

        if ($token === '') {
            $status = 'invalidToken';
        }

        try {
            $isVerified = $this->verify->verifyUserByToken($token);

            if ($isVerified) {
                $status = 'verificationSuccess';
            } else {
                $status = 'verificationFailure';

            }
        } catch (\Exception $e) {
            $status = 'verificationFailure';
        }
        $this->authView->showAuthFormResult($status);
    }

    public function verifyPasswordUpdate(): void
    {
        $token = $_GET['token'] ?? '';

        if ($token === '') {
            $this->authView->showAuthFormResult('invalidToken');
        } else {
            $this->authView->showAuthForm('updatePassword', 'Update Password');
        }
    }
}
