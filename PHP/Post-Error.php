// < Error 411. The request must be chunked or have a content length. PHP エラーの解決方法 >

// Postなのに、PostデータをSetしていないので、エラーが発生しています。

// => 空配列をSetするか、明示的に、array('Content-Length: 0') をSetすれば、解決します。

$post_url = "https://www.msil.go.jp/msilgisapi/api/layer/layer";
$post_curl = curl_init($post_url);

curl_setopt($post_curl, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($post_curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));

// 1. 明示的に、array('Content-Length: 0') を Setする
curl_setopt($post_curl, CURLOPT_POSTFIELDS, array('Content-Length: 0'));


// 2. または、 空配列を Setする
// curl_setopt($post_curl, CURLOPT_POSTFIELDS, array());

curl_setopt($post_curl, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
curl_setopt($post_curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($post_curl, CURLOPT_RETURNTRANSFER, true); // レスポンスを文字列で受け取る

$post_response = curl_exec($post_curl);

$post_http_info = curl_getinfo($post_curl);

// 6. curlの処理を終了 => コネクションを切断
curl_close($post_curl);

var_export($post_response);
