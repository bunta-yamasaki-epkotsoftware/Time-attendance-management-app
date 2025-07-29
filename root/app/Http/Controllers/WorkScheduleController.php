<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance; // Assuming you have an Attendance model
use Carbon\Carbon; // For date and time handling
use Carbon\CarbonPeriod; // For generating date ranges
use Illuminate\Support\Facades\Log;

class WorkScheduleController extends Controller
{
    public function index(Request $request)
    {
        // 認証ユーザーの権限を確認
        if(!Auth::check() || !Auth::user()) {
            return redirect()->route('login')->with('error', 'ログインしてください。');
        }

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

    /**
     * Show the form for editing the specified resource.
     */
    public function show(Request $request, string $id)
    {
        // 認証ユーザーの権限を確認
        if(!Auth::check() || !Auth::user()) {
            return redirect()->route('login')->with('error', 'ログインしてください。');
        }

        //クエリパラメータで年・月を受け取る
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        //Carbonで年・月の初日と最終日を取得
        $start = Carbon::create($year, $month, 1);
        $end = $start->copy()->endOfMonth();

        // 日付の範囲を生成
        $dates = CarbonPeriod::create($start, $end);

        // 曜日の配列を定義
        $weekdays = ['日', '月', '火', '水', '木', '金', '土'];

        // 勤務表の詳細を取得
        $attendance = Attendance::findOrFail($id);

        if ($attendance->user_id !== Auth::id()) {
            return redirect()->route('workschedules.index')->with('error', 'この勤務表はあなたのものではありません。');
        }

        return view('workschedules.show', compact('attendance', 'dates', 'weekdays', 'year', 'month')); // workschedules/show.blade.phpを表示
    }

    /**
     * Display the specified resource.
     */
    public function edit(string $id, Request $request)
    {
        // 認証ユーザーの権限を確認
        if(!Auth::check() || !Auth::user()) {
            return redirect()->route('login')->with('error', 'ログインしてください。');
        }

        //クエリパラメータで年・月を受け取る
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        //Carbonで年・月の初日と最終日を取得
        $start = Carbon::create($year, $month, 1);
        $end = $start->copy()->endOfMonth();

        // 日付の範囲を生成
        $dates = CarbonPeriod::create($start, $end);

        // 曜日の配列を定義
        $weekdays = ['日', '月', '火', '水', '木', '金', '土'];

        // 勤務表の詳細を取得
        $attendance = Attendance::findOrFail($id);
        if ($attendance->user_id !== Auth::id()) {
            return redirect()->route('workschedules.index')->with('error', 'この勤務表はあなたのものではありません。');
        }

        return view('workschedules.edit', [
            'attendance' => $attendance,
            'dates' => $dates,
            'weekdays' => $weekdays,
        ]); // workschedules/show.blade.phpを表示
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request, string $id)
    {
        // dd('バリデーション前',$request->all());

        // バリデーション
        try {
            $request->validate([
                'clock_in' => 'required|date_format:H:i',
                'clock_out' => 'nullable|date_format:H:i',
                'break_start' => 'nullable|date_format:H:i',
                'break_end' => 'nullable|date_format:H:i',
                'notes_in' => 'nullable|string|max:255',
                'notes_out' => 'nullable|string|max:255',
                'total_work_hours' => 'nullable|numeric',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->errors()); // どの項目でエラーか配列で表示される
        }

        // バリデーション後
        // dd('バリデーション通過', $request->all());

        // 認証ユーザーの権限を確認
        $attendance = Attendance::findOrFail($id);

        $data = $request->only([
            'clock_in',
            'clock_out',
            'break_start',
            'break_end',
            'notes_in',
            'notes_out',
            'total_work_hours',
        ]);

        // 総労働時間を計算して保存
        if ($request->clock_in && $request->clock_out) {
            $in = \Carbon\Carbon::parse($request->clock_in);
            $out = \Carbon\Carbon::parse($request->clock_out);
            $minutes = abs($out->diffInMinutes($in));
            $data['total_work_hours'] = round($minutes / 60, 2);
        }
        Log::debug('clockOut: 総労働時間を計算', ['total_work_hours' => $data['total_work_hours']]);

        //updateメソッドでの更新
        $attendance->update($data);

        return redirect()->route('workschedules.index', compact('attendance'))->with('success', '勤務表が更新されました。');
    }
}