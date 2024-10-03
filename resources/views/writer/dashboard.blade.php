<x-admin-layout>

<x-slot name="aside">
        <aside class="bg-white shadow  min-h-screen w-64 flex-shrink-0">
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
    </x-slot>
    
    <x-slot name="header">
        <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if (auth('writer')->check())
            ライター
            @elseif (auth('editor')->check())
            編集者
            @elseif (auth('admin')->check())
            管理者
            @endif
            管理画面
        </h2> -->

        <ul>
            <li>
                <a href="#">投稿</a>
            </li>
        </ul>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-welcome />
            </div>
        </div>
    </div>
</x-admin-layout>