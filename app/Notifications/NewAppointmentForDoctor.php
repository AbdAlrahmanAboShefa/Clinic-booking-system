<?php

namespace App\Notifications;

use App\Channels\WhatsAppChannel;
use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewAppointmentForDoctor extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Appointment $appointment) {}

    public function via(object $notifiable): array
{
    return [ 'whatsapp', 'database']; // أو أضفها لـ array موجود
}

public function toArray(object $notifiable): array
{
    return [
        'message' => "📅 حجز موعد جديد من {$this->appointment->patient->first_name}",
        'appointment_id' => $this->appointment->id,
        'date' => $this->appointment->appointment_date,
        'time' => $this->appointment->start_time . ' - ' . $this->appointment->end_time,
    ];
}
    public function toWhatsApp(object $notifiable): string
    {
        return "📋 *موعد جديد*\n\n"
            . "د. {$notifiable->name}،\n\n"
            . "لديك موعد جديد:\n"
            . "👤 المريض: {$this->appointment->patient->full_name}\n"
            . "📅 التاريخ: {$this->appointment->appointment_date}\n"
            . "⏰ الوقت: {$this->appointment->start_time} - {$this->appointment->end_time}";
    }
}