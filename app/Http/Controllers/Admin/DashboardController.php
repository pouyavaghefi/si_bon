<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Notifications\AdminWelcomeNotification;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (
            $user &&
            $user->is_admin &&
            ! $user->notifications()
                ->where('type', AdminWelcomeNotification::class)
                ->exists()
        ) {
            $user->notify(new AdminWelcomeNotification());
        }

        return view('admin.index');
    }

    public function readAllNotifications()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return back();
    }
}
