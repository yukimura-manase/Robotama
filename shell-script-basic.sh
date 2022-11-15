
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



### 条件文の記述 ###

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


# [ 実行結果 ]
# PuruPuru
# 必ず呼び出されるRobotama



### case文 ###

# caseの値に合致したときに処理は)から;;まで

# 何にも当てはまらない時の条件は*)で指定する


signal="green"
case $signal in
 "red")
  echo "stop!"
  ;;
 "yellow")
  echo "caution!"
  ;;
 "green")
  echo "go!"
  ;;
 *)
  echo "..."
  ;;
esac
# go!



### ループ処理 ###

## 1. while文 ##

# 条件式の間だけdoとdoneの間の処理を行う

i=0
while [ $i -lt 12 ]
do
    i=$(($i + 1))
    echo $i
done

# [ 実行結果 ]
# 1
# 2
# 3
# 4
# 5
# 6
# 7
# 8
# 9
# 10
# 11
# 12


## 途中で抜けたりしたい時の記述

# $iが 3 or 5 の時にはなにもしない
# $iが12より大きい数値になったら、ループ終了

i=0
while : # :を使うと常に0(正常終了)を返すので、無限ループになる
do
    i=$(($i + 1))
    if [ $i -eq 3 -o $i -eq 5 ]; then
        continue
    fi
    if [ $i -gt 12 ]; then
        break
    fi  
    echo $i
done

# [ 実行結果 ]
# 1
# 2
# 4
# 6
# 7
# 8
# 9
# 10
# 11
# 12



## 2. for文 ##

# in に続くスペース区切りの値を入れていき do と done の間の処理を実行

for num in 1 2 3 4 5
do
    echo $num
done

# [ 実行結果 ]
# 1
# 2
# 3
# 4
# 5



## 配列を使いたい時 => プログラミング言語の配列のように「,」による区切りがいらないので、要注意です！

robotamaArray=('Robotama' 'ロボ玉' 'Robo-Ball')
for data in ${robotamaArray[@]}
do
    echo $data
done

# [ 実行結果 ]
# Robotama
# ロボ玉
# Robo-Ball


### コマンドライン・引数の使い方 ###

echo $0 # ファイル名
echo $1 # 1番目の引数
echo $2 # 2番めの引数
echo $@ # すべての引数
echo $# # 引数の数 => lenght (長さ)


### 関数 ###

    # 関数内で作った変数は関数外でも使用できる。

    # ローカル変数にしたい場合は local i=5 みたいにlocal というKeywordを使用する

    # functionは省略可能

function RobotamaCall() {
    echo "ロボ玉なのだ！"
}

RobotamaCall

# [ 実行結果 ]
# ロボ玉なのだ！

Hello() {
    echo "Hello $1 and $2"
}

Hello ロボ玉 神聖グンマー帝国のロボ玉

# [ 実行結果 ]
# Hello ロボ玉 and 神聖グンマー帝国のロボ玉





### 参考・引用 ###

# 1. シェルスクリプトの基礎知識まとめ
# https://qiita.com/katsukii/items/383b241209fe96eae6e7


# 2. 今どきのシェルスクリプトは数値計算にexprを使わない（POSIX準拠）
# https://qiita.com/ko1nksm/items/46fa9df8031275c7dc0a


# 3. 日付を取得する | UNIX & Linux コマンド・シェルスクリプトリファレンス
# https://shellscript.sunone.me/date.html

