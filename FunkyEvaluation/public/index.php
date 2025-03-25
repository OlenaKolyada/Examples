<?php

require dirname(__DIR__) . '/vendor/autoload.php';

function createMovieController() {
    $movieRepository = new \src\Movie\MovieRepository();
    $movieView = new \src\Movie\MovieView();
    $movie = new \src\Movie\Movie($movieRepository);
    return new \src\Movie\MovieController($movie, $movieView);
}

$controllerName = $_GET['c'] ?? 'MovieController';
$methodName = $_GET['m'] ?? 'getAllMovies';

$namespace = match ($controllerName) {
    'MovieController' => 'src\\Movie\\',
    default => 'src\\',
};

$controllerClass = $namespace . $controllerName;

if (class_exists($controllerClass)) {
    if ($controllerClass === $namespace . 'MovieController') {
        $controller = createMovieController();
    } else {
        $controller = new $controllerClass();
    }

    if (method_exists($controller, $methodName)) {
        $controller->$methodName();
    } else {
        $baseView = new \src\BaseView();
        $baseView->display404();
    }
} else {
    $baseView = new \src\BaseView();
    $baseView->display404();
}
