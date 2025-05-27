<?php
// app/Http/Controllers/RoleController.php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy(function($permission) {
            return explode('_', $permission->name)[1];
        });

        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $role = Role::create($request->only('name', 'display_name', 'description'));
        $role->permissions()->sync($request->permissions);
        return redirect()->route('roles.index');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all()->groupBy(function($permission) {
            return explode('_', $permission->name)[1]; // Assuming permission names are in the format 'action_model'
        });

        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update($request->only('name', 'display_name', 'description'));
        $role->permissions()->sync($request->permissions);
        return redirect()->route('roles.index');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index');
    }
}
