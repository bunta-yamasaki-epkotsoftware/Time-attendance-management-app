<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance; // Assuming you have an Attendance model
use Carbon\Carbon; // For date and time handling
use Carbon\CarbonPeriod; // For generating date ranges

class WorkScheduleController extends Controller
{
    public function index(Request $request)
    {
        //クエリパラメータで年・月を受け取る
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        //Carbonで年・月の初日と最終日を取得
        $start = Carbon::create($year, $month, 1);
        $end = $start->copy()->endOfMonth();

        // 日付の範囲を生成
        $dates = CarbonPeriod::create($start, $end);

        $attendances = Attendance::where('user_id', Auth::id())
            ->whereBetween('work_date', [$start->format('Y-m-d'), $end->format('Y-m-d')])
            ->orderBy('work_date', 'desc')
            ->get() // ページネーションの際は不要
            ->keyBy('work_date'); // 勤務日でキーを設定

        $weekdays = ['日', '月', '火', '水', '木', '金', '土'];

        return view('workschedules.index', compact('attendances', 'weekdays', 'dates', 'year', 'month')); // workschedules/index.blade.phpを表示
    }
}
