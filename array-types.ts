
// [ TypeScript 配列の定義方法 ]

// 1つの型だけの配列
const singleTypeArray: string[] = ['ロボ玉試作1号機', 'ロボ玉試作2号機'];

// 2つ以上の型の配列
const multiTypeArray: (string | number | boolean)[] =  ['ロボ玉試作1号機', 1000, true];

// 多次元配列 => 配列の中に配列
const multiArray: (string | number)[][] = [
    ['ロボ玉試作1号機', 1000],
    ['ロボ玉試作2号機', 2000],
    ['ロボ玉試作3号機', 3000]
];

export interface Prefectures {
    prefCode: number;
    prefName: string;
}

// Object配列 => 1つのパターンだけ
const prefectureList: Prefectures[]  = [
    {prefCode: 1, prefName: '北海道'},
    {prefCode: 2, prefName: '神聖グンマー帝国'},
    {prefCode: 3, prefName: 'さいたまー共和国'},
    {prefCode: 4, prefName: 'トチギー公国'},
    {prefCode: 5, prefName: 'Tokyo'},
];


export interface YearPopulation {
    year: number;
    population: number;
}

// Object配列 => 2つ以上のObjectパターン
const prefDataSet: (Prefectures | YearPopulation)[] = [
    {prefCode: 1, prefName: '北海道'},
    {year: 2050, population: 160000},
    {year: 2055, population: 150000},
    {year: 2060, population: 140000},
    {year: 2065, population: 130000},
    {year: 2070, population: 120000},
];


// intersectionしたArray
export type Population2050 = Prefectures[] & YearPopulation[]

const pref: Population2050 = [ 
    {prefCode: 1, prefName: '北海道', year: 2050, population: 160000},
    {prefCode: 2, prefName: '神聖グンマー帝国', year: 2050, population: 200000},
    {prefCode: 3, prefName: 'さいたまー共和国', year: 2050, population: 180000},
];

