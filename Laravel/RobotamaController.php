<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


// File-Path: /app/Http/Controllers/RobotamaController.php

class RobotamaController extends Controller
{
    public function robotama_price_list() {

        $robotama_price = [
            'ロボ玉試作1号機' => '1000円',
            'ロボ玉試作2号機' => '2000円',
            'ロボ玉試作3号機' => '3000円'
        ];

        // JSONデータとして、データを返す。
        return json_encode($robotama_price, JSON_UNESCAPED_UNICODE);
    }

    public function delete_decision($delete_id, $robotama_cost) {

        echo '受信した削除対象のIDは、'. $delete_id . "<br>" .'ProjectにかかっているCostは、'. $robotama_cost . "<br>";

        $robotama_data = [
            'robotama-1' => 'ロボ玉試作1号機',
            'robotama-2' => 'ロボ玉試作2号機',
            'robotama-3' => 'ロボ玉試作3号機'
        ];


        $robotama_id = "robotama-{$delete_id}";

        unset($robotama_data[$robotama_id]);

        $delete_at = date("Y-m-d H:i:s");

        if ($robotama_cost) {
            $msg = "コストカットのため、{$robotama_cost}円かかるロボ玉-Projectを終了しました！";
        } else {
            $msg = "ロボ玉-Projectを一部、スクラップしました！";
        }


        $response_data = [
            "msg" => $msg,
            "Robotama-Project-List" => $robotama_data,
            "delete_date" => $delete_at,
        ];

        // JSONデータとして、データを返す。
        return json_encode($response_data, JSON_UNESCAPED_UNICODE);
    }

    public function submit_robotama (Request $request) {

        // 1. Postされたjsonデータ(Request-Body)を取り出す。
        $request_data = $request->all();

        // 2. 連想配列の形になっているので、そこからデータを取り出す。
        $robotama = $request_data['robotama'];
        $purupuru = $request_data['purupuru'];        


        // 3. HTTP通信の Request-Header関連の情報を取り出す

        // Request-IPアドレスを取得する
        $ip_address = $request-> ip();

        // Request-URL を取得する
        $request_url = $request->url();

        // Request-Pathを取得する
        $request_path = $request->path();

        // HTTP-Request-Method の情報を取得する
        $request_method = $request->method();


        // 4. Postデータをもとに、処理をして返却する。
        $response_data = [
            'msg' => "{$purupuru}{$robotama}は、最高に可愛いです！",
            'request_ip' => $ip_address,
            'request_url' => $request_url,
            'request_path' => $request_path,
            'request_method' => $request_method,
        ];

        // JSONデータとして、データを返す。
        return json_encode($response_data, JSON_UNESCAPED_UNICODE);
    }



    public function dump_request_data(Request $request) {

        dump($request);
    }
}

