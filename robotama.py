import requests
import pprint

# PythonでHTTPリクエストを送信する時に利用できるライブラリは２種類ある。

#     1	urllib	標準ライブラリ	やや使いにくい
#     2	Requests	標準ライブラリではない	使いやすい

# 今回は、Requestsを使ったHTTPリクエストについて解説する。



# requests をインストールする
    # pip install requests

# get()メソッドでGETリクエストを送信する
response = requests.get("https://jsonplaceholder.typicode.com/todos/1")

# 結果を出力する
pprint.pprint(response)
# <Response [200]>

# Response-Objectを取得した🔥

# => リクエスト結果のオブジェクトが取得できる

# 値を取り出すための様々な関数が用意されている。


# オブジェクトの中身をそのまま出力すると
# どんな値を保持しているのかを確認することができる。

# vars()関数を利用すると、オブジェクトの中身を見ることができる。
pprint.pprint(vars(response))

# {
#     '_content': b'{\n  "userId": 1,\n  "id": 1,\n  "title": "delectus aut autem",'
#              b'\n  "completed": false\n}',
#  '_content_consumed': True,
#  '_next': None,
#  'connection': <requests.adapters.HTTPAdapter object at 0x000002A58A35DD20>,
#  'cookies': <RequestsCookieJar[]>,
#  'elapsed': datetime.timedelta(microseconds=44549),
#  'encoding': 'utf-8',
#  'headers': {'Date': 'Thu, 22 Sep 2022 06:23:12 GMT', 'Content-Type': 'application/json; charset=utf-8', 'Transfer-Encoding': 'chunked', 'Connection': 'keep-alive', 'X-Powered-By': 'Express', 'X-Ratelimit-Limit': '1000', 'X-Ratelimit-Remaining': '999', 'X-Ratelimit-Reset': '1652380831', 'Vary': 'Origin, Accept-Encoding', 'Access-Control-Allow-Credentials': 'true', 'Cache-Control': 'max-age=43200', 'Pragma': 'no-cache', 'Expires': '-1', 'X-Content-Type-Options': 'nosniff', 'Etag': 'W/"53-hfEnumeNh6YirfjyjaujcOPPT+s"', 'Via': '1.1 vegur', 'CF-Cache-Status': 'HIT', 'Age': '3971', 'Report-To': '{"endpoints":[{"url":"https:\\/\\/a.nel.cloudflare.com\\/report\\/v3?s=60c%2FbYflPnu9x8vcRkdWAjMaRrahrTdzY21cm84m%2Bmk8aaPbd9p8HASiJ78uBVKSmbZhVfA9pkScB6jugeYiUrbEaEZQ0qqfhFd%2F51V3DKQXotazgWXxE42dcccygcdSzeF7hin4wC0%2Fy5D3JIGK"}],"group":"cf-nel","max_age":604800}', 'NEL': '{"success_fraction":0,"report_to":"cf-nel","max_age":604800}', 'Server': 'cloudflare', 'CF-RAY': '74e8f355c99d80a1-NRT', 'Content-Encoding': 'gzip', 'alt-svc': 'h3=":443"; ma=86400, h3-29=":443"; ma=86400'},
#  'history': [],
#  'raw': <urllib3.response.HTTPResponse object at 0x000002A58A3F71C0>,
#  'reason': 'OK',
#  'request': <PreparedRequest [GET]>,
#  'status_code': 200,
#  'url': 'https://jsonplaceholder.typicode.com/todos/1'
#  }


# Response-Object から値を取り出すための様々な関数が用意されている。

# 簡単に説明すると

#     response.json()：JSON形式でレスポンスボディを取得
#     response.status_code：ステータスコードを取得
#     response.text：レスポンスボディを普通に取得
#     response.headers：レスポンスヘッダを取得
#     response.url：リクエスト時のURLを取得

# といった要領で様々なデータを取得することができる。

pprint.pprint(response.json())
# {'completed': False, 'id': 1, 'title': 'delectus aut autem', 'userId': 1}

pprint.pprint(response.status_code)
# 200

pprint.pprint(response.text)
# ('{\n'
#  '  "userId": 1,\n'
#  '  "id": 1,\n'
#  '  "title": "delectus aut autem",\n'
#  '  "completed": false\n'
#  '}')

pprint.pprint(response.headers)
# {'Date': 'Thu, 22 Sep 2022 06:30:58 GMT', 'Content-Type': 'application/json; charset=utf-8', 'Transfer-Encoding': 'chunked', 'Connection': 'keep-alive', 'x-powered-by': 'Express', 'x-ratelimit-limit': '1000', 'x-ratelimit-remaining': '999', 'x-ratelimit-reset': '1639535659', 'vary': 
# 'Origin, Accept-Encoding', 'access-control-allow-credentials': 'true', 'cache-control': 'max-age=43200', 'pragma': 'no-cache', 'expires': '-1', 'x-content-type-options': 'nosniff', 'etag': 'W/"53-hfEnumeNh6YirfjyjaujcOPPT+s"', 'via': '1.1 vegur', 'CF-Cache-Status': 'HIT', 'Age': '28277', 'Report-To': '{"endpoints":[{"url":"https:\\/\\/a.nel.cloudflare.com\\/report\\/v3?s=YRgNgw%2FKEj3tcBmTmq%2FUAyCDf%2BLqQz%2BNn6Mk1LOJywsMXlR82jTeMz1qBVXDZrPHN9SVuvVmGPSDm6zBVQ1kAFPcpfPSGIkCzsB7e0KZV6P4bttrLvTOMMgUMG3Dv78aycPPkk1tdXMOMn05wf1S"}],"group":"cf-nel","max_age":604800}', 'NEL': '{"success_fraction":0,"report_to":"cf-nel","max_age":604800}', 'Server': 'cloudflare', 'CF-RAY': '74e8feb77d61202b-NRT', 'Content-Encoding': 'gzip', 'alt-svc': 'h3=":443"; ma=86400, h3-29=":443"; ma=86400'}

pprint.pprint(response.url)
# 'https://jsonplaceholder.typicode.com/todos/1'


# POSTの使い方もGETとほぼ同じである。

# POSTの場合、リクエストヘッダやリクエストボディを設定するケースが多い。

# その場合は、引数に指定するだけでOKである。

# リクエストボディ：json=で指定
# リクエストヘッダ：headers=で指定


POST_URL = "https://jsonplaceholder.typicode.com/posts"

# リクエストボディを定義する
request_body = {'title': 'robotama', 'body': 'purupuru', 'userId': 1}

# POSTリクエストを、リクエストボディ付きで送信する
response = requests.post(POST_URL, json=request_body)

# レスポンスボディを出力する
pprint.pprint(response.json())


# 出力結果
# {'body': 'purupuru', 'id': 101, 'title': 'robotama', 'userId': 1}


# < 参考・引用 >

# 1. 【Python】HTTPリクエストを送信する（GET/POST）
# https://developers-book.com/2020/08/14/222/



