<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * attendance_requestsテーブルを作成する
     * 勤怠修正申請・有給申請・病欠申請などの申請情報を格納するテーブル
     */
    public function up(): void
    {
        Schema::create('attendance_requests', function (Blueprint $table) {
            // 申請ID（主キー、自動増分）
            $table->id()->comment('申請ID');

            // 申請者ID（外部キー：usersテーブル、必須）
            $table->foreignId('user_id')->constrained('users')->comment('申請者ID');

            // 勤怠ID（外部キー：attendancesテーブル、必須）
            $table->foreignId('attendance_id')->constrained('attendances')->comment('勤怠ID');

            // 申請種別（correction:修正、vacation:有給、sick:病欠）
            $table->enum('request_type', ['correction', 'vacation', 'sick'])->comment('申請種別');

            // 現在の出勤時刻（修正前の値、NULL許可）
            $table->timestamp('current_clock_in')->nullable()->comment('現在の出勤時刻');

            // 現在の退勤時刻（修正前の値、NULL許可）
            $table->timestamp('current_clock_out')->nullable()->comment('現在の退勤時刻');

            // 申請出勤時刻（修正後の希望値、NULL許可）
            $table->timestamp('requested_clock_in')->nullable()->comment('申請出勤時刻');

            // 申請退勤時刻（修正後の希望値、NULL許可）
            $table->timestamp('requested_clock_out')->nullable()->comment('申請退勤時刻');

            // 申請理由（必須、テキスト形式）
            $table->text('reason')->comment('申請理由');

            // ステータス（pending:承認待ち、approved:承認済み、rejected:却下）
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->comment('ステータス');

            // 承認者ID（外部キー：usersテーブル、NULL許可）
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->comment('承認者ID');

            // 承認日時（NULL許可）
            $table->timestamp('reviewed_at')->nullable()->comment('承認日時');

            // 承認コメント（承認者からのコメント、NULL許可）
            $table->text('review_comment')->nullable()->comment('承認コメント');

            // 作成日時・更新日時（Laravel標準）
            $table->timestamps();
        });
    }

    /**
     * attendance_requestsテーブルを削除する
     * マイグレーションのロールバック用
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_requests');
    }
};
