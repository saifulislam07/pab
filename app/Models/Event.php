<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {
    protected $fillable = [
        'title', 'slug', 'description', 'image', 'event_date', 'start_date', 'end_date', 'location', 'is_active',
    ];
}
