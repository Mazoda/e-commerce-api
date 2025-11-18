<?php



use App\Http\Controllers\API\v1\BrandController;
use App\Http\Controllers\API\v1\CategoryController;
use App\Http\Controllers\API\v1\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product:id}', [ProductController::class, 'show']);

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{category:id}', [CategoryController::class, 'show']);
    Route::get('/categories/{category:id}/products', [CategoryController::class, 'products']);

    Route::get('/brands', action: [BrandController::class, 'index']);
    Route::get('/brands/{brand:id}', [BrandController::class, 'show']);
    Route::get('/brands/{brand:id}/products', [BrandController::class, 'products']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('v1')->group(
        function () {
            Route::post('/products', [ProductController::class, 'store']);
            Route::put('/products/{product:id}', [ProductController::class, 'update']);
            Route::delete('/products/{id}', [ProductController::class, 'destroy']);

            // Categories routes
            Route::post('/categories', [CategoryController::class, 'store']);
            Route::put('/categories/{category:id}', [CategoryController::class, 'update']);
            Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

            Route::post('/brands', [BrandController::class, 'store']);
            Route::put('/brands/{brand:id}', [BrandController::class, 'update']);
            Route::delete('/brands/{id}', [BrandController::class, 'destory']);
        }
    );
});

require __DIR__ . '/auth.php';