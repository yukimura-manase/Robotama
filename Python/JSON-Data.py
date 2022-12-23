import json

### JSONデータの読み込みと作成方法(load, dumps)、エンコードとデコードの方法 ###

# JSONファイルを読み込む
jsonFile = open('./Robotama.json', 'r', encoding="utf-8")

# JSONファイルは、Pythonだと「_io.TextIOWrapper」というClass
print(type(jsonFile))
# <class '_io.TextIOWrapper'>

## JSON文字列をパース(decode)する => JSON文字列を読み込む
parseData = json.load(jsonFile)

print(type(parseData))
# <class 'dict'>

print(parseData)
# {'robotama': 'ロボ玉', 'purupuru_flag': True, 'age': 2, 'from': '神聖グンマー帝国', 'brother_list': ['ロボ玉試作1号機', 'ロボ玉試作2号機', 'ロボ玉試作3号機'], 'skill': {'purupuru': 'ぷるんぷるん', 'hamham': 'はむはむ', 'sleep': 'すやー'}}

print(parseData['robotama'])
# ロボ玉

print(parseData['brother_list'][0])
# ロボ玉試作1号機

print(parseData['skill']['purupuru'])
# ぷるんぷるん


## 辞書型をJSON-文字列に変換する => JSON-encoding

jsonEncode = json.dumps(parseData, ensure_ascii=False, indent=2)

    # ensure_ascii=False を設定しておくと、日本語をそのまま表示できる => Unicode-Escape をさせない。
    # indent=2 => インテンドの指定もできる！

print(type(jsonEncode))
# <class 'str'>

print(jsonEncode)
# {
#     "robotama": "ロボ玉",
#     "purupuru_flag": true,
#     "age": 2,
#     "from": "神聖グンマー帝国",    
#     "brother_list": [
#         "ロボ玉試作1号機",
#         "ロボ玉試作2号機",
#         "ロボ玉試作3号機"
#     ],
#     "skill": {
#         "purupuru": "ぷるんぷるん",
#         "hamham": "はむはむ",      
#         "sleep": "すやー"
#     }
# }




### 参考・引用 ###

# Pythonでファイルに書き込まれたJSON文字列をパースする
# https://qiita.com/r-wakatsuki/items/105ef1b4ad843eb0e095










