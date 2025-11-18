<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/catalog', [BookController::class, 'index'])->name('catalog');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'reset'])->name('password.update');

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Books management
    Route::resource('books', BookController::class);
    
    // Loans management
    Route::resource('loans', LoanController::class);
    Route::post('/loans/{loan}/return', [LoanController::class, 'returnBook'])->name('loans.return');
    
    // Super Admin routes
    Route::middleware(['can:super_admin'])->group(function () {
        Route::get('/super-admin/settings', [SuperAdminController::class, 'settings'])->name('super-admin.settings');
        Route::post('/super-admin/settings', [SuperAdminController::class, 'updateSettings']);
    });

    // Loans management
    Route::resource('loans', LoanController::class);
    Route::post('/loans/{loan}/return', [LoanController::class, 'returnBook'])->name('loans.return');
});