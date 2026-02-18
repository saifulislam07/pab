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

    public function exportCsv(Request $request) {
        $status = $request->get('status', 'approved');
        $search = $request->query('search');

        $members = Member::where('status', $status)
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        $filename = "members_" . $status . "_" . date('Y-m-d') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0",
        ];

        $columns = ['Name', 'Mobile', 'Email', 'Role', 'Status', 'Joined At'];

        $callback = function () use ($members, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($members as $member) {
                fputcsv($file, [
                    $member->name,
                    $member->mobile ?? 'N/A',
                    $member->email ?? 'N/A',
                    $member->role,
                    ucfirst($member->status),
                    $member->created_at->format('Y-m-d'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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
