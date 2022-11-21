<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// DB-接続用のClass
use Illuminate\Support\Facades\DB;

class MySQLController extends Controller
{
    public function robotama_list_select() {

        // MySQLとのコネクションを開いて、users テーブルからすべての情報を取得する
        $robotama_table =  DB::connection('mysql')->select('SELECT * from robotama');
    
        // 上記の処理の短縮バージョン
        $robotama_table2 = DB::select('SELECT * from robotama');

        // dump($robotama_table2);

        return json_encode($robotama_table, JSON_UNESCAPED_UNICODE);
    }

    public function robotama_insert_select($robotama_name, $country) {


        // Insert処理をする
        DB::connection('mysql')->insert("INSERT into robotama (robotama_name, country) values (?, ?)", [$robotama_name, $country]);


        $robotama_table = DB::select('SELECT * from robotama');

        return json_encode($robotama_table, JSON_UNESCAPED_UNICODE);
    }


    public function robotama_update_select(Request $request){

        
        // 1. Postされたjsonデータ(Request-Body)を取り出す。
        $request_data = $request->all();

        // 2. 連想配列の形になっているので、そこからデータを取り出す。
        $id = $request_data['id'];
        $robotama = $request_data['robotama_name'];
        $country = $request_data['country'];

        // Primery-Keyが一致するrecodeをupdateする！
        DB::update("UPDATE robotama set robotama_name = ?, country = ? where id = ?",
        [$robotama, $country, $id]);
        
        $robotama_table = DB::select('SELECT * from robotama');

        return json_encode($robotama_table, JSON_UNESCAPED_UNICODE);
    }


    public function robotama_delete_select($delete_id) {

        // 削除処理をする
        DB::delete("delete from robotama where id = ?", [$delete_id]);


        $robotama_table = DB::select('SELECT * from robotama');

        return json_encode($robotama_table, JSON_UNESCAPED_UNICODE);
    }
}
