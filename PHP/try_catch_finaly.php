<?php

// Try-Catch-Finally

try {

    $file_name = null;

    $data_dir = dirname(__FILE__) . '/TestDir/';

    if (!$file_name) throw new Exception("Error file name not set.");

    $file_create_result = file_put_contents("{$data_dir}{$file_name}", 'Robotama-Nanoda');

    if (!$file_create_result) throw new Exception("Error when creating file. Failed to create file {$target_file_path}.");

    $response = [
        'result' => true,
    ];    

// 異常系の処理インターファイス
} catch(Exception $e) {
    
    $response = [
        'result' => false,
        'error' => $e->getMessage()
    ];

} finally {
    // Requestに対するResponseは、必ず返却する
    
    //  finally ブロックの中に書いたコードは、 try および catch ブロックの後で常に実行されます。

    // => 例外がスローされたかどうかは関係ありません。

        
    // CORS-対応
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Content-Type');

    // JSONデータを送信する
    header('Content-Type: application/json');
    $json_response = json_encode($response);

    var_export($json_response);
    // return $json_response;
};



// [ 実行結果 ]
// '{"result":false,"error":"Error file name not set."}'




