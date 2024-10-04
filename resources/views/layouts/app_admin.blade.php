<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <!-- <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> -->

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

</head>

<body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')

        <div class="flex flex-row">

            <!-- サイドメニュー -->
            <aside class="bg-white shadow  min-h-screen w-64 flex-shrink-0">
                <nav class="py-6 px-4 sm:px-6 lg:px-8">

                    <ul class="space-y-2">

                        <li>
                            <span class="mdi mdi-view-dashboard"></span>
                            <a href="{{route('writer.dashboard')}}" class="admin-menu">ダッシュボード</a>
                        </li>

                        <li class="relative group">
                            <!-- メニューアイテム -->
                            <span class="mdi mdi-post"></span>
                            <a href="#" class="admin-menu">
                                投稿
                            </a>

                            <!-- サブメニュー -->
                            <ul class="pl-4 transition-all duration-300 ease-in-out {{ request()->is('*/post/*') ? '' : 'hidden group-hover:block' }}">
                                <li>
                                    <a href="{{ route('writer.post.list') }}"
                                        class="block admin-menu {{ request()->is('writer/post/list') ? 'bg-gray-200' : '' }}">
                                        投稿一覧
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('writer.post.create') }}"
                                        class="block admin-menu {{ request()->is('writer/post/create') ? 'bg-gray-200' : '' }}">
                                        新規投稿
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>

                </nav>
            </aside>

            <!-- Page Content -->
            <main class="flex-grow max-w-2xl">
                {{ $slot }}
            </main>

        </div>

        @stack('modals')

        @livewireScripts

        <!-- <script>
            function toggleSubmenu(event, submenuId) {
                event.preventDefault(); // デフォルトのリンク動作を防ぐ
                const submenu = document.getElementById(submenuId);
                submenu.classList.toggle('hidden');
                submenu.classList.toggle('max-h-0');
                submenu.classList.toggle('max-h-screen'); // スクリーンに合わせて高さを調整
            }
        </script> -->

</body>

</html>