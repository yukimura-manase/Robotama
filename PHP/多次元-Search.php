<?php

// $array = [
// 	['apple','300'],
// 	['grape','400'],
// 	['pine','500']
// ];

// $key = array_search( 'pine', array_column( $array, 0));

// print_r($key);
// //2


// $array2 = [
// 	['name' => 'apple', 'value' => '300'],
// 	['name' => 'grape', 'value' => '400'],
// 	['name' => 'pine', 'value' => '500']
// ];

// $key2 = array_search( 'pine', array_column( $array2, 'name'));

// print_r($key);
// //2



$robotama = [
    ['robotama-1' => 1000],
	['robotama-2' => 2000 ],
	['robotama-3' => 3000]
];

print_r(array_column( $robotama, 'robotama-3'));

print_r(array_column( $robotama, 'robotama-3'));

print_r(array_column( $robotama, 'robotama-3')[0]);



// PHP | array_search()で配列・多次元配列のデータを検索する方法
// https://1-notes.com/php-array-search/



