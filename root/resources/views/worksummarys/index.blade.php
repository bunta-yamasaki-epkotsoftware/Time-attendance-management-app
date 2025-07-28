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

<!-- 勤怠時間項目 -->
<div class="bg-white py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="shadow-md rounded-lg p-6 bg-gray-50">
            <h2 class="text-lg font-sans text-gray-800">勤怠時間項目</h2>
            <div class="grid grid-cols-4 gap-4">
                <div class="bg-gray-100 p-4 rounded">所定時間
                    <div class="text-lg">{{ ($workdays * 8).':00' }}</div>
                </div>
                <div class="bg-gray-100 p-4 rounded">労働時間
                    <div class="text-lg">8:00</div>
                </div>
                <div class="bg-gray-100 p-4 rounded">時間外
                    <div class="text-lg">8:00</div>
                </div>
                <div class="bg-gray-100 p-4 rounded">深夜
                    <div class="text-lg">8:00</div>
                </div>
                <div class="bg-gray-100 p-4 rounded">法定休日
                    <div class="text-lg">8:00</div>
                </div>
                <div class="bg-gray-100 p-4 rounded">法定休日深夜
                    <div class="text-lg">8:00</div>
                </div>
            </div>
        </div>

        <div class="shadow-md rounded-lg p-6 bg-gray-50">
            <h2 class="text-lg font-sans text-gray-800 mt-8">勤怠日数・休暇項目</h2>
            <div class="grid grid-cols-4 gap-4">
                <div class="bg-gray-100 p-4 rounded">所定出勤日
                    <div class="text-lg">{{ $workdays.'.0日' }}</div>
                </div>
                <div class="bg-gray-100 p-4 rounded">出勤日数
                    <div class="text-lg">22.0日</div>
                </div>
                <div class="bg-gray-100 p-4 rounded">有給休暇日数
                    <div class="text-lg">2.0日</div>
                </div>
                <div class="bg-gray-100 p-4 rounded">有給休暇残り日数
                    <div class="text-lg">36.0日</div>
                </div>
            </div>
        </div>

        <div class="shadow-md rounded-lg p-6 bg-gray-50">
            <h2 class="text-lg font-sans text-gray-800 mt-8">勤務区分項目</h2>
            <div class="grid grid-cols-4 gap-4">
                <div class="bg-gray-100 p-4 rounded">出勤
                    <div class="text-lg">20</div>
                </div>
                <div class="bg-gray-100 p-4 rounded">欠勤
                    <div class="text-lg">0</div>
                </div>
                <div class="bg-gray-100 p-4 rounded">有給休暇
                    <div class="text-lg">2</div>
                </div>
                <div class="bg-gray-100 p-4 rounded">午前半休
                    <div class="text-lg">0</div>
                </div>
                <div class="bg-gray-100 p-4 rounded">午後半休
                    <div class="text-lg">0</div>
                </div>
                <div class="bg-gray-100 p-4 rounded">遅刻
                    <div class="text-lg">0</div>
                </div>
                <div class="bg-gray-100 p-4 rounded">早退
                    <div class="text-lg">0</div>
                </div>
                <div class="bg-gray-100 p-4 rounded">代休
                    <div class="text-lg">0</div>
                </div>
                <div class="bg-gray-100 p-4 rounded">休み
                    <div class="text-lg">0</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection