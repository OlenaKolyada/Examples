<?php

spl_autoload_register(function ($class) {
    $classParts = explode('\\', $class);
    $file = __DIR__ . '/' . implode('/', $classParts) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});
