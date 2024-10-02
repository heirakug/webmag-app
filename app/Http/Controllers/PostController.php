<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PostController extends Controller
{
    // ポスト一覧
    public function index(): View
    {
        if (Auth::guard('editor')->check()) {
            return view('editor.post.index');
        }

        return view('writer.post.index');
    }

    // ポスト作成
    public function create(): View
    {
        if (Auth::guard('editor')->check()) {
            return view('editor.post.create');
        }

        return view('writer.post.create');
    }

    // ポスト投稿
    public function store(): View
    {
        if (Auth::guard('editor')->check()) {
            return view('editor.post.index');
        }

        return view('writer.post.index');
    }
}
