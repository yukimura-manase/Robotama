
// クラス(Class) 基本構文

// オブジェクト指向プログラミングでは、クラス はオブジェクト生成、状態(メンバ変数)の初期値の提供や振る舞いの実装(メンバ関数またはメソッド)のための拡張可能なプログラムコードテンプレートです。
// Class => 設計図: Program-Template-Code

// 実践では、ユーザや商品など、同じ種類のオブジェクトを大量に作成することがしばしばあります。

// コンストラクタ、 new 演算子 の章ですでにご存知の通り、new function はそれ場合に役立ちます。

// ですが、最新の JavaScript では、より高度な “class” 構造があり、オブジェクト指向プログラミングに役立つ優れた新機能が導入されています。

// [ “class” 構文 ]
// 基本の構文は次の通りです:

class MyClass {
  // クラスメソッド
  constructor() { console.log('Call-Constructor') };
  method1() { console.log('Call-Method1') };
  method2() { console.log('Call-Method2') };
  method3() { console.log('Call-Method3') };
}
// その後、new MyClass() で、リストされたすべてのメソッドをもつ新しいオブジェクトを作成します。

// constructor() メソッドは new により自動で呼び出され、そこでオブジェクトを初期化できます。

class Roborovski {

    constructor(name) {
      this.name = name;
    };
  
    sayHi() {
        console.log(`My name is ${this.name}`);
    };
  
};
  
// 使い方:
const robotama = new Roborovski("ロボ玉");

console.log({robotama}); // robotama: Roborovski {name: 'ロボ玉'} [[Prototype]]: Object
console.log(robotama.name); // ロボ玉
robotama.sayHi(); // My name is ロボ玉
  
  
// new Roborovski("ロボ玉") が呼び出されると:
    //   1. 新しいオブジェクトが作られます。
    //   2. 指定された引数で constructor が実行され、this.name へ代入します。

// …以降、 robotama.sayHi() のように、オブジェクトメソッドが呼び出せます。


// クラスメソッドの間にはカンマは不要です


// [ クラスとは？ ] => Class = Function

// では、class は正確に何でしょうか？これはまったく新しい言語レベルのエンティティではありません。

// 魔法を解き明かして、クラスが実際に何であるか見てみましょう。これは多くの複雑な側面を理解するのに役立ちます。

// JavaScript では、クラスは関数の一種です。

// これを見てください:

class Roborovski {
    constructor(name) {this.name = name};
    sayHi() {console.log(`My name is ${this.name}`)};
};

// 証拠: Roborovski は function です
console.log(typeof Roborovski); // function

// class Roborovski {...} 構造は実際に行っていることは以下です:

    // 1. クラス宣言の結果となる Roborovski と言う名前の関数を作成します。
        // => 関数コードは constructor メソッドです => メソッドがない場合は空と想定します。

    // 2. Roborovski.prototype に、sayHi などのクラスメソッド(Class-Method)を格納します。


// new Roborovski オブジェクトが作成された後、そのメソッドを呼び出すと、F.prototype の章で説明しように、プロトタイプから取得されます。
// 従って、オブジェクトはクラスメソッドへのアクセスを持ちます。


// class Roborovski 宣言の結果を次のように説明できます:

class Roborovski {
    constructor(name) { this.name = name; }
    sayHi() { console.log(this.name); }
}

// Class は Function
console.log(typeof Roborovski); // function

// Class = Constructor-Method (Function)
// ...あるいは, より正確には Roborovski は constructor メソッド
console.log(Roborovski === Roborovski.prototype.constructor); // true

// メソッドは Roborovski.prototype にあります e.g:
console.log(Roborovski.prototype.sayHi); // sayHi メソッドのコード => ƒ sayHi() { console.log(this.name); }

// prototype には正確には2つのメソッドがあります
console.log(Object.getOwnPropertyNames(Roborovski.prototype)); //  ['constructor', 'sayHi']



// [ 単なるシンタックスシュガー(Syntax sugar)ではありません ]

// class は “ (シンタックスシュガー) ”（新しいものは導入されていないが、より可読性が高い書き方）という人が時々います。
// 実際、class キーワードを使わずに同じものを宣言することが可能です。:

// // 純粋な関数で Roborovski クラスを書き換え

// 1. constructor 関数を作成
function Roborovski(name) {
  this.name = name;
}
// 関数 prototype は "constructor" プロパティをデフォルトで持ちます
// なので、作成は不要です

