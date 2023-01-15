<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerifyEmailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StoreController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['cors'])->group(function(){

    //User
    Route::prefix('/user')->middleware('jwt.verify')->group(function(){
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{token}', [UserController::class, 'show']);
        Route::post('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });

     //User
     Route::prefix('/store')->middleware('jwt.verify')->group(function(){
        Route::get('/', [StoreController::class, 'index']);
        Route::get('/{id}', [StoreController::class, 'show']);
        Route::get('/like/{search}', [StoreController::class, 'like']);
        Route::post('/', [StoreController::class, 'store']);
        Route::post('/{id}', [StoreController::class, 'update']);
        Route::delete('/{id}', [StoreController::class, 'destroy']);
    });

    // Authentication routes
    Route::prefix('/auth')->group(function(){
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
    });

    // Verify email
    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, 'verify'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

    // Resend link to verify email
    Route::post('/email/verify/resend/{id}',[VerifyEmailController::class, 'resend'])
    ->middleware(['throttle:6,1'])->name('verification.send');
});

