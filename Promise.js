
// 【ES6】 JavaScript初心者でもわかるPromise講座 => https://qiita.com/cheez921/items/41b744e4e002b966391a  -----------------------------------------------------------

// [ 1. JavaScriptは処理を待てない非同期言語 ]

// JavaScriptは処理を待てない！ => JavaScriptは非同期言語であるため、一つ前の実行に時間がかかった場合、実行完了をまたずに次の処理が行われてしまいます。
console.log("1番目");

// 1秒後に実行する処理
setTimeout(() => {
  console.log("2番目(1秒後に実行)");
}, 1000);

console.log("3番目");


// [ 2. Promiseは、処理の順序に「お約束」を ]

// Promiseを日本語に翻訳すると「約束」です。
// なので、私はPromiseのことを、処理の順序に「お約束」を取り付けることができるもの、処理を待機することや、その結果に応じて次の処理をすることお約束するものだと思っています。


console.log("1番目");

// お約束を取り付けたい処理にPromise
new Promise((resolve) => {

  //1秒後に実行する処理
  setTimeout(() => {
    console.log("2番目(1秒後に実行)");

    //無事処理が終わったことを伝える
    resolve();
  }, 1000);
}).then(() => {
  // 処理が無事終わったことを受けとって実行される処理
  console.log("3番目");
});

// [ Promiseには3つの状態がある ]

// Promiseには、PromiseStatusというstatusがあり、3つのstatusがあります。

// 1. pending: 未解決 (処理が終わるのを待っている状態)
// 2. resolved: 解決済み (処理が終わり、無事成功した状態)
// 3. rejected: 拒否 (処理が失敗に終わってしまった状態)

// new Promise()で作られたPromiseオブジェクトは、pendeingというPromiseStatusで作られます。
// 処理が成功した時に、PromiseStatusはresolvedに変わり,thenに書かれた処理が実行されます。
// 処理が失敗した時は、PromiseStatusがrejectedに変わり、catchに書かれた処理が実行されます。


// [ Promiseの書き方 ]
// Promiseインスタンスの作成・構文

const promise = new Promise((resolve, reject) => {});
// Promiseの引数には関数を渡し、その関数の第一引数にresolveを設定し、第二引数にrejectを任意で設定します。
// (resolveもrejectも関数です。)



// [ resolveさせよう ]

// rejectは今回使わないため、引数から削除
const promise = new Promise((resolve) => {
    resolve();
}).then(() => {
    console.log("resolveしたよ");
});


// [ resolve関数に引数を渡してあげると... ] => PromiseState(Promiseの状態) & PromiseResult(Promiseの結果)

const promise = new Promise((resolve) => {
    // 引数に文字列を渡す
    resolve("resolveしたよ");
}).then((val) => {
    // 第一引数にて、resolve関数で渡した文字列を受け取ることができる
    console.log(val);
});


new Promise((resolve) => {
    // 引数に文字列を渡す
    resolve("resolveしたよ");
  });


const promise =  new Promise((resolve) => {
    // 引数に文字列を渡す
    resolve("resolveしたよ");
  });
console.log(promise);

// [[Prototype]]: Promise
// [[PromiseState]]: "fulfilled"
// [[PromiseResult]]: "resolveしたよ"


new Promise((resolve, reject) => {});
// [[Prototype]]: Promise
// [[PromiseState]]: "pending"
// [[PromiseResult]]: undefined


new Promise((resolve, reject) => { console.log("ロボ玉"); });

new Promise((resolve, reject) => { 
    resolve("ロボ玉");
}).then((resolveParam)=>{
    console.log(`${resolveParam}は可愛い`);
});

// ロボ玉は可愛い
// [Prototype]]: Promise
// [[PromiseState]]: "fulfilled"
// [[PromiseResult]]: undefined


// [ rejectさせよう ]

const promise = new Promise((resolve, reject) => {
    reject();
  })
    .then(() => {
      console.log("resolveしたよ");
    })
    .catch(() => {
      console.log("rejectしたよ");
    });
console.log(promise);

// [[Prototype]]: Promise
// [[PromiseState]]: "fulfilled"
// [[PromiseResult]]: undefined


