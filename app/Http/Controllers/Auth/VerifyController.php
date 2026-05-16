<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\View;
use App\Models\ActiveCode;
use App\Models\Member;

class VerifyController extends AuthController
{
    public function __construct()
    {
        View::composer('auth.verify', function ($view) {
            $mobile = session('auth_mobile');

            $resendAvailableAt = null;

            if ($mobile) {
                $lastCode = ActiveCode::where('mobile', $mobile)
                    ->whereNull('used_at')
                    ->latest()
                    ->first();

                if ($lastCode) {
                    $resendAvailableAt = $lastCode->created_at
                        ->copy()
                        ->addMinutes(5)
                        ->timestamp;
                }
            }

            $view->with('resendAvailableAt', $resendAvailableAt);
        });
    }

    public function showVerify()
    {
        $mobile = session('auth_mobile');

        $resendAvailableAt = null;

        if ($mobile) {
            $lastCode = ActiveCode::where('mobile', $mobile)
                ->whereNull('used_at')
                ->latest()
                ->first();

            if ($lastCode) {
                $resendAvailableAt = $lastCode->created_at->copy()->addMinutes(5)->timestamp;
            }
        }

        return view('auth.verify', compact('resendAvailableAt'));
    }

    public function doVerify(Request $request)
    {
        $request->validate([
            'code' => ['required', 'digits:5'],
        ]);

        $mobile = session('auth_mobile');

        if (!$mobile) {
            return redirect()
                ->route('auth.register')
                ->withErrors([
                    'mobile' => 'جلسه منقضی شده است. لطفاً دوباره ثبت نام کنید.',
                ]);
        }

        $activeCode = ActiveCode::where('mobile', $mobile)
            ->where('code', $request->code)
            ->whereNull('used_at')
            ->latest()
            ->first();

        if (!$activeCode) {
            return back()->withErrors([
                'code' => 'کد تایید وارد شده صحیح نمی‌باشد.',
            ]);
        }

        if (
            $activeCode->expires_at &&
            Carbon::now()->greaterThan($activeCode->expires_at)
        ) {
            return back()->withErrors([
                'code' => 'کد تایید منقضی شده است.',
            ]);
        }

        $activeCode->update([
            'used_at' => Carbon::now(),
        ]);

        $user = User::firstOrCreate(
            [
                'mobile' => $mobile,
            ],
            [
                'mobile' => $mobile,
                'name' => 'کاربر',
                'mobile_verified_at' => Carbon::now(),
            ]
        );

        if (!$user->mobile_verified_at) {
            $user->update([
                'mobile_verified_at' => Carbon::now(),
            ]);
        }

        Member::firstOrCreate([
            'user_id' => $user->id,
        ]);

        Auth::login($user, true);

        session()->forget('auth_mobile');

        Alert::success('Success', 'ورود شما با موفقیت انجام شد.');

        return redirect('/');
    }

    public function resendCode(Request $request)
    {
        $mobile = session('auth_mobile');

        if (!$mobile) {
            return redirect()
                ->route('auth.register')
                ->withErrors([
                    'mobile' => 'شماره موبایل یافت نشد. لطفاً دوباره شماره خود را وارد کنید.',
                ]);
        }

        $lastCode = ActiveCode::where('mobile', $mobile)
            ->whereNull('used_at')
            ->latest()
            ->first();

        if ($lastCode && $lastCode->created_at->gt(Carbon::now()->subMinutes(5))) {
            return back()->withErrors([
                'code' => 'برای ارسال مجدد کد باید ۵ دقیقه صبر کنید.',
            ]);
        }

        $code = rand(11111, 99999);

        ActiveCode::create([
            'mobile' => $mobile,
            'code' => $code,
            'expires_at' => Carbon::now()->addMinutes(5),
        ]);

        return back()->with('success', 'کد تایید جدید برای شما ارسال شد.');
    }
}
