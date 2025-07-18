# 画面設計書（UI/UX設計）

## 1. デザインコンセプト

### 1.1 参考デザイン
- **RecoRu**スタイルの勤怠管理アプリ
- **シンプル・直感的**な操作性
- **モバイルファースト**設計
- **PWA対応**のネイティブアプリ風UI

### 1.2 カラーパレット
```css
/* メインカラー（グリーン系） */
--primary-color: #5DCEA2;      /* ヘッダー背景 */
--secondary-color: #7ED321;    /* 出勤ボタン */
--accent-color: #F5A623;       /* 退勤ボタン */

/* サブカラー */
--background-light: #F8F9FA;   /* 背景色 */
--text-dark: #333333;          /* テキスト */
--text-light: #666666;         /* サブテキスト */
--white: #FFFFFF;              /* ボタンテキスト */

/* ステータスカラー */
--success: #28A745;            /* 成功 */
--warning: #FFC107;            /* 警告 */
--danger: #DC3545;             /* エラー */
```

## 2. メイン画面（ダッシュボード）

### 2.1 レイアウト構成
```
┌─────────────────────────────┐
│ 📱 ステータスバー            │
├─────────────────────────────┤
│ 🏢 RecoRu (アプリ名)         │
├─────────────────────────────┤
│ 📅 2022/3/7(月)             │
│ 🕐 15:52:48 (リアルタイム)   │
├─────────────────────────────┤
│ [出勤] [退勤]               │
│ (大きなボタン)               │
├─────────────────────────────┤
│ 💬 私用で早退します          │
│ (メッセージ入力エリア)        │
├─────────────────────────────┤
│ 📋 打刻ログ                 │
│ 3/7(月) 15:51 退勤 📍備考    │
│ 3/7(月) 15:51 出勤 📍      │
├─────────────────────────────┤
│ 🏠📊📈⚙️ (ナビゲーション)    │
└─────────────────────────────┘
```

### 2.2 画面要素詳細

#### ヘッダー部分
- **アプリ名**: "Time-attendance" または "勤怠管理"
- **背景色**: グラデーション（#5DCEA2）
- **テキスト色**: 白色
- **高さ**: 60px

#### 日時表示部分
- **日付**: YYYY/M/D(曜日) 形式
- **時刻**: HH:MM:SS（1秒毎更新）
- **フォントサイズ**: 日付 18px, 時刻 32px
- **配置**: 中央揃え

