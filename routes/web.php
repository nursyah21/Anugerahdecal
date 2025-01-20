<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CartController;

Route::get('/', [CategoryController::class, 'index'])->name('welcome');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'userMiddleware'])->group(function () {
    Route::get('dashboard', [UserController::class, 'index'])->name('dashboard');

    // Rute untuk Pesanan
    Route::get('orders', [UserController::class, 'index'])->name('orders.index');

    // Rute untuk Alamat
    Route::get('address', [UserController::class, 'index'])->name('address.index');

    // Rute untuk Detail Akun
    Route::get('account/details', [UserController::class, 'details'])->name('account.details');
});

Route::middleware(['auth', 'adminMiddleware'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    Route::get('/admin/kategori', [AdminController::class, 'kategori'])->name('admin.kategori');
    Route::get('/admin/stiker', [AdminController::class, 'stiker'])->name('admin.stiker');
    
    
    // Rute untuk menyimpan kategori
    Route::post('/admin/categories', [AdminController::class, 'storeCategory'])->name('admin.storeCategory');

    // Rute untuk menyimpan produk
    Route::post('/admin/products', [AdminController::class, 'storeProduct'])->name('admin.storeProduct');

    // Rute untuk menyimpan material
    Route::post('/admin/materials', [AdminController::class, 'storeMaterial'])->name('admin.storeMaterial');

    // Rute untuk menyimpan lamination
    Route::post('/admin/laminations', [AdminController::class, 'storeLamination'])->name('admin.storeLamination');

    Route::get('/admin/product/{id}/edit', [AdminController::class, 'editProduct'])->name('admin.editProduct');

    // Rute Delete
    Route::delete('/admin/categories/{id}', [AdminController::class, 'deleteCategory'])->name('admin.deleteCategory');
    Route::delete('/admin/products/{id}', [AdminController::class, 'deleteProduct'])->name('admin.deleteProduct');
    Route::delete('/admin/materials/{id}', [AdminController::class, 'deleteMaterial'])->name('admin.deleteMaterial');
    Route::delete('/admin/laminations/{id}', [AdminController::class, 'deleteLamination'])->name('admin.deleteLamination');
});

Route::middleware('auth')->group(function () {
    // Menambahkan produk ke keranjang
    Route::post('/cart/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
    // Melihat isi keranjang
    Route::get('/cart', [CartController::class, 'showCart'])->name('cart.index');
    // Memperbarui jumlah produk dalam keranjang
    Route::post('/cart/update/{cartItemId}', [CartController::class, 'updateCart'])->name('cart.update');
    // Menghapus item dari keranjang
    Route::delete('/cart/remove/{cartItemId}', [CartController::class, 'removeCartItem'])->name('cart.remove');
    Route::get('/cart/count', [CartController::class, 'getCount']);
});

Route::get('/category/{id}', [CategoryController::class, 'show']);
Route::get('/product/{id}', [ProductController::class, 'show']);


require __DIR__ . '/auth.php';
