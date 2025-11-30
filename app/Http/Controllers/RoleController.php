<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get(); 
        $permissions = Permission::all();
        return view('roles.index', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $role = Role::create(['name' => $request->name]);
        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        }
        return redirect()->route('roles.index')->with('success', 'Role berhasil ditambahkan');
    }

    public function update(Request $request, Role $role)
    {
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);
        return redirect()->route('roles.index')->with('success', 'Role berhasil diupdate');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus');
    }
}
