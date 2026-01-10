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
    MidtransCallbackController,
    SemuaProdukController
};

/*
|--------------------------------------------------------------------------
| ROUTE ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {

    // ================= AUTH ADMIN =================
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // ================= DASHBOARD =================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // ================= CRUD =================
    Route::resource('/admin', AdminController::class);
    Route::resource('/products', ProductsController::class);
    Route::resource('/stok', StockController::class);
    Route::resource('/kategori', CategoryController::class)->names('categories');
    Route::resource('/transaksi', TransactionController::class);

    // ================= PESANAN =================
Route::put('/pesanan/{id}/status', [OrderController::class, 'updateStatus'])->name('pesanan.updateStatus');
    Route::get('/pesanan', [OrderController::class, 'adminIndex'])->name('pesanan.index');
    Route::get('/pesanan/{id}', [OrderController::class, 'adminShow'])->name('pesanan.show');


    // ================= TRANSAKSI =================
    Route::get('/transaksi', [TransactionController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{id}', [TransactionController::class, 'show'])->name('transaksi.show');
});


/*
|--------------------------------------------------------------------------
| ROUTE PELANGGAN (USER)
|--------------------------------------------------------------------------
*/

// ================= HOME =================
Route::get('/', [HomepageController::class, 'index'])->name('pelanggan.home');

// ================= AUTH PELANGGAN =================
Route::get('/register', [AuthController::class, 'showRegister'])->name('pelanggan.register');
Route::post('/register', [AuthController::class, 'register'])->name('pelanggan.register.submit');

Route::get('/login', [AuthController::class, 'showLogin'])->name('pelanggan.login');
Route::post('/login', [AuthController::class, 'login'])->name('pelanggan.login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('pelanggan.logout');

// ================= PRODUK =================
Route::get('/produk', [ProductsController::class, 'index'])->name('produk.index');
Route::get('/produk/{id}', [ProductsController::class, 'show'])->name('produk.show');

// ================= PELANGGAN LOGIN =================
Route::middleware(['auth:pelanggan'])->group(function () {

    // ================= KERANJANG =================
    Route::get('/cart', [KeranjangController::class, 'index'])->name('cart.index');
    Route::post('/cart', [KeranjangController::class, 'store'])->name('cart.store');
    Route::delete('/cart/{id}', [KeranjangController::class, 'destroy'])->name('cart.destroy');

    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/tambah/{product_id}', [KeranjangController::class, 'store'])->name('keranjang.store');
    Route::delete('/keranjang/hapus/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.hapus');
    Route::put('/keranjang/update/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');

    // ================= CHECKOUT =================
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/midtrans/callback', [CheckoutController::class, 'callback']);

    // ================= PESANAN PELANGGAN =================
    Route::get('/pesanan-saya', [OrderController::class, 'userOrders'])->name('pelanggan.pesanan');
    Route::get('/riwayat-belanja', [OrderController::class, 'userOrders'])->name('riwayat-belanja');
    Route::get('/checkout/struk/pdf/{id}', [OrderController::class, 'cetakStruk'])->name('checkout.struk.pdf');
    Route::get('/detail-belanja{orderId}', [OrderController::class, 'userShow'])->name('detail-belanja');

    Route::get('/semua-produk', [SemuaProdukController::class, 'index'])->name('semua-produk.index');

});
