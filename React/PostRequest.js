import { useState } from 'react';

export const PostRequest = () => {

    const [paramNum, setNum] = useState(0);

    const [json, setJsonData] = useState('');

    const InputParams = (e) => {
        console.log(e);
        const val = e.target.value;
        setNum(val);
    };

    const fetchTodo = async () => {

        const response = await fetch(`https://jsonplaceholder.typicode.com/posts/${paramNum}`);

        console.log('response', response);

        const jsonData = await response.json();

        console.log('jsonData', jsonData);

        setJsonData(jsonData);
    };

    return (
        <div>
            <h1>PostRequest-Test</h1>

            <p>Numberを入力してください</p>
            <input type="number" onChange={ (e) => { InputParams(e) }} />


            <h2>あなたが入力した送信予定のParameter値は: {paramNum} です</h2>

            <button onClick={ () => { fetchTodo() }}>API-通信-Start</button>

            <div>
                {
                    json === '' ? <p>データを取得していません</p> :
                    <div>
                        <p>ID:{json.id}</p>
                        <p>タイトル:{json.title}</p>
                        <p>内容:{json.body}</p>
                    </div>
                }
            </div>

        </div>
    );
};
