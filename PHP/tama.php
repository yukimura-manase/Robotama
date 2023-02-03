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
function console_log_msil_youbou_form($data){
    echo '<script>';
    echo 'console.log('.json_encode($data).')';
    echo '</script>';
};


// < 1. 質問設定のデータ処理・Block >

// ご要望アンケートの質問設定リスト
$msil_question_request_list = [];

// 回答者アンケートの質問設定リスト
$msil_question_respondent_list = [];

// SelectBox(複数選択可 & マルチ選択可)
$msil_select_handle_list = [];

// 選択数の上限-List
$msil_select_limit_list = [];

// Inline-Styleな入力フォームのList
$msil_inline_style_list = [];

$request_question_entity = Express::getObjectByHandle('msil_request_question');
$request_question_entryList = new EntryList($request_question_entity);
$request_question_entries = $request_question_entryList->getResults();

// console_log_msil_youbou_form('$request_question_entries');
// console_log_msil_youbou_form($request_question_entries);

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

    if (!empty($select_search_box_id)) {
        $question_config->select_search_box_id = $select_search_box_id;
        array_push($msil_select_handle_list, $select_search_box_id);
 
        // null は、0(無制限)をSetしておく！
        $select_limit = $request_question->getAttribute('select_limit'); // セレクトBoxの選択上限数
        if (is_null($select_limit)) $select_limit = 0;
        // $question_config->select_limit = (int)$select_limit;
        array_push($msil_select_limit_list, [ $select_search_box_id => (int)$select_limit ]);
    }

    $inline_input_box = $request_question->getAttribute('inline_input_box'); // 横並びにしたいCheckBoxのハンドル名(複数選択可)

    if (!is_null($inline_input_box)) {
        $ex_result = explode('<br/>', $inline_input_box);
        $moji = str_replace(array("\r\n", "\r", "\n"), "@", $ex_result[0]); // 改行コードを削除する
        $result = explode('@', $moji);
        $handle_list = array_diff($result, ['']);
        foreach ($handle_list as $hanlde) {
            array_push($msil_inline_style_list, $hanlde); 
        }
        array_unique($msil_inline_style_list); // 重複する値は、削除する
    }
    
    // すべてのカラムごとの実データを確認した後の処理
    if ($request_flag) $msil_question_request_list[$sort_index] = $question_config;
    else $msil_question_respondent_list[$sort_index] = $question_config;
}

// console_log_msil_youbou_form('$msil_question_request_list');
// console_log_msil_youbou_form($msil_question_request_list);

// console_log_msil_youbou_form('$msil_question_respondent_list');
// console_log_msil_youbou_form($msil_question_respondent_list);

// console_log_msil_youbou_form('$msil_select_handle_list');
// console_log_msil_youbou_form($msil_select_handle_list);

// console_log_msil_youbou_form('$msil_select_limit_list');
// console_log_msil_youbou_form($msil_select_limit_list);

// console_log_msil_youbou_form('$msil_inline_style_list');
// console_log_msil_youbou_form($msil_inline_style_list);



// // App-Insatance => アプリ機能
$app = \Concrete\Core\Support\Facade\Application::getFacadeApplication();

$token = app('token');


// エクスプレスの管理画面から取得できる Express-ID
$express_form_id = 'e643cce3-9b86-11ed-925a-0242ac110003';


// < 3. 入力フォーム設定のデータ処理・Block >

// expressForm => Form-インスタンス => Controllerから受け取っている
// console_log_msil_youbou_form('$expressForm');
// console_log_msil_youbou_form($expressForm);

// フォーム設置時に設定した各入力項目
$af = Core::make('helper/form/attribute');


// console_log_msil_youbou_form('$af');
// console_log_msil_youbou_form($af);

// // エンティティ => テーブル
$entity = $expressForm->getEntity();

