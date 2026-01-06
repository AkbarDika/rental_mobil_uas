<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CatalogController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (Custom)
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'formLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'formRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);







Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Catalog Routes (Public)
|--------------------------------------------------------------------------
*/

Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/{id}', [CatalogController::class, 'show'])->name('catalog.show');
Route::get('/catalog/search', [CatalogController::class, 'search'])->name('catalog.search');
Route::get('/catalog/category/{kategoriId}', [CatalogController::class, 'filterByCategory'])->name('catalog.filter-category');
Route::get('/catalog/filter-price', [CatalogController::class, 'filterByPrice'])->name('catalog.filter-price');

/*
|--------------------------------------------------------------------------
| Protected Routes - Customer
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

});

/*
|--------------------------------------------------------------------------
| Protected Routes - Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {
    
    // Admin Dashboard
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard.alt');
    
    // Admin - Kelola Mobil
    Route::get('/admin/mobil', [AdminController::class, 'cars'])->name('admin.cars');
    
    // Admin - Kelola Pemesanan
    Route::get('/admin/pemesanan', [AdminController::class, 'orders'])->name('admin.orders');
    
    // Admin - Kelola Pembayaran
    Route::get('/admin/pembayaran', [AdminController::class, 'payments'])->name('admin.payments');
    
    // Admin - Kelola Pengguna
    Route::get('/admin/pengguna', [AdminController::class, 'users'])->name('admin.users');
    
});

