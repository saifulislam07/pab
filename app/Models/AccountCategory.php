<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountCategory extends Model
{
    protected $fillable = ['name', 'type', 'icon', 'is_active'];

    public function transactions() {
        return $this->hasMany(Transaction::class, 'account_category_id');
    }

    public function scopeActive($query) {
        return $query->where('is_active', true);
    }

    public function scopeIncome($query) {
        return $query->where('type', 'income');
    }

    public function scopeExpense($query) {
        return $query->where('type', 'expense');
    }
}
