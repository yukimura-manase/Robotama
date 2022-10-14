

< SQLab中級編 >


[ 集計とグループ化 ]
【集計】
分類	関数名	説明
集計	SUM	各行の値の合計を求める
MAX	各行の値の最大値を求める
MIN	各行の値の最小値を求める
AVG	各行の値の平均値を求める
計数	COUNT	行数をカウントする


-- [問題文] 女性の著者数を取得してください。

-- SQLのCOUNT関数を使うと、条件に一致したレコード数を取得することができます。
select count(*) from authors where gender = '女性';

-- SELECT  COUNT(*)  FROM  表名;


【SQL】COUNTの使い方（レコード数取得）
https://medium-company.com/sql-count/


-- [問題文] 書籍の販売数(figure)の合計値を取得してください。

select sum(figure) from book_sales;


-- [問題文] 書籍の総ページ数の平均値を取得してください。

select avg(total_page) from books;


-- [問題文] 書籍の総ページ数の最大値、最小値を取得してください。

select max(total_page), min(total_page) from books;


[ 並び順を整える🔥 ]


-- [問題文] 書籍一覧を発売年が新しい順に並び替えて取得してください。

select * from books order by release_year desc;


-- order by => 取得結果を並べ替える

-- 昇順→ASC、　降順→DESC



-- [問題文] 発行年毎の書籍数を取得してください。
-- また、書籍数は降順に並び替えてください。
-- 出力項目はrelease_year(発行年)とbooks_num(書籍数)です。


select release_year, count(*) as books_num from books 
group by release_year 
order by books_num desc;

-- GROUP BY句を使用することで、同じ値同士のデータをグループ化、そして集合関数を使いグループごとに集計することができます。

-- SQLの「GROUP BY」を使用することで、同じ値同士のデータをグループ化することができます。


【SQL】GROUP BY句の使い方（グループ化）
https://medium-company.com/sql-group-by/


-- GROUP BY句はテーブルをいくつかのグループに分ける働きをします。

-- 指定したカラムの値ごとの合計値や平均値、最大値・最小値を取得したいような場合に役立ちます🔥

-- GROUP BY 句を使用すると指定したカラムの値を基準にデータをグループ化することができます。




-- [問題文] 発行年別の書籍数を取得してください。
-- また、書籍数は降順に並び替え、書籍数が2つ以上のデータを取得してください。
-- 出力項目はrelease_year(発行年)とbooks_num(書籍数)です。


select release_year, count(*) as books_num from books
group by release_year
having count(*) >= 2
order by books_num desc;


-- まず「HAVIING」を一言で説明すると、「抽出条件を指定」する命令です。

-- SELECT [表示したい要素] FROM [テーブル名] HAVING [抽出条件];

SELECT * FROM user HAVING team="チームA";


[ 「WHERE」と「HAVING」の違い ]


先ほどの処理は「WHERE」で書いても全く同じ結果が返ってくるんです。

SELECT * FROM user WHERE team="チームA";


違いは呼ばれるタイミング🔥

    => 見出しにも書いてありますが、違いはズバリ呼ばれるタイミングです


    今回の主役である「WHERE」と「HAVING」は画像の通り「WHERE」→「GROUP BY」→「HAVING」の順に呼ばれるわけです。つまり間にある「GROUP BY」が関わってこなければ、全く同じ挙動をしますが、
    「GROUP BY」を使って、グループ化を行った際には、以下の違いが出てくるわけです。

    WHERE・・・グループ化をされる前の段階、つまり元々のデータでの抽出条件を指定できる

    HAVING・・・グループ化した後の情報での、抽出条件を指定できる。


【SQL】一目でわかる!HAVINGとWHEREの違いと活用方法
https://www.sejuku.net/blog/73003




< INSERT編 >

    SQLにおけるINSERT文は「どのようなデータをどのテーブルに登録するか」を記述したものです。

        
    < insertでRecode-新規作成 >


    【 基本構文 】

    仕様：テーブルにデータを登録する（列名指定） 

    INSERT INTO テーブル名 (列名1, 列名2,...) VALUES (値1, 値2,...);


    [ 参考・引用 ]
        INSERT文（SQLを基本から学ぶシリーズ）
        https://products.sint.co.jp/topsic/blog/sql-insert#toc-0



-- [問題文] イベントテーブルに
--「イベント名：2022 WEBデザイントレンド、最大人数：100人」のイベントを追加後、
-- イベント一覧を取得してください。


insert into events (id, name, max_num) values (3, '2022 WEBデザイントレンド', 100);

