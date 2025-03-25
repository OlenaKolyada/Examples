<?php

declare(strict_types=1);

namespace App\Models;

class Login extends Auth
{
    private Auth $auth;

    public function __construct()
    {
        parent::__construct();
        $this->auth = new Auth();
    }
    public function getUserStatus(string $email, string $password): string
    {
        $status = $this->auth->fetchUserStatus($email, $password);

        return match ($status) {
            'verified' => 'verified',
            'unverified' => 'unverified',
            'invalid_password' => 'invalid_password',
            'user_not_found' => 'user_not_found',
            default => 'error',
        };
    }
}