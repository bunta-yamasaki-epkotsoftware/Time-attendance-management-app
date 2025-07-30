
# Time-attendance Management App

## 環境構築手順

### 1. リポジトリのクローン

```sh
git clone https://github.com/bunta-yamasaki-epkotsoftware/Time-attendance-management-app.git
cd Time-attendance-management-app
```

### 2. .env の編集

`.env`ファイルはDockerの環境ファイルです。基本的にはそのまま使用可能ですが、IPやポートが重複する場合は自身の環境に合わせて修正してください。

### 3. Dockerコンテナの起動

```sh
docker-compose up -d
docker-compose ps # 全てのコンテナがUPであることを確認
```

### 4. Webアプリへのアクセス

- Webアプリ: [http://127.0.0.1:80/](http://127.0.0.1:80/)  
  → Laravelのトップページ（`welcome.blade.php`）が表示されます。
- phpMyAdmin: [http://127.0.0.1:8888/](http://127.0.0.1:8888/)  
  → DBの中身をブラウザで確認できます。

### 5. Webサーバー（コンテナ）に入る

Laravelのコマンドや初期設定はWebサーバー（コンテナ）内で実行します。

```sh
docker exec -it Time-attendance-management-app bash
```

### 6. Laravel初期設定

```sh
cd /var/www/root
composer install # 必要に応じて
chmod -R 777 bootstrap/cache/
chmod -R 777 storage/
```

### 7. データベース初期化

```sh
php artisan migrate:fresh --seed
# もしくは初回のみ
# php artisan migrate
```

---

## 初期ユーザー情報

<!-- <管理者ログインはまだ作成なし>
- 管理者ログイン:  
  - URL: [http://127.0.0.1/admin/login](http://127.0.0.1/admin/login)  
  - ログインID: `.env`ファイル参照 or `admin_01`〜`admin_10`  
  - パスワード: `.env`ファイル参照 or `admin` -->
- ユーザーログイン:  
  - URL: [http://127.0.0.1/login](http://127.0.0.1/login)  
  - ログインメールアドレス: `test_01@test.com`〜`test_10@test.com`  
  - パスワード: `test`

---

## 環境構築の確認

- Web: [http://127.0.0.1:80/](http://127.0.0.1:80/)  
  → `routes/web.php`の`'/'`の実行結果（`welcome.blade.php`）が表示されます。
- phpMyAdmin: [http://127.0.0.1:8888/](http://127.0.0.1:8888/)

---

## 開発・運用Tips

### PHP_CodeSniffer

コミット・プッシュ前にPHP_CodeSnifferでコーディング規約違反がないかチェックしてください。

```sh
composer sniffer ./
# 単一ファイルチェック例
composer sniffer ./app/Http/Controllers/AdminLoginController.php
```

### PHPUnit

```sh
php artisan test
# 単一ファイルテスト例
php artisan test --filter AdminLoginTest
```

---

## 補足

- VSCodeの[Docker拡張機能](https://marketplace.visualstudio.com/items?itemName=ms-azuretools.vscode-docker)を使うと、コンテナの「Open in Browser」からWebやphpMyAdminに簡単にアクセスできます。
- ポートやIPが重複する場合は`.env`や`docker-compose.yml`を編集してください。


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
