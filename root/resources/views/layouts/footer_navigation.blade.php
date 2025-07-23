<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-evenly items-center h-20 pb-4">
            <!-- ホーム -->
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center py-2 px-1 sm:px-3 rounded-lg {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-500' }} hover:text-blue-600 transition-colors">
                <div class="text-lg sm:text-2xl mb-1">🏠</div>
                <span class="text-xs font-medium">ホーム</span>
            </a>

            <!-- 勤務表 -->
            <a href="#" class="flex flex-col items-center py-2 px-1 sm:px-3 rounded-lg text-gray-500 hover:text-blue-600 transition-colors">
                <div class="text-lg sm:text-2xl mb-1">📋</div>
                <span class="text-xs font-medium">勤務表</span>
            </a>

            <!-- 勤務集計 -->
            <a href="#" class="flex flex-col items-center py-2 px-1 sm:px-3 rounded-lg text-gray-500 hover:text-blue-600 transition-colors">
                <div class="text-lg sm:text-2xl mb-1">📊</div>
                <span class="text-xs font-medium">勤務集計</span>
            </a>

            <!-- 設定 -->
            <a href="{{route('settings.index'}}" class="flex flex-col items-center py-2 px-1 sm:px-3 rounded-lg text-gray-500 hover:text-blue-600 transition-colors">
                <div class="text-lg sm:text-2xl mb-1">⚙️</div>
                <span class="text-xs font-medium">設定</span>
            </a>
        </div>
    </div>
</nav>