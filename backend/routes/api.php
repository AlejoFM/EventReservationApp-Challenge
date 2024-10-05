<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventSpaceController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register']); 
    Route::get('event_spaces', [EventSpaceController::class, 'index']);
    Route::get('event_spaces/{id}', action: [EventSpaceController::class, 'show']);
});

Route::group(['middleware' => ['auth.jwt']], function () {
    
    Route::post('logout', [AuthController::class, 'logout']);
    
    Route::post('event_spaces', [EventSpaceController::class, 'store']);
    Route::put('event_spaces/{id}', [EventSpaceController::class, 'update']);
    Route::delete('event_spaces/{id}', [EventSpaceController::class, 'destroy']);
    
    Route::get('reservations', [ReservationController::class, 'index']);
    Route::get('reservations/occupied-dates', [ReservationController::class, 'getOccupiedDates']);
    Route::post('reservations', [ReservationController::class, 'store']);
    Route::delete('reservations/{id}', [ReservationController::class, 'destroy']);
});

