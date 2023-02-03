<?php
setlocale(LC_ALL, 'ja_JP.UTF-8');

const DataDir = '/usr/share/uwe/data/receiver/';
const LogDir = '/usr/share/uwe/log/';

const PythonExePath = '/mnt/c/python/python.exe';
const ReceiverSrcPath = 'C:/Users/Admin/UWE/program/Reciver/DataRegister.py';
const ExporterSrcPath = 'C:/Users/Admin/UWE/program/Reciver/DataExport.py';

// Warning-Level は、Log-File にOutputする
function WarningLog ($log_msg) {
    if (!file_exists(LogDir)) {
        mkdir(LogDir);
        chmod(LogDir, 0777);
    }
    $ts = date("Y/m/d H:i:s");
    // すでにファイルが存在する場合は追記
    $log_path = LogDir . basename(__FILE__, ".php") . ".log";
    file_put_contents($log_path, "{$ts} {$log_msg}\n", FILE_APPEND);
}


function ActionGet($mid) {
    // ['mid' => (int)$mid, 'status' => 0|1|2]
    // status: 0=未接続, 1=接続中, 2=接続 & 収録中
    $result = [];

    if (isset($mid)) {
        //// 管理ID(mid)ありパターン
        $is_con = file_exists(DataDir . "{$mid}.connect");
        $is_rec = file_exists(DataDir . "{$mid}.rec");
        $status = $is_con ? ($is_rec ? 2 : 1) : 0;
        array_push($result, ['mid' => (int)$mid, 'status' => $status]);

    } else {
        //// 管理ID(mid)なしパターン

        // status = 0 は省略可
        // MEMO: PHPで空配列は false な値なので注意！
        $con_path_list = glob(DataDir. '*.connect');
        if (!is_array($con_path_list)) throw new Exception("glob *.connect error." . DataDir);

        $rec_path_list = glob(DataDir. '*.rec');
        if (!is_array($rec_path_list)) throw new Exception("glob *.rec error." . DataDir);

        // 差分比較などのため、mid(拡張子を除外してファイル名)だけを格納するList
        $con_name_list = [];
        $rec_name_list = [];
        foreach ($con_path_list as $path) array_push($con_name_list, basename($path, ".connect"));
        foreach ($rec_path_list as $path) array_push($rec_name_list, basename($path, ".rec"));

        // 接続 & 収録中状態
        foreach (array_intersect($con_name_list, $rec_name_list) as $mid) {
            array_push($result, ['mid' => (int)$mid, 'status' => 2]);
        }
        // 接続 only
        foreach (array_diff($con_name_list, $rec_name_list) as $mid) {
            array_push($result, ['mid' => (int)$mid, 'status' => 1]);
        }
    }
    return $result;
}


