# システム設計書

## 1. アーキテクチャ構成

```
Frontend (Blade + PWA)
├── Service Worker (キャッシュ・オフライン対応)
├── Web App Manifest (ホーム画面追加)
└── Push Notification (通知機能)

Backend (Laravel)
├── Controller (画面制御)
├── Model (データ操作)
├── Service (ビジネスロジック)
├── Repository (データアクセス)
└── Job (バッチ処理)

Database (MySQL)
├── Users (ユーザー管理)
├── Attendances (勤怠データ)
└── System (システム設定)
```

## 2. ディレクトリ構成

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/ (認証関連)
│   │   ├── Admin/ (管理者機能)
│   │   └── Api/ (API機能)
│   ├── Requests/ (バリデーション)
│   └── Middleware/ (ミドルウェア)
├── Models/ (Eloquentモデル)
├── Services/ (ビジネスロジック)
├── Repositories/ (データアクセス)
└── Jobs/ (バッチ処理)

resources/
├── views/
│   ├── layouts/ (レイアウト)
│   ├── auth/ (認証画面)
│   ├── dashboard/ (ダッシュボード)
│   ├── attendance/ (勤怠管理)
│   └── admin/ (管理者画面)
├── js/ (JavaScript)
├── css/ (スタイルシート)
└── pwa/ (PWA設定ファイル)

database/
├── migrations/ (マイグレーション)
├── seeders/ (初期データ)
└── factories/ (テストデータ)
```

## 3. 画面一覧・機能

### 3.1 認証機能
- `/login` - ログイン画面
- `/register` - ユーザー登録画面
- `/password/reset` - パスワードリセット画面

### 3.2 一般ユーザー機能
- `/dashboard` - ダッシュボード（今日の勤怠状況）
- `/attendance/clock` - 打刻画面
- `/attendance/history` - 勤怠履歴
- `/attendance/request` - 勤怠修正申請
- `/profile` - プロフィール編集

### 3.3 管理者機能
- `/admin/dashboard` - 管理ダッシュボード
- `/admin/users` - ユーザー管理
- `/admin/attendances` - 勤怠データ管理
- `/admin/requests` - 申請承認
- `/admin/reports` - レポート出力

## 4. API設計

### 4.1 認証API
```
POST /api/login - ログイン
POST /api/logout - ログアウト
POST /api/refresh - トークン更新
```

### 4.2 勤怠API
```
GET /api/attendance/today - 今日の勤怠
POST /api/attendance/clock-in - 出勤打刻
POST /api/attendance/clock-out - 退勤打刻
POST /api/attendance/break-start - 休憩開始
POST /api/attendance/break-end - 休憩終了
GET /api/attendance/history - 勤怠履歴
```

### 4.3 管理者API
```
GET /api/admin/users - ユーザー一覧
GET /api/admin/attendances - 勤怠データ一覧
PUT /api/admin/attendance/{id}/approve - 勤怠承認
GET /api/admin/reports - レポートデータ
```

## 5. PWA機能設計

### 5.1 Service Worker機能
- キャッシュ戦略（Cache First + Network Fallback）
- オフライン時のデータ保存
- バックグラウンド同期

### 5.2 Web App Manifest
- アプリ名・アイコン設定
- ホーム画面追加対応
- スプラッシュスクリーン

### 5.3 Push Notification
- 勤怠リマインダー通知
- 申請承認通知
- システム通知

## 6. セキュリティ設計

### 6.1 認証・認可
- Laravel Sanctum (SPA認証)
- CSRF Protection
- Rate Limiting

### 6.2 データ保護
- データベース暗号化
- HTTPS強制
- セッション管理

### 6.3 入力検証
- Laravel Validation
- XSS対策
- SQLインジェクション対策
