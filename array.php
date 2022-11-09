
<?php


// 1. PHP の 配列の作り方 => array() と [] の 2通りある！



// php array.phpで ファイル実行

// 1. [] で配列を作成するパターン
$array = ['ロボ玉試作1号機', 'ロボ玉試作2号機', 'ロボ玉試作3号機'];

// 2. array() で配列を作成するパターン
$array2 = array('ロボ玉試作1号機', 'ロボ玉試作2号機', 'ロボ玉試作3号機');


// 配列からデータを取得する => Array[key]

// key は index => indexを指定して値を取り出す。
echo $array[0]."\n";
    // ロボ玉試作1号機

echo '型: ' . gettype($array)."\n";
    // 型: array

// 配列の末尾に値を追加する Ver. array_push
array_push($array, 'Gunmar-Robotama');

// 配列の末尾に値を追加する Ver. Array[]
$array2[] = 'Neo-Robotama';


// 配列の値を更新(Update)する
$array2[0] = 'ロボ玉0号機 (ProtoTypeZero)';



var_export($array);
echo "\n";
// array (
//     0 => 'ロボ玉試作1号機',  
//     1 => 'ロボ玉試作2号機',  
//     2 => 'ロボ玉試作3号機',  
//     3 => 'Gunmar-Robotama',  
//   )

var_export($array2);
echo "\n";

// array (
//     0 => 'ロボ玉0号機 (ProtoTypeZero)',
//     1 => 'ロボ玉試作2号機',  
//     2 => 'ロボ玉試作3号機',  
//     3 => 'Neo-Robotama',     
// )




// [ 配列から特定の要素を削除する ]


// 1. Indexを指定して削除する

// 切り取られた値(返り値・実行結果) = array_splice(削除対象配列, 切り取り開始Index, 切り取り数);

$target = ['ロボ玉試作1号機', 'ロボ玉試作2号機', 'ロボ玉試作3号機'];

// 削除実行
$split = array_splice($target, 1, 1);

// 削除結果
var_export($target);
echo "\n";

// 実行結果・返り値 => 切り取った値
var_export($split);
echo "\n";

$target2 = ['ロボ玉試作1号機', 'ロボ玉試作2号機', 'ロボ玉試作3号機'];

//削除実行
unset($target2[1]);

//実行結果
//indexの1を削除したため、indexが連番でなくなっている!
var_export($target2);
echo "\n";

//indexを詰める
$target2 = array_values($target2);

//indexの欠番が詰められて連番になった
var_export($target2);
echo "\n";


// 2つのやり方の比較

    // 複数削除する場合にarray_splice()で削除を行うと、削除とIndexを詰める作業が同時に発生するため処理が重くなる。
    // unset();でまとめて削除した後に、array_valuesでIndexをすべて詰める方が処理が早くなる。



// 2. 要素(value)を直接指定して削除する

// array_diff();
// array_values();

// index値ではなく、要素そのものを指定して値の削除を行う
// 削除後に、indexを詰める作業が必要
// array_diffは第１引数の配列と第２引数以降の配列と比較し、 第１引数の要素の中で他の配列には存在しないものだけを返す。


$target3 = ['Robotama','ロボ玉試作1号機', 'ロボ玉試作2号機', 'ロボ玉試作3号機', 'Robo-Ball'];

//削除実行
$result = array_diff($target3, ['Robotama', 'ロボ玉試作2号機']);

//indexを詰める
$result = array_values($result);

//削除結果
var_export($result);
echo "\n";






// 2. 多次元配列
$multi_array = [
    ['ロボ玉試作1号機', 01],
    ['ロボ玉試作2号機', 02],
    ['ロボ玉試作3号機', 03],
];

var_export($multi_array);
echo "\n";

// array (
//     0 =>
//     array (
//       0 => 'ロボ玉試作1号機',
//       1 => 1,
//     ),
//     1 =>
//     array (
//       0 => 'ロボ玉試作2号機',
//       1 => 2,
//     ),
//     2 =>
//     array (
//       0 => 'ロボ玉試作3号機',
//       1 => 3,
//     ),
// )



echo '型: ' . gettype($multi_array)."\n";
    // 型: array


echo "foreachでループして中の値を取り出す" ."\n";

foreach ($multi_array as $index => $array) {
    foreach($array as $index2 => $val) {
        echo "{$index}-{$index2}: {$val}" . "\n";
    }
}

// 3. 連想配列
$associative_array = [
    "Robotama-1"  => "Tokyo",
    "Robotama-2"  => "Saitama", 
    "Robotama-3" => "Gunmar", 
];

// key名を指定して、値を取り出す。
echo $associative_array["Robotama-1"] . "\n";


// 連想配列の値を削除する
unset($associative_array['Robotama-1']);

// 連想配列にデータを追加する
$associative_array['Robotama-4'] = 'Kanagawa';

// 連想配列のデータをUpdateする
$associative_array['Robotama-2'] = '飛んで埼玉';


var_export($associative_array);
echo "\n";

echo '型: ' . gettype($associative_array)."\n";
    // 型: array


echo "foreachでループして中の値を取り出す" ."\n";

foreach ($associative_array as $key => $val) {
    echo "{$key} の値は、{$val}" . "\n";
}






// PHPで配列から特定の要素を削除する
// https://qiita.com/Quantum/items/767dba44af81d1825248


// array_values
// https://www.php.net/manual/ja/function.array-values.php







