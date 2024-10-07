<x-admin-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-xs md:max-w-xl w-full px-4 sm:px-6 lg:px-8 overflow-hidden">

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

                <form action="{{ route('writer.post.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="max-w-xl">
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
                        <label for="title_background" class="block text-sm font-medium text-gray-700">タイトル背景画像</label>
                        <div class="mt-1 flex items-center">
                            <input type="file" name="title_background" id="title_background" accept="image/*" class="hidden" onchange="previewImage(this);">
                            <label for="title_background" class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                画像を選択
                            </label>
                            <span id="file-name" class="ml-3 text-sm text-gray-500"></span>
                        </div>
                        <div id="image-preview" class="mt-2">
                            @if($post->title_background)
                            <img src="{{ asset('storage/' . $post->title_background) }}" alt="現在の背景画像" class="h-32 w-auto">
                            @endif
                        </div>
                        @error('title_background')
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

                    <!-- ボディ -->
                    <div class="mb-4">
                        <label for="editor" class="block text-sm font-medium text-gray-700">本文</label>
                        <div class="editor-container editor-container_classic-editor" id="editor-container">
                            <div class="editor-container__editor">
                                <textarea id="editor" name="body" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('body') border-red-500 @enderror">{{ old('body', $post->body) }}</textarea>
                                @error('body')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- 抜粋 -->
                    <div class="mb-4">
                        <label for="excerpt" class="block text-sm font-medium text-gray-700">抜粋</label>
                        <textarea name="excerpt" id="excerpt" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('excerpt') border-red-500 @enderror">{{ old('excerpt', $post->excerpt) }}</textarea>
                        <p class="mt-1 text-sm text-gray-500">記事の簡単な概要や抜粋を入力してください</p>
                        @error('excerpt')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- タグ -->
                    <div class="mb-4">
                        <label for="tags" class="block text-sm font-medium text-gray-700">タグ（カンマ区切りで入力）</label>
                        <input type="text" name="tags" id="tags" value="{{ old('tags', $post->tags ? implode(', ', json_decode($post->tags, true)) : '') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('tags') border-red-500 @enderror">
                        <p class="mt-1 text-sm text-gray-500">複数のタグはカンマ（,）で区切って入力してください</p>
                        @error('tags')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">ステータス</label>
                        <div class="mt-2 flex items-center">
                            <input type="radio" name="status" value="draft" id="draft" {{ old('status', $post->status) == 'draft' ? 'checked' : '' }}>
                            <label for="draft" class="ml-2 text-sm font-medium text-gray-700">準備中</label>
                        </div>
                        <div class="mt-2 flex items-center">
                            <input type="radio" name="status" value="ready_for_review" id="ready_for_review" {{ old('status', $post->status) == 'ready_for_review' ? 'checked' : '' }}>
                            <label for="ready_for_review" class="ml-2 text-sm font-medium text-gray-700">レビュー依頼</label>
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

    <script>
        function previewImage(input) {
            const file = input.files[0];
            if (file) {
                const fileName = file.name;
                document.getElementById('file-name').textContent = fileName;

                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('image-preview');
                    preview.innerHTML = `<img src="${e.target.result}" alt="プレビュー" class="h-32 w-auto">`;
                }
                reader.readAsDataURL(file);
            }
        }
    </script>

</x-admin-layout>