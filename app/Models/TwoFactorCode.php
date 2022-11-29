<?php

namespace App\Models;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TwoFactorCode extends Notification
{
    use Queueable;

    public function via($notifiable) {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Your two factor code is '.$notifiable->two_factor_code)
            ->action('Verify Here', route('showTwoFactor'))
            ->line('The code will expire in 10 minutes')
            ->line('If you have not tried to login, ignore this message.');
    }

}
