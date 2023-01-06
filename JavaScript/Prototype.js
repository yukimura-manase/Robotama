
// [ Prototype-Base-Programming-Language ] => F.prototype => https://ja.javascript.info/function-prototype

// 思い出してください、新しいオブジェクトは new F() のように、コンストラクタ関数で生成できます。

// F.prototype がオブジェクトの場合、new 演算子は新しいオブジェクトで [[Prototype]] をセットするためにそれを使用します。

// JavaScriptは最初からプロトタイプの継承を持っています。 それは言語の中心的な特徴の1つでした。

// しかし、昔は直接アクセスすることはできませんでした。
// 確実に機能したのは、この章で説明する、コンストラクタ関数の "prototype" プロパティを使うことです。そして、それを使っているスクリプトはまだたくさんあります。

const animal = {
    eats: true
};

function Rabbit(name) {
this.name = name;
}

// Class.prototype
Rabbit.prototype = animal;

const rabbit = new Rabbit("White Rabbit"); //  rabbit.__proto__ == animal

console.log(rabbit); // Rabbit {name: 'White Rabbit'}

console.log(rabbit.__proto__); // {eats: true} => 組み込まれているもの

console.log(rabbit.animal); // undefined
console.log(rabbit.prototype); // undefined


console.log(rabbit.name); // White Rabbit
console.log(rabbit.eats ); // true


// Rabbit.prototype = animal の設定は、文字通り次のことを述べています。
    // => "new Rabbit が生成される時、その [[Prototype]] へ animal を割り当てます。"
    // すなわち、Prototype に animal を組み込むということ！

// 上記の図で、"prototype" は水平矢印で、通常のプロパティです。
// [[Prototype]] は縦矢印で、animal から rabbit の継承を意味しています。

// Rabbit.prototype = animal; => Rabbit-Class(prototype)は、animal-Objectを継承 => instance-rabbitにも、それは組み込まれている。

// [ F.prototype は new F 時にだけ使用されます ]

// F.prototype プロパティは new F が呼ばれたときにだけ使用され、新しいオブジェクトの [[Prototype]] を割り当てます。

// 作成後に、F.prototype プロパティが変更された場合（F.prototype = <別のオブジェクト>）、
// new F によって生成された新しいオブジェクトは [[Prototype]] として別のオブジェクトを持ちますが、既に存在するオブジェクトは古いものを保持したままです。



// [ デフォルトの F.prototype, constructor プロパティ ]
// すべての関数は、たとえ明示的に提供されていなくても "prototype" プロパティを持っています。

// デフォルトの "prototype" は constructor というプロパティだけを持つオブジェクトで、それは関数自体を指します。

// こんな感じです:

function Rabbit() {}

/* デフォルト prototype
    Rabbit.prototype = { constructor: Rabbit };
*/

// コードでそれを確認できます:
// デフォルトでは:
// Rabbit.prototype = { constructor: Rabbit }

console.log( Rabbit.prototype.constructor == Rabbit ); // true

console.log(Rabbit.prototype); // constructor: ƒ Rabbit() [[Prototype]]: Object

console.log(Rabbit.prototype.constructor); // ƒ Rabbit() {}


// Point: Class.prototype.constructor-Access と Instance.constructor-Access のちがい

const rabbit = new Rabbit("White Rabbit");

console.log(rabbit.constructor == Rabbit); // true
// 当然、何もしない場合、 constructor プロパティは [[Prototype]] を通じてすべての rabbit が利用できます。:


// constructor プロパティを使って既存のものと同じコンストラクタを使って新しいオブジェクトを作成することができます。

// このように:

function Rabbit(name) {
  this.name = name;
  console.log(name);
}

const rabbit = new Rabbit("White Rabbit"); // White Rabbit

console.log(rabbit); // Rabbit {name: 'White Rabbit'}

const rabbit2 = new rabbit.constructor("Black Rabbit"); // Black Rabbit

console.log(rabbit2); // Rabbit {name: 'Black Rabbit'}



// [ prototype-に対する追加・削除 ]

// JavaScript 自体は正しい "constructor" 値を保証しません。

// はい、関数のためのデフォルトの "prototype" は存在しますが、それがすべてです。その後どうなるかは私たち次第です。

// 特に、もしデフォルトプロトタイプ全体を置き換えると、その中に "constructor" はなくなります。

// 例:

function Rabbit() {}
Rabbit.prototype = {
  jumps: true
};

