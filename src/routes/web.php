<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

//商品一覧画面
Route::get('/products', [ProductController::class, 'index']);//->name('products.index');
//商品　検索 ２つ必要。getとpost
Route::get('/products/search', [ProductController::class, 'search']);
Route::post('/products/search', [ProductController::class, 'search']);
//商品登録
Route::post('/products/register', [ProductController::class, 'create']);
//商品更新
Route::patch('/products/{product_id}/update', [ProductController::class, 'update']);
//商品削除
Route::delete('/products/{product_id}/delete', [ProductController::class, 'destroy']);
//商品　詳細
Route::get('/products/{product_id}', [ProductController::class, 'detail']);
