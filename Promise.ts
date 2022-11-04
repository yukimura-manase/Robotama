

type PromiseFuncType = Promise<void>;

const PromiseFunc: PromiseFuncType = new Promise((resolve, reject)=> {
    resolve('ロボ玉');
}).then((val)=>{
    console.log(`グンマー帝国の${val}`);
});



const PromiseFunc2 = new Promise((resolve, reject)=> {
    resolve('ロボ玉');
}).then((val)=>{
    return `グンマー帝国の${val}`;
});


type PromiseFuncType2 = typeof PromiseFunc2;

// [ 抽出結果 ]
// type PromiseFuncType2 = Promise<string>


type AsyncFuncType = () => Promise<void>;

const asyncFunc: AsyncFuncType = async () => {
    let x, y;

    // await-1: Promiseがresolveするまで待機する
    x = await new Promise((resolve) => {
        setTimeout(() => {
        resolve(7);
        }, 1000);
    });
    // await-2: Promiseがresolveするまで待機する
    y = await new Promise((resolve) => {
        setTimeout(() => {
        resolve(5);
        }, 1000);
    });

    console.log(`すまん！${x + y}秒、待たせた！`);
};


asyncFunc();


type AsyncFuncType2 = () => Promise<
    {
        result: string;
        code: number;
        msg: string;
    }
>

const asyncFunc2: AsyncFuncType2 = async () => {
    let x, y;

    // await-1: Promiseがresolveするまで待機する
    x = await new Promise((resolve) => {
        setTimeout(() => {
        resolve(7);
        }, 1000);
    });
    // await-2: Promiseがresolveするまで待機する
    y = await new Promise((resolve) => {
        setTimeout(() => {
        resolve(5);
        }, 1000);
    });

    return { result: "success", code: 200, msg: `すまん！${x + y}秒、待たせた！`};
};