$provider = \Core::make('Concrete\Core\Express\Search\SearchProvider', array($entity, $entity->getAttributeKeyCategory()));
$set = \Core::make('Concrete\Core\Express\Search\ColumnSet\ColumnSet');
$available = $provider->getAvailableColumnSet();
$attributes = $entity->getAttributeKeyCategory()->getList();

// console_log_msil_youbou_form('$attributes');
// console_log_msil_youbou_form($attributes);


// { akID: handle_name }[]
$akID_handle_lsit = [];

foreach($attributes as $ak) {
    $akID = $ak->getAttributeKeyID();
    $handle_name = $ak->getAttributeKeyHandle();

    // console_log_msil_youbou_form('$handle_name');
    // console_log_msil_youbou_form($handle_name);
    array_push($akID_handle_lsit, (object)['akID' => $akID,  'handle_name' => $handle_name]);
}

// console_log_msil_youbou_form('$akID_handle_lsit');
// console_log_msil_youbou_form($akID_handle_lsit);


$controls = $expressForm->getControls();

// console_log_msil_youbou_form('$controls');
// console_log_msil_youbou_form($controls);


// 入力フォームの設定情報-List
$input_form_config = [];

$last_check_obj = null;

foreach($controls as $control){
    // console_log_msil_youbou_form('$control');
    // console_log_msil_youbou_form(get_class($control));

    $value = $af->setAttributeObject($control);

    $key = $control->getAttributeKey();

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

    if ($obj->handle_name == "last_check_box") $last_check_obj = $obj;
    else array_push($input_form_config , $obj);
}

// console_log_msil_youbou_form('$input_form_config');
// console_log_msil_youbou_form($input_form_config);

// console_log_msil_youbou_form('$last_check_obj');
// console_log_msil_youbou_form($last_check_obj);


?>

