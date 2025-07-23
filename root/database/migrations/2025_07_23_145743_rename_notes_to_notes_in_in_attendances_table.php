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
        Schema::table('attendances', function (Blueprint $table) {
            // $table->renameColumn('notes', 'notes_in');
            $table->text('notes_in')->nullable()->comment('備考(勤怠登録時のメモ)')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            // $table->renameColumn('notes_in', 'notes');
            $table->text('notes')->nullable()->comment('備考(勤怠登録時のメモ)')->change();
        });
    }
};
