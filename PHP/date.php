<?php

// < PHPの時間操作まとめ🔥 >


// < PHPで日付関数を使いこなす（date, strtotime）>

// 1. date関数

// date関数は引数を1つ（or2つ）持てる

//     第1引数：フォーマット（string）
//     第2引数：タイムスタンプ（int）

//     引数1つの時：「現在の時刻」を「指定したフォーマット」で出力
//     引数2つの時：「第2引数のタイムスタンプ」を「指定したフォーマット」で出力

//     戻り値はstring


//     date_default_timezone_set('Asia/Tokyo');：まずタイムゾーンの設定をすること。
        
//     Y：年（4桁表記）
//     y：年（2桁表記）
//     m：月（2桁表記）
//     n：月（先頭にゼロつけない）
//     d：日（2桁表記）
//     H：時間（24時間単位）
//     h：時間（12時間単位）
//     i：分
//     s：秒
//     t：指定した月の日数
//     w：曜日番号（0[日曜]から6[土曜]の値）
//     .：文字列連結
//     \n：改行


// 2. strtotime関数

// strtotime関数は引数を1つ（or 2つ）持てる

//     第1引数：日時（string）。相対日時や絶対日時を指定可能。
//     第2引数：タイムスタンプ（int）

//     引数1つの時：「現在」を基準とした、「第1引数の日時」のタイムスタンプを出力
//     引数2つの時：「第2引数のタイムスタンプ」を基準とした、「第1引数の日時」のタイムスタンプを出力
    
//     戻り値はint



// < 参考・引用🔥 >

// PHPで日付関数を使いこなす（date, strtotime）
// https://qiita.com/shuntaro_tamura/items/b7908e6db527e1543837



// < PHP 日時フォーマット >

    // フォーマット	内容	出力結果(例)
    // Y	西暦(4桁)	2017
    // y	西暦(2桁)	17
    // l	うるう年: 1、平年: 0	0
    // m	月(0埋め)	08
    // n	月(0埋め無し)	8
    // M	月 英語表記	August
    // F	月 英語表記(略)	Aug
    // d	日付(0埋め)	08
    // j	日付(0埋め無し)	8
    // l	曜日 英語表記	Monday
    // D	曜日 英語表記(略)	Mon
    // w	曜日 (日曜: 0 → 土: 6)	1
    // H	時刻 24時間表記 (0埋め)	09
    // G	時刻 24時間表記 (0埋め無し)	9
    // h	時刻 12時間表記 (0埋め)	09
    // g	時刻 12時間表記 (0埋め無し)	9
    // i	分	02
    // s	秒	02


// < 参考・引用🔥 >

// phpで現在日時を取得する方法！
// https://blog.codecamp.jp/php-datetime


// ----------------------------------------------------------------------------------------------------------------------------------------

// [ 1. 基本的な時間操作 ]

// タイムゾーンを指定する
date_default_timezone_set('Asia/Tokyo');


// 1. 現在系統の時間を取得するパターン

// 現在の年を取得する
$nowyear = date("Y");
echo $nowyear . "\n";
// 2022

// 現在の「年/月/日」を取得する
$date = date("Y/m/d");
echo $date . "\n";
// 2022/12/15

// 現在の「時:分:秒」を取得する
$hms = date("H:i:s");
echo $hms . "\n";
// 

// 現在の「日時」(年月日時分秒)を取得する
$nowTime = date("Y-m-d H:i:s");
echo $nowTime . "\n";


// 指定した日時のタイムスタンプを取得する => 過去・未来系のタイムスタンプを取得する

$pass_timestamp = strtotime("2018-04-01");
$pass_date = date("Y-m-d H:i:s", $pass_timestamp);

echo '過去の日付' . "\n";
echo $pass_timestamp . "\n";
echo $pass_date . "\n";

// 過去の日付
// 1522508400
// 2018-04-01 00:00:00


$future_timestamp = strtotime("2025-04-01");
$future_date = date("Y-m-d H:i:s", $future_timestamp);

echo '未来の日付' . "\n";
echo $future_timestamp . "\n";
echo $future_date . "\n";

// 未来の日付
// 1743433200
// 2025-04-01 00:00:00



$now_timestamp = strtotime('now');
$now_date = date("Y-m-d H:i:s", $now_timestamp);

echo '現在の日付' . "\n";
echo $now_timestamp . "\n";
echo $now_date . "\n";
// 現在の日付
// 1671091366
// 2022-12-15 17:02:46



echo '現在から1日後のタイムスタンプを取得する' . "\n";
echo date('Y/m/d H:i:s',strtotime("+1 day")) . "\n";


$before_day = 5;

echo '現在から5日前の日付を取得する' . "\n";
echo date("Y-m-d H:i:s", strtotime("-$before_day day")) . "\n";


echo '現在から1週間後のタイムスタンプ' . "\n";
echo date('Y/m/d H:i:s',strtotime("+1 week")) . "\n";


echo '現在から1カ月後のタイムスタンプ' . "\n";
echo date('Y/m/d H:i:s',strtotime("+1 month")) . "\n";


echo '現在から+1秒、+2分、+3時間、+4日、+5カ月、+6年のタイムスタンプ' . "\n";
echo date('Y/m/d H:i:s',strtotime("+1 seconds +2 min +3 hours +4 day +5 month +6 year")) . "\n";

