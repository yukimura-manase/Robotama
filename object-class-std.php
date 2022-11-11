<?php

// < PHP における Objectの使い方 stdClassとは？ Objectから配列への変換なども解説 >

// ----------------------------------------------------------------------------------------------------------------------------------

// < PHP の オブジェクト型(object) について >




    // 1. オブジェクト とは プログラミング手法の概念

        // オブジェクト とは プログラミング手法の概念

        // オブジェクトとは、所謂 プログラミング手法 や 概念 ことです。
        
        // オブジェクト指向プログラミングでは、「デバック」「保守メンテナンス」「コードの再利用」などを容易にし、「モジュール化」された設計が出来るように考えられています。
        
        // モジュール化とは、1つの複雑なシステムを、相互依存の強いソースコードで構成するのではなく、コードの規格化・標準化を進め、追加や交換が可能な独立した機能を持つコード同士で構成することです。
        
        // PHPでは オブジェクト指向プログラミング(OOP) をサポートしています。
    

    // 2. PHP のオブジェクト型 の種類は 複合型

        // オブジェクト型 はデータ構造と処理系が合わさったデータ型です。

        // オブジェクト型 はデータ構造（プロパティ） と 処理系（メソッド） が合わさっています。


    
    // 3. オブジェクトへの変換

        // オブジェクト以外の型がオブジェクト型に変換(Cast)される場合、stdClass というPHPで予め定義されている ビルトインクラス のインスタンスが新規で生成されます。
        
        // その際、値が NULL の場合は新しいインスタンスは空になります。


        // 配列 が オブジェクト に変換される場合、配列の キー と 値 がそれぞれ オブジェクト の プロパティ名 と 値 になります。
        
        // PHP7.2.0より以前のバージョンでは、数値の key (index番号など) の場合 プロパティ名 で値にアクセスすることはできませんでした。



    // 4. オブジェクトを作成する

        // オブジェクトを作成するには最初に「クラス」を定義します。
        
        // 一度クラスを定義し、「new」 キーワードを使用して、オブジェクトを作成します。
        
        // オブジェクトはいくつでも作成することができます。オブジェクトの プロパティ や メソッド にアクセスする際は「->」を使用します。


        echo '空のObjectを作成する🔥' . "\n";

        echo json_encode(new stdClass()) . "\n"; // {}

            

    // 5. オブジェクトであるか調べる
    
        // オブジェクト型 のチェックは is_object() 関数 で行います！

        // ある値がオブジェクトかどうか調べるには is_object()関数 を使用します。オブジェクト型 であれば 論理値 true を返し、そうでなければ false を返します。

   
        $stdObject = new stdClass();
        if(is_object($stdObject) === TRUE) echo "オブジェクト型です。\n";
        // オブジェクト型です。

        $object = new DateTime();
        echo is_object($object) ? "オブジェクト型です。\n" : "オブジェクト型ではありません。\n";
        // オブジェクト型です。
        
        $object = array();
        echo is_object($object) ? "オブジェクト型です。\n" : "オブジェクト型ではありません。\n";
        // オブジェクト型ではありません。


    
        
        // < 参考・引用 >
        
        // PHP の オブジェクト型(object) について
        // https://wepicks.net/phpref-objecttype/#page-datatype
        
// ----------------------------------------------------------------------------------------------------------------------------------



// 1. Objectの元となる class を作成する
class Robotama{
    public $name = "ロボ玉";
    public $like = "ひまたね";
    public $from = "グンマー帝国";
    public $cost = null;
}
 
// オブジェクト(クラス)は new でインスタンス化(実体化)
$robotama = new Robotama;

// 型を確認
echo gettype($robotama)."\n";
// [ 実行結果 ] 
// object

 
// インスタンス(実体)の中身を表示 => 構造を確認
var_export($robotama);
echo "\n";

// [ 実行結果 ] 
// Robotama::__set_state(array(
//     'name' => 'ロボ玉',
//     'like' => 'ひまたね',
//     'from' => 'グンマー帝国',
//     'cost' => NULL,
//  ))




// PHPでのオブジェクトへのアクセス

// $object->id のような形でアクセス

// オブジェクト -> プロパティ名

// オブジェクト(インスタンス)の Data(value) は「 -> 」で key名を指定して、呼び出す
echo $robotama->like . "\n";
// [ 実行結果 ] 
// ひまたね


// 2. property_exists で プロパティ・key名の存在確認ができる

    // < PHP オブジェクト プロパティの存在確認 >

    // property_exists(object|string $object_or_class, string $property): bool

    // パラメータ ¶
    // object_or_class
    // 確認するクラス名、もしくはクラスのオブジェクト(インスタンス)を指定します。

    // property
    // プロパティ名を指定します。

    // 戻り値 ¶
    // プロパティが存在している場合は true、存在していない場合に false、 エラー時には null を返します。

echo 'property_exists() で property の存在チェック！' . "\n";

