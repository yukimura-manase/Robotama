import * as React from 'react';
import { Routes, Route } from 'react-router-dom';

import { HeaderNav } from './HeaderNav';

import  {NotFound } from './NotFound';

import { UseEffectSample } from './Effect';

import { UseEffectExample } from './Effect-2';

import { PostRequest } from './PostRequest';

import '../style/App.css';

const { useState } = React;

const containerStyle = {
  textAlign: "center",
};

const buttonStyle = {
  margin: "20px"
};

// 1. useState() の Sample
export const UseStateSample = () => {

  
  const [count, setCount] = useState(0);

  return (
  <div style={containerStyle}>
    <h1>useState-Sample</h1>
    <p>
      <button onClick={() => setCount(count - 1)} style={buttonStyle}>-</button>

      {/* 状態管理されている値が、画面に出力される => 変更があれば、画面に即時反映される */}
      <b>{count}</b>
      <button onClick={() => setCount(count + 1)} style={buttonStyle}>+</button>
    </p>
  </div>
  );
};

const App = () => {
  return (
    <div className='App'>
        <HeaderNav />
        <Routes>
          <Route path='/' element={<UseStateSample />}/>
          <Route path='/effect' element={<UseEffectSample />}/>

          <Route path='/effect2' element={<UseEffectExample />}/>

          <Route path='/post' element={<PostRequest />}/>
          
          {/* どの Path にも Matchしない場合の Components */}
          <Route path='*' element={<NotFound />}/>
        </Routes>
    </div>
  );
}

export default App;
