<?php

declare(strict_types=1);

namespace App;

use App\Views\HomeView;

readonly class Launcher
{
    public function run(): void
    {
        $controllerName = $_GET['c'] ?? 'HomeController';
        $methodName = $_GET['m'] ?? 'renderHomePage';

        $controllerClass = 'App\\Controllers\\' . $controllerName;


        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();
            $controller->$methodName();
        } else {
            $view = new HomeView();
            $view->pageNotFound();
        }
    }
}