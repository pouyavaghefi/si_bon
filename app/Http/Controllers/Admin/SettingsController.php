<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.user.settings');
    }

    public function updateBasic(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'password_confirm' => ['required'],
        ]);

        $admin = Auth::user();

        if (! Hash::check($request->password_confirm, $admin->password)) {
            return back()->withErrors([
                'password_confirm' => 'رمز عبور وارد شده صحیح نیست.',
            ])->withInput();
        }

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
        ]);

        return back()->with('success', 'اطلاعات حساب با موفقیت بروزرسانی شد.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $admin = Auth::user();

        if (! Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors([
                'current_password' => 'رمز عبور فعلی صحیح نیست.',
            ]);
        }

        $admin->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'رمز عبور با موفقیت تغییر یافت.');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'password_confirm_avatar' => ['required'],
        ]);

        $admin = Auth::user();

        if (! Hash::check($request->password_confirm_avatar, $admin->password)) {
            return back()->withErrors([
                'password_confirm_avatar' => 'رمز عبور وارد شده صحیح نیست.',
            ]);
        }

        $avatar = $request->file('avatar');

        $filename = time() . '_' . $avatar->getClientOriginalName();

        $avatar->move(public_path('uploads/admin/avatar'), $filename);

        $admin->update([
            'avatar' => 'uploads/admin/avatar/' . $filename,
        ]);

        return back()->with('success', 'تصویر پروفایل بروزرسانی شد.');
    }
}
