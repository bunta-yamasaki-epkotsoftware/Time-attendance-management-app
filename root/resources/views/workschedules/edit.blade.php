@extends('layouts.mobile-app')

@section('content')
    <!-- タイトル -->
    <div class="bg-[#62b89d] py-8">
        <div class="flex justify-center">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-white">打刻編集</h1>
            </div>
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
                        <input type="time" id="clock_in" name="clock_in" value="{{ old('clock_in', $attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') : '') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        <span class="mx-2">ー</span>
                        <input type="time" id="clock_out" name="clock_out" value="{{ old('clock_out', $attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') : '') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    </div>
                </div>
                <div class="mb-4">
                    <label for="#" class="block text-sm font-medium text-gray-700">休憩開始/休憩終了</label>
                    <div class="flex items-center space-x-2">
                        <input type="time" id="break_start" name="break_start" value="{{ old('break_start', $attendance->break_start ? \Carbon\Carbon::parse($attendance->break_start)->format('H:i') : '') }}"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        <span class="mx-2">ー</span>
                        <input type="time" id="break_end" name="break_end" value="{{ old('break_end', $attendance->break_end ? \Carbon\Carbon::parse($attendance->break_end)->format('H:i') : '') }}"
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