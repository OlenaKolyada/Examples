<?php

declare(strict_types=1);

namespace App;

class View
{
    // Home Page
    public function homePage(): void
    {
        $content = 'templates/home.html';
        $pageTitle = 'Home Page';
        include 'templates/layout.html';
    }

    // 404 Page
    public function pageNotFound(): void
    {
        $content = 'templates/404.html';
        $pageTitle = 'Page Not Found';
        include 'templates/layout.html';
    }
}