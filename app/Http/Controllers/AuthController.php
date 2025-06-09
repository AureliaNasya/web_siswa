<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginForm() {
        return view('auth.login');
    }

    public function auth(Request $request) {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $username = $request->username;
        $password = $request->password;

        $admin = AdminModel::where('username', $username)->first();

        if($admin && Hash::check($password, $admin->password)) {
            Auth::login($admin);
            return redirect('/admin/dashboard');
        }

        return redirect()->back()->with('error', 'Username atau Password salah');
    }

    public function logout(Request $request) {
        if($request->id !== Auth::user()?->id) {
            return abort(401);
        }
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