echo property_exists($robotama, 'from');
echo "\n";
// [ 実行結果 ] 
// 1

echo property_exists($robotama, 'robotama_flag'); 
echo "\n";
// [ 実行結果 ] 
// (falseなので何も表示されない！)


echo 'isset() で、null-Check🔥' . "\n";


function NullChecker ($object ,$key) {
    if (isset($object->$key)) {
        echo "{$key} は、{$object->$key}" . "\n";
    } else {
        echo "{$key} は、null" . "\n";
    }
}


echo 'NullChecker-Fire🔥'. "\n";

NullChecker($robotama, 'cost');
// [ 実行結果 ] 
// cost は、null


NullChecker($robotama, 'name');
// [ 実行結果 ] 
// name は、ロボ玉



echo 'is_null() でも null-Check ができる🔥' . "\n";

if (is_null($robotama->cost)) {
    echo '値はNullです' . "\n";
} else {
    echo 'Null以外の値です' . "\n";
}

// [ 実行結果 ] 
// 値はNullです


// < 参考・引用🔥 >
// PHP-Manual: property_exists
// https://www.php.net/manual/ja/function.property-exists.php






// 2. stdClass を呼び出す🔥


$obj = new stdClass(); // stdClassのオブジェクト

$obj->val1 = 123; // key&valueを追加
$obj->val2 = 'ロボ玉試作1号機🔥';

echo $obj->val1 . "\n"; //123
echo $obj->val2 . "\n"; // ロボ玉試作1号機🔥






// Object-Arrayの作成🔥


// < PHP でクラスオブジェクトの配列を作成する >

// [ 目次 ]
// 1. PHP でクラスオブジェクトの配列を作成する
// 2. PHP で stdClass オブジェクトの配列を作成する
// 3. PHP の array() 関数を使用してオブジェクトの配列を作成する

// この記事では、PHP でオブジェクトの配列を作成する方法を紹介します。



// PHP でオブジェクトの配列を作成する
// https://www.delftstack.com/ja/howto/php/php-array-of-objects/

// ----------------------------------------------------------------------------------------------------------------------------------

// [ Array を Castして、Objectを作成するPattern-2選 ]

// < 【PHP】オブジェクト形式のデータを作成する方法 >

//     恥ずかしながら連想配列とオブジェクトを同じものと勘違いしておりました。

//     ということで、ちゃんと理解しろという自戒の念も込めまして、オブジェクト形式データの作成方法をポストしておきます。


// [ 1. PHPでオブジェクト形式データを作成する ]

// 連想配列 と Objectは違います！ => 注意点🔥

// 作り方-1. 配列を作成してから、オブジェクト形式へ変換(Cast)する

$robotama2 = (object) [
    'name'   => 'ロボ玉試作2号機🔥',
    'from' => 'さいたまー共和国',
    'power'   => 2000,
    'weapon' => 'ロボ玉-バズーカー',
    'robotama_flag'=> true
];

echo 'name: ' . $robotama2->name . "\n"; // name: ロボ玉試作2号機🔥
echo 'from: ' . $robotama2->from . "\n"; // from: さいたまー共和国

// 上記内容ですと、$robotama2->name でアクセス可能。

// Object の key-アクセスは、「 -> 」


// インスタンス(実体)の中身を表示 => 構造を確認
var_export($robotama2);
echo "\n";
// [ 実行結果 ]
// (object) array(
//     'name' => 'ロボ玉試作2号機🔥',
//     'from' => 'さいたまー共和国',
//     'power' => 2000,
//     'weapon' => 'ロボ玉-バズーカー',
//     'robotama_flag' => true,
//  )


// [ 2. 各々作成したオブジェクトを、配列化する ]

// Laravelの学習内でも触れましたが、以下の作成方法でループ用のデータを作成できます。

$userList = [
    (object) ['id'=> 1, 'name'=> 'ロボ玉'], 
    (object) ['id'=> 2, 'name'=> 'ロボ・ボール'], 
    (object) ['id'=> 3, 'name'=> 'ロボ玉試作1号機🔥'], 
    (object) ['id'=> 4, 'name'=> '白桃'], 
    (object) ['id'=> 5, 'name'=> 'ももちゃん'], 
    (object) ['id'=> 6, 'name'=> 'ロボ玉試作2号機🔥'],
];

foreach ($userList as $user) {
    echo $user->id . '. ';  // ID
    echo $user->name;       // 名前
    echo "\n";
}
// < 実行結果 >
// 1. ロボ玉
// 2. ロボ・ボール
// 3. ロボ玉試作1号機🔥
// 4. 白桃
// 5. ももちゃん
// 6. ロボ玉試作2号機🔥


