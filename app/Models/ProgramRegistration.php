<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProgramRegistration extends Model {
    use HasFactory;

    protected $fillable = [
        'program_id', 'user_id', 'registration_data', 'status', 'payment_status', 'transaction_id',
    ];

    protected $casts = [
        'registration_data' => 'array',
    ];

    public function program() {
        return $this->belongsTo(Program::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getFormattedIdAttribute() {
        return 'PAB' . $this->created_at->year . '-' . str_pad($this->id, 3, '0', STR_PAD_LEFT);
    }

    public function getField($name) {
        if (!$this->registration_data) return null;
        return self::extractField($this->registration_data, $name);
    }

    public static function extractField(array $data, $name) {
        $searchKey = str_replace([' ', '-', '.'], '_', strtolower($name));
        $aliases = [
            'trans_id' => ['transaction', 'trx', 'ট্রানজ্যাকশন', 'ট্রানজেকশন'],
            'mobile'   => ['phone', 'contact', 'মোবাইল', 'ফোন', 'number'],
            'name'     => ['full_name', 'username', 'নাম', 'applicant'],
            'email'    => ['mail', 'e-mail', 'ইমেইল', 'ই-মেইল'],
            'amount'   => ['fee', 'payment', 'টাকা', 'ফি', 'আমাউন্ট'],
            'note'     => ['comment', 'remark', 'payment_method', 'মোবাইল_ব্যাংকিং_মাধম', 'note'],
            'form_no'  => ['form_number', 'form', 'number', 'সিরিয়াল', 'রেফারেন্স', 'নং']
        ];

        $searchTerms = array_merge([$searchKey], $aliases[$searchKey] ?? []);
        
        foreach ($data as $key => $value) {
            $normalizedKey = str_replace([' ', '-', '.'], '_', strtolower($key));
            foreach ($searchTerms as $term) {
                if ($normalizedKey === $term || str_contains($normalizedKey, $term) || str_contains($term, $normalizedKey)) {
                    return $value;
                }
            }
        }
        
        return null;
    }
}
