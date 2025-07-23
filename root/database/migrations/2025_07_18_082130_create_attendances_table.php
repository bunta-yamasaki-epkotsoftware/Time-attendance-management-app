<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id()->comment('勤怠ID');
            $table->foreignId('user_id')->comment('ユーザーID');
            $table->date('work_date')->comment('勤務日');
            $table->timestamp('clock_in')->nullable()->comment('出勤時刻');
            $table->timestamp('clock_out')->nullable()->comment('退勤時刻');
            $table->timestamp('break_start')->nullable()->comment('休憩開始時刻');
            $table->timestamp('break_end')->nullable()->comment('休憩終了時刻');
            $table->decimal('total_work_hours', 4, 2)->nullable()->comment('総労働時間');
            $table->decimal('total_break_hours', 4, 2)->nullable()->comment('総休憩時間');
            $table->enum('status', ['working', 'completed', 'absent'])->default('working')->comment('ステータス');
            $table->decimal('location_lat', 10, 8)->nullable()->comment('緯度（GPS）');
            $table->decimal('location_lng', 11, 8)->nullable()->comment('経度（GPS）');
            $table->text('notes')->nullable()->comment('備考');
            $table->foreignId('approved_by')->nullable()->comment('承認者ID');
            $table->timestamp('approved_at')->nullable()->comment('承認日時');
            $table->timestamp('created_at')->nullable()->comment('作成日時');
            $table->timestamp('updated_at')->nullable()->comment('更新日時');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