#### 打刻ボタン部分
```html
<div class="clock-buttons">
  <button class="btn-clock-in">出勤</button>
  <button class="btn-clock-out">退勤</button>
</div>
```
- **出勤ボタン**: 緑色(#7ED321)、角丸、150px×60px
- **退勤ボタン**: オレンジ色(#F5A623)、角丸、150px×60px
- **間隔**: 20px
- **テキスト**: 白色、太字、18px

#### メッセージ入力エリア
```html
<div class="message-area">
  <input type="text" placeholder="備考を入力（任意）">
  <button class="btn-close">×</button>
</div>
```
- **背景色**: 白色
- **ボーダー**: グレー、角丸
- **高さ**: 50px

#### 打刻ログ部分
```html
<div class="attendance-log">
  <h3>打刻ログ</h3>
  <div class="log-item">
    <span class="date">3/7(月)</span>
    <span class="time">15:51</span>
    <span class="type clock-out">退勤</span>
    <span class="location">📍</span>
    <span class="note">私用で早退します</span>
  </div>
</div>
```

#### ボトムナビゲーション
```html
<nav class="bottom-nav">
  <a href="/dashboard" class="nav-item active">
    <i class="icon-home"></i>
    <span>ホーム</span>
  </a>
  <a href="/attendance/history" class="nav-item">
    <i class="icon-list"></i>
    <span>勤務表</span>
  </a>
  <a href="/reports" class="nav-item">
    <i class="icon-chart"></i>
    <span>勤務集計</span>
  </a>
  <a href="/settings" class="nav-item">
    <i class="icon-settings"></i>
    <span>設定</span>
  </a>
</nav>
```

## 3. CSS設計

### 3.1 ベースCSS
```css
/* リセット・ベース */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  background-color: var(--background-light);
  color: var(--text-dark);
  line-height: 1.6;
}

/* コンテナ */
.container {
  max-width: 414px;
  margin: 0 auto;
  background: white;
  min-height: 100vh;
  position: relative;
}
```

### 3.2 コンポーネントCSS
```css
/* ヘッダー */
.header {
  background: linear-gradient(135deg, #5DCEA2 0%, #4ABFA1 100%);
  color: white;
  text-align: center;
  padding: 15px 0;
  position: sticky;
  top: 0;
  z-index: 100;
}

/* 日時表示 */
.datetime-display {
  background: linear-gradient(135deg, #5DCEA2 0%, #4ABFA1 100%);
  color: white;
  padding: 20px;
  text-align: center;
}

.date {
  font-size: 18px;
  margin-bottom: 5px;
}

.time {
  font-size: 32px;
  font-weight: bold;
  letter-spacing: 2px;
}

/* 打刻ボタン */
.clock-buttons {
  display: flex;
  gap: 20px;
  padding: 30px 20px;
  justify-content: center;
}

.btn-clock-in, .btn-clock-out {
  flex: 1;
  max-width: 150px;
  height: 60px;
  border: none;
  border-radius: 10px;
  font-size: 18px;
  font-weight: bold;
  color: white;
  cursor: pointer;
  transition: all 0.3s ease;
}

.btn-clock-in {
  background: linear-gradient(135deg, #7ED321 0%, #6BC71A 100%);
}

.btn-clock-out {
  background: linear-gradient(135deg, #F5A623 0%, #E89611 100%);
}

.btn-clock-in:hover, .btn-clock-out:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

/* メッセージエリア */
.message-area {
  margin: 0 20px 20px;
  position: relative;
}

.message-area input {
  width: 100%;
  padding: 15px;
  border: 1px solid #ddd;
  border-radius: 8px;
  font-size: 16px;
}

/* 打刻ログ */
.attendance-log {
  padding: 20px;
  background: white;
}

.log-item {
  display: flex;
  align-items: center;
  padding: 12px 0;
  border-bottom: 1px solid #f0f0f0;
  gap: 10px;
}

.log-item .type.clock-out {
  background: #F5A623;
  color: white;
  padding: 4px 12px;
  border-radius: 12px;
  font-size: 12px;
}

.log-item .type.clock-in {
  background: #7ED321;
  color: white;
  padding: 4px 12px;
  border-radius: 12px;
  font-size: 12px;
}

/* ボトムナビ */
.bottom-nav {
  position: fixed;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 100%;
  max-width: 414px;
  background: white;
  border-top: 1px solid #e0e0e0;
  display: flex;
  padding: 8px 0;
}

.nav-item {
  flex: 1;
  text-align: center;
  text-decoration: none;
  color: #666;
  font-size: 12px;
  padding: 8px;
}

.nav-item.active {
  color: #5DCEA2;
}
```

## 4. レスポンシブ対応

### 4.1 ブレークポイント
```css
/* スマートフォン（縦） */
@media (max-width: 414px) {
  .clock-buttons {
    flex-direction: row;
    gap: 15px;
  }
}

/* タブレット */
@media (min-width: 768px) {
  .container {
    max-width: 768px;
  }
  
  .clock-buttons {
    max-width: 400px;
    margin: 0 auto;
  }
}
```

## 5. PWA対応要素

### 5.1 タッチ操作最適化
- **ボタンサイズ**: 最小44px×44px
- **タップ範囲**: 適切な余白設定
- **フィードバック**: タップ時のアニメーション

### 5.2 オフライン表示
```html
<div class="offline-indicator">
  <span>📶 オフライン</span>
</div>
```

このデザインで実装を進めますか？それとも何か調整したい部分はありますか？
