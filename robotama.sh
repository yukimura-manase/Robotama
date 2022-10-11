
### ファイル・ディレクトリ操作の基本コマンド

# 1. pwd：現在のディレクトリ（カレントディレクトリ）を確認

# pwd => print working directoryの略

robotama@OHTI20180115-1:~$ pwd
/home/robotama

# 2. ls：ディレクトリの内容を表示 

# ls => list segments の略


### echoコマンドとは？ ###

# このようなことができるコマンドになります。

# 画面に文字列の表示(Consoleに標準出力)

# コマンドの実行結果の表示

# 文字列をファイルに出力(ファイルに標準出力)

# 文字列をファイルに追記

echo 'Robotama'

# コマンドの実行結果の表示 => 直前のコマンドの実行結果が判定できる
echo $?

# 実行結果	内容
# 0	True(コマンドの実行が成功)
# 1	False(コマンドの実行が失敗)
# 127	コマンドが見つからない


## 文字列をファイルに出力
echo 'Robotama' > Robotama.txt
robotama@OHTI20180115-1:~$ ls -al

-rw-r--r-- 1 robotama robotama    9 10月 11 10:26 Robotama.txt

robotama@OHTI20180115-1:~$ cat Robotama.txt

# Robotama

## 文字列をファイルに追記



echo 'ぷるぷるロボ玉' >> Robotama.txt

cat Robotama.txt

# Robotama
# ぷるぷるロボ玉

# 注意
# 実作業の際には、>と>>を間違えないようにお気をつけ下さい。
# (意味が全然違います。)

# > : ファイル全体の上書き
# >> : ファイルの最終行に1文を追記

# 重要なファイルの作業を実施する際は、必ずcpコマンドにてバックアップを取得しましょう。


### 「 ; 」区切りで、インラインで(1行で)実行できる

echo Robotama; echo PuruPuru; echo Kawaii
# Robotama
# PuruPuru
# Kawaii

# 「 ; 」で区切らないと、直前のコマンドとの区別ができない。
echo Robotama echo PruPru
# Robotama echo PruPru

### touch & cat コマンド ### 

# ファイルの作成は、touchコマンド
touch Gunma.txt

# ファイルの中身を確認する catコマンド
cat Gunma.txt

# 文字列をファイルに出力(書き込み)して、catで確認する
echo 'Gunma-Robotama' > Gunma.txt; cat Gunma.txt


### ShellScriptの基礎知識まとめ ###

#!/bin/bash

# １行目に利用するシェルを書く

# echo => 標準出力
echo "Hello World!"

### 変数と文字列の扱い ###

# 変数に格納する => 「 = 」の前後にスペースを入れてはいけない。
robotama="ロボ玉"

echo $robotama

echo "$robotama"

echo "${robotama}"

# 変数の中身ではなく文字列として表示されてしまう
echo '$robotama'


# 文字列の連結はくっつけるだけ
echo $robotama$robotama # ロボ玉ロボ玉
echo "$robotama And $robotama" # ロボ玉 And ロボ玉


### 四則演算 ###

## 数値計算に使う $(( ... )) は読みやすい🔥

# expr コマンドによる計算は書き方が面倒です。

# $((...))で計算を実施しましょう🔥

# bash だけではなく全ての POSIX 準拠のシェルで使うことができます。

# なみに似たような機能で let コマンドや ((...)) がありますが、どの環境でも使えるのは $((...)) だけです。

x=10
echo $x # 10
echo $x+2 # 10+2
echo $(($x+2))
echo $((($x+5) * 2))

readonly y=20
y=25 # y: readonly variableというエラーが出る


### 配列 ###

# 添字を指定して中身を取り出すには波括弧を使う
# $aで最初の要素が表示される
# ${a[@]}で全ての要素が表示される
# ${#a[@]}で要素数が表示される

