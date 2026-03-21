<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            SpecializationSeeder::class,
        ]);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@clinic.com',
            'password' => Hash::make('password'),
            'phone' => '1234567890',
        ]);
        $admin->assignRole('admin');

        $doctor = User::create([
            'name' => 'Dr. Smith',
            'email' => 'doctor@clinic.com',
            'password' => Hash::make('password'),
            'phone' => '1234567891',
        ]);
        $doctor->assignRole('doctor');

        $staff = User::create([
            'name' => 'Staff Member',
            'email' => 'staff@clinic.com',
            'password' => Hash::make('password'),
            'phone' => '1234567892',
        ]);
        $staff->assignRole('staff');

        $patient = User::create([
            'name' => 'Patient User',
            'email' => 'patient@clinic.com',
            'password' => Hash::make('password'),
            'phone' => '1234567893',
        ]);
        $patient->assignRole('patient');
    }
}
