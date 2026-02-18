<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model {
    use HasFactory;
    protected $fillable = [
        'title', 'slug', 'description', 'image', 'event_date', 'start_date', 'end_date', 'location', 'is_active',
    ];
}
