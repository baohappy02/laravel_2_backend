<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\UserController;

  
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
  
Route::post('/v1/register', [RegisterController::class, 'register']);
Route::post('/v1/login', [RegisterController::class, 'login']);
     
Route::middleware('auth:api')->group( function () {
    Route::get('/v1/users/view', [UserController::class, 'index']);

    Route::get('/v1/user/show/{id}', [UserController::class, 'show']);

    Route::post('/v1/user/create', [UserController::class, 'store']);
    
    Route::post('/v1/user/update/{id}', [UserController::class, 'update']);

    Route::post('/v1/users/delete/{id}', [UserController::class, 'delete']);
});


    // Route::get('users/view', [UserController::class, 'index']);

    // Route::get('user/show/{id}', [UserController::class, 'show']);

    // Route::post('user/create', [UserController::class, 'store']);
    
    // Route::post('user/update/{id}', [UserController::class, 'update']);

    // Route::post('users/delete/{id}', [UserController::class, 'delete']);