import { useState, useEffect } from 'react';

const containerStyle = {
    textAlign: "center",
  };
  
  const buttonStyle = {
    margin: "20px"
  };

export const UseEffectSample = ()=>{


    const [count, setCount] = useState(0);
    const [count2, setCount2] = useState(0);

    // Component の生成後や state 変更の度に呼び出される
    useEffect(() => {
        console.log('Component の生成後や state 変更の度に呼び出される useEffect()');
    });

    // Component の生成後に1度だけ呼び出される
    useEffect(() => {
        console.log('Component の生成後に1度だけ呼び出される useEffect()');
    }, []);
  
    // count の変更を監視している
    useEffect(()=>{
      console.log('Robotama を監視している useEffect() が実行されました');
    },[count]);

    // count2 の変更を監視している
    useEffect(()=>{
        console.log('Gunmar を監視している useEffect() が実行されました');
    },[count2]);


    return (
      <div style={containerStyle}>
        <h1>useEffect-Sample</h1>
        <h2>Robotama-Counter: { count }</h2>
        <h2>Gunmar-Counter: { count2 }</h2>
        <button onClick={() => setCount(count + 1)} style={buttonStyle}>Robotama +</button>
        <button onClick={() => setCount2(count2 + 1)} style={buttonStyle}>Gunmar +</button>
      </div>
    );
  
  }

