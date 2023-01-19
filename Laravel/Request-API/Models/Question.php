<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';

    // プライマリキー(主キーカラム名がidの場合は記述の必要なし)
    // protected $primaryKey = 'id';

    // fillable => 更新可能カラムを設定する
    protected $fillable = [
        'required_flag',
        'question_text',
        'sort_order',
        'input_id_list',
        'none_display',
        'created_user',
        'updated_user',
        'deleted_user',
    ];

    // hiddenはModelを使って取得する際に一覧として出力させない列。
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    // castsは出力する際にstringではなくそれぞれの型に変換してから取得する。
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];
    

    // user_idに一致するデータを取得
    public static function getData($id) {
        return self::where('id', $id)->get();
    }


    // データを整形して出力
    public function format() {
        return 'ID:' . $this->id . ' 本文:' . $this->message;
    }


    // LaravelのMigrationでテーブルを作成して、モデルでテーブル操作する流れ
    // https://yama-itech.net/laravel-migration-model-start


}


