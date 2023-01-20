<?php

defined('C5_EXECUTE') or die('Access Denied.');

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
use Concrete\Core\Entity\Express\Form;
use Concrete\Core\Support\Facade\Log; # Debug専用のLog

/** @var \Concrete\Core\Block\View\BlockView $view */
/** @var \Concrete\Core\Express\Form\Renderer|null $renderer */
/** @var string|null $success */
/** @var string $bID */
/** @var \Concrete\Core\Error\ErrorList\ErrorList|null $error */
/** @var \Concrete\Core\Captcha\CaptchaInterface|null $captcha */
/** @var string $displayCaptcha "0" or "1" */
/** @var string $submitLabel */


// Develop & Debug-専用の関数
function console_log_msil_request_form($data){
    echo '<script>';
    echo 'console.log('.json_encode($data).')';
    echo '</script>';
};


// [ 要望受付ページの Customize-Express-Form 実装 ]

// この加工処理専用のPHPファイルで実行すること

// 1. 入力フォーム設定の属性情報を取得して、配列にまとめる => 1入力フォーム・1属性

// 2. 質問設定のレコード情報を取得して、配列にまとめる => 1質問・1レコード

// 3. 質問文のハンドル名と入力フォームのハンドル名から、質問文と入力フォームを紐づける

// 4. 

    // 質問文の順序 => 入力フォームの並び順 => 編集画面で決める！

    // 入力フォームの設定情報 & HTMLを取得する => Expressフォームの処理を解析中・・・




// [ Express 基本情報 ]  

// Entity(エンティティ) => Table

// Attribute => Column

// Entry(エントリー) => Recode, 実データ

// Handle や akID => カラムID




// < 1. 質問設定のデータ処理・Block >

// ご要望アンケートの質問設定リスト
$msil_question_request_list = [];

// 回答者アンケートの質問設定リスト
$msil_question_respondent_list = [];



$request_question_entity = Express::getObjectByHandle('msil_request_question');
$request_question_entryList = new EntryList($request_question_entity);
$request_question_entries = $request_question_entryList->getResults();

console_log_msil_request_form('$request_question_entries');
console_log_msil_request_form($request_question_entries);

foreach ($request_question_entries as $request_question) {
    
    $question_config = (object)[];

    $sort_index = 0;
    $sort_index = $request_question->getAttribute('sort_order'); // 並び順

    // ハンドル名で、入力フォームと紐づける
    $request_form_name = $request_question->getAttribute('request_form_name'); // 入力フォームのハンドル名(複数選択可)
    $ex_result = explode('<br/>', $request_form_name);
    $moji = str_replace(array("\r\n", "\r", "\n"), "@", $ex_result[0]); // 改行コードを削除する
    $result = explode('@', $moji);
    $handle_list = array_diff($result, ['']);
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
    if ($request_flag) $msil_question_request_list[$sort_index] = $question_config;
    else $msil_question_respondent_list[$sort_index] = $question_config;
}


console_log_msil_request_form('$msil_question_request_list');
console_log_msil_request_form($msil_question_request_list);

console_log_msil_request_form('$msil_question_respondent_list');
console_log_msil_request_form($msil_question_respondent_list);



// < 2. 海しる-DataSet を取得する処理・Block >

$umisiru_api_entity = Express::getObjectByHandle('umisiru_api_data');
$umisiru_api_entryList = new EntryList($umisiru_api_entity);
$umisiru_api_entries = $umisiru_api_entryList->getResults();

// console_log_msil_request_form('umisiru_api_entries');
// console_log_msil_request_form($umisiru_api_entries);

// SelectBox(入力フォーム)に渡すDataList
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
// console_log_msil_request_form('$umisiru_data_list');
// console_log_msil_request_form($umisiru_data_list);




// App-Insatance => アプリ機能
$app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();

$token = app('token');


// console_log_msil_request_form('$token');
// console_log_msil_request_form($token);

$entityManager = $app->make('database/orm')->entityManager();


// < 3. 入力フォーム設定のデータ処理・Block >

// 要望受付ページの入力フォーム設定の Express-Entity-ID
$exFormID = '38ac05fd-9213-11ed-925a-0242ac110003';


// Form
$form = $entityManager->getRepository(\Concrete\Core\Entity\Express\Form::class)->findOneById($exFormID);

// console_log_msil_request_form('$form');
// console_log_msil_request_form($form);


// フォーム設置時に設定した各入力項目
$af = Core::make('helper/form/attribute');

// エンティティ => テーブル
$entity = $form->getEntity();

$provider = \Core::make('Concrete\Core\Express\Search\SearchProvider', array($entity, $entity->getAttributeKeyCategory()));
$set = \Core::make('Concrete\Core\Express\Search\ColumnSet\ColumnSet');
$available = $provider->getAvailableColumnSet();
$attributes = $entity->getAttributeKeyCategory()->getList();

// console_log_msil_request_form('$attributes');
// console_log_msil_request_form($attributes);






// { akID: handle_name }[]
$akID_handle_lsit = [];

