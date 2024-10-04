<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Rules\SafeHtml;
use Mews\Purifier\Facades\Purifier;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use App\Models\writer;
use App\Models\editor;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    // ::::::::::
    // ::::::::::
    // ::::::::::
    // ポスト一覧
    // ::::::::::
    // ::::::::::
    // ::::::::::
    public function list(): View
    {
        $posts = Post::latest()->paginate(10); // 最新の投稿を10件ずつ取得

        if (Auth::guard('editor')->check()) {
            return view('editor.post.list', compact('posts'));
        }

        return view('writer.post.list', compact('posts'));
    }

    // ::::::::::
    // ::::::::::
    // ::::::::::
    // ポスト作成
    // ::::::::::
    // ::::::::::
    // ::::::::::
    public function create(): View
    {
        if (Auth::guard('editor')->check()) {
            return view('editor.post.create');
        }

        return view('writer.post.create');
    }

    // ::::::::::
    // ::::::::::
    // ::::::::::
    // ポスト編集
    // ::::::::::
    // ::::::::::
    // ::::::::::
    public function edit($id): View
    {
        $post = Post::findOrFail($id);
        // dd($post);

        // 現在のユーザーが投稿の作成者であるか確認
        if (Auth::guard('writer')->id() !== $post->writer_id) {
            return redirect()->route('writer.post.index')->with('error', '他の作者の投稿は編集できません。');
        }

        return view('writer.post.edit', compact('post'));
    }

    // ::::::::::
    // ::::::::::
    // ::::::::::
    // ポスト投稿
    // ::::::::::
    // ::::::::::
    // ::::::::::
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'title_background' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required|string|max:100',
            'body' => ['required', 'string', new SafeHtml],
            'tags' => 'nullable|string',
            'status' => 'required|string|in:' . implode(',', array_keys(Post::STATUS_LIST)),
        ]);

        // HTMLを安全に保存
        $validated['body'] = Purifier::clean($validated['body']);

        // タグの処理
        if ($request->has('tags')) {
            $tags = array_map('trim', explode(',', $request->tags));
            $tags = array_filter($tags); // 空の要素を削除
            $validated['tags'] = json_encode(array_values($tags));
        } else {
            $validated['tags'] = null;
        }

        // 新しい投稿を作成
        $post = new Post($validated);

        // ライターの情報取得
        $writer_id = auth('writer')->id();
        $writer_name = Writer::find($writer_id)->value('name');

        $post->writer_id = $writer_id;
        $post->writer_name = $writer_name;

        // エディターの場合、editor_idとeditor_nameも設定
        if (Auth::guard('editor')->check()) {
            $editor_id = auth('editor')->id();
            $editor_name = Editor::find($editor_id)->value('name');

            $post->editor_id = $editor_id;
            $post->editor_name = $editor_name;
        }

        // 画像のアップロード処理
        if ($request->hasFile('title_background')) {
            $image = $request->file('title_background');
            $filename = time() . '_' . $image->getClientOriginalName();

            // 画像を保存し、パスを取得
            $path = Storage::disk('public')->putFileAs('title_backgrounds', $image, $filename);

            // データベースに保存するパスを設定
            $post->title_background = $path;
        }

        $post->save();

        // リダイレクト先とメッセージを設定
        $redirectRoute = Auth::guard('editor')->check() ? 'editor.post.list' : 'writer.post.list';
        $message = '投稿が正常に保存されました。';

        return redirect()->route($redirectRoute)->with('success', $message);
    }

    // ::::::::::
    // ::::::::::
    // ::::::::::
    // ポスト更新
    // ::::::::::
    // ::::::::::
    // ::::::::::
    public function update(Request $request, $id)
    {

        // dd($request);

        $post = Post::findOrFail($id);

        // 現在のユーザーが投稿の作成者であるか確認
        if (Auth::guard('writer')->id() !== $post->writer_id) {
            return redirect()->route('writer.post.index')->with('error', '他の作者の投稿は編集できません。');
        }

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'title_background' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'category' => 'required|string|max:100',
                'body' => ['required', 'string', new SafeHtml],
                'tags' => 'nullable|string',
                'status' => 'required|string|in:' . implode(',', array_keys(Post::STATUS_LIST)),
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error: ' . json_encode($e->errors()));
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        // HTMLを安全に保存
        $validated['body'] = Purifier::clean($validated['body']);
        // dd($validated['body']);

        // タグの処理
        if ($request->has('tags')) {
            $tags = array_map('trim', explode(',', $request->tags));
            $tags = array_filter($tags); // 空の要素を削除
            $validated['tags'] = json_encode(array_values($tags));
        } else {
            $validated['tags'] = null;
        }
        // dd($validated);

        // 画像のアップロード処理
        if ($request->hasFile('title_background')) {
            // 古い画像を削除
            if ($post->title_background) {
                Storage::disk('public')->delete($post->title_background);
            }

            $imagePath = $request->file('title_background')->store('post_images', 'public');
            $validated['title_background'] = $imagePath;
        }

        $post->update($validated);

        return redirect()->route('writer.post.list')->with('success', '投稿が更新されました。');
    }

    // ::::::::::
    // ::::::::::
    // ::::::::::
    // ポスト削除
    // ::::::::::
    // ::::::::::
    // ::::::::::
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // 現在のユーザーが投稿の作成者であるか確認
        if (Auth::guard('writer')->id() !== $post->writer_id) {
            return redirect()->route('writer.post.list')->with('error', '他の作者の投稿は削除できません。');
        }

        // 関連する画像ファイルの削除
        if ($post->image) {
            // 画像ファイルの削除処理をここに書く
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('writer.post.list')->with('success', '投稿が削除されました。');
    }
}
