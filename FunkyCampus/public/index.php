<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\Launcher;

$launcher = new Launcher();
$launcher->run();