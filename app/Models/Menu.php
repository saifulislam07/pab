<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model {
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'type',
        'title',
        'icon',
        'url',
        'position',
        'target',
        'is_active',
    ];

    public function parent() {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('position');
    }

    public function scopeActive($query) {
        return $query->where('is_active', true);
    }

    public function scopeTopLevel($query) {
        return $query->whereNull('parent_id')->orderBy('position');
    }

    public function scopeFrontend($query) {
        return $query->where('type', 'frontend');
    }

    public function scopeAdmin($query) {
        return $query->where('type', 'admin');
    }
}
