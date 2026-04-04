<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Specialization;

class SpecializationSeeder extends Seeder
{
    public function run(): void
    {
        $specializations = [
            ['name' => 'Cardiology', 'description' => 'Heart and cardiovascular system', 'is_active' => true],
            ['name' => 'Dermatology', 'description' => 'Skin, hair, and nails', 'is_active' => true],
            ['name' => 'Neurology', 'description' => 'Brain and nervous system', 'is_active' => true],
            ['name' => 'Orthopedics', 'description' => 'Bones, joints, and muscles', 'is_active' => true],
            ['name' => 'Pediatrics', 'description' => 'Children\'s health', 'is_active' => true],
            ['name' => 'Gynecology', 'description' => 'Women\'s health', 'is_active' => true],
            ['name' => 'Ophthalmology', 'description' => 'Eye care', 'is_active' => true],
            ['name' => 'ENT', 'description' => 'Ear, nose, and throat', 'is_active' => true],
            ['name' => 'Psychiatry', 'description' => 'Mental health', 'is_active' => true],
            ['name' => 'General Medicine', 'description' => 'General healthcare', 'is_active' => true],
        ];

        foreach ($specializations as $spec) {
            Specialization::firstOrCreate($spec);
        }
    }
}
