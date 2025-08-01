<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController; // Import AttendanceController
use App\Http\Controllers\SettingController; // Import SeetingsController
use App\Http\Controllers\WorkScheduleController; // Import WorkScheduleController
use App\Http\Controllers\WorkSummaryController; // Import WorkSummaryController

Route::get('/', function () {
    return view('welcome');
})->name('home');

// 勤怠ダッシュボードのルート
Route::get('/dashboard', [AttendanceController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/dashboard', [AttendanceController::class, 'store'])->middleware(['auth', 'verified'])->name('attendance.store'); // 勤怠データの保存
Route::post('/dashboard/clock-in', [AttendanceController::class, 'clockIn'])->middleware(['auth', 'verified'])->name('attendance.clockIn'); // 出勤登録
Route::post('/dashboard/clock-out', [AttendanceController::class, 'clockOut'])->middleware(['auth', 'verified'])->name('attendance.clockOut'); // 退勤登録
Route::post('/dashboard/break-start', [AttendanceController::class, 'breakStart'])->middleware(['auth', 'verified'])->name('attendance.breakStart'); // 休憩開始登録
Route::post('/dashboard/break-end', [AttendanceController::class, 'breakEnd'])->middleware(['auth', 'verified'])->name('attendance.breakEnd'); // 休憩終了登録

//勤務表管理のルート
Route::get('/workschedule',[WorkScheduleController::class, 'index'])->middleware(['auth', 'verified'])->name('workschedules.index'); // 勤務表の表示
// Route::get('/workschedule/{id}', [WorkScheduleController::class, 'show'])->middleware(['auth', 'verified'])->name('workschedules.show'); // 勤務表の詳細表示
Route::get('/workschedule/{id}/edit', [WorkScheduleController::class, 'edit'])->middleware(['auth', 'verified'])->name('workschedules.edit'); // 勤務表の編集
Route::put('/workschedule/{id}', [WorkScheduleController::class, 'update'])->middleware(['auth', 'verified'])->name('workschedules.update'); // 勤務表の更新

//勤務集計管理のルート
Route::get('/worksummary', [WorkSummaryController::class, 'index'])->middleware(['auth', 'verified'])->name('worksummarys.index'); // 勤務表の詳細表示

// 設定管理のルート
Route::get('/settings', [SettingController::class, 'index'])->middleware(['auth', 'verified'])->name('settings.index'); // 設定ページの表示

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
