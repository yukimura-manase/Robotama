
// [ JavaScript async/await を使って、Promiseをより簡単に使っていく🔥 ]


// [ 1. async ]

// return new Promise((resolve, reject) => { ・・・} ) を省略した記法 => 『async』

// asyncを関数の宣言の前に付けると、その関数は必ずPromiseを返します。

// すなわち、呼び出して結果を取得するためには必ず関数().then(result=>{ ... })を使うようになります。


// asyncは非同期関数を定義する関数宣言であり、関数の頭につけることで、Promiseオブジェクトを返す関数にすることができます。

// そのような関数をasync functionといいます。


// 普通の関数
const Robotama = () => {
    return 'Robotama';
};

const result = Robotama();
console.log(result);
// Robotama

// async で「非同期関数」を定義する => 必ずPromiseを返します。
const AsyncRobotama = async () => {
    return 'AsyncRobotama';
}

// 
AsyncRobotama()
    .then( result => {
        console.log(result);
    });

// < 実行結果 >
// AsyncRobotama

// Promise {<fulfilled>: undefined}
    // [[Prototype]]: Promise
    // [[PromiseState]] : "fulfilled"
    // [[PromiseResult]]: undefined



// < 重要-Point >
// async関数でPromise以外の値を返した場合は、「その値でresolveされるPromiseが返る」ようになります。

// この挙動はどこかで見覚えがあります。そう、Promise.then(result=>{ ... })の ...部分と同じです！


// もちろん、async関数で今まで通りの方法でPromiseを返すこともできます。

const AsyncRobotama2 = async () => {
    return new Promise((resolve, reject) => {
      resolve('AsyncRobotama2');
    });
  }

AsyncRobotama2().then(result => {
    console.log(result);
});


// Promiseを返すために、いちいち「 new Promise() 」をしなくて、よくなったのでCodeがより簡潔になります。



// [ 2. await ] => Promiseが返ってくるのを待つ (fullfilled になるのを待つ)🔥

// await で Promise が返ってくるのを待ち受ける🔥

// Promise.then(result=>{ ... }) を省略した記法 => 『await』

// async関数の中で使用することで、Promiseが来るのを待機する

// async を付けた関数の中では、await Promise が Promise.then(result=>{ ... }) を簡略化した書き方として使えるようになります。

// async 関数の中ではないトップレベル等の場所ではこの書き方はできないので注意しましょう。


//   awaitは、Promiseオブジェクトが値を返すのを待つ演算子です。

//   ルール: awaitは必ず、async function内で使います。

// await で「then()を省力する」



// async で「非同期関数」を定義する => 必ずPromiseを返します。
const AsyncRobotama3 = async () => {
    return 'AsyncRobotama3';
}

const DevlopRobotama = async () => {
    // await で「then()を省力する」
    const result = await AsyncRobotama3();
    console.log(result);
}

DevlopRobotama();

// [ 実行結果 ]
// AsyncRobotama3
// Promise {<fulfilled>: undefined}



// await の登場により、Promise.then()のチェインが通常の同期処理の流れと同じように書くことができるようになります。


// delayミリ秒待機する。任意の第二引数を結果として返す。
const Sleep = async (delay, result) => {
    return new Promise(resolve => {
        setTimeout(() => resolve(result), delay);
    });
};

const Exec = async () => {
    Sleep(1000)
        .then(() => console.log(1))
        .then(() => Sleep(2000, '2秒・待機'))
        .then((result) => console.log(result));
};

Exec();


// delayミリ秒待機する。任意の第二引数を結果として返す。
const Sleep2 = async (delay, result) => {

    return new Promise(resolve => {
      setTimeout(() => resolve(result), delay);
    });
  }
  
  const Exec2 = async () => {
  
    // 非同期処理を実行するだけ
    await Sleep2(1000)
    console.log(1);
  
    // 非同期の結果を受け取る
    let result = await Sleep2(2000, '2秒・待機')
    console.log(result);
  }
  
  Exec2();



// 複数のPromiseを並列で走らせるときに、awaitは使いやすい🔥


const LateBoy = async (x) => {
    return x;
}

const LateGirl = async (y) => {
    return y;
}

const LateSchool = async () => {

    const lateTimeX = LateBoy(20);

    const lateTimeY = LateGirl(30);

    return `遅刻Timeの総合Score: ${await lateTimeX + await lateTimeY}分`;
}

const lateResult = await LateSchool();

console.log(lateResult);
// 遅刻Timeの総合Score: 50分



const LateSeconds = (x) => {
    return new Promise(resolve => {
        setTimeout(() => {
        resolve(x);
        }, x * 1000);
    });
}

const LateCompany = async () => {
    let a = LateSeconds(1); // ここで2秒待つ
    let b = LateSeconds(2); // ここで3秒待つ
    return `${await a + await b}秒会社に遅刻しました！`; // 1秒待つのと2秒待つのが並行で行われる
}

LateCompany().then(v => {
    console.log(v);
});

const LateCompany2 = async (x) => {
    let a = await LateSeconds(2); // ここで3秒待つ
    let b = await LateSeconds(3); // さらに5秒待つ
    return `${await a + await b}秒会社に遅刻しました！`; // 2秒待つのと3秒待つのが並行で行われる
}

console.log(await LateCompany2());




// async await の使い方
// https://qiita.com/niusounds/items/37c1f9b021b62194e077

// -------------------------------------------------------------------------------------------------------------------------------------------------------------------------


// < 【JavaScript入門】5分で理解！async / awaitの使い方と非同期処理の書き方 >


const PromiseCalc = (num) => {
    return new Promise((resolve) => {

        setTimeout(()=> { resolve(num * num) }, 2000);
    });
};

const AsyncFunc = async () => {
    const result = await PromiseCalc(10);
    console.log(result);
};
 
AsyncFunc();


// 従来のthen() メソッドチェーン
PromiseCalc(10).then((data)=> {
 
    console.log(data);
    return PromiseCalc(100);
}).then((data)=> {
 
    console.log(data);
    return PromiseCalc(1000);
}).then((data)=> {
    console.log(data);
});


const AsyncAll = async () => {
  
    console.log(await PromiseCalc(10));
    console.log(await PromiseCalc(100));
    console.log(await PromiseCalc(1000));
}
 
AsyncAll();


// [ Promise.all()を使った並列処理との違い ]


// PromiseCalc() の引数違いを3つ同時に実行しています。最後に「then」で実行結果を配列として出力するという流れになっていますね。
Promise.all([
    PromiseCalc(10),
    PromiseCalc(100),
    PromiseCalc(1000)
]).then((data) => {
 
    console.log(data);
});


const AsyncAllFunc = async () => {
    
    // まず最初に、実行予定のPromise処理をすべて起動させて変数に格納します
    const promise1 = PromiseCalc(10);
    const promise2 = PromiseCalc(100);
    const promise3 = PromiseCalc(1000);
 
    // そのあとに「await」を付与することですべてのPromise処理を並列に動かして結果を取得することができる
    console.log([await promise1, await promise2, await promise3 ]);
};
 
AsyncAllFunc();





// [ まとめ ]

// asyncはfunctionの前に付与するだけでPromiseを返す非同期処理を定義できる
// awaitはasyncが付与された関数内でのみ実行することができる
// 並列処理を記述する場合は先にすべてのPromise処理を起動させておく




// 【JavaScript入門】5分で理解！async / awaitの使い方と非同期処理の書き方
// https://www.sejuku.net/blog/69618


