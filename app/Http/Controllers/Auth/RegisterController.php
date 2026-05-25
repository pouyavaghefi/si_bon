<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use App\Models\ActiveCode;

class RegisterController extends AuthController
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function doRegister(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email:rfc,dns', 'unique:users,email'],
        ], [
            'email.required' => 'وارد کردن ایمیل الزامی است.',
            'email.email' => 'فرمت ایمیل صحیح نیست.',
            'email.unique' => 'این ایمیل قبلاً ثبت شده است.',
        ]);

        $user = User::create([
            'email' => $request->email,
            'email_verified_at' => now(),
        ]);

        Auth::login($user, true);

        $request->session()->regenerate();

        return redirect()
            ->route('front.user.profile');
    }
}
