<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AdminAuthController,
    AdminController,
    DashboardController,
    OrderController,
    ProductsController,
    StockController,
    TransactionController,
    UserController,
    CategoryController,
    AuthController,
    HomepageController,
    KeranjangController,
    CheckoutController,
};

/*
|--------------------------------------------------------------------------
| ROUTE ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    // Auth admin
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // CRUD admin area
    Route::resource('/admin', AdminController::class);
    Route::resource('/products', ProductsController::class);
    Route::resource('/stok', StockController::class);
    Route::resource('/kategori', CategoryController::class)->names('categories');
    Route::resource('/transaksi', TransactionController::class);

    // Pesanan & Transaksi
    Route::get('/pesanan', [OrderController::class, 'adminIndex']nShow'])->name('pesanan.show');
    Route::put('/pesanan/{id}/status', [OrderController::class)->name('pesanan.index');
    Route::get('/pesanan/{id}', [OrderController::class, 'admi, 'updateStatus'])->name('pesanan.updateStatus');

    Route::get('/transaksi', [TransactionController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{id}', [TransactionController::class, 'show'])->name('transaksi.show');
});

/*
|--------------------------------------------------------------------------
| ROUTE PELANGGAN (USER)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomepageController::class, 'index'])->name('pelanggan.home');

// Auth pelanggan
Route::get('/register', [AuthController::class, 'showRegister'])->name('pelanggan.register');
Route::post('/register', [AuthController::class, 'register'])->name('pelanggan.register.submit');
Route::get('/login', [AuthController::class, 'showLogin'])->name('pelanggan.login');
Route::post('/login', [AuthController::class, 'login'])->name('pelanggan.login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('pelanggan.logout');

// Produk & Keranjang
Route::get('/produk', [ProductsController::class, 'index'])->name('produk.index');
Route::get('/produk/{id}', [ProductsController::class, 'show'])->name('produk.show');

// Hanya untuk pelanggan login
Route::middleware(['auth:pelanggan'])->group(function () {
    Route::get('/cart', [KeranjangController::class, 'index'])->name('cart.index');
    Route::post('/cart', [KeranjangController::class, 'store'])->name('cart.store');
    Route::delete('/cart/{id}', [KeranjangController::class, 'destroy'])->name('cart.destroy');

    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/tambah/{product_id}', [KeranjangController::class, 'store'])->name('keranjang.store');
     Route::delete('/keranjang/hapus/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.hapus');
     Route::put('/keranjang/update/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');


    // // Checkout & Pesanan (pakai OrderController)
    // Route::get('/checkout', [OrderController::class, 'create'])->name('checkout.index');
    // Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index')->middleware('auth');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process')->middleware('auth');

    // Riwayat pesanan pelanggan
    Route::get('/pesanan-saya', [OrderController::class, 'userOrders'])->name('pelanggan.pesanan');
    Route::get('/riwayat-belanja', [OrderController::class, 'userOrders'])->name('riwayat-belanja');
    Route::get('/checkout/struk/{orderId}', [OrderController::class, 'userShow'])->name('checkout.struk');

});