foreach($attributes as $ak) {
    $akID = $ak->getAttributeKeyID();
    $handle_name = $ak->getAttributeKeyHandle();

    // console_log_msil_request_form('$handle_name');
    // console_log_msil_request_form($handle_name);
    array_push($akID_handle_lsit, (object)['akID' => $akID,  'handle_name' => $handle_name]);
}


// console_log_msil_request_form('$akID_handle_lsit');
// console_log_msil_request_form($akID_handle_lsit);

// console_log_msil_request_form('$robotama');
// console_log_msil_request_form($robotama);


$controls = $form->getControls();

// console_log_msil_request_form('$controls');
// console_log_msil_request_form($controls);


// 入力フォームの設定情報-List
$input_form_config = [];

foreach($controls as $control){
    // console_log_msil_request_form('$control');
    // console_log_msil_request_form(get_class($control));

    $value = $af->setAttributeObject($control);

    $key = $control->getAttributeKey();

    // console_log_msil_request_form('$key');
    // console_log_msil_request_form($key);

    $type = $key->getAttributeType();

    $obj = new stdClass();
    $obj->question = $control->getDisplayLabel();
    $obj->isRequired = $control->isRequired();
    $obj->showControlRequired = true;
    $obj->showControlName = true;
    $obj->type = 'attribute_key|' . $type->getAttributeTypeID();
    $obj->typeDisplayName = $type->getAttributeTypeDisplayName();
    $obj->controlID = $control->getID();
    $obj->keyID = $key->getAttributeKeyID();
    $obj->typeContent = $key->render('composer', $value, true);
    $obj->attrTypeHandle = $type->getAttributeTypeHandle();

    // $obj->handle_name = array_search($keyID, $akID_handle_lsit);
    $handle_name = '';
    foreach ($akID_handle_lsit as $val) {
        if ($val->akID == $obj->keyID) {
            $handle_name = $val->handle_name;
            $obj->handle_name = $handle_name;

        }
    }

    // select系属性はオプションとオプションIDももらう。
    $options = [];
    $akc = $key->getController();

    if(method_exists($akc,'getOptions')){

        $optionList = $akc->getOptions();

        if ($optionList) {
            foreach ($optionList as $option) {
                $options[$option->getSelectAttributeOptionID()] = $option->getSelectAttributeOptionDisplayValue();
            }
            $obj->hasOption = true;
            $obj->options = $options;

        } else {
            $obj->hasOption = false;
        }
    }


    array_push($input_form_config , $obj);
    // array_push($input_form_config , (object)[$handle_name => $obj]);
}

console_log_msil_request_form('$input_form_config');
console_log_msil_request_form($input_form_config);

?>


<style>
/* 要望受付ページでは、非表示にする要素たち */


.msil-share-title {
    display: none;
}

#msil-login-block {
    display: none;
}

#msil-logout-block {
    display: none;
}

footer {
    display: none;
}

#msil-request-footer {
    display: block;
}

/* セクションタイトル */
.msil-section-title {
  font-size: 20px;
  font-weight: bold;
  border-bottom: #0084cc 2px solid;
  width: 60%;
  margin: 20px auto;
}



/* アンケートの質問 */
.msil-question {
    border-bottom: #d4d4d4 1px solid;
    background: #0084cc;
    color: #fff;
    padding: 10px 40px;
    font-size: 20px;
    font-weight: bold;
    width: 60%;
    margin: 0 auto;
}


/* 必須項目*/
.msil-required {
    background: #ff0000;
    font-size: 18px;
    font-weight: bold;
    padding: 5px 17px;
    margin-right: 20px;
}


/* 任意項目 */
.msil-optionally {
    background: #ccc;
    color: #000;
    font-size: 18px;
    font-weight: bold;
    padding: 5px 17px;
    margin-right: 20px;
}


/* アンケートの質問 */
.msil-question {
    border-bottom: #d4d4d4 1px solid;
    background: #0084cc;
    color: #fff;
    padding: 10px 40px;
    font-size: 20px;
    font-weight: bold;
    width: 60%;
    margin: 0 auto;
}

        
/* 必須項目*/
.msil-required {
    background: #ff0000;
    font-size: 18px;
    font-weight: bold;
    padding: 5px 17px;
    margin-right: 20px;
}


/* 任意項目 */
.msil-optionally {
    background: #ccc;
    color: #000;
    font-size: 18px;
    font-weight: bold;
    padding: 5px 17px;
    margin-right: 20px;
}

</style>


