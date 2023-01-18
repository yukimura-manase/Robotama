<?php
namespace Application\Job;
use \Concrete\Core\Job\Job as AbstractJob;

use Express;
use Concrete\Core\Express\EntryList;

# Debug専用のLog
use Concrete\Core\Support\Facade\Log;

// APIからデータを取得して、エクスプレスに格納するPHPファイル

class UmisiruApi extends AbstractJob
{

    public function getJobName()
    {
        return t("Umisiru Api Data Fetch.");
    }

    public function getJobDescription()
    {
        return t("Fetch data from Umisiru Api.");
    }

    // Job-実行内容
    public function run()
    {
        // [ ジョブを作成する: https://concrete5-japan.org/help/5-7/developer/jobs/creating-a-job/ ]

            // run() メソッドから返された文字列は自動的にジョブの管理画面ページで表示されます。
            // 一般的にこの文字列は、ジョブによって処理されたアイテム数などの、実行が成功した際の詳細メッセージを表示します。

            // エラーハンドリング => ジョブのエラーハンドリングは例外を投げることで行います。
            // ジョブの中で単に例外を投げるだけで、ジョブはエラー結果を管理画面UIに表示します。


        \Log::addEntry('Star Umisiru Api PHP-Job！');

        
        // まずは、既存のデータをクリーンナップする => お片付け

        $entity = Express::getObjectByHandle('umisiru_api_data');
        $entryList = new EntryList($entity);
        $entries = $entryList->getResults();

        // 配列 & 空配列以外ならば、クリーンナップ処理を実行する
        if (is_array($entries) && !($entries == false) ) {
            \Log::addEntry('Clean up existing data！');
            
            foreach ($entries as $entry) {
                Express::deleteEntry($entry->getId());
            }
            \Log::addEntry('Finished cleaning up existing data！');
        } else {
            \Log::addEntry('Cleanup target data did not exist！');
        }

        \Log::addEntry('Umisiru Api Data Fetch Start！');

        $post_url = "https://www.msil.go.jp/msilgisapi/api/layer/layer";
        $post_curl = curl_init($post_url);
        
        curl_setopt($post_curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($post_curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
        curl_setopt($post_curl, CURLOPT_POSTFIELDS, array('Content-Length: 0'));
        curl_setopt($post_curl, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
        curl_setopt($post_curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($post_curl, CURLOPT_RETURNTRANSFER, true); // レスポンスを文字列で受け取る
        
        $post_response = curl_exec($post_curl);
        $post_http_info = curl_getinfo($post_curl);
        
        curl_close($post_curl);

        
        if ($post_http_info['http_code'] !== 200) {
            throw new Exception("Post error with API.");
        }

        $umisiru_data_set = json_decode($post_response);

        // 3つの key を取得して、Expressにデータを登録する => 1つの情報項目のデータセット

            // "disp_info_name_ja": "貝殻 [底質]" =>表示名
            // "category1_ja": "地形・地質"  => 大分類
            // "category2_ja": "底質"  => 中分類

        foreach ($umisiru_data_set->data as $d) {
                
            // Entry(Recode・実データ)の作成 => データを投入する
            $entry_data = Express::buildEntry('umisiru_api_data')
            ->setAttribute('display_name', $d->disp_info_name_ja)
            ->setAttribute('large_classification', $d->category1_ja)
            ->setAttribute('middle_classification', $d->category2_ja)
            ->save();
        }

    }
}
