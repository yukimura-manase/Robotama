<?php

// PHPで空配列の判定をする3つの方法


// 配列 & 空配列以外ならば、実行する
// if (is_array($array) && !($array == false) ) {
//     echo('配列だが空配列ではないので、処理を実行する') . "\n";
// } else if (is_array($array)) {
//     echo('空配列です');
// } else {
//     echo('配列以外のデータです');
// }

// if (is_array($array) && count($array) !== 0 ) {
//     echo('配列だが空配列ではないので、処理を実行する');

// } else if (is_array($array)) {
//     echo('空配列です');
// } else {
//     echo('配列以外のデータです');
// }


// if (is_array($array) && empty($array)) {
//     echo('空配列です') . "\n";
// } else if (is_array($array)) {
//     echo('配列だが空配列ではないので、処理を実行する') . "\n";
// } else {
//     echo('配列以外のデータです') . "\n";
// }


$array_list = [ [], ['robotama'], (object)[]];

foreach ($array_list as $array) {
        
    // 配列 & 空配列以外ならば、実行する
    if (is_array($array) && !($array == false) ) {
        echo('配列だが空配列ではないので、処理を実行する') . "\n";
    } else if (is_array($array)) {
        echo('空配列です') . "\n";
    } else {
        echo('配列以外のデータです') . "\n";
    }

    if (is_array($array) && count($array) !== 0 ) {
        echo('配列だが空配列ではないので、処理を実行する') . "\n";

    } else if (is_array($array)) {
        echo('空配列です') . "\n";
    } else {
        echo('配列以外のデータです') . "\n";
    }

    if (is_array($array) && empty($array)) {
        echo('空配列です') . "\n";
    } else if (is_array($array)) {
        echo('配列だが空配列ではないので、処理を実行する') . "\n";
    } else {
        echo('配列以外のデータです') . "\n";
    }
}




