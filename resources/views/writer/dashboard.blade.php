<x-admin-layout>
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