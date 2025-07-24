@extends('layouts.mobile-app')

@section('content')
    <!-- 月切り替えナビゲーション -->
<div class="bg-gradient-to-b from-green-400 to-green-500 py-8">
    <div class="flex justify-between mb-4">
        <a href="{{ route('workschedules.index', ['year' => $year, 'month' => $month - 1]) }}"
        class="text-white text-4xl pl-10">&lt;</a>
        <span class="font-bold text-4xl text-white">{{ $year }}年{{ $month }}月</span>
        <a href="{{ route('workschedules.index', ['year' => $year, 'month' => $month + 1]) }}"
        class="text-white text-4xl pr-10">&gt;</a>
    </div>
</div>


    <!-- 打刻ログの表示 -->
    <!-- <div class="bg-gray-300"> -->
        <div class="mx-auto"> <!-- //max-w-4xl -->
                <table class="w-full text-left">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 border-b font-semibold">日付</th>
                                <th class="px-4 py-3 border-b font-semibold">勤務区分</th>
                                <th class="px-4 py-3 border-b font-semibold">開始</th>
                                <th class="px-4 py-3 border-b font-semibold">終了</th>
                                <th class="border-b font-semibold text-right"></th>
                            </tr>
                        </thead>
                    </div>
                    <tbody>
                        @foreach ($dates as $date)
                            @php
                                $attendance = $attendances[$date->format('Y-m-d 00:00:00')] ?? null;
                            @endphp
                            <tr class="hover:bg-yellow-200 cursor-pointer" onclick="window.location='#'">
                                <td class="px-4 py-3 border-b text-gray-600">{{ $date->format('m/d') }} ({{ $weekdays[$date->dayOfWeek] }})</td>
                                @if($attendance)
                                    <td class="px-4 py-3 border-b">
                                        <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-sm">出勤</span>
                                    </td>
                                    <td class="px-4 py-3 border-b text-gray-600">{{substr($attendance->clock_in, 0, 5)}}</td>
                                    <td class="px-4 py-3 border-b text-gray-600">{{substr($attendance->clock_out, 0, 5)}}</td>
                                    <td class="pr-4 border-b text-gray-600 text-right">&gt;</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection