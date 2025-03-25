<?php

require 'autoload.php';

use App\View;
use App\Contact\ContactController;
use App\ContactList\ContactListController;
use App\Weather\WeatherController;
use App\User\UserController;
use App\Rss\RssController;

$controllerName = $_GET['c'] ?? 'View';
$methodName = $_GET['m'] ?? 'homePage';

switch($controllerName) {
    case 'ContactController':
        $namespace = 'App\\Contact\\';
        break;

    case 'ContactListController':
        $namespace = 'App\\ContactList\\';
        break;

    case 'UserController':
        $namespace = 'App\\User\\';
        break;

    case 'WeatherController':
        $namespace = 'App\\Weather\\';
        break;

    case 'RssController':
        $namespace = 'App\\Rss\\';
        break;

    default:
        $namespace = 'App\\';
        break;
}

$controllerClass = $namespace . $controllerName;

if (class_exists($controllerClass)) {
    $controller = new $controllerClass();

    if (method_exists($controller, $methodName)) {
        if ($controllerName === 'WeatherController' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->getWeather();
        } elseif ($controllerName === 'RssController' && $methodName === 'getRss') {
            $type = $_GET['t'];
            $controller->$methodName($type);
        } else {
            $controller->$methodName();
        }
    }
}
