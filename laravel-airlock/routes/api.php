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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->group(function () {

    // ここは全て「sanctum」のミドルウェアが適用される
    // ベアラートークンがuserに紐づく者であれば、user情報を返す
    // 異なれば、ログイン画面へリダイレクト(Laravelのauthの機能が実施してくれる)
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // ベアラートークンに紐づくuserが権限を持つか確認する
    Route::put('/user', function (Request $request) {
        $user = $request->user();
        // tokenCan():引数にある権限があるかどうかを判定
        // personal_access_tokensテーブルのabilitiesの値
        if ($user->tokenCan('user:update')) {
            return '権限あり！';
        }
        return '権限なし。。。';
    });

    // トークンを取得する
    Route::put('/user/show', function (Request $request) {
        $user = $request->user();
        // ユーザーに与えられたトークンを取得するには、tokensを使います。
        foreach ($user->tokens as $token) {
            $name = $token->name;
            $dbToken = $token->token;
            $abilities = $token->abilities;
            dd($name, $dbToken, $abilities);
        }
    });

    // トークンを削除する
    Route::delete('user', function (Request $request) {
        $user = $request->user();
        // 全てのトークンを削除
        $user->tokens()->delete();

        // 特定の権限があるトークンだけを削除
        // $user->tokens()->whereJsonContains('abilities', 'user:update')->delete();
    });
});
