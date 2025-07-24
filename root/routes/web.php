<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController; // Import AttendanceController
use App\Http\Controllers\SettingController; // Import SeetingsController

Route::get('/', function () {
    return view('welcome');
});

// 勤怠管理のルート
Route::get('/dashboard', [AttendanceController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/dashboard', [AttendanceController::class, 'store'])->middleware(['auth', 'verified'])->name('attendance.store'); // 勤怠データの保存
Route::post('/dashboard/clock-in', [AttendanceController::class, 'clockIn'])->middleware(['auth', 'verified'])->name('attendance.clockIn'); // 出勤登録
Route::post('/dashboard/clock-out', [AttendanceController::class, 'clockOut'])->middleware(['auth', 'verified'])->name('attendance.clockOut'); // 退勤登録
Route::post('/dashboard/break-start', [AttendanceController::class, 'breakStart'])->middleware(['auth', 'verified'])->name('attendance.breakStart'); // 休憩開始登録
Route::post('/dashboard/break-end', [AttendanceController::class, 'breakEnd'])->middleware(['auth', 'verified'])->name('attendance.breakEnd'); // 休憩終了登録

// 設定管理のルート
Route::get('/settings', [SettingController::class, 'index'])->middleware(['auth', 'verified'])->name('settings.index'); // 設定ページの表示

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 勤怠管理のルート（dashboardと統合したので削除or別用途に使用）
// Route::get('/attendance', [AttendanceController::class, 'index'])->middleware(['auth', 'verified'])->name('attendance.index');

require __DIR__.'/auth.php';
