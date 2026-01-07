<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\PemesananController;

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

    // Rental Routes
    Route::get('/rental/{carId}', [RentalController::class, 'create'])->name('rental.create');
    Route::post('/rental', [RentalController::class, 'store'])->name('rental.store');
    Route::get('/rental/{pemesananId}/detail', [RentalController::class, 'show'])->name('rental.show');
    Route::get('/rental/{pemesananId}/edit', [RentalController::class, 'edit'])->name('rental.edit');
    Route::post('/rental/{pemesananId}', [RentalController::class, 'update'])->name('rental.update');
    Route::post('/rental/{pemesananId}/cancel', [RentalController::class, 'cancel'])->name('rental.cancel');

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
    Route::get('/mobil', [MobilController::class, 'index'])->name('mobil.index');
    Route::post('/mobil', [MobilController::class, 'store'])->name('mobil.store');
    Route::put('/mobil/{mobil}', [MobilController::class, 'update'])->name('mobil.update');
    Route::delete('/mobil/{mobil}', [MobilController::class, 'destroy'])->name('mobil.destroy');


    Route::get('/pemesanan', [PemesananController::class, 'index'])->name('pemesanan.index');
    Route::post('/pemesanan', [PemesananController::class, 'store'])->name('pemesanan.store');
    Route::get('/pemesanan/{pemesanan}', [PemesananController::class, 'show'])->name('pemesanan.show');
    Route::put('/pemesanan/{pemesanan}', [PemesananController::class, 'update'])->name('pemesanan.update');
    Route::delete('/pemesanan/{pemesanan}', [PemesananController::class, 'destroy'])->name('pemesanan.destroy');

    
    // Admin - Kelola Pembayaran
    Route::get('/admin/pembayaran', [AdminController::class, 'payments'])->name('admin.payments');
    
    // Admin - Kelola Pengguna
    Route::get('/admin/pengguna', [AdminController::class, 'users'])->name('admin.users');
    
});

