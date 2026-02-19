<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model {
    use HasFactory;
    protected $fillable = [
        'user_id', 'member_id', 'name', 'title', 'profession', 'mobile', 'email', 'role', 'image', 'bio',
        'division', 'district', 'upazila', 'current_location',
        'specialization', 'experience_level', 'camera_gear',
        'facebook', 'instagram', 'linkedin', 'website', 'status', 'permission',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate a member ID based on division + district + year/month + sequence.
     * Format: DH-DH-2602-001 (Div2 + Dist2 + YYMM + sequential)
     */
    public static function generateMemberId(string $division, string $district): string {
        $divCode = strtoupper(substr($division, 0, 2));
        $distCode = strtoupper(substr($district, 0, 2));
        $yearMonth = date('ym'); // e.g. "2602" for Feb 2026

        $prefix = "{$divCode}{$distCode}{$yearMonth}";

        // Find the last member_id with this prefix and increment
        $lastMember = self::where('member_id', 'like', $prefix . '%')
            ->orderBy('member_id', 'desc')
            ->first();

        if ($lastMember) {
            $lastSeq = (int) substr($lastMember->member_id, -3);
            $nextSeq = $lastSeq + 1;
        } else {
            $nextSeq = 1;
        }

        return $prefix . str_pad($nextSeq, 3, '0', STR_PAD_LEFT);
    }

    public function getCompletionPercentage(): int {
        $fields = [
            'name', 'mobile', 'email', 'title', 'profession', 'image', 'bio',
            'division', 'district', 'upazila', 'current_location',
            'specialization', 'experience_level', 'camera_gear',
        ];

        $totalFields = count($fields);
        $completedFields = 0;

        foreach ($fields as $field) {
            if (! empty($this->{$field})) {
                $completedFields++;
            }
        }

        return round(($completedFields / $totalFields) * 100);
    }
}
