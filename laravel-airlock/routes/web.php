<?php

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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
    return view('welcome');
});

Route::get('/create_token', function () {
    // 特定の権限をつける
    $permissions = ['user:deleted'];

    // usersテーブルのid:1のデータを取得(userインスタンスを生成)
    $user = User::find(1);
    // Laravel\Sanctum\HasApiTokensのメソッド
    // personal_access_tokensテーブルのtokenにusersテーブルのレコードに紐づくデータを生成
    // 紐づくtokenを生成し、テーブルに保存する
    $token = $user->createToken('my-api-token', $permissions); //第二引数に権限を追加 → personal_access_tokensテーブルのabilitiesには権限が追加される
    echo $token->plainTextToken; //トークンを表示する
    // $token->plainTextTokenで表示されるトークンは
    // personal_access_tokensテーブルのtokenに表示されている値とは異なるが、これはよりセキュアにするために暗号化されているため同じ
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
