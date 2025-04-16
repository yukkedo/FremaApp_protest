<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('/');
});

Route::get('/login', [AuthController::class, 'loginShow']);
Route::get('/', [ItemController::class, 'index']);
Route::get('/item/{item_id}', [ItemController::class, 'getDetail']);
Route::post('/item/{item_id}/like', [ItemController::class, 'like']);
Route::get('/purchase/address', [ItemController::class,'getChangeAddress']);


Route::middleware(['auth'])->group(function () {
    Route::post('/item/{item_id}/comment', [ItemController::class, 'comment']);
    Route::get('/mypage', [ProfileController::class, 'show']);
    Route::get('/mypage/profile', [ProfileController::class, 'profile']);
    Route::post('/mypage/profile/image', [ProfileController::class, 'imageEdit']);
    Route::post('/mypage/profile', [ProfileController::class, 'edit']);
    Route::get('/sell', [ItemController::class, 'getSell']);
    Route::post('/sell/image', [ItemController::class, 'storeImage']);
    Route::post('/sell', [ItemController::class, 'storeSell']);
    Route::get('/purchase/{item_id}', [ItemController::class, 'getPurchase']);
    Route::post('/purchase/{item_id}', [ItemController::class, 'purchaseItem']);
    Route::get('/purchase/address/{item_id}', [ProfileController::class, 'getChangeAddress']);
    Route::post('/purchase/address/{item_id}', [ProfileController::class, 'addressUpdate']);
});