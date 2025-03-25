<?php

namespace App\Views;

class HomeView
{
    public function displayHomePage(): void
    {
        $content = dirname(__DIR__) . '/../templates/home.html';
        $pageTitle = 'Funky Campus';
        include dirname(__DIR__) . '/../templates/layout.html';
    }

    public function pageNotFound(): void
    {
        $content = dirname(__DIR__) . '/../templates/404.html';
        $pageTitle = 'Page Not Found';
        include dirname(__DIR__) . '/../templates/layout.html';
    }
}