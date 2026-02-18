<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model {
    use HasFactory;
    protected $fillable = [
        'title', 'image', 'link', 'price', 'start_date', 'end_date', 'position', 'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'price'      => 'decimal:2',
        'is_active'  => 'boolean',
    ];

    /**
     * Scope to get only currently active advertisements.
     */
    public function scopeActive($query) {
        return $query->where('is_active', true)
            ->where('start_date', '<=', now()->toDateString())
            ->where('end_date', '>=', now()->toDateString());
    }
}
