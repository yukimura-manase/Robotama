<?php

// [ PHPでスマホやタブレット・PCなどのデバイス判定、デバイスごとで処理をわける方法 ]

// Mobile Detect を使うとスマホやタブレットなどを判別することができ、使い方はとても簡単です。

// Mobile Detect はユーザーエージェントの文字列や HTTP ヘッダーからデバイスやブラウザなどを判定する軽量の PHP クラスです。


// 1. composer でインストール

    // composer require mobiledetect/mobiledetectlib

// 2. require_once "Mobile_Detect.php";


// ファイルの読み込み（読み込みのファイルへのパスは環境に応じて変更）
require_once 'Mobile_Detect.php';
 
// インスタンスを生成
$detect = new Mobile_Detect;
 
// isMobile(): デバイスが「スマホ」or「タブレット」の場合 true を返す
if ( $detect->isMobile() ) {
 // デバイスが「スマホ」or「タブレット」の場合に実行する処理
}
 
// isTablet(): デバイスが「タブレット」の場合 true を返す
if( $detect->isTablet() ){
 // デバイスが「タブレット」の場合に実行する処理
}
 
// デバイスがスマホの場合だけの条件文
if( $detect->isMobile() && !$detect->isTablet() ){
 // デバイスがスマホの場合に実行する処理
}

// デバイスがPC or タブレット の場合だけの条件文
if (!$detect->isMobile() || $detect->isTablet()) {
}

// マジック メソッドを使用して特定のプラットフォームかどうかを確認することもできます。
if( $detect->isiOS() ){
}
 
if( $detect->isAndroidOS() ){
}
 
 

// [ 参考・引用🔥 ]

// 1. PHP でスマホやタブレットなどを判定 Mobile Detect
// https://www.webdesignleaves.com/pr/plugins/mobile_detect_php.php


// 2. Mobile Detect
// http://mobiledetect.net/

