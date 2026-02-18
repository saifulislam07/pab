<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller {
    public function index(Request $request) {
        $search = $request->query('search');
        $roles = \Spatie\Permission\Models\Role::with('permissions')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('admin.roles.index', compact('roles'));
    }

    public function create() {
        $permissions = \Spatie\Permission\Models\Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request) {
        $request->validate([
            'name'        => 'required|unique:roles,name',
            'permissions' => 'array',
        ]);

        $role = \Spatie\Permission\Models\Role::create(['name' => $request->name]);
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(\Spatie\Permission\Models\Role $role) {
        $permissions = \Spatie\Permission\Models\Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, \Spatie\Permission\Models\Role $role) {
        $request->validate([
            'name'        => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'array',
        ]);

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(\Spatie\Permission\Models\Role $role) {
        if ($role->name === 'admin' || $role->name === 'member') {
            return redirect()->back()->with('error', 'Cannot delete system roles.');
        }
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }
}
