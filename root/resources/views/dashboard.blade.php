@extends('layouts.mobile-app')

@section('content')
            <!-- タイトル -->
    <div class="bg-gradient-to-b from-green-400 to-green-500 py-8">
        <div class="flex justify-center">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-white">RecoRu</h1>
            </div>
        </div>

        <!-- 日付表示 -->
        <div class="flex justify-center mt-5">
            <div class="text-center">
                <div class="mt-6">
                    <div id="current-date" class="text-xl text-white mb-2"></div>
                    <div id="current-time" class="text-3xl font-bold text-white"></div>
                </div>
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

    <!-- 出勤・退勤表示 -->
    <div class="bg-gradient-to-b from-green-400 to-green-500 py-8">
        <div class="flex flex-col items-center space-y-4">

            <!-- 出勤・退勤ボタン -->
            <div class="flex space-x-4">
                <form method="POST" action="{{route('attendance.clockIn')}}" class="attendance-form" id="clockin-form">
                    @csrf
                    <input type="hidden" name="type" value="clock_in">
                    <input type="hidden" name="notes_in" id="clockin-notes">
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-4 px-12 rounded-lg text-xl shadow-lg">
                        出勤
                    </button>
                </form>

                <form method="POST" action="{{route('attendance.clockOut')}}" class="attendance-form" id="clockout-form">
                    @csrf
                    <input type="hidden" name="type" value="clock_out">
                    <input type="hidden" name="notes_out" id="clockout-notes">
                    <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 px-12 rounded-lg text-xl shadow-lg">
                        退勤
                    </button>
                </form>
            </div>

    <!-- 休憩・戻り表示 -->
    <div class="bg-gradient-to-b from-green-400 to-green-500">
        <div class="flex flex-col items-center space-y-4">

            <!-- 休憩・戻りボタン -->
            <div class="flex space-x-4">
                <form method="POST" action="{{route('attendance.breakStart')}}" class="attendance-form" id="break_start-form">
                    @csrf
                    <input type="hidden" name="type" value="break_start">
                    <button type="submit" class="bg-violet-500 hover:bg-violet-600 text-white font-bold py-4 px-12 rounded-lg text-xl shadow-lg">
                        休憩
                    </button>
                </form>

                <form method="POST" action="{{route('attendance.breakEnd')}}" class="attendance-form" id="break_end-form">
                    @csrf
                    <input type="hidden" name="type" value="break_end">
                    <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-4 px-12 rounded-lg text-xl shadow-lg">
                        戻り
                    </button>
                </form>
            </div>

            <!-- メモ入力欄 -->
            <div class="w-full max-w-md mt-4">
                <input type="text" id="attendance-memo" name="test_memo" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-700" placeholder="私用で早退します">
            </div>
        </div>
    </div>

            <!-- 打刻ログの表示 -->
    <div class="bg-white py-8 px-4">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4 mt-4">打刻ログ</h2>
            <div class="bg-white rounded-lg shadow-lg p-4 border">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 border-b font-semibold text-gray-700">日時</th>
                            <th class="px-4 py-3 border-b font-semibold text-gray-700">時間</th>
                            <th class="px-4 py-3 border-b font-semibold text-gray-700">打刻</th>
                            <th class="px-4 py-3 border-b font-semibold text-gray-700">メモ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($requests as $request)
                        @if(!empty($request->clock_out))
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 border-b text-gray-600">{{$request->work_date->format('Y-m-d')}}</td>
                            <td class="px-4 py-3 border-b text-gray-600">{{substr($request->clock_out, 0, 5)}}</td>
                            <td class="px-4 py-3 border-b">
                                <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-sm">退勤</span>
                            </td>
                            <td class="px-4 py-3 border-b text-gray-600">{{$request->notes_out}}</td>
                        </tr>
                        @endif
                        @if(!empty($request->break_end))
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 border-b text-gray-600">{{$request->work_date->format('Y-m-d')}}</td>
                            <td class="px-4 py-3 border-b text-gray-600">{{substr($request->break_end, 0, 5)}}</td>
                            <td class="px-4 py-3 border-b">
                                <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-sm">戻り</span>
                            </td>
                        </tr>
                        @endif
                        @if(!empty($request->break_start))
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 border-b text-gray-600">{{$request->work_date->format('Y-m-d')}}</td>
                            <td class="px-4 py-3 border-b text-gray-600">{{substr($request->break_start, 0, 5)}}</td>
                            <td class="px-4 py-3 border-b">
                                <span class="bg-violet-100 text-violet-800 px-2 py-1 rounded-full text-sm">休憩</span>
                            </td>
                        </tr>
                        @endif
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 border-b text-gray-600">{{$request->work_date->format('Y-m-d')}}</td>
                            <td class="px-4 py-3 border-b text-gray-600">{{substr($request->clock_in, 0, 5)}}</td>
                            <td class="px-4 py-3 border-b">
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm">出勤</span>
                            </td>
                            <td class="px-4 py-3 border-b text-gray-600">{{$request->notes_in}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <!-- ページネーションリンク -->
                    {{ $requests->links('pagination::tailwind') }}
                </table>
            </div>
        </div>
    </div>

@endsection
