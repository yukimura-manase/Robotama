
import traceback


RobotamaDataSet = {
    "robotama": "ロボ玉",
    "purupuru_flag": True,
    "age": 2,
    "from": "神聖グンマー帝国",    
    "brother_list": [
        "ロボ玉試作1号機",
        "ロボ玉試作2号機",
        "ロボ玉試作3号機"
    ],
    "skill": {
        "purupuru": "ぷるんぷるん",
        "hamham": "はむはむ",      
        "sleep": "すやー"
    }
}


print('Robotama-DataSet-Parse')

# try-ブロック => 例外処理の判定ブロック
try: 

    robotama = RobotamaDataSet['skill']['robotama']

# except-ブロック => 異常系の処理ブロック
except Exception as error :

    # traceback.format_exc() で例外の詳細情報を取得する
    error_msg:str = traceback.format_exc()

    print(error_msg)

# else-ブロック => 正常系の処理ブロック => 例外が発生しなかったときの処理ブロック
else :

    print('正常系の処理を実行するブロック')


# finally-ブロック => 必ず最後に実行される処理
finally :

    print('必ず最後に実行したり処理を実行するブロック')

    try:
        print(Robotama)

    # 例外を無視したい場合は、pass を使用する
    except Exception as error:
        pass

    try :
        # 意図的に Exception クラスのエラーを発生させる
        raise Exception("Robotama-Error-発生")

    except Exception as error :

        print(error)


