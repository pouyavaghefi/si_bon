<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'password' => ['required'],
        ]);

        $this->ensureIsNotRateLimited($request);

        if ($request->name !== 'root') {

            RateLimiter::hit($this->throttleKey($request), 300);

            return back()->withErrors([
                'name' => 'Invalid credentials.',
            ])->withInput();
        }

        $credentials = [
            'name' => $request->name,
            'password' => $request->password,
            'is_admin' => 1,
            'is_active' => 1,
        ];

        if (Auth::attempt($credentials)) {

            RateLimiter::clear($this->throttleKey($request));

            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        RateLimiter::hit($this->throttleKey($request), 300);

        return back()->withErrors([
            'name' => 'Invalid credentials.',
        ])->withInput();
    }

    protected function ensureIsNotRateLimited(Request $request): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($request), 3)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages([
            'name' => "Too many login attempts. Try again in {$seconds} seconds.",
        ]);
    }

    protected function throttleKey(Request $request): string
    {
        return Str::lower($request->input('name')).'|'.$request->ip();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
