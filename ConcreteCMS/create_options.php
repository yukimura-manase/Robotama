<?php
namespace Application\Job;
use \Concrete\Core\Job\Job as AbstractJob;

use Express;
use Concrete\Core\Express\EntryList;
use Concrete\Core\Entity\Attribute\Value\Value\SelectValueOption;
use Database;
use Concrete\Core\Support\Facade\Log; # Debug専用のLog

// パスカルケースでClass名を命名する
class CreateInfoItemOption extends AbstractJob
{

    public function getJobName()
    {
        return t("Create option list.");
    }

    public function getJobDescription()
    {
        return t("Create select-option-list of information items.");
    }

    // Job-実行内容
    public function run()
    {

        \Log::addEntry('Start Create option list.！');

        // [ Task ]

        // 1. 海しる-APIのデータセット管理テーブルからデータを取得する & Option-Listを作成する

        // 2. データセット管理テーブルから取得したデータをもとに、Option-Listを作成する


        // [ 1. 海しる-APIのデータセット管理テーブルからデータを取得する & Option-Listを作成する ]

        $umisiru_api_entity = Express::getObjectByHandle('umisiru_api_data');
        $umisiru_api_entryList = new EntryList($umisiru_api_entity);
        $umisiru_api_entries = $umisiru_api_entryList->getResults();

        $option_list = [];

        foreach ($umisiru_api_entries as $umisiru_data_set) {

            // no_display => 非表示フラグ: Default-false
            if (!( $umisiru_data_set->getAttribute('no_display') )) {
                $large_classification = $umisiru_data_set->getAttribute('large_classification');
                $middle_classification = $umisiru_data_set->getAttribute('middle_classification');
                $group_name = "group@{$large_classification}({$middle_classification})";

                // グループ名が登録されていなかったら、グループ名を登録する
                if (!in_array($group_name, $option_list)) array_push($option_list, $group_name);

                array_push($option_list, $umisiru_data_set->getAttribute('display_name'));
            }
        }

        \Log::addEntry('海しる-APIのデータセット管理テーブルからデータを取得、完了！');

        // [ 2. データセット管理テーブルから取得したデータをもとに、Option-Listを作成する ]

        // 入力フォーム-Table
        $request_forms = Express::getObjectByHandle('msil_youbou_form');

        // Option-Listを作成する Handle名-List
        $attr_handle = ['information_item_select', 'existing_ocean_info_select', 'api_request_select'];

        foreach ($request_forms->getAttributes() as $attr) {
            

            // 属性情報からハンドル-Keyを取得する
            $handle = $attr->getAttributeKeyHandle();
            
            // Targetのハンドル-Keyだったら処理を開始する
            if (in_array($handle, $attr_handle)) {

                // 属性のコントローラーを取得する
                $controller = $attr->getController();

                $type = $attr->getAttributeKeySettings();
                $list = $type->getOptionList();
                $displayOrder = $list->getOptions()->count();

                foreach ($option_list as $value) {
                    $displayOrder++;

                    $option = new SelectValueOption();
                    $option->setSelectAttributeOptionValue($value);
                    $option->setIsEndUserAdded(true);
                    $option->setDisplayOrder($displayOrder);
                    $option->setOptionList($list);

                    $em = \Database::connection()->getEntityManager();
                    $em->persist($option);
                    $em->flush();
                }

            }
        }

        \Log::addEntry('Option-List作成、完了！');

    }
}