function ActionChange($mid, $status) {
    // mid or status が欠けていたら、Error
    if (!isset($mid) || !isset($status)) throw new Exception("action change: status is not set.");

    // status: 0 => 未接続状態にする(接続状態なら切断＋収録状態なら停止)
    // status: 1 => 接続状態にする(収録状態なら収録停止、未接続なら接続)
    // status: 2 => 収録状態にする(接続状態なら収録判定ファイルを作成する)

    // 参照パス生成
    $cmd_path = DataDir . "{$mid}.command";
    $con_path = DataDir . "{$mid}.connect";
    $rec_path = DataDir . "{$mid}.rec";
    $end_path = DataDir . "{$mid}.end";

    if ($status == 0)  {
        // 未接続状態にする
        if (!file_exists($end_path)) {
            if (!touch($end_path)) {
                throw new Exception("Failed to create file. {$end_path}");
            }
            chmod($end_path, 0666);
        }
        if (file_exists($rec_path)) {
            if (!unlink($rec_path)) {
                WarningLog("Failed to delete {$rec_path}.");
            }
        }

        if (file_exists($con_path)) {
            for ($i = 0; $i < 5; $i++) {
                sleep(1);
                if (!file_exists($con_path)) {
                    break;
                }
            }
        }
    }
    else if ($status == 1) {
        // 接続状態にする(収録状態なら収録停止、未接続なら接続)
        if (file_exists($rec_path)) {
            if (!unlink($rec_path)) {
                throw new Exception("Failed to delete file. {$rec_path}");
            }
        }

        if (!file_exists($con_path)) {
            // 接続前に不要なファイルを削除
            if (file_exists($end_path)) {
                if (!unlink($end_path)) {
                    WarningLog("Failed to delete {$end_path}.");
                }
            }
            if (file_exists($cmd_path)) {
                if (!unlink($cmd_path)) {
                    WarningLog("Failed to delete {$cmd_path}.");
                }
            }

            // 接続 (Receiver Start)
            $command = sprintf('%s %s %s >/dev/null 2>&1 &', PythonExePath, ReceiverSrcPath, $mid);
            exec($command, $py_output, $py_return);
            // throw new Exception("command:{$command}, py_output:{$py_output[0]}, py_return:{$py_return}");
            // 戻り値は取れないので、Receiver.py で $con_path を生成してもらう。あれば接続 OKと判断
            for ($i = 0; $i < 5; $i++) {
                sleep(1);
                if (file_exists($con_path)) {
                    break;
                }
            }
        }
    }
    else if ($status == 2) {
        // 収録状態にする(接続状態なら収録判定ファイルを作成する)
        if (!file_exists($rec_path)) {
            if (!touch($rec_path)) {
                throw new Exception("Failed to create file. {$rec_path}");
            }
            chmod($rec_path, 0666);
        }
    } else {
        throw new Exception("Invalid change status number.");
    }
}


function ActionCommand($mid, $command) {
    if (!isset($mid) || !isset($command)) throw new Exception("action command: mid or command is not set.");

    $cmd_path = DataDir . "{$mid}.command";
    if (!file_put_contents($cmd_path, $command)) {
        throw new Exception("Failed to file_put_contents. {$cmd_path}");
    }
    chmod($cmd_path, 0666);
}

////////////////////////////////////////////////////////////////////////
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

    if (isset($mid)) {
        $mid = sprintf('%03d', $mid);
    }

    // 1. Action が Setされているかどうかの Check Check
    if (!isset($action)) {
        throw new Exception("Action is not set.");
    }

    if (!file_exists(DataDir)) {
        mkdir(DataDir);
        chmod(DataDir, 0777);
    }

    // 2. Action が get なら {mid: 管理ID: status: 0|!|2} の Listを返却する
    if ($action == 'get') {
        $response = ['result' => true, 'list' => ActionGet($mid)];
        echo json_encode($response);
        return;
    }

    // 3. Action が change なら 接続の ON/OFF or 収録の ON/OFF などの状態を変更させる
    if ($action == 'change') {
        ActionChange($mid, $status);
        $response = ['result' => true];
        echo json_encode($response);
        return;
    }


    // 4. action が command なら $mid.command ファイルを作成して、そのファイルにコマンド文字列を書き込む
    if ($action == 'command') {
        ActionCommand($mid, $command);
        $response = ['result' => true];
        echo json_encode($response);
        return;
    }

    // 5. action が export なら 収録ファイルを作成する Python-Script を呼びだす！
    if ($action == 'export') {
        $command = sprintf('%s %s %s', PythonExePath, ExporterSrcPath);
        exec($command, $py_output, $py_return);
        if ($py_return == 0) {
            $response = ['result' => true];
            echo json_encode($response);
            return;
        } else {
            // Python からの Messageをそのまま送信する
            $py_msg = $py_output[0] ? $py_output[0] : "Unknown error. return={$py_return}";
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
    $response = ['result' => false, 'error' => $e->getMessage()];
    echo json_encode($response);
    return;
}


