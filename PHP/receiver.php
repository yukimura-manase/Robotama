<?php
setlocale(LC_ALL, 'ja_JP.UTF-8');

const DataDir = '/usr/share/uwe/data/receiver/';
const LogDir = '/usr/share/uwe/log/';

// const ReceiverStartCommand = 'python3 /usr/share/zabbix/connection/DataRegister.py ';
const ReceiverStartCommand = 'python3 DataRegister.py ';

// レシーバープログラムパス => パスは通してあるのでOK！
// C:\Users\Admin\UWE\program\Reciver\DataRegister.py

// Warning-Level は、Log-File にOutputする
function WarningLog ($log_msg) {
    if (!file_exists(LogDir)) {
        mkdir(LogDir);
    }
    $ts = date("Y/m/d H:i:s");
    // すでにファイルが存在する場合は追記
    $log_path = LogDir . basename(__FILE__, ".php") . ".log";
    file_put_contents($log_path, "{$ts} {$log_msg}\n", FILE_APPEND);
}

// midを必ず3桁に調整する
function MidThree ($mid) {
    $mid_length = strlen($mid);
    if ($mid_length <= 2) {
        $add_zero = 3 - $mid_length;
        for ($count = 0; $count < $add_zero; $count++){
            $mid = '0' . $mid;
        }
    }
    return $mid;
}

