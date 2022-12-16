<?php

$DataDir = dirname(__FILE__) . '/TestDir/';

// File の CRUD処理まとめ => Create, Read, Update, Delete 処理🔥
try {

    // [ 1. File の Create-処理🔥 ]

    // file_put_contents() で、ファイルを新規作成 or 存在すれば、設定したデータを書き込む
    
    $target_file = 'Robotama.txt';

    $target_file_path = "{$DataDir}{$target_file}";

    // 1-1. ファイル新規作成 or ファイル内容上書きパターン
    $file_create_result = file_put_contents($target_file_path, 'Robotama-Nanoda');

    // ファイルを作成失敗したら、Error-throw
    if (!$file_create_result) throw new Exception("Error when creating file. Failed to create file {$target_file_path}.");


    // [ 2. File の Read-処理🔥 ]

    // 2-1. ファイルを読み込む
    $file_data = file_get_contents($target_file_path);

    // ファイルの読み込みに失敗したら、Error-throw
    if (!$file_create_result) throw new Exception("Error when Reading file. Failed to read file {$target_file_path}.");

    // 2-2. 読み込んだデータを出力する
    echo '新規作成後のファイルのコンテンツ' . "\n";
    echo $file_data . "\n";
    // 新規作成後のファイルのコンテンツ
    // Robotama-Nanoda
    

    // [ 3. File の Update-処理🔥 ]

    $msg = 'ぷるぷるロボ玉なのだ！';

    // 3-1. ファイル新規作成 or すでにファイルが存在する場合は、データを追記するパターン
    $msg_add_result = file_put_contents($target_file_path, "\n{$msg}", FILE_APPEND);

    
    // ファイルに追記が失敗したら、Error-throw
    if (!$file_create_result) throw new Exception("Error when updating file. Failed to update file {$target_file_path}.");


    $file_data2 = file_get_contents($target_file_path);

    echo '追記後ののファイルのコンテンツ' . "\n";
    echo($file_data2) . "\n";
    // 追記後ののファイルのコンテンツ  
    // Robotama-Nanoda
    // ぷるぷるロボ玉なのだ！

    // [ 4. File の Delete-処理🔥 ]


    // 4-1. ファイルを削除する
    $delete_process_result = unlink($target_file_path);

    // ファイルの削除に失敗したら、Error-throw
    if (!$delete_process_result) throw new Exception("Error when deleting file. Failed to delete {$target_file_path}.");


   

// 異常系の処理インターファイス
} catch(Exception $e) {
    header('Content-Type: application/json');
    $response = [
        'result' => false,
        'error' => $e->getMessage()
    ];
    echo json_encode($response);
    return;
}

