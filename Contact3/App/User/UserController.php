<?php

declare(strict_types=1);

namespace App\User;

class UserController
{
    private User $user;
    private UserView $userView;

    public function __construct() {
        $this->user = new User();
        $this->userView = new UserView();
    }

    public function getLoginForm(): void
    {
        $this->userView->displayLoginForm();
    }

    public function submitLoginForm(): void
    {
        $id = isset($_POST['id']) && $_POST['id'] !== '' ? (int)$_POST['id'] : null;
        $formData = $_POST;
        $result = $this->user->processLoginForm($formData, $id);
        $this->renderResult($result);
    }

    private function renderResult(bool $result): void
    {
        if($result) {
            $this->userView->displayResult(true);
        } else {
            $this->userView->displayResult(false);
        }
    }
}