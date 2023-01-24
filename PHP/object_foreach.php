<?php

$robotama_developer = (object)[
    'robotama-1' => 'ロボ玉試作1号機', 
    'robotama-2' =>'ロボ玉試作2号機', 
    'robotama-3' =>'ロボ玉試作3号機'
];


var_export($robotama_developer);

echo "\n";

foreach($robotama_developer as $key => $value) {
    echo "keyは{$key}, valueは{$value}" . "\n";
}


class Robotama{
    public $name = "ロボ玉";
    public $like = "ひまたね";
    private $puru = true;
    public $from = "グンマー帝国";
    private $rival = "白桃さん";
    public $cost = null;
}
 
// 2. オブジェクト(クラス)は new でインスタンス化(実体化)
$robotama = new Robotama;


foreach($robotama as $key => $value) {
    echo "keyは{$key}, valueは{$value}" . "\n";
}