try {
    // CORS-対応
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Content-Type');
    header('Content-Type: application/json');


    // action: ("get" | "change" | "command")
    $action = $_REQUEST['action'];

    $mid = $_REQUEST['mid'];
    $status = $_REQUEST['status'];
    $command = $_REQUEST['command'];

    if (isset($mid)) $mid = MidThree($mid);

    // 1. Action が Setされているかどうかの Check Check
    if (!isset($action)) {
        throw new Exception("Action is not set.");
    }

    if (!file_exists(DataDir)) {
        mkdir(DataDir);
    }

    // 2. Action が get なら {管理ID: status} の Listを返却する
    // status: (0 | 1 | 2) = (未接続 | 接続中 | 接続 & 収録中)
    if ($action == 'get') {
        $list = [];

        // 1. receiver_proc & rec ファイル => 接続 & 収録中 (正常系)
        // 2. receiver_proc ファイルのみ => 接続 (正常系)
        // 3. ファイルなし => 未接続

        // 2-1. 管理ID(mid)ありパターン
        if (isset($mid)) {

            // 該当ファイルの存在確認
            $target_rec_file = "{$mid}.rec";
            $target_process_file = "{$mid}.receiver_proc";

            $proc_bool = file_exists(DataDir . $target_process_file);
            $rec_bool = file_exists(DataDir . $target_rec_file);

            // status: (0 | 1 | 2) = (未接続 | 接続中 | 接続 & 収録中)
            $status = $proc_bool ? ($rec_bool ? 2 : 1) : 0;

            array_push($list, ['mid' => (int)$mid, 'status' => $status]);

        // 2-2. 管理ID(mid)なしパターン
        } else {
            // status = 1 | 2 のリストを生成する

            // MEMO: PHPで空配列は false な値なので注意！
            $proc_path_list = glob(DataDir. '*.receiver_proc');
            if (!is_array($proc_path_list)) throw new Exception("glob *.receiver_proc error." . DataDir);

            $rec_path_list = glob(DataDir. '*.rec');
            if (!is_array($rec_path_list)) throw new Exception("glob *.rec error." . DataDir);

            // 差分比較などのため、mid だけ(拡張子を除外してファイル名)を格納するList
            $proc_mid_list = [];
            $rec_mid_list = [];
            foreach ($proc_path_list as $path) array_push($proc_mid_list, basename($path, ".receiver_proc"));
            foreach ($rec_path_list as $path) array_push($rec_mid_list, basename($path, ".rec"));

            // 両方あれば接続 & 収録中状態
            $proc_rec_list = array_intersect($proc_mid_list, $rec_mid_list);
            // proc_list にだけ存在すれば、接続状態
            $proc_only_list = array_diff($proc_mid_list, $rec_mid_list);

            foreach ($proc_rec_list as $mid) array_push($list, ['mid' => (int)$mid, 'status' => 2,]);
            foreach ($proc_only_list as $mid) array_push($list, ['mid' => (int)$mid, 'status' => 1,]);
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
        // mid or status が欠けていたら、Error
        if (!isset($mid) || !isset($status)) throw new Exception("Change mid or status is not set.");

        // status の値が、(0 | 1 | 2)以外だったら、Error (異常系) => 3以上 or マイナスの数値(0未満)はエラー
        if ($status < 0 || 3 <= $status) throw new Exception("Invalid change status number.");

        // [ 正常系処理 & 異常系処理 Action-Change-Part-2 ]
        // status: 0 => 未接続状態にする(接続状態なら切断＋収録状態なら停止)
        // status: 1 => 接続状態にする(収録状態なら収録停止、未接続なら接続)
        // status: 2 => 収録状態にする(接続状態なら収録判定ファイルを作成する)


        // [ 共通で使用するデータ ]
        $proc_path = DataDir. $mid . '.receiver_proc';
        $rec_path = DataDir. $mid . '.rec';
        $end_path = DataDir. $mid . '.end';

        // [ Status ごとの処理 ]
        if ($status == 0)  {
            // status: 0 => 接続停止する (収録中なら、収録停止する)
            if (file_exists($rec_path)) {
                if (!unlink($rec_path)) {
                    WarningLog("Failed to delete {$rec_path}.");
                }
            }

            if (!file_exists($end_path)) {

                // .end ファイルを作成する
                $create_success = touch($end_path);
                
                // 権限変更
                $chmod_success = chmod($end_path, 0777);

                if (!$create_success) {
                    throw new Exception("Failed to create file. {$end_path}");
                }


            }

            if (file_exists($proc_path)) {
                // Process-ID を 「.receiver_proc」ファイルの中から取得する
                // $pid = file_get_contents($proc_path);

                if (!unlink($proc_path)) {
                    throw new Exception("Failed to delete {$proc_path}.");
                }

                // Process-Kill コマンドを作成する
                // $kill_command = "taskkill.exe /{$pid}";
                // system($kill_command, $status_code);

                // // kill コマンドの返り値(status_code) => (1: 正常終了, 0: 異常終了)
                // if ($status_code == 0) {
                //     throw new Exception("Process kill failed. The process id is {$pid}.");
                // } else {
                //     // ProcessをKill が成功したら、「.receiver_proc」ファイルの削除
                //     if (!unlink($proc_path)) {
                //         throw new Exception("Failed to delete {$proc_path}.");
                //     }
                // }
            }
        }
        else if ($status == 1) {
            // status: 1 => 接続開始する or 接続済み & 収録中の場合は、収録停止して、ただの接続状態にする

            // 収録中の判定ファイルが存在する場合は、削除する
            if (file_exists($rec_path)) {
                if (!unlink($rec_path)) {
                    throw new Exception("Failed to delete file. {$rec_path}");
                }
            }

            // 接続中の判定ファイルがなければ、新規で作成する
            if (!file_exists($proc_path)) {

                // .receiver_proc ファイルを作成する
                $create_success = touch($proc_path);
                
                // 権限変更
                $chmod_success = chmod($proc_path, 0777);

                if (!$create_success) {
                    throw new Exception("Failed to create file. {$proc_path}");
                }

                $command = ReceiverStartCommand . $mid;
                exec($command, $py_return);
            }
        }
        else if ($status == 2) {
            // status: 2 収録開始する => 収録判定ファイルを作成する

            // 接続中なら収録判定ファイルを作成
            if (!file_exists($rec_path)) {
  
                // .rec ファイルを作成する
                $create_success = touch($rec_path);
                
                // 権限変更
                $chmod_success = chmod($rec_path, 0777);

                if (!$create_success) throw new Exception("Failed to create file. {$rec_path}");
            }
        }
        // action: change の正常系-レスポンス
        $response = [
            'result' => true,
        ];
        echo json_encode($response);
        return;
    }


    // 4. action が command なら $mid.command ファイルを作成して、そのファイルにコマンド文字列を書き込む
    if ($action == 'command') {

        // mid が欠けていたら、Error
        if (!isset($mid)) throw new Exception("mid is not set.");
        // command が欠けていたら
        if (!isset($command)) throw new Exception("command is not set.");

        $cmd_path = DataDir. $mid . '.command';

        // $mid.command ファイルを作成(ファイルあれば上書き)
        if (!file_put_contents($cmd_path, $command)) {
            throw new Exception("Failed to create file {$cmd_path}.");
        }

        // action: command の正常系-レスポンス
        $response = [
            'result' => true,
        ];
        echo json_encode($response);
        return;
    }

    // 5. action が export なら 収録ファイルを作成する Python-Script を呼びだす！
    if ($action == 'export') {

        // 新規の接続なので、Python-Script を呼び出す => Pythonの実行プログラムを呼び出す: 引数は、$mid
        // Python は $midを受け取ったら、/usr/share/uwe/receiver の receiver_procファイルにデータを出力する

        $command = ReceiverStartCommand;
        exec($command, $py_output, $result_code);

        // Python-return => ( 0: 正常判定, 0以外: 異常判定)        
        if ($result_code == 0) {
            // action: command の正常系-レスポンス
            $response = [
                'result' => true,
            ];
            echo json_encode($response);
            return;
        } else {
            // Python からの Messageをそのまま送信する
            $py_msg = $py_output[0];
            throw new Exception("{$py_msg}");
        }
    }

    // 6. pid-エンドポイント(PID)を確認する用のエンドポイント
    if ($action == 'pid') {
        exec('tasklist.exe', $output, $result_code);  

        // Pythonだけで絞り込み
        foreach ($output as $val) {
            if (!(stripos($val, 'python') === false))
            echo $val . "\n";
        }
    }

// 異常系の処理インターファイス
} catch(Exception $e) {
    $response = [
        'result' => false,
        'error' => $e->getMessage(),
    ];
    echo json_encode($response);
    return;
}


