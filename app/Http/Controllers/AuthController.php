<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

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

        /*
        if (!Auth::attempt([
            fn (Builder $query) => $query->where('username', $request->user_email)->orWhere('password', $request->password)
        ]))
            return redirect()->back()->with('error', 'Username or Password is Wrong!');

        return redirect('/admin/dashboard');
        */

        if($admin && Hash::check($request->password, $admin->password)) {
            $token = $admin->createToken('auth_token')->plainTextToken;
            return redirect('/admin/dashboard');
        }
        return redirect()->back()->with('error', 'Username or Password is Wrong!'); 
    }

    /*
    public function logout(Request $request) {
        if($request->id !== Auth::user()?->id) {
            return abort(401);
        }
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
    */
    public function logout(Request $request) {
        $request->user()->tokens()->delete();
        return redirect('/');
    }
}
