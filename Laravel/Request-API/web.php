<?php

use Illuminate\Support\Facades\Route;

// 1. 作成したコントローラーを追加する！
use App\Http\Controllers\MariaController;

use App\Http\Controllers\LoginController;

use App\Http\Controllers\RegisterController;

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

Route::get('/admin/login', function () {
    return view('adminLogin'); // blade.php
})
->middleware('guest:admin');

// ログイン時にpostする際は上記のコンストラクターを挟むが、普通にgetでアクセスする際はコントローラーを使わないので、ここで別途設定する必要がある。


Route::post('/admin/login', [LoginController::class, 'adminLogin'])->name('admin.login');


Route::get('/admin/logout', [LoginController::class, 'adminLogout'])->name('admin.logout');


Route::get('/admin/dashboard', function () {
    return view('adminDashboard');
})->middleware('auth:admin');


// 今回は、ログイン済みのアカウントで新規アカウントを作成するので、middlewareはauthを選択する => 誰でも登録できる時は、ログインと同じでguestにする。
Route::get('/admin/register', [RegisterController::class, 'adminRegisterForm'])->middleware('auth:admin');


Route::post('/admin/register', [RegisterController::class, 'adminRegister'])->middleware('auth:admin')->name('admin.register');












