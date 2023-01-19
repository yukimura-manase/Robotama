<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswerInputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answer_inputs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('input_type')->unsigned()->nullable(); // 入力フォームの種類 => 必須: 1-5のいずれか
            $table->json('input_description');  // 入力フォームの説明文
            $table->json('input_option');   // 入力フォームの選択肢 => 3, 4, 5 の場合のみ



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answer_inputs');
    }
}
 
