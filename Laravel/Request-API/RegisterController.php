<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Models\AdminUser;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    // use RegistersUsers;

    // adminRegisterFormはblade.php を表示。ログインの時はweb.phpに直接記述したが、今回はこちらに書いてみる。
    public function adminRegisterForm(Request $request)
    {
        return view('adminRegister');
    }

    // adminValidatorはValidatorの作成。
    protected function adminValidator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:App\Models\AdminUser'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'admin_level' => ['required', 'numeric'],
        ]);
    }

    // adminRegisterDatabaseはデータベースに挿入する。
    protected function adminRegisterDatabase(array $data)
    {
        return AdminUser::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'admin_level' => $data['admin_level'],
        ]);
    }

    // adminRegisterがリクエストを受け付ける場所で、上記２つの関数を使ってデータを登録作業を行なっている。
    public function adminRegister(Request $request)
    {
        $this->adminValidator($request->all())->validate();

        $user = $this->adminRegisterDatabase($request->all());

        if ($user) {
            return view('adminRegister', ['registered' => true, 'registered_email' => $user->email]);
        }
    }
}
