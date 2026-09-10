<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GymClassController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MembershipController;
use Illuminate\Support\Facades\Route;

Route::middleware(['security.headers', 'log.activity'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('members', MemberController::class)->except(['show']);
    Route::resource('memberships', MembershipController::class)->except(['show']);
    Route::resource('classes', GymClassController::class)->except(['show'])->parameters(['classes' => 'class']);
    Route::resource('bookings', BookingController::class)->only(['index', 'create', 'store', 'destroy']);
});
