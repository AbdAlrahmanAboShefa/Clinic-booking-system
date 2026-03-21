<?php

namespace App\Policies;

use App\Models\Patient;
use App\Models\User;

class PatientPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'staff', 'doctor']);
    }

    public function view(User $user, Patient $patient): bool
    {
        if ($user->hasAnyRole(['admin', 'staff', 'doctor'])) {
            return true;
        }

        return $user->patient->id === $patient->id;
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'staff']);
    }

    public function update(User $user, Patient $patient): bool
    {
        if ($user->hasAnyRole(['admin', 'staff'])) {
            return true;
        }

        return $user->patient->id === $patient->id;
    }

    public function delete(User $user, Patient $patient): bool
    {
        return $user->hasRole('admin');
    }
}
