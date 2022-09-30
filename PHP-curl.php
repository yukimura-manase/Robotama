<?php

$custom_data_curl = curl_init();                                  // curlの処理を始めるための初期設定  // コネクションを開く
$search_query = "$column_name eq $id";               // 検索query-parameter => クエリの設定方法は、"(列名) eq (検索値)"となる。※URLエンコードは行うこと
$url_encoding = curl_escape($custom_data_curl, $search_query);    // < PHP・urlエンコード・文法 > curl_escape(CurlHandle $handle, string $string): string|false


$query_marge_url = "http://robotama/api/data/$table_name/query-column?q={$url_encoding}"; // URL-Marge



curl_setopt($custom_data_curl, CURLOPT_URL, $query_marge_url); // url-setting
curl_setopt($custom_data_curl, CURLOPT_CUSTOMREQUEST, "GET");   // メソッド指定
curl_setopt($custom_data_curl, CURLOPT_HTTPHEADER, array("Content-type: application/json", "Authorization: $access_token"));  // HTTP-HeaderをSetting
curl_setopt($custom_data_curl, CURLOPT_SSL_VERIFYPEER, false);  // サーバ証明書の検証は行わない。
curl_setopt($custom_data_curl, CURLOPT_SSL_VERIFYHOST, false);  
curl_setopt($custom_data_curl, CURLOPT_RETURNTRANSFER, true);   // レスポンスを文字列で受け取る

$robotama_response = curl_exec($custom_data_curl); // レスポンスを変数に入れる


curl_close($custom_data_curl);     // curlの処理を終了 // コネクションを切断


// Exment-APIとの通信処理を記述する -------------------------------------------------------------------------------

// 1. Exment-APIからTokenを取得する =>  Password Grant Token(パスワード形式)

$exment_post = [  // Flask-APIにPostするデータセット => データセット名(query-paramater)
"grant_type"=> "password",                                      // Password Grant Token(パスワード形式)
"client_id"=> "d2c23920-d107-11ec-b8cd-319ea383dd10",           // Client ID
"client_secret"=> "fiD2MmmRuFp0JyYfVWo8NyCb9879Ehb9OYEBnKzM",   // Client Secret
"username"=> "kaiho",                                           // ログインするユーザーIDまたはメールアドレス
"password"=> "kaiho-exment",                                    // ログインするユーザーパスワード
"scope"=> "me table_read value_read value_write plugin"         // アプリケーションとしてのアクセス許可レベル => 複数のスコープを指定する場合、スペース区切り
];
$exment_api_params = json_encode($exment_post);  // JSON形式で、Postするためにencoding

$robotama_url = "http://robotama/api/data/robotama"; // auth_api: アクセス許可を得るための認証エンドポイント => Token取得-API
$auth_curl = curl_init($auth_api);  // Auth-APIとのcurlの処理を始める合図

curl_setopt($auth_curl, CURLOPT_CUSTOMREQUEST, "POST"); // メソッド指定
curl_setopt($auth_curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));  // JSONデータを送信するので、Content-type: application/json設定をset！
curl_setopt($auth_curl, CURLOPT_POSTFIELDS, $exment_api_params); // パラメータをセット 
curl_setopt($auth_curl, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
curl_setopt($auth_curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($auth_curl, CURLOPT_RETURNTRANSFER, true); // レスポンスを文字列で受け取る







$robotama_url = "http://robotama/api/data/robotama";
$custom_data_curl = curl_init($robotama_url);    // curlの処理を始めるための初期設定  // コネクションを開く
curl_setopt($custom_data_curl, CURLOPT_CUSTOMREQUEST, "PUT");   // メソッド指定
curl_setopt($custom_data_curl, CURLOPT_HTTPHEADER, array("Content-type: application/json", "Authorization: $token"));  // HTTP-HeaderをSetting
curl_setopt($custom_data_curl, CURLOPT_POSTFIELDS, $json_params); // PUT-method => PostFieleds => Request-Params: json_encode(value);
curl_setopt($custom_data_curl, CURLOPT_SSL_VERIFYPEER, false);  // サーバ証明書の検証は行わない。
curl_setopt($custom_data_curl, CURLOPT_SSL_VERIFYHOST, false); 
curl_setopt($custom_data_curl, CURLOPT_RETURNTRANSFER, true);   // レスポンスを文字列で受け取る

$robotama_response = curl_exec($custom_data_curl); // レスポンスを変数に入れる
curl_close($custom_data_curl);     // curlの処理を終了 // コネクションを切断



