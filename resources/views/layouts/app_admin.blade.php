<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

</head>

<body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100" x-data="{ sidebarOpen: true }">
        @livewire('navigation-menu')

        <div class="flex">
            <!-- サイドメニュー -->
            <aside :class="sidebarOpen ? 'w-[12em]' : 'w-16'" class="bg-white shadow min-h-screen">
                <button @click="sidebarOpen = !sidebarOpen" class="p-4 focus:outline-none">
                    <span x-show="sidebarOpen" class="mdi mdi-arrow-left"></span>
                    <span x-show="!sidebarOpen" class="mdi mdi-arrow-right"></span>
                </button>

                <nav class="py-6 px-4 sm:px-6 lg:px-8">
                    <ul class="space-y-2">

                        <li class="flex items-center h-[40px]">
                            <span class="mdi mdi-view-dashboard"></span>
                            <span x-show="sidebarOpen" class="ml-2">
                                <a class="block admin-menu w-[8em]" href="{{route('writer.dashboard')}}">ダッシュボード</a>
                            </span>
                        </li>

                        <li class="relative group flex flex-col tems-center">
                            <div>
                                <span class="mdi mdi-post"></span>
                                <span x-show="sidebarOpen" class="ml-2">投稿</span>
                            </div>

                            <!-- サブメニュー -->
                            <ul class="pl-4 transition-all duration-300 ease-in-out ml-[2px]" x-show="sidebarOpen">
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
            <main class="flex-grow">
                {{ $slot }}
            </main>
        </div>

        @stack('modals')
        @livewireScripts
    </div>
</body>

</html>