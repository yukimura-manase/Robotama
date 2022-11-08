
// < Fetch-API-Test >


// Fetch APIはブラウザに実装されているので、ライブラリなどが不要で、そのまま使用することが可能です。

// JSON-Placeholder を使って、fetch-APIのテストをする。

// 1. Test用のhtmlを作って、fetch-Acess可能なページを表示する。

// fetch関数は、戻り値がPromiss


// < then() 記述Pattern Ver. Get >

// [ thenパターンでFetch APIを使う ]

// ここまでは、async/awaitパターンでFetch APIを使用する方法を紹介してきましたが、then ~ catchパターンでFetch APIを使う方法も最後に紹介します。

// Fetch APIは、fetch関数でリクエストを送信する所と、response.json(),response.text()などのレスポンス本文を取得する関数で、それぞれPromissが返ってくるため、thenを２段階で構える必要があります。

fetch('https://jsonplaceholder.typicode.com/todos/')
    .then(response => response.json())
    .then(json => console.log(json))
    .catch(e => console.error(e.message));



// < await 記述Pattern Ver. Get >

// Fetch APIの fetch 関数でGETリクエストを送信し、結果（レスポンス）をJSONで取得する例です。
const response = await fetch('https://jsonplaceholder.typicode.com/todos/');

if(response.ok){
    console.log("正常です");
}

// Response-Object => Response はフェッチ API のインターフェイスで、リクエストのレスポンスを表します。

if (response instanceof Response) console.log('Response-Objectです');


// Response.body 読取専用 => 本文のコンテンツの ReadableStream です。

// Response.headers 読取専用 => レスポンスに関連した Headers オブジェクトが入ります。

// Response.ok 読取専用 => レスポンスが成功 (200–299 の範囲のステータス) したか否かを通知する論理値が入ります。

// Response.redirected 読取専用 => レスポンスがリダイレクトの結果である (つまり、その URL リストには複数のエントリーがある) かどうかを示します。

// Response.status 読取専用 => このレスポンスのステータスコードを返します (成功ならば 200 になります)。

// Response.statusText 読取専用 => ステータスコードに対応したステータスメッセージが入ります (たとえば 200 ならば OK)。

// Response.type 読取専用 => レスポンスの種類です。 (例えば basic, cors)

// Response.url 読取専用 => レスポンスの URL を返します。


console.log(' Response-プロパティ');
console.log('response.body:', response.body);               // response.body: ReadableStream {locked: false}
console.log('response.headers:', response.headers);         // response.headers: Headers {}
console.log('response.ok:', response.ok);                   // response.ok: true
console.log('response.redirected:', response.redirected);   // response.redirected false
console.log('response.status', response.status);            // response.status 200
console.log('response.statusText:', response.statusText);   // response.statusText:
console.log('response.type:', response.type);               // response.type: cors
console.log('response.url:', response.url);                 // response.url: https://jsonplaceholder.typicode.com/todos/



console.log('Response-メソッド');

// Response.json():  レスポンスの本体のテキストを JSON として解釈した結果で解決するプロミスを返します。

// JSONで取得
const jsonData = await response.json();
console.log('response.json():', jsonData);


// Response.text(): レスポンスの本体のテキスト表現で解決するプロミスを返します。

// テキストデータで取得
// const textData =  await response.text();
// console.log('response.text():', textData);


// Response.arrayBuffer(): レスポンスの本体を表す ArrayBuffer で解決するプロミスを返します。

// バイナリデータバッファで取得
// const bufferData = await response.arrayBuffer();
// console.log('response.arrayBuffer():', bufferData);


// フォームデータで取得
// const formData = await response.formData();

// Blobで取得
// const blobData = await response.blob();




// [ POSTリクエストを送る ]

// 1. フォーム（multipart/form-data）形式でPOSTする

// フォーム形式の multipart/form-data でPOSTする場合は、FormDataクラスにデータを格納して送信します。

const form = new FormData();
form.append('nama', 'Robotama');
form.append('address', 'Saitama');

const formResponse = await fetch("https://httpbin.org/post", {
  method: "POST",   // GET POST PUT DELETEなど
  body: form        // リクエスト本文にフォームデータを設定
});

console.log(await formResponse.json());


// 2. application/x-www-form-urlencoded形式でPOSTする

// URLエンコードありのフォーム形式の application/x-www-form-urlencoded でPOSTする場合は、URLSearchParamsクラスを使います。

const params = new URLSearchParams();
params.append('id', 123);
params.append('name', 'Robotama Gunmar');


const postResponse = await fetch("https://httpbin.org/post", {
  method: "POST",   // GET POST PUT DELETEなど
  body: params, // リクエスト本文にURLSearchParamsを設定
});

console.log(await postResponse.json());


// 3. JSON形式（application/json）でPOSTする

// JSON形式のデータを POSTする場合は、bodyに JSON.stringify などで文字列にした JSON形式のデータを設定します。

// また、このままでは Content-Type がプレーンテキストの text/plain として判別されてしまうため、合わせて 'Content-Type': 'application/json' ヘッダを設定します。

const requestBody = {
    msg: 'ロボ玉',
    from: 'グンマー帝国'
};


const postRes = await fetch("https://httpbin.org/post", {
  method: "POST",   // GET POST PUT DELETEなど
  headers: {
    'Content-Type': 'application/json'
  },
  body: JSON.stringify(requestBody),    // リクエスト本文をセット
});

console.log(await postRes.json());
// {args: {…}, data: '{"msg":"ロボ玉","from":"グンマー帝国"}', files: {…}, form: {…}, headers: {…}, …}



// [ Fetch APIで HTTPのステータスコードを取得する ] 

// リクエストが成功したかを確認するには、Responseオブジェクトのokプロパティで取得できます。

// okプロパティは、HTTPステータスコードが200番台（200～299）であればtrueを返し、それ以外の400や500番台のHTTPステータスコードであればfalseを返します。

// < Sucsess-Pattern >
const robotamaFetch = async () => {
        
    const response = await fetch('https://jsonplaceholder.typicode.com/todos/');

    if(response.ok){
        console.log("通信成功です！");
    }
};

robotamaFetch();



// < 参考・引用🔥 >

// Fetch APIの使い方！JavaScriptでGET/POSTを非同期で送信
// https://www.sukerou.com/2020/10/fetch-apijavascirpthttp.html

// fetch()
// https://developer.mozilla.org/ja/docs/Web/API/fetch

// Response
// https://developer.mozilla.org/ja/docs/Web/API/Response