<script>

    // SelectBoxは、作成されているが、JavaScriptで検索機能や複数選択・解除機能を実装する

    // ダミー・セレクトボックス & 本物のSelectBoxで見せかけは、Formの整合性を取っている。


    // [ 注意点 ]

    // グローバルスコープ・エリアで const を使用するとバッティングするので注意！
    // => 検索機能付きのSelectBoxは、1ページで、複数作成される予定なので・・・


    // 選択肢・Optionの作成と追加を実行する関数
    function OptionCreator (selectBox, optionList, optGroupList) {

        console.log({optionList});
        
        optionList.forEach((opt, index) => {

        // 1. 最初は、<option value="">選択してください</option> を作成する
        if (index == 0) {
            let option = document.createElement('option');
            option.setAttribute('value', '');
            option.innerText = '選択してください';
            selectBox.appendChild(option);
        }

        // Optionを作って、所属するグループにSetする
        let option = document.createElement('option');
        option.setAttribute('value', opt.id);
        option.innerText = opt.value;

        let groupId = opt.groupId;

        console.log({groupId});

        let belongToGroup = document.getElementById(`${groupId}`);

        console.log({belongToGroup});

        // 所属するoptgroupがなかったら、追加する
        if (belongToGroup == null) {

            const belong = optGroupList.find(group => group.id == groupId);

            selectBox.appendChild(belong);

            belongToGroup = document.getElementById(`${groupId}`); // 再度、取得する
        }

        belongToGroup.appendChild(option);

        });
    }

    
                        
    function NoMatchOption (selectBox) {
        let option = document.createElement('option');
        option.setAttribute('value', '');
        option.innerText = '検索に該当はありません';
        selectBox.appendChild(option);
    }

    // SelectBoxを作成する関数 => 引数: 1. selectPrefBox: Select-HTML-Element, 2. optionList = {id: number, value: string}[]
    function SelectCreator (selectBox, optionList, optGroup, searchList, searchBool) {

        if (optionList.length == 0) return; 

        selectBox.innerHTML = ''; // 初期化処理

        // console.log({selectBox});
        // console.log({optionList});
        // console.log({searchList});
        // console.log({searchBool});
            
        // 1. グループ・カテゴリを作成する

        // optgroupタグを作成 => グループカテゴリを作成する
        const optGroupList = optGroup.map((group) => {
            let optgroup = document.createElement('optgroup');
            optgroup.setAttribute('id', group.id);
            optgroup.setAttribute('label', group.value);
            return optgroup;
        });

        // console.log({optGroupList});

        // 2. 選択肢・Optionの作成と追加
        if (searchList.length !== 0 && searchBool) OptionCreator(selectBox, searchList, optGroupList);
        else if (!searchBool) OptionCreator(selectBox, optionList, optGroupList);
        else NoMatchOption(selectBox);
    }

    // 関数で、カプセル化する！
    function InitialSelectCreator (akID, optionObj, selectLimit) {

        // console.log('InitialSelectCreator-Call-On');
        // console.log({akID});
        // console.log({optionObj});
        // console.log({selectLimit});

        let groupCount = 1;
        let groupId = '';

        let limitBool = (1 <= selectLimit) ? true : false;

        // OptGroup-配列 => {id: 'group_1', value: 'ロボ玉プロトタイプ'}[]
        let optGroup = [];

        // Option-配列 => {id: '16591', value: 'ロボ玉試作2号機', groupId: 'group_1_102'}
        let optionList = [];

        for (const key in optionObj) {
            const val = optionObj[key];
            const opt = {};

            // グループ・データなら、加工して、optGroupに投入する
            if (/^group@/.test(val)) {
                groupId = `group_${groupCount}_${akID}`;
                groupCount++;
                opt.id = groupId;
                opt.value = val.replace("group@", "");
                optGroup.push(opt);
            } else {
                opt.id = key;
                opt.value = val;
                opt.groupId = groupId;
                optionList.push(opt);
            }
        }
        // console.log({optGroup});
        // console.log({optionList});

        // DefaultのSelectBox
        let selectBox = document.getElementById(`msil_select_${akID}`);
        let options = selectBox.options;
        
        // ダミーの表示専用・SelectBox
        let dummySelectBox = document.getElementById(`msil_select_dummy_${akID}`);

        // 検索Box
        let searchbox = document.getElementById(`msil_searchbox_${akID}`);

        let searchResult = []; // 検索結果のOption-List
        
        // [ 2. 検索-Inputフォームで、動的にSelectBoxを再作成する => 検索によって、リアルタイムでSelectBoxを変更する  ]

        searchbox.addEventListener('input', (e) => { // 入力文字列を受け取る処理

            if (!e.target.value) return;

            let searchStr = e.target.value; // 検索文字列

            searchResult = optionList.filter((opt) => { // 検索文字列から絞り込む
                if (/^group@/.test(opt.value)) return false;

                let reg = new RegExp(`${searchStr}`); // 正規表現で変数を使用するためには、RegExp-Classを使用する
                return reg.test(opt.value); // 検索文字列のパターンと、登録データがマッチするかでTestをする
            });

            // console.log({searchResult});

            // SelectCreator(dummySelectBox, optionList, optGroup, searchResult);
        });

        // 検索ボタン
        let searchBtn = document.getElementById(`msil_search_btn_${akID}`);

        searchBtn.onclick = () => SelectCreator(dummySelectBox, optionList, optGroup, searchResult, true);
        

        // [ 3. SelectBoxで選択したものは、画面に表示される => 複数選択が可能である ]

        // 選択中のものを表示するInput-Box
        let dispDiv = document.getElementById(`disp_select_${akID}`);

        dummySelectBox.addEventListener('change', (e) => {

            // 選択してくださいは、弾く！
            if (!e.target.value) return;
            
            if (limitBool) {
                // 1. 設定された上限まで、選択可能にして、それ以上は、弾く！
                if (selectLimit <= dispDiv.childElementCount) {
                    alert(`選択できる数は、${selectLimit}までです`);
                    return;
                }
            }

            const id = e.target.value;
            const idList = [...dispDiv.children].map(btn => { return btn.id.replace("msil_btn_", "") });

            if (idList.some(i => i == id)) {
                alert('選択済みです');
                return;
            }

            // Optionデータを取得して、ボタンに紐づける
            const option = optionList.find(opt => opt.id == id);

            // ボタンを作成する
            let input = document.createElement('input');
            input.setAttribute('type', 'button');
            input.setAttribute('id', `msil_btn_${option.id}`);
            input.setAttribute('value', option.value);
            
            // 本物のSelectBoxをtrueにしておく！
            const target = document.getElementById(`msil_option_${option.id}`);
            target.selected = true;
            
            // 選択を解除する機能をボタンに付与する
            input.onclick = e => {
                // console.log(e.target);

                const btnId = e.target.id.replace("msil_btn_", "");
                const target = document.getElementById(`msil_option_${btnId}`);
                target.selected = false;

                dispDiv.removeChild(e.target);
            }

            dispDiv.appendChild(input);
        });
                    
        // [ 4. 検索状態をResetするボタンを作成する ]
        let resetBtn =  document.getElementById(`msil_reset_btn_${akID}`);

        resetBtn.onclick = () => SelectCreator(dummySelectBox, optionList, optGroup, [], false);
    }


