<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Reseller\DashboardController;

Route::middleware(['auth', 'reseller'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