const rabbit = new Rabbit();
console.log(rabbit.constructor === Rabbit); // false
console.log(rabbit.jumps); // true
console.log(rabbit.constructor); // ƒ Object() { [native code] }
console.log(rabbit.prototype.constructor); // TypeError: Cannot read properties of undefined (reading 'constructor')
console.log(rabbit.prototype.constructor === Rabbit); // TypeError: Cannot read properties of undefined (reading 'constructor')

console.log(rabbit); 
// Rabbit {}[[Prototype]]: Object
    // jumps: true[[Prototype]]: Object


// したがって、正しい "constructor" を維持するためには、
// 全体を上書きする代わりに、デフォルト "prototype" に対して追加/削除を行います。:

function Rabbit() {}

// 完全に Rabbit.prototype を上書きはしません
// 単に追加するだけです

// 1. 
Rabbit.prototype.jumps = true

const rabbit = new Rabbit();
console.log(rabbit.constructor === Rabbit); // true
console.log(rabbit.jumps); // true
console.log(rabbit.constructor); // ƒ Rabbit() {}
console.log(rabbit.prototype.constructor); // TypeError: Cannot read properties of undefined (reading 'constructor')
console.log(rabbit.prototype.constructor === Rabbit); // TypeError: Cannot read properties of undefined (reading 'constructor')

// デフォルト Rabbit.prototype.constructor は保持されます


// もしくは、代替として手動で constructor プロパティを再び作ります。:
Rabbit.prototype = {
  jumps: true,
  constructor: Rabbit
};

// 追加したので、これで constructor も正しいです

// サマリ
// このチャプターでは、constructor 関数を通して作成されたオブジェクトのための [[Prototype]] を設定方法について簡単に説明しました。後で、それに依存するより高度なプログラミングパターンを見ていきます。

// すべてが非常にシンプルで、物事を明確にするための留意事項はほんの少しです。:

// F.prototype プロパティは [[Prototype]] と同じではありません。F.prototype がする唯一のことは: new F() が呼ばれたときに新しいオブジェクトの [[Prototype]] をセットすることです。
// F.prototype の値はオブジェクトまたは null でなければなりません。: 他の値では動作しません。
// "prototype" プロパティはコンストラクタ関数に設定され、new で呼び出されたときにのみ、特別な効果があります。
// 通常のオブジェクトでは、prototype は特別なものではありません。:

// let user = {
//   name: "John",
//   prototype: "Bla-bla" // no magic at all
// };
// デフォルトでは、すべての関数は F.prototype = { constructor: F } を持っているので、その "constructor" プロパティへアクセスすることで、オブジェクトの constructor を取得することができます。




// < 参考・引用 >
// 1. F.prototype => https://ja.javascript.info/function-prototype

// -------------------------------------------------------------------------------------------------------------------------------------------------

// [ Prototype-Base-Programming-Language ] => 『サバイバルTypeScript』プロトタイプベース => https://typescriptbook.jp/reference/values-types-variables/object/prototype-based-programming

