<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EventController;
use App\Http\Controllers\PageController; // Added this line
use App\Http\Controllers\SiteAccessController;

Route::get('/site-access', [SiteAccessController::class, 'index'])->name('site-access.index');
Route::post('/site-access/unlock', [SiteAccessController::class, 'unlock'])->name('site-access.unlock');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [HomeController::class, 'show'])->name('events.show');

// Static Pages
Route::get('/terms', [PageController::class, 'terms'])->name('pages.terms');
Route::get('/privacy', [PageController::class, 'privacy'])->name('pages.privacy');
Route::get('/cookie-policy', [PageController::class, 'cookie'])->name('pages.cookie');
Route::get('/services', [PageController::class, 'services'])->name('pages.services');

use App\Http\Controllers\ScheduleController;
Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');

use App\Http\Controllers\ContactController;
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

use App\Http\Controllers\CheckoutController;
Route::get('/checkout/{event}', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout/{event}', [CheckoutController::class, 'store'])->name('checkout.store');

use App\Http\Controllers\PaymentController;
Route::get('/payment/{transaction}', [PaymentController::class, 'show'])->name('payment.show');
Route::post('/payment/{transaction}/complete', [PaymentController::class, 'updateStatus'])->name('payment.update');
Route::get('/payment/{transaction}/success', [PaymentController::class, 'success'])->name('payment.success');

Route::view('dashboard', 'admin.dashboard')
    ->middleware(['auth', 'verified', 'admin'])
    ->name('dashboard');

use App\Http\Controllers\Auth\UserLoginController;

Route::middleware('guest')->group(function () {
    Route::get('login', [UserLoginController::class, 'create'])->name('login');
    Route::post('login', [UserLoginController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [UserLoginController::class, 'destroy'])->name('logout');

    // Scanner Routes
    Route::prefix('scanner')->name('scanner.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Scanner\ScanController::class, 'index'])->name('index');
        Route::post('/verify', [\App\Http\Controllers\Scanner\ScanController::class, 'verify'])->name('verify');
    });
});
