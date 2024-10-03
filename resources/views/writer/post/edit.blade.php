<x-admin-layout>
    <x-slot name="aside">
        <aside class="bg-white shadow  min-h-screen w-64 flex-shrink-0">
            <nav class="py-6 px-4 sm:px-6 lg:px-8">
                <ul class="space-y-2">
                    <li class="relative group">
                        <a href="#"
                            class="block p-2 text-gray-700 hover:bg-gray-200 rounded {{ request()->is('writer/post*') ? 'border-b-2 border-blue-500' : '' }}">
                            投稿
                        </a>
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
            <div class="overflow-hidden">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h2 class="text-2xl font-semibold mb-4">投稿の編集</h2>

                    @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">入力内容にエラーがあります。</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('writer.post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">タイトル</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('title') border-red-500 @enderror">
                            @error('title')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="category" class="block text-sm font-medium text-gray-700">カテゴリ</label>
                            <select name="category" id="category" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('category') border-red-500 @enderror">
                                <option value="">選択してください</option>
                                <option value="tech" {{ old('category', $post->category) == 'tech' ? 'selected' : '' }}>技術</option>
                                <option value="life" {{ old('category', $post->category) == 'life' ? 'selected' : '' }}>生活</option>
                                <option value="news" {{ old('category', $post->category) == 'news' ? 'selected' : '' }}>ニュース</option>
                            </select>
                            @error('category')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- <div class="mb-4">
                            <label for="body" class="block text-sm font-medium text-gray-700">本文</label>
                            <textarea id="editor" name="body">{{ old('body', $post->body) }}</textarea>
                            @error('body')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div> -->

                        <div class="main-container mb-4">
                            <label for="body" class="block text-sm font-medium text-gray-700">本文</label>
                            <div class="editor-container editor-container_classic-editor" id="editor-container">
                                <div class="editor-container__editor">
                                    <textarea id="editor" name="body">{{ old('body', $post->body) }}</textarea>
                                    @error('body')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700">ステータス</label>
                            <div class="mt-2 flex items-center">
                                <input type="radio" name="status" value="draft" id="draft" {{ old('status', $post->status) == 'draft' ? 'checked' : '' }}>
                                <label for="draft" class="ml-2 text-sm font-medium text-gray-700">下書き</label>
                            </div>
                            <div class="mt-2 flex items-center">
                                <input type="radio" name="status" value="published" id="published" {{ old('status', $post->status) == 'published' ? 'checked' : '' }}>
                                <label for="published" class="ml-2 text-sm font-medium text-gray-700">公開</label>
                            </div>
                            @error('status')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700">
                                更新する
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>