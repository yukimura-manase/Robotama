
// < JavaScriptでタイムスタンプを使った、日付・時間の操作や計算をする🔥 >

// 1. Date.parse(日時文字列); => 日付文字列からタイムスタンプを取得する

const timestanp_1 = Date.parse('2023/01/06');
console.log({timestanp_1});

const toDate_From_timestanp_1 = new Date(timestanp_1);
console.log({toDate_From_timestanp_1});
// {toDate_From_timestanp_1: Fri Jan 06 2023 00:00:00 GMT+0900 (日本標準時)}

const timestanp_2 = Date.parse(2023, 1, 6);
console.log({timestanp_2});

const toDate_From_timestanp_2 = new Date(timestanp_2);
console.log({toDate_From_timestanp_2});
// {toDate_From_timestanp_2: Sun Jan 01 2023 09:00:00 GMT+0900 (日本標準時)}

// 2. 現在日時をタイムスタンプで取得する => Date.now()
const now_timestanp = Date.now();

console.log({now_timestanp});

const toDate_From_timestanp = new Date(now_timestanp);
console.log({toDate_From_timestanp});
// {toDate_From_timestanp: Fri Jan 06 2023 14:30:53 GMT+0900 (日本標準時)}


// 3. 日付や時刻を設定する・取得する

// 3-1. コンストラクターで設定する方法

const date_1 = new Date('2023/02/22 12:00:00');

console.log({date_1});
// {date_1: Wed Feb 22 2023 12:00:00 GMT+0900 (日本標準時)}

const date_2 = new Date(2023, 5, 5, 18, 30);

console.log({date_2});
// {date_2: Mon Jun 05 2023 18:30:00 GMT+0900 (日本標準時)}

const timestanp_3 = Date.parse('2023/08/11');
const date_3 = new Date(timestanp_3);

console.log({date_3});
// {date_3: Fri Aug 11 2023 00:00:00 GMT+0900 (日本標準時)}


// 3-2. メソッドで設定する方法


const futureDate = new Date();

futureDate.setFullYear(2025);
futureDate.setMonth(0);
futureDate.setDate(12);
futureDate.setHours(12);
futureDate.setMinutes(30);
futureDate.setSeconds(50);


console.log(`未来の日時: ${futureDate}`);



// 4. 日付や時刻を計算する => タイムスタンプ(時刻の数値)を使って計算する🔥


const date = new Date('2023/08/11');

// 4-1. 指定した日付の 1ヶ月前を設定する
date.setMonth(date.getMonth() - 1);
console.log(date.toLocaleDateString()); // 2023/7/11

// 4-2. 指定した日付の100日後を設定する
date.setDate(date.getDate() + 100 );
console.log(date.toLocaleDateString()); // 2023/10/19


// 4-3. 2つの日時の計算をする Ver.日数

const dateA = new Date('2022/05/05');
const dateB = new Date('2022/04/05');

console.log({dateA});
console.log({dateB});

// 「 getTime() = Date.parse() 」=> タイムスタンプを取得することができる🔥

const diffMiSec = dateA.getTime() - dateB.getTime();
console.log({diffMiSec});

// タイムスタンプで差分を取得したので、そこから計算する

// 日数の差分を知りたい場合は「 差分 / (24 * 60 * 60 * 1000) 」で計算する🔥
const diffDate = diffMiSec / (24 * 60 * 60 * 1000);

console.log(`2つの日付の差分は、${diffDate}日です`);
// 2つの日付の差分は、30日です


const dateC = new Date('2022/05/07 12:00:00');
const dateD = new Date('2022/05/05 12:00:00');

const diffMiSec2 = dateC.getTime() - dateD.getTime();

// 時間の差分を知りたい場合は「 差分 / (60 * 60 * 1000) 」で計算する🔥
const diffHour = diffMiSec2 / (60 * 60 * 1000);

console.log(`2つの時間の差分は、${diffHour}時間です`);
// 2つの時間の差分は、48時間です



const dateE = new Date('2022/05/05 12:50:00');
const dateF = new Date('2022/05/05 12:00:00');

const diffMiSec3 = dateE.getTime() - dateF.getTime();

// 分の差分を知りたい場合は「 差分 / (60 * 1000) 」で計算する🔥
const diffMin = diffMiSec3 / (60 * 1000);

console.log(`2つの分の差分は、${diffMin}分です`);
// 2つの分の差分は、50分です


















