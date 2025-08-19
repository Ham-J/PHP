<?php
require __DIR__ . '/../vendor/autoload.php';
session_start();

$router = require __DIR__ . '/../routes/router.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->dispatch($_SERVER['REQUEST_METHOD'], $uri);
