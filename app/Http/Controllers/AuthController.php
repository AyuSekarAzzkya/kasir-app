<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginAuth(Request $request)
    {
        $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        $credentials = $request->only(['email', 'password']);
        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard.index');
            }

            if ($user->role === 'cashier') {
                return redirect()->route('transaction.index');
            }

            return abort(403, 'Role tidak dikenali, akses ditolak.');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('logout', 'Anda telah logout !');
    }
}