// 2. prototype へメソッドを追加
Roborovski.prototype.sayHi = function() {
    console.log(this.name);
};

// // 使い方:
const robotama = new Roborovski('ぴゅあぴゅあ-Func-Robotama');
robotama.sayHi();
// この定義の結果はほぼ同じです。
// なので、コンストラクタとそのプロトタイプメソッドを一緒に定義するための、class のシンタックスシュガーとみなされる理由はたしかにあります。

// ですが、重要な違いがあります。


// [ Class-構文の意義 ]

// 1. まず、class で生成された関数は特別な内部プロパティ(property・key) [[IsClassConstructor]]: true でラベル付けされています。

// そのため、手動で作成するのとまったく同じではありません。

// 言語は様々な箇所でそのプロパティをチェックします。

// 例えば通常の関数と違い、new で呼び出す必要があります:

class Roborovski {
  constructor() {}
}

console.log(typeof Roborovski); // function

Roborovski(); // TypeError: Class constructor Roborovski cannot be invoked without 'new'
// Error: クラスのコンストラクタ User は `new` なしで呼び出せません

// また、ほとんどの JavaScript エンジンではクラスのコンストラクタの文字列表現は、“class…” で始まります

class Roborovski {
  constructor() {}
}

console.log(Roborovski); // class User { ... }
// 他の違いもあります。この後見ていきます。


// 2. クラス メソッドは列挙不可です。
// => クラス定義は、"prototype" にあるすべてのメソッドに対して enumerable フラグを false にセットします。

// オブジェクトを for...in するとき、通常はクラスメソッドは必要ないのでこれは役立ちます。


// 3. クラスは常に use strict です クラス構造の中のコードはすべて自動で strict モードです。

// 加えて、class 構文には後で説明するような多くの機能があります。



// [ クラス表現 ]

// 関数と同じように、クラスも別の式の中で定義し、渡したり、返却したり代入することができます。

// これはクラス式の例です。:

const Roborovski = class {
    sayHi() {
        console.log("Roborovski say Hello");
    }
};
//   名前付き関数と同様、クラスも名前を持つことができます。

console.log({Roborovski});
console.log(Roborovski.prototype.sayHi()); // Roborovski say Hello
  
//   クラス式に名前がある場合、そのクラス内部でのみ見えます:


  // "名前付きクラス式"
  // (スペックにはこのような用語はありませんが、名前付き関数式と同じです)

  const Roborovski = class RoborovskiDeveloper {
    sayHi() {
        console.log(RoborovskiDeveloper); // RoborovskiDeveloper の名前はクラスの内部でのみ見えます => Scope
    }
  };
  
  
  console.log({Roborovski});
  new Roborovski().sayHi(); // 動作します, RoborovskiDeveloper の定義を表示
  
  // console.log(RoborovskiDeveloper); // ReferenceError: RoborovskiDeveloper is not defined
  // error, MyClass の名前はクラスの外からは見えません

  console.log(Roborovski.prototype.sayHi()); // RoborovskiDeveloper の定義を表示



//   次のように。クラスを動的に “要求に応じて” 作ることもできます。:
  
  function makeClass(phrase) {
    // クラス定義とその返却
    return class {
      sayHi() {
        console.log(phrase);
      }
    };
  }
  
  // 新しいクラスを作成
  const Robotama = makeClass("ロボ玉");
  
  new Robotama().sayHi(); // ロボ玉



//   [ Getters/setters ]

//   リテラルオブジェクトのように、クラスも getters/setters, 算出プロパティなどを含めることができます。
  
//   これは、get/set を使用して実装された user.name の例です:


class Roborovski {

    constructor(name) {

      // setter を呼び出す
      this.name = name;
    }
  
    get name() {
      return this._name; // _keyName = set-value
    }
  
    set name(value) {
      if (value.length < 4) {
        console.log("Name too short.");
        return;
      }
      this._name = value;
    }
  
  }
  
  let robotama = new Roborovski("ロボ・ロボ玉");
  console.log(robotama.name); // ロボ・ロボ玉
  
  robotama = new Roborovski("ロボ玉"); // Name too short.

//   技術的には、このようなクラス宣言は User.prototype に getter / setter を作成することで機能します。



//   [ 計算された名前（computed name）]

//   これは括弧 [...] を使用した計算されたメソッド名の例です。

  class Roborovski {

    ['say' + 'Hi']() {
        console.log("Hello");
    }
  
  }
  
  new Roborovski().sayHi();
