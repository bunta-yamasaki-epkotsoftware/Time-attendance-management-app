<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * usersテーブルを作成する
     * 勤怠管理システムのユーザー情報を格納するテーブル
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            // ユーザーID（主キー、自動増分）
            $table->id()->comment('ユーザーID');

            // 社員番号（一意制約、最大20文字）
            $table->string('employee_id', 20)->unique()->comment('社員番号');

            // 氏名（必須、最大100文字）
            $table->string('name', 100)->comment('氏名');

            // メールアドレス（一意制約、必須、最大255文字）
            $table->string('email', 255)->unique()->comment('メールアドレス');

            // メール確認日時（NULL許可、Laravel標準）
            $table->timestamp('email_verified_at')->nullable()->comment('メール確認日時');

            // パスワード（ハッシュ化、必須、最大255文字）
            $table->string('password', 255)->comment('パスワード（ハッシュ化）');

            // 部署ID（外部キー：departmentsテーブル、NULL許可）
            $table->foreignId('department_id')->nullable()->constrained('departments')->comment('部署ID');

            // 役職ID（外部キー：rolesテーブル、NULL許可）
            $table->foreignId('role_id')->nullable()->constrained('roles')->comment('役職ID');

            // 管理者フラグ（デフォルト：false）
            $table->boolean('is_admin')->default(false)->comment('管理者フラグ');

            // 入社日（必須）
            $table->date('hire_date')->comment('入社日');

            // 有効フラグ（デフォルト：true、退職時などにfalse）
            $table->boolean('is_active')->default(true)->comment('有効フラグ');

            // Remember token（Laravel標準、ログイン状態保持用）
            $table->rememberToken()->comment('Remember token');

            // 作成日時・更新日時（Laravel標準）
            $table->timestamps();
        });
    }

    /**
     * usersテーブルを削除する
     * マイグレーションのロールバック用
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
