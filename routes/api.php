<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PenyewaController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\FotoKamarController;
use App\Http\Controllers\LogAktivitasController;

Route::apiResource('penyewa', PenyewaController::class);
Route::apiResource('kamar', KamarController::class);
Route::apiResource('reservasi', ReservasiController::class);
Route::apiResource('pembayaran', PembayaranController::class);

Route::post('foto-kamar', [FotoKamarController::class, 'store']);
Route::delete('foto-kamar/{id}', [FotoKamarController::class, 'destroy']);

Route::get('log', [LogAktivitasController::class, 'index']);
Route::post('log', [LogAktivitasController::class, 'store']);
