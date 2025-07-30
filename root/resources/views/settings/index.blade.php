@extends('layouts.mobile-app')

@section('content')
    <!-- タイトル -->
    <div class="bg-[#62b89d] py-4">
        <div class="flex justify-center">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-white">設定</h1>
            </div>
        </div>
    </div>

    <div class="bg-white py-8 px-4">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">ログイン情報</h2>
            <div class="bg-white rounded-lg shadow-lg p-4 border">
                <p class="text-gray-600 flex justify-between">
                    <span>ログインID</span>
                    <span>{{$requests->employee_id}}</span>
                </p>
            </div>
            <div class="bg-white rounded-lg shadow-lg p-4 border">
                <p class="text-gray-600 flex justify-between">
                    <span>名前</span>
                    <span>{{$requests->name}}</span>
                </p>
            </div>
            <div class="bg-white rounded-lg shadow-lg p-4 border">
                <p class="text-gray-600 flex justify-between">
                    <span>メールアドレス</span>
                    <span>{{$requests->email}}</span>
                </p>
            </div>
        </div>
    </div>
    <div class="bg-white py-8 px-4">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">アプリ管理</h2>
            <div class="bg-white rounded-lg shadow-lg p-4 border">
                <p class="text-gray-600 flex justify-between">
                    <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-black hover:text-red-800">
                                ログアウト
                            </button>
                    </form>
                </p>
            </div>
        </div>
    </div>

    <script>
        let deferredPrompt;
        const installButton = document.getElementById('installButton');

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            installButton.style.display = 'block';
        });

        installButton.addEventListener('click', async () => {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                const { outcome } = await deferredPrompt.userChoice;
                deferredPrompt = null;
                installButton.style.display = 'none';
            }
        });
    </script>
@endsection