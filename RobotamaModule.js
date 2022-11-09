
// JavaScriptでよく使うパターンを搭載した独自Moduleを開発する🔥

const RobotamaModule = {
    log: (...target) => { 
        console.log(...target);
    },

    // < Cookie-Method >
    setCookie: (key, val) => {
        document.cookie = `${key}=${val}`;
    },
    getCookie: (key) => {
        const cookieData = document.cookie;

        // Cookie を綺麗に分割するために「'; '」(セミコロン&半角スペース)で区切る！
        const cookieDataList = cookieData.split('; ');

        for (const cookie of cookieDataList) {
            
            const cookieSplit = cookie.split('=');
        
            // key名を指定して、Cookie-Valueを取り出します。
            if (cookieSplit[0] === key) {
                console.log('getCookie', cookieSplit[1]);
                return cookieSplit[1];
            }
        }
    },
    removeCookie: (key) => {
        // document.cookie = "削除対象のkey名=; max-age=0"; で削除できる。
        document.cookie = `${key}=; max-age=0`;
    },

    // < LocalStorage-Method >
    setLocalStorage: (key, val) => {
        localStorage.setItem(key, val);
    },
    getLocalStorage: (key) => {
        const item =  localStorage.getItem(key);
        console.log('getLocalStorage', item);
    },
    removeLocalStorage: (key) => {
        localStorage.removeItem(key);
    },

    // < SessionStorage-Method >
    setSessionStorage: (key, val) => {
        sessionStorage.setItem(key, val);
    },
    getSessiionStorage: (key) => {
        const item = sessionStorage.getItem(key);
        console.log('getSessiionStorage', item);
    },
    removeSessionStorage: (key) => {
        sessionStorage.removeItem(key);
    },

};


RobotamaModule.log('Robotama-Run-Start・・・', 'Nanoda🔥');


// -------------------------------- Cookie --------------------------------
RobotamaModule.setCookie('Robotama', 'Gunmar');

const cookie = RobotamaModule.getCookie('Robotama');

RobotamaModule.setCookie('Cookie-Monster', 'Cookie食べたい🔥');

const cookieMonster = RobotamaModule.getCookie('Cookie-Monster');

RobotamaModule.removeCookie('Cookie-Monster');


// -------------------------------- LocalStorage --------------------------------
RobotamaModule.setLocalStorage('PuruPuruFlag', true);

const puruPuruRobotama = RobotamaModule.getLocalStorage('PuruPuruFlag');


RobotamaModule.setLocalStorage('GunmarFlag', true);

RobotamaModule.removeLocalStorage('GunmarFlag');


// -------------------------------- SessionStorage --------------------------------

RobotamaModule.setSessionStorage('ロボ玉', 'ロボロフスキー・ハムスター');

const Robotama = RobotamaModule.getSessiionStorage('ロボ玉');


RobotamaModule.setSessionStorage('ProtoType-1', 'ロボ玉試作1号機');

const RobotamaProtoType1 = RobotamaModule.getSessiionStorage('ProtoType-1');

RobotamaModule.removeSessionStorage('ProtoType-1');




// < Window.localStorage >

    // localStorage プロパティはローカルの Storage オブジェクトにアクセスすることができます。 
    // localStorage は sessionStorage (en-US) によく似ています。
    // 唯一の違いは、localStorage に保存されたデータには保持期間の制限はなく、sessionStorage に保存されたデータはセッションが終わると同時に（ブラウザが閉じられたときに）クリアされてしまうことです。

    // https://developer.mozilla.org/ja/docs/Web/API/Window/localStorage




// < Window.sessionStorage >

    // sessionStorage プロパティで、 session Storage オブジェクトにアクセスできます。sessionStorage は Window.localStorage に似ています。
    // 唯一の違いは、localStorage に保存されたデータに期限がないのに対して、sessionStorage に保存されたデータはページのセッションが終了するときに消去されます。
    // ページのセッションはブラウザを開いている限り、ページの再読み込みや復元を越えて持続します。**新しいタブやウィンドウにページを開くと、新しいセッションが開始します。

    // https://developer.mozilla.org/ja/docs/Web/API/Window/sessionStorage