</script>

<?php

// SelectBox(複数選択可 & マルチ選択可)を作成する処理
foreach ($input_form_config as $input_form) {

    // ハンドル名が登録されていれば、Targetである
    if (in_array($input_form->handle_name, $msil_select_handle_list)) {

        $akID = $input_form->keyID;
        $akID_json = json_encode($akID);

        $handle_key = $input_form->handle_name;
        $select_limit = 0;
        $select_limit = array_column( $msil_select_limit_list, $handle_key)[0];
        $select_limit_json = json_encode($select_limit);
        
        // Option-List => 選択肢-List
        $options = $input_form->options;
        $options_json = json_encode($options);

        // 要素数-長さ
        $options_length = count((array)$options);
        $count = 0;

        ob_start(); // 出力のバッファを開始する

        ?>
        <!-- name="akID[123][atSelectOptionValue][]" -->
        <select class="form-select" id="msil_select_<?php echo $akID ?>" name="akID[<?php echo $akID ?>][atSelectOptionValue][]" multiple hidden>
        <?php
        foreach ((object)$options as $id => $option) {

                // 初回だけは、両方とも false 
                $optgroup_flag = false;

                if ($count == 0) {
                   ?> <option value="">選択してください</option> <?php 
                }

                $count++;

                // 次のグループ名が来たら、</optgroup> でグループセットを閉じる
                if ((preg_match('/group@/', $option)) && $optgroup_flag) { 
                    
                    $optgroup_flag = false;
                ?>
                    </optgroup>
                <?php
                // グループ名 or 通常のOption
                } else if (preg_match('/group@/', $option)) {

                    $optgroup_flag = true;

                    $group = str_replace('group@', '', $option);

                    ?>
                    <optgroup label="<?php echo $group ?>">
                    <?php
                } else if ($count == $options_length) { // foreachのLast
                    ?>
                    </optgroup>
                    <?php
                } else {
                    ?>
                    <option id="msil_option_<?php echo $id ?>" value="<?php echo $id ?>">
                        <!-- id="akID[123][atSelectOptionValue]_16590" -->
                        <span id="akID[<?php echo $akID ?>][atSelectOptionValue]_<?php echo $id ?>"  >
                            <?php echo $option ?>
                        </span>
                    </option>
                    <?php
                }
                ?>
                
            <?php
        }
        ?>
        </select>

        <!-- ダミー・セレクトボックス -->
        <select class="form-select" id="msil_select_dummy_<?php echo $akID ?>">
        <?php

        $count = 0;

        foreach ((object)$options as $id => $option) {

                // 初回だけは、両方とも false 
                $optgroup_flag = false;

                if ($count == 0) {
                   ?> <option value="">選択してください</option> <?php 
                }

                $count++;

                // 次のグループ名が来たら、</optgroup> でグループセットを閉じる
                if ((preg_match('/group@/', $option)) && $optgroup_flag) { 
                    
                    $optgroup_flag = false;
                ?>
                    </optgroup>
                <?php
                // グループ名 or 通常のOption
                } else if (preg_match('/group@/', $option)) {

                    $optgroup_flag = true;

                    $group = str_replace('group@', '', $option);

                    ?>
                    <optgroup label="<?php echo $group ?>">
                    <?php
                } else if ($count == $options_length) { // foreachのLast
                    ?>
                    </optgroup>
                    <?php
                } else {
                    ?>
                    <option value="<?php echo $id ?>">
                        <?php echo $option ?>
                    </option>
                    <?php
                }
                ?>
                
            <?php
        }
        ?>
        </select>

        <div style="margin-top: 12px;">
            <span>上記のSelectBoxの検索</span>
            <input type="text" id="msil_searchbox_<?php echo $akID ?>" class="msil-select-searchbox">
            
            <!-- 検索ボタン・リセットボタン -->
            <input type="button" id="msil_search_btn_<?php echo $akID ?>" value="検索" class="msil-btn">
            <input type="button" id="msil_reset_btn_<?php echo $akID ?>" value="リセット" class="msil-btn">

            <!-- 選択中のものが表示される -->
            <p>選択されたものが表示されます (ボタンを押すと選択が解除されます)</p>
            <div id="disp_select_<?php echo $akID ?>"></div>
        </div>
        <script>
            // 関数で、スコープをクローズしている => 命名の衝突を避けるため
            InitialSelectCreator(<?php echo $akID ?>, <?php echo $options_json; ?>, <?php echo $select_limit_json; ?>);
        </script>

        <?php

        $select_box = ob_get_contents(); // バッファされた出力を取得する
        $input_form->typeContent = $select_box;
        ob_end_clean(); // バッファを削除する
    }
}

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
    font-size: 25px;
    font-weight: bold;
    border-bottom: #0084cc 2px solid;
    width: 100%;
    margin: 30px 0;
}



