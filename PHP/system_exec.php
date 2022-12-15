<?php

// system() と exec() の違いとは？

// exec()とsystem()は似ている関数（外部コマンドを実行するという点ではまったく同じ）ですが、

// exec() は引数に指定したコマンドを実行結果を出力せず、system() はコマンドの実行結果を出力するという点が違います。

// コマンドの実行結果をPHP側で出力するかどうか？ が、使い分けの判断基準になりそうです。


// 1. system() では、実行したコマンドの実行結果がデフォルトで出力される

// Linuxコマンド "ls" の全ての結果を出力し、出力の最後の
// 行を $last_line に格納します。Linuxコマンドの戻り値は
// $retval に格納されます。

// echo 'ls コマンドの出力 Ver. system()' . "\n";
// // ls コマンドの出力 Ver. system()

// $last_line = system('ls -al', $result_code);
// // total 56
// // drw-rw-rw-   2 robotama 0     0 2022-12-14 16:08 .
// // dr--r--r--  23 robotama 0 49152 2022-12-15 10:02 ..
// // -rw-rw-rw-   1 robotama 0  1235 2022-12-14 16:05 boolean.php    
// // -rw-rw-rw-   1 robotama 0  2148 2022-12-15 15:01 exec_system.php

// echo 'system(ls -al) コマンド実行後の出力' . "\n";

// // 戻り値: 成功時はコマンド出力の最後の行を返し、失敗時は false を返します。
// echo $last_line . "\n";
// // -rw-rw-rw-   1 robotama 0  2148 2022-12-15 15:01 exec_system.php

// // 引数 result_code が存在する場合、 実行したコマンドの返すステータスがこの変数に書かれます。
// echo $result_code . "\n";
// // 0


// [ php exec_system.php コマンドの実行結果 ]
// ls コマンドの出力 Ver. system()
// total 56
// drw-rw-rw-   2 robotama 0     0 2022-12-14 16:08 .
// dr--r--r--  23 robotama 0 49152 2022-12-15 10:02 ..
// -rw-rw-rw-   1 robotama 0  1235 2022-12-14 16:05 boolean.php    
// -rw-rw-rw-   1 robotama 0  2148 2022-12-15 15:01 exec_system.php
// system(ls -al) コマンド実行後の出力
// -rw-rw-rw-   1 robotama 0  2148 2022-12-15 15:01 exec_system.php
// 0



echo 'ls コマンドの出力 Ver. exec()' . "\n";

$last_line = exec('ls -al', $output, $exec_result_code);

// 戻り値: 成功時はコマンド出力の最後の行を返し、失敗時は false を返します。
echo $last_line . "\n";
// -rw-rw-rw-   1 robotama 0  3017 2022-12-15 15:08 exec_system.php

// 引数 result_code が存在する場合、 実行したコマンドの返すステータスがこの変数に書かれます。
echo $exec_result_code . "\n";
// 0

echo 'exec(ls -al) コマンドの実行結果を出力' . "\n";

var_export($output);
// array (
//   0 => 'total 56',
//   1 => 'drw-rw-rw-   2 robotama 0     0 2022-12-14 16:08 .',
//   2 => 'dr--r--r--  23 robotama 0 49152 2022-12-15 10:02 ..',
//   3 => '-rw-rw-rw-   1 robotama 0  1235 2022-12-14 16:05 boolean.php',    
//   4 => '-rw-rw-rw-   1 robotama 0  3017 2022-12-15 15:08 exec_system.php',
// )


foreach ($output as $val) {
    echo $val . "\n";
}
// total 56
// drw-rw-rw-   2 robotama 0     0 2022-12-14 16:08 .
// dr--r--r--  23 robotama 0 49152 2022-12-15 10:02 ..
// -rw-rw-rw-   1 robotama 0  1235 2022-12-14 16:05 boolean.php
// -rw-rw-rw-   1 robotama 0  3017 2022-12-15 15:08 exec_system.php



// [ php exec_system.php コマンドの実行結果 ]
// ls コマンドの出力 Ver. exec()
// -rw-rw-rw-   1 robotama 0  3017 2022-12-15 15:08 exec_system.php
// 0
// exec(ls -al) コマンドの実行結果を出力
// array (
//   0 => 'total 56',
//   1 => 'drw-rw-rw-   2 robotama 0     0 2022-12-14 16:08 .',
//   2 => 'dr--r--r--  23 robotama 0 49152 2022-12-15 10:02 ..',
//   3 => '-rw-rw-rw-   1 robotama 0  1235 2022-12-14 16:05 boolean.php',    
//   4 => '-rw-rw-rw-   1 robotama 0  3017 2022-12-15 15:08 exec_system.php',
// )
// total 56
// drw-rw-rw-   2 robotama 0     0 2022-12-14 16:08 .
// dr--r--r--  23 robotama 0 49152 2022-12-15 10:02 ..
// -rw-rw-rw-   1 robotama 0  1235 2022-12-14 16:05 boolean.php
// -rw-rw-rw-   1 robotama 0  3017 2022-12-15 15:08 exec_system.php



// < 参考・引用🔥 >

// 1. 外部コマンドを実行 - exec()、system()
// https://webkaru.net/php/function-exec-system/

// 2. PHP-Manual: exec
// https://www.php.net/manual/ja/function.exec.php

// 3. PHP-Manual: system
// https://www.php.net/manual/ja/function.system.php















