<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminProdukController;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Order;

Route::get('/', [HomeController::class, 'index']);
Route::get('/produk', [ProdukController::class, 'index']);

Route::post('/cart/add', [CartController::class, 'add']);
Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart/remove', [CartController::class, 'remove']);

Route::get('/checkout', [CheckoutController::class, 'index']);
Route::post('/checkout', [CheckoutController::class, 'store']);
Route::get('/checkout/success', [CheckoutController::class, 'success']);

Route::get('/login', [AuthController::class, 'loginForm']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::middleware(['admin'])->group(function () {

    Route::get('/admin', [AdminController::class, 'index']);

    Route::get('/admin/order/{id}/terima', [AdminController::class, 'terima']);
    Route::get('/admin/order/{id}/tolak', [AdminController::class, 'tolak']);

    Route::get('/admin/pesanan', [AdminController::class, 'pesanan']);

    Route::get('/admin/produk', [AdminProdukController::class, 'index']);
    Route::get('/admin/produk/tambah', [AdminProdukController::class, 'create']);
    Route::post('/admin/produk/store', [AdminProdukController::class, 'store']);
    Route::get('/admin/produk/edit/{id}', [AdminProdukController::class, 'edit']);
    Route::post('/admin/produk/update/{id}', [AdminProdukController::class, 'update']);
    Route::get('/admin/produk/delete/{id}', [AdminProdukController::class, 'delete']);

    Route::get('/admin/pesanan/data', [AdminController::class, 'getOrders']);

    Route::get('/admin/laporan', [AdminController::class, 'laporan']);
});

Route::get('/test-email', function () {
    Mail::send([], [], function ($message) {
        $message->to('ultahyah@gmail.com')
                ->from('ultahyah@gmail.com', 'RANRIS')
                ->subject('TEST EMAIL LARAVEL')
                ->html('<h1>EMAIL MASUK</h1>');
    });

    return "TERKIRIM";

Route::get('/test-pdf', function () {
    $order = \App\Models\Order::with('items')->first();

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.invoice_pdf', compact('order'));

    return $pdf->stream();
});
});