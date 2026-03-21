<?php

namespace App\Policies;

use App\Models\DoctorSchedule;
use App\Models\User;

class DoctorSchedulePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'staff', 'doctor']);
    }

    public function view(User $user, DoctorSchedule $schedule): bool
    {
        if ($user->hasAnyRole(['admin', 'staff'])) {
            return true;
        }

        if ($user->hasRole('doctor')) {
            return $schedule->doctor_id === $user->doctor->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'staff', 'doctor']);
    }

    public function update(User $user, DoctorSchedule $schedule): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        if ($user->hasRole('doctor')) {
            return $schedule->doctor_id === $user->doctor->id;
        }

        return false;
    }

    public function delete(User $user, DoctorSchedule $schedule): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        if ($user->hasRole('doctor')) {
            return $schedule->doctor_id === $user->doctor->id;
        }

        return false;
    }
}
