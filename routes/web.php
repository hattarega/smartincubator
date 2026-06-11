<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Guest

Route::middleware(['guest', 'nocache'])->group(function () {
    Route::get('/', function () {
        return view('landing');
    });

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});




Route::middleware(['auth', 'nocache'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::put('/cage/update-date/{id}', [DashboardController::class, 'updateDate'])->name('cage.updateDate');

    Route::put('/cage/update-egg/{id}', [DashboardController::class, 'updateEgg'])->name('cage.updateEgg');

    Route::put('/setting/suhu', [DashboardController::class, 'updateTemperature'])
        ->name('setting.updateTemperature');

    Route::put('/setting/kelembapan', [DashboardController::class, 'updateHumidity'])
        ->name('setting.updateHumidity');

    Route::get('/dashboard/sensor', [DashboardController::class, 'showSensor'])
        ->name('setting.showSensor');

    Route::post('/actuator/toggle', [DashboardController::class, 'toggle']);
    Route::post('/actuator/auto', [DashboardController::class, 'setAuto']);
    Route::get('/chart-data', [DashboardController::class, 'chartData']);

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/logout', [AuthController::class, 'logout']);
});
