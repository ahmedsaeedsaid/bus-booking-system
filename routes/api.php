<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\TripController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::apiResource('trips', TripController::class)->only('index', 'store');

    Route::apiResource("trips.reservation", ReservationController::class)->only('store');
});