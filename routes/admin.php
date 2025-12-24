<?php

use App\Http\Controllers\Admin\Auth\AdminLoginController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [AdminLoginController::class, 'create'])->name('login');
    Route::post('login', [AdminLoginController::class, 'store'])->name('login.store');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('logout', [AdminLoginController::class, 'destroy'])->name('logout');
    Route::view('dashboard', 'admin.dashboard')->name('dashboard');

    Route::get('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile');
    Route::put('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
    Route::get('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings');
    Route::resource('events', \App\Http\Controllers\Admin\EventController::class);
});