// < プロトタイプベース >

    // ここではJavaScriptのプロトタイプベースの概要を説明します。
    // JavaやPHPなどでクラスを使ったことがある方や、オブジェクト指向プログラミングに触れたことがある方を念頭に書いています。
    // また、ここでは主に次の疑問に答えていきます。

        // ・プロトタイプベースとはどのような考え方なのか？
        // ・プロトタイプベースのJavaScriptは、クラスベースのPHPやJavaとどんなところが違う？
        // ・なぜJavaScriptはプロトタイプベースを採用したのか？
        // ・プロトタイプベースの利点は何か？


    // [ オブジェクトの生成 ] => Object-Oriented-Programming: オブジェクト指向プログラミング

        // オブジェクト指向プログラミング(OOP)では、オブジェクトを扱います。オブジェクトを扱う以上は、オブジェクトを生成する必要があります。
            
        // しかし、オブジェクトの生成方式は、OOPで統一的な決まりはありません。言語によって実装方法は違います。
        // ただ、生成方法は大きく分けて「クラスベース」と「プロトタイプベース」があります。


    // [ クラスベース(Class-Base)とは ] => Java, PHP, Python

        // JavaやPHP、Ruby、Pythonなどはクラスベースに分類されます。
        // クラスベースでのオブジェクト生成は、オブジェクトの設計図である「クラス」を用います。
        // クラスに対してnew演算子を用いるなどして得られるのがオブジェクトであり、クラスベースの世界では、それを「インスタンス」と呼びます。

        // たとえば、ボタンのオブジェクトがほしいときは、まずその設計図となるボタンクラスを作ります。

        class Button {
            constructor(name) {
            this.name = name;
            }
        }

        // その上で、ボタンクラスに対してnew演算子を用いると、ボタンオブジェクトが得られます。

        const dangerousButton = new Button("絶対に押すなよ?");

        // このような言語がクラスベースと言われるのは、オブジェクトの素となるのがクラスだからです。



    // [ プロトタイプベース(Prototype-Base)とは ] => JavaScript

        // 一方のJavaScriptのオブジェクト生成はプロトタイプベースです。
        // プロトタイプベースの特徴は、クラスのようなものが無いところです。
        // (あったとしてもクラスもオブジェクトの一種だったりと特別扱いされていない)

        // クラスベースではオブジェクトの素となるものは常にクラスでした。
        // プロトタイプベースには、クラスがありません。

        // では、何を素にしてオブジェクトを生成するのでしょうか。
        // 答えは、「オブジェクトを素にして新しいオブジェクトを生成する」です。

        // たとえば、JavaScriptでは既存のオブジェクトに対して、Object.create()を実行すると新しいオブジェクトが得られます。

        const button = {
            name: "ボタン",
        };
            
        const dangerousButton = Object.create(button);
        dangerousButton.name = "絶対に押すなよ？";
        // 上の例のbuttonとdangerousButtonは違うオブジェクトになります。
        // その証拠に、それぞれのnameプロパティは値が違います。

        console.log(button.name); // "ボタン"
        console.log(dangerousButton.name); // "絶対に押すなよ？"

        // 「プロトタイプ」とは日本語では「原型」のことです。
        // プロトタイプベースは単純に言ってしまえば、「原型」となるオブジェクトを素にオブジェクトを生成するアプローチなのです。



    // [ コラム: プロトタイプベースは直感的でない？ ]

        // この本の読者の多くは、PHPやJavaなどクラスベースの言語に馴染みが深いかと思います。
        // その立場からすると、プロトタイプベースは直感的でないと感じるかもしれません。
        // ところが、日常生活で私たちはプロトタイプベース的な活動をしていることがあります。
        // ここでは、プロトタイプベースが少しでも身近に感じられるよう、ちょっとした例え話をしたいと思います。

        // 仕事などで書類を作成することはないでしょうか。
        // 会議の議事録、テスト仕様書、報告書、経費精算書…。いろいろあると思います。
        // 中には定期的、または不定期に同じような書類を何度か作ることもあるでしょう。みなさんは繰り返しのペーパーワークをどうこなしていますか。

        // 準備のいい人は、雛形を作っておくことでしょう。
        // 雛形とは、いつも変わらない部分は埋めておき、毎度内容が変わる部分は空欄にした文書のことです。
        // いざ書類が必要になったときは、雛形をベースに穴埋めすれば書類ができます。

        // このやり方はクラスベースに似ています。
        // クラスはそのままでは使えませんが、インスタンス化すると使えます。
        // 書類の雛形もそのままでは提出できませんが、穴埋めすれば役立ちます。

        // 一方で、書類の準備の時間がないときや、準備のモチベーションが上がらないときは、雛形までは作らないかもしれません。
        // それでも、前回使った書類があれば、それを複製して今回必要になることに合わせて内容を加筆したり、置き換えたりして仕上げてしまうことはありませんでしょうか。

        // このアプローチはプロトタイプベースに似ています。
        // プロトタイプとなるオブジェクトはそれ自身も使えますし、それを素にした新しいオブジェクトももちろん使えます。

        // 前回使った書類はそれ自身で役に立っていますが、それを複製して作った新しい書類も役に立ちます。

        // Component-Oriented と ProtoType-Baseは似ている？


    // [ 継承 ]

        // 継承についても、クラスベースとプロトタイプベースでは違った特徴があります。

        // クラスベースでは、継承するときはextendsキーワードなどを用いてクラスからクラスを派生させ、派生クラスからオブジェクトを生成する手順を踏みます。

        // では上の手順を具体的なコードで確認してみましょう。ここにCounterクラスがあります。

        class Counter {
            constructor() {
            this.count = 0;
            }
            
            countUp() {
            this.count++;
            }
        }

        // このクラスは数とそれをカウントアップする振る舞いを持っています。
        // このCounterクラスを継承して、リセット機能を持った派生クラスは次のResettableCounterクラスになります。

        class ResettableCounter extends Counter {
            reset() {
            this.count = 0;
            }
        }
        // このResettableCounterクラスを使うには、このクラスに対してnew演算子でオブジェクトを生成します。

        counter = new ResettableCounter();
        counter.countUp();
        counter.reset();

        // 以上の例でもわかるとおり、クラスベースでの継承とオブジェクトの生成はextendsとnewと違った言語機能になっていることが多いです。


        // 一方、プロトタイプベースのJavaScriptでは、継承もオブジェクトの生成と同じプロセスで行います。

        // 次の例は、counterオブジェクトを継承したresettableCounterオブジェクトを作っています。

        const counter = {
            count: 0,
            countUp() {
            this.count++;
            },
        };
            
        const resettableCounter = Object.create(counter);
        resettableCounter.reset = function () {
            this.count = 0;
        };

        // 「継承」と言ってもプロトタイプベースでは、クラスベースのextendsのような特別な仕掛けがあるわけではなく、
        // 「既存のオブジェクトから新しいオブジェクトを作る」というプロトタイプベースの仕組みを継承に応用しているにすぎません。



