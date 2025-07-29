<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance; // Assuming you have an Attendance model
use Carbon\Carbon; // For date and time handling
use Carbon\CarbonPeriod; // For generating date ranges

class WorkSummaryController extends Controller
{
    public function index(Request $request)
    {
        // 認証ユーザーの権限を確認
        if(!Auth::check() || !Auth::user()) {
            return redirect()->route('login')->with('error', 'ログインしてください。');
        }

        //クエリパラメータで年・月を受け取る
        // $year = $request->input('year', now()->year);
        // $month = $request->input('month', now()->month);
        $year = now()->year;
        $month = now()->month;

        //Carbonで年・月の初日と最終日を取得
        $start = Carbon::create($year, $month, 1);
        $end = $start->copy()->endOfMonth();

        // 日付の範囲を生成
        $dates = CarbonPeriod::create($start, $end);

        //土日の取得
        $saturdaysAndSundays = [];
        foreach ($dates as $date) {
            if ($date->isSaturday() || $date->isSunday()) {
                $saturdaysAndSundays[] = $date->copy();
            }
        }

        //平日の取得
        $workdays = count($dates) - count($saturdaysAndSundays);

        //平日出勤日数
        $workingdays = Attendance::where('user_id', Auth::id())
            ->whereBetween('work_date', [$start->format('Y-m-d'), $end->format('Y-m-d')])
            ->whereNotIn('work_date', $saturdaysAndSundays)
            ->count();

        //休日出勤日数
        $holidayWorkdays = Attendance::where('user_id', Auth::id())
            ->whereBetween('work_date', [$start->format('Y-m-d'), $end->format('Y-m-d')])
            ->whereIn('work_date', $saturdaysAndSundays)
            ->count();

        //休日出勤時間
        $holidayWorkHours = Attendance::where('user_id', Auth::id())
            ->whereBetween('work_date', [$start->format('Y-m-d'), $end->format('Y-m-d')])
            ->whereIn('work_date', $saturdaysAndSundays)
            ->sum('total_work_hours');

        //欠勤日
        $absentdays = count($dates) - ($workingdays + $holidayWorkdays);

        //合計労働時間
        $totalWorkHours = Attendance::where('user_id', Auth::id())
            ->whereBetween('work_date', [$start->format('Y-m-d'), $end->format('Y-m-d')])
            ->sum('total_work_hours');

        $hours = floor($totalWorkHours);
        $minutes = str_pad(round($totalWorkHours - $hours), 2, '0', STR_PAD_LEFT);

        // //時間外労働時間・深夜労働時間の計算
        $afterWorkHours = 0;
        $nightWorkHours = 0;
        $attendances = Attendance::where('user_id', Auth::id())
            ->whereBetween('work_date', [$start->format('Y-m-d'), $end->format('Y-m-d')])
            ->get();

        foreach ($attendances as $attendance) {
            if ($attendance->clock_out > '18:30') {
                $clockOut = Carbon::parse($attendance->clock_out);
                $afterStart = Carbon::parse('18:30');
                // 退勤が18:30より後なら、その差分だけ加算
                $afterMinutes = abs($clockOut->diffInMinutes($afterStart));
                $afterWorkHours += $afterMinutes / 60;
            }
            if($attendance->clock_out > '22:00') {
                $clockOut = Carbon::parse($attendance->clock_out);
                $nightStart = Carbon::parse('22:00');
                // 退勤が22:00より後なら、その差分だけ加算
                $nightMinutes = abs($clockOut->diffInMinutes($nightStart));
                $nightWorkHours += $nightMinutes / 60;
            }
        }

        $attendances = Attendance::all();

        $weekdays = ['日', '月', '火', '水', '木', '金', '土'];

        return view('worksummarys.index', compact('attendances', 'weekdays', 'dates', 'year', 'month', 'workdays','workingdays','holidayWorkdays','absentdays','totalWorkHours', 'hours', 'minutes','afterWorkHours','nightWorkHours','holidayWorkHours')); // worksummary/index.blade.phpを表示
    }
}
