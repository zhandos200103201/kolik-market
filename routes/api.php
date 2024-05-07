<?php

use App\kolik\Domains\Controllers\Auth\Controller as AuthenticationController;
use App\kolik\Domains\Controllers\Category\Controller as CategoryController;
use App\kolik\Domains\Controllers\City\Controller as CityController;
use App\kolik\Domains\Controllers\Dashboard\Product\Controller as DashboardProductController;
use App\kolik\Domains\Controllers\Dashboard\Product\Resource\Controller as DashboardProductResourceController;
use App\kolik\Domains\Controllers\Feedback\Controller as FeedbackController;
use App\kolik\Domains\Controllers\Generation\Controller as ModelGenerationController;
use App\kolik\Domains\Controllers\Manufacturer\Controller as ManufacturerController;
use App\kolik\Domains\Controllers\Model\Controller as CarModelController;
use App\kolik\Domains\Controllers\Profile\Product\Controller as ProfileProductController;
use App\kolik\Domains\Controllers\Profile\Setting\Info\Controller as ProfileInfoController;
use App\kolik\Domains\Controllers\Profile\Setting\Password\Controller as ProfilePasswordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'Success',
    ]);
});

Route::prefix('auth')->name('auth-')->group(function (): void {
    Route::post('register', [AuthenticationController::class, 'register'])->name('register');
    Route::post('login', [AuthenticationController::class, 'login'])->name('login');
    Route::get('verify', [AuthenticationController::class, 'verify'])->name('verify')->middleware('signed');

    Route::middleware('auth:sanctum')->group(function (): void {
        Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');

        Route::prefix('email')->name('email-')->group(function (): void {
            Route::post('verify/send', [AuthenticationController::class, 'send'])->name('send');
        });
    });
});

Route::middleware(['auth:sanctum'])->group(function (): void {
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

        Route::get('products', [ProfileProductController::class, 'index'])->name('index');
        Route::get('products/{product}', [ProfileProductController::class, 'show'])->name('show');
        Route::prefix('products')->middleware('email.verify')->name('product-')->group(function (): void {
            Route::post('', [ProfileProductController::class, 'create'])->name('create');
            Route::put('{product}', [ProfileProductController::class, 'update'])->name('update');
            Route::delete('{product}', [ProfileProductController::class, 'delete'])->name('delete');
        });
    });

    Route::middleware(['admin'])->group(function (): void {
        Route::prefix('categories')->name('category-')->group(function (): void {
            Route::get('', [CategoryController::class, 'index'])->name('index');
            Route::post('', [CategoryController::class, 'create'])->name('create');
            Route::put('{category}', [CategoryController::class, 'update'])->name('update');
            Route::delete('{category}', [CategoryController::class, 'delete'])->name('delete');
        });

        Route::prefix('cities')->name('city-')->group(function (): void {
            Route::get('', [CityController::class, 'index'])->name('index');
            Route::post('', [CityController::class, 'create'])->name('create');
            Route::put('{city}', [CityController::class, 'update'])->name('update');
            Route::delete('{city}', [CityController::class, 'delete'])->name('delete');
        });

        Route::prefix('manufacturers')->name('manufacturer-')->group(function (): void {
            Route::get('', [ManufacturerController::class, 'index'])->name('index');
            Route::post('', [ManufacturerController::class, 'create'])->name('create');
            Route::put('{manufacturer}', [ManufacturerController::class, 'update'])->name('update');
            Route::delete('{manufacturer}', [ManufacturerController::class, 'delete'])->name('delete');
        });

        Route::prefix('models')->name('model-')->group(function (): void {
            Route::get('', [CarModelController::class, 'index'])->name('index');
            Route::post('', [CarModelController::class, 'create'])->name('create');
            Route::put('{model}', [CarModelController::class, 'update'])->name('update');
            Route::delete('{model}', [CarModelController::class, 'delete'])->name('delete');
        });

        Route::prefix('generations')->name('generation-')->group(function (): void {
            Route::get('', [ModelGenerationController::class, 'index'])->name('index');
            Route::post('', [ModelGenerationController::class, 'create'])->name('create');
            Route::put('{generation}', [ModelGenerationController::class, 'update'])->name('update');
            Route::delete('{generation}', [ModelGenerationController::class, 'delete'])->name('delete');
        });
    });
});

Route::prefix('feedbacks')->name('feedback-')->group(function (): void {
    Route::get('', [FeedbackController::class, 'index'])->name('index');
    Route::post('', [FeedbackController::class, 'create'])->name('create');
});

Route::prefix('dashboard')->name('dashboard-')->group(function (): void {
    Route::prefix('products')->name('product-')->group(function (): void {
        Route::prefix('resources')->name('resource-')->group(function (): void {
            Route::get('', [DashboardProductResourceController::class, 'index'])->name('index');
        });

        Route::get('', [DashboardProductController::class, 'index'])->name('index');
        Route::get('{product}', [DashboardProductController::class, 'show'])->name('show');
    });
});