// クラスベース風にも書けるJavaScript
// ここまでの説明で、クラスベースに慣れ親しんだ読者の中には「JavaScriptでオブジェクト指向プログラミングをしようとすると、随分と独特な書き方になるんだな」と思った方がいるかもしれません。
// ここで誤解して欲しくないのが、プロトタイプベースのJavaScriptでもクラスのような書き方ができるようになっていることです。

// 古いJavaScriptには確かにクラスの構文がなく独特の書き方がありましたが、ES2015にclassやextends構文が導入されたため、
// 近年のJavaScriptではクラスベース風の書き方が容易にできるようになっています。
// なので、クラスベースの他言語から来た開発者にも、JavaScriptコードは理解しやすいものになってきています。

//次のコードはクラスベースの説明の際に提示したものですが、実はこれはJavaScriptでした。

class Counter {
    constructor() {
    this.count = 0;
    }
    
    countUp() {
    this.count++;
    }
}
// class構文が使える近年のJavaScript開発では、Object.createを多用したり、無理にプロトタイプベースを意識したコードにする必要もそうそう無いので心配しないでください。
// ただ、class構文があると言っても、JavaScriptがクラスベースに転向したのではなく、クラスベース風の書き方ができるにすぎません。
// かくいうclass構文もプロトタイプベースの仕組みの上に成り立っており、JavaScriptのオブジェクトモデルはプロトタイプベースなので、この点は頭の片隅に入れておく必要があります。


// [ なぜJavaScriptはプロトタイプベースなのか？ ]

// JavaScriptの開発にあたり、Selfという言語の影響があったとEich氏は言います。
// Selfは1990年に発表されたプロトタイプベースのオブジェクト指向言語です。
// Selfの発表論文に掲げられたタイトルは「The Power of Simplicity」つまり「シンプルさの力」です。
// Selfはクラスを用いたオブジェクト指向プログラミングよりも、プロトタイプベースのほうが言語が単純化されると同時に柔軟になると主張しました。
// Selfはクラスだけでなく、関数と値の区別や、メソッドとフィールドの区別も撤廃したシンプルさを追求した言語です。
// 言語は単純になると、言語の説明も簡単になり学びやすくもなります。
// シンプルにするために継承やクラスを諦めたかというとそうではなく、逆に柔軟さが生まれるので、クラスのようなものや継承もプロトタイプを応用すれば実現できるとSelfは主張しています。

// これはあくまでSelfの意見でJavaScriptが明言したわけではありませんが、歴史の文脈から読み取るに、JavaScriptもSelfの考え方に共感してプロトタイプベースを採用したのは明らかです。
// JavaScriptのプロトタイプベース採用の背景には、言語をシンプルで柔軟なものにしたいという考えが根底にあったわけです。

// JavaScriptがプロトタイプベースを採用したことで、実際に柔軟なプログラミングが行えるようになっています。
// その一例として、プロトタイプを応用してクラス風のオブジェクト指向を実現するイディオムが生まれ、
// それがclass構文として言語仕様に取り込まれたり、プロトタイプをプログラマが拡張することで古い実行環境でも最新バージョンのJavaScriptのメソッドが使えるようにするポリフィルが誕生してきました。


// [ まとめ ]

// 1. クラスベースは、クラスをもとに新しいオブジェクトを生成するスタイル。JavaやPHPなどが該当。
// 2. プロトタイプベースは、既存のオブジェクトから新しいオブジェクトを生成するスタイル。JavaScriptが該当。
// 3. プロトタイプベースでの継承は、特別な操作ではなく、オブジェクト生成とまったく同じプロセスである。
// 4. JavaScriptでもclass構文を使えばクラスベース風のプログラミングが可能。
// 5. JavaScriptがプロトタイプベースを採用したのは、言語をシンプルで柔軟なものにするのが狙い。


// < 参考・引用 >
// 1. 『サバイバルTypeScript』プロトタイプベース => https://typescriptbook.jp/reference/values-types-variables/object/prototype-based-programming
