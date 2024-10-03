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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- フラッシュメッセージの表示 -->
            @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-semibold mb-4">投稿リスト</h2>

                @if($posts->isEmpty())
                <p>投稿がありません。</p>
                @else
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">タイトル</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">カテゴリ</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ステータス</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">作成日</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">アクション</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($posts as $post)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $post->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $post->category }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $post->status_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $post->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('writer.post.edit', $post->id) }}" class="text-indigo-600 hover:text-indigo-900">編集</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $posts->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>