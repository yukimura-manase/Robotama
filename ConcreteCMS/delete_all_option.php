<?php
namespace Application\Job;
use \Concrete\Core\Job\Job as AbstractJob;

use Express;
use Concrete\Core\Support\Facade\Log; # Debug専用のLog

// パスカルケースでClass名を命名する
class DeleteInfoItemOption extends AbstractJob
{

    public function getJobName()
    {
        return t("Delete all option list.");
    }

    public function getJobDescription()
    {
        return t("Delete all select-option-list of information items.");
    }

    // Job-実行内容
    public function run()
    {

        \Log::addEntry('Start Delete all option list.！');

                
        // 入力フォーム-Table
        $request_forms = Express::getObjectByHandle('msil_youbou_form');

        // Option-Listを作成する Handle名-List
        $attr_handle = ['information_item_select', 'existing_ocean_info_select', 'api_request_select'];

        foreach ($request_forms->getAttributes() as $attr) {
            

            // 属性情報からハンドル-Keyを取得する
            $handle = $attr->getAttributeKeyHandle();
            
            // Targetのハンドル-Keyだったら処理を開始する
            if (in_array($handle, $attr_handle)) {

                $controller = $attr->getController();

                // 初期化処理 => すべてのOptionを削除する
                $controller->setOptions([]);
            }
        }

        \Log::addEntry('Finish Delete all option list.！');
    }
}
