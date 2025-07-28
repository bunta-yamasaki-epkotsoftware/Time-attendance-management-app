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

        $attendances = Attendance::all();

        $weekdays = ['日', '月', '火', '水', '木', '金', '土'];

        return view('worksummarys.index', compact('attendances', 'weekdays', 'dates', 'year', 'month', 'workdays')); // worksummary/index.blade.phpを表示
    }
}