new Promise((resolve, reject) => {
    reject();
  });

// [[Prototype]]: Promise
// [[PromiseState]]: "rejected"
// [[PromiseResult]]: undefined

// Error: Uncaught (in promise) undefined => rejectされた時に、catchの処理が行われなかった時のError



// [ Promiseのメソッドチェーン ] => then()やcatch()の後に、thenをさらに続けることができる！

// 1. resolveした場合
new Promise((resolve, reject) => {
    resolve("test");
  })
    .then((val) => {
      console.log(`then1: ${val}`);
      return val;
    })
    .catch((val) => {
      console.log(`catch: ${val}`);
      return val;
    })
    .then((val) => {
      console.log(`then2: ${val}`);
    });

    // then1: test
    // then2: test


// 2. rejectした場合
new Promise((resolve, reject) => {
    reject("test");
    })
    .then((val) => {
        console.log(`then1: ${val}`);
        return val;
    })
    .catch((val) => {
        console.log(`catch: ${val}`);
        return val;
    })
    .then((val) => {
        console.log(`then2: ${val}`);
    });

    // catch: test
    // then2: test



// [ Promise.all と Promise.race ]

// < Promise.all() >

// Promise.all()は配列でPromiseオブジェクトを渡し、全てのPromiseオブジェクトがresolvedになったら次の処理に進みます。

const promise1 = new Promise((resolve) => {
    setTimeout(() => {
      resolve();
    }, 1000);
  }).then(() => {
    console.log("promise1おわったよ！");
  });
  
  const promise2 = new Promise((resolve) => {
    setTimeout(() => {
      resolve();
    }, 3000);
  }).then(() => {
    console.log("promise2おわったよ！");
  });
  
  // 配列でPromise-Objectを渡す！ => すべてがresolveになったら次の処理に移行する！
  Promise.all([promise1, promise2]).then(() => {
    console.log("全部おわったよ！");
  });

    // promise1おわったよ！
    // promise2おわったよ！
    // 全部おわったよ！


// < Promise.race >
// Promise.race()はPromise.all()と同じく配列でPromiseオブジェクトを渡し、どれか1つのPromiseオブジェクトがresolvedになったら次に進みます。
// race: 競争・追いかけっこ

const promise1 = new Promise((resolve) => {
    setTimeout(() => {
      resolve();
    }, 1000);
  }).then(() => {
    console.log("promise1おわったよ！");
  });
  
  const promise2 = new Promise((resolve) => {
    setTimeout(() => {
      resolve();
    }, 3000);
  }).then(() => {
    console.log("promise2おわったよ！");
  });
  
  // 配列でPromise-Objectを渡す！ => どれか1つのPromiseオブジェクトがresolvedになったら次の処理に移行する！
  Promise.race([promise1, promise2]).then(() => {
    console.log("どれか一つおわったよ！");
  });

//   promise1おわったよ！
//   どれか一つおわったよ！
//   promise2おわったよ！



// [ async/awaitを使ってもっと簡潔に！ ]

// Promiseの処理は、Promiseインスタンスを生成したり,resolve/rejectしたりするため、場合によっては結構冗長的になってしまいます。
// async/awaitを使うとPromiseの処理をより簡潔に書くことができます。

const alwaysLateBoy = (ms) => {
    new Promise((resolve) => {
      setTimeout(() => {
        resolve();
      }, ms);
    }).then(() => {
      console.log(`すまん！${ms}ms待たせたな。`);
    });
  };

// 上記の処理をasync/awaitを用いると、下記のようにまとめることができます。

// async function を定義
const alwaysLateBoy = async (ms) => { // Promise-Objectを返すAsync-Functionとなる！
    await new Promise((resolve) => {
      setTimeout(() => {
        resolve();
      }, ms);
    })
    // Promiseの結果が返ってくるまで実行されない
    console.log(`すまん！${ms}ms待たせたな。`)
  };
  alwaysLateBoy(2000);
  // すまん！2000ms待たせたな。

// < asyncとは >
// asyncは非同期関数を定義する関数宣言であり、関数の頭につけることで、Promiseオブジェクトを返す関数にすることができます。

