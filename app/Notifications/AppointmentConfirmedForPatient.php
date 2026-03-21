<?php

namespace App\Notifications;

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
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Appointment Confirmed')
            ->line("Your appointment has been confirmed!")
            ->line("Date: {$this->appointment->appointment_date}")
            ->line("Time: {$this->appointment->start_time} - {$this->appointment->end_time}")
            ->line("Doctor: {$this->appointment->doctor->user->name}")
            ->action('View Appointment', url('/appointments/' . $this->appointment->id));
    }
}
