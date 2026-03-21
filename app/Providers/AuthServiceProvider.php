<?php

namespace App\Providers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Patient;
use App\Policies\AppointmentPolicy;
use App\Policies\DoctorPolicy;
use App\Policies\DoctorSchedulePolicy;
use App\Policies\PatientPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Appointment::class => AppointmentPolicy::class,
        Doctor::class => DoctorPolicy::class,
        Patient::class => PatientPolicy::class,
        DoctorSchedule::class => DoctorSchedulePolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