select * from events order by id asc;



------------------------------------------------------------------------------------------------------------------------------------------------------

< update文で更新する！ >

基本は、whereで更新するレコードを指定してupdateする！


1. UPDATE対象が全レコード

    ではまず、一番シンプルな「全レコードを更新する場合」を見てみましょう。

    仕様：テーブル employeesのnameというカラムを「名前」という値で更新する。

    UPDATE employees SET name = '名前'

    ここは基本中の基本なので迷うことはありませんね。
    
    ですが、全レコードを更新することは稀です。だいたい条件を指定して、それに合うレコードだけ更新します。



2. 特定のレコードを更新する！

    仕様：テーブルの全データの中から、条件に合ったものだけを更新する => whereで指定！

    UPDATE (表名) SET (カラム名1) = (値1) WHERE (条件);

    UPDATE employees SET title = 'Mr.' WHERE gender = 'M';

    カラムが複数の場合は、カンマで区切ります。

    仕様：テーブルの全データの中から、条件に合ったものだけを更新する（複数カラム）

    UPDATE (表名) SET (カラム名1) = (値1), (カラム名2) = (値2) WHERE (条件);



UPDATE文（SQLを基本から学ぶシリーズ）
https://products.sint.co.jp/topsic/blog/sql-update

------------------------------------------------------------------------------------------------------------------------------------------------------

< SQLのUPDATE文の書き方あれこれ。 >

    UPDATE
     テーブル名
    SET
      列名1 = 値1
     ,列名2 = 値2
     [,･･･]
    WHERE
     [条件];


SQLのUPDATE文の書き方あれこれ。
https://qiita.com/ryota_i/items/d17c7630bacb36d26864

------------------------------------------------------------------------------------------------------------------------------------------------------


-- [問題文] イベント「最新の英語学習法を学ぼう」の最大人数を30人に変更してください。
-- イベント一覧を取得してください。


update events set max_num = 30 where name = '最新の英語学習法を学ぼう';
select * from events order by id asc;



-- [問題文] イベント「最新の英語学習法を学ぼう」を削除してください。
-- イベント一覧を取得してください。


delete from events where name = '最新の英語学習法を学ぼう';

select * from events order by id asc;



[ DELETE編 ]

DELETE FROM テーブル名 WHERE 条件

delete from robotama_table where id = robotama;



[ サブクエリ🔥 ]

sql サブクエリとは？？？

サブクエリとはSQLの中に書くSQLのことです。 SQL文を実行することをクエリ（問合せ）の発行と呼びます。 

当然の話ですが、クエリを発行するとその結果が表形式で取得できるのがOracleです。 

サブクエリが入っているクエリはまずサブクエリから実行され、実行結果を一つのテーブルと見なしながらメインクエリが実行されます。


SQLのサブクエリ（副問合せ）とは？～初心者向けに書き方を解説～
https://products.sint.co.jp/siob/blog/what-is-sql-subquery


[ サブクエリ【SQL】（英：subquery）とは ]

    ショボい例だけど、例えば「SELECT * FROM (SELECT column1 FROM tbl1)」のように、SQL文の中に入れ子になってSQL文が書かれていること。

    言い方を変えると

        SQL文の結果を使ったSQL文🔥

    です。

    もしくは

    「SELECT * FROM (SELECT column1 FROM tbl1)」における
    
    「SELECT column1 FROM tbl1」の部分のように、入れ子になって書かれているSQL文における中に書いてある方のSQL文のこと


サブクエリ【SQL】とは
https://wa3.i-3-i.info/word17573.html




    (SELECT column1 FROM tbl1) 
    
        => () の中に、SQL-Queryを記述する🔥

        => 処理結果が、1つのTable構造としてみなされる🔥



-- [問題文] 書籍名「コードと回路」より総ページ数の多い書籍一覧を取得してください。

-- 書籍名「コードと回路」の総ページ数を取得する
select total_page from  books where name = 'コードと回路';

-- 上記を踏まえた、答え🔥

-- [ Answer ]
-- 書籍名「コードと回路」より総ページ数の多い書籍一覧を取得
select * from books where total_page > (select total_page from  books where name = 'コードと回路');



-- [問題文] 書籍名「時短レシピ100」「かもめ飛行」と発行年が同じ書籍一覧を取得してください。


-- 書籍名「時短レシピ100」「かもめ飛行」と発行年を取得する
select release_year from books where name = '時短レシピ100' or name = 'かもめ飛行';

