
// TypeScriptで関数の型を定義する(型定義)



// 1. 関数に直接、定義するパターン

// 1-1. function(関数宣言)の場合
function helloFunc (name: string): void {
    console.log(`${name}なのだ！`);
}


// 1-2. アロー関数(関数式)の場合
const helloArrowFunc = (name: string): void => console.log(`${name}なのだ！`);



// 2. typeエイリアスを使って、関数の型を定義するパターン

// 【 完全記法: メソッド構文 】

// JavaScript では、関数はObjectであるため、このように表現する。
// (引数の型): 戻り値の型; を {}の中に記述する
type HelloFuncType1 = {
    (name: string): void;
};

const helloRobotama1: HelloFuncType1 = (name: string) => console.log(`${name}なのだ！`);


// 【 省略記法: アロー関数構文 】
// (引数の型) => 戻り値の型の形式で記述する
type HelloFuncType2 = (name: string) => void;

const helloRobotama2: HelloFuncType2 = (name: string) => console.log(`${name}なのだ！`);



//　アロー関数構文のほうが短くシンプルなので、アロー関数構文で型宣言する方がおすすめです！


// 関数から関数の型を抽出して、宣言する

type TypeArrowFunc = typeof helloArrowFunc;

// [ 抽出結果 ]
// type TypeArrowFunc = (name: string) => void



// 関数のGenerics(ジェネリクス)・型定義

function ParameterTypeJudg <Type> (param: Type): void {
    console.log(`Parameterの型は、${typeof param}`);
}

type GenericsFunc = <Type>(param: Type) => void;

const ParameterTypeJudg2: GenericsFunc = param => console.log(`Parameterの型は、${typeof param}`);






// 参考・引用

// 1. TypeScriptで関数の型定義を書く方法まとめ
// https://qiita.com/NeGI1009/items/a98c6a76b0c4f3bc18b3


// 2. 関数の型の宣言 (function type declaration)
// https://typescriptbook.jp/reference/functions/function-type-declaration


