<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminWelcomeNotification extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'خوش آمدید به پنل مدیریت',
            'message' => 'ورود شما با موفقیت انجام شد و همه بخش‌های مدیریتی آماده استفاده هستند.',
            'icon' => 'shield-check',
        ];
    }
}
