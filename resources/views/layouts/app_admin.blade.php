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

    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.1.1/ckeditor5.css" />

</head>

<body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')

        <div class="flex">

            <!-- サイドメニュー -->
            <aside class="bg-white shadow w-44 min-h-screen">
                <nav class="py-6 px-4 sm:px-6 lg:px-8">

                    <ul class="space-y-2">

                        <li class="relative group">
                            <!-- メニューアイテム -->
                            <a href="#"
                                class="block p-2 text-gray-700 hover:bg-gray-200 rounded {{ request()->is('writer/post*') ? 'border-b-2 border-blue-500' : '' }}">
                                投稿
                            </a>

                            <!-- サブメニュー -->
                            <ul class="pl-4 hidden group-hover:block transition-all duration-300 ease-in-out">
                                <li>
                                    <a href="{{ route('writer.post.index') }}"
                                        class="block p-2 text-gray-600 hover:bg-gray-200 rounded {{ request()->is('writer/post/index') ? 'border-b-2 border-blue-500' : '' }}">
                                        投稿一覧
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('writer.post.create') }}"
                                        class="block p-2 text-gray-600 hover:bg-gray-200 rounded {{ request()->is('writer/post/create') ? 'border-b-2 border-blue-500' : '' }}">
                                        新規投稿
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>

                </nav>
            </aside>


            <!-- Page Content -->
            <div class="ml-44 p-4"> <!-- サイドメニューの幅分のマージンを設定 -->

                <main>
                    {{ $slot }}
                </main>
            </div>

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
