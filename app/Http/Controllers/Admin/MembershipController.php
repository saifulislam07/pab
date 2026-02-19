<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Earning;
use App\Models\Member;
use Illuminate\Http\Request;

class MembershipController extends Controller {
    public function index(Request $request) {
        $status = $request->get('status', 'pending');
        $members = Member::where('membership_status', $status)
            ->latest()
            ->paginate(15);

        return view('admin.membership.index', compact('members', 'status'));
    }

    public function approve(Member $member) {
        $startedAt = now();
        $expiresAt = $member->membership_type === 'lifetime'
        ? now()->addYears(10)
        : now()->addYear();

        $member->update([
            'membership_status'     => 'active',
            'membership_started_at' => $startedAt,
            'membership_expires_at' => $expiresAt,
        ]);

        // Record the payment in Earnings
        Earning::create([
            'title'  => 'Membership Fee: ' . $member->name . ' (' . ucfirst($member->membership_type) . ')',
            'amount' => $member->membership_amount ?? 0,
            'date'   => now(),
        ]);

        return redirect()->back()->with('success', 'Membership approved. Validity set until ' . $expiresAt->format('M d, Y'));
    }

    public function reject(Member $member) {
        // Clear payment details and set status to none
        if ($member->payment_proof) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($member->payment_proof);
        }

        $member->update([
            'membership_status' => 'none',
            'payment_method'    => null,
            'transaction_id'    => null,
            'payment_proof'     => null,
        ]);

        return redirect()->back()->with('info', 'Membership application rejected and data cleared.');
    }
}
