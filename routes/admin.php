<?php

use App\Http\Controllers\Admin\Auth\AdminLoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ContactController;

Route::middleware('guest')->group(function () {
    Route::get('login', [AdminLoginController::class, 'create'])->name('login');
    Route::post('login', [AdminLoginController::class, 'store'])->name('login.store');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('logout', [AdminLoginController::class, 'destroy'])->name('logout');
    Route::view('dashboard', 'admin.dashboard')->name('dashboard');

    Route::get('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile');
    Route::put('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');

    // Contact Messages
    Route::resource('contacts', ContactController::class)->only(['index', 'show', 'destroy']);

    Route::resource('events', \App\Http\Controllers\Admin\EventController::class);
    Route::post('events/{event}/assign-scanner', [\App\Http\Controllers\Admin\EventController::class, 'assignScanner'])->name('events.assign-scanner');
    Route::delete('events/{event}/unassign-scanner/{scanner}', [\App\Http\Controllers\Admin\EventController::class, 'unassignScanner'])->name('events.unassign-scanner');
    Route::resource('events.tickets', \App\Http\Controllers\Admin\TicketController::class)->shallow();

    // Report
    Route::get('reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');

    // Scanners
    // Scanners
    Route::resource('scanners', \App\Http\Controllers\Admin\ScannerController::class)->except(['show']);
});
