<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SponsorController extends Controller {
    public function index(Request $request) {
        $search = $request->query('search');
        $sponsors = Sponsor::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%");
        })
            ->orderBy('order')
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('admin.sponsors.index', compact('sponsors'));
    }

    public function create() {
        return view('admin.sponsors.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'logo'      => 'required|image|max:2048',
            'link'      => 'nullable|url',
            'order'     => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('sponsors', 'public');
        }

        Sponsor::create($data);

        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor added successfully.');
    }

    public function edit(Sponsor $sponsor) {
        return view('admin.sponsors.edit', compact('sponsor'));
    }

    public function update(Request $request, Sponsor $sponsor) {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'logo'      => 'nullable|image|max:2048',
            'link'      => 'nullable|url',
            'order'     => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('logo')) {
            if ($sponsor->logo) {
                Storage::disk('public')->delete($sponsor->logo);
            }
            $data['logo'] = $request->file('logo')->store('sponsors', 'public');
        }

        $sponsor->update($data);

        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor updated successfully.');
    }

    public function destroy(Sponsor $sponsor) {
        if ($sponsor->logo) {
            Storage::disk('public')->delete($sponsor->logo);
        }
        $sponsor->delete();

        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor deleted successfully.');
    }
}
