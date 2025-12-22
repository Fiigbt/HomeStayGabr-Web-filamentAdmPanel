<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;

Route::get('/', function () {
    return view('welcome');
});

// Reservation Routes
Route::get('/kamar', [ReservationController::class, 'index'])->name('reservations.index');
Route::get('/kamar/{id}/booking', [ReservationController::class, 'create'])->name('reservations.create');
Route::post('/kamar/booking/store', [ReservationController::class, 'store'])->name('reservations.store');
Route::get('/booking/{id}/confirmation', [ReservationController::class, 'show'])->name('reservations.confirmation');
