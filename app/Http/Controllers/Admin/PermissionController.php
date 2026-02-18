<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionController extends Controller {
    public function index(Request $request) {
        $search = $request->query('search');
        $permissions = \Spatie\Permission\Models\Permission::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%");
        })
            ->latest()
            ->paginate(20)
            ->appends(['search' => $search]);

        return view('admin.permissions.index', compact('permissions'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        \Spatie\Permission\Models\Permission::create(['name' => $request->name]);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission created successfully.');
    }

    public function destroy(\Spatie\Permission\Models\Permission $permission) {
        $permission->delete();
        return redirect()->route('admin.permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