// インスタンス(実体)の中身を表示 => 構造を確認
var_export($userList);
echo "\n";
// [ 実行結果 ]
// array (
//     0 => 
//     (object) array(
//        'id' => 1,
//        'name' => 'ロボ玉',
//     ),
//     1 => 
//     (object) array(
//        'id' => 2,
//        'name' => 'ロボ・ボール',
//     ),
//     2 => 
//     (object) array(
//        'id' => 3,
//        'name' => 'ロボ玉試作1号機🔥',
//     ),
//     3 => 
//     (object) array(
//        'id' => 4,
//        'name' => '白桃',
//     ),
//     4 => 
//     (object) array(
//        'id' => 5,
//        'name' => 'ももちゃん',
//     ),
//     5 => 
//     (object) array(
//        'id' => 6,
//        'name' => 'ロボ玉試作2号機🔥',
//     ),
//   )
  


// < 参考・引用 >

// 【PHP】オブジェクト形式のデータを作成する方法
// https://nodoame.net/archives/10729


// ----------------------------------------------------------------------------------------------------------------------------------


// < 【PHP】stdClassについて >


// [ PHP-Manual ] => クラスの基礎: http://php.net/manual/ja/language.oop5.basic.php

// stdClass is the default PHP object. 
// stdClass has no properties, methods or parent. 
// It does not support magic methods, and implements no interfaces.

// When you cast a scalar or array as Object, you get an instance of stdClass. 
// You can use stdClass whenever you need a generic object instance.


// stdClass is NOT a base class! 
// PHP classes do not automatically inherit from any class. 
// All classes are standalone, unless they explicitly extend another class. 
// PHP differs from many object-oriented languages in this respect.


// You cannot define a class named 'stdClass' in your code. 
// That name is already used by the system. 
// You can define a class named 'Object'.

// You could define a class that extends stdClass, but you would get no benefit, as stdClass does nothing.


// [ 翻訳🔥 ]

// stdClass はデフォルトの PHP オブジェクトです。
// stdClass には、プロパティ、メソッド、または親がありません。
// 魔法のメソッドをサポートしておらず、インターフェイスを実装していません。

// スカラーまたは配列を Object としてキャストすると、stdClass のインスタンスが取得されます。
// 汎用オブジェクト インスタンスが必要な場合はいつでも stdClass を使用できます。


// stdClass は基底クラスではありません!
// PHP クラスは、どのクラスからも自動的に継承されません。
// 別のクラスを明示的に拡張しない限り、すべてのクラスはスタンドアロンです。
// この点で、PHP は多くのオブジェクト指向言語とは異なります。


// コードで「stdClass」という名前のクラスを定義することはできません。
// その名前はシステムによって既に使用されています。
// 「Object」という名前のクラスを定義できます。

// stdClass を拡張するクラスを定義することもできますが、stdClass は何もしないため、メリットはありません。


// [ 要点まとめ🔥 ]

    // 1. stdClassとは
    // 2. PHPデフォルトのクラス
    // 3. 親クラスなどは無い
    // 4. プロパティが無い
    // 5. メソッドが無い
    // 6. マジックメソッドが無い
    // 7. インターフェイスが無い



    // stdClassの stdとは？ => 「Standard」(標準)の略


    // stdClassとは
    // stdClass = プロパティやメソッドを一切持たない標準クラス

    // [ 特徴 ]
    // 普通のクラスのようにnewを用いて使用

    

    // 他の型からオブジェクト型にキャストを行うとstdClassのインスタンスになる

    // オブジェクト以外の型の値がオブジェクトに変換される時には、stdClass というビルトインクラス
    // （予めPHPの内部で定義されているクラス）のインスタンスが新しく生成されます。
    


    $obj = new stdClass();
    $obj->hoge = 'hoge';

    // 配列で結果を返す代わりにstdClassを返す


    // 配列の場合
    $cat= [];
    $cat['name'] = 'Hakutou';
    echo $cat['name'];
    echo "\n";

    // stdClassの場合
    $cat2= new stdClass();
    $cat2->name= 'Momo';
    echo $cat2->name;
    echo "\n";


    // 配列ではなくオブジェクト形式でデータを保存したいときに使用。
    // オブジェクトにすることで、$obj->hoge のような形で記述可能に




// < stdClassのオブジェクトを作る方法 >


    // データベースから取ってくるデータがstdClassの配列だったりします。

    // そのstdClassの配列を処理するコードを作ったりします。

    // コードを作るとPHPUnitでテストしたりします。

    // そうすると期待値や引数がstdClassだったりします。

    // するとstdClassのオブジェクトを作らねばなりません。


    // 方法1. 配列をオブジェクトでキャストする


    // 方法2. new \stdClassをして1つ1つ設定する




// < 参考・引用 >

// 【PHP】stdClassについて
// https://qiita.com/shintarou-akao/items/7455c1a4eb7b9e85faf8


// 連想Keyを使ったArrayの代わりにstdClassを利用する
// https://qiita.com/onomame/items/be2261c6eb566edab030



// stdClassのオブジェクトを作る方法
// https://qiita.com/ponsuke0531/items/e6ffbdf76c41f58cf254







