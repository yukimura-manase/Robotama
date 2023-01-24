<?php


use \Concrete\Core\Entity\Attribute\Key\Settings\SelectSettings;
use Concrete\Core\Entity\Attribute\Value\Value\SelectValueOptionList;
use Concrete\Core\Entity\Attribute\Value\Value\SelectValueOption;

// 追加したい Option-Listを渡す
function selectSettings($options, $isMultiple=false)
{
    $settings = new SelectSettings();
    $list = new SelectValueOptionList();
    $list->setOptions(selectOptions($options, $list));
    $settings->setOptionList($list);
    if($isMultiple)
    {
        $settings->setAllowMultipleValues(true);
    }
    return $settings;
}

// 
function selectOptions($optionArray, $list)
{
    $options = [];
    $displayOrder = 0;
    foreach($optionArray as $option)
    {
        $o = new SelectValueOption();
        $o->setSelectAttributeOptionValue($option);
        $o->setDisplayOrder($displayOrder);
        $o->setOptionList($list);
        if(is_object($o))
        {
            $options[] = $o;
            ++$displayOrder;
        }
    }

    return $options;
}


// Class: \Concrete\Core\Express\ObjectBuilder
$object = Express::buildObject('object', 'objects', 'Expressオブジェクト', $pkg = null);


$object->addAttribute('select', '性別', 'object_sex', selectSettings(['男', '女'], true));

$object->save();




// [concrete 8.2+] Expressオブジェクトとセレクトボックス属性をパッケージインストールで追加する
//  https://qiita.com/calmtech/items/3df4394c275a5c3031b8
