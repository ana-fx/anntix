<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Organizer\DashboardController;
use App\Http\Controllers\Organizer\EventController;
use App\Http\Controllers\Organizer\TicketController;
use App\Http\Controllers\Organizer\ReportController;
use App\Http\Controllers\Organizer\ProfileController;
use App\Http\Controllers\Organizer\ResellerController;
use App\Http\Controllers\Organizer\ResellerManagementController;

Route::middleware(['auth', 'organizer'])->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Events & Management
    Route::get('events/tickets', [TicketController::class, 'allTickets'])->name('tickets.index');
    Route::resource('events', EventController::class)->only(['index', 'show', 'edit', 'update']);

    // Tickets & Event Features
    Route::get('withdrawals', [\App\Http\Controllers\Organizer\WithdrawalController::class, 'globalIndex'])->name('withdrawals.index');
    Route::resource('events.tickets', TicketController::class);
    Route::resource('events.withdrawals', \App\Http\Controllers\Organizer\WithdrawalController::class)->only(['index', 'store']);
    Route::get('events/{event}/tickets-report', [TicketController::class, 'index'])->name('events.tickets-report.index');
    Route::get('events/{event}/scanners', [EventController::class, 'scanners'])->name('events.scanners.index');
    Route::get('events/{event}/resellers', [EventController::class, 'resellers'])->name('events.resellers.index');

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('transactions', [ReportController::class, 'transactions'])->name('transactions');
        Route::get('transactions/{transaction}', [ReportController::class, 'showTransaction'])->name('show');
        Route::get('scanner', [ReportController::class, 'scanner'])->name('scanner');
    });

    // Resellers
    Route::resource('resellers', ResellerController::class);
    Route::post('resellers/{reseller}/toggle-active', [ResellerController::class, 'toggleActive'])->name('resellers.toggle-active');
    Route::get('reseller-management', [ResellerManagementController::class, 'index'])->name('reseller-management.index');

    // Profile
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
});
