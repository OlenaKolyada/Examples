<?php

declare(strict_types=1);

namespace src;

class BaseView
{
    // L'affichage de la page 404
    public function display404(): void
    {
        $content = dirname(__DIR__) . '/templates/404.html';
        $title = '404 Not Found';
        include dirname(__DIR__) . '/templates/layout.html';
    }
}