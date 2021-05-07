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
  
// Route::post('/register', [RegisterController::class, 'register']);
// Route::post('/login', [RegisterController::class, 'login']);
     
// Route::middleware('auth:api')->group( function () {
//     // Route::resource('users', UserController::class);
//     Route::get('users', [UserController::class, 'index']);

//     Route::get('users/{id}', [UserController::class, 'show']);

//     Route::post('users', [UserController::class, 'store']);
    
//     Route::post('users/{id}', [UserController::class, 'update']);

//     Route::post('users/delete/{id}', [UserController::class, 'delete']);
// });


Route::get('users', [UserController::class, 'index']);

    Route::get('users/{id}', [UserController::class, 'show']);

    Route::post('users', [UserController::class, 'store']);
    
    Route::post('users/{id}', [UserController::class, 'update']);

    Route::post('users/delete/{id}', [UserController::class, 'delete']);