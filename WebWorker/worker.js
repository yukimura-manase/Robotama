// バックグラウンド処理・並列処理
self.onmessage = (event) => {

    // Parameter (引数)の取得
    let params = event.data;

    // ここで「バックグラウンド処理・並列処理」させたい重い処理を実行する
    const response = `${params}なのだ！`;

    // Web-Worker で処理した結果を返す
    self.postMessage(response);
};


// 1. Web Worker => 「Web Worker」は、JavaScriptでバックグラウンド処理(並列処理)を実行するための機能です。

// 2. Web Workerの使い方

    // バックグラウンド処理は独立スレッドで実行するので、個別ファイルに記述します。

    // バックグラウンド処理を呼び出すスクリプトでは、ワーカーを生成し、バックグラウンド処理の結果取得のコールバックを追加してから、バックグラウンド処理を呼び出します。

// 3. Web Workerからアクセスできる機能、できない機能

// 4. inline-worker => 「inline-worker」を使うことで、バックグラウンド処理を別ファイルで分けず1つのファイルで記述することができます。



// < 参考・引用🔥 >

// 1. javascriptのWebWorkerを使ってみた
// https://qiita.com/qiiChan/items/5179a7e540257d38c181


// 2. Web Workerの使い方
// https://note.com/npaka/n/nc930b61840ac

