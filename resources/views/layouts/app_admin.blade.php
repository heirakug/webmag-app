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

        <div class="flex flex-row">

            <!-- サイドメニュー -->
            @if('aside')
            {{$aside}}
            @endif('aside')

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