echo '次の木曜日のタイムスタンプ' . "\n";
echo date('Y/m/d H:i:s',strtotime("next Thursday")) . "\n";


echo '前の月曜日のタイムスタンプ' .  "\n";
echo date('Y/m/d H:i:s',strtotime("last Monday")) . "\n";

echo '--------------------------------------------------------------' . "\n";



// あたりまえですが、時間の比較計算のためには、タイムスタンプ(数値化)する必要があります。


$pass_timestamp = strtotime("2018-04-01");
$now_timestamp = strtotime('now');
$future_timestamp = strtotime("2025-04-01");


var_dump($pass_timestamp <= $now_timestamp);
// bool(true)

var_dump($future_timestamp <= $pass_timestamp);
// bool(false)

var_dump(($pass_timestamp <= $now_timestamp) && ($now_timestamp <= $future_timestamp));
// bool(true)


// < 指定した日時のタイムスタンプを取得する >


    // 文字列の日時からタイムスタンプを取得する
    // strtotime関数に文字列で日付を渡すと、その時刻のタイムスタンプを取得することができます。

    // コード例
    // strtotime("2018-01-25");
    // 出力結果
    // int(1516806000)
    // 取得したタイムスタンプはdate関数などで簡単に特定のフォーマットで表示することができます。

    // コード例
    // // 日付からタイムスタンプを取得
    // $timestamp = strtotime("2018-01-25");

    // // 指定したフォーマットで出力
    // echo date("Y-m-d H:i:s", $timestamp);
    // 出力結果
    // 2018-01-25 00:00:00




    // 使用できる時刻フォーマット
    // strtotime関数では時刻の文字列をタイムスタンプに変換するに当たって、特定のフォーマットである必要があります。

    // コード例
    // // OK
    // $timestamp = strtotime("2018-01-25");
    // $timestamp = strtotime("2018-01-25 01:15:00");
    // $timestamp = strtotime("2018/1/25 01:15:00");
    // $timestamp = strtotime("2018-Jan-20 01:15:00");

    // // NG
    // $timestamp = strtotime("2018.01.25 01:15:00");
    // $timestamp = strtotime("2018年01月25日 01:15:00");



    // 指定した日時のタイムスタンプを取得する
    // https://gray-code.com/php/get-the-timestamp-from-specify-time/



// ----------------------------------------------------------------------------------------------------------------------------------------


// [ 2. 休日の判定 => Ver. 土日の判定(曜日の判定) ]

// 曜日配列
$dayofweek_array = [
    '日', //0
    '月', //1
    '火', //2
    '水', //3
    '木', //4
    '金', //5
    '土', //6
];

// 曜日ごとの番号を取得する！ => 
$dayofweek_num = date('w');

echo $dayofweek_num . "\n";
// 4

//日本語で曜日を出力
echo $dayofweek_array[$dayofweek_num] . '曜日' . "\n";
// 木曜日

$rest_date_flag = false;

// 0(日曜)か6(土曜)なら休日判定
if($dayofweek_num == 0 || $dayofweek_num == 6){

    echo "休みやん！" . "\n";
    $rest_date_flag = true;
};

$isHoliday = $rest_date_flag ? 'true' : 'false';

echo "休みフラグ: {$isHoliday}" . "\n";
// 休みフラグ: false

// ----------------------------------------------------------------------------------------------------------------------------------------

// [ 3. 深夜の判定 ]

// 深夜の定義を何時から何時にするかによる、、、 => ひとまず0時から4時ぐらいまでを深夜として判定する！

// 時間の比較(数値の比較)をする必要があるため、タイムスタンプを

// [ 4パータンの時刻の表記方法がある！ ]
// H	時刻 24時間表記 (0あり)	08
// G	時刻 24時間表記 (0無し)	8
// h	時刻 12時間表記 (0あり)	08
// g	時刻 12時間表記 (0無し)	8

// 時間の表記は、どれを採用するか？

$nowtime = date("H:i:s");   // H	時刻 24時間表記 (0-埋め)	09
$num_nowtime = strtotime($nowtime);

echo $nowtime . "\n";     
echo "数値化: $num_nowtime" . "\n";
// 15:38:50
// 数値化: 1671086330


$midnight_start = date("22:00:00");
$num_midnight_start = strtotime($midnight_start);

echo($midnight_start). "\n";
echo("数値化: $num_midnight_start"). "\n";
// 22:00:00
// 数値化: 1671109200

$midnight_finish = date("05:00:00");
$num_midnight_finish = strtotime($midnight_finish);
echo($midnight_finish). "\n";
echo("数値化: $num_midnight_finish"). "\n";
// 05:00:00
// 数値化: 1671048000


// "00:00:00" < nowtime < "04:00:00"
$midnight_flag = ($num_midnight_start <= $num_nowtime &&  $num_nowtime <= $num_midnight_finish) ? true : false;


if($midnight_flag) echo("深夜やん！"). "\n";
else echo("深夜じゃないよ！"). "\n";
// 深夜じゃないよ！  





// < 参考・引用🔥 >


// 1. PHP-Manual: date
// https://www.php.net/manual/ja/function.date.php


// 2. PHP-Manual: strtotime
// https://www.php.net/manual/ja/function.strtotime.php



// 3. PHP タイムスタンプの取得と日時の取得
// https://wepicks.net/phpsample-date-timest_now/



// ----------------------------------------------------------------------------------------------------------------------------------------








