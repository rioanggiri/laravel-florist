<?php

use App\Http\Controllers\Admin\AccountController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardTransactionController;
use App\Http\Controllers\DashboardSettingController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProductGalleryController as AdminProductGalleryController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\DashboardReviewController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
Route::get('/categories/{id}', [CategoryController::class, 'detail'])->name('categories-detail');
Route::get('/details/{id}', [DetailController::class, 'index'])->name('detail');
Route::post('/details/{id}', [DetailController::class, 'add'])->name('detail-add');
Route::get('/guides', [HomeController::class, 'guides'])->name('guides');

// Authenticated user routes
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::delete('/cart/{id}', [CartController::class, 'delete'])->name('cart-delete');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout');
    Route::get('/success', [CartController::class, 'success'])->name('success');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/dashboard/transactions', DashboardTransactionController::class)->only([
        'index', 'show'
    ]);
    Route::get('/dashboard/invoice/{transaction}', [DashboardTransactionController::class, 'invoice'])->name('transactions.invoice');
    Route::resource('/dashboard/reviews', DashboardReviewController::class)->only([
        'index', 'store', 'show', 'edit', 'update', 'delete'
    ]);
    Route::get('/dashboard/account', [DashboardSettingController::class, 'account'])->name('dashboard-account');
    Route::post('/dashboard/account/{redirect}', [DashboardSettingController::class, 'update'])->name('dashboard-account-redirect');
});

// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin-dashboard');
    Route::resource('category', AdminCategoryController::class);
    Route::resource('user', AdminUserController::class);
    Route::resource('product', AdminProductController::class);
    Route::resource('product-gallery', AdminProductGalleryController::class);
    Route::resource('transaction', TransactionController::class);
    Route::get('/invoice/{transaction}', [TransactionController::class, 'invoice'])->name('transaction.invoice');
    Route::get('/review', [ReviewController::class, 'index'])->name('admin-review');
    Route::delete('/review/{id}', [ReviewController::class, 'delete'])->name('admin-delete-review');
    Route::get('/account', [AccountController::class, 'account'])->name('admin-account');
    Route::post('/account/{redirect}', [AccountController::class, 'update'])->name('admin-account-redirect');
    Route::get('/laporan', [ReportController::class, 'cetakAll'])->name('laporan.all');
    Route::post('/laporan/harian', [ReportController::class, 'cetakHarian'])->name('laporan.harian');
    Route::post('/laporan/mingguan', [ReportController::class, 'cetakMingguan'])->name('laporan.mingguan');
    Route::post('/laporan/bulanan', [ReportController::class, 'cetakBulanan'])->name('laporan.bulanan');
    Route::get('/laporan/akandiproses', [ReportController::class, 'cetakProses'])->name('laporan.proses');
    //Route::get('/laporan/{type}', [ReportController::class, 'cetakLaporan'])->name('transaction.laporan.type');
});

// Authentication routes
Auth::routes();
Route::get('/register/success', [RegisterController::class, 'success'])->name('register-success');
