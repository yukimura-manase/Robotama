
document.addEventListener('DOMContentLoaded',() => {
    
    // 送信ボタン
    const button = document.getElementById('submitBtn');

    console.log({button});

    const msgInput = document.getElementById('msgInput');

    console.log({msgInput});

    // Clickイベント
    button.onclick = () => {

        let inputMsg = msgInput.value;

        console.log({inputMsg});

        if (inputMsg === '') {
            window.alert('送信するメッセージを入力してください');
            return;
        }

        // 1. Web-Worker のインスタンスを作成する
        const worker = new Worker('worker.js');

        console.log({worker});

        // 2. バックグラウンド処理の結果を取得して、実行する処理を登録する
        worker.onmessage = (event) => {
            console.log('result: ', event.data);
            window.alert(event.data);
        }

        // 3. Web-Worker に実際にデータを渡す
        worker.postMessage(inputMsg);
    };

});

