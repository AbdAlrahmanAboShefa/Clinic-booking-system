<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'staff']);
    }

    public function view(User $user, Appointment $appointment): bool
    {
        if ($user->hasAnyRole(['admin', 'staff'])) {
            return true;
        }

        if ($user->hasRole('doctor')) {
            return $appointment->doctor_id === $user->doctor->id;
        }

        if ($user->hasRole('patient')) {
            return $appointment->patient_id === $user->patient->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'staff', 'patient']);
    }

    public function update(User $user, Appointment $appointment): bool
    {
        if ($user->hasAnyRole(['admin', 'staff'])) {
            return true;
        }

        if ($user->hasRole('doctor')) {
            return $appointment->doctor_id === $user->doctor->id;
        }

        return false;
    }

    public function delete(User $user, Appointment $appointment): bool
    {
        return $user->hasAnyRole(['admin', 'staff']);
    }

    public function cancel(User $user, Appointment $appointment): bool
    {
        if ($user->hasAnyRole(['admin', 'staff'])) {
            return true;
        }

        if ($user->hasRole('doctor')) {
            return $appointment->doctor_id === $user->doctor->id;
        }

        if ($user->hasRole('patient')) {
            return $appointment->patient_id === $user->patient->id;
        }

        return false;
    }

    public function confirm(User $user, Appointment $appointment): bool
    {
        if ($user->hasAnyRole(['admin', 'staff'])) {
            return true;
        }

        if ($user->hasRole('doctor')) {
            return $appointment->doctor_id === $user->doctor->id && $appointment->status === 'pending';
        }

        return false;
    }

    public function reject(User $user, Appointment $appointment): bool
    {
        if ($user->hasAnyRole(['admin', 'staff'])) {
            return true;
        }

        if ($user->hasRole('doctor')) {
            return $appointment->doctor_id === $user->doctor->id && $appointment->status === 'pending';
        }

        return false;
    }
}
