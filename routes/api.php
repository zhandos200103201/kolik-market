<?php

use App\kolik\Domains\Controllers\Auth\Controller as AuthenticationController;
use App\kolik\Domains\Controllers\Category\Controller as CategoryController;
use App\kolik\Domains\Controllers\City\Controller as CityController;
use App\kolik\Domains\Controllers\Feedback\Controller as FeedbackController;
use App\kolik\Domains\Controllers\Generation\Controller as ModelGenerationController;
use App\kolik\Domains\Controllers\Manufacturer\Controller as ManufacturerController;
use App\kolik\Domains\Controllers\Model\Controller as CarModelController;
use App\kolik\Domains\Controllers\Profile\Setting\Info\Controller as ProfileInfoController;
use App\kolik\Domains\Controllers\Profile\Setting\Password\Controller as ProfilePasswordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'Success',
    ]);
});

Route::prefix('auth')->name('auth-')->group(function (): void {
    Route::post('register', [AuthenticationController::class, 'register']);
    Route::post('login', [AuthenticationController::class, 'login'])->name('login');

    Route::middleware('auth:sanctum')->group(function (): void {
        Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');

        Route::prefix('email')->name('email-')->group(function (): void {
            Route::post('verify/send', [AuthenticationController::class, 'send'])->name('send');
            Route::post('verify', [AuthenticationController::class, 'verify'])->name('verify')->middleware('signed');
        });
    });
});

Route::prefix('categories')->group(function (): void {
    Route::get('', [CategoryController::class, 'index']);
    Route::get('{category}', [CategoryController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function (): void {
        Route::post('', [CategoryController::class, 'create']);
        Route::put('{category}', [CategoryController::class, 'update']);
        Route::delete('{category}', [CategoryController::class, 'delete']);
    });
});

Route::prefix('manufacturers')->group(function (): void {
    Route::get('', [ManufacturerController::class, 'index']);

    Route::middleware('auth:sanctum')->group(function (): void {
        Route::post('', [ManufacturerController::class, 'create']);
        Route::put('{manufacturer}', [ManufacturerController::class, 'update']);
        Route::delete('{manufacturer}', [ManufacturerController::class, 'delete']);
    });
});

Route::prefix('models')->group(function (): void {
    Route::get('', [CarModelController::class, 'index']);

    Route::middleware('auth:sanctum')->group(function (): void {
        Route::post('', [CarModelController::class, 'create']);
        Route::put('{model}', [CarModelController::class, 'update']);
        Route::delete('{model}', [CarModelController::class, 'delete']);
    });
});

Route::prefix('generations')->group(function (): void {
    Route::get('', [ModelGenerationController::class, 'index']);

    Route::middleware('auth:sanctum')->group(function (): void {
        Route::post('', [ModelGenerationController::class, 'create']);
        Route::put('{generation}', [ModelGenerationController::class, 'update']);
        Route::delete('{generation}', [ModelGenerationController::class, 'delete']);
    });
});

Route::prefix('cities')->group(function (): void {
    Route::get('', [CityController::class, 'index']);

    Route::middleware('auth:sanctum')->group(function (): void {
        Route::post('', [CityController::class, 'create']);
        Route::put('{city}', [CityController::class, 'update']);
        Route::delete('{city}', [CityController::class, 'delete']);
    });
});

Route::prefix('feedbacks')->group(function (): void {
    Route::get('', [FeedbackController::class, 'index']);
    Route::post('', [FeedbackController::class, 'create']);
    //    Route::put('{generation}', [FeedbackController::class, 'update']);
    //    Route::delete('{generation}', [FeedbackController::class, 'delete']);
});

Route::middleware('auth:sanctum')->group(function (): void {
    Route::prefix('profiles')->name('profile-')->group(function (): void {
        Route::prefix('settings')->name('setting-')->group(function (): void {
            Route::prefix('info')->name('info-')->group(function (): void {
                Route::get('', [ProfileInfoController::class, 'index'])->name('index');
                Route::put('', [ProfileInfoController::class, 'update'])->name('update');
            });

            Route::prefix('password')->name('password-')->group(function (): void {
                Route::post('email', [ProfilePasswordController::class, 'email'])->name('email');
                Route::post('reset', [ProfilePasswordController::class, 'reset'])->name('reset');
            });
        });
    });
});
