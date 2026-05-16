<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function showProfile()
    {
        return view('frontend.user.profile');
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name'       => ['nullable', 'string', 'max:255'],
            'email'      => ['nullable', 'email', 'max:255'],
            'code_meli'  => ['nullable', 'string', 'max:20'],
            'base_phone' => ['nullable', 'string', 'max:20'],
            'job'        => ['nullable', 'string', 'max:255'],
            'refund'     => ['nullable', 'string', 'max:255'],
            'day'        => ['nullable', 'integer', 'between:1,31'],
            'month'      => ['nullable', 'integer', 'between:1,12'],
            'year'       => ['nullable', 'integer', 'between:1300,1500'],
            'messaging'  => ['nullable'],
            'avatar'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user = Auth::user();

        $user->update([
            'name'  => $validated['name'] ?? null,
            'email' => $validated['email'] ?? null,
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar && file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }

            $destination = public_path('uploads/users/avatar');

            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file = $request->file('avatar');
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

            $file->move($destination, $fileName);

            $user->update([
                'avatar' => 'uploads/users/avatar/' . $fileName,
            ]);
        }

        $birthDate = null;

        if (
            !empty($validated['year']) &&
            !empty($validated['month']) &&
            !empty($validated['day'])
        ) {
            $birthDate = sprintf(
                '%04d-%02d-%02d',
                $validated['year'],
                $validated['month'],
                $validated['day']
            );
        }

        $user->member()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'first_name'    => $validated['name'] ?? null,
                'national_code' => $validated['code_meli'] ?? null,
                'phone'         => $validated['base_phone'] ?? null,
                'job'           => $validated['job'] ?? null,
                'refund'        => $validated['refund'] ?? null,
                'birth_date'    => $birthDate,
                'newsletter'    => $request->boolean('messaging'),
            ]
        );

        return back()->with('success', 'اطلاعات پروفایل با موفقیت بروزرسانی شد.');
    }
}
