<?php

declare(strict_types=1);

namespace App\User;

class User
{
    private UserRepo $userRepo;

    public function __construct() {
        $this->userRepo = new UserRepo();
    }

    public function processLoginForm(array $formData, int|null $id): bool
    {
        if ($id === null) {
            return $this->userRepo->createUser($formData);
        }
    }
}