<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'dashboard.view',
            'patients.view', 'patients.create', 'patients.edit', 'patients.delete',
            'doctors.view', 'doctors.create', 'doctors.edit', 'doctors.delete',
            'appointments.view', 'appointments.create', 'appointments.edit', 'appointments.cancel',
            'schedules.manage',
            'reports.view',
            'settings.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $doctor = Role::firstOrCreate(['name' => 'doctor']);
        $doctor->givePermissionTo([
            'dashboard.view',
            'appointments.view', 'appointments.edit',
            'patients.view',
            'schedules.manage',
        ]);

        $staff = Role::firstOrCreate(['name' => 'staff']);
        $staff->givePermissionTo([
            'dashboard.view',
            'patients.view', 'patients.create',
            'appointments.view', 'appointments.create', 'appointments.edit', 'appointments.cancel',
        ]);

        $patient = Role::firstOrCreate(['name' => 'patient']);
        $patient->givePermissionTo([
            'dashboard.view',
            'appointments.view', 'appointments.create', 'appointments.cancel',
        ]);
    }
}
