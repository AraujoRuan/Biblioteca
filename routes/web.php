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
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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
});