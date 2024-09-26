<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Editor;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class EditorRegisterController extends Controller
{
    // 登録画面呼び出し
    public function create(): View
    {
        return view('editor.auth.register');
    }

    // 登録実行
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.Editor::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $editor = Editor::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($editor));

        Auth::guard('editor')->login($editor);

				return redirect('/editor/dashboard');
    }
}
