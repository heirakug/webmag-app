<x-admin-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold mb-6">ブログ投稿</h1>

                    <!-- 投稿フォーム -->
                    <form action="{{ route('writer.post.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- タイトル -->
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">タイトル</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('title') border-red-500 @enderror">
                            @error('title')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- カテゴリ -->
                        <div class="mb-4">
                            <label for="category" class="block text-sm font-medium text-gray-700">カテゴリ</label>
                            <select name="category" id="category" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <option value="">選択してください</option>
                                <option value="tech">技術</option>
                                <option value="life">生活</option>
                                <option value="news">ニュース</option>
                                <!-- 他のカテゴリを追加 -->
                            </select>
                            @error('category')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- コンテンツ -->
                        <div class="mb-6">
                            <label for="content" class="block text-sm font-medium text-gray-700">本文</label>
                            <textarea name="content" id="content" rows="10" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('content') border-red-500 @enderror">{{ old('content') }}</textarea>
                            @error('content')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- 画像アップロード -->
                        <div class="mb-6">
                            <label for="image" class="block text-sm font-medium text-gray-700">画像アップロード</label>
                            <input type="file" name="image" id="image" class="mt-1 block w-full">
                            @error('image')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <textarea id="ckeditor" name="pageBody"></textarea>

                        {{-- CKEditor --}}
                        <script src="//cdn.ckeditor.com/4.15.0/full/ckeditor.js"></script>
                        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
                        <script src="js/ckeditor.js"></script>


                        <!-- 公開・下書き -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700">ステータス</label>
                            <div class="mt-2 flex items-center">
                                <input type="radio" name="status" value="published" id="published" checked>
                                <label for="published" class="ml-2 text-sm font-medium text-gray-700">公開</label>
                            </div>
                            <div class="mt-2 flex items-center">
                                <input type="radio" name="status" value="draft" id="draft">
                                <label for="draft" class="ml-2 text-sm font-medium text-gray-700">下書き</label>
                            </div>
                            @error('status')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
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

</x-admin-layout>