<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- タイトル -->
                <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $post->title }}</h1>

                <!-- タイトル背景画像 -->
                @if ($post->title_background)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $post->title_background) }}" alt="タイトル背景画像" class="w-full h-auto rounded-md">
                    </div>
                @endif

                <!-- カテゴリ -->
                <p class="text-sm font-medium text-gray-600">カテゴリ: {{ $post->category }}</p>

                <!-- 本文 -->
                <div class="mt-4 text-gray-800 leading-relaxed">
                    {!! $post->body !!}
                </div>

                <!-- 抜粋 -->
                <div class="mt-4 bg-gray-100 p-4 rounded">
                    <h2 class="text-lg font-semibold text-gray-800">抜粋</h2>
                    <p class="text-gray-600">{{ $post->excerpt }}</p>
                </div>

                <!-- タグ -->
                @if ($post->tags)
                    <div class="mt-4">
                        <h3 class="text-lg font-semibold text-gray-800">タグ</h3>
                        @php
                            $tags = json_decode($post->tags, true);
                        @endphp
                        <ul class="list-disc list-inside">
                            @foreach ($tags as $tag)
                                <li>{{ $tag }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- ライター情報 -->
                <div class="mt-6 text-sm text-gray-500">
                    <p>投稿者: {{ $post->writer_name }}</p>
                    @if ($post->editor_name)
                        <p>編集者: {{ $post->editor_name }}</p>
                    @endif
                </div>

                <!-- プレビューの終了 -->
                <div class="mt-6">
                    <a href="{{ route('writer.post.create') }}" class="text-blue-600 hover:underline">
                        投稿の編集に戻る
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
