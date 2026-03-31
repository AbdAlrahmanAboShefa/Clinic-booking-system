<?php

namespace App\Notifications;

use App\Channels\WhatsAppChannel;
use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AppointmentConfirmedForPatient extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Appointment $appointment) {}

    public function via(object $notifiable): array
    {
       return ['whatsapp','database'];
    }

  public function toArray(object $notifiable): array
{
    return [
        'message' => 'تم تأكيد موعدك',
        'appointment_id' => $this->appointment->id,
        'date' => $this->appointment->appointment_date,
        'time' => $this->appointment->start_time . ' - ' . $this->appointment->end_time,
        'doctor' => $this->appointment->doctor->user->name,
    ];
}

    public function toWhatsApp(object $notifiable): string
    {
        return "✅ *تم تأكيد موعدك*\n\n"
            . "مرحباً {$notifiable->name} 👋\n\n"
            . "📅 التاريخ: {$this->appointment->appointment_date}\n"
            . "⏰ الوقت: {$this->appointment->start_time} - {$this->appointment->end_time}\n"
            . "👨‍⚕️ الطبيب: د. {$this->appointment->doctor->user->name}\n\n"
            . "نتمنى لك الشفاء العاجل 🌿";
    }
}