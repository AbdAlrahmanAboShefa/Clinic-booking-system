<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'duration_minutes',
        'price',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function appointments()
    {
        return $this->belongsToMany(Appointment::class, 'appointment_services')
            ->withPivot('price_at_booking')
            ->withTimestamps();
    }
}
