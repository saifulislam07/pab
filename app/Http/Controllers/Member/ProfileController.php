<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class ProfileController extends Controller {
    public function edit() {
        $member = auth()->user()->member;
        if (! $member) {
            $member = Member::create([
                'user_id' => auth()->id(),
                'name'    => auth()->user()->name,
                'email'   => auth()->user()->email,
                'role'    => 'Standard Member',
                'status'  => 'pending',
            ]);
        }
        return view('member.profile.edit', compact('member'));
    }

    public function update(Request $request) {
        $member = auth()->user()->member;

        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|max:255',
            'mobile'           => 'required|string|max:20',
            'title'            => 'nullable|string|max:100',
            'profession'       => 'nullable|string|max:150',
            'bio'              => 'nullable|string',
            'division'         => 'nullable|string|max:50',
            'district'         => 'nullable|string|max:100',
            'upazila'          => 'nullable|string|max:100',
            'current_location' => 'nullable|string|max:255',
            'specialization'   => 'nullable|string|max:100',
            'experience_level' => 'nullable|string|in:Professional,Intermediate,Hobbyist',
            'camera_gear'      => 'nullable|string',
            'facebook'         => 'nullable|url',
            'instagram'        => 'nullable|url',
            'linkedin'         => 'nullable|url',
            'website'          => 'nullable|url',
            'image'            => 'nullable|image|max:2048',
            'permission'       => 'nullable|boolean',
        ]);

        $data['permission'] = $request->has('permission') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($member->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($member->image);
            }
            $data['image'] = $request->file('image')->store('members', 'public');
        }

        // Generate member_id if not yet assigned and division+district are provided
        if (empty($member->member_id) && ! empty($data['division']) && ! empty($data['district'])) {
            $data['member_id'] = Member::generateMemberId($data['division'], $data['district']);
        }

        $member->update($data);

        return redirect()->route('member.dashboard')->with('success', 'Profile completed successfully.');
    }
}
