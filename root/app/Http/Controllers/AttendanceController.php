<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance; // Assuming you have an Attendance model
use Carbon\Carbon; // For date and time handling
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //ログインしているか確認
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインしてください。');
        }

        // 現在ログインしているユーザーの勤怠データのみ取得
        $requests = Attendance::where('user_id', Auth::id())
                              ->orderBy('work_date', 'desc') // 最新の勤怠データを上に表示
                              ->paginate(3); // ページネーションを追加
                            //   ->get(); //ページネーションの際は不要

        return view('dashboard', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function clockIn(Request $request)
    {
        //今日の出勤がすでに登録されているか確認
        $todayAttendance = Attendance::where('user_id', Auth::id())
            ->whereDate('work_date', Carbon::today())
            ->first();

        if($todayAttendance) {
            return redirect()->route('dashboard')->with('error', '今日の勤怠はすでに登録されています。');
        }

        //出勤登録（退勤はnullで初期化）
        $attendance = new Attendance();
        $attendance->user_id = Auth::id();
        $now = Carbon::now();
        $attendance->work_date = $now->format('Y-m-d');
        $attendance->clock_in = $now->format('H:i');
        $attendance->clock_out = null;
        $attendance->notes_in = $request->input('notes_in', ''); // メモがあれば保存
        $attendance->save();
        return redirect()->route('dashboard')->with('success', '出勤が登録されました。');
    }

    public function clockOut(Request $request)
    {
        // デバッグログ
        // Log::debug('clockOut: start', ['user_id' => Auth::id()]);
        $attendance = Attendance::where('user_id', Auth::id())
            ->whereDate('work_date', Carbon::today())
            ->first();
        // Log::debug('clockOut: attendance record', ['attendance' => $attendance]);
        if(!$attendance) {
            // Log::debug('clockOut: 出勤記録がありません');
            return redirect()->route('dashboard')->with('error', '出勤記録がありません。');
        }

        if($attendance->clock_out) {
            // Log::debug('clockOut: 今日の退勤はすでに登録されています');
            return redirect()->route('dashboard')->with('error', '今日の退勤はすでに登録されています。');
        }

        //出勤登録
        // $attendance = new Attendance();
        // $attendance->user_id = Auth::id();
        // $now = Carbon::now();
        // $attendance->work_date = $now->format('Y-m-d');
        // $attendance->clock_out = $now->format('Y-m-d H:i:s');
        // $attendance->save();
        // return redirect()->route('dashboard')->with('success', '退勤が登録されました。');
        $attendance->clock_out = Carbon::now()->format('H:i');
        $attendance->notes_out = $request->input('notes_out', ''); // メモがあれば保存

        // 総労働時間を計算して保存
        if ($attendance->clock_in && $attendance->clock_out) {
            $in = \Carbon\Carbon::parse($attendance->clock_in);
            $out = \Carbon\Carbon::parse($attendance->clock_out);
            $minutes = abs($out->diffInMinutes($in));
            $attendance->total_work_hours = round($minutes / 60, 2);
        }
        // Log::debug('clockOut: 総労働時間を計算', ['total_work_hours' => $attendance->total_work_hours]);

        $attendance->save();
        // Log::debug('clockOut: 退勤登録完了', ['attendance' => $attendance]);

        return redirect()->route('dashboard')->with('success', '退勤が登録されました。');
    }

    public function breakStart(Request $request)
    {
        // 今日の勤怠記録を取得
        $attendance = Attendance::where('user_id', Auth::id())
            ->whereDate('work_date', Carbon::today())
            ->first();

        if(!$attendance) {
            return redirect()->route('dashboard')->with('error', '出勤記録がありません。');
        }

        if($attendance->clock_out) {
            return redirect()->route('dashboard')->with('error', '今日の退勤はすでに登録されています。');
        }

        $attendance->break_start = Carbon::now()->format('H:i');
        $attendance->save();

        return redirect()->route('dashboard')->with('success', '休憩が登録されました。');
    }

    public function breakEnd(Request $request)
    {
        // 今日の勤怠記録を取得
        $attendance = Attendance::where('user_id', Auth::id())
            ->whereDate('work_date', Carbon::today())
            ->first();

        if(!$attendance) {
            return redirect()->route('dashboard')->with('error', '出勤記録がありません。');
        }

        if($attendance->clock_out) {
            return redirect()->route('dashboard')->with('error', '今日の退勤はすでに登録されています。');
        }

        $attendance->break_end = Carbon::now()->format('H:i');
        $attendance->save();

        return redirect()->route('dashboard')->with('success', '戻りが登録されました。');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
