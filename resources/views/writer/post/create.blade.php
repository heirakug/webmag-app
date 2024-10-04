<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <!-- バリデーションエラーの全体表示 -->
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

                    <!-- 投稿フォーム -->
                    <form action="{{ route('writer.post.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- タイトル -->
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">タイトル</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('title') border-red-500 @enderror">
                            @error('title')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- タイトル背景画像 -->
                        <div class="mb-4">
                            <label for="title_background" class="block text-sm font-medium text-gray-700">タイトル背景画像</label>
                            <input type="file" name="title_background" id="title_background" accept="image/*" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('title_background') border-red-500 @enderror" onchange="previewImage(this);">
                            <div id="image-preview" class="mt-2"></div>
                            @error('title_background')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- カテゴリ -->
                        <div class="mb-4">
                            <label for="category" class="block text-sm font-medium text-gray-700">カテゴリ</label>
                            <select name="category" id="category" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('category') border-red-500 @enderror">
                                <option value="">選択してください</option>
                                <option value="tech" {{ old('category') == 'tech' ? 'selected' : '' }}>技術</option>
                                <option value="life" {{ old('category') == 'life' ? 'selected' : '' }}>生活</option>
                                <option value="news" {{ old('category') == 'news' ? 'selected' : '' }}>ニュース</option>
                                <!-- 他のカテゴリを追加 -->
                            </select>
                            @error('category')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- 本文エディタ -->
                        <div class="mb-4">
                            <label for="editor" class="block text-sm font-medium text-gray-700">本文</label>
                            <div class="editor-container editor-container_classic-editor" id="editor-container">
                                <div class="editor-container__editor">
                                    <textarea id="editor" name="body" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('body') border-red-500 @enderror">{{ old('body') }}</textarea>
                                    @error('body')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- タグ -->
                        <div class="mb-4">
                            <label for="tags" class="block text-sm font-medium text-gray-700">タグ（カンマ区切りで入力）</label>
                            <input type="text" name="tags" id="tags" value="{{ old('tags') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('tags') border-red-500 @enderror">
                            <p class="mt-1 text-sm text-gray-500">複数のタグはカンマ（,）で区切って入力してください</p>
                            @error('tags')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- 公開・下書き -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700">ステータス</label>
                            <div class="mt-2">
                                <div class="flex items-center mt-2">
                                    <input type="radio" name="status" value="draft" id="draft" {{ old('status') == 'draft' ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                    <label for="draft" class="ml-2 block text-sm text-gray-700">準備中</label>
                                </div>
                                <div class="flex items-center mt-2">
                                    <input type="radio" name="status" value="ready_for_review" id="ready_for_review" {{ old('status') == 'ready_for_review' ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                    <label for="ready_for_review" class="ml-2 block text-sm text-gray-700">レビュー依頼</label>
                                </div>
                            </div>
                            @error('status')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- 提出ボタン -->
                        <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white text-sm hover:bg-blue-700">
                                投稿する
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('image-preview');
                    preview.innerHTML = `<img src="${e.target.result}" alt="プレビュー" class="mt-2 h-32 w-auto">`;
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-admin-layout>