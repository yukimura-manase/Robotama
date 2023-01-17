
// < PHPで連想配列やObjectのキーに変数名を設定する方法 >


// 1. 連想配列のキーに変数名を設定する

// 設定したい変数名を文字列として、用意しておく！
$Gunmar = 'Gunmar';

$from_array = [
    'Tokyo' => '東京',
    'Saitama' => 'さいたま共和国',
];

$from_array[$Gunmar] = '神聖グンマー帝国';

var_export($from_array);
echo "\n";


// 2. Objectのキーに変数名を設定する
$from = 'from';

$robotama = new stdClass();

$robotama->id = 1;
$robotama->name = 'ロボ玉試作1号機';

$robotama->$from = 'Gunmar';

var_export($robotama);
echo "\n";


echo $from_array[$robotama->$from] . "\n";

// $robotama = new stdClass();

// foreach ($key_list as $key) {
//    $robotama->$key  
// }

