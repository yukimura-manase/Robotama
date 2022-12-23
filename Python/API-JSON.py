
import requests
import json
import pprint


### PythonでAPI経由で取得した JSONデータをパースする方法🔥 ###


# JSONファイルをパースする記事は多いんだけど、WebAPIとかを叩いてレスポンスからパースするシンプルな記事が見当たらなかったので。


# get()メソッドでGETリクエストを送信する
response = requests.get("https://jsonplaceholder.typicode.com/todos/1")


#response.json()でJSONデータに変換して変数へ保存
jsonData = response.json()

# response.json() で取得したJSON-オブジェクトは、Dict
#JSONでの名前を指定することで情報がとってこれる

print(type(jsonData))
# <class 'dict'>

pprint.pprint(jsonData)
# {'completed': False, 'id': 1, 'title': 'delectus aut autem', 'userId': 1}

print(jsonData["userId"])
# 1



### 参考・引用 ### 


# PythonでWeb APIを叩いてJSONをパースする
# https://qiita.com/bow_arrow/items/4dcab3389c892baba1a5









