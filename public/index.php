<?php

header("Content-type: application/json; charset=utf-8");
require_once __DIR__ . '/../vendor/autoload.php';

use App\Application;

$application = new Application(dirname(__DIR__));
$application->run();
