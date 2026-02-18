<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller {
    public function index(Request $request) {
        $status = $request->get('status', 'pending');
        $search = $request->query('search');
        $members = Member::where('status', $status)
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->appends(['status' => $status, 'search' => $search]);

        return view('admin.members.index', compact('members', 'status'));
    }

    public function updateStatus(Request $request, Member $member) {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending',
        ]);

        $member->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Member status updated to ' . $request->status);
    }

    public function destroy(Member $member) {
        $member->delete();
        return redirect()->back()->with('success', 'Member deleted successfully.');
    }
}
