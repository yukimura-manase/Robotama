<?php

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


// File-Path: /routes/web.php


// 1. ロボ玉の価格のデータを返すAPI-エンドポイント (シンプルなGet通信)

// 「 /robotama 」get通信でAccessすると、RobotamaController の robotama_price_list 関数が起動する！
Route::get('/robotama', 'RobotamaController@robotama_price_list');

// [ 実行結果 ]
// {"ロボ玉試作1号機":"1000円","ロボ玉試作2号機":"2000円","ロボ玉試作3号機":"3000円"}



// 2. QueryParameterによって、処理内容が変わるAPI-エンドポイント (QueryParameterをSetするTypeのGet通信)

// URL-Path の中に {}で囲んでQueryParameterを受け取る変数名を決める!
Route::get('/project/{delete_id}/{robotama_cost?}', 'RobotamaController@delete_decision');

// URL: http://127.0.0.1:8000/project/2/5000 にて実行する

// [ 実行結果 ]
// 受信した削除対象のIDは、2
// ProjectにかかっているCostは、5000
// {"msg":"コストカットのため、5000円かかるロボ玉-Projectを終了しました！","Robotama-Project-List":{"robotama-1":"ロボ玉試作1号機","robotama-3":"ロボ玉試作3号機"},"delete_date":"2022-11-16 08:01:21"}



// < Laravel-パラメーター受信関係 >


// 【Laravel】ルーティングのパラメータを任意にする設定する方法｜波カッコ{ }の中のクエスチョンマーク(?)の意味やデータの受け取り方
// https://prograshi.com/framework/laravel/route-optional-parameter/



// Laravel入門#03(コントローラでルートパラメータを取得)
// https://coco-lb.com/learn-laravel-controller-route-parameter/




// 3. Post通信のAPI-エンドポイント


// 新規追加のエンドポイント: Post通信
Route::post('/submit/robotama', 'RobotamaController@submit_robotama');

// [ Postする JSONデータ🔥 ]
// {
//     "robotama": "ロボ玉",
//     "purupuru": "ぷるぷる"
// }


// [ 実行結果 ]
// {
//     "msg":"ぷるぷるロボ玉は、最高に可愛いです！",
//     "request_ip":"127.0.0.1",
//     "request_url":"http:\/\/127.0.0.1:8000\/submit\/robotama",
//     "request_path":"submit\/robotama",
//     "request_method":"POST"
// }



// 4. 番外編: $request の中身はどんなデータなのか？


// $request の中身を確認する dump() で情報を出力するエンドポイント
Route::get('/request/dump', 'RobotamaController@dump_request_data');








