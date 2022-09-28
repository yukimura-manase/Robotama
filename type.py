import datetime

### 型宣言・型-Check・データ型の変換方法(Cast)まとめ🔥

# 型宣言

    # 「 変数: 型 」の形で宣言する

# Pythonにおけるデータ型の確認方法

    # type(targetData)

    # targetData => 型を確認したいData

# Pythonでのデータ型の変換方法(Cast)

    # 型名(targetData)

    # targetData => 型変換したいData


### Python での型宣言 & 型-Check

# str型：文字列
string: str = 'ロボ玉'

print(string) # ロボ玉
print(type(string)) # <class 'str'>

# int型：整数
integer: int = 12

print(integer) # 12
print(type(integer)) # <class 'int'>

# float型：小数点
double: float = 12.34

print(double) # 12.34
print(type(double)) # <class 'float'>


# bool型：真偽値
boolean: bool = True

print(boolean) # True
print(type(boolean)) # <class 'bool'>

# list型：リスト
array: list = ['ロボ玉試作1号機', 'ロボ玉試作2号機', 'ロボ玉試作3号機']

print(array) # ['ロボ玉試作1号機', 'ロボ玉試作2号機', 'ロボ玉試作3号機']
print(type(array)) # <class 'list'>


# tuple型：タプル => 定数-List
tupleData: tuple = ('robotama', 'hakutou', 'momo')

print(tupleData) # ('robotama', 'hakutou', 'momo')
print(type(tupleData)) # <class 'tuple'>


# dict型：辞書
dictionary: dict = {
    'robotama-1': 'ロボ玉試作1号機',
    'robotama-2': 'ロボ玉試作2号機',
    'robotama-3': 'ロボ玉試作3号機',
}

print(dictionary) # {'robotama-1': 'ロボ玉試作1号機', 'robotama-2': 'ロボ玉試作2号機', 'robotama-3': 'ロボ玉試作3号機'}
print(type(dictionary)) # <class 'dict'>


date: datetime = datetime.datetime.now()

print(date) # 2022-09-22 17:39:43.047093
print(type(date)) # <class 'dict'>




# Python での型変換(Cast)


# 文字列str型から整数int型への変換
stringInt = '12'

integer2 = int(stringInt)

print(integer2, type(integer2)) # 12 <class 'int'>


# 文字列str型から浮動小数点float型への変換
stringDouble = '12.34'

double2 = float(stringDouble)

print(double2, type(double2)) # 12.34


# 整数int型から文字列str型への変換

num1 = 30

str1 = str(num1)

print(str1, type(str1))


# 浮動小数点float型から文字列str型への変換

num2 = 30.45

str2 = str(num2)

print(str2, type(str2))


# 日付datetime型から文字列str型への変換

date1 = datetime.datetime(2020,1,31,12,36,45)

	
date1.strftime("%Y/%m/%d %H:%M:%S")

type(date1.strftime("%Y/%m/%d %H:%M:%S"))


# 文字列str型から日付datetime型への変換

str1 = '2020/01/31 12:36:45'
type(str1)

datetime.datetime.strptime(str1, '%Y/%m/%d %H:%M:%S')

type(datetime.datetime.strptime(str1, '%Y/%m/%d %H:%M:%S'))



# 図解！Python データ型を徹底解説！(確認・変換・指定方法と種類一覧)
# https://ai-inter1.com/python-data_type/




