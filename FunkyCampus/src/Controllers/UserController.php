<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use App\Views\UserView;

class UserController
{
    private User $user;
    private UserView $userView;
    public function __construct()
    {
        $this->user = new User();
        $this->userView = new UserView();
    }

}
