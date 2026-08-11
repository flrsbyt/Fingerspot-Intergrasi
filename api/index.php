<?php

// Vercel PHP Runtime entry point
// This file is the entry point for Vercel's PHP runtime

// Require the Composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Create the Laravel application
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Set the application environment
$app->loadEnvironmentFrom('.env');

// Create the kernel
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Handle the request
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Send the response
$response->send();

// Terminate the application
$kernel->terminate($request, $response);