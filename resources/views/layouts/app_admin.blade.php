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

    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')

        <div class="flex">

            <!-- サイドメニュー -->
            <aside class="bg-white shadow w-44 min-h-screen">
                <div class="py-6 px-4 sm:px-6 lg:px-8">
                    <ul class="space-y-2">
                        <li>
                            <a href="" class="block p-2 text-gray-700 hover:bg-gray-200 rounded" onclick="toggleSubmenu(event, 'submenu-post')">投稿</a>
                            <ul id="submenu-post" class="hidden pl-4 transition-all duration-300 ease-in-out max-h-0 overflow-hidden">
                                <li>
                                    <a href="{{route('writer.post.index')}}" class="block p-2 text-gray-600 hover:bg-gray-200 rounded">投稿一覧</a>
                                </li>
                                <li>
                                    <a href="{{route('writer.post.create')}}" class="block p-2 text-gray-600 hover:bg-gray-200 rounded">新規投稿</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </aside>

            <!-- Page Content -->
            <div class="ml-44 p-4"> <!-- サイドメニューの幅分のマージンを設定 -->
                {{ $slot }}
                </main>
            </div>
        </div>

        @stack('modals')

        @livewireScripts
</body>
<script>
        function toggleSubmenu(event, submenuId) {
            event.preventDefault(); // デフォルトのリンク動作を防ぐ
            const submenu = document.getElementById(submenuId);
            submenu.classList.toggle('hidden');
            submenu.classList.toggle('max-h-0');
            submenu.classList.toggle('max-h-screen'); // スクリーンに合わせて高さを調整
        }
    </script>

</html>