<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth', [UserController::class, 'authenticate']);

Route::prefix('/')
    ->middleware(['auth.jwt', 'redis.check'])
    ->group(function () {
        Route::post('/lead', [UserController::class, 'RegisterLead']);
        Route::get('/lead', [UserController::class, 'GetLeadAll']);
        Route::get('/lead/{id}', [UserController::class, 'GetLeadID']);
    });