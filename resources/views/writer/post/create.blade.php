<x-admin-layout>

    <x-slot name="header">
        <ul>
            <li>
                <a href="#">投稿</a>
                <ul>
                    <li>
                        <a href="#">新規投稿</a>
                    </li>
                </ul>
            </li>
        </ul>
    </x-slot>

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
                        <div class="mb-4" id="editor">
                        </div>

                        <!-- <script src="https://cdn.ckeditor.com/ckeditor5/43.1.1/ckeditor5.umd.js"></script>

                        <script>
                            const {
                                ClassicEditor,
                                Essentials,
                                Bold,
                                Italic,
                                Font,
                                Paragraph
                            } = CKEDITOR;

                            ClassicEditor
                                .create(document.querySelector('#editor'), {
                                    simpleUpload: {
                                        uploadUrl: '/upload',
                                        headers: {
                                            'X-CSRF-TOKEN': 'YOUR-CSRF-TOKEN'
                                        }
                                    },
                                    plugins: [Essentials, Bold, Italic, Font, Paragraph],
                                    toolbar: [
                                        'undo', 'redo', '|', 'bold', 'italic', '|',
                                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
                                    ]
                                })
                                .then( /* ... */ )
                                .catch( /* ... */ );
                        </script> -->


                        <!-- 画像アップロード -->
                        <div class="mb-6">
                            <label for="image" class="block text-sm font-medium text-gray-700">画像アップロード</label>
                            <input type="file" name="image" id="image" class="mt-1 block w-full">
                            @error('image')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

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