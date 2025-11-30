<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('permissions.index', compact('permissions'));
    }

    public function store(Request $request)
    {
        Permission::create(['name' => $request->name]);
        return redirect()->route('permissions.index')->with('success', 'Permission berhasil ditambahkan');
    }

    public function update(Request $request, Permission $permission)
    {
        $permission->update(['name' => $request->name]);
        return redirect()->route('permissions.index')->with('success', 'Permission berhasil diupdate');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission berhasil dihapus');
    }
}
