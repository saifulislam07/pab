<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model {
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'image', 'start_date', 'end_date', 'location', 'is_active', 'is_registration_active', 'registration_fields', 'registration_fee',
    ];

    protected $casts = [
        'registration_fields'    => 'array',
        'is_registration_active' => 'boolean',
        'is_active'              => 'boolean',
    ];

    public function registrations() {
        return $this->hasMany(ProgramRegistration::class);
    }
}
