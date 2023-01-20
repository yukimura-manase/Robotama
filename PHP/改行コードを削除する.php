<?php

// 改行コードを削除する方法

$moji = "purpose_of_use_check\npurpose_of_use_text";

// preg_replaceで正規表現を使って、改行コードを削除する方法もある！
// $result = preg_replace("/\n|\r|\r\n/", "", $moji);

// 削除するだけなら、これでOK
$result = str_replace(array("\r\n", "\r", "\n"), "", $moji);

echo $result . "\n";
// purpose_of_use_check\npurpose_of_use_text
// purpose_of_use_check\npurpose_of_use_text

// // 改行コードを削除して、置き換える
$result_2 = str_replace(array("\r\n", "\r", "\n"), "@", $moji);

echo $result_2 . "\n";

$ex_result = explode('@', $result_2);

var_export($ex_result);


// 【PHP】改行コードを削除
// https://deep-blog.jp/engineer/php-new-lin-code-delete/

