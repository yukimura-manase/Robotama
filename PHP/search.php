<?php


// PHP 配列の中から特定の値があるかを検索する => 存在しなかったら、追加する


// array_search(検索する値, 検索対象の配列, 型の比較を行うか)

$data_set = [
    (object)['group' => '日本', 'city' => '東京'],
    (object)['group' => '日本', 'city' => '大阪'],
    (object)['group' => 'ドイツ', 'city' => 'ベルリン'],
    (object)['group' => 'ドイツ', 'city' => 'ミュンヘン'],
    (object)['group' => 'アメリカ', 'city' => 'ニューヨーク'],
    (object)['group' => 'アメリカ', 'city' => 'ロサンゼルス'],
];

$group_array = [];

$city_info = [];


// Result-Image
// $result_group_array = [
//     'group_1' => '日本', 
//     'group_2' => 'ドイツ', 
//     'group_3' => 'アメリカ'
// ];
 
// $result_city_info = [
//     'group_1' => '東京', 
//     'group_1' => '大阪', 
//     'group_2' => 'ミュンヘン', 
//     'group_2' => 'ベルリン', 
//     'group_3' => 'ニューヨーク', 
//     'group_3' => 'ロサンゼルス'
// ];


// よくよく考えてみたら、key名は、識別子なので、重複は不可でした・・・


foreach ($data_set as $data) {

    $group_name = $data->group;
    
    // group_arrayにグループ名が登録されていなければ、グループ名を登録する
    if (!in_array($group_name, $group_array)) array_push($group_array, $group_name);

    $group_key = array_search($group_name, $group_array); // グループ名リストから、key(index)を取得する

    $city_obj = (object)[];

    $city_obj->city = $data->city;
    $city_obj->group_key = $group_key;
    array_push($city_info, $city_obj);
}

var_export($group_array);
//  array (
//     0 => '日本',
//     1 => 'ドイツ',
//     2 => 'アメリカ',
//   )

var_export($city_info);
//   array (
//     0 => 
//     (object) array(
//        'city' => '東京',
//        'group_key' => 0,
//     ),
//     1 => 
//     (object) array(
//        'city' => '大阪',
//        'group_key' => 0,
//     ),
//     2 => 
//     (object) array(
//        'city' => 'ベルリン',
//        'group_key' => 1,
//     ),
//     3 => 
//     (object) array(
//        'city' => 'ミュンヘン',
//        'group_key' => 1,
//     ),
//     4 => 
//     (object) array(
//        'city' => 'ニューヨーク',
//        'group_key' => 2,
//     ),
//     5 => 
//     (object) array(
//        'city' => 'ロサンゼルス',
//        'group_key' => 2,
//     ),
//   )




// 【PHP入門】配列の値を検索するarray_searchと他4つの関数
// https://www.sejuku.net/blog/22098



