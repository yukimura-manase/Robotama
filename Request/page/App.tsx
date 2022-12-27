import React from 'react';

import '../style/App.css';

import Footer from '../components/Footer';

const App = () => {
  return (
    <article className="App-Page">

      {/* Header-Section */}
      <header className='wrapper'>
        <nav className='reqnav'>
          <ul>
            <li><a href="#">ご要望</a></li>
            <li><a href="https://www.msil.go.jp/msil/htm/toiawase.html">お問い合わせ</a></li>
          </ul>
        </nav>
        <h2>
          <span className='title'>Request</span>
          <span className='sub-title'>ご要望受付</span>
        </h2>
        <p>ご要望は下記アンケートフォームよりご入力ください。お問い合わせは上の「お問い合わせ」をクリックいただき、メールよりご連絡ください。</p>

        <div className='time-slider'>
          <ul>
            <li className='active'>情報のご入力</li>
            <li>入力内容の確認</li>
            <li>受付の完了</li>
          </ul>
        </div>
      </header>

      {/* Main-Section */}
      <main id='main-container' className='wrapper'>
        {/* ご要望アンケート-Section */}
        <section>
          <h3 className='section-title'>ご要望アンケート</h3>
          <div className='section-contents'>

            {/* アンケート項目-1 */}
            <h4 className='question'>
              <span className='required'>必須</span>
              <span>海洋状況表示システムの主な利用目的（複数選択可）</span>
            </h4>
            <ul className='answer-box flex-list'>
              <li><label htmlFor=""><input type="checkbox" />海洋レジャー</label></li>
              <li><label htmlFor=""><input type="checkbox" />物流・海運</label></li>
              <li><label htmlFor=""><input type="checkbox" />水産</label></li>
              <li><label htmlFor=""><input type="checkbox" />港湾管理</label></li>
              <li><label htmlFor=""><input type="checkbox" />海洋安全</label></li>
              <li><label htmlFor=""><input type="checkbox" />海洋教育</label></li>
              <li><label htmlFor=""><input type="checkbox" />環境保全</label></li>
              <li><label htmlFor=""><input type="checkbox" />油防除</label></li>
              <li><label htmlFor=""><input type="checkbox" />海洋開発</label></li>
              <li><label htmlFor=""><input type="checkbox" />その他(具体的な内容を入力してください。)</label></li>
            </ul>

            {/* アンケート項目-2 */}
            <h4 className='question'>
              <span className='required'>必須</span>
              <span>よく利用する情報項目（5項目まで選択）</span>
            </h4>
            <div className='answer-box'>
              <h5>よく利用する情報を下記検索欄にご入力ください。</h5>
              <select name="" id=""></select>
            </div>
            
            {/* アンケート項目-3 */}
            <h4 className='question'>
              <span className='required'>必須</span>
              <span>ご要望内容（複数選択可）</span>
            </h4>

            <div className='answer-box'>
              <h5>1.新たな海洋情報について</h5>
              <ul>
                <li><input type="checkbox" />自社、自組織が保有する情報の提供</li>
                <li><input type="checkbox" />他組織が保有する情報の掲載要望</li>
              </ul>
              <input type="text" />
            </div>

            <div className='answer-box'>
              <h5>2.既存の海洋情報について</h5>
              <p>※データ利用についての問い合わせは、メタデータの各提供機関にご連絡ください。</p>
              <p>改善を希望する情報項目を選択してください。(改善を希望する情報を下記検索欄にご入力ください。)</p>
              <select name="" id=""></select>
              <p>改善の希望内容を下記よりご選択ください。</p>
              <ul className='flex-list'>
                <li><input type="checkbox" />情報量の向上・数値の詳細化</li>
                <li><input type="checkbox" />場所の詳細化・拡大</li>
                <li><input type="checkbox" />時間帯による変遷</li>
                <li><input type="checkbox" />情報の更新頻度</li>
                <li><input type="checkbox" />過去の情報</li>
                <li><input type="checkbox" />その他</li>
              </ul>
              <p>【内容】</p>
              <input type="text" />
            </div>

            <div className='answer-box'>
              <h5>3.システムの機能について</h5>
              <p>※操作説明を確認の上、ご回答をお願いします。</p>
              <ul className='flex-list'>
                <li><input type="checkbox" />新たな機能の追加</li>
                <li><input type="checkbox" />現在の機能の改善</li>
                <li><input type="checkbox" />検索・レイヤー等の操作方法</li>
                <li><input type="checkbox" />スマホ版について</li>
                <li><input type="checkbox" />その他</li>
              </ul>
              <p>【内容】</p>
              <input type="text" />
            </div>

            <div className='answer-box'>
              <h5>4.APIについて</h5>
              <p>※APIに関するページをご確認の上、ご回答をお願いします。</p>
              <p>希望する対象の情報項目を選択してください。(希望する対象の情報を下記検索欄にご入力ください。)</p>
              <select name="" id=""></select>
              <ul className='flex-list'>
                <li><input type="checkbox" />APIの使用・利用例等の充実化</li>
                <li><input type="checkbox" />APIの利用方法について</li>
                <li><input type="checkbox" />その他</li>
              </ul>
              <p>【内容】</p>
              <input type="text" />
            </div>

            <div className='answer-box'>
              <h5>５.その他</h5>
              <p>【内容】</p>
              <input type="text" />
            </div>
            
          </div>
        </section>

        {/* 回答者について-Section */}
        <section>
          <h3 className='section-title'>回答者について</h3>
          <div className='section-contents'>
            
            {/* アンケート項目-4 */}
            <h4 className='question'>
              <span className='required'>必須</span>
              <span>業種（次の中から一つ選択してください。）</span>
            </h4>
            <div className='answer-box'>
              <ul className='flex-list'>
                <li><input type="radio" />IT・アプリ開発</li>
                <li><input type="radio" />建設</li>
                <li><input type="radio" />物流・海運</li>
                <li><input type="radio" />港湾管理</li>
                <li><input type="radio" />資源・エネルギー</li>
                <li><input type="radio" />環境</li>
                <li><input type="radio" />水産</li>
                <li><input type="radio" />気象</li>
                <li><input type="radio" />海洋開発</li>
                <li><input type="radio" />その他(具体的な業種を入力してください。)</li>
              </ul>
              <input type="text" />
            </div>
          
            {/* アンケート項目-5 */}
            <h4 className='question'>
              <span className='optionally'>任意</span>
              <span>差支えなければ回答者についてお答えください。</span>
            </h4>
            <div className='answer-box'>
              <h5>ご所属</h5>
              <input type="text" />
              <h5>お名前</h5>
              <input type="text" />
              <h5>連絡先（メールアドレス）</h5>
              <input type="email" />
            </div>

          </div>
        </section>

        <div className='confirm'>
          <div className='confirm-check'>
            <input type="checkbox" />
            <p>自社、自組織が保有する情報を提供いただける場合は、後日当方よりご連絡させていただきますので、連絡先等のご記入をお願いいたします。それ以外のお送りいただいた要望内容については、原則返信は行っておりませんので、あらかじめご了承ください。</p>
          </div>
          <div className='submit-box'>
            <button className='submit-btn'>確認画面に進む</button>
          </div>
        </div>

      </main>

      {/* Footer-Section */}
      <Footer />
    </article>
  );
}

export default App;
