<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex items-center lg:justify-center flex-col w-full">
        <header class="bg-[#62b89d] w-full text-sm mb-6 not-has-[nav]:hidden text-center">
            <h1 class="text-2xl font-semibold mb-2 mt-2">ログイン画面</h1>
        </header>
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
        </div>
        <footer class="bg-[#62b89d] w-full text-sm mt-6 not-has-[nav]:hidden text-center">
            <h1 class="text-2xl font-semibold mb-1">xxxxxxxxxxx</h1>
        </footer>
    </body>
</html>
