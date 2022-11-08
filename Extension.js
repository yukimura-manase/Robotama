// 拡張子チェックをして、該当のファイルか判定する



// 大文字小文字を区別しないパターン
const pattern = /.(jsf|hsx|R2S|RAW|s7k|xse|xtf|wmbf)$/i;

const ExtensionCheck = (file) => {
    const result = pattern.test(file);
    if (result) {
        console.log('拡張子-OK');
    } else {
        console.log('拡張子-NG');
    }
}


ExtensionCheck('Robotama.HSX');


ExtensionCheck('Robotama.docx');


ExtensionCheck('Robotama.jsf');



// 大文字小文字を区別するパターン
const pattern2 = /.(jsf|hsx|R2S|RAW|s7k|xse|xtf|wmbf)$/;

const ExtensionCheck2 = (file) => {
    const result = pattern2.test(file);
    if (result) {
        console.log('拡張子-OK');
    } else {
        console.log('拡張子-NG');
    }
}


ExtensionCheck2('Robotama.HSX');


ExtensionCheck2('Robotama.docx');


ExtensionCheck2('Robotama.jsf');





// JavaScript ファイル拡張子チェック
// https://qiita.com/yasuken/items/0b97e34a16345ca4e6dc
