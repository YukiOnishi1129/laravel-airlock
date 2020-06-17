<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function () {

    // ここは全て「sanctum」のミドルウェアが適用される
    Route::get('/user', function (Request $request) {
        $user = $request->user();
        if ($user->tokenCan('user:update')) {
            return '権限あり！';
        }
        return '権限なし。。。';
    });
});
