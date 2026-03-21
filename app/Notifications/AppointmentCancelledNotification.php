<?php

namespace App\Notifications;

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
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject('Appointment Cancelled')
            ->line("Your appointment has been cancelled.")
            ->line("Original Date: {$this->appointment->appointment_date}")
            ->line("Original Time: {$this->appointment->start_time} - {$this->appointment->end_time}")
            ->line("Doctor: {$this->appointment->doctor->user->name}");

        if ($this->appointment->cancellation_reason) {
            $message->line("Reason: {$this->appointment->cancellation_reason}");
        }

        return $message
            ->line("Please book a new appointment if needed.")
            ->action('Book New Appointment', url('/appointments/create'));
    }
}
