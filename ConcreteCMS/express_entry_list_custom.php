<?php defined('C5_EXECUTE') or die('Access Denied.');

use Express;
use Concrete\Core\Express\EntryList;
use Concrete\Core\Entity\Express\Entity;
use Core;
use Concrete\Core\Express\Entry\Search\Result\Result;
use Concrete\Core\Search\Column\CollectionAttributeKeyColumn;
use Doctrine\ORM\EntityManagerInterface;
use Concrete\Core\Attribute\AttributeKeyInterface;
use Concrete\Core\Form\Context\ContextFactory;
use Concrete\Core\Express\Form\Context\FrontendFormContext;
use Concrete\Block\ExpressForm\Controller;

use Concrete\Core\Express\Entry\EntryManagerInterface;

use Concrete\Core\Entity\Express\Form;

# Debug専用のLog
use Concrete\Core\Support\Facade\Log;


// Develop & Debug-専用の関数
// function console_log_msil_question($data){
//     echo '<script>';
//     echo 'console.log('.json_encode($data).')';
//     echo '</script>';
// };


// [ 要望受付ページの Customize-Express-実装 ]

// この加工処理専用のPHPファイルで実行すること

// 1. 入力フォーム設定の属性情報を取得して、配列にまとめる => 1入力フォーム・1属性

// 2. 質問設定のレコード情報を取得して、配列にまとめる => 1質問・1レコード

// 3. 質問文のハンドル名と入力フォームのハンドル名から、質問文と入力フォームを紐づける

// 4. 

    // 質問文の順序 => 入力フォームの並び順 => 編集画面で決める！

    // 入力フォームの設定情報 & HTMLを取得する => Expressフォームの処理を解析中・・・

// concrete5 8 express_formブロックで設定した項目をバラバラに取得できるようにする
// https://gist.github.com/YuzuruSano/d20286c13964c5d023158957181f7b1f



// [ Express 基本情報 ]  

// Entity(エンティティ) => Table

// Attribute => Column

// Entry(エントリー) => Recode, 実データ

// Handle や akID => カラムID


// < 1. 海しる-DataSet を取得する処理・Block >

$umisiru_api_entity = Express::getObjectByHandle('umisiru_api_data');
$umisiru_api_entryList = new EntryList($umisiru_api_entity);
$umisiru_api_entries = $umisiru_api_entryList->getResults();

// console_log_msil_question('umisiru_api_entries');
// console_log_msil_question($umisiru_api_entries);

// SelectBox(入力フォーム)に渡すDataList
global $umisiru_data_list;
$umisiru_data_list = [];

foreach ($umisiru_api_entries as $umisiru_data_set) {
    $data_set = (object)[];

    // no_display => 非表示フラグ: Default-false
    if (!( $umisiru_data_set->getAttribute('no_display') )) {
        $data_set->display_name = $umisiru_data_set->getAttribute('display_name');
        $data_set->large_classification = $umisiru_data_set->getAttribute('large_classification');
        $data_set->middle_classification = $umisiru_data_set->getAttribute('middle_classification');
        array_push($umisiru_data_list, $data_set);
    }
}

// console_log_msil_question('umisiru_data_list');
// console_log_msil_question($umisiru_data_list);


// < 2. 質問設定のデータ処理・Block >

// 質問ごとのデータを作成して、JavaScriptで受け渡す


// ご要望アンケートの質問設定リスト
global $question_request_list;
$question_request_list = [];

// 回答者アンケートの質問設定リスト
global $question_respondent_list;
$question_respondent_list = [];

// Handle名: 説明文
global $handle_description_obj;
$handle_description_obj = (object)[];


$request_question_entity = Express::getObjectByHandle('msil_request_question');
$request_question_entryList = new EntryList($request_question_entity);
$request_question_entries = $request_question_entryList->getResults();

// console_log_msil_question('$request_question_entries');
// console_log_msil_question($request_question_entries);

$question_request_list = [];
$question_respondent_list = [];

