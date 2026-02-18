<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Earning extends Model {
    use HasFactory;

    protected $fillable = ['advertisement_id', 'title', 'amount', 'date'];

    public function advertisement() {
        return $this->belongsTo(Advertisement::class);
    }
}
