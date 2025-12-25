<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EventController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event:slug}', [HomeController::class, 'show'])->name('events.show');

use App\Http\Controllers\ScheduleController;
Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');

use App\Http\Controllers\ContactController;
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

use App\Http\Controllers\CheckoutController;
Route::get('/checkout/{event:slug}', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout/{event:slug}', [CheckoutController::class, 'store'])->name('checkout.store');

use App\Http\Controllers\PaymentController;
Route::get('/payment/{transaction:code}', [PaymentController::class, 'show'])->name('payment.show');
Route::post('/payment/{transaction:code}/complete', [PaymentController::class, 'updateStatus'])->name('payment.update');
Route::get('/payment/{transaction:code}/success', [PaymentController::class, 'success'])->name('payment.success');

Route::view('dashboard', 'admin.dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

use App\Http\Controllers\Auth\UserLoginController;

Route::middleware('guest')->group(function () {
    Route::get('login', [UserLoginController::class, 'create'])->name('login');
    Route::post('login', [UserLoginController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [UserLoginController::class, 'destroy'])->name('logout');
});
