<?php



use App\Http\Controllers\API\v1\CategoryController;
use App\Http\Controllers\API\v1\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::
    get('/test', function () {
        return ['msg' => 'Hello hello testing'];
    });

Route::prefix('v1')->group(
    function () {
        Route::apiResource('products', ProductController::class);
        Route::apiResource('categories', CategoryController::class);
    }
);
