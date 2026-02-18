<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller {
    public function index(Request $request) {
        $search = $request->query('search');
        $items = GalleryItem::with('category')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('admin.gallery.index', compact('items'));
    }

    public function create() {
        $categories = \App\Models\Category::all();
        return view('admin.gallery.create', compact('categories'));
    }

    public function batchCreate() {
        $categories = \App\Models\Category::all();
        return view('admin.gallery.batch', compact('categories'));
    }

    public function batchStore(Request $request) {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'images'      => 'required|array',
            'images.*'    => 'image|max:5120', // Max 5MB per image
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('gallery', 'public');
                GalleryItem::create([
                    'category_id' => $request->category_id,
                    'image'       => $path,
                    'title'       => null, // Batch uploads usually don't have individual titles initially
                ]);
            }
        }

        return redirect()->route('admin.gallery.index')->with('success', 'Batch images uploaded successfully.');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'title'       => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'required|image',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('gallery', 'public');
        }

        GalleryItem::create($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item added successfully.');
    }

    public function edit(GalleryItem $gallery) {
        $categories = \App\Models\Category::all();
        return view('admin.gallery.edit', compact('gallery', 'categories'));
    }

    public function update(Request $request, GalleryItem $gallery) {
        $data = $request->validate([
            'title'       => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            if ($gallery->image && ! str_starts_with($gallery->image, 'http')) {
                Storage::disk('public')->delete($gallery->image);
            }
            $data['image'] = $request->file('image')->store('gallery', 'public');
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item updated successfully.');
    }

    public function destroy(GalleryItem $gallery) {
        if ($gallery->image && ! str_starts_with($gallery->image, 'http')) {
            Storage::disk('public')->delete($gallery->image);
        }
        $gallery->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item deleted successfully.');
    }
}