// そのような関数をasync functionといいます。
const asyncFunc = async () => {
    return 1;
  };
  console.log(asyncFunc);
  asyncFunc();

// [[Prototype]]: Promise
// [[PromiseState]]: "fulfilled"
// [[PromiseResult]]: 1



// < awaitとは >
//   awaitは、Promiseオブジェクトが値を返すのを待つ演算子です。
//   ルール: awaitは必ず、async function内で使います。

const asyncFunc = async () => {
    let x, y;
    x = new Promise(resolve => {
      setTimeout(() => {
        resolve(7);
      }, 1000 )
    })
    y = new Promise(resolve => {
      setTimeout(() => {
        resolve(5);
      }, 1000 )
    })
    console.log(x + y)
  };
  asyncFunc();
  // console.log(x + y) = [object Promise][object Promise] 


  const asyncFunc = async () => {
    let x, y;
    // Promiseがresolveするまで待機
    x = await new Promise((resolve) => {
      setTimeout(() => {
        resolve(7);
      }, 1000);
    });
    // Promiseがresolveするまで待機
    y = await new Promise((resolve) => {
      setTimeout(() => {
        resolve(5);
      }, 1000);
    });
  
    console.log(x + y);
  };
  asyncFunc();
  // console.log(x + y) = 12
  // await を指定する => console.log(x + y)は、上二つのPromiseが値を返すのを待ってから実行される。
 


// -----------------------------------------------------------------------------------------------------------------------------------------------------------------------

// 【JavaScriptの応用】Promise -finally・Promise.all => https://tcd-theme.com/2021/09/javascript-promise-finally-promiseall.html

// [ finallyメソッド ]
// finallyメソッドとは、処理の成功・失敗に関わらず、その先の処理を継続して行うメソッドです。
// Promiseチェーンのさいごに必ず呼び出したい処理などを定義することができます。

// thenメソッドとの違いは、Promiseの処理結果を判断する必要がない点です。
// 成功したか失敗したかは関係なく、Promiseが確定された段階で処理を行うということになります。

// thenの場合
const promise = new Promise((resolve, reject) => {
    const something = true;
    if (!something) {
      resolve('成功');
    } else {
      reject('失敗')
    }
  }).then(
      result => console.log(result),
      error => console.log(error)
    );
  // '失敗'
  // thenメソッドで、処理が成功した場合と失敗した場合の処理を記述するためには、引数を2つ用意する必要があります。


 // finallyの場合
// finallyの場合
const promise = new Promise((resolve, reject) => {
    const something = true;
    if (!something) {
        resolve('成功');
    } else {
      reject('失敗');
    }
  })
  .finally(() => console.log('結果に関係なく処理'));
  // '結果に関係なく処理'


const promise = new Promise((resolve, reject) => {
    const something = true;
    if (!something) {
        resolve('成功');
    } else {
      reject('失敗');
    }
  })
  .then(
    (result)=>{
        console.log('then',result);
    },
    (error) => {
        console.log('then', error); // こちらが優先される！
    }
  )
  .catch((error)=>{ //catchメソッドは、rejectedステータスのPromiseオブジェクトを受け取ります。 実質的には、thenメソッドでrejectedステータスを扱う場合と同じですが、コードが簡潔化されます。
    console.log('catch', error);
  })
  .finally(() => console.log('結果に関係なく処理'));
  // then 失敗
  // '結果に関係なく処理'



// [ finally – then ]

// 以下を見ると、finallyメソッドがどのような動きをしているか分かります。


const promise = new Promise((resolve, reject) => {
  const something = true;
  if (!something) {
    resolve('成功');
  } else {
    reject('失敗');
  }
})
  .finally(() => console.log('結果に関係なく処理'))
  .then( // resolve, またはrejectを扱う
    result => console.log(result),
    error => console.log(error)
  );
// '結果に関係なく処理'
// '失敗'

// finallyメソッドの後に、thenメソッドで処理を継続してみると、thenメソッドはPromiseの成功または失敗の結果を扱うことが分かります。

