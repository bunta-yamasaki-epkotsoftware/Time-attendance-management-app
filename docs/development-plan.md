# 開発手順書

## Phase 1: データベース構築（1-2日）

### 1.1 マイグレーションファイル作成
```bash
# コンテナに入る
docker exec -it Time-attendance-management-app bash

# マイグレーションファイル生成
php artisan make:migration create_departments_table
php artisan make:migration create_roles_table
php artisan make:migration add_department_role_to_users_table
php artisan make:migration create_attendances_table
php artisan make:migration create_attendance_requests_table
```

### 1.2 モデル作成
```bash
php artisan make:model Department
php artisan make:model Role
php artisan make:model Attendance
php artisan make:model AttendanceRequest
```

### 1.3 シーダー作成
```bash
php artisan make:seeder DepartmentSeeder
php artisan make:seeder RoleSeeder
php artisan make:seeder UserSeeder
```

## Phase 2: 認証システム構築（2-3日）

### 2.1 Laravel Breezeインストール
```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run build
```

### 2.2 認証機能カスタマイズ
- ログイン画面のデザイン調整
- 社員番号ログイン対応
- 権限管理システム

### 2.3 ミドルウェア作成
```bash
php artisan make:middleware AdminMiddleware
php artisan make:middleware EmployeeMiddleware
```

## Phase 3: 基本勤怠機能（3-4日）

### 3.1 コントローラー作成
```bash
php artisan make:controller AttendanceController
php artisan make:controller Admin/AttendanceController
php artisan make:controller DashboardController
```

### 3.2 リクエストクラス作成
```bash
php artisan make:request AttendanceClockRequest
php artisan make:request AttendanceRequestRequest
```

### 3.3 サービスクラス作成
```bash
php artisan make:service AttendanceService
php artisan make:service AdminService
```

### 3.4 主要機能実装
- 出勤・退勤打刻
- 休憩時間管理
- 勤怠履歴表示
- ダッシュボード

## Phase 4: 管理者機能（2-3日）

### 4.1 管理者画面実装
- ユーザー管理
- 勤怠データ一覧
- 申請承認機能
- レポート出力

### 4.2 バリデーション・権限制御
- 入力値検証
- 画面アクセス制御
- データ編集権限

## Phase 5: PWA機能実装（2-3日）

### 5.1 Service Worker実装
```javascript
// public/sw.js
// キャッシュ戦略の実装
// オフライン対応
```

### 5.2 Web App Manifest
```json
// public/manifest.json
// アプリ設定
// アイコン設定
```

### 5.3 プッシュ通知
```bash
composer require laravel-notification-channels/webpush
```

## Phase 6: フロントエンド・UI改善（3-4日）

### 6.1 レスポンシブデザイン
- Bootstrap/TailwindCSS導入
- モバイルファースト設計
- タッチ操作最適化

### 6.2 JavaScript機能
- リアルタイム時計
- GPS位置情報取得
- オフライン時のローカルストレージ

### 6.3 UX改善
- ローディング表示
- エラーハンドリング
- 成功メッセージ

## Phase 7: API実装（2日）

### 7.1 API Routes設定
```php
// routes/api.php
// 勤怠API
// 管理者API
```

### 7.2 APIコントローラー
```bash
php artisan make:controller Api/AttendanceApiController
php artisan make:controller Api/AuthApiController
```

## Phase 8: テスト・デバッグ（2-3日）

### 8.1 単体テスト
```bash
php artisan make:test AttendanceTest
php artisan make:test UserTest
php artisan test
```

### 8.2 機能テスト
- 各画面の動作確認
- 権限テスト
- データ整合性確認

### 8.3 PWAテスト
- オフライン動作確認
- キャッシュ動作確認
- 通知機能確認

## Phase 9: デプロイ・本番環境構築（1-2日）

### 9.1 本番環境設定
- HTTPS設定
- 環境変数設定
- データベース最適化

### 9.2 パフォーマンス最適化
- キャッシュ設定
- 画像最適化
- CDN設定

## 必要なパッケージ一覧

```bash
# 認証
composer require laravel/breeze

# PWA関連
npm install workbox-webpack-plugin
composer require silviolleite/laravelpwa

# 通知
composer require laravel-notification-channels/webpush

# UI/CSS
npm install bootstrap
# または
npm install tailwindcss

# JavaScript
npm install axios
npm install alpine.js

# 開発・テスト
composer require --dev phpunit/phpunit
composer require --dev laravel/pint
```

## 推定開発期間: 15-20日

### 優先順位
1. Phase 1-3: 基本機能（必須）
2. Phase 4: 管理者機能（必須）
3. Phase 5-6: PWA・UI（重要）
4. Phase 7-8: API・テスト（重要）
5. Phase 9: デプロイ（必須）
