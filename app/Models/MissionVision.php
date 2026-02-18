<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MissionVision extends Model {
    protected $guarded = [];

    protected $casts = [
        'mission_points' => 'array',
        'vision_points'  => 'array',
        'core_values'    => 'array',
    ];
}
