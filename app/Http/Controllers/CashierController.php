<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class CashierController extends Controller
{
    public function index()
    {
        $cashiers = User::role('cashier')->get();
        return view('admin.user.index', compact('cashiers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4'
        ]);

        $cashier = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $cashier->assignRole('cashier'); 
        return back()->with('success', 'Kasir berhasil ditambahkan');
    }
}
