<?php

namespace App\Services;

class TokenGenerator
{
    public function generateToken(): string
    {
        return bin2hex(random_bytes(16));
    }
}