//   このような特徴は、リテラルオブジェクトに似ているので、覚えやすいと思います。


// [ クラスフィールド ]
// 古いブラウザではポリフィルが必要な場合があります
// クラスフィールドは最近言語に追加されたものです。

// 以前は、クラスはメソッドだけを持っていました。

// “クラスフィールド” は任意のプロパティが追加できる構文です。

// 例えば、class User に name プロパティを追加しましょう。

class Roborovski {
  name = "ロボ玉";

  sayHi() {
    console.log(`Hello, ${this.name}!`);
  }
}

new Roborovski().sayHi(); // Hello, ロボ玉!
// つまり、宣言の中で、" = " と記述するだけです。

// クラスフィールドの重要な違いは、User.prototype ではなく、個々のオブジェクトにセットされることです。:

class Roborovski {
    name = "ロボ玉";
}

const robotama = new Roborovski();
console.log(robotama.name); // ロボ玉
console.log(Roborovski.prototype.name); // undefined


// また、より複雑な式や関数呼び出しで値を代入することもできます。:

class Roborovski {
  name = window.prompt("Name, please?", "ロボ玉");
}
// Window.prompt() => https://developer.mozilla.org/ja/docs/Web/API/Window/prompt

const robotama = new Roborovski();
console.log(robotama.name); // ロボ玉



// [ クラスフィールドでバインドされたメソッドを作成する ]

// 章 関数バインディング でデモしたように、JavaScript での関数は、動的な this を持ちます。これは呼び出しのコンテキストに依存します。

// そのため、オブジェクトメソッドが渡され、別のコンテキストで呼び出された場合、this はもうそのオブジェクトの参照ではありません。

// 例えば、このコードは undefined になります:

class Button {
  constructor(value) {
    this.value = value;
  }

  click() {
    console.log(this.value);
  }
}

const button = new Button("hello");

setTimeout(button.click, 1000); // undefined


// 問題は "this なし" で呼び出されたことです。

// 章 関数バインディング で議論したように、これを直す2つのアプローチがあります。:

// setTimeout(() => button.click(), 1000) のようにラッパー関数を渡す。
// メソッドをオブジェクトにバインドする。 e.g. コンストラクタにて。
// クラスフィールドは別の、すばらしい構文を提供します:

// class Button {
//   constructor(value) {
//     this.value = value;
//   }
//   click = () => {
//     alert(this.value);
//   }
// }

// let button = new Button("hello");

// setTimeout(button.click, 1000); // hello
// クラスフィールド click = () => {...} はオブジェクトごとに作られ、Button オブジェクトごとに別々の関数です。
// そして、this はそのオブジェクトを参照します。どこで button.click を渡しても、this は常に正しい値になります。

// これはイベントリスナーなど、ブラウザ環境で特に役立ちます。



// [ サマリ ]
// 基本のクラス構文は次のようになります。:

// class MyClass {
//   prop = value; // プロパティ

//   constructor() { // コンストラクタ
    
//   }

//   method {} // メソッド

//   get something() {} // getter
//   set something() {} // setter

//   [Symbol.iterator]() {} // 計算された名前のメソッド (ここではシンボル)
//   // ...
// }

// MyClass は技術的には関数（constructor として提供）で、メソッド、getter / setter は MyClass.prototype に記述されます。

// 次の章では、継承など他の機能を含め、クラスにてより詳しく学びます。





// < 参考・引用 >
// 1. クラス(Class) 基本構文 => https://ja.javascript.info/class


// 2.  MDN: Object.getOwnPropertyNames() => https://developer.mozilla.org/ja/docs/Web/JavaScript/Reference/Global_Objects/Object/getOwnPropertyNames

// 3. 【JavaScript】 プロパティ操作に関するObjectオブジェクトのメソッド => https://note.affi-sapo-sv.com/js-method-for-property.php#:~:text=Object.getOwnPropertyNames%E3%81%AF%E3%80%81%E3%82%AA%E3%83%96%E3%82%B8%E3%82%A7%E3%82%AF%E3%83%88%E3%81%8C,%E5%90%8D%E3%82%92%E5%8F%96%E5%BE%97%E3%81%97%E3%81%BE%E3%81%99%E3%80%82&text=Object.keys%E3%81%A8%E3%81%AE%E9%81%95%E3%81%84,%E3%81%AA%E3%81%A3%E3%81%A6%E3%81%84%E3%82%8B%E7%82%B9%E3%81%A7%E3%81%99%E3%80%82