// つまり、finallyは次のハンドラにそのまま処理結果を渡しているということです。


// [ finally – catch ]

// catchメソッドで繋げるとどうでしょうか。

const promise = new Promise((resolve, reject) => {
  const something = true;
  if (!something) {
    resolve('成功');
  } else {
    reject('失敗');
  }
})
  .finally(() => console.log('結果に関係なく処理'))
  .catch(error => console.log(error)); // rejectを扱う
// '結果に関係なく処理'
// '失敗'

// catchは、エラーオブジェクトを扱うメソッドです。
// この場合も、finallyが次のハンドラにそのままエラーオブジェクトを渡していることが分かります。

// 以上のことから、finallyメソッドは、Promiseの結果を元に処理を行う手段ではないと言えます。


// [ Promise.allメソッド ]
// どのような時にPromise.allメソッドが使われるのでしょうか。例えば、すべての処理が適切に終了したことを確認したうえで、新しい処理を行いたい場合です。

const promiseA = new Promise((resolve, reject) => {
    resolve(123)
  });
  
  const promiseB = new Promise((resolve, reject) => {
    resolve('string')
  });
  
  const promiseC = new Promise((resolve, reject) => {
    resolve(true)
  });
  
  Promise.all([promiseA, promiseB, promiseC]).then((results) => {
    console.log(results);
  });
  // [123, 'string', true]



  const promiseA = new Promise((resolve, reject) => {
    resolve(123)
  });
  
  const promiseB = new Promise((resolve, reject) => {
    resolve('string')
  });
  
  const promiseC = new Promise((resolve, reject) => {
    reject(false)
  });
  
  // promiseCがrejectされたため、実行されない
  Promise.all([promiseA, promiseB, promiseC]).then((results) => {
    console.log(results);
  });
//   [[Prototype]]: Promise
//   [[PromiseState]]: "rejected"
//   [[PromiseResult]]: false
//   Error: Uncaught (in promise) false




const promiseA = new Promise((resolve) => {
    resolve()
  }).then(() => console.log('処理A完了'));
  
  const promiseB = new Promise((resolve) => {
    resolve()
  }).then(() => console.log('処理B完了'));
  
  const promiseC = new Promise((resolve) => {
    resolve()
  }).then(() => console.log('処理C完了'));
  
  Promise.all([promiseA, promiseB, promiseC]).then(() => {
    console.log('すべての処理が完了しました');
  });
  // '処理A完了'
  // '処理B完了'
  // '処理C完了'
  // 'すべての処理が完了しました'


//   このような処理は、メールアドレスやユーザー名の登録を行うためのバリデーション処理時に役に立ちます。
//   すべて適切な値であるか審査に通ったら、登録を完了させるような場合です。


// < まとめ >
// 今回は、Promiseのfinally、Promise.allメソッドについて解説しました。

// < ポイント >
// * finallyメソッドは、Promiseオブジェクトの結果に関わらず処理を実行する
// * Promise.allメソッドは、指定したすべてのPromiseオブジェクトがfullfilledステータスになれば処理を実行する
// 特にPromiseチェーンを扱っていく場合、メソッドの使い分けが大切なため、各役割を理解していきましょう。


// -----------------------------------------------------------------------------------------------------------------------------------------------------------------------

// < Promiseで遊ぼう！！ >



const promiseObject = new Promise((resolve, reject)=> {
    resolve('ロボ玉');
}).then((val)=>{
    console.log(`グンマー帝国の${val}`);
});

promiseObject.then((val)=>{
    console.log(val);
    console.log('さらなるロボ玉');
});
// グンマー帝国のロボ玉
// undefined
// さらなるロボ玉


// < 参考・引用 >

// 【ES6】 JavaScript初心者でもわかるPromise講座 => https://qiita.com/cheez921/items/41b744e4e002b966391a

// 【JavaScriptの応用】Promise -finally・Promise.all => https://tcd-theme.com/2021/09/javascript-promise-finally-promiseall.html

//  Promise.prototype.finally() => https://developer.mozilla.org/ja/docs/Web/JavaScript/Reference/Global_Objects/Promise/finally











