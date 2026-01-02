<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\AktivitasUserController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;

use Illuminate\Support\Facades\Route;

Route::prefix('kasir')->group(function () {
    Route::post('login',  [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->prefix('kasir')->group(function () {

    Route::get('dashboard/summary', [DashboardController::class, 'summary']);
    Route::get('dashboard/chart-weekly', [DashboardController::class, 'weeklyChart']);
    Route::get('dashboard/payment-methods', [DashboardController::class, 'paymentMethods']);

    Route::apiResource('karyawan', KaryawanController::class);
    Route::apiResource('kategori', KategoriController::class);
    Route::apiResource('produk', ProdukController::class);
    Route::apiResource('transaksi', TransaksiController::class);
    Route::apiResource('pelanggan', PelangganController::class);
    Route::apiResource('aktivitas-user', AktivitasUserController::class);

    Route::get('laporan', [LaporanController::class, 'index']);
    Route::post('laporan/cetak', [LaporanController::class, 'cetak']);
});
