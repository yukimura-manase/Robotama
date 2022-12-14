<?php

// PHP の真偽値判定の一覧

$dataSet = [ true, false, null, 0, 1, 0.1, 1.1,  "0", "1", '', 'robotama', [], [0], (object)[], (object)['robotama'=>'ロボ玉'] ];
foreach($dataSet as $val) {
    
    var_export($val);
    echo ' の真偽値判定: ';
    var_dump((bool) $val);
    echo "\n";
}

// [ 実行結果 ]
// true の真偽値判定: bool(true)

// false の真偽値判定: bool(false)

// NULL の真偽値判定: bool(false)

// 0 の真偽値判定: bool(false)

// 1 の真偽値判定: bool(true)

// 0.1 の真偽値判定: bool(true)

// 1.1 の真偽値判定: bool(true)

// '0' の真偽値判定: bool(false)

// '1' の真偽値判定: bool(true)

// '' の真偽値判定: bool(false)

// 'robotama' の真偽値判定: bool(true)     

// array (
// ) の真偽値判定: bool(false)

// array (
//   0 => 0,
// ) の真偽値判定: bool(true)

// (object) array(
// ) の真偽値判定: bool(true)

// (object) array(
//    'robotama' => 'ロボ玉',
// ) の真偽値判定: bool(true)



// false な値 => false, null, 0, '0', '', [] の6つ

// false判定な値は、false, null, 0, '0', '', [] の6つになります。






