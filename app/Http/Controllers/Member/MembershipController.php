<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MembershipController extends Controller {
    public function index() {
        $member = auth()->user()->member;
        return view('member.membership.index', compact('member'));
    }

    public function apply() {
        $member = auth()->user()->member;

        // If already pending or active, redirect to index
        if ($member->membership_status === 'pending' || $member->membership_status === 'active') {
            return redirect()->route('member.membership.index');
        }

        return view('member.membership.apply', compact('member'));
    }

    public function store(Request $request) {
        $member = auth()->user()->member;

        $request->validate([
            'membership_type'   => 'required|in:yearly,lifetime',
            'membership_amount' => 'required|numeric|min:0',
            'payment_method'    => 'required|string|max:50',
            'transaction_id'    => 'required|string|max:100|unique:members,transaction_id,' . $member->id,
            'payment_proof'     => 'required|image|max:2048',
        ]);

        $data = [
            'membership_type'   => $request->membership_type,
            'membership_status' => 'pending',
            'membership_amount' => $request->membership_amount,
            'payment_method'    => $request->payment_method,
            'transaction_id'    => $request->transaction_id,
        ];

        if ($request->hasFile('payment_proof')) {
            $data['payment_proof'] = $request->file('payment_proof')->store('payments', 'public');
        }

        $member->update($data);

        return redirect()->route('member.membership.index')->with('success', 'Your membership application has been submitted and is pending admin approval.');
    }
}
