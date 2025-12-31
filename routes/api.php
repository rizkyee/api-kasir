<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::prefix('kasir')->group(function () {
    Route::post('login',  [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->prefix('kasir')->group(function () {

    Route::apiResource('karyawan', KaryawanController::class);
    Route::apiResource('kategori', KategoriController::class);
    Route::apiResource('produk', ProdukController::class);
    Route::apiResource('transaksi', TransaksiController::class);
});
