<?php

namespace App\Channels;

use App\Services\WhatsAppService;
use Illuminate\Notifications\Notification;


class WhatsAppChannel
{
    public function __construct(private WhatsAppService $whatsapp) {}

    public function send(object $notifiable, Notification $notification): void
    {
        // لو مافي رقم، تجاهل بهدوء
        if (! $phone = $notifiable->routeNotificationFor('whatsapp')) {
            return;
        }

        $message = $notification->toWhatsApp($notifiable);

        $this->whatsapp->send($phone, $message);
    }
}