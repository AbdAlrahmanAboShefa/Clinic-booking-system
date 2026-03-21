<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Notifications\AppointmentReminderNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendAppointmentReminders extends Command
{
    protected $signature = 'app:send-appointment-reminders';

    protected $description = 'Send appointment reminders 2 hours before';

    public function handle(): void
    {
        $now = Carbon::now();

        $appointments = Appointment::with(['patient.user', 'doctor.user'])
            ->where('status', 'confirmed')
            ->whereNull('reminder_sent_at')
            ->whereDate('appointment_date', $now->toDateString())
            ->lockforUpdate()
            ->get();

        $remindedCount = 0;

        foreach ($appointments as $appointment) {
            $appointmentTime = Carbon::parse($appointment->appointment_date->toDateString() . ' ' . $appointment->start_time);
            $timeDiff = $now->diffInMinutes($appointmentTime, false);

            if ($timeDiff > 0 && $timeDiff <= 120 && !$appointment->reminder_sent_at) {
                $appointment->patient->user->notify(new AppointmentReminderNotification($appointment));
                $appointment->update(['reminder_sent_at' => now()]);
                $remindedCount++;
                $this->info("Reminder sent for appointment #{$appointment->id}");
            }
        }

        $this->info("Sent {$remindedCount} appointment reminders.");
    }   
}
