<?php

namespace App\Models;

class Signup extends Auth
{
    private Auth $auth;

    public function __construct()
    {
        parent::__construct();
        $this->auth = new Auth();
    }
    public function signUp(array $formData): bool
    {

        return $this->auth->insertIntoUsers($formData);
    }
}