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

        $settings = \App\Models\Setting::first();

        return view('admin.sponsors.index', compact('sponsors', 'settings'));
    }

    public function updateSettings(Request $request) {
        $data = $request->validate([
            'sponsor_title'    => 'nullable|string|max:255',
            'sponsor_subtitle' => 'nullable|string|max:255',
        ]);

        $setting = \App\Models\Setting::first();
        if (! $setting) {
            $setting = \App\Models\Setting::create($data);
        } else {
            $setting->update($data);
        }

        return redirect()->back()->with('success', 'Sponsor section settings updated successfully.');
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

    public function bulkDestroy(Request $request) {
        $ids = json_decode($request->ids);
        if (! $ids || ! is_array($ids)) {
            return redirect()->back()->with('error', 'No items selected.');
        }

        $sponsors = Sponsor::whereIn('id', $ids)->get();
        $deletedCount = 0;
        $skippedCount = 0;

        foreach ($sponsors as $sponsor) {
            // Check if sponsor is linked to any programs
            // The relationship is in Program model as belongsToMany(Sponsor)
            // So we check if any programs exist for this sponsor ID
            $existsInPrograms = \Illuminate\Support\Facades\DB::table('program_sponsor')
                ->where('sponsor_id', $sponsor->id)
                ->exists();

            if ($existsInPrograms) {
                $skippedCount++;
                continue;
            }

            if ($sponsor->logo) {
                Storage::disk('public')->delete($sponsor->logo);
            }
            $sponsor->delete();
            $deletedCount++;
        }

        $message = "{$deletedCount} sponsors deleted successfully.";
        if ($skippedCount > 0) {
            $message .= " {$skippedCount} sponsors skipped because they are associated with programs.";
        }

        return redirect()->route('admin.sponsors.index')->with($skippedCount > 0 ? 'warning' : 'success', $message);
    }
}
