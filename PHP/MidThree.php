<?php

// 文字列の要素数・長さを取得する方法


// strlen — 文字列の長さを得る
// strlen(string $string): int


// 必ず3桁に調整するためのSampleCode

$str = '111';

$str = '0';

echo strlen($str) . "\n";

$str_length = strlen($str);

echo $str_length . "\n";
echo gettype($str_length) . "\n";
// integer

// 必ず3桁に調整する
if ($str_length <= 2) {
    // echo '3桁以下です';

    $add_zero = 3 - $str_length;
    // echo $add_zero . "\n";
    
    for ($count = 0; $count < $add_zero; $count++){
        $str = 0 . $str;
        // echo $str . "\n";
    }
}


// midを必ず3桁に調整する
function MidThree ($mid) {
    $mid_length = strlen($mid);
    if ($mid_length <= 2) {
        $add_zero = 3 - $mid_length;
        for ($count = 0; $count < $add_zero; $count++){
            $mid = '0' . $mid;
        }
    }
    return $mid;
}




