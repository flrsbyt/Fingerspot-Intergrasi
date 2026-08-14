<?php

use App\Http\Controllers\CommandPanelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AttlogController;
use App\Http\Controllers\UserinfoController;
use App\Http\Controllers\PinController;
use App\Http\Controllers\ApiRequestController;
use App\Http\Controllers\WebhookLogController;
use App\Http\Controllers\CommandLogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChangelogController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\RealtimeController;

// ========== ADMIN ROUTES (Harus Login) ==========
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Data Tables
    Route::resource('attlogs', AttlogController::class);
    Route::resource('userinfos', UserinfoController::class);
    Route::resource('pins', PinController::class);
    Route::post('/pins/test-connection', [PinController::class, 'testConnection'])->name('pins.test-connection');
    Route::resource('api-requests', ApiRequestController::class);
    Route::resource('webhook-logs', WebhookLogController::class);
    Route::resource('command-logs', CommandLogController::class);

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/add-device', [SettingsController::class, 'addDevice'])->name('settings.add-device');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'updateCompany'])->name('profile.update');

    // Changelog
    Route::get('/changelog', [ChangelogController::class, 'index'])->name('changelog.index');

    // Command Panel
    Route::post('/command/get-attlog', [CommandPanelController::class, 'getAttlog'])->name('command.get-attlog');
    Route::post('/command/get-userinfo', [CommandPanelController::class, 'getUserinfo'])->name('command.get-userinfo');
    Route::post('/command/set-userinfo', [CommandPanelController::class, 'setUserinfo'])->name('command.set-userinfo');
    Route::post('/command/delete-userinfo', [CommandPanelController::class, 'deleteUserinfo'])->name('command.delete-userinfo');
    Route::post('/command/get-all-pin', [CommandPanelController::class, 'getAllPin'])->name('command.get-all-pin');
    Route::post('/command/set-time', [CommandPanelController::class, 'setTime'])->name('command.set-time');
    Route::post('/command/register-online', [CommandPanelController::class, 'registerOnline'])->name('command.register-online');
    Route::post('/command/restart-mesin', [CommandPanelController::class, 'restartMesin'])->name('command.restart-mesin');
});

// ========== WEBHOOK ROUTE (Public) ==========
Route::post('/api/webhook/fingerspot', [WebhookController::class, 'handle'])->name('webhook.fingerspot');

// ========== REALTIME API ROUTES (Auth) ==========
Route::middleware(['auth'])->group(function () {
    Route::get('/api/realtime/attlogs', [RealtimeController::class, 'latestAttlogs'])->name('realtime.attlogs');
    Route::get('/api/realtime/device-status', [RealtimeController::class, 'deviceStatus'])->name('realtime.device-status');
    Route::get('/api/realtime/system-stats', [RealtimeController::class, 'systemStats'])->name('realtime.system-stats');
});

// ========== HOME ==========
Route::get('/', function () {
    return view('landing');
})->name('home');

// BREEZE AUTH ROUTES
require __DIR__.'/auth.php';