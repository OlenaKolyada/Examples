<?php

declare(strict_types=1);

namespace App\Views;

class AuthView
{
    public function showAuthForm(string $action, string $message): void
    {
        if ($action === 'login') {
            $title = 'Login';
        } elseif ($action === 'signup') {
            $title = 'Sign Up';
        } elseif ($action === 'restore' || $action === 'updatePassword') {
            $title = 'Restore Password';
        }

        $content = dirname(__DIR__) . '/../templates/auth_form.html';
        include dirname(__DIR__) . '/../templates/layout.html';
    }

    public function showAuthFormResult(string $status): void
    {

        $messages = [
            'unverified' => [
                'title' => 'You’re almost there!',
                'message' => 'You need to confirm your email before logging in.<br>Check your email for our confirmation link and click it to complete the process.'
            ],
            'confirmationNeeded' => [
                'title' => 'Confirmation Needed',
                'message' => 'We sent you a link to reset your password.'
            ],
            'passUpdated' => [
                'title' => 'Password updated',
                'message' => 'Password updated successfully.'
            ],
            'passUpdateFailure' => [
                'title' => 'Password Update Failed',
                'message' => 'Try again please.'
            ],
            'regSuccess' => [
                'title' => 'Registration successful!',
                'message' => 'A confirmation email is on its way to your inbox.<br>Check it out to finish up!'
            ],
            'regFailure' => [
                'title' => 'Something went wrong',
                'message' => 'Looks like your registration ran into some trouble.<br>Give it another try!'
            ],
            'verificationSuccess' => [
                'title' => 'Email Verified',
                'message' => 'Your email has been successfully verified!'
            ],
            'invalidToken' => [
                'title' => 'Email Verification Failed',
                'message' => 'Invalid or expired token.'
            ],
            'verificationFailure' => [
                'title' => 'Email Verification Failed',
                'message' => 'An error occurred. Please try again.'
            ]
        ];

        $messageData = $messages[$status] ?? [
            'title' => 'Unknown Status',
            'message' => 'An unknown status was encountered.'
        ];

        $title = $messageData['title'];
        $message = $messageData['message'];

        $content = dirname(__DIR__) . '/../templates/auth_form_result.html';
        include dirname(__DIR__) . '/../templates/layout.html';
    }
}
