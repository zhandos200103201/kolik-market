<?php

use App\Http\Controllers\Auth\Controller as AuthenticationController;
use App\Http\Controllers\Category\Controller as CategoryController;
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

Route::get('/', function () {
    return response()->json([
        'message' => 'Success.'
    ]);
});

Route::prefix('auth')->group(function ():void {
    Route::post('register', [AuthenticationController::class, 'register']);
    Route::post('login', [AuthenticationController::class, 'login']);
});

Route::prefix('categories')->group(function (): void{
    Route::get('', [CategoryController::class, 'index']);
    Route::get('{category}', [CategoryController::class, 'show']);
    Route::middleware('auth:api')->group(function (): void {
        Route::post('', [CategoryController::class, 'create']);
        Route::put('{category}', [CategoryController::class, 'update']);
        Route::delete('{category}', [CategoryController::class, 'delete']);
    });
});



