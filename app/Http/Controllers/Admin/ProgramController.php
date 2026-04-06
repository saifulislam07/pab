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
        $sponsors = \App\Models\Sponsor::where('is_active', true)->get();
        return view('admin.programs.create', compact('sponsors'));
    }

    public function store(Request $request) {
        $request->validate([
            'title'                  => 'required',
            'description'            => 'required',
            'image'                  => 'nullable|image',
            'start_date'             => 'nullable|date',
            'end_date'               => 'nullable|date|after_or_equal:start_date',
            'registration_deadline'  => 'nullable|date',
            'location'               => 'nullable|string',
            'is_registration_active' => 'nullable|boolean',
            'registration_fields'    => 'nullable|array',
            'registration_fee'       => 'nullable|numeric',
            'sponsor_ids'            => 'nullable|array',
            'sponsor_ids.*'          => 'exists:sponsors,id',
        ]);

        $data = $request->except('sponsor_ids');
        $data['is_registration_active'] = $request->has('is_registration_active');
        $data['slug'] = Str::slug($request->title);

        if (isset($data['registration_fields']) && is_array($data['registration_fields'])) {
            foreach ($data['registration_fields'] as &$field) {
                $field['required'] = isset($field['required']) ? (bool) $field['required'] : false;
            }
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('programe'), $imageName);
            $data['image'] = $imageName;
        }

        $program = Program::create($data);

        if ($request->has('sponsor_ids')) {
            $program->sponsors()->sync($request->sponsor_ids);
        }

        return redirect()->route('admin.programs.index')->with('success', 'Program created successfully.');
    }

    public function edit(Program $program) {
        $sponsors = \App\Models\Sponsor::where('is_active', true)->get();
        return view('admin.programs.edit', compact('program', 'sponsors'));
    }

    public function update(Request $request, Program $program) {
        $request->validate([
            'title'                  => 'required',
            'description'            => 'required',
            'image'                  => 'nullable|image',
            'start_date'             => 'nullable|date',
            'end_date'               => 'nullable|date|after_or_equal:start_date',
            'registration_deadline'  => 'nullable|date',
            'location'               => 'nullable|string',
            'is_registration_active' => 'nullable|boolean',
            'registration_fields'    => 'nullable|array',
            'registration_fee'       => 'nullable|numeric',
            'sponsor_ids'            => 'nullable|array',
            'sponsor_ids.*'          => 'exists:sponsors,id',
        ]);

        $data = $request->except('sponsor_ids');
        $data['is_registration_active'] = $request->has('is_registration_active');
        $data['slug'] = Str::slug($request->title);

        if (isset($data['registration_fields']) && is_array($data['registration_fields'])) {
            foreach ($data['registration_fields'] as &$field) {
                $field['required'] = isset($field['required']) ? (bool) $field['required'] : false;
            }
        }

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($program->image && file_exists(public_path('programe/' . $program->image))) {
                unlink(public_path('programe/' . $program->image));
            }
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('programe'), $imageName);
            $data['image'] = $imageName;
        }

        $program->update($data);

        if ($request->has('sponsor_ids')) {
            $program->sponsors()->sync($request->sponsor_ids);
        } else {
            $program->sponsors()->sync([]);
        }

        return redirect()->route('admin.programs.index')->with('success', 'Program updated successfully.');
    }

    public function destroy(Program $program) {
        if ($program->image && file_exists(public_path('programe/' . $program->image))) {
            unlink(public_path('programe/' . $program->image));
        }
        $program->delete();

        return redirect()->route('admin.programs.index')->with('success', 'Program deleted successfully.');
    }

    public function registrations(Program $program, Request $request) {
        $search = $request->query('search');
        $registrations = $program->registrations()
            ->with('user')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('registration_data', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($uq) use ($search) {
                            $uq->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(20)
            ->appends(['search' => $search]);

        return view('admin.programs.registrations', compact('program', 'registrations'));
    }

    public function updateRegistrationStatus(Request $request, ProgramRegistration $registration) {
        $request->validate([
            'status' => 'required|in:pending,accept,reject',
        ]);

        $oldStatus = $registration->status;
        $registration->update(['status' => $request->status]);

        // Auto-Earn Logic
        $feeCategory = \App\Models\AccountCategory::where('name', 'Program Registration Fee')->first();
        
        if ($feeCategory) {
            if ($request->status === 'accept') {
                // Create or Update Income Transaction
                \App\Models\Transaction::updateOrCreate(
                    [
                        'reference_id'   => $registration->id,
                        'reference_type' => 'program_registration',
                    ],
                    [
                        'account_category_id' => $feeCategory->id,
                        'amount'              => $registration->program->registration_fee ?? 0,
                        'type'                => 'income',
                        'date'                => now(),
                        'description'         => "Registration Fee for {$registration->program->title} - ID: {$registration->formatted_id}",
                    ]
                );
            } elseif ($oldStatus === 'accept' && $request->status !== 'accept') {
                // If it was accepted but now it's not, remove the income record
                \App\Models\Transaction::where('reference_id', $registration->id)
                    ->where('reference_type', 'program_registration')
                    ->delete();
            }
        }

        return back()->with('success', 'Registration status updated and finance records adjusted.');
    }

    public function exportRegistrations(Program $program) {
        $registrations = $program->registrations()->with('user')->get();

        if ($registrations->isEmpty()) {
            return back()->with('error', 'No registrations to export.');
        }

        // Collect all unique keys from registration_data
        $allKeys = [];
        foreach ($registrations as $reg) {
            if (is_array($reg->registration_data)) {
                foreach (array_keys($reg->registration_data) as $key) {
                    if (!in_array($key, $allKeys)) {
                        $allKeys[] = $key;
                    }
                }
            }
        }

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"registrations_{$program->slug}.csv\"",
        ];

        $callback = function () use ($registrations, $allKeys) {
            $file = fopen('php://output', 'w');

            // Header row
            $headerRow = ['User Name', 'User Email', 'Status', 'Date'];
            foreach ($allKeys as $key) {
                $headerRow[] = ucfirst(str_replace('_', ' ', $key));
            }
            fputcsv($file, $headerRow);

            // Data rows
            foreach ($registrations as $reg) {
                $row = [
                    $reg->user->name ?? 'Guest',
                    $reg->user->email ?? 'N/A',
                    ucfirst($reg->status),
                    $reg->created_at->format('Y-m-d H:i:s'),
                ];

                foreach ($allKeys as $key) {
                    $row[] = $reg->registration_data[$key] ?? '';
                }

                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function showRegistration(ProgramRegistration $registration) {
        $registration->load(['user', 'program']);
        return view('admin.programs.registration-show', compact('registration'));
    }
}