foreach ($request_question_entries as $request_question) {
    
    $question_config = (object)[];

    $sort_index = 0;
    $sort_index = $request_question->getAttribute('sort_order'); // 並び順

    // ハンドル名で、入力フォームと紐づける
    $request_form_name = $request_question->getAttribute('request_form_name'); // 入力フォームのハンドル名(複数選択可)

    // console_log_msil_question('$request_form_name');
    // console_log_msil_question($request_form_name);
    
    $ex_result = explode('<br/>', $request_form_name);
    // console_log_msil_question('$ex_result');
    // console_log_msil_question($ex_result);

    // 改行コードを削除する
    $moji = str_replace(array("\r\n", "\r", "\n"), "@", $ex_result[0]);

    // console_log_msil_question('$moji');
    // console_log_msil_question($moji);

    $result = explode('@', $moji);
    // console_log_msil_question('$result');
    // console_log_msil_question($result);

    $handle_list = array_diff($result, ['']);

    // console_log_msil_question('$handle_list');
    // console_log_msil_question($handle_list);
    $question_config->handle_name = $handle_list;

    $question_config->question = $request_question->getAttribute('question'); // 質問文
    $question_config->input_required = $request_question->getAttribute('input_required'); // 入力必須フラグ

    // ご要望アンケート or 回答者アンケートの判定
    $youbou_flag = $request_question->getAttribute('youbou_flag'); // 要望項目フラグ
    if ($youbou_flag == "Yes") $request_flag = true;
    else $request_flag = false;

    $input_description = $request_question->getAttribute('input_description'); // 入力フォームの説明文
    $input_description_list = explode('@@', $input_description);
    foreach ($input_description_list as $desc) {
        if ($desc !== '') {
            $handle_desc = explode('@', $desc);
            $handle = $handle_desc[0];
            $description = $handle_desc[1];
            $question_config->$handle = $description;
        }
    }

    $select_search_box_id = $request_question->getAttribute('select_search_box_id'); // 検索機能付きのセレクトボックス

    if (!empty($select_search_box_id)) $question_config->select_search_handle = $select_search_handle;


    // すべてのカラムごとの実データを確認した後の処理
    if ($request_flag) $question_request_list[$sort_index] = $question_config;
    else $question_respondent_list[$sort_index] = $question_config;
}



// 1. エクスプレスの質問設定・管理テーブル
// $results = $result->getItemListObject()->getResults();


// console_log_msil_question('$results');
// console_log_msil_question($results);


// 2. 質問設定・管理テーブルのカラム情報
// foreach ($result->getColumns() as $column) {

//     // console_log_msil_question('$column');
//     // console_log_msil_question($column);
// }


// 3. 質問設定・管理テーブルのレコード情報 (All)
// foreach ($result->getItems() as $item) {

//     // console_log_msil_question('$item');
//     // console_log_msil_question($item);

//     // Qestion-Object
//     $question_config = (object)[];

//     // 要望項目フラグ
//     $request_flag = false;

//     $sort_index = 0;

//     // 4. レコード情報からカラムごとに、1つ1つ取り出す => カラムの判定をして、実データを取り出す
//     foreach ($item->getColumns() as $column) {

//         // console_log_msil_question('$column-2');
//         // console_log_msil_question($column);

//         // 4-0. ハンドル名 => ハンドル名で、入力フォームと紐づける
//         if ($column->key == "ak_request_form_name") {
//             $request_form_name = $column->getColumnValue($item);
//             $result = explode('<br/>', $request_form_name);
//             $handle_list = array_diff($result, ['']);
//             $question_config->handle_name = $handle_list;
//         }

//         // 4-1. 質問文
//         if ($column->key == "ak_question") {
//             $question = $column->getColumnValue($item);
//             $question_config->question = $question;
//         }

//         // 4-2. 必須フラグ
//         if ($column->key == "ak_input_required") {

//             $input_required = $column->getColumnValue($item);
//             $question_config->input_required = $input_required;
//         }

//         // 4-3. 要望項目フラグ => ご要望アンケート or 回答者アンケートの判定
//         if ($column->key == "ak_youbou_flag") {
//             $youbou_flag = $column->getColumnValue($item);

//             if ($youbou_flag == "Yes") $request_flag = true;
//             else $request_flag = false;
//         }

//         // 4-4. 並び順
//         if ($column->key == "ak_sort_order") {
//             $sort_order = $column->getColumnValue($item);
//             $sort_index = $sort_order;
//         }

//         // 4-5. 入力フォームの説明文
//         if ($column->key == "ak_input_description") {
//             $input_description = $column->getColumnValue($item);

//             $input_description_list = explode('@@', $input_description);

//             foreach ($input_description_list as $desc) {
//                 if ($desc !== '') {
//                     $handle_desc = explode('@', $desc);
//                     $handle = $handle_desc[0];
//                     $description = $handle_desc[1];
//                     $handle_description_obj->$handle = $description;
//                 }
//             }
//         }

//         // 4-6. 検索機能付きのカスタム・セレクトボックス
//         if ($column->key == "select_search_box_id" && !empty($column->value)) {
//             $select_search_handle = $column->getColumnValue($item);
//             $question_config->select_search_handle = $select_search_handle;
//         }

//     }

//     // すべてのカラムごとの実データを確認した後の処理
//     if ($request_flag) $question_request_list[$sort_order] = $question_config;
//     else $question_respondent_list[$sort_order] = $question_config;
// }



// console_log_msil_question('$question_request_list');
// console_log_msil_question($question_request_list);


// console_log_msil_question('$question_respondent_list');
// console_log_msil_question($question_respondent_list);


// console_log_msil_question('$handle_description_obj');
// console_log_msil_question($handle_description_obj);



?>

