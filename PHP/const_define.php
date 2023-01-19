<?php


// < constとdefineの違い >


// 以下３つの違いがあります。

    // constはif文や関数の中では使えない
    // defineではグローバルスコープに値が配置される
    // constは名前空間内に配置される


// constの例
const MAX_QUANTITY = 0.1;

// defineの例
define('MAX_QUANTITY2', 0.1);

// if文や関数の中ではconstが使えないので、defineを使うことになります。

// defined()を使うことで、二度定義することを防ぐことができます。

if(!defined('MAX_QUANTITY3')) {
    define('MAX_QUANTITY3', 0.1);
  }



// 【PHP】定数の使い方とconstとdefineの違い
// https://devsakaso.com/php-const-define/




// どちらも定数を定義するときに使用する

define('DEFINE_1', 'defineで定義した定数');
const CONST_1 = 'constで定義した定数';

echo DEFINE_1;
// defineで定義した定数
echo CONST_1;
// constで定義した定数


// 1. 関数と構文

    // define は関数
    // const は構文

    // define は関数の呼び出しのオーバーヘッドがあるため 遅い
    // const は関数じゃないから 速い



// 2. 変数や、関数の戻り値を使えるか使えないか

    // define は変数や、関数の戻り値を使える

    // const は変数や、関数の戻り値を使えない


$robotama = 'ロボ玉';

define('ROBOTAMA', $robotama);
echo ROBOTAMA; // 適当な変数


// $robotama_1 = 'ロボ玉試作1号機';
// const ROBOTAMA_1 = $robotama_1; // Error



// 3. トップレベル以外で使えるか使えないか

// const は if や for function の中では使えない => トップレベルでしか使えない。

if (true) {
    define('MY_CONST', 'defineはifの中でも使える');
}

if (true) {
    // const MY_CONST = 'constは構文エラーになる';
    // PHP Parse error:  syntax error, unexpected 'const' (T_CONST) in ...
}



// 4. クラス定数


class Example
{
    public define('MY_CONST', 'defineは関数だから構文エラーになる');
}



class Example
{
    public const MY_CONST = 'クラス定数を定義するときに使う';
}

echo Example::MY_CONST;



// 5. 名前空間

    // const は名前空間上に登録される
    // define はグローバルに登録される


namespace My {
    define('MY_CONST', 'defineで定義した定数');
    const MY_CONST = 'constで定義した定数';
}

namespace Example {
    echo MY_CONST; // defineで定義した定数
    echo \My\MY_CONST; // constで定義した定数
}



    // クラス定数を定義するときは const を使用するといい

    // define は実行時じゃないと何が入っているか分からないしグローバル汚染になるので const がおすすめ



// PHPの「define」と「const」の違い
// https://qiita.com/schrosis/items/485b984e05b2eb4521b4


// PHPの定数定義 const と define() の違い【PHP入門】
// https://footloose-engineer.com/blog/2021/12/24/php-var-const-define/





// 【PHP】constとdefine()で定義した定数の違いについて
//  https://toku1.jp/programming-php-constant/








