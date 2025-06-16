<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthAPI extends Controller
{
    public function login(Request $request) {
        $request -> validate([
            'username' => ['required', 'string'],
            'password' => ['requied', 'string']
        ]);

        $admin = AdminModel::where('username', $request->username)->first();
        if(!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json([
                'message' => 'Username atau Password Salah'
            ], 422);
        }
        $token = $admin->createToken('main')->plainTextToken;
        return response()->json([
            'user' => $admin,
            'token' => $token
        ]);
    
    }

    public function logout(Request $request) {
        $admin = $request->user();
        $admin->currentAccessToken()->delete();
        return redirect('/login');
    }
    /*
    public function auth(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string'],
            'password' => ['required', 'string']
        ]);

        if($validator->fails()) return $this->responseError([
            'message' => $validator->errors()->all()
        ]);
        $validatedData = $validator->valid();
        $authenticated = Auth::attempt([
            fn(Builder $query) => $query->where('username', $validatedData['username'])
            ->orWhere('password', $validatedData['password'])
        ]);

        if(!$authenticated) return $this->responseError('Username atau Password salah');
        $admin = AdminModel::find(Auth::user()->id_adm);
        $token = $admin->createToken(Auth::user()->nama_adm);
        return $this->responseSuccess([
            'id_adm' => Auth::user()->id_adm,
            'nama_adm' => Auth::user()->nama_adm,
            'username' => Auth::user()->username,
            'password' => Auth::user()->password,
            'token_type' => 'Bearer',
            'token' => $token->planTextToken
        ]);
    }
    */
}
