<?php

use Illuminate\Support\Facades\Route;

// [add admin auth 20240925]
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminRegisterController;

// [add writer editor auth 20240926]
use App\Http\Controllers\Writer\WriterLoginController;
use App\Http\Controllers\Writer\WriterRegisterController;
use App\Http\Controllers\Editor\EditorLoginController;
use App\Http\Controllers\Editor\EditorRegisterController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| 管理者用ルーティング
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin'], function () {
    // 登録
    Route::get('register', [AdminRegisterController::class, 'create'])
        ->name('admin.register');

    Route::post('register', [AdminRegisterController::class, 'store']);

    // ログイン
    Route::get('login', [AdminLoginController::class, 'showLoginPage'])
        ->name('admin.login');

    Route::post('login', [AdminLoginController::class, 'login']);

    // 以下の中は認証必須のエンドポイントとなる
    Route::middleware(['auth:admin'])->group(function () {
        // ダッシュボード
        Route::get('dashboard', fn() => view('admin.dashboard'))
            ->name('admin.dashboard');
    });
});

/*
|--------------------------------------------------------------------------
| ライター用ルーティング
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'writer'], function () {
    // 登録
    Route::get('register', [WriterRegisterController::class, 'create'])
        ->name('writer.register');

    Route::post('register', [WriterRegisterController::class, 'store']);

    // ログイン
    Route::get('login', [WriterLoginController::class, 'showLoginPage'])
        ->name('writer.login');

    Route::post('login', [WriterLoginController::class, 'login']);

    // 以下の中は認証必須のエンドポイントとなる
    Route::middleware(['auth:writer'])->group(function () {
        // ダッシュボード
        Route::get('dashboard', fn() => view('writer.dashboard'))
            ->name('writer.dashboard');
    });
});

/*
|--------------------------------------------------------------------------
| 編集者用ルーティング
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'editor'], function () {
    // 登録
    Route::get('register', [EditorRegisterController::class, 'create'])
        ->name('editor.register');

    Route::post('register', [EditorRegisterController::class, 'store']);

    // ログイン
    Route::get('login', [EditorLoginController::class, 'showLoginPage'])
        ->name('editor.login');

    Route::post('login', [EditorLoginController::class, 'login']);

    // 以下の中は認証必須のエンドポイントとなる
    Route::middleware(['auth:editor'])->group(function () {
        // ダッシュボード
        Route::get('dashboard', fn() => view('editor.dashboard'))
            ->name('editor.dashboard');
    });
});
