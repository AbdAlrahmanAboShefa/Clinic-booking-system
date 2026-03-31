<?php

namespace App\Notifications;

use App\Channels\WhatsAppChannel;
use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;

class AppointmentCancelledNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Appointment $appointment) {}

    public function via(object $notifiable): array
{
    return [ 'whatsapp', 'database'];
}

public function toArray(object $notifiable): array
{
    return [
        'message' => "❌ تم إلغاء موعدك مع د. {$this->appointment->doctor->user->name}",
        'appointment_id' => $this->appointment->id,
        'date' => $this->appointment->appointment_date,
        'time' => $this->appointment->start_time . ' - ' . $this->appointment->end_time,
        'reason' => $this->appointment->cancellation_reason,
    ];
}

    public function toWhatsApp(object $notifiable): string
    {
        $message = "❌ *تم إلغاء موعدك*\n\n"
            . "مرحباً {$notifiable->name}،\n\n"
            . "📅 التاريخ: {$this->appointment->appointment_date}\n"
            . "⏰ الوقت: {$this->appointment->start_time} - {$this->appointment->end_time}\n"
            . "👨‍⚕️ الطبيب: د. {$this->appointment->doctor->user->name}\n";

        if ($this->appointment->cancellation_reason) {
            $message .= "📝 السبب: {$this->appointment->cancellation_reason}\n";
        }

        return $message . "\nيمكنك حجز موعد جديد من التطبيق 📱";
    }
}