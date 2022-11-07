
// [ Promise.all と Promise.race ]

// < Promise.all() >

// Promise.all()は配列でPromiseオブジェクトを渡し、全てのPromiseオブジェクトがresolvedになったら次の処理に進みます。

const promise1 = new Promise((resolve) => {
  setTimeout(() => {
    resolve();
  }, 1000);
}).then(() => {
  console.log("promise1おわったよ！");
  return "promise1";
});

const promise2 = new Promise((resolve) => {
  setTimeout(() => {
    resolve();
  }, 3000);
}).then(() => {
  console.log("promise2おわったよ！");
  return "promise2";
});

// 配列でPromise-Objectを渡す！ => すべてがresolveになったら、then の処理に移行する！
Promise.all([promise1, promise2])
  .then(([val1, val2]) => {
    console.log(`${val1}&${val2}完了、Promise全部おわったよ！`);
  });

// promise1おわったよ！
// promise2おわったよ！
// promise1&promise2完了、Promise全部おわったよ！



// < Promise.race >
// Promise.race()はPromise.all()と同じく配列でPromiseオブジェクトを渡し、どれか1つのPromiseオブジェクトがresolvedになったら次に進みます。
// race: 競争・追いかけっこ

const promise1 = new Promise((resolve) => {
    setTimeout(() => {
      resolve();
    }, 1000);
  }).then(() => {
    console.log("promise1おわったよ！");
    return "promise1";
  });
  
  const promise2 = new Promise((resolve) => {
    setTimeout(() => {
      resolve();
    }, 3000);
  }).then(() => {
    console.log("promise2おわったよ！");
    return "promise2";
  });
  
  // 配列でPromise-Objectを渡す！ => どれか1つのPromiseオブジェクトがresolvedになったら次の処理に移行する！
  Promise.race([promise1, promise2])
  .then((val) => {
    console.log(`${val}が先に終わったよ！`);
  });


//   promise1おわったよ！
//   promise1が先に終わったよ！
//   promise2おわったよ！

