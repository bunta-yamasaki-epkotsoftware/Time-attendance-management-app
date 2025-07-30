
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