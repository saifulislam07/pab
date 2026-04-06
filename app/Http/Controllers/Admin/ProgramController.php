<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProgramRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProgramController extends Controller {
    public function index(Request $request) {
        $search = $request->query('search');
        $programs = Program::when($search, function ($query) use ($search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%");
        })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('admin.programs.index', compact('programs'));
    }

    public function create() {
        return view('admin.programs.create');
    }

    public function store(Request $request) {
        $request->validate([
            'title'                  => 'required',
            'description'            => 'required',
            'image'                  => 'nullable|image',
            'start_date'             => 'nullable|date',
            'end_date'               => 'nullable|date|after_or_equal:start_date',
            'location'               => 'nullable|string',
            'is_registration_active' => 'nullable|boolean',
            'registration_fields'    => 'nullable|array',
            'registration_fee'       => 'nullable|numeric',
        ]);

        $data = $request->all();
        $data['is_registration_active'] = $request->has('is_registration_active');
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('programs', 'public');
        }

        Program::create($data);

        return redirect()->route('admin.programs.index')->with('success', 'Program created successfully.');
    }

    public function edit(Program $program) {
        return view('admin.programs.edit', compact('program'));
    }

    public function update(Request $request, Program $program) {
        $request->validate([
            'title'                  => 'required',
            'description'            => 'required',
            'image'                  => 'nullable|image',
            'start_date'             => 'nullable|date',
            'end_date'               => 'nullable|date|after_or_equal:start_date',
            'location'               => 'nullable|string',
            'is_registration_active' => 'nullable|boolean',
            'registration_fields'    => 'nullable|array',
            'registration_fee'       => 'nullable|numeric',
        ]);

        $data = $request->all();
        $data['is_registration_active'] = $request->has('is_registration_active');
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('image')) {
            if ($program->image) {
                Storage::disk('public')->delete($program->image);
            }
            $data['image'] = $request->file('image')->store('programs', 'public');
        }

        $program->update($data);

        return redirect()->route('admin.programs.index')->with('success', 'Program updated successfully.');
    }

    public function destroy(Program $program) {
        if ($program->image) {
            Storage::disk('public')->delete($program->image);
        }
        $program->delete();

        return redirect()->route('admin.programs.index')->with('success', 'Program deleted successfully.');
    }

    public function registrations(Program $program) {
        $registrations = $program->registrations()->with('user')->latest()->paginate(20);
        return view('admin.programs.registrations', compact('program', 'registrations'));
    }
}
