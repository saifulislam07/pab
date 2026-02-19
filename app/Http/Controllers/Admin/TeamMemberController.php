<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller {
    public function index(Request $request) {
        $search = $request->query('search');
        $members = TeamMember::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('role', 'like', "%{$search}%");
        })
            ->orderBy('order')
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('admin.team.index', compact('members'));
    }

    public function create() {
        return view('admin.team.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'role'      => 'required|string|max:255',
            'image'     => 'nullable|image|max:2048',
            'facebook'  => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin'  => 'nullable|url',
            'website'   => 'nullable|url',
            'order'     => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('team', 'public');
        }

        TeamMember::create($data);

        return redirect()->route('admin.team.index')->with('success', 'Team member added successfully.');
    }

    public function edit(TeamMember $team) {
        return view('admin.team.edit', compact('team'));
    }

    public function update(Request $request, TeamMember $team) {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'role'      => 'required|string|max:255',
            'image'     => 'nullable|image|max:2048',
            'facebook'  => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin'  => 'nullable|url',
            'website'   => 'nullable|url',
            'order'     => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($team->image) {
                Storage::disk('public')->delete($team->image);
            }
            $data['image'] = $request->file('image')->store('team', 'public');
        }

        $team->update($data);

        return redirect()->route('admin.team.index')->with('success', 'Team member updated successfully.');
    }

    public function destroy(TeamMember $team) {
        if ($team->image) {
            Storage::disk('public')->delete($team->image);
        }
        $team->delete();

        return redirect()->route('admin.team.index')->with('success', 'Team member deleted successfully.');
    }
}