/* アンケートの質問 */
.msil-question {
    border-bottom: #d4d4d4 1px solid;
    background: #0084cc;
    color: #fff;
    padding: 10px 40px;
    font-size: 20px;
    font-weight: bold;
    width: 100%;
    margin: 30px auto;
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

/* CheckBox・Radio-Btn 横並び設定 */
.msil-inline_style {
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
    align-items: center;
    gap: 30px;
}

/* 入力フォームの説明文 */
.msil-input-description {
    margin: 30px 0 10px 0;
}

/* セレクトボックス専用の検索Box */
.msil-select-searchbox {
    width: 30%;
    border-radius: 8px;
}

/* 検索・リセットボタンのスタイル */
.msil-btn {
    background-color: transparent;
    border: none;
    cursor: pointer;
    outline: none;
    padding: 0;
    appearance: none;
}

.msil-btn {
    background: #eee;
    border-radius: 3px;
    justify-content: space-around;
    align-items: center;
    margin: 0 auto;
    max-width: 280px;
    padding: 10px 25px;
    color: #313131;
    transition: 0.3s ease-in-out;
    font-weight: 500;
}
.msil-btn:after {
  content: "";
  position: absolute;
  top: 50%;
  bottom: 0;
  right: 2rem;
  font-size: 90%;
  display: flex;
  justify-content: center;
  align-items: center;
  transition: right 0.3s;
  width: 6px;
  height: 6px;
  border-top: solid 2px currentColor;
  border-right: solid 2px currentColor;
  transform: translateY(-50%) rotate(45deg);
}
.msil-btn:hover {
  background: #6bb6ff;
  color: #FFF;
}
.msil-btn:hover:after {
  right: 1.4rem;
}


/* 

1. button要素のcssをリセットしたい
https://qiita.com/nabettu/items/1593af04e48444c45c53

2. HTMLとCSSのコピペでできるボタンデザイン50選
https://dubdesign.net/download/html-css/button-design/

*/

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

    <!-- Custom-Token-Generetor -->
    <?=Core::make('token')->output('msil_check');?>
    <input type="hidden" name="express_form_id" value="<?php echo $express_form_id; ?>">

<h3 class='msil-section-title'>ご要望アンケート</h3>

<!-- Express-Form-Start -->
<div class="ccm-block-express-form">
    

    <?php if (is_array($msil_question_request_list) && $msil_question_request_list == true) {

        // console_log_msil_youbou_form('Robotama-Debug-2');
        
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
                                <div class="msil-input-description"><?php echo $question_request->$handle; ?></div>
                            <?php
                            } 
                            
                            // Inline-Style(横並び設定)かどうかをCheckしている！
                            if (in_array($handle, $msil_inline_style_list, true)) {
                                ?>
                                <span class="msil-inline_style"><?php echo $input_config->typeContent; ?></span>
                                <?php
                            } else {
                                ?>
                                <span><?php echo $input_config->typeContent; ?></span>
                                <?php
                            }
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
                                <div class="msil-input-description"><?php echo $question_request->$handle; ?></div>
                            <?php
                            } 
                            // Inline-Style(横並び設定)かどうかをCheckしている！
                            if (in_array($handle, $msil_inline_style_list, true)) {
                                ?>
                                <span class="msil-inline_style"><?php echo $input_config->typeContent; ?></span>
                                <?php
                            } else {
                                ?>
                                <span><?php echo $input_config->typeContent; ?></span>
                                <?php
                            }
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
                            <div class="msil-input-description"><?php echo $question_respondent->$handle; ?></div>
                        <?php
                        } 
                        // Inline-Style(横並び設定)かどうかをCheckしている！
                        if (in_array($handle, $msil_inline_style_list, true)) {
                            ?>
                            <span class="msil-inline_style"><?php echo $input_config->typeContent; ?></span>
                            <?php
                        } else {
                            ?>
                            <span><?php echo $input_config->typeContent; ?></span>
                            <?php
                        }
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
                            <div class="msil-input-description"><?php echo $question_respondent->$handle; ?></div>
                        <?php
                        } 
                        // Inline-Style(横並び設定)かどうかをCheckしている！
                        if (in_array($handle, $msil_inline_style_list, true)) {
                            ?>
                            <span class="msil-inline_style"><?php echo $input_config->typeContent; ?></span>
                            <?php
                        } else {
                            ?>
                            <span><?php echo $input_config->typeContent; ?></span>
                            <?php
                        }
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
    <?php 
} ?>

<?php
if (!is_null($last_check_obj)) {
    ?>
    <div class="msil-last-check" id="msil-youbou-confirm"><?php echo $last_check_obj->typeContent; ?></div>
    <?php
}

?>
    <style>
        .form-actions {
            display: none;
        }
        .msil-last-check {
            margin-top: 50px;
        }
    </style>
    <div id="msil-youbou-submit" class="form-actions" style="text-align: center; margin: 20px auto;">
        <button type="submit" name="Submit" class="btn btn-primary"><?=t($submitLabel); ?></button>
    </div>
    <script>
        const confrimBtn = document.getElementById('msil-youbou-confirm');
        const submitBtn = document.getElementById('msil-youbou-submit');

        confrimBtn.onclick = (e) => {
            if (e.target.checked) submitBtn.style.display = 'block';
            else  submitBtn.style.display = 'none';
        }
    </script>

</form>
</div>
<?php
} else {
        ?>
        <p><?=t('This form is unavailable.'); ?></p>
    <?php
} ?>
</div>






