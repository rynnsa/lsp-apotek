<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('fe.master');
// });


// Frontend ------------------------Frontend--------------------------Frontend----------------------------Frontend------------------------------Frontend----------------

Route::get('/register', [App\Http\Controllers\PelangganController::class, 'register'])->name('register');
Route::post('/register', [App\Http\Controllers\PelangganController::class, 'store'])->name('register.store');
Route::get('/login', [App\Http\Controllers\PelangganController::class, 'login'])->name('login');
Route::post('/login', [App\Http\Controllers\PelangganController::class, 'authenticate'])->name('authenticate');

Route::get('/profile-pelanggan', [App\Http\Controllers\ProfilePelangganController::class, 'index'])->name('profile');
Route::post('/profile-pelanggan', [App\Http\Controllers\ProfilePelangganController::class, 'update'])->name('profile.update');


Route::post('/logout', [App\Http\Controllers\PelangganController::class, 'logout'])->name('logout');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/shop', [App\Http\Controllers\ShopController::class, 'index'])->name('shop');
Route::get('/shop-detail/{id}', [App\Http\Controllers\ShopController::class, 'shopdetail'])->name('shop-detail');
Route::post('/filter-products', [App\Http\Controllers\ShopController::class, 'filter'])->name('products.filter');

Route::resource('/contact', App\Http\Controllers\ContactController::class);

