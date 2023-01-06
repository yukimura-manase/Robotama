
// < JavaScriptで日付や時間の取り扱い・操作する方法・Dateオブジェクトの使い方🔥 >


// 1. JavaScript で日付や時間操作をするのなら、まずは、Dateインスタンスを作成する
let date = new Date();
console.log('date:', date);
// date: Fri Jan 06 2023 10:16:00 GMT+0900 (日本標準時)


// 2. 西暦を取得する
const year = date.getFullYear();
console.log('year:', year);
// year: 2023


// 3. 日付を取得する
const month = date.getMonth();
console.log('month:', month);
// month: 0

// getMonth() は、0-11の数字のいずれかを返す🔥

// 1月が0扱いなので、注意 => +1して使用する

// 1月は、0 , 2月は、1 となる => なので、+1して使用する

const today = date.getDate();
console.log('today:', today);
// today: 6

console.log(`今日は、${month + 1}月${today}日です！`);
// 今日は、1月6日です！


// 4. 時間を取得する

const hour = date.getHours();
console.log('hour:', hour);
// hour: 10

// getHours() は、0-23の数字のいずれかを返す🔥

// 24時が、0扱いなので、注意！

const minutes = date.getMinutes();
console.log('minutes:', minutes);
// minutes: 16

// getMinutes() は、0-59の数字のいずれかを返す🔥

// 60分が、0扱いなので、注意！

const seconds = date.getSeconds();
console.log('seconds:', seconds);


// getSeconds() は、0-59の数字のいずれかを返す🔥

// 60秒が、0扱いなので、注意！

const ms = date.getMilliseconds();
console.log('ms:', ms);
// ms: 896


console.log(`現在時刻は、${hour}時${minutes}分${seconds}秒です！`);
// 現在時刻は、10時34分19秒です！


// 5. 午前と午後の判定をする

let judgment = '';

if (hour <= 12) {
    judgment = '午前';
} else {
    judgment = '午後';
    hour = hour - 12;
}

console.log(`現在は、${judgment} ${hour}です！`);



// 6. 曜日を取得する
const dayNum = date.getDay();
console.log('dayNum:', dayNum);
// dayNum: 5


const dayofweek = [ '日', '月', '火', '水', '木', '金', '土' ];

console.log(`今日は、${dayofweek[dayNum]}曜日です！`);


// 7. Localeの日付を取得する => 利用者の言語環境にあわせた時刻表示が得られる！
// => 多言語の日付時刻表示をしたいときに、役立ちます！

date = new Date();

const locale = date.toLocaleString();
const localeDate = date.toLocaleDateString();
const localeTime = date.toLocaleTimeString();

console.log('locale:', locale);             // locale: 2023/1/6 13:38:07
console.log('localeDate:', localeDate);     // localeDate: 2023/1/6
console.log('localeTime:', localeTime);     // localeTime: 13:38:07








