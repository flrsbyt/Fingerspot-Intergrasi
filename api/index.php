<?php

// Load Composer autoloader
require_once __DIR__.'/../vendor/autoload.php';

// Load Laravel application
$app = require_once __DIR__.'/../bootstrap/app.php';

// Create kernel and handle request
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);