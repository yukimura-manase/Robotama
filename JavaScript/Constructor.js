
// < constructor(コンストラクタ)関数 と new 演算子 >

// 通常の {...} 構文では、1つのオブジェクトを作成できます。しかし、複数のユーザやメニューアイテムなど、似たようなオブジェクトを多数作成する必要がある場合もあります。

// このようなことは、コンストラクタ関数と "new" 演算子を使うことで実現できます。

// [ コンストラクタ 関数 ]
// コンストラクタ関数は技術的には通常の関数です。それには2つの慣習があります:

// 1. 名前は大文字で始めます。
// 2. "new" 演算子を使ってのみ実行されるべきです。

// Constructor-Function
function PrototypeRobotama(...params) { // 可変長引数
    this.name = params[0];
    this.isAdmin = params[1];
}

console.log(typeof PrototypeRobotama); // function

const robotama = new PrototypeRobotama('ロボ玉試作1号機', true);

console.log(robotama.name); // ロボ玉試作1号機
console.log(robotama.isAdmin); // false

console.log(robotama); // PrototypeRobotama {name: 'ロボ玉試作1号機', isAdmin: true}

console.log(typeof robotama); // object
console.log(robotama instanceof PrototypeRobotama); // true
console.log(robotama instanceof Object); // true


const robotama2 = new PrototypeRobotama('ロボ玉試作2号機', false);

console.log(robotama2.name); // ロボ玉試作2号機
console.log(robotama2.isAdmin); // false


// new 演算子を用いて関数が実行された場合、次のような処理が行われます:

// 1. 新しい空のオブジェクトが作成され、 this に割り当てられます。
// 2. 関数本体を実行します。通常は新しいプロパティを追加することで this に変更を加えます。
// 3. this の値が返されます。

// つまり、new PrototypeRobotama(...) は次のようなことを行います:

function PrototypeRobotama(...params) {
    // this = {};  (暗黙)

    // this へプロパティを追加
    this.name = params[0];
    this.isAdmin = params[1];

    // return this;  (暗黙)
}

// したがって、const robotama = new PrototypeRobotama('ロボ玉試作1号機', true) は、以下と同じ結果となります:

const robotama = {
    name: "ロボ玉試作1号機",
    isAdmin: true
};

// もし他のユーザを作りたいのであれば、new User("Ann")、new User("Alice") と言ったように呼び出すことができます。
// 毎回リテラルを使うよりはるかに短く、また読みやすくなります。
// 再利用可能なオブジェクト作成のコードを実装すること、それがコンストラクタの主な目的です。


// 改めて留意しておきましょう。技術的にはどのような関数（this を持たないアロー関数を除く）でもコンストラクタとして使用できます。

// つまり、どの関数も new で実行することができ、上記のアルゴリズムが実行されることになります。
// “先頭が大文字” というのは、関数が new で実行されることを明確にするための共通の合意です。


// [ new function() { … } ] => new 無名関数
// 1つの複雑なオブジェクトを作成するためのコードがたくさんある場合、次のように即座に呼び出されるコンストラクタ関数でラップすることができます:

// 1. new function() { … } で 即時-Constructor-呼び出し => カプセル化される。
const user = new function(age) {
  this.name = "John";
  this.isAdmin = false;
  this.age = age;

  if(new.target) console.log('Instance化されました'); // 「 Instance化されました 」が即時呼び出しされる。

  // ...ユーザ作成のための他のコード。
  // 複雑なロジック、文
  // ローカル変数などを持つかもしれません。
};

console.log(user); // {name: 'John', isAdmin: false}

// new function() { … } 記法によって、カプセル化されている。
const newUser = new user(12); // TypeError: user is not a constructor
  

// このコンストラクタはどこにも保存されておらず、単に作って呼び出されただけなので再び呼び出すことはできません。
// したがってこのトリックは、将来の再利用は考えず、単一のオブジェクトを構成するコードをカプセル化することを目的としています。

// コンストラクタの呼び出しモードの確認: new.target 
// Constructor-Functionの中では、new.target という特別なプロパティを使うことで、new を使って呼び出されたのかそうでないのかを確認することができます。



// [ コンストラクタからの返却 ]
// 通常、コンストラクタは return 文を持ちません。
// コンストラクタの仕事は、必要なものをすべて this の中に書き込むことであり、this が自動的に戻り値となります。

// しかし、return 文がある場合のルールはシンプルです:

// もし return がオブジェクトと一緒に呼ばれた場合、this の代わりにオブジェクトが返されます。
// もし return がプリミティブと一緒に呼ばれた場合、それは無視されます。
// 言い換えると、オブエジェクトのreturn はそのオブジェクトを返し、それ以外のケースでは this が返されます。

// 例えば、ここで return はオブジェクトと共に呼ばれているため、this より優先してこのオブジェクトが返されます:

// 実行結果は、「 this 」 or 「 return object 」
function Roborovski (){
    this.name = 'ロボ玉';
    
    return { name: 'ロボロフスキー'}; // こちらが優先されて、this-Setは、返されない。
}

console.log(Roborovski()); // {name: 'ロボロフスキー'}


// Methodを仕込む
function RoborovskiGreeting (){
    this.name = 'ロボ玉';
    this.hello = () => {console.log(`${this.name}なのだ！`)};
}

const roborovski = new RoborovskiGreeting();

roborovski.hello(); // ロボ玉なのだ！




// [ サマリ ]
// 1. コンストラクタ関数（もしくは簡潔にコンストラクタ）は通常の関数ですが、大文字から始まる名前を持つと言う共通の合意があります。
// 2. コンストラクタ関数は new を使ってのみ呼び出されるべきです。この呼び出しは、最初に空の this を作成し、必要な処理が行われた this を最後に返すことを意味します。
// 3. 複数の似たようなオブジェクトを作るために、コンストラクタ関数を使うことができます。

// JavaScript には、日付を表す Date や集合を表す Set、そしてこのあと私たちが学ぶ予定のものなど、多くの組み込みオブジェクトに対するコンストラクタ関数が用意されています。


// < 参考・引用 >
// 1. コンストラクタ、 new 演算子 => https://ja.javascript.info/constructor-new
// 2. MDN: new 演算子 => https://developer.mozilla.org/ja/docs/Web/JavaScript/Reference/Operators/new




