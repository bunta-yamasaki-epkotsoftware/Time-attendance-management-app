# データベース設計書

## ER図概要

```
Users (ユーザー)
├── Attendances (勤怠記録)
├── Departments (部署)
├── Roles (役職)
└── AttendanceRequests (勤怠修正申請)
```

## テーブル設計

### 1. users テーブル (ユーザー)

| カラム名 | データ型 | 制約 | 説明 |
|---------|---------|------|------|
| id | BIGINT | PK, AUTO_INCREMENT | ユーザーID |
| employee_id | VARCHAR(20) | UNIQUE, NOT NULL | 社員番号 |
| name | VARCHAR(100) | NOT NULL | 氏名 |
| email | VARCHAR(255) | UNIQUE, NOT NULL | メールアドレス |
| password | VARCHAR(255) | NOT NULL | パスワード（ハッシュ化） |
| department_id | BIGINT | FK | 部署ID |
| role_id | BIGINT | FK | 役職ID |
| is_admin | BOOLEAN | DEFAULT FALSE | 管理者フラグ |
| hire_date | DATE | NOT NULL | 入社日 |
| is_active | BOOLEAN | DEFAULT TRUE | 有効フラグ |
| created_at | TIMESTAMP | | 作成日時 |
| updated_at | TIMESTAMP | | 更新日時 |

### 2. departments テーブル (部署)

| カラム名 | データ型 | 制約 | 説明 |
|---------|---------|------|------|
| id | BIGINT | PK, AUTO_INCREMENT | 部署ID |
| name | VARCHAR(100) | NOT NULL | 部署名 |
| description | TEXT | | 部署説明 |
| manager_id | BIGINT | FK (users.id) | 部署長ID |
| created_at | TIMESTAMP | | 作成日時 |
| updated_at | TIMESTAMP | | 更新日時 |

### 3. roles テーブル (役職)

| カラム名 | データ型 | 制約 | 説明 |
|---------|---------|------|------|
| id | BIGINT | PK, AUTO_INCREMENT | 役職ID |
| name | VARCHAR(100) | NOT NULL | 役職名 |
| level | INT | NOT NULL | 権限レベル |
| created_at | TIMESTAMP | | 作成日時 |
| updated_at | TIMESTAMP | | 更新日時 |

### 4. attendances テーブル (勤怠記録)

| カラム名 | データ型 | 制約 | 説明 |
|---------|---------|------|------|
| id | BIGINT | PK, AUTO_INCREMENT | 勤怠ID |
| user_id | BIGINT | FK, NOT NULL | ユーザーID |
| work_date | DATE | NOT NULL | 勤務日 |
| clock_in | TIMESTAMP | | 出勤時刻 |
| clock_out | TIMESTAMP | | 退勤時刻 |
| break_start | TIMESTAMP | | 休憩開始時刻 |
| break_end | TIMESTAMP | | 休憩終了時刻 |
| total_work_hours | DECIMAL(4,2) | | 総労働時間 |
| total_break_hours | DECIMAL(4,2) | | 総休憩時間 |
| status | ENUM | DEFAULT 'working' | ステータス(working,completed,absent) |
| location_lat | DECIMAL(10,8) | | 緯度（GPS） |
| location_lng | DECIMAL(11,8) | | 経度（GPS） |
| notes | TEXT | | 備考 |
| approved_by | BIGINT | FK (users.id) | 承認者ID |
| approved_at | TIMESTAMP | | 承認日時 |
| created_at | TIMESTAMP | | 作成日時 |
| updated_at | TIMESTAMP | | 更新日時 |

### 5. attendance_requests テーブル (勤怠修正申請)

| カラム名 | データ型 | 制約 | 説明 |
|---------|---------|------|------|
| id | BIGINT | PK, AUTO_INCREMENT | 申請ID |
| user_id | BIGINT | FK, NOT NULL | 申請者ID |
| attendance_id | BIGINT | FK, NOT NULL | 勤怠ID |
| request_type | ENUM | NOT NULL | 申請種別(correction,vacation,sick) |
| current_clock_in | TIMESTAMP | | 現在の出勤時刻 |
| current_clock_out | TIMESTAMP | | 現在の退勤時刻 |
| requested_clock_in | TIMESTAMP | | 申請出勤時刻 |
| requested_clock_out | TIMESTAMP | | 申請退勤時刻 |
| reason | TEXT | NOT NULL | 申請理由 |
| status | ENUM | DEFAULT 'pending' | ステータス(pending,approved,rejected) |
| reviewed_by | BIGINT | FK (users.id) | 承認者ID |
| reviewed_at | TIMESTAMP | | 承認日時 |
| review_comment | TEXT | | 承認コメント |
| created_at | TIMESTAMP | | 作成日時 |
| updated_at | TIMESTAMP | | 更新日時 |

## インデックス設計

```sql
-- users テーブル
CREATE INDEX idx_users_employee_id ON users(employee_id);
CREATE INDEX idx_users_department_id ON users(department_id);
CREATE INDEX idx_users_role_id ON users(role_id);

-- attendances テーブル
CREATE INDEX idx_attendances_user_date ON attendances(user_id, work_date);
CREATE INDEX idx_attendances_work_date ON attendances(work_date);
CREATE INDEX idx_attendances_status ON attendances(status);

-- attendance_requests テーブル
CREATE INDEX idx_requests_user_id ON attendance_requests(user_id);
CREATE INDEX idx_requests_status ON attendance_requests(status);
CREATE INDEX idx_requests_attendance_id ON attendance_requests(attendance_id);
```

## 制約・リレーション

```sql
-- 外部キー制約
ALTER TABLE users ADD FOREIGN KEY (department_id) REFERENCES departments(id);
ALTER TABLE users ADD FOREIGN KEY (role_id) REFERENCES roles(id);
ALTER TABLE departments ADD FOREIGN KEY (manager_id) REFERENCES users(id);
ALTER TABLE attendances ADD FOREIGN KEY (user_id) REFERENCES users(id);
ALTER TABLE attendances ADD FOREIGN KEY (approved_by) REFERENCES users(id);
ALTER TABLE attendance_requests ADD FOREIGN KEY (user_id) REFERENCES users(id);
ALTER TABLE attendance_requests ADD FOREIGN KEY (attendance_id) REFERENCES attendances(id);
ALTER TABLE attendance_requests ADD FOREIGN KEY (reviewed_by) REFERENCES users(id);
```
