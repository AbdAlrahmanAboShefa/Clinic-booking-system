<?php

namespace App\Policies;

use App\Models\Doctor;
use App\Models\User;

class DoctorPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'staff']);
    }

    public function view(User $user, Doctor $doctor): bool
    {
        return $user->hasAnyRole(['admin', 'staff', 'doctor', 'patient']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function update(User $user, Doctor $doctor): bool
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, Doctor $doctor): bool
    {
        return $user->hasRole('admin');
    }

    public function manageSchedule(User $user, Doctor $doctor): bool
    {
        return $user->hasRole('admin') || ($user->hasRole('doctor') && $user->doctor->id === $doctor->id);
    }
}
