# Time-attendance Management App

## 資料

<https://github.com/epkotsoftware/dev-laravel-learning-docs/blob/main/README.md>

## 環境構築手順

### 1. .env の編集

[.env](./.env)ファイルはDockerの環境ファイルです。  
基本的にはそのまま使用可能ですが、IPとポートが重複するとコンテナが起動しないので  
自身の環境に合わせて設定を変えてください。

### 2. コマンド実行

```sh
# リポジトリをクローン
git clone https://github.com/bunta-yamasaki-epkotsoftware/Time-attendance-management-app.git
# 2. リポジトリに移動
cd Time-attendance-management-app
# 3. コンテナ起動
docker-compose up -d
# 4. 対象コンテナ全てのステータスが、UP である事を確認
docker-compose ps
```

下記作成中
ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

### 3. Laravel

#### Webサーバー（コンテナ）に入る

Laravel関連のコマンドはDockerで用意した、Webサーバー（コンテナ）上で行います。

```bash
# ターミナルで実行
docker exec -it Time-attendance-management-app bash
```

#### composer install

```bash
# ■ Webサーバーで入力
# Laravelプロジェクトは既にインストール済みです
# 必要に応じてvendorディレクトリを再生成する場合のみ実行
composer install
```

#### Laravel初期設定

```bash
# ■ Webサーバーで入力
cd /var/www/root
# .envファイルは既に設定済みです
# storage ディレクトリに読み取り・書き込み権限を与える（bootstrap, storage内に書き込み（ログ出力時等）に「Permission denied」のエラーが発生する）
chmod -R 777 bootstrap/cache/
chmod -R 777 storage/
```

#### データベースの初期化

[Laravel初期設定](#laravel初期設定)後に実行してください。  

```bash
# ■ Webサーバーで入力
cd /var/www/root
# テーブルの再作成＆初期データを挿入（既にマイグレーション済みの場合）
php artisan migrate:fresh --seed
# 初回セットアップの場合（既に実行済み）
# php artisan migrate
```

#### マルチログインについて

- 管理者側へログイン
  - <http://127.0.0.1/admin/login> ログイン画面
  - 統括管理者アカウント
  - ログインID：.envファイルに記載
  - パスワード：.envファイルに記載
  - ログインID：`admin_01` 〜 `admin_10` （管理者10人分）
  - パスワード：`admin`
- ユーザー側へログイン
  - <http://127.0.0.1/users/login> ログイン画面
  - ログインID：`test_01` 〜 `test_10` （ユーザー10人分）
  - パスワード：`test`

## 環境構築の確認

- Web 
  - <http://127.0.0.1:80/> （デフォルト設定のURL）  
    [routes/web.php](./root/routes/web.php)のURI「`'/'`」の実行結果が画面に表示されます。  
    VSCodeの[Docker拡張機能](https://marketplace.visualstudio.com/items?itemName=ms-azuretools.vscode-docker)が入っている場合、対象コンテナの「Open in Browser」でも開けます。  
- phpMyAdmin 
  - <http://127.0.0.1:8888> （デフォルト設定のURL）  
    VSCodeの[Docker拡張機能](https://marketplace.visualstudio.com/items?itemName=ms-azuretools.vscode-docker)が入っている場合、対象コンテナの「Open in Browser」でも開けます。  


### PHP_CodeSnifferの使用

コミット・プッシュ前にPHP_CodeSnifferを活用してコーディング規約違反がないかチェックすること。

```bash
# ■ Webサーバーで入力
# 全体チェック
composer sniffer ./
# 単一ファイルチェック(例としてAdminLoginControllerをチェックする場合)
composer sniffer ./app/Http/Controllers/AdminLoginController.php
```

### PHPunit

#### テストの実施

```bash
# ■ Webサーバーで入力
# 全体チェック
php artisan test
# 単一ファイルチェック(例としてAdminLoginTest.phpを実施する場合)
php artisan test --filter AdminLoginTest
```

#### 運用ルール

- メソッド名はキャメルケースで`'test' ＋ URI ＋ HTTPメソッド ＋ok(正常系) or error(異常系) ＋ テスト観点`
  - 例） test_admin_login_delete_ok_session_regenerate()
- URI毎にテストファイルを作成する
- 1ケース1メソッドを意識してテストを作成する（1メソッドにテストをまとめない）