-- 上記を踏まえた、答え🔥

-- [ Answer ]
-- 書籍名「時短レシピ100」「かもめ飛行」と発行年が同じ書籍一覧を取得する
select * from books 
where release_year 
in (select release_year from books where name = '時短レシピ100' or name = 'かもめ飛行');




[ Tableの結合: JOIN句🔥 ]


「JOIN」とは
まずそもそも「JOIN」とはなんなのかですが、先ほども説明した通り複数テーブルの結合を行いたいときに使用する命令です。

テーブルを結合して、ひとまとめにできるわけですね!そしてこの「JOIN」の種類は大きく分けると、3種類存在します。

    クロス結合
    内部結合
    外部結合

の3種類です。それぞれの違いと、コマンドの書き方を見ていくことにしましょう。



1. クロス結合とは => cross join

クロス結合は一言でいうとすべての組み合わせ作成する結合方式です。

    SELECT * FROM team CROSS JOIN user;



2. 「INNER JOIN」(内部結合)

    内部結合とは
    これは、指定した関連性のある要素を軸にして、組み合わせてくれる命令です。


    使ってみる

        今回は「team_id」が関連性のある要素です。これを軸に組み合わせてみましょう。

        実行命令:

        SELECT * FROM team INNER JOIN user ON team.team_id = user.team_id;



3. 「OUTER JOIN」(外部結合)


最後に外部結合です。外部結合には、さらに3種類の結合方式が存在します。とはいえど、怯える必要がありません!

先ほどの内部結合が理解できていれば理解するのは簡単です。

なぜなら外部結合とは「内部結合 + α」の情報を表示するだけの方式だからです。

そして、この「+α」部分になにを指定するかを選ぶのが、先ほど話した3種類「LEFT OUTER JOIN」「RIGHT OUTER JOIN」「FULL OUTER JOIN」なのです。

今回は代表して「LEFT OUTER JOIN」を使用して、詳しく見てみましょう。



【SQL】これで完璧テーブル結合!JOINの種類と使い方を一覧まとめ
https://www.sejuku.net/blog/73650


[ JOIN構文 ]

複数のテーブルから情報を取得する必要がある際、テーブルを連結することでクエリの発行から情報の取得までを一度で済ませることができます。

複数のテーブルを連結させるには、FROMで複数のテーブルを指定することで実現することができます。

複数のテーブルを指定するには、テーブル名とテーブル名の間にカンマ( , )、もしくはJOINを挟みます。

    SELECT * FROM テーブル名, テーブル名

JOINを使って同様のことが行えます。

    SELECT * FROM テーブル名 JOIN テーブル名

次のクエリは、購入履歴(purchase)テーブルと顧客(customer)テーブルを結合し、[購入ID(id_p)] フィールド、[名前(fullname)]

フィールドを表示します。


SELECT id_p, fullname 
FROM purchase JOIN customer ON purchase.id_c=customer.id_c;


購入履歴(purchase)テーブルと顧客(customer)テーブルを結合するために、JOINを使っています。

ON以降の「purchase.id_c = customer.id_c」という箇所は、

「顧客履歴テーブルと顧客テーブルの[顧客ID(id_c)]フィールドの値が一致したレコードを選択する」という意味です。


複数のテーブルにリレーションを張るには、FROMの部分に複数のテーブルをカンマ( ,)かJOINで区切って並べ、

ONでそれらのテーブルを連結する条件を指定します。


SELECT構文：JOINを使ってテーブルを結合する
https://rfs.jp/sb/sql/s03/03_3.html



-- [問題文] 書籍テーブルと著者テーブルを結合してください。
-- 出力項目はbook_name(書籍名)とauthor_name(著者名)です。


select books.name as book_name, authors.name as author_name  
from books 
join book_authors
on books.id = book_authors.book_id
join authors
on book_authors.author_id = authors.id;



[ テーブルの結合🔥 ]

    テーブルの結合（例）

        SELECT 日付, 名前 AS 費目, メモ
        FROM 家計簿
        JOIN 費目
            ON 家計簿.費目ID = 費目.ID


    ON句には、相互に等しいデータが所属しているカラムを左辺右辺に設定する🔥


    ONでそれらのテーブルを連結する条件を指定します🔥




< 参考・引用🔥 >


SQLab
https://sqlab.net/


SQLab: SQL中級編
https://sqlab.net/works/intermediate/


【これだけ覚えてたらOK！】SQL構文まとめ
https://qiita.com/tatsuya4150/items/69c2c9d318e5b93e6ccd



