<?php

use Illuminate\Support\Facades\Route;

// Home - 重導向到產品頁面
use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'index'])->name('home');


// Auth
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products/{id}/add-to-cart', [ProductController::class, 'addToCart'])->name('products.addToCart');

// Cart
Route::get('/cart', [ProductController::class, 'showCart'])->name('cart.index');
Route::post('/cart/update', [ProductController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/{id}', [ProductController::class, 'removeFromCart'])->name('cart.remove');
Route::delete('/cart', [ProductController::class, 'clearCart'])->name('cart.clear');


// User Apps (用戶端應用程式瀏覽)
use App\Http\Controllers\UserAppsController;

Route::prefix('user')->middleware('user.auth')->group(function () {
    Route::get('/', [UserAppsController::class, 'index'])->name('user.index');
    Route::get('/apps', [UserAppsController::class, 'index'])->name('user.apps.index');
    Route::get('/apps/{id}', [UserAppsController::class, 'show'])->name('user.apps.show');
    Route::get('/apps/{id}/integrations', [UserAppsController::class, 'integrations'])->name('user.apps.integrations');
});


// Admin Management
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\PermissionController;

Route::prefix('admin')->group(function () {
    // 登入相關（不需要權限）
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

    // 管理員管理（需要登入和對應權限）
    Route::middleware(['admin.permission'])->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');

        // 編輯和更新自己的資料（所有管理員都可以）
        Route::get('/{account}/edit', [AdminController::class, 'edit'])->name('admin.edit');
        Route::put('/{account}', [AdminController::class, 'update'])->name('admin.update');

        // 帳號管理權限 (s01) - 只有有權限的管理員才能執行
        Route::middleware(['admin.permission:s01'])->group(function () {
            Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
            Route::post('/', [AdminController::class, 'store'])->name('admin.store');
            Route::delete('/{account}', [AdminController::class, 'destroy'])->name('admin.destroy');
        });

        // 產品管理權限 (s02)
        Route::middleware(['admin.permission:s02'])->group(function () {
            Route::resource('products', ProductController::class);
        });

        // 產品資料維護權限 (s03)
        Route::middleware(['admin.permission:s03'])->group(function () {
            Route::get('/products/maintain', [AdminProductController::class, 'maintain'])->name('admin.products.maintain');
        });

        // 權限管理權限 (s00)
        Route::middleware(['admin.permission:s00'])->prefix('permissions')->group(function () {
            Route::get('/', [PermissionController::class, 'index'])->name('admin.permissions.index');
            Route::get('/{account}/edit', [PermissionController::class, 'edit'])->name('admin.permissions.edit');
            Route::put('/{account}', [PermissionController::class, 'update'])->name('admin.permissions.update');
            Route::post('/assign', [PermissionController::class, 'assign'])->name('admin.permissions.assign');
            Route::post('/revoke', [PermissionController::class, 'revoke'])->name('admin.permissions.revoke');
            Route::post('/batch-update', [PermissionController::class, 'batchUpdate'])->name('admin.permissions.batchUpdate');
        });
    });
});