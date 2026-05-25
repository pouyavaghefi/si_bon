<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Member;
use App\Models\ActiveCode;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Session;

class   LoginController extends AuthController
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'کاربری با این ایمیل یافت نشد.'
            ]);
        }

        if ($user->email_verified_at) {

            Auth::login($user, true);

            $request->session()->regenerate();

            return redirect()
                ->route('front.user.profile');
        }

        return redirect()
            ->route('front.auth.login')
            ->withErrors([
                'email' => 'ایمیل کاربر تایید نشده است.'
            ]);
    }

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        Alert::success('Success', 'با موفقیت از حساب کاربری خارج شدید.');

        return redirect()->route('front.landing');
    }
}
