<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller {
    public function index(Request $request) {
        $search = $request->query('search');
        $users = \App\Models\User::with('roles')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->paginate(15)
            ->appends(['search' => $search]);

        $roles = \Spatie\Permission\Models\Role::all();
        return view('admin.users.index', compact('users', 'roles'));
    }

    public function update(Request $request, \App\Models\User $user) {
        $request->validate([
            'roles' => 'required|array',
        ]);

        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot change your own roles.');
        }

        $user->syncRoles($request->roles);

        return redirect()->back()->with('success', 'User roles updated successfully.');
    }

    public function destroy(\App\Models\User $user) {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete yourself.');
        }

        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    public function bulkDestroy(Request $request) {
        $ids = json_decode($request->ids);
        if (! $ids || ! is_array($ids)) {
            return redirect()->back()->with('error', 'No users selected.');
        }

        $users = \App\Models\User::whereIn('id', $ids)->get();
        $deletedCount = 0;
        $skippedCount = 0;

        foreach ($users as $user) {
            if ($user->id === auth()->id()) {
                $skippedCount++;
                continue;
            }
            $user->delete();
            $deletedCount++;
        }

        $message = "{$deletedCount} users deleted successfully.";
        if ($skippedCount > 0) {
            $message .= " Your own account was skipped.";
        }

        return redirect()->back()->with($skippedCount > 0 ? 'warning' : 'success', $message);
    }
}
