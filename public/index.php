<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (php_sapi_name() !== 'cli') {
    $lockFile = __DIR__ . '/../storage/installed.lock';
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    $isInstaller = str_contains($uri, '/install.php') || str_contains($uri, '/install-assets/');

    if (!file_exists($lockFile) && !$isInstaller) {
        header('Location: /install.php');
        exit;
    }
}

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
