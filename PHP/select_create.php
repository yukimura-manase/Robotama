
<?php

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



// グループ分けされたSelectBoxを作成する
foreach ($group_array as $key => $group) { ?>
    
    <select id="world-city">
        <optgroup label="<?php echo $group ?>">
            <?php
            foreach ($city_info as $city_obj) {
                if ($city_obj->group_key == $key) { ?>
                    <option><?php echo $city_obj->city ?></option>
                <?php
                }
            }
            ?>
        </optgroup>
    </select>
    
<?php }








