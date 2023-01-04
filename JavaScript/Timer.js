
// < Timer-関連のJavaScript >


// 1. 一定時間後に処理を実行したい: setTimeout(関数, ミリ秒)

// 遅延して処理を実行させたい

// Timeout: 指定した時間の経過


console.log(`JavaScript起動時刻: ${new Date().toLocaleTimeString()}`);

const timerId = setTimeout( () => {
    console.log(`1秒後に、setTimeout起動: ${new Date().toLocaleTimeString()}`);
}, 1000);


const timerId2 = setTimeout( () => {
    console.log(`2秒後に、setTimeout起動: ${new Date().toLocaleTimeString()}`);
}, 2000);


const timerId3 = setTimeout( () => {
    console.log(`3秒後に、setTimeout起動: ${new Date().toLocaleTimeString()}`);
}, 3000);


console.log('timerId', timerId);
console.log('timerId2', timerId2);
console.log('timerId3', timerId3);



// 2. 一定時間後の処理を解除したい: clearTimeout(タイマーID)

// setTimeoutの処理をキャンセルする

clearTimeout(timerId2);



// 3. 一定時間ごとに処理を実行したい: setInterval(関数, ミリ秒)

// 一定間隔で処理を実行したい => アニメーションの関数を呼び出すなど

// Interval: 間隔


console.log(`JavaScript起動時刻: ${new Date().toLocaleTimeString()}`);

const intervalId = setInterval(() => {
    console.log(`1秒間隔で、setInterval起動: ${new Date().toLocaleTimeString()}`);
}, 1000);



const intervalId2 = setInterval(() => {
    console.log(`2秒間隔で、setInterval起動: ${new Date().toLocaleTimeString()}`);
}, 2000);


// 4. 一定時間ごとの処理を解除したい: clearInterval(インターバルID)

clearInterval(intervalId2);




 