Route::middleware(['auth:pelanggan'])->group(function () {
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');    
    Route::post('/cart/update-quantity', [App\Http\Controllers\CartController::class, 'updateQuantity'])->name('cart.update-quantity');
    Route::post('/cart/remove-item', [App\Http\Controllers\CartController::class, 'removeItem'])->name('cart.remove-item');
    Route::get('/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [App\Http\Controllers\CartController::class, 'storeCheckout'])->name('checkout.store');
    Route::get('/checkout/success', [App\Http\Controllers\CartController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/failed', [App\Http\Controllers\CartController::class, 'failed'])->name('checkout.failed');
    Route::post('/cart/process-checkout', [App\Http\Controllers\CartController::class, 'processCheckout'])->name('cart.process-checkout');
    Route::post('/checkout/create', [App\Http\Controllers\CartController::class, 'createOrder'])->name('order.create');
    Route::post('/checkout/process', [App\Http\Controllers\CartController::class, 'processOrder'])->name('order.process');
    Route::get('/status-pemesanan', [App\Http\Controllers\PenjualanController::class, 'status'])->name('status-pemesanan');
    Route::get('/pesanan/{id}/detail', [App\Http\Controllers\CartController::class, 'detail'])->name('pesanan.detail');
}); 

// Raja Ongkir Routes (outside auth middleware for AJAX calls)
Route::get('/rajaongkir/cities/{provinceId}', [App\Http\Controllers\RajaOngkirController::class, 'getCities'])->name('rajaongkir.cities');
Route::get('/rajaongkir/districts/{cityId}', [App\Http\Controllers\RajaOngkirController::class, 'getDistricts'])->name('rajaongkir.districts');
Route::post('/rajaongkir/cost', [App\Http\Controllers\RajaOngkirController::class, 'checkOngkir'])->name('rajaongkir.cost');
Route::post('/rajaongkir/cost', [App\Http\Controllers\RajaOngkirController::class, 'checkOngkir'])->name('rajaongkir.cost');

Route::get('/check-payment-status/{orderId}', [App\Http\Controllers\MidtransController::class, 'checkStatus']);
Route::post('/midtrans/callback', [App\Http\Controllers\MidtransController::class, 'callback']);


Route::resource('/testimonial', App\Http\Controllers\TestimonialController::class);


// Backend -----------------------Backend----------------------------Backend--------------------------Backend---------------------------Backend-------------

Route::get('/login-dashmin', [App\Http\Controllers\LoginController::class, 'index'])->name('login-dashmin');
Route::post('/login-dashmin', [App\Http\Controllers\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

// Backend Routes
// Route::middleware(['auth'])->group(function () {
    Route::get('/landing', [App\Http\Controllers\AdminController::class, 'landing']);

    // Route::middleware(['jabatan:admin,pemilik'])->group(function () {
        Route::get('/kelola-pengguna', [App\Http\Controllers\KelolaPenggunaController::class, 'index'])->name('kelola-pengguna');
        Route::post('/kelola-pengguna', [App\Http\Controllers\KelolaPenggunaController::class, 'store'])->name('kelola-pengguna.store');
        Route::patch('/kelola-pengguna/{id}', [App\Http\Controllers\KelolaPenggunaController::class, 'update'])->name('kelola-pengguna.update');
        Route::delete('/kelola-pengguna/{id}', [App\Http\Controllers\KelolaPenggunaController::class, 'destroy'])->name('kelola-pengguna.destroy');
        Route::get('/data-pelanggan', [App\Http\Controllers\PelangganController::class, 'datapelanggan']);
    // });

    // Route::middleware(['jabatan:apoteker'])->group(function () {
        Route::get('/obat', [App\Http\Controllers\DaftarObatController::class, 'index'])->name('obat');
        Route::post('/obat', [App\Http\Controllers\DaftarObatController::class, 'obat'])->name('obat.store');
        Route::patch('/obat/{id}', [App\Http\Controllers\DaftarObatController::class, 'updateObat'])->name('obat.update');
        Route::delete('/obat/{id}', [App\Http\Controllers\DaftarObatController::class, 'destroyObat'])->name('obat.destroy');
        Route::patch('/obat/update-harga/{id}', [App\Http\Controllers\DaftarObatController::class, 'updateHargaJual'])->name('obat.update-harga');
        
        Route::get('/jenis-obat', [App\Http\Controllers\DaftarObatController::class, 'jenisobat'])->name('jenis-obat');
        Route::post('/jenis-obat', [App\Http\Controllers\DaftarObatController::class, 'jenis'])->name('jenis-obat.store');
        Route::patch('/jenis-obat/{id}', [App\Http\Controllers\DaftarObatController::class, 'updateJenis'])->name('jenis-obat.update');
        Route::delete('/jenis-obat/{id}', [App\Http\Controllers\DaftarObatController::class, 'destroyJenis'])->name('jenis-obat.destroy');

        Route::get('/distributor', [App\Http\Controllers\DistributorController::class, 'index'])->name('distributor');
        Route::post('/distributor', [App\Http\Controllers\DistributorController::class, 'store'])->name('distributor.store');
        Route::patch('/distributor/{id}', [App\Http\Controllers\DistributorController::class, 'updateDistributor'])->name('distributor.update');
        Route::delete('/distributor/{id}', [App\Http\Controllers\DistributorController::class, 'destroyDistributor'])->name('distributor.destroy');

        Route::get('/pembelian', [App\Http\Controllers\DistributorController::class, 'pembelian'])->name('pembelian');
        Route::get('/pembelian/create', [App\Http\Controllers\DistributorController::class, 'create'])->name('pembelian.create');
        Route::post('/pembelian', [App\Http\Controllers\DistributorController::class, 'storePembelian'])->name('pembelian.store');
        Route::get('/pembelian/edit/{id}', [App\Http\Controllers\DistributorController::class, 'edit'])->name('pembelian.edit');
        Route::patch('/pembelian/{id}', [App\Http\Controllers\DistributorController::class, 'updatePembelian'])->name('pembelian.update');
        Route::delete('/pembelian/{id}', [App\Http\Controllers\DistributorController::class, 'destroyPembelian'])->name('pembelian.destroy');

        Route::get('/detail-pembelian', [App\Http\Controllers\DistributorController::class, 'detail'])->name('detailpembelian');
        Route::post('/detail-pembelian', [App\Http\Controllers\DistributorController::class, 'storeDetail'])->name('detailpembelian.store');
        Route::patch('/detail-pembelian/{id}', [App\Http\Controllers\DistributorController::class, 'updateDetail'])->name('detailpembelian.update');
        Route::delete('/detail-pembelian/{id}', [App\Http\Controllers\DistributorController::class, 'destroyDetail'])->name('detailpembelian.destroy');

        Route::get('/metode-bayar', [App\Http\Controllers\MetodeBayarController::class, 'index'])->name('metodebayar');
        Route::post('/metode-bayar', [App\Http\Controllers\MetodeBayarController::class, 'store'])->name('metodebayar.store');
        Route::patch('/metode-bayar{id}', [App\Http\Controllers\MetodeBayarController::class, 'update'])->name('metodebayar.update');
        Route::delete('/metode-bayar{id}', [App\Http\Controllers\MetodeBayarController::class, 'destroy'])->name('metodebayar.destroy');

        Route::get('/jenis-pengiriman', [App\Http\Controllers\PengirimanController::class, 'jenis'])->name('jenis-pengiriman');
        Route::post('/jenis-pengiriman', [App\Http\Controllers\PengirimanController::class, 'storeJenis'])->name('jenispengiriman.store');
        Route::patch('/jenis-pengiriman/{id}', [App\Http\Controllers\PengirimanController::class, 'updateJenis'])->name('jenispengiriman.update');
        Route::delete('/jenis-pengiriman/{id}', [App\Http\Controllers\PengirimanController::class, 'destroyJenis'])->name('jenispengiriman.destroy');

        Route::get('/pengiriman', [App\Http\Controllers\PengirimanController::class, 'index'])->name('pengiriman');
        Route::post('/pengiriman', [App\Http\Controllers\PengirimanController::class, 'store'])->name('pengiriman.store');
        Route::patch('/pengiriman/{id}', [App\Http\Controllers\PengirimanController::class, 'update'])->name('pengiriman.update');
        Route::delete('/pengiriman/{id}', [App\Http\Controllers\PengirimanController::class, 'destroy'])->name('pengiriman.destroy');

        Route::get('/data-pengiriman', [App\Http\Controllers\PengirimanController::class, 'datapengiriman'])->name('data-pengiriman');

        Route::get('/data-pelanggan', [App\Http\Controllers\PelangganController::class, 'datapelanggan']);

        Route::get('/penjualan', [App\Http\Controllers\PenjualanController::class, 'index'])->name('penjualan');
        Route::post('/penjualan/update-status/{id}', [App\Http\Controllers\PenjualanController::class, 'updateStatus']);
        Route::post('/cancel-order/{id}', [App\Http\Controllers\PenjualanController::class, 'cancelOrder'])->name('cancel-order');

        Route::get('/keuangan', [App\Http\Controllers\AdminController::class, 'index'])->name('keuangan');

        Route::get('/sales/download-pdf', [App\Http\Controllers\AdminController::class, 'downloadSalesPDF'])->name('sales.download-pdf');
        Route::get('/purchases/download-pdf', [App\Http\Controllers\AdminController::class, 'downloadPurchasesPDF'])->name('purchases.download-pdf');
        Route::get('/income/download-pdf', [App\Http\Controllers\AdminController::class, 'downloadIncomePDF'])->name('income.download-pdf');
    // });
// });

Route::post('/kirim-kontak', [App\Http\Controllers\ContactController::class, 'send'])->name('contact.send');
Route::get('/search-obat', [App\Http\Controllers\ShopController::class, 'searchObat'])->name('search.obat');

Route::post('/midtrans/get-token/{id}', [App\Http\Controllers\MidtransController::class, 'getSnapToken'])->name('midtrans.token');
Route::post('/midtrans/notification', [App\Http\Controllers\MidtransController::class, 'handleNotification'])->name('midtrans.notification');
Route::post('/midtrans/update-status/{id}', [App\Http\Controllers\MidtransController::class, 'updateStatus'])->name('midtrans.update-status');

Route::get('/rajaongkir', [App\Http\Controllers\RajaOngkirController::class, 'index'])->name('rajaongkir');
Route::get('/cities/{provinceId}', [App\Http\Controllers\RajaOngkirController::class, 'getCities']);
Route::get('/districts/{cityId}', [App\Http\Controllers\RajaOngkirController::class, 'getDistricts']);
Route::post('/check-ongkir', [App\Http\Controllers\RajaOngkirController::class, 'checkOngkir']);



