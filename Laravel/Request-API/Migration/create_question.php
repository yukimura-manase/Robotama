<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 質問設定のテーブル
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id'); // 自動採番のID
            $table->boolean('required_flag')->default(true); // 回答必須フラグ => 必須, Default: true
            $table->string('question_text');  // 質問文
            $table->integer('sort_order'); // 並び順
            $table->json('input_id_list'); // 質問文に紐づいている、入力フォームのリスト
            $table->boolean('none_display')->default(false); // 非表示フラグ => Default: false(表示する)
            $table->string('created_user');  // 作成ユーザー
            $table->string('updated_user');  // 更新ユーザー
            $table->string('deleted_user');  // 削除ユーザー
            $table->timestamps();  // created_at と updated_at が作成
            $table->softDeletes(); // deleted_at が作成
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
