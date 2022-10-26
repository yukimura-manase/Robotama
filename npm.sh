
# < npmまとめ！ >

# npm(Node Package Manager)とは？

#     1. Node.jsのパッケージ管理ツール

#     2. パッケージのインストール、アンインストール、バージョンの管理などが可能

#     3. Node.jsをインストールすると同時にnpmもインストールされる


# npmコマンド

npm コマンド [オプション]



# ヘルプを表示します。

    $ npm help
    $ npm --help
    $ npm help コマンド
    $ npm -h コマンド


# npmのバージョンの確認

    
$ npm -v
$ npm --version
$ npm version


# [ パッケージのインストール ]
インストール方法は２つある


# npm環境をセットアップして、package.jsonを生成します。
    
    $ npm init


# グローバルインストール

    npm install -g パッケージ名

    npm i -g パッケージ名

    [ グローバルインストール ]

        • パッケージは全てのプロジェクト(ディレクトリ)で利用可能
        • パッケージは指定したルートの先のnode_modulesに保存される
        • 保存先は変更可能



# ローカルインストール

    npm install パッケージ名

    npm i パッケージ名


    [ ローカルインストール ]
        
        • パッケージはインストールした作業ディレクトリで利用可能
        • 作業ディレクトリのnode_modulesに保存される



# 複数インストールする際は半角スペースあける
$ npm install パッケージ名 パッケージ名


# パッケージのバージョンを指定していする際は@をつけて指定する
$ npm install パッケージ名＠バージョン


# [ インストールのオプションとショートカット ]

# インストールの際オプションを指定することで本番環境用、開発環境用など区別して保存可能
# package.jsonのdependencies → 本番環境用
# package.json の devDependencies → 開発環境用
# 本番環境用はプロジェクト複製の際にnpm installコマンドでインストールされる
# 開発環境用のパッケージは複製の際npm installコマンドでインストールされるが、インストールの際に--production オプションを指定するとインストールされない

オプション	ショートカット	説明
--save	-S	• packahge.json の dependenciesに保存される
• prodはprodaction (本番環境) の意味をもつ
--save-dev	-D	• package.json の devDependencies に追加される
• devはdevelopment (開発環境) の意味をもつ

# package.jsonに追加してインストール

    # package.jsonに自動で追加する場合は–saveまたは–save-devオプションを使用します。


    $ npm install --save [パッケージ名]
    または
    $ npm install --save-dev [パッケージ名]


    これでpackage.jsonのdependenciesかdevDependenciesに自動て書き込みを行ってくれます。


## プロジェクトからアンインストール (npm uninstall)

    $ npm uninstall [パッケージ名]

# uninstallコマンドも省略や以下のコマンドでも同様にアンインストールが行えます。

    $ npm un [パッケージ名] 
    $ npm remove [パッケージ名] 
    $ npm r [パッケージ名] 
    $ npm rm [パッケージ名] 


# package.jsonからも削除してアンインストール

    #インストール同様に –saveまたは–save-davのオプションを付けます。


    $ npm uninstall --save [パッケージ名]
    または
    $ npm uninstall --save-dev [パッケージ名]


依存関係を含めないインストール済みのパッケージの確認

$ npm ls --depth=0
依存関係を含めたインストール済みのパッケージの確認

$ npm ls
こちらも同様に-gオプションを使用するとグローバル環境のパッケージの確認が行えます。



最新になっていないパッケージを一覧表示 (npm outdated)
インストールした時点から、バージョンが更新されていて、最新ではないパッケージの一覧を表示します。


$ npm outdated




npmまとめ！
https://zenn.dev/thao_0108/articles/10bb038982eff3


いまさら聞けない！npmのこれだけは知っておきたい基礎知識
https://www.webprofessional.jp/beginners-guide-node-package-manager/


npm入門
https://www.tohoho-web.com/ex/npm.html


npmとyarnのコマンド早見表
https://qiita.com/rubytomato@github/items/1696530bb9fd59aa28d8



npmでよく使うコマンドまとめ
https://hirooooo-lab.com/development/npm-command/


