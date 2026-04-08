<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller {
    public function index(Request $request) {
        $query = Advertisement::latest();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $advertisements = $query->paginate(10)->appends($request->query());
        return view('admin.advertisements.index', compact('advertisements'));
    }

    public function create() {
        return view('admin.advertisements.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'title'      => 'required|string|max:255',
            'image'      => 'required|image|max:2048',
            'link'       => 'nullable|url|max:255',
            'price'      => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'position'   => 'required|in:sidebar,banner',
            'is_active'  => 'required|boolean',
        ]);

        $data['image'] = $request->file('image')->store('advertisements', 'public');

        $advertisement = Advertisement::create($data);

        // Record Earning
        \App\Models\Earning::create([
            'advertisement_id' => $advertisement->id,
            'title'            => 'Ad Revenue: ' . $advertisement->title,
            'amount'           => $advertisement->price,
            'date'             => $advertisement->start_date,
        ]);

        return redirect()->route('admin.advertisements.index')->with('success', 'Advertisement created successfully and earning recorded.');
    }

    public function edit(Advertisement $advertisement) {
        return view('admin.advertisements.edit', compact('advertisement'));
    }

    public function update(Request $request, Advertisement $advertisement) {
        $data = $request->validate([
            'title'      => 'required|string|max:255',
            'image'      => 'nullable|image|max:2048',
            'link'       => 'nullable|url|max:255',
            'price'      => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'position'   => 'required|in:sidebar,banner',
            'is_active'  => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($advertisement->image);
            $data['image'] = $request->file('image')->store('advertisements', 'public');
        }

        $advertisement->update($data);

        // Update Earning if it exists
        $earning = \App\Models\Earning::where('advertisement_id', $advertisement->id)->first();
        if ($earning) {
            $earning->update([
                'title'  => 'Ad Revenue: ' . $advertisement->title,
                'amount' => $advertisement->price,
                'date'   => $advertisement->start_date,
            ]);
        }

        return redirect()->route('admin.advertisements.index')->with('success', 'Advertisement updated successfully.');
    }

    public function destroy(Advertisement $advertisement) {
        // Check for linked earnings
        if (\App\Models\Earning::where('advertisement_id', $advertisement->id)->exists()) {
            return redirect()->back()->with('error', 'Cannot delete advertisement with associated earning records.');
        }

        if ($advertisement->image) {
            Storage::disk('public')->delete($advertisement->image);
        }
        $advertisement->delete();

        return redirect()->route('admin.advertisements.index')->with('success', 'Advertisement deleted successfully.');
    }

    public function bulkDestroy(Request $request) {
        $ids = json_decode($request->ids);
        if (! $ids || ! is_array($ids)) {
            return redirect()->back()->with('error', 'No items selected.');
        }

        $ads = Advertisement::whereIn('id', $ids)->get();
        $deletedCount = 0;
        $skippedCount = 0;

        foreach ($ads as $ad) {
            if (\App\Models\Earning::where('advertisement_id', $ad->id)->exists()) {
                $skippedCount++;
                continue;
            }

            if ($ad->image) {
                Storage::disk('public')->delete($ad->image);
            }
            $ad->delete();
            $deletedCount++;
        }

        $message = "{$deletedCount} advertisements deleted successfully.";
        if ($skippedCount > 0) {
            $message .= " {$skippedCount} advertisements skipped because they have associated earnings.";
        }

        return redirect()->route('admin.advertisements.index')->with($skippedCount > 0 ? 'warning' : 'success', $message);
    }
}
