<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Views\HomeView;

class HomeController
{
    private HomeView $view;

    public function __construct()
    {
        $this->view = new HomeView();
    }

    public function renderHomePage(): void
    {
        $this->view->displayHomePage();
    }
}