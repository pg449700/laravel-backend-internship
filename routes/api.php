<?php

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\GymClassController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\MembershipController;
use Illuminate\Support\Facades\Route;

Route::middleware(['force.json', 'security.headers', 'log.activity', 'throttle:60,1'])->name('api.')->group(function () {
    Route::get('/dashboard/stats', [DashboardController::class, 'stats'])->name('dashboard.stats');
    Route::apiResource('members', MemberController::class);
    Route::apiResource('memberships', MembershipController::class);
    Route::apiResource('classes', GymClassController::class)->parameters(['classes' => 'class']);
    Route::apiResource('bookings', BookingController::class)->only(['index', 'show', 'store', 'destroy']);
});
