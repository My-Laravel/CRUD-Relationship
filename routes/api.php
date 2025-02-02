<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Models\User;

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

Route::prefix('users')->group(function () {
    Route::get('/',[UsersController::class, 'index']);
    Route::post('/',[UsersController::class,'store']);
    Route::get('/{id}',[UsersController::class,'show']);
    Route::put('/{id}',[UsersController::class, 'update']);
    Route::delete('/{id}',[UsersController::class, 'destroy']);
});