<?php if (isset($renderer)) {?>
<div class="ccm-form">
    <a name="form<?=$bID; ?>"></a>

    <?php if (isset($success)) { ?>
        <div class="alert alert-success">
            <?=$success; ?>
        </div>
    <?php
} ?>


<?php if (isset($error) && is_object($error)) { ?>
    <div class="alert alert-danger">
        <?=$error->output(); ?>
    </div>
<?php } ?>

<form enctype="multipart/form-data" class="form-stacked" method="post" action="<?=$view->action('submit')?>#form<?=$bID?>">
    <input type="hidden" name="ccm_token" value="1673937637:dade003299ee8b96e92a923fd5cbf58e">
    <input type="hidden" name="express_form_id" value="38ac05fd-9213-11ed-925a-0242ac110003">

<h3 class='msil-section-title'>ご要望アンケート</h3>

<!-- Express-Form-Start -->
<div class="ccm-block-express-form">
    

    <?php if (is_array($msil_question_request_list) && $msil_question_request_list == true) {

        // console_log_msil_request_form('Robotama-Debug-2');
        
        $length = count($msil_question_request_list);

        // 動的に質問文の設定を適用していく

        for ($val = 1; $val <= $length; $val++) {

            $question_request = $msil_question_request_list[$val];
            
            // 回答必須の質問-Block
            if ($question_request->input_required == "Yes") {
                ?>
                <!-- 質問文を作成する -->
                
                <h4 class='msil-question'>
                    <span class='msil-required'>必須</span>
                    <span><?php echo $question_request->question; ?></span>
                </h4>

                <!-- 入力フォームを作成する -->
                <?php
                foreach ($input_form_config as $input_config) {
                    foreach ($question_request->handle_name as $handle) {
                        if ($handle == $input_config->handle_name) { 

                            // 説明文が存在したら、出力する
                            if (property_exists($question_request, $handle)) { ?>
                                <div><?php echo $question_request->$handle; ?></div>
                            <?php
                            } ?>
                                <span><?php echo $input_config->typeContent; ?></span>
                            <?php
                        }
                    }
                }
            
            } else {
                ?>
                <!-- 質問文を作成する -->
                
                <h4 class='msil-question'>
                    <span class='msil-optionally'>任意</span>
                    <span><?php echo $question_request->question; ?></span>
                </h4>

                <!-- 入力フォームを作成する -->
                <?php
                foreach ($input_form_config as $input_config) {
                    foreach ($question_request->handle_name as $handle) {
                        if ($handle == $input_config->handle_name) { 
                        
                            // 説明文が存在したら、出力する
                            if (property_exists($question_request, $handle)) { ?>
                                <div><?php echo $question_request->$handle; ?></div>
                            <?php
                            } ?>
                                <span><?php echo $input_config->typeContent; ?></span>
                        <?php 
                        }
                    }
                }
            }
        }
    } 
    ?>


<h3 class='msil-section-title'>回答者について</h3>

<?php if (is_array($msil_question_respondent_list) && $msil_question_respondent_list == true) {

    $length = count($msil_question_respondent_list);

    for ($val = 1; $val <= $length; $val++) {

        $question_respondent = $msil_question_respondent_list[$val];

        
        if ($question_respondent->input_required == "Yes") { ?>

            <!-- 質問文を作成する -->
            
            <h4 class='msil-question'>
                <span class='msil-required'>必須</span>
                <span><?php echo $question_respondent->question; ?></span>
            </h4>

            <!-- 入力フォームを作成する -->
            <?php
            foreach ($input_form_config as $input_config) {
                foreach ($question_respondent->handle_name as $handle) {
                    if ($handle == $input_config->handle_name) {
                        // 説明文が存在したら、出力する
                        if (property_exists($question_respondent, $handle)) { ?>
                            <div><?php echo $question_respondent->$handle; ?></div>
                        <?php
                        } ?>
                            <span><?php echo $input_config->typeContent; ?></span>
                        <?php
                    }
                }
            }
            ?>
            <?php 
        } else { ?>

            <!-- 質問文を作成する -->
            <h4 class='msil-question'>
                <span class='msil-optionally'>任意</span>
                <span><?php echo $question_respondent->question; ?></span>
            </h4>

            <!-- 入力フォームを作成する -->
            <?php
            foreach ($input_form_config as $input_config) {
                foreach ($question_respondent->handle_name as $handle) {
                    if ($handle == $input_config->handle_name) {
                        // 説明文が存在したら、出力する
                        if (property_exists($question_respondent, $handle)) { ?>
                            <div><?php echo $question_respondent->$handle; ?></div>
                        <?php
                        } ?>
                            <span><?php echo $input_config->typeContent; ?></span>
                        <?php
                    }
                }
            }
        }

    }
}
?>

<?php

if ($displayCaptcha) { ?>
        <div class="form-group captcha">
            <?php
            $captchaLabel = $captcha->label();
            if (!empty($captchaLabel)) {
                ?>
                <label class="control-label"><?php echo $captchaLabel; ?></label>
                <?php } ?>

            <div><?php $captcha->display(); ?></div>
            <div><?php $captcha->showInput(); ?></div>
        </div>
    <?php } ?>

    <div class="form-actions">
        <button type="submit" name="Submit" class="btn btn-primary"><?=t($submitLabel); ?></button>
    </div>
</form>
</div>
<?php
} else {
        ?>
        <p><?=t('This form is unavailable.'); ?></p>
    <?php
} ?>
</div>
