<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model {
    protected $fillable = ['name', 'role', 'image', 'bio', 'facebook', 'twitter', 'linkedin', 'status'];

    //
}
