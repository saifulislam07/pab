<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SliderController extends Controller {
    public function index(Request $request) {
        $search = $request->query('search');
        $sliders = Slider::when($search, function ($query) use ($search) {
            $query->where('title', 'like', "%{$search}%");
        })
            ->orderBy('order')
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('admin.sliders.index', compact('sliders'));
    }

    public function create() {
        return view('admin.sliders.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'image'     => 'required|image|max:2048',
            'title'     => 'nullable|string|max:255',
            'subtitle'  => 'nullable|string|max:255',
            'order'     => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sliders', 'public');
        }

        Slider::create($data);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider created successfully.');
    }

    public function edit(Slider $slider) {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider) {
        $data = $request->validate([
            'image'     => 'nullable|image|max:2048',
            'title'     => 'nullable|string|max:255',
            'subtitle'  => 'nullable|string|max:255',
            'order'     => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($slider->image && ! Str::startsWith($slider->image, 'http')) {
                Storage::disk('public')->delete($slider->image);
            }
            $data['image'] = $request->file('image')->store('sliders', 'public');
        }

        $slider->update($data);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider updated successfully.');
    }

    public function destroy(Slider $slider) {
        if ($slider->image && ! Str::startsWith($slider->image, 'http')) {
            Storage::disk('public')->delete($slider->image);
        }
        $slider->delete();

        return redirect()->route('admin.sliders.index')->with('success', 'Slider deleted successfully.');
    }
}
