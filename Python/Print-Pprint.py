
import pprint


# pip install ipython
from IPython.core.display import display

# pip install pandas
import pandas as pd

### print() と pprint() と display() の違いとは？ 使い分け方について ###

# print（）とpprint（）はどちらもPythonプリントモジュールです。機能は基本的に同じです。


robotamaList =  [
    {
        'robotama': 'ロボ玉試作1号機',
        'from': '神聖グンマー帝国',
        'power': 1000,
        'purupuruFlag': True
    },
    {
        'robotama': "ロボ玉試作2号機",
        'from': 'トチギー公国',
        'power': 2000,
        'purupuruFlag': True
    },
    {
        'robotama': "ロボ玉試作3号機",
        'from': 'さいたまー共和国',
        'power': 3000,
        'purupuruFlag': True
    },
]



## 1. print ##

print(robotamaList)

# 1行で表示される・・・
# [{'robotama': 'ロボ玉試作1号機', 'from': '神聖グンマー帝国', 'power': 1000, 'purupuruFlag': True}, {'robotama': 'ロボ玉試作2号機', 'from': 'トチギー公国', 'power': 2000, 'purupuruFlag': True}, {'robotama': 'ロボ玉試作3号機', 'from': 'さいたまー共和国', 'power': 3000, 'purupuruFlag': True}]

# 通常のprintではリストや辞書の要素が改行されることなく1行で出力されます。やはりこれだと少し見づらいですね。



## 2. pprint ##

# 改行表示される！

pprint.pprint(robotamaList)
# [{'from': '神聖グンマー帝国',
#   'power': 1000,
#   'purupuruFlag': True,
#   'robotama': 'ロボ玉試作1号機'},
#  {'from': 'トチギー公国',
#   'power': 2000,
#   'purupuruFlag': True,
#   'robotama': 'ロボ玉試作2号機'},
#  {'from': 'さいたまー共和国',
#   'power': 3000,
#   'purupuruFlag': True,
#   'robotama': 'ロボ玉試作3号機'}]

# pprintはリストや辞書の要素が改行して見やすく出力します。

# pprintの頭文字のpは「pretty」のpです => pretty => 綺麗・整っている という意味合いがある🔥


# Pythonの標準ライブラリであるpprintモジュールを使うと、リスト（list型）や辞書（dict型）などのオブジェクトをきれいに整形して出力・表示したり、
    # 文字列（str型オブジェクト）に変換したりすることができる。pprintは「pretty-print」の略。


# 複雑なデータ構造と長いデータ長を持つデータには、pprint（）が適しています。


# また、pprint() では、出力の仕方を引数で、変更することができます。


## 出力幅（文字数）を指定: 引数width

## 出力する要素の深さを指定: 引数depth

## インデント幅を指定: 引数indent





## 番外編: ipython のdisplay() との違いは？ ##

# display()はdataframe形式の表のレイアウトを保持してくれます。


df = pd.DataFrame(
    [[2, 3, 4, 5], [1, 2, 3, 4]], 
    index=['sample1', 'sample2'], 
    columns=['propertyA', 'propertyB','propertyC','propertyD']
)


print(df)

display(df)



### < 参考・引用 > ###

# 1. Pythonのpprintの使い方（リストや辞書を整形して出力）
# https://note.nkmk.me/python-pprint-pretty-print/



# 2. print()、display()、pprint()の違い
# https://punhundon-lifeshift.com/print_display_pprint






