
// min-maxから年月のObject-Listを加工する処理を作成する

let yyyyMmData = {min: '202207', max: '202408'};

const yyyyMmList = [];

const startYear = yyyyMmData.min.substring(0, 4);
let startMonth = Number(yyyyMmData.min.substring(4, 6));
console.log({startYear});

const lastYear = yyyyMmData.max.substring(0, 4);
let lastMonth = Number(yyyyMmData.max.substring(4, 6));
console.log({lastYear});

let startYearMonthData = {year: '', month: []};
startYearMonthData.year = startYear;

// for (初期値; 条件文; 増減の記述;) { 繰り返し処理 }

// startMonthから始まって、その年の12月までの Monthを投入する => 12以上になったらループ終了(12まではtrue)
for (let month = startMonth; month <= 12; month++ ) {
  startYearMonthData.month.push(startMonth);
}
yyyyMmList.push(startYearMonthData);

console.log({yyyyMmList});

// 年の差分 => 1以上なら、その年数分の 1-12月のSetを作成する
console.log('margin', Number(lastYear) - Number(startYear));

const margin = Number(lastYear) - Number(startYear);

// 開始年と終了年に間の期間だけ
for (let year = Number(startYear) + 1; year < Number(lastYear); year++) {

    // 1月から12月までのListを作成する
    let yearMonthData = {year: '', month: []}; // 初期化処理
    yearMonthData.year = String(year);
    for (let month = 1; month <= 12; month++ ) {
        yearMonthData.month.push(month);
    }
    yyyyMmList.push(yearMonthData);
}

let lastYearMonthData = {year: '', month: []};
lastYearMonthData.year = lastYear;

// 1月からLastMonthまでを作成する
for (let month = 1; month <= lastMonth; month++ ) {
    lastYearMonthData.month.push(month);
}
yyyyMmList.push(lastYearMonthData);


// ----------------------------------------------------------------------------------------------------


console.log('Robotama-Start');

// min-maxから年月のObject-Listを加工する処理を作成する

let yyyyMmData = {min: '202207', max: '202408'};

const yyyyMmList = [];

const startYear = yyyyMmData.min.substring(0, 4);
let startMonth = Number(yyyyMmData.min.substring(4, 6));

const lastYear = yyyyMmData.max.substring(0, 4);
let lastMonth = Number(yyyyMmData.max.substring(4, 6));

// createYyyyMmData (年, 開始月, 終了月) => 実行結果: { year: string; month: number[] }[]
function createYyyyMmData (year, startMonth, lastMonth) {
    let yearMonthData = {year: '', month: []};
    yearMonthData.year = String(year);
    let limit = Number((lastMonth ? lastMonth : 12));
    for (let month = startMonth; month <= limit; month++ ) {
        yearMonthData.month.push(month);
    }
    return yearMonthData;
}

// 開始年
yyyyMmList.push(createYyyyMmData(startYear, startMonth, 12));

// 開始年と終了年に間の期間
for (let year = Number(startYear) + 1; year < Number(lastYear); year++) {
    yyyyMmList.push(createYyyyMmData(year, 1, 12));
}

// 終了年
yyyyMmList.push(createYyyyMmData(lastYear, 1, lastMonth));


console.log({yyyyMmList});




