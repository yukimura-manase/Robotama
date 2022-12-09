<?php
setlocale(LC_ALL, 'ja_JP.UTF-8');

$DataDir = dirname(__FILE__) . '/recoding/';

chdir($DataDir);

// $files = scandir($DataDir);

// CORS-対応
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

try {

    // action: "get" | "change" | "command"
    $action = $_REQUEST['action'];

    $mid = $_REQUEST['mid'];

    $status = $_REQUEST['status'];

    $command = $_REQUEST['command'];

    // 1. Action が Setされているかどうかの Check Check
    if (!isset($action)) {
        throw new Exception("Action is not set. {$DataDir}");
    }

    // 2. Action が get なら {管理ID: status} の Listを返却する
    if ($action == 'get') {

        $list = [];

        // [ 正常系処理 & 異常系処理 ]
            // 1. sender_proc & rec ファイル => 接続 & 収録中 (正常系)
            // 2. sender_proc ファイルのみ => 接続 (正常系)
            // 3. rec ファイルのみ => 収録中のみ (異常系)

        // 2-1. 管理ID(mid)ありパターン
        if (isset($mid)) {

            // status: (0 | 1 | 2) = (未接続 | 接続中 | 接続 & 収録中)
            $status = 0;
                
            $target_rec_file = "{$mid}.rec";
            $target_process_file = "{$mid}.sender_proc";

            // まずは、該当ファイルの存在確認をする
            $proc_bool = file_exists("{$DataDir}{$target_process_file}");
            $rec_bool = file_exists("{$DataDir}{$target_rec_file}");

            // rec ファイルのみ => 収録中のみ (異常系)
            if ($rec_bool && !$proc_bool) {
                // 0(未接続判定)を返して、無視する => Exception で処理を止めない
                array_push($list, ['mid' => (int)$mid, 'status' => 0]);

                $delete_rec_result = unlink("{$DataDir}{$target_rec_file}"); // 収録中のみの異常系ファイルを削除する
                if (!$delete_rec_result) {
                    throw new Exception("Error when deleting files. Failed to delete {$DataDir}{$target_rec_file}.");
                }
            } else {
                $proc_bool ? $status++ : false;
                $rec_bool ? $status++ : false;
                array_push($list, ['mid' => (int)$mid, 'status' => $status]);
            }

        // 2-2. 管理ID(mid)なしパターン
        } else {

            $proc_path_list = glob($DataDir. '*.sender_proc');
            $rec_path_list = glob($DataDir. '*.rec');

            if ($proc_path_list == false || $rec_path_list == false) {
                throw new Exception("glob error. {$DataDir}");
            }

            // 差分比較などのため、mid だけを格納するList
            $sender_proc_list = [];
            $rec_list = [];

            foreach ($proc_path_list as $path) {
                $file = basename($path); // ファイル名を取得
                $extension = substr($file, strrpos($file, '.') + 1); // 拡張子を取得
                $file_name = basename($file, ".{$extension}"); // ファイル名から拡張子を除外して取得
                array_push($sender_proc_list, $file_name);
            }

            foreach ($rec_path_list as $path) {
                $file = basename($path); // ファイル名を取得
                $extension = substr($file, strrpos($file, '.') + 1); // 拡張子を取得
                $file_name = basename($file, ".{$extension}"); // ファイル名から拡張子を除外して取得
                array_push($rec_list, $file_name);
            }

            // sender_proc_list & rec_list 両方に同じ mid が存在すれば => 接続 & 収録中・状態 (正常系)
            $proc_rec_list = array_intersect($sender_proc_list, $rec_list);
            
            // sender_proc_list にだけ mid が存在すれば => 接続・状態 (正常系)
            $sender_proc_only_list = array_diff($sender_proc_list, $rec_list);

            // rec_list のみ mid が存在すれば => 収録中のみ (異常系)
            $rec_only_list = array_diff($rec_list, $sender_proc_list);

            if (!empty($rec_only_list)) {
                foreach ($rec_only_list as $mid) {
                    $error_rec_file_path = "{$DataDir}{$mid}.rec";
                    $delete_rec_result = unlink($error_rec_file_path); // 収録中のみの異常系ファイルを削除する

                    if (!$delete_rec_result) {
                        throw new Exception("Error when deleting files. Failed to delete {$error_rec_file_path}.");
                    }
                }
            }

            foreach ($proc_rec_list as $mid) { array_push($list, ['mid' => (int)$mid, 'status' => 2,]); }

            foreach ($sender_proc_only_list as $mid) { array_push($list, ['mid' => (int)$mid, 'status' => 1,]); }
        }

        // action: get の正常系-レスポンス
        $response = [
            'result' => true,
            'list' => $list,
        ];
        echo json_encode($response);
        return;
    } 
    

    // 3. Action が change なら 接続の ON/OFF or 収録の ON/OFF などの状態を変更させる
    if ($action == 'change') {

    // [ 正常系処理 & 異常系処理 Action-Change-Part-1 ]
        // 1. { action: 'change', mid: number, status: (0 | 1 | 2) } は必須 (正常系)
        // 2. 上記の必須データがかけたら Error (異常系)
        // 3. mid が欠けていたら、Error (異常系)
        // 4. status が欠けていたら、Error (異常系)
        // 5. status の値が、(0 | 1 | 2)以外だったら、Error (異常系)

        $error_status = 0;

        isset($mid) ? true : $error_status+=3;

        if (isset($status)) {
            if (3 <= (int)$status) { $error_status+=7; }
        } else { $error_status+=5; }
        
        // 3-1. 正常系か異常系かで、ハンドリングする Switch-文
        $process_continue = false;
        switch ($error_status) {
            case 0:
                $process_continue = true;
                break;
            case 3:
                throw new Exception("Change mid is not set.");
                break;
            case 5:
                throw new Exception("Change status is not set.");
                break;
            case 7:
                throw new Exception("Invalid change status number.");
                break;
            case 8: 
                throw new Exception("Change mid and status is not set.");
                break;
            case 10:
                throw new Exception("Change mid is not set and Invalid change status number.");
                break;
            default: 
                $process_continue = true;
        }

        // 3-2. 正常系ならば、処理を実行する
        if ($process_continue) {
            // [ 正常系処理 & 異常系処理 Action-Change-Part-2 ]
            // 1. status: 0 => 接続停止する(収録中なら、収録停止する) => 正常系
            // 2. status: 1 => 接続開始する or 接続済み & 収録中の場合は、収録停止して、ただの接続状態にする => 正常系
            // 3. status: 2 => 収録開始する(収録判定ファイルを作成する) => 正常系


            // [ 共通で使用するデータ ]

            // 1. globでListを作成する
            $proc_path_list = glob($DataDir. '*.sender_proc');
            $rec_path_list = glob($DataDir. '*.rec');

            if ($proc_path_list == false || $rec_path_list == false) {
                throw new Exception("glob error. {$DataDir}");
            }

            // 2. $mid.rec や $mid.sender_proc のファイル名
            $target_process_file = "{$mid}.sender_proc";
            $target_rec_file = "{$mid}.rec";

            // 3. 該当ファイルまでのPath
            $target_process_path = "{$DataDir}{$target_process_file}";
            $target_rec_path = "{$DataDir}{$target_rec_file}";

            // 4. 該当ファイルの存在確認をする
            $proc_bool = file_exists("{$DataDir}{$target_process_file}");
            $rec_bool = file_exists("{$DataDir}{$target_rec_file}");


            // [ Status ごとの処理 ]
            // 1. status: 0 => 接続停止する (収録中なら、収録停止する)
            if ($status == 0)  {

                // 収録中の判定ファイルを削除する
                if ($rec_bool) {
                    $delete_rec_result = unlink($target_rec_file);
                    if (!$delete_rec_result) { throw new Exception("Error when deleting files. Failed to delete {$target_rec_path}."); }
                }

                // 接続中の判定ファイルを削除する
                if ($proc_bool) {
                    $delete_process_result = unlink($target_process_file);
                    if (!$delete_process_result) { throw new Exception("Error when deleting files. Failed to delete {$target_process_path}."); }
                }


            // 2. status: 1 => 接続開始する or 接続済み & 収録中の場合は、収録停止して、ただの接続状態にする
            } else if ($status == 1) {
                
                // 収録中の判定ファイルが存在する場合は、削除する
                if ($rec_bool) {
                    $delete_rec_result = unlink($target_rec_file);
                    if (!$delete_rec_result) { throw new Exception("Error when deleting files. Failed to delete {$target_rec_path}."); }
                }

                // 接続中の判定ファイルがなければ、新規で作成する
                if (!$proc_bool) {
                    $create_process_result = touch($target_process_file);
                    if (!$create_process_result) { throw new Exception("Error when creating files. Failed to create file {$target_process_path}."); }
                }

                // 新規の接続なので、Python-Script を呼び出す

                // $command = "export LANG=ja_JP.UTF-8; ls -al";

                // Pythonの実行プログラムを呼び出す
                // $command = "export LANG=ja_JP.UTF-8; python /usr/share/zabbix/connection/DataRegister.py {$mid}";
                
                // $command_result = exec($command, $output);

                // foreach ($output as $val) {
                //     echo $val . "\n";
                // }


            // 3. status: 2 収録開始する => 収録判定ファイルを作成する
            } else if ($status == 2) {

                // 接続判断ファイル & 収録判断ファイル 両方なかったら、2つとも作成する
                if (!$proc_bool && !$rec_bool) {

                    $create_process_result = touch($target_process_file);
                    if (!$create_process_result) { throw new Exception("Error when creating files. Failed to create file {$target_process_path}."); }

                    $create_rec_result = touch($target_rec_file);
                    if (!$create_rec_result) { throw new Exception("Error when creating files. Failed to create file {$target_rec_path}."); }
                    
                // 接続判断のファイルだけが、存在しなければ作成する
                } else if (!$proc_bool) {

                    $create_process_result = touch($target_process_file);
                    if (!$create_process_result) { throw new Exception("Error when creating files. Failed to create file {$target_process_path}."); }

                // 収録判断のファイルだけが存在しなければ、作成する
                } else if (!$rec_bool) {
                    $create_rec_result = touch($target_rec_file);

                    if (!$create_rec_result) { throw new Exception("Error when creating files. Failed to create file {$target_rec_path}."); }
                }

                // Pythonの実行プログラムを呼び出す
                // $command = "export LANG=ja_JP.UTF-8; python /usr/share/zabbix/connection/DataRegister.py {$mid}";
                // $command_result = exec($command, $output);
            }

            // action: change の正常系-レスポンス
            $response = [
                'result' => true,
            ];
            echo json_encode($response);
            return;
        }

    }

    // 4. action が command なら $mid.command ファイルを作成して、そのファイルにコマンド文字列を書き込む
    if ($action == 'command') {

        // [ 正常系処理 & 異常系処理 Action-Command-Part-1 ]
        // 1. { action: 'command', mid: number, command: コマンド文字列 } は必須 (正常系)
        // 2. 上記の必須データがかけたら Error (異常系)
        // 3. mid が欠けていたら、Error (異常系)
        // 4. コマンド文字列が欠けていたら、Error (異常系)

        $error_status = 0;

        isset($mid) ? true : $error_status+=3;

        isset($command) ? true : $error_status+=5;
        
        // 4-1. 正常系か異常系かで、ハンドリングする Switch-文
        $process_continue = false;
        switch ($error_status) {
            case 0:
                $process_continue = true;
                break;
            case 3:
                throw new Exception("Command mid is not set.");
                break;
            case 5:
                throw new Exception("Command string is not set.");
                break;
            case 8: 
                throw new Exception("Command mid and Command string is not set.");
                break;
            default: 
                $process_continue = true;
        }

        // 4-2. 正常系の処理開始
        if ($process_continue) {

            $target_command_file = "{$mid}.command";
            $target_command_file_path = "{$DataDir}{$target_command_file}";

            // ファイルを作成して、受信した command を書き込む

            // Ver. ファイル新規作成 or ファイル内容上書きパターン
            $file_create_result = file_put_contents($target_command_file, $command);

            if (!$file_create_result) { throw new Exception("Error when creating files. Failed to create file {$target_command_file_path}."); }

            // Ver. ファイル新規作成 or すでにファイルが存在する場合は、データを追記するパターン
            // $file_insert_command_result = file_put_contents($target_command_file, "{$command}\n", FILE_APPEND);

            // if (!$file_insert_command_result) { throw new Exception("Error when creating files. Failed to create file {$target_command_file_path}."); }
        }

        // action: command の正常系-レスポンス
        $response = [
            'result' => true,
        ];
        echo json_encode($response);
        return;
    }

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


