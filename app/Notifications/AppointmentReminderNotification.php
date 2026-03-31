<?php

namespace App\Notifications;

use App\Channels\WhatsAppChannel;
use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AppointmentReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Appointment $appointment) {}

    public function via(object $notifiable): array
{
    return ['whatsapp', 'database'];
}

public function toArray(object $notifiable): array
{
    return [
        'message' => "⏰ تذكير: موعدك بعد ساعتين مع د. {$this->appointment->doctor->user->name}",
        'appointment_id' => $this->appointment->id,
        'date' => $this->appointment->appointment_date,
        'time' => $this->appointment->start_time . ' - ' . $this->appointment->end_time,
    ];
}

    public function toWhatsApp(object $notifiable): string
    {
        return "⏰ *تذكير: موعدك بعد ساعتين!*\n\n"
            . "مرحباً {$notifiable->name}،\n\n"
            . "📅 التاريخ: {$this->appointment->appointment_date}\n"
            . "⏰ الوقت: {$this->appointment->start_time} - {$this->appointment->end_time}\n"
            . "👨‍⚕️ الطبيب: د. {$this->appointment->doctor->user->name}\n\n"
            . "لا تنسى الحضور في الوقت 😊";
    }
}