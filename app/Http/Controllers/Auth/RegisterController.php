<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
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
            'mobile' => ['required', 'digits:9'],
        ]);

        $mobile = '09' . $request->mobile;

        $userExists = User::where('mobile', $mobile)->exists();

        if ($userExists) {
            return back()->withErrors([
                'mobile' => 'این شماره موبایل قبلاً ثبت شده است.',
            ])->withInput();
        }

        $code = rand(11111, 99999);

        ActiveCode::updateOrCreate(
            [
                'mobile' => $mobile,
            ],
            [
                'code' => $code,
                'used_at' => null,
                'expires_at' => now()->addMinutes(2),
            ]
        );

        session([
            'auth_mobile' => $mobile,
        ]);

        // send sms here

        return redirect()
            ->route('auth.verify')
            ->with('success', 'کد تایید برای شما ارسال شد.');
    }
}
