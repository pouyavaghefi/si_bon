<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Member;
use App\Models\ActiveCode;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class LoginController extends AuthController
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            'mobile' => ['required', 'regex:/^09[0-9]{9}$/']
        ]);

        $mobile = $request->mobile;

        $user = User::where('mobile', $mobile)->first();

        $code = rand(100000, 999999);

        ActiveCode::create([
            'mobile'     => $mobile,
            'code'       => $code,
            'expires_at' => now()->addMinutes(2),
        ]);

        // send sms here

        if (!$user) {

            return redirect()
                ->route('auth.register')
                ->with([
                    'mobile' => $mobile,
                    'code'   => $code
                ]);
        }

        return redirect()
            ->route('auth.verify')
            ->with([
                'mobile' => $mobile,
                'code'   => $code
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
