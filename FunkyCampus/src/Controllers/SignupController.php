<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Signup;
use App\Services\EmailSender;
use App\Services\TokenGenerator;

class SignupController extends AuthController
{
    private Signup $signup;
    private TokenGenerator $tokenGenerator;
    private EmailSender $emailSender;

    public function __construct()
    {
        parent::__construct();
        $this->signup = new Signup();
        $this->tokenGenerator = new TokenGenerator();
        $this->emailSender = new EmailSender();
    }

    public function signUp(): void
    {
        $email = $_POST['email'];
        $emailExists = $this->signup->isEmailExists($email);

        if ($emailExists) {
            $this->authView->showAuthForm('signup', 'Email is already in use.');
        } else {
            $formData = $this->getSignupData();
            $result = $this->signup->signUp($formData);

            if ($result) {
                $this->emailSender->sendConfirmationEmail($email, $formData['confirmation_token']);
                $this->authView->showAuthFormResult('regSuccess');
            } else {
                $this->authView->showAuthFormResult('regFailure');
            }
        }
    }

    private function getSignupData(): array
    {
        return array(
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'registration_date' => $_POST['registration_date'] ?? date('Y-m-d'),
            'status' => 'unverified',
            'confirmation_token' => $this->tokenGenerator->generateToken(),
            'token_expires_at' => (new \DateTime())->modify('+24 hours')->format('Y-m-d H:i:s')
        );
    }
}
