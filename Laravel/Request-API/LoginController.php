<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Providers\RouteServiceProvider;

class LoginController extends Controller
{

    // コントローラーのコンストラクタは、関数を呼び出す前に呼び出されるため、そこでミドルウェア1を指定する。

    // 今回は、guestミドルウェアを呼び出し、引数としてadminを渡す。
    // exceptは例外。これを指定した場合は、ミドルウェアを通過しない。
    // 後にログアウト画面を作成するため、先にそれを除外しておく。
    public function __construct()
    {
        $this->middleware('guest:admin')->except('adminLogout');
    }

 /**
 * 認証の試行を処理
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([ // 入力内容のチェック
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($credentials)) { // ログイン試行
            if ($request->user('admin')->admin_level > 0) { // 管理権限レベルが0でないか
                $request->session()->regenerate(); // セッション更新


                return redirect()->intended(RouteServiceProvider::ADMIN_HOME); // ダッシュボードへ
            } else {
                Auth::guard('admin')->logout(); // if文でログインしてしまっているので、ログアウトさせる

                $request->session()->regenerate(); // セッション更新

                return back()->withErrors([ // 権限レベルが0の場合
                    'error' => 'You do not have permission to log in.',
                ]);
            }
        }

        return back()->withErrors([ // ログインに失敗した場合
            'error' => 'The provided credentials do not match our records.',
        ]);
    }


    // ログアウト処理の追加
    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }


}
