<?php

// PHP 特定の文字列が含まれているかを調べる方法

$moji_list = ['group@ロボ玉', 'ロボ玉試作1号機', 'ロボ玉試作2号機', 'ロボ玉試作3号機', 'group@猫', '白桃さん', 'ももちゃん'];

echo 'strpos() Time'. "\n";

    // needle が見つかった位置を、 haystack 文字列の先頭 (offset の値とは無関係) からの相対位置で返します。 文字列の開始位置は 0 であり、1 ではないことに注意しましょう。

    // needle が見つからない場合は false を返します。

foreach ($moji_list as $moji) {

    // NG-パターン
    // if (strpos($moji, 'group@') == false)  echo 'なし' . "\n";
    // else echo 'あり' . "\n";

    // 厳密-Checkにしないと、整数の「0」がfalseに変換されてしまいます・・・
    if (strpos($moji, 'group@') === false)  echo 'なし' . "\n";
    else echo 'あり' . "\n";
}

echo 'preg_match() Time'. "\n";

foreach ($moji_list as $moji) {

    if (preg_match('/group@/', $moji))  echo 'あり' . "\n";
    else echo 'なし' . "\n";
}


// preg_match() は、pattern が指定した subject にマッチした場合に 1 を返します。 マッチしなかった場合は 0 を返します。 失敗した場合に false を返します

