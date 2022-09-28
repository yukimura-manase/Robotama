<?php

// phpのforeachを使用してループ処理をしている際に、条件によってループを抜けたり（中断）、
// スキップさせたい場合があります。

// その場合は、breakとcontinueを使用すれば、処理を中断させたりスキップさせることができます。

// 他にもfor、while、do-while、switchでも使用可能です。



// 1. ループ処理を抜ける（中断）「break」=> 強制終了🔥

// breakを使用すれば、ループ処理を途中で終了させることができます。

$robotama_array = ['ロボ玉試作1号機', 'ロボ玉試作2号機', 'ロボ玉試作3号機'];


foreach($robotama_array as $robotama) {

    if ($robotama == 'ロボ玉試作2号機') {
        break;
    }
    echo $robotama."\n";
}
// < 実行結果 >
// ロボ玉試作1号機


// 2. ループ処理をスキップ「continue」

// continueを使用すれば、ループ処理をスキップさせることができます。

foreach($robotama_array as $robotama) {

    if ($robotama == 'ロボ玉試作2号機') {
        continue;
    }
    echo $robotama."\n";
}
// < 実行結果 >
// ロボ玉試作1号機
// ロボ玉試作3号機



// [ 参考・引用 ]

// PHP：foreachのループを抜ける方法、又はスキップ
// http://raining.bear-life.com/php/foreach%E3%81%AE%E3%83%AB%E3%83%BC%E3%83%97%E3%82%92%E6%8A%9C%E3%81%91%E3%82%8B%E6%96%B9%E6%B3%95%E3%80%81%E5%8F%88%E3%81%AF%E3%82%B9%E3%82%AD%E3%83%83%E3%83%97