a=(2 4 6)
echo $a # 2
echo ${a[0]} # 2
echo ${a[1]} # 4
echo ${a[@]} # 2 4 6
echo ${#a[@]} # 3


# 波括弧を忘れた場合、最初の要素と文字列を連結した文字列になる
echo $a[1] # 2[1]


## 値の代入、要素の追加

# 代入、追加時に波括弧は要らない

# 配列に代入する
a=(2 4 6)
a[2]=10 
echo ${a[@]} # 2 4 10

# 配列に値を追加する
a+=(20 30)
echo ${a[@]} # 2 4 10 20 30


# `date`は日付や曜日を要素とした配列になっている。
d=(`date`)
echo $d # 2014年 11月 12日 水曜日 11時09分30秒 JST
echo ${d[3]} # 水曜日



### 日付の取得・操作

# 今日の日付
date
# 2022年 10月 11日 火曜日 10:03:44 JST


# -d 'N days ago' オプションで N 日前の日付を取得できる。

# 2日前の日付を取得する
date -d '2 days ago'

# 2022年 10月  9日 日曜日 10:02:49 JST

# 現在の月を取得する
date '+%m'
# 10

# Nヶ月前の月を取得する
date -d "`date '+%Y-%m-01'` 1 months ago" '+%m'

# 現在日時から10秒前の日時を求める
date -d '10 seconds ago'
# 現在日時から10秒後の日時を求める
date -d '10 seconds'
# 現在日時から10分前の日時を求める
date -d '10 minutes ago'
# 現在日時から10分後の日時を求める
date -d '10 minutes'
# 現在日時から10時間前の日時を求める
date -d '10 hours ago'
# 現在日時から10時間後の日時を求める
date -d '10 hours'
# 現在日時から10日前の日時を求める
date -d '10 days ago'
# 現在日時から10日後の日時を求める
date -d '10 days'
# 現在日時から10ヶ月前の日時を求める
date -d '10 months ago'
# 現在日時から10ヶ月後の日時を求める
date -d '10 months'
# 現在日時から10年前の日時を求める
date -d '10 years ago'
# 現在日時から10年後の日時を求める
date -d '10 years'


# 日付のフォーマットを指定して実行
# 上記のコマンドはそれぞれフォーマットを指定して実行することも可能である。

date -d '12 hours ago' '+%Y-%m-%d [%H:%M:%S]'

# 指定した日時で実行

# date コマンドで表示される日時を現在日時ではなく、次のように指定した日時で date コマンドを実行することも可能である。


# 現在日時を「2006/01/01 12:13:14」としてコマンドを実行する
date -d '2006/01/01 12:13:14'

# フォーマットの指定も可能
date -d '2006/01/01 12:13:14' '+%Y %m %d - %H %M %S'



### 条件式の記述 ###

# ポイント
# 正常終了は0が返ってくる

# testコマンドで条件式を評価できる（ちなみにtestは[]で置き換え可能）


# $?で、直前に終了した命令が正常終了したかどうかを評価する


## 比較演算子 ##

# -eq ： equal
# -ne ： not equal
# -gt ： greater than (◯◯より大きい)
# -ge ： greater than or equal (◯◯以上)
# -lt ： less than (◯◯より小さい)
# -le ： less than or equal (◯◯以下)


# testコマンドで、条件式を記述する
test 1 -eq 2
echo $?
# 1
# 1 は、false => コマンド実行の結果が、失敗したことを意味する🔥

# testコマンドではなく、[] を使っても条件式を記述することができる。
[ 1 -eq 2 ]
echo $?
# 

test 1 -eq 1
echo $?
# 0

# 「 ; 」区切りで、インラインで(1行で)実行できる
test 1 -eq 2; echo $? # 1 ←正常でない
test 1 -eq 1; echo $? # 0 ←正常終了


# 文字列とファイル

## 文字列の比較演算子 ##

# = ： equal
# != ： not equal

## ファイルの比較演算子 ##

# -nt ： newer than
# -ot ： older than
# -e ： exist (存在しているかどうか)
# -d ： directory (ディレクトリかどうか)


## 論理演算子 ##
# -a ： and
# -o ： or
# ! ： is not


# ファイルが存在するかどうか
test -e hello.sh; echo $? # 0

# 1 = 1 && 2 == 2 
test 1 -eq 1 -a 2 -eq 2; echo $? # 0



### 条件分岐 ###

## if-文 ##

# if のあとに条件式を書く

# 条件に合致していれば　then　から　fi　まで実行

x=20
if [ $x -gt 60 ]
    then
    echo "Robotama"
elif [ $x -gt 40 ]
    then
    echo "Gunma"
else 
    echo "PuruPuru"
fi 
    echo "必ず呼び出されるRobotama"









### 参考・引用 ###

# 1. シェルスクリプトの基礎知識まとめ
# https://qiita.com/katsukii/items/383b241209fe96eae6e7


# 2. 今どきのシェルスクリプトは数値計算にexprを使わない（POSIX準拠）
# https://qiita.com/ko1nksm/items/46fa9df8031275c7dc0a


# 3. 日付を取得する | UNIX & Linux コマンド・シェルスクリプトリファレンス
# https://shellscript.sunone.me/date.html


# 4. 【Linux】echoコマンドの使用方法
# https://qiita.com/masato930/items/6031785e23d8fdbb1a5a


# 5. 知識0から始めるVim講座
# https://qiita.com/JpnLavender/items/fabcc79b4ab0d52e1f6d


# 6.【超初心者Linux】第2夜：基本コマンドを使いながら覚えるのれす！(pwd,cd,ls,mkdir,rmdir,cp,mv,rm)
# https://dogandrun.hatenablog.jp/entry/2013/11/30/181606


# 7. lsコマンドの使い方と覚えたい15のオプション【Linuxコマンド集】
# https://eng-entrance.com/linux_command_ls









