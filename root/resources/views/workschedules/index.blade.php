@extends('layouts.mobile-app')

@section('content')
    <!-- 月切り替えナビゲーション -->
<div class="bg-[#62b89d] py-4">
    <div class="flex justify-between">
        <a href="{{ route('workschedules.index', ['year' => $year, 'month' => $month - 1]) }}"
        class="text-white text-4xl pl-10">&lt;</a>
        <span class="font-bold text-4xl text-white">{{ $year }}年{{ $month }}月</span>
        <a href="{{ route('workschedules.index', ['year' => $year, 'month' => $month + 1]) }}"
        class="text-white text-4xl pr-10">&gt;</a>
    </div>
</div>

<!-- //エラーメッセージ・成功メッセージ -->
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" id="error-message" role="alert">
            <strong class="font-bold">エラー:</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
            <!-- ×ボタンを追加 -->
            <button type="submit" class="absolute top-0 right-0 px-4 py-3" onclick="closeMessage('error-message')">
                ×
            </button>
        </div>
    @elseif(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" id="success-message" role="alert">
            <strong class="font-bold">成功:</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
            <!-- ×ボタンを追加 -->
            <button type="button" class="absolute top-0 right-0 px-4 py-3" onclick="closeMessage('success-message')">
                ×
            </button>
        </div>
    @endif


    <!-- 打刻ログの表示 -->
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
            <tbody>
                @foreach ($dates as $date)
                    @php
                        $attendance = $attendances[$date->format('Y-m-d 00:00:00')] ?? null;
                    @endphp
                    <tr class="hover:bg-yellow-200 cursor-pointer" onclick="window.location='{{ $attendance ? route('workschedules.edit', $attendance->id) : '#' }}'">
                        <td class="px-4 py-3 border-b text-gray-600">{{ $date->format('m/d') }} ({{ $weekdays[$date->dayOfWeek] }})</td>
                        @if($attendance)
                            <td class="px-4 py-3 border-b">
                                <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-sm">出勤</span>
                            </td>
                            <td class="px-4 py-3 border-b text-gray-600">{{substr($attendance->clock_in, 0, 5)}}</td>
                            <td class="px-4 py-3 border-b text-gray-600">{{substr($attendance->clock_out, 0, 5)}}</td>
                            <td class="pr-4 border-b text-gray-600 text-right">&gt;</td>
                        @else
                            <td class="px-4 py-3 border-b text-gray-400">-</td>
                            <td class="px-4 py-3 border-b text-gray-400">-</td>
                            <td class="px-4 py-3 border-b text-gray-400">-</td>
                            <td class="pr-4 border-b text-gray-400 text-right"></td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection