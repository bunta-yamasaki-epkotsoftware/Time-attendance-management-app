# Time-attendance Management App

### 1. .env の編集
.envファイルはDockerの環境ファイルです。基本的にはそのまま使用可能ですが、IPやポートが重複する場合は自身の環境に合わせて修正してください。

### 2. コマンド実行
```sh
# リポジトリをクローン
git clone https://github.com/bunta-yamasaki-epkotsoftware/Time-attendance-management-app.git
# 2. リポジトリに移動
cd Time-attendance-management-app
# 3. コンテナ起動
docker compose up -d
# 4. 対象コンテナ全てのステータスが、UP である事を確認
docker compose ps
```

### 3.開発環境のコピー
```sh
# 1. リポジトリに移動
cd root
# 2. 「.env.dev」ファイルを「.env」にコピー
cp .env.dev .env
```

### 4. Laravel
Webサーバー（コンテナ）に入る
Laravel関連のコマンドはDockerで用意した、Webサーバー（コンテナ）上で行います。
```sh
# ターミナルで実行
docker exec -it Time-attendance-management-app bash
```

#### composer install

```sh
# ■ コンテナWebサーバーで入力
# 「composer.json」、「composer.lock」に記載されているパッケージをvendorディレクトリにインストール
#   ※ 時間がかかるので注意。
composer install
```

composer install 実行後に「Exception」が出ていると失敗しているので
root/vendor/ディレクトリを削除して、再実行。

### Laravel初期設定
```sh
# ■ コンテナWebサーバーで入力
cd /var/www/root
# storage ディレクトリに読み取り・書き込み権限を与える（bootstrap, storage内に書き込み（ログ出力時等）に「Permission denied」のエラーが発生する）
chmod -R 777 bootstrap/cache/
chmod -R 777 storage/
```

### データベースの初期化
Laravel初期設定後に実行してください。
```sh
# ■ Webサーバーで入力
cd /var/www/root
# テーブルの再作成＆初期データを挿入
php artisan migrate:fresh --seed
# もしくは初回のみ
# php artisan migrate
```

### Viteの開発サーバー立ち上げ
```sh
# ■ Webサーバーで入力
cd /var/www/root
# 開発環境の立ち上げ
npm run dev
##本番環境はnpm run build
```

### 初期ユーザー情報
<!-- <管理者ログインはまだ作成なし>
- 管理者ログイン:  
  - URL: [http://127.0.0.1/admin/login](http://127.0.0.1/admin/login)  
  - ログインID: `.env`ファイル参照 or `admin_01`〜`admin_10`  
  - パスワード: `.env`ファイル参照 or `admin` -->
ユーザーログイン:
URL: http://127.0.0.1/login
ログインメールアドレス: test_01@test.com〜test_10@test.com
パスワード: test

## 環境構築の確認
Web: http://127.0.0.1:80/
→ routes/web.phpの'/'の実行結果（welcome.blade.php）が表示されます。
phpMyAdmin: http://127.0.0.1:8888/
補足
VSCodeのDocker拡張機能を使うと、コンテナの「Open in Browser」からWebやphpMyAdminに簡単にアクセスできます。
ポートやIPが重複する場合は.envやdocker-compose.ymlを編集してください。