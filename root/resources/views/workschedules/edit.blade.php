@extends('layouts.mobile-app')

@section('content')
    <!-- タイトル -->
    <div class="bg-gradient-to-b from-green-400 to-green-500 py-8">
        <div class="flex justify-center">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-white">打刻編集</h1>
            </div>
        </div>
    </div>

    <!-- 日付 -->
    <div class="flex justify-center mt-4">
        <div class="text-center">
        </div>
    </div>

    <!-- 勤怠項目 -->
    <div class="flex justify-center mt-4">
        <div class="w-full max-w-md px-4">
            <div class="bg-white rounded-lg shadow-md pb-2">
                <h2 class="text-2xl font-semibold pl-2">勤怠項目</h2>
            </div>
            <form action="{{route('workschedules.update',['id' => $attendance->id])}}" method="POST" class="mt-4">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="#" class="block text-sm font-medium text-gray-700">開始/終了</label>
                    <div class="flex items-center space-x-2">
                        <input type="time" id="clock_in" name="clock_in" value="{{ old('clock_in', $attendance->clock_in ?? '') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        <span class="mx-2">ー</span>
                        <input type="time" id="clock_out" name="clock_out" value="{{ old('clock_out', $attendance->clock_out ?? '') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    </div>
                </div>
                <div class="mb-4">
                    <label for="#" class="block text-sm font-medium text-gray-700">休憩開始/休憩終了</label>
                    <div class="flex items-center space-x-2">
                        <input type="time" id="break_start" name="break_start" value="{{ old('break_start', $attendance->break_start ?? '') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        <span class="mx-2">ー</span>
                        <input type="time" id="break_end" name="break_end" value="{{ old('break_end', $attendance->break_end ?? '') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    </div>
                </div>
                <div class="mb-4">
                    <label for="notes_in" class="block text-sm font-medium text-gray-700">出勤メモ</label>
                    <input type="text" id="notes_in" name="notes_in" value="{{ old('notes_in', $attendance->notes_in ?? '入力されていません') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="notes_out" class="block text-sm font-medium text-gray-700">退勤メモ</label>
                    <input type="text" id="notes_out" name="notes_out" value="{{ old('notes_out', $attendance->notes_out ?? '入力されていません') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                </div>
                <div class="flex justify-between items-center gap-4">
                    <div class="flex gap-4">
                        <a href="{{ route('workschedules.index') }}"
                            class="w-full bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            戻る
                        </a>
                    </div>
                    <div class="flex gap-4">
                        <a href="#"
                            class="w-auto bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            申請
                        </a>
                        <button type="submit"
                            class="w-auto bg-blue-500 hover:bg-blue-500 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            更新
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection