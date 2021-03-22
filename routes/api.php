<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('user')->group(function(){
    Route::post("login", "Auth\AuthController@login");
});
//middleware("auth:api")->
Route::get("/users", function(){
    return \App\User::all();
});
Route::prefix('auth')->group(function() {
    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('details', 'Auth\AuthController@details');
    });

});

Route::apiResource('suppliers', Api\SupplierController::class);
Route::apiResource('orders', Api\OrderController::class);
Route::apiResource('products', Api\ProductController::class);

Route::prefix("test")->group(function(){
    Route::get("suppliers", function(){
        return \App\Models\Supplier::with('products')->get();
    });

    Route::get("products", function(){
        return \App\Models\Product::with('suppliers', 'orders')->get();
    });

    Route::get("orders", function(){
        return \App\Models\Order::with('products', 'products.suppliers')->get();
    });
});
