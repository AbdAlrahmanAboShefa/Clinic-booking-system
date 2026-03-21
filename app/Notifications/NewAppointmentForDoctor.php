<?php

namespace App\Notifications;

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
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Appointment Booked')
            ->line("You have a new appointment on {$this->appointment->appointment_date}")
            ->line("Time: {$this->appointment->start_time} - {$this->appointment->end_time}")
            ->line("Patient: {$this->appointment->patient->full_name}")
            ->action('View Appointment', url('/appointments/' . $this->appointment->id));
    }
}