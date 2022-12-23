import requests

import pprint


# PostするURL
POST_URL = 'https://robotama/api/posgre/m_dataset'



# リクエストボディを定義
request_body = {"classification_id": 1}


# 
response = requests.post(POST_URL, json=request_body, verify=False)



# JSON形式でレスポンスボディを取得
json_data = response.json()


pprint.pprint(json_data) # [{'name': 'Robotama-DataSet'}] 

classification_name = json_data[0]['name']

pprint.pprint(classification_name) # 'Robotama-DataSet'



